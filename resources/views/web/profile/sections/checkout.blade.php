@extends('web.profile.profile-master')

@section('checkout-content')
    <!-- Success Modal -->
    <div id="successModal" class="rs-payment-popup" style="display:none;">
        <div class="rs-payment-popup-content rs-payment-popup-content-2 text-center">
            <button type="button" class="rs-payment-popup-close rs-payment-popup-close-2"><i
                    class="fal fa-times"></i></button>
            <div class="rs-payment-popup-icon success mb-20">
                <img src="{{ asset('assets/frontend/img/icon/check.svg') }}" alt="">
            </div>
            <h2>{{ __('Thanks for Your Purchase') }}!</h2>

            <!-- SHOW JSON HERE -->
            <p id="successResponse"></p>

            <a href="{{ route('home') }}"
                class="rs-modal-btn rs-modal-btn-1 rs-btn rs-success-btn actionBtn d-flex align-items-center justify-content-center ml-auto mr-auto">{{ __('Back Home') }}</a>
        </div>
    </div>
    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">{{ __('Error') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>



    <div class="col-xl-12 checkout fix">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-24"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">{{ __('Checkout') }}</h2>
        </div>
        <!-- Checkout Card -->
        <div class="rs-checkout-card">

            <form id="checkoutForm" action="{{ url('/api/boostplan/checkout') }}" method="POST">
                @csrf
                <div class="rs-checkout-body d-flex align-items-center justify-content-between fix">
                    <div class="rs-checkout-left">
                        <div class="rs-info-card">

                            <input type="hidden" name="boost_plan_id" value="{{ $boostPlan->id ?? '' }}">
                            <input type="hidden" name="selling_post_id" value="{{ $post->id ?? '' }}">
                            <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
                            <div class="rs-checkout-form-top p-16 mb-25" data-bg-color="#F6F7F9">
                                <h5 class="rs-checkout-info-title">{{ __('User Information') }}</h5>
                                <div class="rs-checkout-input-item mb-16">
                                    <label class="rs-checkout-form-label">{{ __('Name') }}</label>
                                    <input class="rs-checkout-form-input" type="text" name="name"
                                        value="{{ old('name', auth()->user()->name) }}">
                                </div>
                                <div class="rs-checkout-input-item mb-16">
                                    <label class="rs-checkout-form-label">{{ __('Email') }}</label>
                                    <input class="rs-checkout-form-input" type="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                </div>
                                <div class="rs-checkout-input-item">
                                    <label class="rs-checkout-form-label">{{ __('Phone No') }}</label>
                                    <input class="rs-checkout-form-input" type="text" name="contact"
                                        value="{{ old('contact', auth()->user()->phone_no ?? '') }}">
                                </div>
                            </div>
                            <div class="rs-checkout-form-bottom p-16" data-bg-color="#F6F7F9" id="autoPayWrapper"
                                style="display:none;">
                                <div class="rs-checkout-autopay">
                                    <div class="rs-checkout-autopay-top mb-16">
                                        <h5 class="rs-checkout-autopay-title">{{ __('Auto Pay') }}</h5>
                                        <div class="rs-checkout-autopay-switch">
                                            <!-- Hidden input ensures 'false' is sent if checkbox is not checked -->
                                            <input type="hidden" name="auto_pay" value="0">

                                            <!-- Actual checkbox -->
                                            <input type="checkbox" name="auto_pay" id="autoPaySwitch" value="1"
                                                {{ old('auto_pay', false) ? 'checked' : '' }}>
                                            <label for="autoPaySwitch"></label>
                                        </div>
                                    </div>

                                    <p class="rs-checkout-autopay-text">
                                        {{ __('Thanks to Coerz\'soutstanding SEO services, we\'ve witnessed a remarkable improvement in our search engine rankings. Their expertise in keyword strategy and content optimization has led to a surge in organic traffic to our site.') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="rs-checkout-right">
                        <div class="rs-payment-summary">
                            <div class="rs-payment-header mb-16 fix">
                                <!-- Top: Days & Price -->
                                <div class="rs-payment-top d-flex align-items-center justify-content-between mb-8">
                                    <h4 class="rs-payment-days">
                                        <span
                                            id="display-days">{{ $boostPlan ? $boostPlan->sustain_days : 'Select Plan' }}</span>
                                        {{ __('Days') }}
                                    </h4>
                                    <div class="rs-payment-price" id="display-price">
                                        {{ $boostPlan
                                            ? ($boostPlan->discount_amount
                                                ? currencyFormat($boostPlan->discount_amount)
                                                : currencyFormat($boostPlan->payable_amount))
                                            : '0.00' }}

                                    </div>
                                </div>

                                <!-- Bottom: Name & Dropdown -->
                                <div class="rs-payment-bottom d-flex align-items-center justify-content-between">
                                    <h5 class="rs-payment-title-2" id="display-name">
                                        {{ $boostPlan ? $boostPlan->name : 'Select Plan' }}
                                    </h5>

                                    <!-- Dropdown -->
                                    <div class="rs-payment-change p-relative">
                                        <select id="plan" name="boost_plan_id"
                                            class="rs-payment-change-item-select">
                                            <option value="">{{ __('Change Item') }}</option>
                                            @foreach ($allBoostPlans as $plan)
                                                <option value="{{ $plan->id }}"
                                                    data-days="{{ $plan->sustain_days }}"
                                                    data-price="{{ $plan->discount_amount ?? $plan->payable_amount }}"
                                                    data-name="{{ $plan->name }}"
                                                    {{ $boostPlan && $boostPlan->id == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->sustain_days }} Day{{ $plan->sustain_days > 1 ? 's' : '' }}
                                                    -
                                                    {{ $plan->discount_amount ? number_format($plan->discount_amount, 2) : number_format($plan->payable_amount, 2) }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="rs-checkout-right-center">
                                <div class="rs-service-summary" data-tax-type="{{ $taxData->type ?? 'percentage' }}"
                                    data-tax-value="{{ $taxData->value ?? 0 }}">
                                    <h5 class="rs-service-summary-title">{{ __('Service Summary') }}</h5>

                                    <div class="rs-summary-col p-16">
                                        <div class="rs-summary-row d-flex align-items-center justify-content-between">
                                            <span>{{ __('Service Price') }}</span>
                                            <input type="hidden" name="service_price" id="service-price-hidden"
                                                value="{{ $boostPlan ? $boostPlan->discount_amount ?? $boostPlan->payable_amount : 0 }}">
                                            <span id="service-price" name="service-price">
                                                {{ $boostPlan ? ($boostPlan->discount_amount ? number_format($boostPlan->discount_amount, 2) : number_format($boostPlan->payable_amount, 2)) : '0.00' }}
                                            </span>
                                        </div>

                                        <div class="rs-summary-row tex d-flex align-items-center justify-content-between">
                                            <input type="hidden" name="service_tax" id="service-tax-hidden"
                                                value="0">

                                            <span>
                                                {{ __('Tax ') }}
                                                (
                                                @if (($taxData->type ?? 'percentage') === 'percentage')
                                                    {{ $taxData->value ?? 0 }}%
                                                @else
                                                    {{ number_format($taxData->value ?? 0, 2) }}
                                                @endif
                                                )
                                            </span>



                                            <span id="service-tax" name="service-tax">0.00</span>
                                        </div>
                                        <div
                                            class="rs-summary-row total d-flex align-items-center justify-content-between">
                                            <input type="hidden" name="service_total" id="service-total-hidden"
                                                value="{{ $boostPlan ? $boostPlan->payable_amount : 0 }}">
                                            <span>{{ __('Total') }}</span>
                                            <span id="service-total"
                                                name="service-total">{{ $boostPlan ? number_format($boostPlan->payable_amount, 2) : '0.00' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rs-checkout-payment-method p-16">
                                    <h5 class="rs-checkout-payment-method-title">{{ __('Payment Method') }}</h5>

                                    {{-- Hidden input to store selected payment method ID --}}
                                    <input type="hidden" name="payment_gateway_id" id="payment_gateway_id">
                                    <input type="hidden" id="is_wallet" name="is_wallet" value="0">

                                    <div class="rs-method-buttons gap-16 mb-3 d-flex">
                                        @foreach ($paymentGateways as $gateway)
                                            @if ($gateway->is_active)
                                                <button type="button" class="rs-payment-method-img-btn payment-btn"
                                                    data-id="{{ $gateway->id }}">
                                                    <img src="{{ $gateway->imagePath }}"
                                                        alt="{{ ucfirst($gateway->name) }}">
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="text-center mb-3 fw-bold">Or</div>
                                    <!-- Wallet Button -->
                                    <button type="button"
                                        class="btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2 payment-btn rs-payment-method-img-btn payment-btn"
                                        data-id="null" id="walletBtn">
                                        <i class="fas fa-wallet me-2"></i> {{ __('Use Wallet') }}
                                    </button>

                                </div>
                                <div class="rs-payment-actions d-flex align-items-center justify-content-between gap-16 p-16"
                                    data-bg-color="#F6F7F9">
                                    {{-- <button type="button" class="rs-payment-cancel">{{ __('Cancel ') }}</button> --}}

                                    <a href="{{ route('user.my-ads') }}" class="rs-payment-cancel" style="padding-top: 10px;">
                                        {{ __('Cancel') }}
                                    </a>

                                    <button type="submit" class="rs-payment-proceed rs-btn" id="submitBtn">
                                        <span class="btn-icon">
                                            <i class="bi bi-credit-card"></i>
                                        </span>

                                        <span class="btn-text">
                                            {{ __('Proceed Payment') }}
                                        </span>

                                        <span class="btn-loader d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Processing...
                                        </span>
                                    </button>

                                </div>

                            </div>

                            <div class="rs-note-box mt-16" id="paypleNoteBox" style="display: none;">
                                <span>{{ __('Note') }}<b>*</b></span>
                                <div class="bg-light border rounded p-3 mt-3 small">

                                    <div class="alert alert-warning border-start border-warning border-5 mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>{{ __('PayPal Currency Info') }}:</strong>
                                        @if (
                                            !in_array(strtoupper(env('CURRENCY')), [
                                                'USD',
                                                'EUR',
                                                'GBP',
                                                'AUD',
                                                'CAD',
                                                'JPY',
                                                'CHF',
                                                'SEK',
                                                'NOK',
                                                'DKK',
                                                'PLN',
                                                'CZK',
                                                'HUF',
                                                'ILS',
                                                'MXN',
                                                'BRL',
                                                'MYR',
                                                'PHP',
                                                'TWD',
                                                'THB',
                                                'NZD',
                                                'SGD',
                                                'HKD',
                                                'CNY',
                                            ]))
                                            <span class="text-danger">
                                                {{ __(' PayPal does not support') }}
                                                <strong>{{ strtoupper(env('CURRENCY')) }}</strong>.
                                                {{ __('Please use') }} <strong>{{ __('Wallet') }}</strong>
                                                {{ __('or another gateway') }}.
                                            </span>
                                        @else
                                            {{ __('PayPal supports your currency') }}
                                            (<strong>{{ strtoupper(env('CURRENCY')) }}</strong>)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </form>
        </div>
    @endsection
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.payment-btn');
                const paymentMethod = document.getElementById('payment_gateway_id');
                const isWallet = document.getElementById('is_wallet');

                // Handle Payment / Wallet Click
                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        buttons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        let id = this.getAttribute('data-id');

                        if (id === 'null') {
                            paymentMethod.value = ""; // no gateway
                            isWallet.value = 1; // wallet selected
                        } else {
                            paymentMethod.value = id; // gateway selected
                            isWallet.value = 0; // wallet not selected
                        }

                        console.log("Gateway:", paymentMethod.value, "Wallet:", isWallet.value);
                    });
                });

                // Validate Before Submit
                const form = document.getElementById('checkoutForm');
                form.addEventListener('submit', function(e) {

                    // jodi kono payment method select na hoy
                    if (paymentMethod.value === "" && isWallet.value !== "1") {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Select Payment Method',
                            text: 'Please choose a payment gateway or wallet to proceed.',
                            confirmButtonColor: '#ff6a00'
                        });

                        return false;
                    }
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const select = document.getElementById('plan');
                const displayDays = document.getElementById('display-days');
                const displayPrice = document.getElementById('display-price');
                const displayName = document.getElementById('display-name');

                select.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const days = selected.getAttribute('data-days') || 'Select Plan';
                    const price = selected.getAttribute('data-price') || '0.00';
                    const name = selected.getAttribute('data-name') || 'Select Plan';

                    displayDays.textContent = days;
                    displayPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
                    displayName.textContent = name;
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const planSelect = document.getElementById('plan');
                const priceEl = document.getElementById('service-price');
                const priceHidden = document.getElementById('service-price-hidden');
                const taxEl = document.getElementById('service-tax');
                const totalEl = document.getElementById('service-total');
                const taxHidden = document.getElementById('service-tax-hidden');
                const totalHidden = document.getElementById('service-total-hidden');

                const summary = document.querySelector('.rs-service-summary');
                const taxType = summary.dataset.taxType;
                const taxValue = parseFloat(summary.dataset.taxValue) || 0;

                function updateSummary(price) {
                    let taxAmount = 0;
                    if (taxType === 'percentage') {
                        taxAmount = price * (taxValue / 100);
                    } else if (taxType === 'flat') {
                        taxAmount = taxValue;
                    }

                    // Update display
                    priceEl.textContent = price.toFixed(2);
                    taxEl.textContent = taxAmount.toFixed(2);
                    totalEl.textContent = (price + taxAmount).toFixed(2);

                    // Update hidden inputs
                    priceHidden.value = price;
                    taxHidden.value = taxAmount.toFixed(2);
                    totalHidden.value = (price + taxAmount).toFixed(2);
                }

                // Initialize summary on page load
                updateSummary(parseFloat(priceHidden.value) || 0);

                // Update when plan changes
                planSelect.addEventListener('change', function() {
                    const selectedOption = this.selectedOptions[0];
                    if (!selectedOption || !selectedOption.dataset.price) return;

                    const newPrice = parseFloat(selectedOption.dataset.price) || 0;
                    updateSummary(newPrice);
                });
            });
        </script>

        {{-- calculation tax and total --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const priceEl = document.getElementById('service-price');
                const taxEl = document.getElementById('service-tax');
                const totalEl = document.getElementById('service-total');

                const priceHidden = document.getElementById('service-price-hidden');
                const taxHidden = document.getElementById('service-tax-hidden');
                const totalHidden = document.getElementById('service-total-hidden');

                const summary = document.querySelector('.rs-service-summary');
                const taxType = summary.dataset.taxType;
                const taxValue = parseFloat(summary.dataset.taxValue) || 0;

                let price = parseFloat(priceEl.textContent.replace(/,/g, '')) || 0;
                let taxAmount = 0;

                if (taxType === 'percentage') {
                    taxAmount = price * (taxValue / 100);
                } else if (taxType === 'flat') {
                    taxAmount = taxValue;
                }

                // Update frontend display
                taxEl.textContent = taxAmount.toFixed(2);
                totalEl.textContent = (price + taxAmount).toFixed(2);

                // Update hidden inputs for backend
                priceHidden.value = price;
                taxHidden.value = taxAmount.toFixed(2);
                totalHidden.value = (price + taxAmount).toFixed(2);
            });
        </script>

        {{-- modal --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('error'))
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "{{ session('error') }}",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Okay"
                    });
                @endif
            });
        </script>

        {{-- auto pay show-hide --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.payment-btn');
                const hiddenInput = document.getElementById('payment_gateway_id');
                const autoPayWrapper = document.getElementById('autoPayWrapper');

                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        buttons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        let id = this.getAttribute('data-id');

                        // If wallet, store null (empty string)
                        hiddenInput.value = (id === 'null') ? '' : id;

                        // Show Auto Pay only if wallet is selected
                        if (id === 'null') {
                            autoPayWrapper.style.display = 'block';
                        } else {
                            autoPayWrapper.style.display = 'none';
                            // Uncheck Auto Pay when hiding
                            document.getElementById('autoPaySwitch').checked = false;
                        }


                    });
                });
            });
        </script>
        {{-- open open popup window --}}
        <script>
            $(document).ready(function() {
                const successModal = document.querySelector('#successModal');

                const openPaymentPopupWindow = (url, debug = false) => {
                    if (debug) console.log(`Opening payment window: ${url}`);

                    const winWidth = 700;
                    const winHeight = 700;
                    const left = screen.width / 2 - winWidth / 2;
                    const top = screen.height / 2 - winHeight / 2;

                    const options = `resizable,height=${winHeight},width=${winWidth},top=${top},left=${left}`;
                    const win = window.open(url, "_blank", options);

                    if (!win) {
                        if (debug) console.error("Failed to open payment window");
                        alert("Popup blocked! Please allow popups.");
                        return;
                    }

                    win.document.title = "Payment Window Screen - Make Payment";

                    let intervalID = null;

                    const handleWindowClose = (status) => {
                        if (debug) console.log(`Closing popup with status: ${status}`);
                        if (win && !win.closed) {
                            win.close();
                        }
                    };

                    const trackWindow = () => {
                        try {
                            if (win.closed) {
                                if (debug) console.log("Window manually closed");
                                clearInterval(intervalID);
                                handleWindowClose("closed");
                                return;
                            }

                            const currentHost = location.host;

                            // Only check if same-origin
                            if (win.location.host === currentHost) {
                                const pathname = win.location.pathname;

                                if (pathname.includes("payment/success")) {
                                    clearInterval(intervalID);
                                    handleWindowClose("success");
                                    successModal.style.display = 'block';
                                } else if (pathname.includes("payment/cancel")) {
                                    clearInterval(intervalID);
                                    handleWindowClose("cancel");
                                } else if (pathname.includes("payment/fail")) {
                                    clearInterval(intervalID);
                                    handleWindowClose("fail");
                                    Swal.fire({
                                        icon: "error",
                                        title: "Payment Failed!",
                                        text: "Your payment process was unsuccessful. Please try again.",
                                    });
                                }
                            }

                        } catch (e) {
                            if (debug) console.warn(
                                "Cross-origin access blocked; cannot track status until redirect returns to same-origin."
                            );
                        }
                    };

                    intervalID = setInterval(trackWindow, 100); // check every 100ms
                    win.focus();
                };

                $("#checkoutForm").on("submit", function(e) {
                    e.preventDefault();

                    const form = $(this);
                    const actionUrl = form.attr("action");

                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {

                            if (response.data == "null" || response.data === "null") {
                                Swal.fire({
                                    icon: "error",
                                    title: "Payment Failed!",
                                    text: response
                                        .message,
                                });
                                return;
                            }

                            if (response.data && response.data.payment_url) {
                                openPaymentPopupWindow(response.data.payment_url, true);
                                return;
                            }


                            if (response.message) {
                                successModal.style.display = 'block';
                            }
                        },

                        error: function(xhr) {
                            console.log(xhr.responseText);
                            let errorMessage = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: "info",
                                title: "Insufficient Balance!",
                                confirmButtonText: "Try Again",
                                confirmButtonColor: "#e74c3c",
                                text: errorMessage,
                            });
                        }
                    });
                });

            });



            function closeModal() {
                successModal.style.display = 'none';
                errorModal.style.display = 'none';

            }
            document.querySelectorAll('.rs-payment-popup-close, .actionBtn').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            overlay.addEventListener('click', closeModal);
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paypleNoteBox = document.getElementById('paypleNoteBox');

                const PAYPLE_GATEWAY_ID = '1';

                document.querySelectorAll('.payment-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const selectedId = this.getAttribute('data-id');

                        if (selectedId === PAYPLE_GATEWAY_ID) {
                            paypleNoteBox.style.display = 'block';
                        } else {
                            paypleNoteBox.style.display = 'none';
                        }
                    });
                });

                const initiallySelected = document.querySelector('.payment-btn.active');
                if (initiallySelected) {
                    const selectedId = initiallySelected.getAttribute('data-id');
                    if (selectedId === PAYPLE_GATEWAY_ID) {
                        paypleNoteBox.style.display = 'block';
                    }
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const btn = document.getElementById('submitBtn');
                if (!btn) return;

                const form = btn.closest('form');
                if (!form) return;

                form.addEventListener('submit', function() {

                    btn.querySelector('.btn-text').classList.add('d-none');
                    btn.querySelector('.btn-icon').classList.add('d-none');
                    btn.querySelector('.btn-loader').classList.remove('d-none');
                    setTimeout(() => {
                        btn.querySelector('.btn-text').classList.remove('d-none');
                        btn.querySelector('.btn-icon').classList.remove('d-none');
                        btn.querySelector('.btn-loader').classList.add('d-none');
                    }, 2000);


                });

            });
        </script>
    @endpush
