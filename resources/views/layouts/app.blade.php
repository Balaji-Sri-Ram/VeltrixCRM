<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VeltrixCRM') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Light gray background */
            color: #334155; /* Dark gray text */
        }
        .clean-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-slate-50">
    
    <!-- Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 w-full px-8 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold text-blue-600">
            <a href="{{ route('home') }}">VeltrixCRM</a>
        </div>
        <div class="flex space-x-6 items-center">
            <!-- Language Switcher -->
            <select id="lang-switcher" class="bg-white border border-slate-200 text-slate-700 rounded-2xl py-2.5 px-5 focus:border-[var(--color-primary)] outline-none shadow-sm text-xs font-bold uppercase tracking-widest cursor-pointer appearance-none">
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="te" {{ app()->getLocale() == 'te' ? 'selected' : '' }}>తెలుగు</option>
                <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>हिंदी</option>
                <option value="pa" {{ app()->getLocale() == 'pa' ? 'selected' : '' }}>ਪੰਜਾਬੀ</option>
            </select>
            
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-blue-600 font-medium transition">Dashboard</a>
                @else
                    <a href="{{ route('staff.dashboard') }}" class="text-slate-600 hover:text-blue-600 font-medium transition">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">@lang('messages.logout')</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 font-medium transition">@lang('messages.login')</a>
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition font-medium">@lang('messages.register')</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow z-10">
        @yield('content')
    </main>

    <!-- Floating AI Widget -->
    <div id="ai-widget" class="fixed bottom-8 right-8 w-14 h-14 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center cursor-pointer shadow-lg hover:shadow-xl transition-all z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-slate-500 mt-auto z-10">
        &copy; {{ date('Y') }} VeltrixCRM. All rights reserved.
    </footer>

    <!-- Scripts -->
    <script>
        // Language Switcher Logic
        document.getElementById('lang-switcher').addEventListener('change', function() {
            window.location.href = '/lang/' + this.value;
        });
    </script>
</body>
</html>
