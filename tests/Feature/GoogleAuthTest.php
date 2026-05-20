<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;
use App\Mail\WelcomeMail;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    private function mockGoogleUser($id, $email, $name)
    {
        $abstractUser = $this->createMock(SocialiteUser::class);
        $abstractUser->method('getId')->willReturn($id);
        $abstractUser->method('getEmail')->willReturn($email);
        $abstractUser->method('getName')->willReturn($name);
        $abstractUser->method('getAvatar')->willReturn('https://avatar.url');
        $abstractUser->token = 'mock-token';

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('setHttpClient')->willReturn($provider);
        $provider->method('stateless')->willReturn($provider);
        $provider->method('user')->willReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }

    public function test_redirectToGoogle_stores_register_action_and_role_in_session()
    {
        $response = $this->get(route('auth.google', ['role' => 'admin']));

        $response->assertSessionHas('oauth_register_role', 'admin');
        $response->assertSessionHas('oauth_action', 'register');
    }

    public function test_redirectToGoogle_stores_login_action_when_no_role_provided()
    {
        $response = $this->get(route('auth.google'));

        $response->assertSessionMissing('oauth_register_role');
        $response->assertSessionHas('oauth_action', 'login');
    }

    public function test_register_action_fails_if_account_already_exists()
    {
        // Arrange: Create existing user
        User::factory()->create([
            'email' => 'veltrixcrm@gmail.com',
        ]);

        $this->mockGoogleUser('google-123', 'veltrixcrm@gmail.com', 'Ramu');

        // Act: Callback with 'register' in session
        $response = $this->withSession([
            'oauth_action' => 'register',
            'oauth_register_role' => 'staff'
        ])->get(route('auth.google.callback'));

        // Assert: Redirect to register with errors
        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email' => 'The account already exists.']);
        $this->assertGuest();
    }

    public function test_register_action_redirects_to_onboarding_and_saves_profile_in_session()
    {
        $this->mockGoogleUser('google-123', 'newuser@example.com', 'New User');

        // Act: Callback with 'register' in session
        $response = $this->withSession([
            'oauth_action' => 'register',
            'oauth_register_role' => 'admin'
        ])->get(route('auth.google.callback'));

        // Assert: Redirect to onboarding page
        $response->assertRedirect(route('register.google.complete'));
        $response->assertSessionHas('oauth_google_user');
        
        $sessionData = session()->get('oauth_google_user');
        $this->assertEquals('newuser@example.com', $sessionData['email']);
        $this->assertEquals('google-123', $sessionData['google_id']);
        
        $this->assertGuest();
    }

    public function test_onboarding_page_requires_session_data()
    {
        $response = $this->get(route('register.google.complete'));
        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email' => 'Google authentication session expired. Please register again.']);
    }

    public function test_onboarding_submission_creates_user_with_role_and_business_type()
    {
        \Illuminate\Support\Facades\Mail::fake();

        $googleProfile = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'google_id' => 'google-123',
            'google_token' => 'mock-token',
            'avatar' => 'https://avatar.url',
        ];

        // Act: Submit onboarding details
        $response = $this->withSession([
            'oauth_google_user' => $googleProfile
        ])->post(route('register.google.complete.store'), [
            'role' => 'admin',
            'business_type' => 'Enterprise SaaS'
        ]);

        // Assert: Redirect to admin dashboard, authenticated
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'google_id' => 'google-123',
            'role' => 'admin',
            'business_type' => 'Enterprise SaaS'
        ]);

        \Illuminate\Support\Facades\Mail::assertSent(WelcomeMail::class, function (WelcomeMail $mail) use ($googleProfile) {
            return $mail->hasTo($googleProfile['email']);
        });
    }

    public function test_onboarding_submission_fails_if_account_already_exists()
    {
        // Create existing user first
        User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $googleProfile = [
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'google_id' => 'google-123',
            'google_token' => 'mock-token',
            'avatar' => 'https://avatar.url',
        ];

        // Act: Submit onboarding details
        $response = $this->withSession([
            'oauth_google_user' => $googleProfile
        ])->post(route('register.google.complete.store'), [
            'role' => 'staff',
            'business_type' => 'Creative Agency'
        ]);

        // Assert: Redirect to register with error
        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email' => 'The account already exists.']);
        $this->assertGuest();
    }

    public function test_login_action_fails_if_account_does_not_exist()
    {
        $this->mockGoogleUser('google-123', 'nonexistent@example.com', 'Stranger');

        // Act: Callback with 'login' in session
        $response = $this->withSession([
            'oauth_action' => 'login'
        ])->get(route('auth.google.callback'));

        // Assert: Redirect to login with errors
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email' => 'Account not found. Please register first.']);
        $this->assertGuest();
    }

    public function test_login_action_succeeds_if_account_exists()
    {
        // Arrange: Create existing user
        $user = User::factory()->create([
            'email' => 'veltrixcrm@gmail.com',
            'role' => 'staff'
        ]);

        $this->mockGoogleUser('google-123', 'veltrixcrm@gmail.com', 'Ramu');

        // Act: Callback with 'login' in session
        $response = $this->withSession([
            'oauth_action' => 'login'
        ])->get(route('auth.google.callback'));

        // Assert: Redirect to dashboard, authenticated
        $response->assertRedirect('staff/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
