{{-- OFFER MODAL – real <form> --}}
<div id="offerModal" class="rs-product-make-offer" style="display:none;">
    <div class="rs-product-make-offer-content">
        <button type="button" class="rs-product-make-offer-close" id="closeOffer">
            <i class="fas fa-times"></i>
        </button>

        <h2 class="rs-product-make-offer-title">{{ __('Make Offer') }}</h2>
        <p>{{ __('Buy smarter. Make an offer and get the best deal') }}.</p>

        <form action="{{ route('make.offer') }}" method="POST">
            @csrf
            <input type="hidden" name="receiver_id" id="offer_receiver_id">
            <input type="hidden" name="selling_post_id" id="offer_selling_post_id">
            <input type="hidden" name="product_name" id="offer_product_name">

            <label>{{ __('Set Your Price') }}</label>
            <input type="number" name="offer_price" id="offer_price" placeholder="Please Enter Your Price ($30)" required>

            <label>{{ __('Message ') }}</label>
            <textarea name="offer_message" id="offer_message" placeholder="Write your message" required></textarea>

            <button type="submit" id="submitOfferBtn" class="rs-btn-primary">
                {{ __('Submit Offer') }}
            </button>
        </form>
    </div>
</div>
