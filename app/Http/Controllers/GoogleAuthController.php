<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(Request $request)
    {
        // Capture selected role and set action if initiating from the registration page
        if ($request->has('role') && in_array($request->role, ['admin', 'staff'])) {
            session()->put('oauth_register_role', $request->role);
            session()->put('oauth_action', 'register');
        } else {
            session()->forget('oauth_register_role');
            session()->put('oauth_action', 'login');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate them.
     */
    public function handleGoogleCallback()
    {
        try {
            $driver = Socialite::driver('google');
            
            // Disable SSL verification in local environments (highly common for Windows PHP/cURL setups)
            if (app()->environment('local')) {
                $driver->setHttpClient(new \GuzzleHttp\Client([
                    'verify' => false,
                ]));
                // Use stateless to bypass state verification issues in local environment (domain/session mismatch)
                $driver->stateless();
            }

            $googleUser = $driver->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication failed. Please try again. Error: ' . $e->getMessage(),
            ]);
        }

        $email = $googleUser->getEmail();
        $googleId = $googleUser->getId();

        if (!$email) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google did not return an email address. Please make sure your Google profile has a public email address.',
            ]);
        }

        // Determine action based on session
        $action = session()->pull('oauth_action', 'login');
        $role = session()->pull('oauth_register_role', 'staff');

        // Check if user already exists (either by google_id or email)
        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if ($action === 'register') {
            if ($user) {
                // Enforce restriction: account already exists
                return redirect()->route('register')->withErrors([
                    'email' => 'The account already exists.',
                ]);
            }

            // Store Google user details in session for the onboarding completion step
            session()->put('oauth_google_user', [
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $email,
                'google_id' => $googleId,
                'google_token' => $googleUser->token,
                'avatar' => $googleUser->getAvatar(),
            ]);

            return redirect()->route('register.google.complete');
        } else {
            // Action is login
            if (!$user) {
                // Enforce restriction: account not found
                return redirect()->route('login')->withErrors([
                    'email' => 'Account not found. Please register first.',
                ]);
            }

            // Update token and avatar in case they changed
            $user->update([
                'google_id' => $googleId,
                'google_token' => $googleUser->token,
                'avatar' => $googleUser->getAvatar(),
            ]);
            $isNewUser = false;
        }

        // Authenticate the user
        Auth::login($user);

        // Record Activity Log
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $isNewUser ? 'Google Registration' : 'Google Login',
            'description' => $isNewUser 
                ? 'User successfully registered via Google OAuth as ' . $user->role . '.' 
                : 'User successfully logged in via Google OAuth.',
        ]);

        // Regenerate Session ID to prevent session fixation attacks
        request()->session()->regenerate();

        // Redirect to their designated dashboard
        if ($user->role === 'admin') {
            return redirect()->intended('admin/dashboard');
        }

        return redirect()->intended('staff/dashboard');
    }
}
