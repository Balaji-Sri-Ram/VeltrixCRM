<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Establish Presence | VeltrixCRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
        
        <!-- Left Side: Marketing/Visual (Stacked on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-[var(--color-bg-card)] relative items-center justify-center p-24 overflow-hidden border-r border-[var(--color-border-soft)]">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-[var(--color-primary)]/5 rounded-full blur-3xl -ml-48 -mt-48"></div>
            
            <div class="relative z-10 w-full max-w-lg">
                <div class="mb-12 animate-in-left" style="opacity: 0;">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl mb-8 shadow-lg shadow-[var(--color-primary)]/20">V</div>
                    <h1 class="heading-editorial text-5xl text-[var(--color-charcoal)] mb-6 leading-tight">Start Building Better Customer Relationships.</h1>
                    <p class="text-muted-veltrix text-lg leading-relaxed">Create your VeltrixCRM workspace and manage your business with a clean, intelligent CRM platform.</p>
                </div>

                <!-- Visual Element: CRM Feature Cards -->
                <div class="grid grid-cols-2 gap-6 animate-in-up" style="opacity: 0;">
                    <div class="card-veltrix bg-white !p-6 shadow-xl shadow-[var(--color-primary)]/5 border-[var(--color-border-soft)] group hover:-translate-y-2 transition-all duration-500 cursor-default">
                        <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-primary)] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[var(--color-primary)] group-hover:text-white transition-all duration-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div class="font-bold text-[var(--color-charcoal)] mb-1">Sarah Jenkins</div>
                        <div class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">Added as Manager</div>
                    </div>
                    
                    <div class="card-veltrix bg-white !p-6 shadow-xl shadow-[var(--color-accent)]/5 border-[var(--color-border-soft)] mt-8 group hover:-translate-y-2 transition-all duration-500 cursor-default">
                        <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-accent)] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[var(--color-accent)] group-hover:text-white transition-all duration-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        </div>
                        <div class="font-bold text-[var(--color-charcoal)] mb-1">Q3 Projections</div>
                        <div class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">+42% Growth Tracker</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-24 bg-[var(--color-bg-base)] py-20">
            <div class="w-full max-w-lg animate-in-fade" style="opacity: 0;">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl">V</div>
                </div>

                <div class="mb-10">
                    <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Create Workspace</h2>
                    <p class="text-muted-veltrix font-medium">Join the next generation of customer-centric businesses.</p>
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

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Identity Name</label>
                            <input type="text" name="name" id="name" class="input-premium" placeholder="Ramu Parasa" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div>
                            <label for="email" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Work Email</label>
                            <input type="email" name="email" id="email" class="input-premium" placeholder="name@company.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Secure Password</label>
                            <input type="password" name="password" id="password" class="input-premium" placeholder="••••••••" required>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Confirm Security</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="input-premium" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Custom Role Dropdown -->
                        <div class="relative text-left" id="role-dropdown-wrapper">
                            <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Account Type / Role</label>
                            <input type="hidden" name="role" id="role" value="{{ old('role', 'admin') }}">
                            
                            <button type="button" id="role-dropdown-btn" class="w-full bg-white border border-[var(--color-border-soft)] rounded-2xl px-6 py-4 flex items-center justify-between text-sm font-bold text-[var(--color-charcoal)] hover:border-[var(--color-primary)] transition-all shadow-sm">
                                <span id="role-selected-text">{{ old('role') == 'staff' ? 'Staff / Manager' : 'Admin' }}</span>
                                <svg class="w-4 h-4 opacity-40 transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Custom Dropdown Menu -->
                            <div id="role-dropdown-menu" class="absolute left-0 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all duration-300 z-[70] overflow-hidden">
                                <div data-value="admin" class="role-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Admin
                                </div>
                                <div data-value="staff" class="role-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Staff / Manager
                                </div>
                            </div>
                        </div>

                        <!-- Custom Business Domain Dropdown -->
                        <div class="relative text-left" id="business-dropdown-wrapper">
                            <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Business Domain</label>
                            <input type="hidden" name="business_type" id="business_type" value="{{ old('business_type', 'Enterprise SaaS') }}">
                            
                            <button type="button" id="business-dropdown-btn" class="w-full bg-white border border-[var(--color-border-soft)] rounded-2xl px-6 py-4 flex items-center justify-between text-sm font-bold text-[var(--color-charcoal)] hover:border-[var(--color-primary)] transition-all shadow-sm">
                                <span id="business-selected-text">{{ old('business_type', 'Enterprise SaaS') }}</span>
                                <svg class="w-4 h-4 opacity-40 transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Custom Dropdown Menu -->
                            <div id="business-dropdown-menu" class="absolute left-0 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all duration-300 z-[70] overflow-hidden">
                                <div data-value="Enterprise SaaS" class="business-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Enterprise SaaS
                                </div>
                                <div data-value="Financial Intelligence" class="business-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Financial Intelligence
                                </div>
                                <div data-value="Creative Agency" class="business-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Creative Agency
                                </div>
                                <div data-value="Direct Commerce" class="business-option flex items-center px-6 py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] cursor-pointer transition-colors border-b border-[var(--color-border-soft)] last:border-0">
                                    Direct Commerce
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 hover:-translate-y-0.5 transition-all">
                        <span class="text-xs uppercase tracking-widest font-bold">Establish Presence</span>
                    </button>

                    <!-- Divider -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-[var(--color-border-soft)]"></div></div>
                        <div class="relative flex justify-center text-xs uppercase tracking-widest font-bold"><span class="bg-[var(--color-bg-base)] px-4 text-muted-veltrix opacity-40">Or register with</span></div>
                    </div>

                    <!-- Google Button -->
                    <a id="google-register-btn" href="{{ route('auth.google', ['role' => 'admin']) }}" class="w-full bg-white border border-[var(--color-border-soft)] text-[var(--color-charcoal)] px-8 py-4 rounded-2xl flex items-center justify-center gap-0 hover:bg-[var(--color-bg-card)] transition-all font-bold text-xs uppercase tracking-widest shadow-sm">
                        <svg class="w-5 h-5 mr-[2.5px]" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        <span>oogle</span>
                    </a>
                </form>
                
                <p class="mt-12 text-center text-xs font-bold text-muted-veltrix uppercase tracking-widest">
                    Already have a presence? <a href="{{ route('login') }}" class="text-[var(--color-primary)] hover:underline ml-2">Access Workspace</a>
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

            // Setup Custom Interactive Dropdowns
            const setupDropdown = (wrapperId, btnId, menuId, textId, inputId, optionClass) => {
                const wrapper = document.getElementById(wrapperId);
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);
                const text = document.getElementById(textId);
                const input = document.getElementById(inputId);
                const options = wrapper.querySelectorAll('.' + optionClass);
                const arrow = btn.querySelector('svg');

                const openMenu = () => {
                    menu.style.transition = 'all 0.25s cubic-bezier(0.16, 1, 0.3, 1)';
                    menu.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'translate-y-0');
                    arrow.classList.add('rotate-180');
                };

                const closeMenu = () => {
                    menu.style.transition = 'all 0.75s cubic-bezier(0.16, 1, 0.3, 1)';
                    menu.classList.remove('opacity-100', 'translate-y-0');
                    menu.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                    arrow.classList.remove('rotate-180');
                };

                // Add Hover Listeners to Wrapper
                wrapper.addEventListener('mouseenter', () => {
                    openMenu();
                });

                wrapper.addEventListener('mouseleave', () => {
                    closeMenu();
                });

                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = !menu.classList.contains('pointer-events-none');
                    if (isOpen) closeMenu();
                    else openMenu();
                });

                options.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        const val = opt.getAttribute('data-value');
                        input.value = val;
                        text.textContent = opt.textContent.trim();
                        closeMenu();
                        
                        // Notify change listeners
                        input.dispatchEvent(new Event('change'));
                    });
                });

                document.addEventListener('click', (e) => {
                    if (!wrapper.contains(e.target)) {
                        closeMenu();
                    }
                });
            };

            setupDropdown('role-dropdown-wrapper', 'role-dropdown-btn', 'role-dropdown-menu', 'role-selected-text', 'role', 'role-option');
            setupDropdown('business-dropdown-wrapper', 'business-dropdown-btn', 'business-dropdown-menu', 'business-selected-text', 'business_type', 'business-option');

            // Dynamic OAuth Role Parameter Assignment
            const roleInput = document.getElementById('role');
            const googleBtn = document.getElementById('google-register-btn');
            if (roleInput && googleBtn) {
                // Initialize default href based on selected role
                googleBtn.href = `{{ route('auth.google') }}?role=${roleInput.value}`;
                
                roleInput.addEventListener('change', (e) => {
                    googleBtn.href = `{{ route('auth.google') }}?role=${e.target.value}`;
                });
            }
        });
    </script>
</body>
</html>
