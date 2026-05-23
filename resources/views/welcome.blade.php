<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeltrixCRM | Premium SaaS Customer Management</title>
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

        /* Removed unused .reveal transition to prevent layout/pinning conflicts */

        /* Success bounce animation */
        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.95);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-bounce-in {
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        /* Premium Staggered Image Grid styling */
        .hero-grid-container {
            display: grid;
            grid-template-columns: repeat(3, auto);
            gap: 1.25rem;
            position: relative;
            align-items: start;
        }

        .hero-grid-col {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* Vertical offset stagger */
        .col-1 {
            margin-top: 12.5rem;
        }

        .col-2 {
            margin-top: 6rem;
        }

        .col-3 {
            margin-top: 0;
        }

        .hero-card {
            position: relative;
            width: 130px;
            height: 195px;
            border-radius: 2.25rem;
            overflow: hidden;
            border: 1px solid var(--color-border-soft);
            box-shadow: 0 10px 30px -8px rgba(45, 58, 45, 0.08);
            background-color: var(--color-bg-card);
            will-change: transform, opacity;
            backface-visibility: hidden;
            contain: layout style paint;
            perspective: 1000px;
            /* INITIAL STATE FOR ANIMATION - PREVENTS FLASH */
            opacity: 0;
            transform: translate3d(0, 0, 0) scale(0.9);
        }

        .hero-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .hero-card:hover .hero-card-img {
            transform: scale(1.05);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-grid-container {
                gap: 1rem;
            }

            .hero-grid-col {
                gap: 1rem;
            }

            .col-1 {
                margin-top: 10rem;
            }

            .col-2 {
                margin-top: 5rem;
            }

            .hero-card {
                width: 110px;
                height: 165px;
                border-radius: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .hero-grid-container {
                gap: 0.75rem;
            }

            .hero-grid-col {
                gap: 0.75rem;
            }

            .col-1 {
                margin-top: 8rem;
            }

            .col-2 {
                margin-top: 4rem;
            }

            .hero-card {
                width: 85px;
                height: 128px;
                border-radius: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-[var(--color-bg-base)] text-[var(--color-charcoal)]">

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

            <div class="hidden md:flex items-center gap-12">
                <a href="#features"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.features') }}</a>
                <a href="#contact"
                    class="text-xs font-bold uppercase tracking-widest text-[var(--color-graphite)] hover:text-[var(--color-primary)] transition-colors">{{ __('messages.contact_us') }}</a>
                <a href="#"
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
            <a href="#features"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.features') }}</a>
            <a href="#contact"
                class="mobile-nav-link text-2xl font-bold uppercase tracking-[0.2em]">{{ __('messages.contact_us') }}</a>
            <a href="#"
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

    <main>
        <section class="pt-2 pb-24 lg:pt-4 lg:pb-32 overflow-hidden">
            <div class="container-boxed grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">

                <!-- Left Side: Copy -->
                <div class="space-y-8 animate-hero-text">
                    <div
                        class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-white border border-[var(--color-border-soft)] text-[var(--color-primary)] font-bold text-[10px] tracking-[0.2em] uppercase shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[var(--color-primary)] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[var(--color-primary)]"></span>
                        </span>
                        {{ __('messages.hero_badge') }}
                    </div>

                    <h1 class="heading-editorial text-5xl lg:text-7xl leading-[1.1]">
                        {{ __('messages.hero_heading_1') }} <span
                            class="text-[var(--color-primary)]">{{ __('messages.hero_heading_2') }}</span>
                    </h1>

                    <p class="text-lg text-muted-veltrix max-w-lg leading-relaxed">
                        {{ __('messages.hero_desc') }}
                    </p>

                    <div class="flex flex-wrap gap-5 pt-4">
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}"
                                class="btn-primary-veltrix text-xs uppercase tracking-widest px-10 !py-4">
                                {{ __('messages.get_started') }}
                            </a>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}"
                                class="btn-secondary-veltrix text-xs uppercase tracking-widest px-10 !py-4 bg-white border border-[var(--color-border-soft)]">
                                {{ __('messages.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="btn-primary-veltrix text-xs uppercase tracking-widest px-10 !py-4">
                                {{ __('messages.get_started') }}
                            </a>
                            <a href="{{ route('login') }}"
                                class="btn-secondary-veltrix text-xs uppercase tracking-widest px-10 !py-4 bg-white border border-[var(--color-border-soft)]">
                                {{ __('messages.login') }}
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Side: Staggered Premium CRM Image Grid -->
                <div class="relative animate-hero-img flex justify-center lg:justify-end items-center pt-2 pb-6">
                    <div class="hero-grid-container z-10">
                        <!-- Column 1 (Leftmost) -->
                        <div class="hero-grid-col col-1">
                            <div class="hero-card card-1">
                                <img src="/images/CRM1.jpg" alt="CRM Workspace 1" class="hero-card-img">
                            </div>
                        </div>
                        <!-- Column 2 (Middle) -->
                        <div class="hero-grid-col col-2">
                            <div class="hero-card card-2">
                                <img src="/images/CRM2.jpg" alt="CRM Workspace 2" class="hero-card-img">
                            </div>
                            <div class="hero-card card-3">
                                <img src="/images/CRM3.jpg" alt="CRM Workspace 3" class="hero-card-img">
                            </div>
                        </div>
                        <!-- Column 3 (Rightmost) -->
                        <div class="hero-grid-col col-3">
                            <div class="hero-card card-4">
                                <img src="/images/CRM4.jpg" alt="CRM Workspace 4" class="hero-card-img">
                            </div>
                            <div class="hero-card card-5">
                                <img src="/images/CRM5.jpg" alt="CRM Workspace 5" class="hero-card-img">
                            </div>
                            <div class="hero-card card-6">
                                <img src="/images/CRM6.jpg" alt="CRM Workspace 6" class="hero-card-img">
                            </div>
                        </div>
                    </div>
                    <!-- Subtle natural shadow element -->
                    <div
                        class="absolute -bottom-12 -right-12 -left-12 h-1/3 bg-gradient-to-t from-[var(--color-bg-base)] to-transparent pointer-events-none z-0">
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust Section -->
        <section class="scroll-section py-20 border-y border-[var(--color-border-soft)]">
            <div class="container-boxed">
                <p
                    class="text-center text-[10px] font-bold tracking-[0.3em] text-[var(--color-graphite)] uppercase mb-12 opacity-80">
                    {{ __('messages.trust_heading') }}</p>
                <div
                    class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60 grayscale contrast-125">
                    <span class="text-2xl font-black tracking-tighter">UMBRA</span>
                    <span class="text-2xl font-black tracking-tighter">NOVA</span>
                    <span class="text-2xl font-black tracking-tighter">KINETIC</span>
                    <span class="text-2xl font-black tracking-tighter">AETHER</span>
                    <span class="text-2xl font-black tracking-tighter">SOLAS</span>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="scroll-section min-h-[140vh] py-20 relative">
            <div class="container-boxed">
                <div class="text-center max-w-3xl mx-auto mb-12 opacity-0">
                    <h2 class="heading-editorial text-4xl lg:text-5xl mb-6">{{ __('messages.features_heading') }}</h2>
                    <p class="text-muted-veltrix text-lg">{{ __('messages.features_desc') }}</p>
                </div>

                @php
                    $features = [
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => __('messages.feature_1_title'), 'desc' => __('messages.feature_1_desc')],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => __('messages.feature_2_title'), 'desc' => __('messages.feature_2_desc')],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => __('messages.feature_3_title'), 'desc' => __('messages.feature_3_desc')],
                        ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'title' => __('messages.feature_4_title'), 'desc' => __('messages.feature_4_desc')],
                        ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z', 'title' => __('messages.feature_5_title'), 'desc' => __('messages.feature_5_desc')],
                        ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => __('messages.feature_6_title'), 'desc' => __('messages.feature_6_desc')]
                    ];
                @endphp

                <div class="relative w-full mt-16 min-h-[350px]">
                    <!-- Row 1: First Three Features -->
                    <div class="features-row-1 grid md:grid-cols-3 gap-6 w-full relative z-10 opacity-0">
                        @foreach(array_slice($features, 0, 3) as $f)
                            <div
                                class="card-veltrix hover:-translate-y-2 transition-all duration-500 group border-[var(--color-border-soft)]">
                                <div
                                    class="w-14 h-14 bg-[var(--color-bg-base)] rounded-2xl border border-[var(--color-border-soft)] flex items-center justify-center text-[var(--color-primary)] mb-6 group-hover:bg-[var(--color-primary)] group-hover:text-white transition-colors duration-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="{{ $f['icon'] }}"></path>
                                    </svg>
                                </div>
                                <h3 class="heading-editorial text-2xl mb-4">{{ $f['title'] }}</h3>
                                <p class="text-muted-veltrix text-sm leading-relaxed">{{ $f['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Row 2: Next Three Features -->
                    <div
                        class="features-row-2 grid md:grid-cols-3 gap-6 w-full absolute inset-x-0 top-0 opacity-0 pointer-events-none z-20">
                        @foreach(array_slice($features, 3, 3) as $f)
                            <div
                                class="card-veltrix hover:-translate-y-2 transition-all duration-500 group border-[var(--color-border-soft)]">
                                <div
                                    class="w-14 h-14 bg-[var(--color-bg-base)] rounded-2xl border border-[var(--color-border-soft)] flex items-center justify-center text-[var(--color-primary)] mb-6 group-hover:bg-[var(--color-primary)] group-hover:text-white transition-colors duration-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="{{ $f['icon'] }}"></path>
                                    </svg>
                                </div>
                                <h3 class="heading-editorial text-2xl mb-4">{{ $f['title'] }}</h3>
                                <p class="text-muted-veltrix text-sm leading-relaxed">{{ $f['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact"
            class="scroll-section py-32 bg-[var(--color-bg-card)] border-y border-[var(--color-border-soft)]">
            <div class="container-boxed">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <h2 class="heading-editorial text-4xl lg:text-5xl mb-6">{{ __('messages.contact_heading') }}
                        </h2>
                        <p class="text-muted-veltrix text-lg mb-10 max-w-lg">{{ __('messages.contact_desc') }}</p>

                        <div class="space-y-8">
                            <div class="flex items-start gap-5">
                                <div
                                    class="w-12 h-12 rounded-xl bg-white border border-[var(--color-border-soft)] flex items-center justify-center text-[var(--color-primary)] shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-bold uppercase tracking-widest text-[var(--color-charcoal)] mb-1">
                                        {{ __('messages.contact_email') }}</h4>
                                    <p class="text-sm text-muted-veltrix font-medium">veltrixcrm@gmail.com</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-5">
                                <div
                                    class="w-12 h-12 rounded-xl bg-white border border-[var(--color-border-soft)] flex items-center justify-center text-[var(--color-primary)] shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-bold uppercase tracking-widest text-[var(--color-charcoal)] mb-1">
                                        {{ __('messages.direct_line') }}</h4>
                                    <p class="text-sm text-muted-veltrix font-medium">+91 7207674897</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="card-veltrix bg-white !p-10 shadow-xl border-[var(--color-border-soft)] relative overflow-hidden">
                        <!-- Success Message (hidden by default) -->
                        <div id="contact-success-msg" class="hidden">
                            <div class="text-center py-8">
                                <div
                                    class="w-20 h-20 bg-emerald-50 border-2 border-emerald-200 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce-in">
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="heading-editorial text-2xl mb-3 text-[var(--color-charcoal)]">Query
                                    Transmitted Successfully</h3>
                                <p class="text-muted-veltrix text-sm max-w-sm mx-auto mb-8">Thank you for reaching out.
                                    Our team will review your inquiry and respond within 24 hours.</p>
                                <button onclick="resetContactForm()"
                                    class="btn-secondary-veltrix text-xs uppercase tracking-widest font-bold">
                                    Send Another Query
                                </button>
                            </div>
                        </div>

                        <!-- Error Message (hidden by default) -->
                        <div id="contact-error-msg"
                            class="hidden mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <span id="contact-error-text">Something went wrong. Please try again.</span>
                        </div>

                        <!-- Contact Form -->
                        <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.your_name') }}</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-4 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold"
                                        placeholder="E.g. Ramu Parasa">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.email_address') }}</label>
                                    <input type="email" name="email" required
                                        class="w-full bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-4 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-bold"
                                        placeholder="email@enterprise.com">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">{{ __('messages.message') }}</label>
                                <textarea rows="5" name="message" required
                                    class="w-full bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] rounded-2xl px-5 py-4 outline-none focus:border-[var(--color-primary)] transition-all text-sm font-medium leading-relaxed"
                                    placeholder="{{ __('messages.message_placeholder') }}"></textarea>
                            </div>
                            <button type="submit" id="contact-submit-btn" class="w-full btn-primary-veltrix !py-5">
                                <span id="contact-btn-text"
                                    class="text-xs uppercase tracking-widest font-bold">{{ __('messages.submit_query') }}</span>
                                <svg id="contact-btn-spinner" class="hidden w-5 h-5 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="scroll-section py-32 bg-[var(--color-primary)] text-white overflow-hidden relative">
            <!-- Subtle background texture -->
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                </div>
            </div>

            <div class="container-boxed text-center relative z-10">
                <h2 class="heading-editorial text-5xl lg:text-6xl mb-8 text-white">{{ __('messages.cta_heading') }}</h2>
                <p class="text-emerald-100 text-xl max-w-2xl mx-auto mb-12 font-medium opacity-80">
                    {{ __('messages.cta_desc') }}</p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ auth()->check() ? route('pricing') : route('register') }}"
                        class="inline-flex items-center justify-center bg-white text-[var(--color-primary)] hover:bg-[var(--color-bg-base)] px-12 py-5 rounded-2xl text-xs font-bold uppercase tracking-widest shadow-xl transition-all hover:-translate-y-1">
                        {{ __('messages.cta_button') }}
                    </a>
                </div>
                <p class="mt-10 text-[10px] font-bold text-emerald-200 uppercase tracking-widest opacity-60">
                    {!! __('messages.cta_subtext') !!}</p>
            </div>
        </section>
    </main>

    <footer class="py-24 border-t border-[var(--color-border-soft)]">
        <div class="container-boxed">
            <div class="grid md:grid-cols-4 gap-16 mb-20">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-8">
                        <div
                            class="w-9 h-9 bg-[var(--color-primary)] rounded-lg flex items-center justify-center text-white font-bold text-lg">
                            V</div>
                        <span class="font-bold text-2xl text-[var(--color-charcoal)]">VeltrixCRM</span>
                    </div>
                    <p class="text-muted-veltrix max-w-sm text-sm leading-relaxed">{{ __('messages.footer_desc') }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] mb-8">
                        {{ __('messages.footer_col_1') }}</h5>
                    <ul class="space-y-4 text-xs font-bold text-muted-veltrix uppercase tracking-[0.15em]">
                        <li><a href="#features"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.features') }}</a>
                        </li>
                        <li><a href="{{ route('pricing') }}"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.pricing') }}</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.enterprise') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] mb-8">
                        {{ __('messages.footer_col_2') }}</h5>
                    <ul class="space-y-4 text-xs font-bold text-muted-veltrix uppercase tracking-[0.15em]">
                        <li><a href="#"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.about') }}</a>
                        </li>
                        <li><a href="#contact"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.contact') }}</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-[var(--color-primary)] transition-colors">{{ __('messages.security') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="flex flex-col md:flex-row justify-between items-center gap-8 pt-10 border-t border-[var(--color-border-soft)]">
                <p class="text-[10px] font-bold uppercase tracking-widest text-muted-veltrix">
                    {{ __('messages.footer_rights') }}</p>
                <div class="flex flex-wrap gap-4">
                    <!-- Instagram Link -->
                    <a href="https://www.instagram.com/ramu__parasa/" target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-2 px-4 py-2 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-pink-300/40 hover:bg-pink-500/[0.03] rounded-full text-muted-veltrix hover:text-pink-600 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-[0_4px_20px_rgba(236,72,153,0.08)]">
                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Instagram</span>
                    </a>

                    <!-- GitHub Link -->
                    <a href="https://github.com/Balaji-Sri-Ram/VeltrixCRM" target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-2 px-4 py-2 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-zinc-400/40 hover:bg-zinc-500/[0.03] rounded-full text-muted-veltrix hover:text-zinc-800 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                            </path>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">GitHub</span>
                    </a>

                    <!-- LinkedIn Link -->
                    <a href="https://www.linkedin.com/in/balaji-sri-ram-parasa" target="_blank"
                        rel="noopener noreferrer"
                        class="group flex items-center gap-2 px-4 py-2 bg-[var(--color-bg-base)] border border-[var(--color-border-soft)] hover:border-blue-300/40 hover:bg-blue-500/[0.03] rounded-full text-muted-veltrix hover:text-blue-600 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-[0_4px_20px_rgba(37,99,235,0.08)]">
                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                            </path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">LinkedIn</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
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

            // Smooth Scroll for Logo handled by lenis in app.js

            // AJAX Contact Form Submission
            const contactForm = document.getElementById('contact-form');
            const contactSuccessMsg = document.getElementById('contact-success-msg');
            const contactErrorMsg = document.getElementById('contact-error-msg');
            const contactErrorText = document.getElementById('contact-error-text');
            const contactSubmitBtn = document.getElementById('contact-submit-btn');
            const contactBtnText = document.getElementById('contact-btn-text');
            const contactBtnSpinner = document.getElementById('contact-btn-spinner');

            contactForm?.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Hide previous messages
                contactErrorMsg.classList.add('hidden');

                // Show loading state
                contactSubmitBtn.disabled = true;
                contactBtnText.classList.add('hidden');
                contactBtnSpinner.classList.remove('hidden');

                const formData = new FormData(contactForm);

                try {
                    const response = await fetch(contactForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Hide form, show success
                        contactForm.classList.add('hidden');
                        contactSuccessMsg.classList.remove('hidden');
                    } else {
                        contactErrorText.textContent = data.message || 'Something went wrong. Please try again.';
                        contactErrorMsg.classList.remove('hidden');
                    }
                } catch (error) {
                    contactErrorText.textContent = 'Network error. Please check your connection and try again.';
                    contactErrorMsg.classList.remove('hidden');
                } finally {
                    // Reset button
                    contactSubmitBtn.disabled = false;
                    contactBtnText.classList.remove('hidden');
                    contactBtnSpinner.classList.add('hidden');
                }
            });
        });

        // Reset contact form to initial state
        function resetContactForm() {
            const contactForm = document.getElementById('contact-form');
            const contactSuccessMsg = document.getElementById('contact-success-msg');
            contactForm.reset();
            contactForm.classList.remove('hidden');
            contactSuccessMsg.classList.add('hidden');
        }
    </script>
</body>

</html>