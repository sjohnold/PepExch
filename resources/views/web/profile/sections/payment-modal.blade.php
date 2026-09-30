    <div id="paymentModal" class="rs-product-make-offer rs-Payment-modal" style="display:none;">
        <div class="rs-product-make-offer-content  rs-Payment-content w-100">
            <div class="rs-payment-img text-center mb-24">
                <img src="{{asset('assets/frontend/img/wallet/wallet-01.svg')}}" alt="">
            </div>
            <button class="rs-product-make-offer-close" id="closePayment"><i class="fas fa-times"></i></button>
            <h2 class="rs-payment-title text-center">{{ __('Add Payment Method ') }}</h2>
            <p class="text-center rs-payment-text">{{ __('Top up your wallet securely and enjoy seamless payments.') }}</p>

            <div class="rs-payment-method-select-box mb-16">
                <label for="paymentMethod">{{ __('Select Payment Method') }}</label>
                <div class="custom-select p-relative">
                    <img class="p-absolute" src="{{asset('assets/frontend/img/icon/stripe 1.svg')}}" alt="">
                    <select id="paymentMethod">
                        <option value="stripe" selected>
                            {{ __(' Stripe') }}
                        </option>
                        <option value="paypal">{{ __('PayPal') }}</option>
                        <option value="bkash">{{ __('bKash') }}</option>
                        <option value="nagad">{{ __('Nagad') }}</option>
                    </select>
                </div>
            </div>
            <div class="rs-Payment-modal-form">
                <form action="#">
                    <div class="rs-Payment-modal-input-item">
                        <label>{{ __('Cardholder Name') }}</label>
                        <input type="text" placeholder="Write name">
                    </div>
                    <div class="rs-Payment-modal-input-item">
                        <label>{{ __('Card Number') }}</label>
                        <input type="text" placeholder="Write card no">
                    </div>
                    <div class="rs-Payment-modal-input-item p-relative">
                        <img id="calendarIcon" class="p-absolute rs-date-img" src="{{asset('assets/frontend/img/icon/calendar 01.svg')}}"
                            alt="">
                        <label>{{ __('Exp. Date') }}</label>
                        <input type="text" id="expDate" placeholder="10/02/2025" readonly>
                    </div>
                    <div class="rs-Payment-modal-input-item">
                        <label>{{ __('CVV') }}</label>
                        <input type="text" placeholder="123">
                    </div>
                    <div class="rs-payment-method-select-box w-100">
                        <label for="paymentMethod">{{ __('Select Payment Method') }}</label>
                        <div class="custom-select p-relative">
                            <select id="paymentMethod" class="selact-cuntry">
                                <option value="stripe" selected>
                                    {{ __('Bangladesh') }}
                                </option>
                                <option value="paypal">{{ __('India') }}</option>
                                <option value="bkash">{{ __('Iraq') }}</option>
                                <option value="nagad">{{ __('Iraq') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="rs-payment-method-btn d-flex align-items-center gap-16 w-100">
                        <button class="rs-btn rs-btn-2 rs-payment-method-cancel-btn"
                            data-bg-color="#F6F7F9">{{ __('Cancel') }}</button>
                        <button class="rs-btn">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tp-offcanvas-overlay"></div>
    </div>