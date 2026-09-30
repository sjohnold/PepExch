@props(['product', 'wishlistIds'])
<div class="rs-product-box">

    <div class="rs-product-thumb p-relative">
        <a class="popup-image" href="{{ $product->profilePath ?? asset('assets/frontend/img/product/default.png') }}">
            <img src="{{ $product->profilePath ?? asset('assets/frontend/img/product/default.png') }}" alt="">
        </a>



        {{-- This Section is Recreated --}}
        <div class="rs-product-thumb-loves p-absolute">
            <a href="#"
                onclick="return confirmAlert(event, '{{ route('wishlist.add', $product->id) }}', {{ in_array($product->id, getWishlistIds() ?? []) ? 'true' : 'false' }})"
                class="rs-product-details-price-contact-icon-bg d-flex align-items-center justify-content-center">

                <svg class="love-icon {{ in_array($product->id, getWishlistIds() ?? []) ? 'active' : '' }}"
                    xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 22" fill="none">
                    <path
                        d="M12 21C11.7 21 11.4 20.93 11.15 20.8C7.2 18.75 1 14.28 1 8.5C1 5.42 3.42 3 6.5 3C8.24 3 9.91 3.81 11 5.08C12.09 3.81 13.76 3 15.5 3C18.58 3 21 5.42 21 8.5C21 14.28 14.8 18.75 10.85 20.8C10.6 20.93 10.3 21 10 21H12Z"
                        stroke="#17181D" stroke-width="2" fill="none" />
                </svg>
            </a>
        </div>

    </div>


    <div class="rs-product-content">
        <div class="rs-product-location">
            <a href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                    fill="none">
                    <path
                        d="M7 0.6875C3.38125 0.6875 0.4375 3.63125 0.4375 7.25C0.4375 11.0885 3.96024 13.415 6.29124 14.9547L6.688 15.218C6.7825 15.281 6.89125 15.3125 7 15.3125C7.10875 15.3125 7.2175 15.281 7.312 15.218L7.70876 14.9547C10.0398 13.415 13.5625 11.0885 13.5625 7.25C13.5625 3.63125 10.6187 0.6875 7 0.6875ZM7.08925 14.0157L7 14.0751L6.91075 14.0157C4.65325 12.5247 1.5625 10.4832 1.5625 7.25C1.5625 4.2515 4.0015 1.8125 7 1.8125C9.9985 1.8125 12.4375 4.2515 12.4375 7.25C12.4375 10.4832 9.346 12.5255 7.08925 14.0157ZM7 4.8125C5.656 4.8125 4.5625 5.906 4.5625 7.25C4.5625 8.594 5.656 9.6875 7 9.6875C8.344 9.6875 9.4375 8.594 9.4375 7.25C9.4375 5.906 8.344 4.8125 7 4.8125ZM7 8.5625C6.27625 8.5625 5.6875 7.97375 5.6875 7.25C5.6875 6.52625 6.27625 5.9375 7 5.9375C7.72375 5.9375 8.3125 6.52625 8.3125 7.25C8.3125 7.97375 7.72375 8.5625 7 8.5625Z"
                        fill="#358CEF" />
                </svg>
                <span>{{ Str::limit(getLocationName($product->latitude, $product->longitude), 15, '...') }}</span>
            </a>
        </div>

        <a href="{{ route('product-details', $product->id) }}">
            <h3 class="rs-product-title" title="{{ $product->name ?? 'Untitled Product' }}">
                {{ substr($product->name ?? 'Untitled Product', 0, 40) }}{{ strlen($product->name ?? '') > 40 ? '...' : '' }}
            </h3>
        </a>


        <a href="javascript:void(0)" class="rs-product-condition">
            {{ __('Condition') }}: <span>{{ $product->conditions ?? 'N/A' }}</span>
        </a>

        <div class="rs-product-price d-flex align-items-center justify-content-between mb-12">
            <b>{{ currencyFormat($product->asking_price) ?? '0.00' }}</b>
            <span class="rs-product-time">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                    fill="none">
                    <path
                        d="M9 0.9375C4.554 0.9375 0.9375 4.554 0.9375 9C0.9375 13.446 4.554 17.0625 9 17.0625C13.446 17.0625 17.0625 13.446 17.0625 9C17.0625 4.554 13.446 0.9375 9 0.9375ZM9 15.9375C5.17425 15.9375 2.0625 12.8258 2.0625 9C2.0625 5.17425 5.17425 2.0625 9 2.0625C12.8258 2.0625 15.9375 5.17425 15.9375 9C15.9375 12.8258 12.8258 15.9375 9 15.9375ZM11.6475 10.8525C11.8673 11.0722 11.8673 11.4285 11.6475 11.6483C11.538 11.7578 11.394 11.8132 11.25 11.8132C11.106 11.8132 10.962 11.7585 10.8525 11.6483L8.60248 9.39825C8.49673 9.2925 8.4375 9.14923 8.4375 9.00073V5.25073C8.4375 4.94023 8.6895 4.68823 9 4.68823C9.3105 4.68823 9.5625 4.94023 9.5625 5.25073V8.76746L11.6475 10.8525Z"
                        fill="#687387" />
                </svg>
                {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}
            </span>
        </div>

        <div class="rs-product-btn d-flex align-items-center justify-content-between mt-auto">
            @if($product->is_sold)
                <button class="rs-product-details-btn d-flex align-items-center justify-content-center"
                    disabled>
                    {{ __('Sold Out') }}
                </button>
            @else
                <a href="{{ route('product-details', $product->id) }}"
                    class="rs-product-details-btn d-flex align-items-center justify-content-center">
                    {{ __('View Details') }}
                </a>
            @endif

            @auth
                @if ($product->user_id && $product->user_id != auth()->id())
                    <button class="makeOfferBtn rs-product-offer-btn d-flex align-items-center justify-content-center"
                        onclick="openOfferModal({{ $product->user_id }}, '{{ addslashes($product->name) }}', {{ $product->id }})">
                        {{ __('Make Offer') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M8.5 11L12.5 11" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M8.5 16H16.5" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M21.5 9V18C21.5 20.2091 19.7091 22 17.5 22H7.5C5.29086 22 3.5 20.2091 3.5 18V6C3.5 3.79086 5.29086 2 7.5 2H14.5M21.5 9L14.5 2M21.5 9H18.5C16.2909 9 14.5 7.20914 14.5 5V2" stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </button>
                @endif
            @else
                <button class="rs-product-offer-btn d-flex align-items-center justify-content-center"
                    onclick="event.stopPropagation(); toggleModal('sign_in_popup');">
                    {{ __('Make Offer') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path d="M8.5 11L12.5 11" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M8.5 16H16.5" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M21.5 9V18C21.5 20.2091 19.7091 22 17.5 22H7.5C5.29086 22 3.5 20.2091 3.5 18V6C3.5 3.79086 5.29086 2 7.5 2H14.5M21.5 9L14.5 2M21.5 9H18.5C16.2909 9 14.5 7.20914 14.5 5V2" stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </button>
            @endauth
        </div>
    </div>
</div>


@push('script')
    <script>
        function openOfferModal(receiverId, productName, sellingPostId) {
            // Populate hidden fields
            document.getElementById('offer_receiver_id').value = receiverId;
            document.getElementById('offer_product_name').value = productName;
            document.getElementById('offer_selling_post_id').value = sellingPostId;

            // Optionally, you can clear previous offer values
            document.getElementById('offer_price').value = '';
            document.getElementById('offer_message').value = '';

            // Show modal
            document.getElementById('offerModal').style.display = 'block';
        }

        document.getElementById('closeOffer').addEventListener('click', function() {
            document.getElementById('offerModal').style.display = 'none';
        });
    </script>
@endpush
