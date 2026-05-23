<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.about_title') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Interactive Profile Offset Border Styles */
        .profile-wrapper {
            position: relative;
            width: 100%;
            max-width: 380px;
            aspect-ratio: 1 / 1;
        }

        /* Clean, thin outer ring that pops out on hover */
        .profile-ring-outer {
            position: absolute;
            inset: 0;
            border: 2px solid var(--color-primary);
            border-radius: 50%;
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 0;
            pointer-events: none;
        }

        /* The main photo container card */
        .profile-photo-container {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 8px solid #ffffff;
            box-shadow: 0 4px 20px -4px rgba(45, 58, 45, 0.12);
            overflow: hidden;
            z-index: 10;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Interactive states on hover */
        .profile-wrapper:hover .profile-ring-outer {
            inset: -10px;
            /* expands outward */
            opacity: 1;
            transform: scale(1);
        }

        .profile-wrapper:hover .profile-photo-container {
            transform: scale(0.98);
            /* slight press effect */
            box-shadow: 0 10px 30px -10px rgba(45, 58, 45, 0.2);
        }
    </style>
</head>

<body class="bg-[var(--color-bg-base)] text-[var(--color-charcoal)] min-h-screen flex flex-col justify-between">

    <!-- Top Navbar -->
    <nav
        class="w-full py-6 sticky top-0 z-50 bg-[var(--color-bg-base)]/80 backdrop-blur-md border-b border-[var(--color-border-soft)]">
        <div class="container-boxed flex items-center justify-between">
            <!-- Logo -->
            <a href="/" id="navbar-logo" class="flex items-center gap-2 group">
                <div
                    class="w-9 h-9 bg-[var(--color-primary)] rounded-lg flex items-center justify-center text-white font-bold text-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-md group-hover:shadow-[var(--color-primary)]/20">
                    V
                </div>
                <span
                    class="font-bold text-xl tracking-tight text-[var(--color-charcoal)] transition-colors duration-300 group-hover:text-[var(--color-primary)]">Veltrix<span
                        class="text-[var(--color-primary-light)] transition-colors duration-300 group-hover:text-[var(--color-primary)]">CRM</span></span>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-12">
                <a href="/#features"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.features') }}</a>
                <a href="/#contact"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.contact_us') }}</a>
                <a href="{{ route('about') }}"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.about') }}</a>
                <a href="{{ route('pricing') }}"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.pricing') }}</a>
            </div>

            <!-- CTA -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-6">
                    <!-- Language Dropdown -->
                    <div class="relative group" id="lang-dropdown-wrapper">
                        <button id="lang-dropdown-btn"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-[var(--color-border-soft)] rounded-full text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] hover:border-[var(--color-primary)] transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5 text-[var(--color-primary)]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                </path>
                            </svg>
                            <span>{{ app()->getLocale() == 'en' ? 'English' : (app()->getLocale() == 'te' ? 'తెలుగు' : (app()->getLocale() == 'hi' ? 'हिंदी' : 'ਪੰਜਾਬੀ')) }}</span>
                            <svg class="w-3 h-3 opacity-40 group-hover:rotate-180 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="lang-menu"
                            class="absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all duration-500 delay-150 ease-out z-[70] overflow-hidden group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto group-hover:delay-0 group-hover:duration-300">
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">English</a>
                            <a href="{{ route('lang.switch', 'te') }}"
                                class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">తెలుగు</a>
                            <a href="{{ route('lang.switch', 'hi') }}"
                                class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">हिंदी</a>
                            <a href="{{ route('lang.switch', 'pa') }}"
                                class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">ਪੰਜਾਬੀ</a>
                        </div>
                    </div>

                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}"
                            class="btn-primary-veltrix !py-2.5 !px-6 text-xs font-bold uppercase tracking-widest">
                            {{ __('messages.dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-charcoal)] transition-colors">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}"
                            class="btn-primary-veltrix !py-2.5 !px-6 text-xs font-bold uppercase tracking-widest">
                            {{ __('messages.get_started') }}
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-[var(--color-charcoal)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu"
            class="fixed inset-0 bg-white z-[60] flex flex-col items-center justify-center gap-8 translate-x-full transition-transform duration-500 md:hidden">
            <button id="close-menu-btn" class="absolute top-8 right-8 p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <a href="/#features"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.features') }}</a>
            <a href="/#contact"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.contact_us') }}</a>
            <a href="{{ route('about') }}"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.about') }}</a>
            <a href="{{ route('pricing') }}"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.pricing') }}</a>
            <div class="pt-8 flex flex-col gap-4 w-full px-12">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}"
                        class="btn-primary-veltrix w-full text-center !py-5">{{ __('messages.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}"
                        class="btn-secondary-veltrix w-full text-center !py-5">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}"
                        class="btn-primary-veltrix w-full text-center !py-5">{{ __('messages.get_started') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content Flow -->
    <main class="flex-grow">

        <!-- SECTION 1: About Me (Founder & CEO) -->
        <section class="py-20 lg:py-28 overflow-hidden bg-gradient-to-b from-[var(--color-bg-base)] to-[#F5F3EF]/30">
            <div class="container-boxed">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                    <!-- Left Column: Biography & Vision -->
                    <div class="lg:col-span-7 space-y-8 animate-founder-left">
                        <div
                            class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-white border border-[var(--color-border-soft)] text-[var(--color-primary)] font-bold text-[10px] tracking-[0.2em] uppercase shadow-sm">
                            {{ __('messages.about_team_1_role') }}
                        </div>

                        @php
                            $fullName = __('messages.about_team_1_name');
                            $parts = explode(' ', $fullName);
                            $lastWord = array_pop($parts);
                            $firstPart = implode(' ', $parts);
                        @endphp
                        <a href="https://balaji-sri-ram.github.io/Portfolio/" target="_blank" rel="noopener noreferrer"
                            class="inline-block">
                            <h1 class="heading-editorial text-4xl lg:text-6xl text-[var(--color-charcoal)]">
                                {{ $firstPart }} <span
                                    class="text-[var(--color-primary)] font-extrabold">{{ $lastWord }}</span>
                            </h1>
                        </a>

                        <p class="text-base lg:text-lg text-muted-veltrix leading-relaxed max-w-2xl">
                            {{ __('messages.about_team_1_bio') }}
                        </p>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <!-- LinkedIn Social Link Link -->
                            <a href="https://www.linkedin.com/in/balaji-sri-ram-parasa" target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-2.5 py-2.5 px-5 rounded-full font-bold text-xs uppercase tracking-widest bg-white border border-[rgba(26,26,26,0.15)] text-[var(--color-graphite)] transition-all duration-300 active:scale-95 hover:bg-blue-500/[0.03] hover:border-blue-300 hover:text-blue-600 hover:-translate-y-0.5 shadow-sm hover:shadow-blue-500/5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                    </path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                                LinkedIn
                            </a>

                            <!-- GitHub Link -->
                            <a href="https://github.com/Balaji-Sri-Ram" target="_blank" rel="noopener noreferrer"
                                class="flex items-center gap-2.5 py-2.5 px-5 rounded-full font-bold text-xs uppercase tracking-widest bg-white border border-[rgba(26,26,26,0.15)] text-[var(--color-graphite)] transition-all duration-300 active:scale-95 hover:bg-zinc-500/[0.03] hover:border-zinc-400 hover:text-black hover:-translate-y-0.5 shadow-sm hover:shadow-black/5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                    </path>
                                </svg>
                                GitHub
                            </a>

                            <!-- Twitter Link -->
                            <a href="https://x.com/PawanKalyan?lang=en" target="_blank" rel="noopener noreferrer"
                                class="flex items-center gap-2.5 py-2.5 px-5 rounded-full font-bold text-xs uppercase tracking-widest bg-white border border-[rgba(26,26,26,0.15)] text-[var(--color-graphite)] transition-all duration-300 active:scale-95 hover:bg-zinc-500/[0.03] hover:border-zinc-400 hover:text-black hover:-translate-y-0.5 shadow-sm hover:shadow-black/5">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                                    </path>
                                </svg>
                                Twitter
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Profile Image with Circular Background Ring -->
                    <div class="lg:col-span-5 flex justify-center animate-founder-right">
                        <a href="https://balaji-sri-ram.github.io/Portfolio/" target="_blank" rel="noopener noreferrer"
                            class="profile-wrapper group block">

                            <!-- Outer Offset Ring -->
                            <div class="profile-ring-outer"></div>

                            <!-- Circular Framed Image Container -->
                            <div class="profile-photo-container">
                                <img src="/images/my_image.png" alt="{{ __('messages.about_team_1_name') }}"
                                    class="w-full h-full object-cover scale-102 group-hover:scale-108 transition-transform duration-700"
                                    style="object-position: 75% center;">
                            </div>

                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 2: About Company & Short Journey -->
        <section class="py-20 lg:py-28 border-t border-[var(--color-border-soft)] bg-[var(--color-bg-card)]">
            <div class="container-boxed">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                    <!-- Left: Company Mission & Pillars -->
                    <div class="lg:col-span-5 space-y-8">
                        <div class="space-y-4">
                            <span
                                class="text-[10px] font-bold uppercase tracking-[0.2em] text-[var(--color-accent)]">{{ __('messages.about_subtitle') }}</span>
                            <h2 class="heading-editorial text-3xl lg:text-4xl text-[var(--color-charcoal)]">
                                {{ __('messages.about_mission_title') }}
                            </h2>
                            <p class="text-base text-muted-veltrix leading-relaxed">
                                {{ __('messages.about_desc') }}
                            </p>
                        </div>

                        <!-- Core Pillars Checklist -->
                        <div class="space-y-8 pt-4 border-t border-[var(--color-border-soft)]">
                            <div class="flex gap-4">
                                <div
                                    class="w-5 h-5 rounded-full bg-[var(--color-primary)]/10 text-[var(--color-primary)] flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-xs uppercase tracking-widest text-[var(--color-charcoal)]">
                                        {{ __('messages.about_value_1_title') }}
                                    </h4>
                                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.about_value_1_desc') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-5 h-5 rounded-full bg-[var(--color-primary)]/10 text-[var(--color-primary)] flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-xs uppercase tracking-widest text-[var(--color-charcoal)]">
                                        {{ __('messages.about_value_2_title') }}
                                    </h4>
                                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.about_value_2_desc') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-5 h-5 rounded-full bg-[var(--color-primary)]/10 text-[var(--color-primary)] flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-xs uppercase tracking-widest text-[var(--color-charcoal)]">
                                        {{ __('messages.about_value_3_title') }}
                                    </h4>
                                    <p class="text-xs text-muted-veltrix mt-1">{{ __('messages.about_value_3_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Short Journey Timeline -->
                    <div class="lg:col-span-7 space-y-12 pl-4 lg:pl-12 border-l border-[var(--color-border-soft)]">
                        <div class="space-y-2">
                            <span
                                class="text-[10px] font-bold uppercase tracking-[0.2em] text-[var(--color-primary)]">{{ __('messages.about_timeline_title') }}</span>
                            <h2 class="heading-editorial text-3xl lg:text-4xl text-[var(--color-charcoal)]">The Journey
                                Timeline</h2>
                        </div>

                        <div
                            class="space-y-12 relative before:absolute before:left-3 before:top-4 before:bottom-4 before:w-0.5 before:bg-[var(--color-border-soft)]">

                            <!-- Timeline Track 1 -->
                            <div class="timeline-block relative pl-10 group">
                                <div
                                    class="absolute left-[7px] top-2.5 w-2.5 h-2.5 rounded-full bg-slate-300 border-2 border-white group-hover:bg-[var(--color-primary)] group-hover:scale-125 transition-all duration-300">
                                </div>
                                <div class="text-xs font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">
                                    {{ __('messages.about_timeline_1_year') }}
                                </div>
                                <h3 class="heading-editorial text-xl text-[var(--color-charcoal)] mb-2">
                                    {{ __('messages.about_timeline_1_title') }}
                                </h3>
                                <p class="text-sm text-muted-veltrix leading-relaxed">
                                    {{ __('messages.about_timeline_1_desc') }}
                                </p>
                            </div>

                            <!-- Timeline Track 2 -->
                            <div class="timeline-block relative pl-10 group">
                                <div
                                    class="absolute left-[7px] top-2.5 w-2.5 h-2.5 rounded-full bg-slate-300 border-2 border-white group-hover:bg-[var(--color-primary)] group-hover:scale-125 transition-all duration-300">
                                </div>
                                <div class="text-xs font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">
                                    {{ __('messages.about_timeline_2_year') }}
                                </div>
                                <h3 class="heading-editorial text-xl text-[var(--color-charcoal)] mb-2">
                                    {{ __('messages.about_timeline_2_title') }}
                                </h3>
                                <p class="text-sm text-muted-veltrix leading-relaxed">
                                    {{ __('messages.about_timeline_2_desc') }}
                                </p>
                            </div>

                            <!-- Timeline Track 3 -->
                            <div class="timeline-block relative pl-10 group">
                                <div
                                    class="absolute left-[7px] top-2.5 w-2.5 h-2.5 rounded-full bg-slate-300 border-2 border-white group-hover:bg-[var(--color-primary)] group-hover:scale-125 transition-all duration-300">
                                </div>
                                <div class="text-xs font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">
                                    {{ __('messages.about_timeline_3_year') }}
                                </div>
                                <h3 class="heading-editorial text-xl text-[var(--color-charcoal)] mb-2">
                                    {{ __('messages.about_timeline_3_title') }}
                                </h3>
                                <p class="text-sm text-muted-veltrix leading-relaxed">
                                    {{ __('messages.about_timeline_3_desc') }}
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="py-12 border-t border-[var(--color-border-soft)] bg-[var(--color-bg-base)]">
        <div class="container-boxed flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-[var(--color-primary)] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                    V</div>
                <span class="font-bold text-lg text-[var(--color-charcoal)]">VeltrixCRM</span>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-muted-veltrix">
                {{ __('messages.footer_rights') }}
            </p>
            <div class="flex gap-4">
                <!-- Instagram Link -->
                <a href="https://www.instagram.com/ramu__parasa/" target="_blank" rel="noopener noreferrer"
                    class="group flex items-center justify-center w-8 h-8 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-pink-300/40 hover:bg-pink-500/[0.03] rounded-full text-muted-veltrix hover:text-pink-600 transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </a>

                <!-- GitHub Link -->
                <a href="https://github.com/Balaji-Sri-Ram/VeltrixCRM" target="_blank" rel="noopener noreferrer"
                    class="group flex items-center justify-center w-8 h-8 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-zinc-400/40 hover:bg-zinc-500/[0.03] rounded-full text-muted-veltrix hover:text-zinc-800 transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                        </path>
                    </svg>
                </a>

                <!-- LinkedIn Link -->
                <a href="https://www.linkedin.com/in/balaji-sri-ram-parasa" target="_blank" rel="noopener noreferrer"
                    class="group flex items-center justify-center w-8 h-8 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-blue-300/40 hover:bg-blue-500/[0.03] rounded-full text-muted-veltrix hover:text-blue-600 transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Logic
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link');

            const toggleMenu = (show) => {
                if (show) {
                    mobileMenu.classList.remove('translate-x-full');
                } else {
                    mobileMenu.classList.add('translate-x-full');
                }
            };

            mobileMenuBtn?.addEventListener('click', () => toggleMenu(true));
            closeMenuBtn?.addEventListener('click', () => toggleMenu(false));
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => toggleMenu(false));
            });

            // Smooth animations reveal
            gsap.from('.animate-founder-left', {
                x: -50,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out'
            });

            gsap.from('.animate-founder-right', {
                x: 50,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out',
                delay: 0.2
            });

            // GSAP ScrollTrigger for Timeline Blocks
            const timelineBlocks = gsap.utils.toArray('.timeline-block');
            timelineBlocks.forEach((block, index) => {
                const dot = block.querySelector('.absolute');

                // Premium smooth fade-up for each timeline block
                gsap.from(block, {
                    scrollTrigger: {
                        trigger: block,
                        start: 'top 90%',
                        toggleActions: 'play none none reverse'
                    },
                    y: 50,
                    opacity: 0,
                    duration: 1.2,
                    ease: 'power3.out',
                    delay: index * 0.1
                });

                if (dot) {
                    gsap.fromTo(dot,
                        { scale: 0, opacity: 0 },
                        {
                            scrollTrigger: {
                                trigger: block,
                                start: 'top 90%',
                                toggleActions: 'play none none reverse'
                            },
                            scale: 1,
                            opacity: 1,
                            duration: 0.8,
                            ease: 'elastic.out(1, 0.5)',
                            delay: index * 0.1 + 0.2
                        }
                    );
                }
            });
        });
    </script>
</body>

</html>
