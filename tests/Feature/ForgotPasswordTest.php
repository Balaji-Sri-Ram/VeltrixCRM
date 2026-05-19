<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_sendOtp_fails_if_email_does_not_exist()
    {
        $response = $this->postJson(route('password.otp.send'), [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'User does not exist.'
        ]);
    }

    public function test_verifyOtp_fails_if_email_does_not_exist()
    {
        $response = $this->postJson(route('password.otp.verify'), [
            'email' => 'nonexistent@example.com',
            'otp' => '123456'
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'User does not exist.'
        ]);
    }

    public function test_resetPassword_fails_if_email_does_not_exist()
    {
        // Mock a token in the table so it passes token check first
        DB::table('password_reset_tokens')->insert([
            'email' => 'nonexistent@example.com',
            'token' => '123456',
            'created_at' => now()
        ]);

        $response = $this->postJson(route('password.reset.update'), [
            'email' => 'nonexistent@example.com',
            'otp' => '123456',
            'password' => 'NewPassword@123',
            'password_confirmation' => 'NewPassword@123'
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'User does not exist.'
        ]);
    }

    public function test_full_recovery_flow_succeeds_for_valid_user()
    {
        $user = User::factory()->create([
            'email' => 'ramuparasa02@gmail.com',
            'password' => bcrypt('OldPassword@123')
        ]);

        // 1. Request OTP
        $response = $this->postJson(route('password.otp.send'), [
            'email' => 'ramuparasa02@gmail.com'
        ]);
        $response->assertOk();

        $tokenRecord = DB::table('password_reset_tokens')->where('email', 'ramuparasa02@gmail.com')->first();
        $this->assertNotNull($tokenRecord);
        $otp = $tokenRecord->token;

        // 2. Verify OTP
        $response = $this->postJson(route('password.otp.verify'), [
            'email' => 'ramuparasa02@gmail.com',
            'otp' => $otp
        ]);
        $response->assertOk();

        // 3. Reset Password
        $response = $this->postJson(route('password.reset.update'), [
            'email' => 'ramuparasa02@gmail.com',
            'otp' => $otp,
            'password' => 'NewPassword@123',
            'password_confirmation' => 'NewPassword@123'
        ]);
        $response->assertOk();

        // Verify database state
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'ramuparasa02@gmail.com'
        ]);

        // Try to log in with new password
        $response = $this->post('/login', [
            'email' => 'ramuparasa02@gmail.com',
            'password' => 'NewPassword@123'
        ]);
        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }
}
