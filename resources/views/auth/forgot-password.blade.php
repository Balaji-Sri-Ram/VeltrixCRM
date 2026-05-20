<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recover Access | VeltrixCRM</title>
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
        .otp-input {
            width: 56px;
            height: 64px;
            background-color: #ffffff;
            border: 1px solid rgba(26, 26, 26, 0.1);
            border-radius: 16px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-charcoal);
            padding: 8px;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .otp-input:focus, .otp-input.filled {
            border-color: var(--color-charcoal);
            box-shadow: 0 0 0 1px rgba(26, 26, 26, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .step-container {
            display: none;
            opacity: 0;
        }
        .step-active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-[var(--color-bg-base)] text-[var(--color-charcoal)] antialiased overflow-x-hidden">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Left Side: Marketing/Visual -->
        <div class="hidden lg:flex lg:w-1/2 bg-[var(--color-bg-card)] relative items-center justify-center p-24 overflow-hidden border-r border-[var(--color-border-soft)]">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[var(--color-primary)]/5 rounded-full blur-3xl -mr-48 -mt-48"></div>
            
            <div class="relative z-10 w-full max-w-lg">
                <div class="mb-12 animate-in-left">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl mb-8 shadow-lg shadow-[var(--color-primary)]/20">V</div>
                    <h1 id="visual-headline" class="heading-editorial text-5xl text-[var(--color-charcoal)] mb-6 leading-tight">Recover Access to Your Workspace.</h1>
                    <p id="visual-subtext" class="text-muted-veltrix text-lg leading-relaxed">Enter your registered email address and we'll send a secure OTP verification code to reset your password.</p>
                </div>

                <!-- Visual Element: Abstract Analytics Widgets -->
                <div class="space-y-6 animate-in-up">
                    <div class="group card-veltrix bg-white !p-6 shadow-xl border-[var(--color-border-soft)] flex items-center gap-6 hover:-translate-y-2 transition-all duration-500 cursor-default">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-100 transition-all duration-500 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <div class="font-bold text-[var(--color-charcoal)] mb-1 tracking-wide">Encrypted Channel</div>
                            <div class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">End-to-End Security</div>
                        </div>
                        <div class="ml-auto flex items-center gap-2">
                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Secure</span>
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Multi-Step Forms -->
        <div class="flex-1 flex items-center justify-center p-8 lg:p-24 bg-[var(--color-bg-base)]">
            <div class="w-full max-w-md">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12">
                    <div class="w-12 h-12 bg-[var(--color-primary)] rounded-2xl flex items-center justify-center text-white font-bold text-xl">V</div>
                </div>

                <!-- STEP 1: EMAIL ENTRY -->
                <div id="step-email" class="step-container step-active">
                    <div class="mb-8">
                        <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Security Recovery</h2>
                        <p class="text-muted-veltrix font-medium">Please enter your identity email to begin.</p>
                    </div>

                    <!-- Error Alert Banner -->
                    <div id="alert-email" class="hidden mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-xs font-semibold tracking-wide flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span id="alert-email-text"></span>
                    </div>

                    <form id="form-email" class="space-y-6">
                        <div>
                            <label for="recovery-email" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Work Email</label>
                            <input type="email" id="recovery-email" name="email" class="input-premium" placeholder="name@company.com" required autocomplete="email">
                        </div>

                        <button type="submit" id="btn-email" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 hover:-translate-y-0.5 transition-all flex items-center justify-center">
                            <span id="btn-email-text" class="text-xs uppercase tracking-widest font-bold">Transmit OTP Code</span>
                            <div id="btn-email-spinner" class="hidden flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-xs uppercase tracking-widest font-bold">Transmitting...</span>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- STEP 2: OTP VERIFICATION -->
                <div id="step-otp" class="step-container">
                    <div class="mb-8">
                        <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Verify Identity</h2>
                        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-2.5 rounded-xl inline-block text-[10px] font-bold uppercase tracking-widest mb-4">Verification code sent successfully.</div>
                        <p class="text-muted-veltrix font-medium">We've sent a 6-digit code to your email.</p>
                    </div>

                    <!-- Error Alert Banner -->
                    <div id="alert-otp" class="hidden mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-xs font-semibold tracking-wide flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span id="alert-otp-text"></span>
                    </div>

                    <form id="form-otp" class="space-y-8">
                        <div class="flex justify-between gap-2" id="otp-inputs">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                            <input type="text" maxlength="1" class="otp-input" required autocomplete="off">
                        </div>

                        <div class="space-y-4">
                            <button type="submit" id="btn-otp" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 flex items-center justify-center">
                                <span id="btn-otp-text" class="text-xs uppercase tracking-widest font-bold">Verify Identity</span>
                                <div id="btn-otp-spinner" class="hidden flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-xs uppercase tracking-widest font-bold">Verifying...</span>
                                </div>
                            </button>
                            <div class="text-center">
                                <p class="text-[10px] font-bold text-muted-veltrix uppercase tracking-widest">
                                    Didn't receive the code? <button type="button" id="btn-resend" class="text-[var(--color-primary)] hover:underline ml-1">Resend Code</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- STEP 3: PASSWORD RESET -->
                <div id="step-reset" class="step-container">
                    <div class="mb-8">
                        <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Reset Security</h2>
                        <p class="text-muted-veltrix font-medium">Define your new access credentials.</p>
                    </div>

                    <!-- Error Alert Banner -->
                    <div id="alert-reset" class="hidden mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-xs font-semibold tracking-wide flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span id="alert-reset-text"></span>
                    </div>

                    <form id="form-reset" class="space-y-6">
                        <div>
                            <label for="new-password" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">New Password</label>
                            <div class="relative">
                                <input type="password" id="new-password" class="input-premium" placeholder="••••••••" required oninput="checkStrength(this.value)" autocomplete="new-password">
                                <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-muted-veltrix hover:text-[var(--color-primary)] transition" onclick="togglePass('new-password')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                            </div>
                            <div class="mt-4 flex gap-1 h-1.5" id="strength-meter">
                                <div class="flex-1 bg-[var(--color-border-soft)] rounded-full transition-all duration-500"></div>
                                <div class="flex-1 bg-[var(--color-border-soft)] rounded-full transition-all duration-500"></div>
                                <div class="flex-1 bg-[var(--color-border-soft)] rounded-full transition-all duration-500"></div>
                            </div>
                            <p id="strength-text" class="text-[9px] font-bold text-muted-veltrix uppercase tracking-widest mt-2 opacity-60">Password Strength: Weak</p>
                        </div>

                        <div>
                            <label for="confirm-password" class="block text-[10px] font-bold text-muted-veltrix uppercase tracking-widest mb-3">Confirm Security</label>
                            <input type="password" id="confirm-password" class="input-premium" placeholder="••••••••" required autocomplete="new-password">
                        </div>

                        <button type="submit" id="btn-reset" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 flex items-center justify-center">
                            <span id="btn-reset-text" class="text-xs uppercase tracking-widest font-bold">Update Password</span>
                            <div id="btn-reset-spinner" class="hidden flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-xs uppercase tracking-widest font-bold">Updating...</span>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- STEP 4: CELEBRATION SUCCESS -->
                <div id="step-success" class="step-container text-center">
                    <div class="mb-8 flex flex-col items-center justify-center">
                        <!-- Premium Checkmark Animation Container -->
                        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 mb-6 border border-emerald-100 shadow-lg shadow-emerald-500/10">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h2 class="heading-editorial text-4xl mb-4 text-[var(--color-charcoal)]">Credentials Restored</h2>
                        <p class="text-muted-veltrix font-medium">Your new high-security password is now active in the VeltrixCRM database.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" class="w-full btn-primary-veltrix !py-5 shadow-xl shadow-[var(--color-primary)]/10 block text-xs uppercase tracking-widest font-bold">
                            Authenticate Now
                        </a>
                        <p class="text-[9px] font-bold text-muted-veltrix uppercase tracking-widest">
                            Redirecting to workspace in <span id="success-countdown">3</span>s...
                        </p>
                    </div>
                </div>
                
                <!-- Footer link -->
                <div id="recovery-footer" class="mt-12 text-center text-xs font-bold text-muted-veltrix uppercase tracking-widest">
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-[var(--color-primary)] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Memory state to hold email & OTP for the steps
        const recoveryState = {
            email: '',
            otp: ''
        };

        document.addEventListener("DOMContentLoaded", () => {
            // Entrance Animations
            gsap.from(".animate-in-left", { x: -30, opacity: 0, duration: 1.2, ease: "power4.out" });
            gsap.from(".animate-in-up", { y: 30, opacity: 0, duration: 1.2, delay: 0.3, ease: "power4.out" });
            
            // OTP Input Logic
            const otpInputs = document.querySelectorAll('.otp-input');
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1) {
                        input.classList.add('filled');
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else if (e.target.value.length === 0) {
                        input.classList.remove('filled');
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (!e.target.value) {
                            input.classList.remove('filled');
                            if (index > 0) {
                                otpInputs[index - 1].focus();
                                otpInputs[index - 1].value = '';
                                otpInputs[index - 1].classList.remove('filled');
                            }
                        } else {
                            e.target.value = '';
                            input.classList.remove('filled');
                        }
                    }
                });
            });

            // Form Submit Event Listeners
            document.getElementById('form-email').addEventListener('submit', handleSendOtp);
            document.getElementById('form-otp').addEventListener('submit', handleVerifyOtp);
            document.getElementById('form-reset').addEventListener('submit', handleResetPassword);
            document.getElementById('btn-resend').addEventListener('click', handleResendOtp);
        });

        // 1. Submit Email & Request OTP
        async function handleSendOtp(event) {
            event.preventDefault();
            const emailInput = document.getElementById('recovery-email');
            const alertBox = document.getElementById('alert-email');
            const btnText = document.getElementById('btn-email-text');
            const btnSpinner = document.getElementById('btn-email-spinner');
            const submitBtn = document.getElementById('btn-email');

            // Set loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            alertBox.classList.add('hidden');

            try {
                const response = await fetch("{{ route('password.otp.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: emailInput.value })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'An unexpected error occurred.');
                }

                // Success
                recoveryState.email = emailInput.value;
                goToStep(2);

            } catch (err) {
                // Show Error Alert Banner
                document.getElementById('alert-email-text').textContent = err.message;
                alertBox.classList.remove('hidden');
                gsap.fromTo(alertBox, { opacity: 0, y: -5 }, { opacity: 1, y: 0, duration: 0.3 });
            } finally {
                // Reset loading state
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
            }
        }

        // 2. Resend Code
        async function handleResendOtp(event) {
            event.preventDefault();
            const btn = document.getElementById('btn-resend');
            const alertBox = document.getElementById('alert-otp');
            
            btn.disabled = true;
            btn.textContent = 'Transmitting...';
            alertBox.classList.add('hidden');

            try {
                const response = await fetch("{{ route('password.otp.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: recoveryState.email })
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message);

                alertBox.className = 'mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-xs font-semibold tracking-wide flex items-center gap-3';
                document.getElementById('alert-otp-text').textContent = 'A new security code has been transmitted successfully.';
                alertBox.classList.remove('hidden');
                gsap.fromTo(alertBox, { opacity: 0, y: -5 }, { opacity: 1, y: 0, duration: 0.3 });
            } catch (err) {
                alertBox.className = 'mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-xs font-semibold tracking-wide flex items-center gap-3';
                document.getElementById('alert-otp-text').textContent = err.message;
                alertBox.classList.remove('hidden');
                gsap.fromTo(alertBox, { opacity: 0, y: -5 }, { opacity: 1, y: 0, duration: 0.3 });
            } finally {
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = 'Resend Code';
                }, 5000);
            }
        }

        // 3. Verify OTP code
        async function handleVerifyOtp(event) {
            event.preventDefault();
            const otpInputs = document.querySelectorAll('.otp-input');
            const alertBox = document.getElementById('alert-otp');
            const btnText = document.getElementById('btn-otp-text');
            const btnSpinner = document.getElementById('btn-otp-spinner');
            const submitBtn = document.getElementById('btn-otp');

            const otp = Array.from(otpInputs).map(input => input.value).join('');

            if (otp.length < 6) {
                document.getElementById('alert-otp-text').textContent = 'Please fill out the full 6-digit security code.';
                alertBox.classList.remove('hidden');
                return;
            }

            // Set loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            alertBox.classList.add('hidden');

            try {
                const response = await fetch("{{ route('password.otp.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: recoveryState.email,
                        otp: otp
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'The entered OTP code is invalid.');
                }

                // Success
                recoveryState.otp = otp;
                goToStep(3);

            } catch (err) {
                // Show Error Alert Banner
                document.getElementById('alert-otp-text').textContent = err.message;
                alertBox.classList.remove('hidden');
                gsap.fromTo(alertBox, { opacity: 0, y: -5 }, { opacity: 1, y: 0, duration: 0.3 });
            } finally {
                // Reset loading state
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
            }
        }

        // 4. Reset Password
        async function handleResetPassword(event) {
            event.preventDefault();
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const alertBox = document.getElementById('alert-reset');
            const btnText = document.getElementById('btn-reset-text');
            const btnSpinner = document.getElementById('btn-reset-spinner');
            const submitBtn = document.getElementById('btn-reset');

            if (newPassword !== confirmPassword) {
                document.getElementById('alert-reset-text').textContent = 'Confirm password does not match the new password.';
                alertBox.classList.remove('hidden');
                return;
            }

            // Set loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            alertBox.classList.add('hidden');

            try {
                const response = await fetch("{{ route('password.reset.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: recoveryState.email,
                        otp: recoveryState.otp,
                        password: newPassword,
                        password_confirmation: confirmPassword
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update credentials.');
                }

                // Success celebration slide
                goToStep(4);

                // Run beautiful 3 seconds countdown and redirect
                let count = 3;
                const counterText = document.getElementById('success-countdown');
                const interval = setInterval(() => {
                    count--;
                    counterText.textContent = count;
                    if (count <= 0) {
                        clearInterval(interval);
                        window.location.href = "{{ route('login') }}";
                    }
                }, 1000);

            } catch (err) {
                // Show Error Alert Banner
                document.getElementById('alert-reset-text').textContent = err.message;
                alertBox.classList.remove('hidden');
                gsap.fromTo(alertBox, { opacity: 0, y: -5 }, { opacity: 1, y: 0, duration: 0.3 });
            } finally {
                // Reset loading state
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
            }
        }

        function goToStep(step) {
            const current = document.querySelector('.step-active');
            let next;
            if (step === 2) {
                next = document.getElementById('step-otp');
            } else if (step === 3) {
                next = document.getElementById('step-reset');
            } else if (step === 4) {
                next = document.getElementById('step-success');
                // Hide recovery footer
                document.getElementById('recovery-footer').classList.add('hidden');
            }
            
            // Visual feedback transitions
            if(step === 2) {
                document.getElementById('visual-headline').textContent = "Verify Identity.";
                document.getElementById('visual-subtext').textContent = "We've transmitted a specialized security token to your account email for authorization.";
            } else if(step === 3) {
                document.getElementById('visual-headline').textContent = "Get Back to Managing Your Business.";
                document.getElementById('visual-subtext').textContent = "Your identity is verified. You may now define a new high-security password for your CRM workspace.";
            } else if(step === 4) {
                document.getElementById('visual-headline').textContent = "Workspace Restored.";
                document.getElementById('visual-subtext').textContent = "Your security credentials have been successfully synchronized across our secure cloud servers.";
            }

            gsap.to(current, { 
                opacity: 0, 
                y: -10, 
                duration: 0.4, 
                onComplete: () => {
                    current.classList.remove('step-active');
                    next.classList.add('step-active');
                    gsap.fromTo(next, { opacity: 0, y: 10 }, { opacity: 1, y: 0, duration: 0.4 });
                    
                    // Autofocus OTP input or New password input
                    if (step === 2) {
                        const firstOtpInput = document.querySelector('.otp-input');
                        if (firstOtpInput) firstOtpInput.focus();
                    } else if (step === 3) {
                        const newPassInput = document.getElementById('new-password');
                        if (newPassInput) newPassInput.focus();
                    }
                }
            });
        }

        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function checkStrength(pass) {
            const meters = document.getElementById('strength-meter').children;
            const text = document.getElementById('strength-text');
            
            let score = 0;
            if (pass.length > 0) {
                score = 1; // Default Weak
                
                if (pass.length >= 6) {
                    score = 2; // Medium
                    
                    // Upgrade to Strong if length >= 8 OR has capital OR has special char
                    if (pass.length >= 8 || /[A-Z]/.test(pass) || /[^a-zA-Z0-9]/.test(pass)) {
                        score = 3; // Strong
                    }
                }
            }

            for (let i = 0; i < 3; i++) {
                meters[i].className = 'flex-1 bg-[var(--color-border-soft)] rounded-full transition-all duration-500';
                if (i < score) {
                    meters[i].classList.remove('bg-[var(--color-border-soft)]');
                    meters[i].classList.add(score === 1 ? 'bg-orange-400' : (score === 2 ? 'bg-yellow-400' : 'bg-emerald-500'));
                }
            }
            
            if (score === 0) {
                text.textContent = 'Password Strength: Required';
                text.className = 'text-[9px] font-bold uppercase tracking-widest mt-2 text-muted-veltrix opacity-60';
            } else {
                text.textContent = `Password Strength: ${score === 1 ? 'Weak' : (score === 2 ? 'Medium' : 'High Security')}`;
                text.className = `text-[9px] font-bold uppercase tracking-widest mt-2 ${score === 1 ? 'text-orange-500' : (score === 2 ? 'text-yellow-600' : 'text-emerald-600')}`;
            }
        }
    </script>
</body>
</html>
