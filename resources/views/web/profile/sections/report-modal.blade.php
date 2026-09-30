    <div id="reportModal" class="rs-product-make-offer" style="display:none;">
        <div class="rs-product-make-offer-content">
            <button class="rs-product-make-offer-close" id="closeReport">
                <i class="fas fa-times"></i>
            </button>

            <h2 class="rs-product-make-offer-title"> {{ __('Report Review') }}</h2>
            <p>{{ __('Buy smarter. Make an offer and get the best deal.') }}</p>

            <div class="form-group mb-20">
                <label for="reportReason" class="d-block mb-8">{{ __('Report type') }}</label>
                <select id="reportReason">
                    <option value="" disabled selected>{{ __('Fake Review') }}</option>
                    <option value="fake">{{ __('Fake Product') }}</option>
                    <option value="scam">{{ __('Scam / Fraud') }}</option>
                    <option value="misleading">{{ __('Misleading Information') }}</option>
                    <option value="other">{{ __('Other') }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="reportMessage">{{ __('Details') }}</label>
                <textarea id="reportMessage" placeholder="Write Details"></textarea>
            </div>

            <div class="rs-payment-method-btn d-flex align-items-center gap-16 w-100">
                <button class="rs-btn">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>