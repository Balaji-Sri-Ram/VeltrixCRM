<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VeltrixCRM - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GSAP & Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--color-bg-base);
            color: var(--color-charcoal);
            overflow-x: hidden;
        }
        
        /* Chatbot UI */
        #chat-window {
            clip-path: circle(0% at bottom right);
            transition: clip-path 0.5s cubic-bezier(0.86, 0, 0.07, 1);
        }
        #chat-window.open {
            clip-path: circle(150% at bottom right);
        }
        .msg-bubble {
            max-width: 80%;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex bg-[var(--color-bg-base)] text-[var(--color-charcoal)]">
    <!-- Success Message Modal Overlay -->
    <div id="success-message-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
        <!-- Success Message Container -->
        <div id="success-message-container" class="bg-white w-full max-w-sm rounded-[32px] border border-[var(--color-border-soft)] shadow-2xl p-10 text-center transform scale-95 opacity-0 transition-all duration-500 relative">
            <button onclick="closeSuccessMessageModal()" class="absolute top-6 right-6 text-muted-veltrix hover:text-[var(--color-charcoal)] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="w-16 h-16 bg-[var(--color-bg-card)] text-[var(--color-primary)] rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="heading-editorial text-2xl mb-2">{{ __('messages.success') }}</h2>
            <p id="success-message-text" class="text-muted-veltrix text-sm">{{ __('messages.action_success') }}</p>
        </div>
    </div>

    <!-- Customer Details Modal -->
    <div id="customer-details-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
        <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-500 border border-[var(--color-border-soft)]" id="customer-modal-content">
            <div class="p-10 relative">
                <button onclick="closeCustomerModal()" class="absolute top-8 right-8 text-muted-veltrix hover:text-[var(--color-charcoal)] transition-colors p-2 bg-[var(--color-bg-card)] rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center space-x-6 mb-10">
                    <div id="modal-customer-avatar" class="w-20 h-20 rounded-3xl bg-[var(--color-primary)] text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-[var(--color-primary)]/10">
                        J
                    </div>
                    <div>
                        <h2 id="modal-customer-name" class="heading-editorial text-3xl">Customer Name</h2>
                        <div class="flex items-center space-x-3 mt-2">
                            <span id="modal-customer-status" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Active</span>
                            <span id="modal-customer-id" class="text-muted-veltrix text-xs">#ID-1001</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="bg-[var(--color-bg-card)] p-6 rounded-3xl border border-[var(--color-border-soft)]">
                        <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-4">{{ __('messages.contact_info') }}</p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-muted-veltrix border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span id="modal-customer-email" class="text-sm font-medium text-[var(--color-charcoal)]">email@example.com</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-muted-veltrix border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <span id="modal-customer-phone" class="text-sm font-medium text-[var(--color-charcoal)]">+1 234 567 890</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[var(--color-bg-card)] p-6 rounded-3xl border border-[var(--color-border-soft)]">
                        <p class="text-[10px] font-bold text-[var(--color-accent)] uppercase tracking-widest mb-4">{{ __('messages.assignment_details') }}</p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-[var(--color-accent)] border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span id="modal-customer-assigned" class="text-sm font-medium text-[var(--color-charcoal)]">Assigned Agent</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-[var(--color-accent)] border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span id="modal-customer-created" class="text-sm font-medium text-[var(--color-charcoal)]">{{ __('messages.joined_date') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 flex space-x-4">
                    <a id="modal-customer-wa" href="#" target="_blank" class="flex-1 bg-[#25D366] text-white py-4 rounded-2xl font-bold flex items-center justify-center space-x-2 shadow-lg shadow-emerald-100 hover:-translate-y-1 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.115.548 4.183 1.594 6.012L.15 23.85l5.961-1.564A11.968 11.968 0 0012.03 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 21.969c-1.844 0-3.655-.496-5.244-1.439l-.376-.223-3.89 1.02 1.04-3.79-.245-.39A9.927 9.927 0 012.03 12.03C2.03 6.516 6.516 2.03 12.031 2.03c5.515 0 10 4.486 10 10s-4.485 10-10 10zm5.495-7.514c-.301-.151-1.782-.88-2.057-.98-.276-.101-.477-.151-.678.15-.201.302-.779.98-.954 1.18-.176.202-.352.227-.653.076-1.554-.775-2.658-1.405-3.69-3.21-.101-.176.106-.164.402-.756.1-.202.05-.378-.025-.529-.075-.151-.678-1.636-.928-2.241-.244-.59-.493-.51-.678-.519-.176-.01-.378-.01-.578-.01-.201 0-.527.075-.803.377-.276.302-1.054 1.031-1.054 2.514 0 1.483 1.079 2.916 1.23 3.118.151.201 2.127 3.245 5.152 4.548 2.046.88 2.68.705 3.181.579.624-.158 1.782-.729 2.032-1.433.251-.704.251-1.308.176-1.433-.075-.126-.276-.201-.577-.352z"/></svg>
                        <span>{{ __('messages.whatsapp_dm') }}</span>
                    </a>
                    <button onclick="closeCustomerModal()" class="flex-1 btn-secondary-veltrix">
                        {{ __('messages.close_details') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Details Modal -->
    <div id="staff-details-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-[var(--color-primary)]/10 backdrop-blur-md">
        <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-500 border border-[var(--color-border-soft)]" id="staff-modal-content">
            <div class="p-10 relative">
                <button onclick="closeStaffModal()" class="absolute top-8 right-8 text-muted-veltrix hover:text-[var(--color-charcoal)] transition-colors p-2 bg-[var(--color-bg-card)] rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center space-x-6 mb-10">
                    <div id="modal-staff-avatar" class="w-20 h-20 rounded-3xl bg-[var(--color-primary)] text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-[var(--color-primary)]/10">
                        S
                    </div>
                    <div>
                        <h2 id="modal-staff-name" class="heading-editorial text-3xl">Staff Name</h2>
                        <div class="flex items-center space-x-3 mt-2">
                            <span id="modal-staff-role" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[var(--color-bg-base)] text-[var(--color-primary)]">Staff</span>
                            <span id="modal-staff-id" class="text-muted-veltrix text-xs">#ID-1</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="bg-[var(--color-bg-card)] p-6 rounded-3xl border border-[var(--color-border-soft)]">
                        <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-4">{{ __('messages.contact_info') }}</p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-muted-veltrix border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span id="modal-staff-email" class="text-sm font-medium text-[var(--color-charcoal)]">email@example.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[var(--color-bg-card)] p-6 rounded-3xl border border-[var(--color-border-soft)]">
                        <p class="text-[10px] font-bold text-[var(--color-accent)] uppercase tracking-widest mb-4">{{ __('messages.assignment_details') }}</p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-[var(--color-accent)] border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <span id="modal-staff-role-detail" class="text-sm font-medium text-[var(--color-charcoal)]">Role</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-[var(--color-accent)] border border-[var(--color-border-soft)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span id="modal-staff-created" class="text-sm font-medium text-[var(--color-charcoal)]">Joined Date</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 flex space-x-4">
                    <a id="modal-staff-email-link" href="#" class="flex-1 bg-[var(--color-primary)] text-white py-4 rounded-2xl font-bold flex items-center justify-center space-x-2 shadow-lg shadow-[var(--color-primary)]/10 hover:-translate-y-1 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Send Email</span>
                    </a>
                    <button onclick="closeStaffModal()" class="flex-1 btn-secondary-veltrix">
                        {{ __('messages.close_details') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-white flex flex-col justify-between fixed h-full z-20 border-r border-[var(--color-border-soft)] p-6">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2 mb-12 px-4 group">
                <div class="w-9 h-9 bg-[var(--color-primary)] rounded-lg flex items-center justify-center text-white font-bold text-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-md group-hover:shadow-[var(--color-primary)]/20">
                    V
                </div>
                <span class="font-bold text-xl tracking-tight text-[var(--color-charcoal)] transition-colors duration-300 group-hover:text-[var(--color-primary)]">Veltrix<span class="text-[var(--color-primary-light)] transition-colors duration-300 group-hover:text-[var(--color-primary)]">CRM</span></span>
            </a>

            <nav class="space-y-1.5">
                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-[0.2em] mb-4 mt-8 px-4 opacity-50">{{ __('messages.main_menu') }}</p>
                
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item-veltrix {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>{{ __('messages.dashboard') }}</span>
                </a>
                <a href="{{ route('admin.customers') }}" class="nav-item-veltrix {{ Request::is('admin/customers*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>{{ __('messages.customers') }}</span>
                </a>
                <a href="{{ route('admin.staff') }}" class="nav-item-veltrix {{ Request::is('admin/staff*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>{{ __('messages.staff') }}</span>
                </a>
                <a href="{{ route('admin.tasks') }}" class="nav-item-veltrix {{ Request::is('admin/tasks*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span>{{ __('messages.tasks') }}</span>
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item-veltrix {{ Request::is('admin/analytics*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>{{ __('messages.analytics') }}</span>
                </a>
                @else
                <a href="{{ route('staff.dashboard') }}" class="nav-item-veltrix {{ Request::is('staff/dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>{{ __('messages.dashboard') }}</span>
                </a>
                <a href="{{ route('staff.customers') }}" class="nav-item-veltrix {{ Request::is('staff/customers*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>{{ __('messages.customers') }}</span>
                </a>
                <a href="{{ route('staff.tasks') }}" class="nav-item-veltrix {{ Request::is('staff/tasks*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span>{{ __('messages.tasks') }}</span>
                </a>
                <a href="{{ route('staff.analytics') }}" class="nav-item-veltrix {{ Request::is('staff/analytics*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>{{ __('messages.analytics') }}</span>
                </a>
                @endif
            </nav>
        </div>

        <div class="mt-auto">
            <div class="bg-[var(--color-bg-card)] p-5 rounded-[24px] relative overflow-hidden border border-[var(--color-border-soft)]">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 bg-[var(--color-primary)]/5 rounded-full"></div>
                <h4 class="font-bold text-[var(--color-primary)] text-xs mb-1">Upgrade Experience</h4>
                <p class="text-[10px] text-muted-veltrix mb-4">Unlock advanced AI and priority flows.</p>
                <a href="{{ route('pricing') }}" class="w-full bg-[var(--color-primary)] text-white text-[10px] font-bold py-2.5 rounded-xl hover:opacity-90 transition block text-center">Upgrade Plan</a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-72 flex flex-col min-h-screen relative">
        <!-- Top Navigation -->
        <header id="topbar" class="h-20 px-8 flex items-center justify-between bg-transparent backdrop-blur-md sticky top-0 z-10 border-b border-[var(--color-border-soft)]/50">
            <div class="flex-1"></div>

            <div class="flex items-center space-x-6">
                <!-- Language Dropdown -->
                <div class="relative group" id="lang-dropdown-wrapper">
                    <button id="lang-dropdown-btn" class="flex items-center gap-2 px-4 py-2 bg-white border border-[var(--color-border-soft)] rounded-full text-[10px] font-bold uppercase tracking-widest text-[var(--color-charcoal)] hover:border-[var(--color-primary)] transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                        <span>{{ app()->getLocale() == 'en' ? 'English' : (app()->getLocale() == 'te' ? 'తెలుగు' : (app()->getLocale() == 'hi' ? 'हिंदी' : 'ਪੰਜਾਬੀ')) }}</span>
                        <svg class="w-3 h-3 opacity-40 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="lang-menu" class="absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all duration-500 delay-150 ease-out z-[70] overflow-hidden group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto group-hover:delay-0 group-hover:duration-300">
                        <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">English</a>
                        <a href="{{ route('lang.switch', 'te') }}" class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">తెలుగు</a>
                        <a href="{{ route('lang.switch', 'hi') }}" class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">हिंदी</a>
                        <a href="{{ route('lang.switch', 'pa') }}" class="flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0">ਪੰਜਾਬੀ</a>
                    </div>
                </div>

                <div class="relative group">
                    <button id="notification-bell" class="relative p-2 text-muted-veltrix hover:text-[var(--color-primary)] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span id="notif-count" class="absolute top-2 right-2.5 w-2 h-2 bg-[var(--color-accent)] rounded-full border-2 border-white hidden"></span>
                    </button>
                    
                    <div id="notif-dropdown" class="absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-2xl border border-[var(--color-border-soft)] hidden z-[60] overflow-hidden">
                        <div class="p-5 border-b border-[var(--color-border-soft)] flex justify-between items-center bg-[var(--color-bg-card)]">
                            <h4 class="heading-editorial text-sm">{{ __('messages.notifications') }}</h4>
                            <button onclick="clearNotifications()" class="text-[10px] font-bold text-[var(--color-primary)] hover:underline uppercase tracking-widest">{{ __('messages.clear_all') }}</button>
                        </div>
                        <div id="notif-list" class="max-h-64 overflow-y-auto">
                            <div class="p-8 text-center text-muted-veltrix text-xs">{{ __('messages.no_notifications') }}</div>
                        </div>
                        <div class="p-3 bg-[var(--color-bg-card)] text-center border-t border-[var(--color-border-soft)]">
                            <button id="toggle-notif-btn" onclick="toggleNotificationsView(event)" class="text-[10px] font-bold text-[var(--color-primary)] hover:text-[var(--color-primary-light)] uppercase tracking-widest">{{ __('messages.view_all') }}</button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-[var(--color-bg-card)] flex items-center justify-center text-[var(--color-primary)] font-bold overflow-hidden border border-[var(--color-border-soft)] shadow-sm">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=F5F3EF&color=2D3A2D" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-bold text-[var(--color-charcoal)] leading-tight">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-[10px] text-muted-veltrix hover:text-[var(--color-accent)] transition font-bold uppercase tracking-wider">{{ __('messages.logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div id="main-content" class="p-8 flex-1">
            @yield('content')
        </div>
    </main>

    <!-- Floating AI Widget -->
    <div id="ai-widget" class="fixed bottom-8 right-8 w-16 h-16 rounded-2xl bg-[var(--color-primary)] text-white flex items-center justify-center cursor-pointer shadow-2xl hover:-translate-y-1 hover:shadow-[0_20px_60px_-12px_rgba(45,58,45,0.3)] transition-all z-50 group">
        <span class="text-2xl font-bold group-hover:scale-110 transition-transform duration-300">V</span>
    </div>

    <!-- AI Chat Window -->
    <div id="chat-window" class="fixed bottom-28 right-8 w-96 bg-white rounded-[32px] shadow-[0_24px_64px_-12px_rgba(45,58,45,0.15)] border border-[var(--color-border-soft)] z-50 hidden flex-col overflow-hidden h-[500px]">
        <!-- Chat Header -->
        <div class="bg-[var(--color-primary)] p-6 text-white flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/15">
                    <span class="text-white font-bold text-lg">V</span>
                </div>
                <div>
                    <h3 class="heading-editorial text-white text-lg leading-tight">Veltrix AI</h3>
                    <p class="text-[10px] font-bold text-white/60 tracking-widest uppercase">System Active</p>
                </div>
            </div>
            <button id="close-chat" class="text-white/70 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" class="flex-1 p-6 overflow-y-auto space-y-4 bg-[var(--color-bg-base)]">
            <div class="msg-bubble bg-white border border-[var(--color-border-soft)] p-4 rounded-2xl rounded-tl-sm text-sm text-[var(--color-charcoal)] shadow-sm self-start">
                Hello {{ Auth::user()->name }}! I am your Veltrix Intelligence Assistant. How can I facilitate your workflow today?
            </div>
        </div>
        
        <!-- Chat Input -->
        <div class="p-5 bg-white border-t border-[var(--color-border-soft)]">
            <form id="chat-form" class="flex items-center bg-[var(--color-bg-card)] rounded-2xl border border-[var(--color-border-soft)] px-3 py-1.5">
                <input type="text" id="chat-input" placeholder="Enter inquiry..." class="flex-1 bg-transparent border-none outline-none text-sm px-3 py-2 text-[var(--color-charcoal)] placeholder-muted-veltrix" autocomplete="off" required>
                <button type="submit" class="w-9 h-9 rounded-xl bg-[var(--color-primary)] text-white flex items-center justify-center hover:opacity-90 transition shadow-md">
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Animations
        gsap.from("#sidebar", { x: -30, opacity: 0, duration: 1, ease: "power4.out" });
        gsap.from("#topbar", { y: -20, opacity: 0, duration: 1, delay: 0.2, ease: "power4.out" });
        gsap.from("#main-content", { y: 20, opacity: 0, duration: 1, delay: 0.4, ease: "power4.out" });

        // Chat Widget Logic
        const aiWidget = document.getElementById('ai-widget');
        const chatWindow = document.getElementById('chat-window');
        const closeChat = document.getElementById('close-chat');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        aiWidget.addEventListener('click', () => {
            chatWindow.classList.remove('hidden');
            chatWindow.style.display = 'flex';
            setTimeout(() => chatWindow.classList.add('open'), 10);
            aiWidget.style.transform = 'scale(0)';
        });

        closeChat.addEventListener('click', () => {
            chatWindow.classList.remove('open');
            setTimeout(() => {
                chatWindow.classList.add('hidden');
                chatWindow.style.display = 'none';
            }, 500);
            aiWidget.style.transform = 'scale(1)';
        });

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            appendMessage(message, 'user');
            chatInput.value = '';

            const thinkingId = 'thinking-' + Date.now();
            appendMessage('Processing...', 'ai', thinkingId);

            try {
                const response = await fetch('{{ route("ai.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                document.getElementById(thinkingId).remove();

                if (response.ok) {
                    appendMessage(data.reply, 'ai');
                } else {
                    appendMessage('Error: ' + data.error, 'error');
                }
            } catch (error) {
                if(document.getElementById(thinkingId)) document.getElementById(thinkingId).remove();
                appendMessage('Failed to connect to Veltrix AI.', 'error');
            }
        });

        function appendMessage(text, sender, id = null) {
            const div = document.createElement('div');
            if (id) div.id = id;
            
            if (sender === 'user') {
                div.className = 'msg-bubble bg-[var(--color-primary)] text-white p-4 rounded-2xl rounded-tr-sm text-sm shadow-sm self-end ml-auto';
            } else if (sender === 'ai') {
                div.className = 'msg-bubble bg-white border border-[var(--color-border-soft)] p-4 rounded-2xl rounded-tl-sm text-sm text-[var(--color-charcoal)] shadow-sm self-start mr-auto';
            } else {
                div.className = 'msg-bubble bg-[var(--color-accent)]/10 border border-[var(--color-accent)]/20 p-4 rounded-2xl rounded-tl-sm text-sm text-[var(--color-accent)] shadow-sm self-start mr-auto';
            }
            
            div.textContent = text;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Real-time Polling Logic
        const bell = document.getElementById('notification-bell');
        const dropdown = document.getElementById('notif-dropdown');
        const notifList = document.getElementById('notif-list');
        const notifCount = document.getElementById('notif-count');

        bell.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => dropdown.classList.add('hidden'));

        async function fetchNotifications() {
            try {
                const response = await fetch("{{ route('notifications.index') }}");
                const data = await response.json();
                
                if (data.unreadCount > 0) {
                    notifCount.classList.remove('hidden');
                } else {
                    notifCount.classList.add('hidden');
                }

                if (data.notifications.length > 0) {
                    notifList.innerHTML = data.notifications.map(n => `
                        <div class="p-5 border-b border-[var(--color-border-soft)] hover:bg-[var(--color-bg-card)] transition cursor-pointer ${n.is_read ? 'opacity-50' : ''}" onclick="markAsRead(${n.id})">
                            <h5 class="text-xs font-bold text-[var(--color-charcoal)]">${n.title}</h5>
                            <p class="text-[11px] text-muted-veltrix mt-1 leading-relaxed">${n.message}</p>
                            <span class="text-[9px] font-bold text-muted-veltrix mt-2 block opacity-50">${new Date(n.created_at).toLocaleString()}</span>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Polling error:', error);
            }
        }

        async function markAsRead(id) {
            try {
                await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                });
                fetchNotifications();
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        }

        async function clearNotifications() {
            if (!confirm('Clear all notifications?')) return;
            try {
                await fetch("{{ route('notifications.clear') }}", {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                });
                fetchNotifications();
            } catch (error) {
                console.error('Error clearing notifications:', error);
            }
        }

        function toggleNotificationsView(event) {
            if (event) event.stopPropagation();
            const list = document.getElementById('notif-list');
            const btn = document.getElementById('toggle-notif-btn');
            const isExpanded = list.classList.contains('max-h-[70vh]');
            
            if (isExpanded) {
                list.classList.remove('max-h-[70vh]', 'overflow-y-auto');
                list.classList.add('max-h-64', 'overflow-y-auto');
                btn.textContent = "{{ __('messages.view_all') }}";
            } else {
                list.classList.remove('max-h-64', 'overflow-y-auto');
                list.classList.add('max-h-[70vh]', 'overflow-y-auto');
                btn.textContent = "View Less";
            }
        }

        // Success Message Logic
        let successTimeout;
        function showSuccessMessage(message) {
            const modal = document.getElementById('success-message-modal');
            const container = document.getElementById('success-message-container');
            const text = document.getElementById('success-message-text');
            
            if (successTimeout) clearTimeout(successTimeout);
            
            text.textContent = message;
            if (modal) modal.classList.remove('hidden');
            
            setTimeout(() => {
                if (container) {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }
            }, 10);
            
            successTimeout = setTimeout(() => {
                closeSuccessMessageModal();
            }, 2500);
        }

        function closeSuccessMessageModal() {
            const modal = document.getElementById('success-message-modal');
            const container = document.getElementById('success-message-container');
            
            if (container) {
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
            }
            setTimeout(() => {
                if (modal) modal.classList.add('hidden');
            }, 300);
        }

        // Customer Modal Logic
        async function viewCustomerDetails(id) {
            const modal = document.getElementById('customer-details-modal');
            const content = document.getElementById('customer-modal-content');
            
            try {
                const response = await fetch(`/api/customers/${id}`);
                const data = await response.json();
                
                document.getElementById('modal-customer-name').textContent = data.name;
                document.getElementById('modal-customer-email').textContent = data.email || 'No email';
                document.getElementById('modal-customer-phone').textContent = data.phone || 'No phone';
                document.getElementById('modal-customer-status').textContent = data.status;
                document.getElementById('modal-customer-id').textContent = `#ID-${data.id}`;
                document.getElementById('modal-customer-assigned').textContent = data.assigned_to_name || 'Unassigned';
                document.getElementById('modal-customer-created').textContent = `Joined ${new Date(data.created_at).toLocaleDateString()}`;
                document.getElementById('modal-customer-avatar').textContent = data.name.charAt(0);
                
                if (data.phone) {
                    const cleanPhone = data.phone.replace(/[^0-9]/g, '');
                    document.getElementById('modal-customer-wa').href = `https://wa.me/${cleanPhone}`;
                    document.getElementById('modal-customer-wa').classList.remove('hidden');
                } else {
                    document.getElementById('modal-customer-wa').classList.add('hidden');
                }

                const statusBadge = document.getElementById('modal-customer-status');
                statusBadge.className = 'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ' + 
                    (data.status === 'active' ? 'bg-emerald-100 text-emerald-800' : 
                    (data.status === 'lead' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-500'));

                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            } catch (error) {
                console.error('Error fetching customer details:', error);
            }
        }

        // Staff Modal Logic
        async function viewStaffDetails(id) {
            const modal = document.getElementById('staff-details-modal');
            const content = document.getElementById('staff-modal-content');
            
            try {
                const response = await fetch(`/api/staff/${id}`);
                const data = await response.json();
                
                document.getElementById('modal-staff-name').textContent = data.name;
                document.getElementById('modal-staff-email').textContent = data.email || 'No email';
                document.getElementById('modal-staff-id').textContent = `#ID-${data.id}`;
                document.getElementById('modal-staff-avatar').textContent = data.name.charAt(0);
                document.getElementById('modal-staff-created').textContent = `Joined ${new Date(data.created_at).toLocaleDateString()}`;
                
                const roleText = data.role === 'admin' ? 'System Administrator' : 'Operational Staff';
                document.getElementById('modal-staff-role-detail').textContent = roleText;
                
                const roleBadge = document.getElementById('modal-staff-role');
                roleBadge.textContent = data.role;
                roleBadge.className = 'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ' + 
                    (data.role === 'admin' ? 'bg-orange-100 text-orange-800' : 'bg-[var(--color-bg-base)] text-[var(--color-primary)]');

                if (data.email) {
                    document.getElementById('modal-staff-email-link').href = `mailto:${data.email}`;
                }

                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            } catch (error) {
                console.error('Error fetching staff details:', error);
            }
        }

        function closeStaffModal() {
            const modal = document.getElementById('staff-details-modal');
            const content = document.getElementById('staff-modal-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                 modal.classList.add('hidden');
            }, 500);
        }

        function closeCustomerModal() {
            const modal = document.getElementById('customer-details-modal');
            const content = document.getElementById('customer-modal-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                 modal.classList.add('hidden');
            }, 500);
        }

        // Initialize Custom Select Dropdowns (Language Switcher Options UI/UX)
        function initializeCustomSelects() {
            document.querySelectorAll('select:not(#lang-switcher)').forEach(select => {
                if (select.dataset.customInitialized === 'true') return;
                select.dataset.customInitialized = 'true';
                
                // Keep the exact previous styled visual select box 100% intact,
                // but prevent native operating system dropdown trigger.
                select.style.pointerEvents = 'none';
                
                // Create custom dropdown wrapper to contain the select
                const wrapper = document.createElement('div');
                wrapper.className = 'relative custom-select-container';
                
                // Handle widths and layout flows
                const isFull = select.classList.contains('w-full') || !select.classList.contains('bg-white');
                if (isFull) {
                    wrapper.classList.add('w-full');
                } else {
                    wrapper.classList.add('inline-block');
                }
                
                // Insert wrapper before select and nest select inside it
                select.parentNode.insertBefore(wrapper, select);
                wrapper.appendChild(select);
                
                // Create custom options menu overlay
                const menu = document.createElement('div');
                menu.className = 'absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-[var(--color-border-soft)] opacity-0 translate-y-2 pointer-events-none transition-all ease-out z-[90] overflow-hidden max-h-60 overflow-y-auto';
                menu.style.transitionDuration = '500ms';
                menu.style.transitionDelay = '150ms';
                
                // Populate options
                function populateOptions() {
                    menu.innerHTML = '';
                    Array.from(select.options).forEach(option => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'flex items-center px-5 py-3.5 text-[10px] font-bold uppercase tracking-widest text-muted-veltrix hover:text-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition-colors border-b border-[var(--color-border-soft)] last:border-0';
                        item.textContent = option.textContent;
                        item.dataset.value = option.value;
                        
                        item.addEventListener('click', (e) => {
                            e.preventDefault();
                            
                            // Set value programmatically and dispatch change
                            select.value = option.value;
                            select.dispatchEvent(new Event('change'));
                            
                            closeMenu();
                        });
                        menu.appendChild(item);
                    });
                }
                
                populateOptions();
                wrapper.appendChild(menu);
                
                // Redefine select options mutation to auto-repopulate list if select is dynamically modified
                const observer = new MutationObserver(() => {
                    populateOptions();
                });
                observer.observe(select, { childList: true });
                
                // Hover/unhover logic matching Language Dropdown UX (fade and delay on hover-off)
                let closeTimeout;
                const activeBorderColor = 'var(--color-primary)';
                const originalBorderColor = select.style.borderColor;
                
                function openMenu() {
                    if (closeTimeout) clearTimeout(closeTimeout);
                    select.style.borderColor = activeBorderColor;
                    
                    // Trigger rotation of SVG chevron if styled with SVG
                    const chevron = select.parentNode.querySelector('.chevron-icon svg') || select.parentNode.querySelector('svg');
                    if (chevron) {
                        chevron.style.transform = 'rotate(180deg)';
                        chevron.style.transition = 'transform 0.3s ease';
                    }
                    
                    menu.style.transitionDuration = '300ms';
                    menu.style.transitionDelay = '0ms';
                    menu.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                }
                
                function closeMenu() {
                    select.style.borderColor = originalBorderColor;
                    const chevron = select.parentNode.querySelector('.chevron-icon svg') || select.parentNode.querySelector('svg');
                    if (chevron) {
                        chevron.style.transform = '';
                    }
                    
                    menu.style.transitionDuration = '500ms';
                    menu.style.transitionDelay = '150ms';
                    menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    menu.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                }
                
                wrapper.addEventListener('mouseenter', () => {
                    openMenu();
                });
                
                wrapper.addEventListener('mouseleave', () => {
                    closeMenu();
                });
                
                // Click behavior to toggle
                wrapper.addEventListener('click', (e) => {
                    if (e.target.tagName === 'A') return;
                    if (menu.classList.contains('pointer-events-auto')) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
            });
        }

        // Run custom dropdown initializer
        document.addEventListener('DOMContentLoaded', initializeCustomSelects);
        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            initializeCustomSelects();
        }
        setInterval(initializeCustomSelects, 1000); // Polling for dynamically loaded modal forms

        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    </script>
    
    @stack('scripts')
</body>
</html>
