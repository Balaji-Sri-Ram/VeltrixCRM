<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login',
                'description' => 'User logged into the system.',
            ]);

            if ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended('staff/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ], 404);
        }

        // Generate a 6-digit random OTP
        $otp = rand(100000, 999999);

        // Store OTP in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => now()
            ]
        );

        // Send Email
        try {
            Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($email) {
                $message->to($email)
                    ->subject('VeltrixCRM Security Verification Code');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to transmit OTP. Please check your SMTP credentials or network connectivity: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'A secure verification code has been transmitted to your email.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Check if user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ], 404);
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token !== $otp) {
            return response()->json([
                'success' => false,
                'message' => 'The entered OTP code is invalid.'
            ], 400);
        }

        // Check expiration (15 minutes)
        if (now()->diffInMinutes($record->created_at) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'The OTP code has expired. Please request a new code.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Identity successfully verified.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->email;
        $otp = $request->otp;
        $password = $request->password;

        // Perform final verification of OTP for security
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token !== $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Security token verification failed. Please try again.'
            ], 400);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'Security token has expired. Please try again.'
            ], 400);
        }

        // Update the user password
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ], 404);
        }

        $user->password = Hash::make($password);
        $user->save();

        // Clear the OTP
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Log this action
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Password Reset',
            'description' => 'User successfully updated their password via recovery flow.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your security credentials have been successfully updated.'
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,staff'],
            'business_type' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'business_type' => $request->business_type,
        ]);

        Auth::login($user);

        // Transmit welcome email securely without blocking flow
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            Log::warning('Welcome email delivery failed for ' . $user->email . ': ' . $e->getMessage());
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Registration',
            'description' => 'New ' . $user->role . ' registered.',
        ]);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/staff/dashboard');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Logout',
                'description' => 'User logged out.',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showGoogleComplete()
    {
        if (!session()->has('oauth_google_user')) {
            return redirect()->route('register')->withErrors([
                'email' => 'Google authentication session expired. Please register again.'
            ]);
        }

        $googleUser = session()->get('oauth_google_user');
        return view('auth.google-complete', compact('googleUser'));
    }

    public function googleCompleteStore(Request $request)
    {
        if (!session()->has('oauth_google_user')) {
            return redirect()->route('register')->withErrors([
                'email' => 'Google authentication session expired. Please register again.'
            ]);
        }

        $request->validate([
            'role' => ['required', 'in:admin,staff'],
            'business_type' => ['required', 'string', 'max:255'],
        ]);

        $googleUser = session()->get('oauth_google_user');

        // Check again to be safe
        $existingUser = User::where('email', $googleUser['email'])
            ->orWhere('google_id', $googleUser['google_id'])
            ->first();

        if ($existingUser) {
            session()->forget('oauth_google_user');
            return redirect()->route('register')->withErrors([
                'email' => 'The account already exists.',
            ]);
        }

        $user = User::create([
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'google_id' => $googleUser['google_id'],
            'google_token' => $googleUser['google_token'],
            'avatar' => $googleUser['avatar'],
            'role' => $request->role,
            'business_type' => $request->business_type,
            'password' => null,
        ]);

        Auth::login($user);

        // Transmit welcome email securely without blocking flow
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            Log::warning('Welcome email delivery failed for ' . $user->email . ': ' . $e->getMessage());
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Registration',
            'description' => 'User registered via Google OAuth as a ' . $user->role . '.',
        ]);

        session()->forget('oauth_google_user');

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/staff/dashboard');
    }
}
