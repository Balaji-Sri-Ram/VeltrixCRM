<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\WelcomeMail;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_standard_registration_creates_user_and_sends_welcome_email()
    {
        Mail::fake();

        $response = $this->post(route('register'), [
            'name' => 'Julianne Sterling',
            'email' => 'julianne@example.com',
            'password' => 'SecurePassword@123',
            'password_confirmation' => 'SecurePassword@123',
            'role' => 'admin',
            'business_type' => 'Enterprise SaaS',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Julianne Sterling',
            'email' => 'julianne@example.com',
            'role' => 'admin',
            'business_type' => 'Enterprise SaaS',
        ]);

        Mail::assertSent(WelcomeMail::class, function (WelcomeMail $mail) {
            return $mail->hasTo('julianne@example.com');
        });
    }
}
