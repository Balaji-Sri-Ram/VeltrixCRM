<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | VeltrixCRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-gradient {
            background: linear-gradient(135deg, #FBFBF9 0%, #F5F3EF 100%);
        }
        .input-premium {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid rgba(26, 26, 26, 0.1);
            border-radius: 16px;
            padding: 18px 24px;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-charcoal);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .input-premium:focus {
            border-color: var(--color-charcoal);
            box-shadow: 0 0 0 1px rgba(26, 26, 26, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-[var(--color-bg-base)] text-[var(--color-charcoal)] antialiased overflow-x-hidden">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Left Side: Marketing/Visual -->
        <div class="hidden lg:flex lg:w-1/2 bg-[var(--color-primary)] relative items-center justify-center p-24 overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -ml-32 -mb-32"></div>
            
            <div class="relative z-10 w-full max-w-lg">
                <div class="mb-12 animate-in-left" style="opacity: 0;">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center text-white font-bold text-xl mb-8">V</div>
                    <h1 class="heading-editorial text-5xl text-white mb-6 leading-tight">Welcome Back to Smarter Customer Management.</h1>
                    <p class="text-white/70 text-lg leading-relaxed">Access your dashboard, leads, analytics, and workflows in one intelligent platform.</p>
                </div>

                <!-- Visual Element: Dashboard Cards Preview -->
                <div class="space-y-6 animate-in-up" style="opacity: 0;">
                    <div class="group bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-[32px] shadow-2xl flex items-center gap-6 hover:bg-white/10 hover:-translate-y-1 transition-all duration-500 cursor-default">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-white group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div>
                            <div class="text-white font-bold text-base mb-1 tracking-wide">Revenue Scaled</div>
                            <div class="text-white/60 text-[10px] uppercase tracking-widest font-bold">Acme Corp Deal Closed</div>
                        </div>
                        <div class="ml-auto text-white font-bold text-lg group-hover:text-emerald-400 transition-colors">+12.5%</div>
                    </div>
                    
                    <div class="group bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-[32px] shadow-2xl flex items-center gap-6 translate-x-12 hover:bg-white/10 hover:-translate-y-1 transition-all duration-500 cursor-default">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-white group-hover:scale-110 group-hover:bg-white/20 transition-all duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div class="space-y-1">
                            <div class="text-white font-bold text-base tracking-wide">New Enterprise Leads</div>
                            <div class="flex items-center gap-2 pt-1">
                                <div class="flex -space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-[var(--color-primary)] flex items-center justify-center text-[10px] font-bold text-white shadow-md group-hover:-translate-y-1 transition-transform delay-75">S</div>
                                    <div class="w-6 h-6 rounded-full bg-emerald-500 border-2 border-[var(--color-primary)] flex items-center justify-center text-[10px] font-bold text-white shadow-md group-hover:-translate-y-1 transition-transform delay-100">A</div>
                                    <div class="w-6 h-6 rounded-full bg-amber-500 border-2 border-[var(--color-primary)] flex items-center justify-center text-[10px] font-bold text-white shadow-md group-hover:-translate-y-1 transition-transform delay-150">E</div>
                                </div>
                                <span class="text-white/60 text-[10px] uppercase tracking-widest font-bold ml-1">+24 this week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-24 bg-[var(--color-bg-base)]">
            <div class="w-full max-w-md animate-in-fade" style="opacity: 0;">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl">V</div>
                </div>

                <div class="mb-10">
                    <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Login</h2>
                    <p class="text-muted-veltrix font-medium">Please enter your credentials to continue.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-600 px-5 py-4 rounded-2xl mb-8 text-sm font-medium animate-shake">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Work Email</label>
                        <input type="email" name="email" id="email" class="input-premium" placeholder="name@company.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label for="password" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">Security Password</label>
                            <a href="{{ route('password.forgot') }}" class="text-[10px] font-bold text-[var(--color-primary)] uppercase tracking-widest hover:underline opacity-60">Forgot?</a>
                        </div>
                        <input type="password" name="password" id="password" class="input-premium" placeholder="••••••••" required>
                    </div>

                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-[var(--color-border-soft)] text-[var(--color-primary)] focus:ring-[var(--color-primary)] cursor-pointer">
                        <label for="remember" class="ml-3 block text-xs font-bold text-muted-veltrix uppercase tracking-widest cursor-pointer select-none">Remember this session</label>
                    </div>

                    <button type="submit" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 hover:-translate-y-0.5 transition-all">
                        <span class="text-xs uppercase tracking-widest font-bold">Access Workspace</span>
                    </button>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-[var(--color-border-soft)]"></div></div>
                        <div class="relative flex justify-center text-xs uppercase tracking-widest font-bold"><span class="bg-[var(--color-bg-base)] px-4 text-muted-veltrix opacity-40">Or continue with</span></div>
                    </div>

                    <!-- Google Button -->
                    <a href="{{ route('auth.google') }}" class="w-full bg-white border border-[var(--color-border-soft)] text-[var(--color-charcoal)] px-8 py-4 rounded-2xl flex items-center justify-center gap-0 hover:bg-[var(--color-bg-card)] transition-all font-bold text-xs uppercase tracking-widest shadow-sm">
                        <svg class="w-5 h-5 mr-[2.5px]" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        <span>oogle</span>
                    </a>
                </form>
                
                <p class="mt-12 text-center text-xs font-bold text-muted-veltrix uppercase tracking-widest">
                    Don't have an account? <a href="{{ route('register') }}" class="text-[var(--color-primary)] hover:underline ml-2">Establish Presence</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Entrance Animations
            gsap.to(".animate-in-left", { x: 0, opacity: 1, duration: 1.2, ease: "power4.out" });
            gsap.to(".animate-in-up", { y: 0, opacity: 1, duration: 1.2, delay: 0.3, ease: "power4.out" });
            gsap.to(".animate-in-fade", { opacity: 1, duration: 1, delay: 0.5 });
            
            // Initial states
            gsap.set(".animate-in-left", { x: -30 });
            gsap.set(".animate-in-up", { y: 30 });
        });
    </script>
</body>
</html>
