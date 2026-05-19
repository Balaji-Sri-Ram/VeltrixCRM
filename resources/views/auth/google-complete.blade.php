<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Workspace Setup | VeltrixCRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .role-card, .domain-card {
            border: 1.5px solid var(--color-border-soft);
            background-color: #ffffff;
            border-radius: 16px;
            padding: 16px 20px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .role-card:hover, .domain-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px -10px rgba(45, 58, 45, 0.08);
            border-color: var(--color-charcoal);
        }
        
        .role-card.active, .domain-card.active {
            border-color: var(--color-primary);
            background-color: rgba(45, 58, 45, 0.02);
            box-shadow: 0 0 0 1.5px var(--color-primary);
        }
        
        .checkmark-icon {
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .role-card.active .checkmark-icon, .domain-card.active .checkmark-icon {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-[var(--color-bg-base)] text-[var(--color-charcoal)] antialiased overflow-x-hidden">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Left Side: Visual / Marketing (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-[var(--color-bg-card)] relative items-center justify-center p-24 overflow-hidden border-r border-[var(--color-border-soft)]">
            <!-- Background Decorative Blur -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-[var(--color-primary)]/5 rounded-full blur-3xl -ml-48 -mt-48"></div>
            
            <div class="relative z-10 w-full max-w-lg">
                <div class="mb-12 animate-in-left" style="opacity: 0;">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl mb-8 shadow-lg shadow-[var(--color-primary)]/20">V</div>
                    <div class="inline-flex items-center gap-2 bg-white/80 border border-[var(--color-border-soft)] rounded-full px-4 py-1.5 text-xs font-semibold text-[var(--color-primary)] mb-6 shadow-sm">
                        <img src="{{ $googleUser['avatar'] }}" alt="Google Avatar" class="w-5 h-5 rounded-full">
                        <span>Connected via Google OAuth</span>
                    </div>
                    <h1 class="heading-editorial text-5xl text-[var(--color-charcoal)] mb-6 leading-tight">One Step Closer to Operational Clarity.</h1>
                    <p class="text-muted-veltrix text-lg leading-relaxed">Establish your exact administrative profile and operational domain to dynamically initialize your VeltrixCRM dashboard.</p>
                </div>

                <!-- Live Identity Preview Card -->
                <div class="card-veltrix bg-white !p-8 shadow-xl border-[var(--color-border-soft)] animate-in-up" style="opacity: 0;">
                    <div class="flex items-center gap-4">
                        <img src="{{ $googleUser['avatar'] }}" alt="Avatar" class="w-16 h-16 rounded-2xl border border-[var(--color-border-soft)] object-cover shadow-sm">
                        <div>
                            <h3 class="font-bold text-lg text-[var(--color-charcoal)]">{{ $googleUser['name'] }}</h3>
                            <p class="text-sm text-muted-veltrix">{{ $googleUser['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Onboarding Completion Form -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-24 bg-[var(--color-bg-base)] py-20">
            <div class="w-full max-w-xl animate-in-fade" style="opacity: 0;">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12 flex items-center gap-4">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl">V</div>
                    <div class="inline-flex items-center gap-2 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-full px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-[var(--color-primary)] shadow-sm">
                        <img src="{{ $googleUser['avatar'] }}" alt="Avatar" class="w-4 h-4 rounded-full">
                        <span>Authorized</span>
                    </div>
                </div>

                <div class="mb-10">
                    <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Initialize Workspace</h2>
                    <p class="text-muted-veltrix font-medium">Fine-tune your identity access credentials and select your business scope.</p>
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

                <form method="POST" action="{{ route('register.google.complete.store') }}" class="space-y-10">
                    @csrf
                    
                    <!-- Role Hidden Field -->
                    <input type="hidden" name="role" id="selected-role" value="staff">
                    
                    <!-- Domain Hidden Field -->
                    <input type="hidden" name="business_type" id="selected-business-type" value="Enterprise SaaS">

                    <!-- SECTION 1: ROLE SELECTION -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">Operational Clearance</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Admin Card -->
                            <div class="role-card flex flex-col justify-between" onclick="selectRole('admin', this)">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-accent)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Admin</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Full system governance, user control, and analytical reports.</p>
                                </div>
                            </div>
                            
                            <!-- Staff Card (Active by Default) -->
                            <div class="role-card active flex flex-col justify-between" onclick="selectRole('staff', this)">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-primary)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Staff / Manager</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Pipeline actions, customer operations, and record updates.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 2: BUSINESS DOMAIN SELECTION -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">Business Domain</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Card 1: Enterprise SaaS (Active by default) -->
                            <div class="domain-card active flex flex-col justify-between h-36" onclick="selectBusinessDomain('Enterprise SaaS', this)">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-primary)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Enterprise SaaS</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Digital cloud services and subscription platforms.</p>
                                </div>
                            </div>
                            
                            <!-- Card 2: Financial Intelligence -->
                            <div class="domain-card flex flex-col justify-between h-36" onclick="selectBusinessDomain('Financial Intelligence', this)">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-accent)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Financial Intelligence</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Assets management, intelligence, and fintech platforms.</p>
                                </div>
                            </div>
                            
                            <!-- Card 3: Creative Agency -->
                            <div class="domain-card flex flex-col justify-between h-36" onclick="selectBusinessDomain('Creative Agency', this)">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-primary)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Creative Agency</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Experience design, branding, and visuals production.</p>
                                </div>
                            </div>
                            
                            <!-- Card 4: Direct Commerce -->
                            <div class="domain-card flex flex-col justify-between h-36" onclick="selectBusinessDomain('Direct Commerce', this)">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="w-10 h-10 rounded-xl bg-[var(--color-bg-base)] text-[var(--color-accent)] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    </div>
                                    <div class="checkmark-icon w-5 h-5 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[var(--color-charcoal)] mb-0.5 text-sm">Direct Commerce</h4>
                                    <p class="text-[11px] text-muted-veltrix leading-relaxed">Direct-to-consumer commerce, store sales, and logistics.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 font-bold uppercase tracking-widest text-xs">
                        Initialize Workspace
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Entrance Animations
            gsap.fromTo(".animate-in-left", { x: -30, opacity: 0 }, { x: 0, opacity: 1, duration: 1.2, ease: "power4.out" });
            gsap.fromTo(".animate-in-up", { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 1.2, delay: 0.3, ease: "power4.out" });
            gsap.fromTo(".animate-in-fade", { opacity: 0 }, { opacity: 1, duration: 1, ease: "power2.out" });
        });

        function selectRole(roleValue, element) {
            document.getElementById('selected-role').value = roleValue;
            // Remove active style from all role cards
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('active');
            });
            // Add active style to selected card
            element.classList.add('active');
            
            // Add micro-animation
            gsap.fromTo(element, { scale: 0.98 }, { scale: 1, duration: 0.3, ease: "power2.out" });
        }

        function selectBusinessDomain(domainValue, element) {
            document.getElementById('selected-business-type').value = domainValue;
            // Remove active style from all domain cards
            document.querySelectorAll('.domain-card').forEach(card => {
                card.classList.remove('active');
            });
            // Add active style to selected card
            element.classList.add('active');
            
            // Add micro-animation
            gsap.fromTo(element, { scale: 0.98 }, { scale: 1, duration: 0.3, ease: "power2.out" });
        }
    </script>
</body>
</html>
