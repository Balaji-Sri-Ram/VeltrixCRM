@extends('layouts.dashboard')

@section('title', __('messages.pricing_title'))

@section('content')
@php
    $successJson = file_get_contents(public_path('animations/success.json'));
    $cancelJson = file_get_contents(public_path('animations/cancel.json'));
@endphp
<!-- Add Lottie Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>

<div class="min-h-screen flex flex-col py-16 px-6 lg:px-12 bg-[var(--color-bg-base)]">
    <div class="max-w-7xl mx-auto w-full">
        <!-- Header Section -->
        <div class="text-center mb-24 opacity-0" id="pricing-header">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] text-[var(--color-primary)] font-medium text-xs tracking-wide uppercase mb-6">
                {{ __('messages.simple_transparency') }}
            </div>
            <h1 class="heading-editorial text-5xl lg:text-6xl mb-6">{!! str_replace(['growth', 'विकास', 'వృద్ధి', 'ਵਿਕਾਸ'], ['<span class="text-[var(--color-accent)]">growth</span>', '<span class="text-[var(--color-accent)]">विकास</span>', '<span class="text-[var(--color-accent)]">వృద్ధి</span>', '<span class="text-[var(--color-accent)]">ਵਿਕਾਸ</span>'], __('messages.pricing_heading')) !!}</h1>
            <p class="text-muted-veltrix text-lg max-w-2xl mx-auto">{{ __('messages.pricing_sub') }}</p>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-32">
            <!-- Free Plan -->
            <div class="pricing-card card-veltrix bg-white flex flex-col opacity-0" id="plan-free">
                <div class="mb-10">
                    <div class="w-12 h-12 bg-[var(--color-bg-card)] rounded-xl flex items-center justify-center text-[var(--color-primary)] mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[var(--color-charcoal)] mb-2">{{ __('messages.starter') }}</h3>
                    <p class="text-muted-veltrix text-sm">{{ __('messages.starter_desc') }}</p>
                </div>
                <div class="mb-10">
                    <span class="text-5xl font-bold text-[var(--color-charcoal)]">₹0</span>
                    <span class="text-muted-veltrix text-sm">/ {{ __('messages.forever') }}</span>
                </div>
                <ul class="space-y-4 mb-12 flex-1">
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_100_cust') }}</li>
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_basic_tasks') }}</li>
                    <li class="flex items-center text-sm text-muted-veltrix opacity-50"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 12H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_ai_assistant') }}</li>
                </ul>
                <button onclick="openCheckout('{{ __('messages.starter') }}', 0)" class="btn-secondary-veltrix w-full">{{ __('messages.current_plan') }}</button>
            </div>

            <!-- Pro Plan -->
            <div class="pricing-card card-veltrix bg-white border-2 border-[var(--color-accent)] relative opacity-0" id="plan-pro">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[var(--color-accent)] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ __('messages.most_refined') }}</div>
                <div class="mb-10">
                    <div class="w-12 h-12 bg-[var(--color-bg-card)] rounded-xl flex items-center justify-center text-[var(--color-primary)] mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.143-7.714L1 12l6.857-2.286L9 3z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[var(--color-charcoal)] mb-2">{{ __('messages.professional') }}</h3>
                    <p class="text-muted-veltrix text-sm">{{ __('messages.pro_desc') }}</p>
                </div>
                <div class="mb-10">
                    <span class="text-5xl font-bold text-[var(--color-charcoal)]">₹999</span>
                    <span class="text-muted-veltrix text-sm">/ {{ __('messages.month') }}</span>
                </div>
                <ul class="space-y-4 mb-12 flex-1">
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_1000_cust') }}</li>
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_ai_chatbot') }}</li>
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_team_collab') }}</li>
                </ul>
                <button onclick="openCheckout('{{ __('messages.professional') }}', 999)" class="btn-primary-veltrix w-full">{{ __('messages.upgrade_now') }}</button>
            </div>

            <!-- Professional Plan -->
            <div class="pricing-card card-veltrix bg-white flex flex-col opacity-0" id="plan-professional">
                <div class="mb-10">
                    <div class="w-12 h-12 bg-[var(--color-primary)] text-white rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[var(--color-charcoal)] mb-2">{{ __('messages.enterprise_plan') }}</h3>
                    <p class="text-muted-veltrix text-sm">{{ __('messages.ent_desc') }}</p>
                </div>
                <div class="mb-10">
                    <span class="text-5xl font-bold text-[var(--color-charcoal)]">₹2999</span>
                    <span class="text-muted-veltrix text-sm">/ {{ __('messages.month') }}</span>
                </div>
                <ul class="space-y-4 mb-12 flex-1">
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_unlim_cust') }}</li>
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_custom_ai') }}</li>
                    <li class="flex items-center text-sm text-[var(--color-charcoal)]"><svg class="w-5 h-5 text-[var(--color-primary)] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.feature_sso') }}</li>
                </ul>
                <button onclick="openCheckout('{{ __('messages.enterprise_plan') }}', 2999)" class="btn-secondary-veltrix w-full">{{ __('messages.secure_enterprise') }}</button>
            </div>
        </div>

        <!-- Payment Methods Footer -->
        <div class="text-center opacity-0 w-full mb-12" id="pricing-footer">
            <p class="text-xs font-bold tracking-[0.2em] text-muted-veltrix uppercase mb-10">{{ __('messages.encrypted_tx') }}</p>
            <div class="flex flex-wrap justify-center items-center gap-16">
                <span class="payment-label hover:text-[#1A1F71]">VISA</span>
                <span class="payment-label hover:text-[#EB001B]">MASTERCARD</span>
                <span class="payment-label hover:text-[#0979B0] italic">UPI</span>
                <span class="payment-label hover:text-[#4285F4]">GPAY</span>
                <span class="payment-label hover:text-[#6739B7]">PHONEPE</span>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkout-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-[var(--color-primary)]/10 backdrop-blur-md" onclick="closeCheckout()"></div>
    <div class="bg-white rounded-3xl w-full max-w-xl relative overflow-hidden shadow-2xl border border-[var(--color-border-soft)]" id="checkout-card">
        <!-- Close Button -->
        <button onclick="closeCheckout()" class="absolute top-8 right-8 text-muted-veltrix hover:text-[var(--color-charcoal)] z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        
        <!-- Header -->
        <div class="p-10 border-b border-[var(--color-border-soft)] bg-[var(--color-bg-card)]">
            <h3 class="heading-editorial text-2xl" id="modal-title">{{ __('messages.upgrade_to') }} <span id="selected-plan" class="text-[var(--color-accent)]"></span></h3>
            <p class="text-muted-veltrix text-sm mt-2">{{ __('messages.finalize_sub') }}</p>
        </div>

        <!-- Slider Container -->
        <div class="overflow-hidden">
            <div id="checkout-slider" class="flex transition-transform duration-500 ease-out">
                
                <!-- Step 1: User Details -->
                <div class="w-full flex-shrink-0 p-10">
                    <div class="space-y-6">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-[var(--color-charcoal)]">{{ __('messages.personal_info') }}</h4>
                            <button onclick="toggleEditDetails()" class="text-xs text-[var(--color-primary)] font-bold hover:underline" id="edit-btn">{{ __('messages.edit_details') }}</button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.full_name') }}</label>
                                <input type="text" id="user-name" value="{{ Auth::user()->name }}" disabled class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none transition disabled:opacity-70">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.email_address') }}</label>
                                <input type="email" id="user-email" value="{{ Auth::user()->email }}" disabled class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none transition disabled:opacity-70">
                            </div>
                        </div>
                        <div class="pt-4">
                            <button onclick="goToStep(1)" class="btn-primary-veltrix w-full">{{ __('messages.proceed_to_payment') }}</button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Payment Options -->
                <div class="w-full flex-shrink-0 p-10">
                    <h4 class="font-bold text-[var(--color-charcoal)] mb-6">{{ __('messages.payment_method') }}</h4>
                    <div class="space-y-3">
                        <button onclick="selectPayment('UPI')" class="w-full p-5 rounded-2xl border border-[var(--color-border-soft)] hover:border-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[var(--color-bg-card)] rounded-lg flex items-center justify-center mr-4 text-[var(--color-primary)] transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="font-bold text-[var(--color-charcoal)]">{{ __('messages.upi_transfer') }}</span>
                            </div>
                            <svg class="w-5 h-5 text-muted-veltrix" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button onclick="selectPayment('Card')" class="w-full p-5 rounded-2xl border border-[var(--color-border-soft)] hover:border-[var(--color-primary)] hover:bg-[var(--color-bg-card)] transition flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[var(--color-bg-card)] rounded-lg flex items-center justify-center mr-4 text-[var(--color-primary)] transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="font-bold text-[var(--color-charcoal)]">{{ __('messages.card_payment') }}</span>
                            </div>
                            <svg class="w-5 h-5 text-muted-veltrix" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    <button onclick="goToStep(0)" class="mt-8 text-muted-veltrix text-sm font-bold hover:text-[var(--color-charcoal)] flex items-center mx-auto"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.back') }}</button>
                </div>

                <!-- Step 3: Payment Details -->
                <div class="w-full flex-shrink-0 p-10">
                    <h4 class="font-bold text-[var(--color-charcoal)] mb-6" id="payment-step-title">{{ __('messages.enter_details') }}</h4>
                    <div id="upi-fields" class="hidden space-y-4">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.upi_id') }} <span class="text-[var(--color-accent)]">*</span></label>
                            <input type="text" id="upi-input" placeholder="username@upi" required class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none">
                        </div>
                    </div>
                    <div id="card-fields" class="hidden space-y-4">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.card_number') }} <span class="text-[var(--color-accent)]">*</span></label>
                            <input type="text" id="card-num-input" placeholder="XXXX XXXX XXXX XXXX" required class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.expiry') }} <span class="text-[var(--color-accent)]">*</span></label>
                                <input type="text" id="card-exp-input" placeholder="MM/YY" required class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase tracking-widest font-bold text-muted-veltrix mb-1.5 block">{{ __('messages.cvv') }} <span class="text-[var(--color-accent)]">*</span></label>
                                <input type="password" id="card-cvv-input" placeholder="***" required class="w-full px-5 py-4 bg-[var(--color-bg-card)] border border-[var(--color-border-soft)] rounded-xl text-[var(--color-charcoal)] outline-none">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Message Block -->
                    <p id="payment-error-msg" class="text-xs font-bold text-[var(--color-accent)] mt-6 text-center hidden"></p>

                    <button onclick="validateAndProceedToReview()" class="btn-primary-veltrix w-full mt-8">{{ __('messages.proceed_to_payment') }}</button>
                    <button onclick="goToStep(1)" class="mt-8 text-muted-veltrix text-sm font-bold hover:text-[var(--color-charcoal)] flex items-center mx-auto"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> {{ __('messages.back') }}</button>
                </div>

                <!-- Step 4: Final Confirmation -->
                <div class="w-full flex-shrink-0 p-10">
                    <div class="text-center mb-10">
                        <div class="w-16 h-16 bg-[var(--color-bg-card)] text-[var(--color-primary)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-[var(--color-charcoal)]">{{ __('messages.upgrade_to') }}</h4>
                        <p class="text-muted-veltrix text-sm mt-2">{{ __('messages.this_month') }}: <span class="font-bold text-[var(--color-charcoal)]" id="final-price"></span></p>
                    </div>
                    <div class="space-y-4">
                        <button onclick="confirmPayment()" class="btn-primary-veltrix w-full">{{ __('messages.upgrade_now') }}</button>
                        <button onclick="cancelPayment()" class="w-full py-4 text-sm font-bold text-muted-veltrix hover:text-[var(--color-accent)] transition-colors">{{ __('messages.payment_cancelled') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Overlay with Lottie -->
<div id="success-overlay" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-white/40 backdrop-blur-xl"></div>
    <div class="text-center relative z-10 w-full max-w-md px-6 flex flex-col items-center">
        <div id="lottie-success" class="mb-4" style="width: 280px; height: 280px; display: block; margin: 0 auto;"></div>
        <h2 class="heading-editorial text-4xl mb-4 opacity-0 translate-y-4" id="success-title">{{ __('messages.payment_success') }}</h2>
        <p class="text-muted-veltrix opacity-0 translate-y-4" id="success-msg">{{ __('messages.redirecting_dashboard') }}</p>
    </div>
</div>

<!-- Cancel Overlay with Lottie -->
<div id="cancel-overlay" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-white/40 backdrop-blur-xl"></div>
    <div class="text-center relative z-10 w-full max-w-md px-6 flex flex-col items-center">
        <div id="lottie-cancel" class="mb-4" style="width: 280px; height: 280px; display: block; margin: 0 auto;"></div>
        <h2 class="heading-editorial text-4xl mb-4 opacity-0 translate-y-4" id="cancel-title">{{ __('messages.payment_cancelled') }}</h2>
        <p class="text-muted-veltrix opacity-0 translate-y-4" id="cancel-msg">{{ __('messages.return_pricing') }}</p>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Fix Animation: Ensure elements appear and STAY visible
        gsap.set(["#pricing-header", ".pricing-card", "#pricing-footer"], { opacity: 0, y: 30 });
        
        const tl = gsap.timeline({ defaults: { ease: "power3.out" } });
        tl.to("#pricing-header", { opacity: 1, y: 0, duration: 0.8 })
          .to(".pricing-card", { 
              opacity: 1, 
              y: 0, 
              duration: 0.6, 
              stagger: 0.15
          }, "-=0.4")
          .to("#pricing-footer", { opacity: 1, y: 0, duration: 0.8 }, "-=0.2");
    });

    let currentStep = 0;
    const slider = document.getElementById('checkout-slider');
    const modal = document.getElementById('checkout-modal');

    function openCheckout(plan, price) {
        document.getElementById('selected-plan').textContent = plan;
        document.getElementById('final-price').textContent = '₹' + price;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        goToStep(0);
        
        gsap.from("#checkout-modal #checkout-card", {
            y: 40, opacity: 0, duration: 0.6, ease: "power4.out"
        });
    }

    function closeCheckout() {
        gsap.to("#checkout-modal #checkout-card", {
            y: 40, opacity: 0, duration: 0.4, onComplete: () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    }

    function goToStep(step) {
        currentStep = step;
        const xPercent = -step * 100;
        gsap.to(slider, {
            xPercent: xPercent,
            duration: 0.6,
            ease: "power3.inOut"
        });
    }

    function toggleEditDetails() {
        const inputs = ['user-name', 'user-email'];
        const btn = document.getElementById('edit-btn');
        const isEditing = btn.textContent === "{{ __('messages.save_customer') }}" || btn.textContent === "Save Details" || btn.textContent === "ਸੁਰੱਖਿਅਤ ਕਰੋ" || btn.textContent === "सहेजें" || btn.textContent === "సేవ్ చేయి";

        inputs.forEach(id => {
            const input = document.getElementById(id);
            input.disabled = isEditing;
            if(!isEditing) input.classList.add('bg-white', 'border-[var(--color-primary)]');
            else input.classList.remove('bg-white', 'border-[var(--color-primary)]');
        });

        if (isEditing) {
            btn.textContent = "{{ __('messages.edit_details') }}";
        } else {
            btn.textContent = btn.getAttribute('data-save-text') || "Save Details";
        }
    }

    // Set translation text for Save Details
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('edit-btn');
        if (btn) {
            btn.setAttribute('data-save-text', "{{ __('messages.save_customer') }}");
        }
    });

    let selectedPaymentMethod = '';
    function selectPayment(method) {
        selectedPaymentMethod = method;
        document.getElementById('payment-step-title').textContent = method + ' ' + "{{ __('messages.enter_details') }}";
        document.getElementById('upi-fields').classList.add('hidden');
        document.getElementById('card-fields').classList.add('hidden');
        
        // Clear errors and input fields
        const errorMsg = document.getElementById('payment-error-msg');
        if (errorMsg) errorMsg.classList.add('hidden');
        
        if (method === 'UPI') {
            document.getElementById('upi-fields').classList.remove('hidden');
        } else {
            document.getElementById('card-fields').classList.remove('hidden');
        }
        
        goToStep(2);
    }

    function validateAndProceedToReview() {
        const errorMsg = document.getElementById('payment-error-msg');
        if (errorMsg) {
            errorMsg.classList.add('hidden');
            errorMsg.textContent = '';
        }
        
        if (selectedPaymentMethod === 'UPI') {
            const upiInput = document.getElementById('upi-input');
            const upiVal = upiInput ? upiInput.value.trim() : '';
            if (!upiVal) {
                showPaymentError("{{ __('messages.enter_valid_upi') }}");
                if (upiInput) upiInput.focus();
                return;
            }
            if (!upiVal.includes('@')) {
                showPaymentError("{{ __('messages.enter_valid_upi') }}");
                if (upiInput) upiInput.focus();
                return;
            }
        } else if (selectedPaymentMethod === 'Card') {
            const cardNum = document.getElementById('card-num-input');
            const cardExp = document.getElementById('card-exp-input');
            const cardCvv = document.getElementById('card-cvv-input');
            
            const cardNumVal = cardNum ? cardNum.value.trim() : '';
            const cardExpVal = cardExp ? cardExp.value.trim() : '';
            const cardCvvVal = cardCvv ? cardCvv.value.trim() : '';
            
            if (!cardNumVal) {
                showPaymentError("{{ __('messages.enter_valid_card') }}");
                if (cardNum) cardNum.focus();
                return;
            }
            const cleanCard = cardNumVal.replace(/\s+/g, '');
            if (cleanCard.length < 12 || isNaN(cleanCard)) {
                showPaymentError("{{ __('messages.enter_valid_card') }}");
                if (cardNum) cardNum.focus();
                return;
            }
            
            if (!cardExpVal) {
                showPaymentError("{{ __('messages.enter_valid_exp') }}");
                if (cardExp) cardExp.focus();
                return;
            }
            const expRegex = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
            if (!expRegex.test(cardExpVal)) {
                showPaymentError("{{ __('messages.enter_valid_exp') }}");
                if (cardExp) cardExp.focus();
                return;
            }
            
            if (!cardCvvVal) {
                showPaymentError("{{ __('messages.enter_valid_cvv') }}");
                if (cardCvv) cardCvv.focus();
                return;
            }
            if (cardCvvVal.length < 3 || isNaN(cardCvvVal)) {
                showPaymentError("{{ __('messages.enter_valid_cvv') }}");
                if (cardCvv) cardCvv.focus();
                return;
            }
        }
        
        goToStep(3);
    }
    
    function showPaymentError(msg) {
        const errorMsg = document.getElementById('payment-error-msg');
        if (errorMsg) {
            errorMsg.textContent = msg;
            errorMsg.classList.remove('hidden');
            
            // GSAP premium shake effect on error
            gsap.fromTo("#payment-error-msg", 
                { x: -10 }, 
                { x: 10, duration: 0.08, repeat: 3, yoyo: true, ease: "sine.inOut", onComplete: () => {
                    gsap.set("#payment-error-msg", { x: 0 });
                }}
            );
        }
    }

    // Attach auto-formatters when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        // Card number auto-spacing
        const cardNumInput = document.getElementById('card-num-input');
        if (cardNumInput) {
            cardNumInput.addEventListener('input', (e) => {
                let val = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let matches = val.match(/\d{4,16}/g);
                let match = matches && matches[0] || '';
                let parts = [];
                for (let i = 0, len = match.length; i < len; i += 4) {
                    parts.push(match.substring(i, i + 4));
                }
                e.target.value = parts.length > 0 ? parts.join(' ') : val;
            });
        }

        // Expiry date auto-slash
        const cardExpInput = document.getElementById('card-exp-input');
        if (cardExpInput) {
            cardExpInput.addEventListener('input', (e) => {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length >= 2) {
                    e.target.value = val.substring(0, 2) + '/' + val.substring(2, 4);
                } else {
                    e.target.value = val;
                }
            });
        }
        
        // CVV auto-limit and digit-only restriction
        const cardCvvInput = document.getElementById('card-cvv-input');
        if (cardCvvInput) {
            cardCvvInput.addEventListener('input', (e) => {
                let val = e.target.value.replace(/\D/g, '');
                e.target.value = val.substring(0, 3);
            });
        }
    });

    let successAnim, cancelAnim;

    function confirmPayment() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        const overlay = document.getElementById('success-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        if (successAnim) successAnim.destroy();
        successAnim = lottie.loadAnimation({
            container: document.getElementById('lottie-success'),
            renderer: 'svg',
            loop: false,
            autoplay: true,
            animationData: {!! $successJson !!}
        });

        successAnim.onComplete = () => {
            setTimeout(() => {
                window.location.href = "{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}";
            }, 1800);
        };

        gsap.timeline()
            .to("#success-title", { opacity: 1, y: 0, duration: 0.6, delay: 0.3 })
            .to("#success-msg", { opacity: 1, y: 0, duration: 0.6 }, "-=0.3");
    }

    function cancelPayment() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        const overlay = document.getElementById('cancel-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        if (cancelAnim) cancelAnim.destroy();
        cancelAnim = lottie.loadAnimation({
            container: document.getElementById('lottie-cancel'),
            renderer: 'svg',
            loop: false,
            autoplay: true,
            animationData: {!! $cancelJson !!}
        });

        cancelAnim.onComplete = () => {
            setTimeout(() => {
                closeCancelOverlay();
            }, 1800);
        };

        gsap.timeline()
            .to("#cancel-title", { opacity: 1, y: 0, duration: 0.6, delay: 0.3 })
            .to("#cancel-msg", { opacity: 1, y: 0, duration: 0.6 }, "-=0.3");
    }

    function closeCancelOverlay() {
        const overlay = document.getElementById('cancel-overlay');
        gsap.to(overlay, { opacity: 0, duration: 0.5, onComplete: () => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            overlay.style.opacity = 1;
        }});
    }
</script>
@endpush

<style>
    .pricing-card { transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
    .pricing-card:hover { transform: translateY(-8px); }
    #checkout-slider { width: 100%; }
    .payment-label { 
        @apply text-xl font-bold opacity-30 grayscale cursor-default transition-all duration-300;
    }
    .payment-label:hover {
        @apply opacity-100 grayscale-0 -translate-y-1;
    }
</style>
@endsection
