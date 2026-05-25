<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

// Language Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'te', 'hi', 'pa'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

// Setup Database
Route::get('/setup-database', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migrations ran successfully! You can now use the app. Please remove this route later for security.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing')->middleware('auth');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/forgot-password/send-otp', [AuthController::class, 'sendOtp'])->name('password.otp.send');
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])->name('password.reset.update');
    
    // Google OAuth Routes
    Route::get('/auth/google', [\App\Http\Controllers\GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('/register/google-complete', [AuthController::class, 'showGoogleComplete'])->name('register.google.complete');
    Route::post('/register/google-complete', [AuthController::class, 'googleCompleteStore'])->name('register.google.complete.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
    Route::get('/staff', [AdminController::class, 'staffIndex'])->name('staff');
    Route::post('/staff', [AdminController::class, 'staffStore'])->name('staff.store');
    Route::put('/staff/{user}', [AdminController::class, 'staffUpdate'])->name('staff.update');
    Route::delete('/staff/{user}', [AdminController::class, 'staffDestroy'])->name('staff.destroy');
    
    Route::get('/customers', [AdminController::class, 'customerIndex'])->name('customers');
    Route::get('/tasks', [AdminController::class, 'taskIndex'])->name('tasks');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/data', [AnalyticsController::class, 'getData'])->name('analytics.data');
    Route::get('/analytics/export', [AnalyticsController::class, 'exportCsv'])->name('analytics.export');
    Route::delete('/analytics/logs', [AnalyticsController::class, 'clearLogs'])->name('analytics.logs.clear');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/stats', [StaffController::class, 'getStats'])->name('stats');
    Route::get('/customers', [StaffController::class, 'customerIndex'])->name('customers');
    Route::get('/tasks', [StaffController::class, 'taskIndex'])->name('tasks');
    Route::get('/analytics', [StaffController::class, 'analyticsIndex'])->name('analytics');
    Route::get('/analytics/data', [StaffController::class, 'analyticsData'])->name('analytics.data');
    Route::get('/analytics/export', [StaffController::class, 'exportCsv'])->name('analytics.export');
    Route::delete('/analytics/logs', [StaffController::class, 'clearLogs'])->name('analytics.logs.clear');
});

// Shared Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::delete('/notifications/clear', [NotificationController::class, 'clearAll'])->name('notifications.clear');

    // API Routes for Modals
    Route::get('/api/customers/{customer}', function(\App\Models\Customer $customer) {
        return response()->json(array_merge($customer->toArray(), [
            'assigned_to_name' => $customer->assignedTo->name ?? 'Unassigned'
        ]));
    });

    Route::get('/api/tasks/{task}', function(\App\Models\Task $task) {
        return response()->json($task);
    });

    Route::get('/api/staff/{user}', function(\App\Models\User $user) {
        return response()->json($user);
    });

    Route::get('/lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');
});


