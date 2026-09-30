@extends('web.profile.profile-master')
@section('my-wallet')
    {{-- add balance --}}
    <form action="{{ url('/api/boostplan/checkout') }}" method="POST" id="addBalanceModal" name="checkoutForm"
        class="rs-product-make-offer checkoutForm" style="display:none;">
        @csrf
        <div class="rs-product-make-offer-content">
            <button type="button" class="rs-product-make-offer-close" id="closeAddBalance">
                <i class="fas fa-times"></i>
            </button>

            <div class="wallet-balance-modal">
                <div class="rs-payment-img text-center mb-24">
                    <img src="{{ asset('assets/frontend/img/wallet/wallet-02.svg') }}" alt="">
                </div>

                <h2 class="rs-payment-title text-center">{{ __('Add Payment Method') }}</h2>
                <p class="text-center rs-payment-text">
                    {{ __('Top up your wallet securely and enjoy seamless payments') }}.
                </p>

                <div class="rs-payment-method-select-box mb-16">
                    <label for="paymentMethod">{{ __('Select Payment Method') }}</label>
                    <select id="paymentMethod" name="payment_gateway_id" required class="form-select">
                        @foreach ($payment_methods as $method)
                            @if ($method->is_active)
                                <option value="{{ $method->id }}" data-icon="{{ $method->imagePath }}"
                                    {{ $loop->first ? 'selected' : '' }}>
                                    {{ ucfirst($method->name) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">{{ __('Set Amount') }}</label>
                    <input type="text" id="amount" name="amount" placeholder="Enter Amount" required>
                    <input hidden type="text" id="userId" name="user_id" value="{{ auth()->id() }}" required>
                </div>

                <div class="rs-payment-method-btn d-flex align-items-center gap-16 w-100">
                    <button type="button" class="rs-btn rs-btn-2 rs-payment-method-cancel-btn" data-bg-color="#F6F7F9"
                        id="cancelAddBalance">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="add-btn rs-btn">{{ __('Add Balance') }}</button>
                </div>
            </div>
        </div>
    </form>

    {{-- end balance --}}
    <div class="">
        <div class="rs-profile-head  d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('My Wallet') }}
            </h2>

        </div>

        <div class="rs-profile-note p-16 br-8 mb-32" data-bg-color="#FDF3F3">
            <h5 class="rs-profile-note-title">
                {{ __('Note') }} <span>*</span>
            </h5>
            <p>{{ __('Thanks to Coerzs outstanding SEO services, weve witnessed a remarkable improvement in our search engine rankings. Their expertise in keyword strategy and content optimization has led to a surge in organic traffic to our site.') }}
            </p>
        </div>

        <div class="rs-wallet mb-24">
            <div class="rs-wallet-wrapper gap-24 br-8" data-bg-img="{{ asset('assets/frontend/img/bg/wallet-bg.jpg') }}">
                <div class="rs-wallet-card rs-wallet-card-2  p-16 br-8 p-relative">
                    <img class="br-8" src="{{ asset('assets/frontend/img/bg/card-01.jpg') }}" alt="">
                    <div class="rs-wallet-card-content p-absolute">
                        <div class="rs-wallet-balance-show d-flex gap-16 align-items-center">
                            <svg class="wallet-logo" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M17.0833 18.3333C17.0833 21.3167 19.5167 23.75 22.5 23.75H30V25C30 28.3333 28.3333 30 25 30H5C1.66667 30 0 28.3333 0 25V3.33333C0 5.16667 1.5 6.66667 3.33333 6.66667H25C28.3333 6.66667 30 8.33333 30 11.6667V12.9167H22.5C19.5167 12.9167 17.0833 15.35 17.0833 18.3333ZM22.5 15.4167C20.9 15.4167 19.5833 16.7333 19.5833 18.3333C19.5833 19.9333 20.9 21.25 22.5 21.25H30V15.4167H22.5ZM23.3667 20C22.45 20 21.6833 19.25 21.6833 18.3333C21.6833 17.4167 22.4333 16.6667 23.35 16.6667H23.3667C24.2834 16.6667 25.0334 17.4167 25.0334 18.3333C25.0334 19.25 24.2834 20 23.3667 20ZM20 0H4.58333C3.43333 0 2.5 0.933333 2.5 2.08333C2.5 3.23333 3.43333 4.16667 4.58333 4.16667H24.95C24.7 1.38333 23.05 0 20 0Z"
                                    fill="white" />
                            </svg>
                            <h4 class="rs-wallet-balance">
                                {{ __('$' . number_format($wallet->balance ?? 0, 2)) }}
                            </h4>
                        </div>
                        <div class="rs-wallet-balance-text d-flex align-items-center gap-93">
                            <p>
                                {{ __('Wallet Remaining Balance') }}
                            </p>
                            <a href="javascript:void(0)" class="rs-wallet-balance-add">
                                <span>{{ __('Add Balance') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none">
                                    <path
                                        d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="fix rs-wallet-items">
                    <div class="rs-wallet-box gap-24 d-flex align-items-center ">
                        <div class="rs-wallet-card rs-wallet-card-1  p-16 br-8 p-relative">
                            <img class="br-8" src="{{ asset('assets/frontend/img/bg/card-01.jpg') }}" alt="">
                            <div class="rs-wallet-card-content p-absolute">
                                <div class="rs-wallet-balance-show d-flex gap-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                        viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M17.0833 18.3333C17.0833 21.3167 19.5167 23.75 22.5 23.75H30V25C30 28.3333 28.3333 30 25 30H5C1.66667 30 0 28.3333 0 25V3.33333C0 5.16667 1.5 6.66667 3.33333 6.66667H25C28.3333 6.66667 30 8.33333 30 11.6667V12.9167H22.5C19.5167 12.9167 17.0833 15.35 17.0833 18.3333ZM22.5 15.4167C20.9 15.4167 19.5833 16.7333 19.5833 18.3333C19.5833 19.9333 20.9 21.25 22.5 21.25H30V15.4167H22.5ZM23.3667 20C22.45 20 21.6833 19.25 21.6833 18.3333C21.6833 17.4167 22.4333 16.6667 23.35 16.6667H23.3667C24.2834 16.6667 25.0334 17.4167 25.0334 18.3333C25.0334 19.25 24.2834 20 23.3667 20ZM20 0H4.58333C3.43333 0 2.5 0.933333 2.5 2.08333C2.5 3.23333 3.43333 4.16667 4.58333 4.16667H24.95C24.7 1.38333 23.05 0 20 0Z"
                                            fill="white" />
                                    </svg>
                                    <h4 class="rs-wallet-balance">
                                        {{ currencyFormat(number_format($wallet->balance ?? 0, 2))}}
                                    </h4>
                                </div>
                                <div class="rs-wallet-balance-text d-flex align-items-center gap-93">
                                    <p>
                                        {{ __('Wallet Remaining Balance') }}
                                    </p>
                                    <a href="javascript:void(0)" class="rs-wallet-balance-add">
                                        <span>{{ __('Add Balance') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="rs-transaction-wrapper">
            <h3 class="rs-transaction-title br-8 mb-16 p-16 pt-17 pb-17" data-bg-color="#F6F7F9">
                {{ __('Transaction History') }}
            </h3>

            <div class="rs-transaction-card-body p-16 br-8" data-bg-color="#F6F7F9">

                @forelse ($transactions as $transaction)
                    <div class="rs-transaction-card p-16 br-8" data-bg-color="#fff"
                        style="display:grid; grid-template-columns: repeat(6, 1fr); gap:16px; align-items:center;">

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Transaction ID') }}</div>
                            <div class="value">{{ $transaction->identifier }}</div>
                        </div>

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Name') }}</div>
                            <div class="value">{{ $transaction->user->name }}</div>
                        </div>

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Payment Method') }}</div>
                            <div class="value">{{ $transaction->payment_method->name ?? 'N/A' }}</div>
                        </div>

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Amount') }}</div>
                            <div class="value">{{ number_format($transaction->amount, 2) }}</div>
                        </div>

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Date') }}</div>
                            <div class="value">{{ $transaction->created_at->format('d/m/Y') }}</div>
                        </div>

                        <div class="rs-transaction-item">
                            <div class="label">{{ __('Status') }}</div>
                            <div class="value">
                                @if ($transaction->status === 'pending')
                                    <span class="badge bg-danger">Cancel</span>
                                @else
                                    <span class="badge bg-success">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                @empty
                    <div class="text-center p-24 br-8 ">
                        <strong>{{ __('No Transaction Found') }}</strong>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if ($transactions->count())
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

    <div id="successModal" class="rs-payment-popup" style="display:none;">
        <div class="rs-payment-popup-content text-center p-relative">
            <button type="button" class="rs-payment-popup-close rs-payment-popup-close-main"><i
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
    </div>
@endsection



@push('script')
    <script>
        $(document).ready(function() {


            const successModal = $('#successModal');


            function closeSuccessModalAndRefresh() {
                successModal.hide();

                setTimeout(function() {
                    window.location.reload(true);
                }, 200);
            }

            /* ===============================
               PAYMENT POPUP HANDLER
            ================================ */
            const closeAllPaymentModals = () => {
                $('#addBalanceModal').hide();
                $('#paymentModal').hide();
                $('.tp-offcanvas-overlay').hide();
            };

            const openPaymentPopupWindow = (url, debug = false) => {

                const winWidth = 700;
                const winHeight = 700;
                const left = screen.width / 2 - winWidth / 2;
                const top = screen.height / 2 - winHeight / 2;

                const options = `resizable,height=${winHeight},width=${winWidth},top=${top},left=${left}`;
                const win = window.open(url, "_blank", options);

                if (!win) {
                    alert("Popup blocked! Please allow popups.");
                    return;
                }

                let intervalID = null;

                const handleWindowClose = () => {
                    if (win && !win.closed) {
                        win.close();
                    }
                    closeAllPaymentModals();
                };

                const trackWindow = () => {
                    try {
                        if (win.closed) {
                            clearInterval(intervalID);
                            handleWindowClose();
                            return;
                        }

                        if (win.location.host === location.host) {
                            const path = win.location.pathname;

                            if (path.includes("payment/success")) {
                                clearInterval(intervalID);
                                handleWindowClose();
                                successModal.show();
                            }

                            if (path.includes("payment/cancel")) {
                                clearInterval(intervalID);
                                handleWindowClose();
                            }

                            if (path.includes("payment/fail")) {
                                clearInterval(intervalID);
                                handleWindowClose();
                                Swal.fire({
                                    icon: "error",
                                    title: "Payment Failed!",
                                    text: "Your payment process was unsuccessful. Please try again.",
                                });
                            }
                        }
                    } catch (e) {}
                };

                intervalID = setInterval(trackWindow, 100);
                win.focus();
            };

            /* ===============================
               CHECKOUT FORM SUBMIT
            ================================ */
            $(".checkoutForm").on("submit", function(e) {
                e.preventDefault();

                const form = $(this);

                $.ajax({
                    type: "POST",
                    url: form.attr("action"),
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form.serialize(),
                    dataType: "json",

                    success: function(response) {
                        if (response?.data?.payment_url) {
                            openPaymentPopupWindow(response.data.payment_url);
                        } else {
                            successModal.show();
                        }
                    },

                    error: function(xhr) {
                        const response = JSON.parse(xhr.responseText);
                       Swal.fire({
                            icon: "info",
                            title: "Insufficient Balance!",
                            text: response.message,
                            confirmButtonText: "Try Again",
                            confirmButtonColor: "#e74c3c",
                        });
                    }
                });
            });




            //  close icon
            $(document).on('click', '.rs-payment-popup-close', function() {
                closeSuccessModalAndRefresh();
            });

            // Back Home button
            $(document).on('click', '.actionBtn', function(e) {
                e.preventDefault();
                closeSuccessModalAndRefresh();
            });

            //click outside modal
            $(document).on('click', '#successModal', function(e) {
                if (e.target.id === 'successModal') {
                    closeSuccessModalAndRefresh();
                }
            });

        });

        // Amount validation

    </script>
@endpush
