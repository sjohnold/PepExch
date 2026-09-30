<div class="rs-product-head-bottom d-flex align-items-center gap-16 w-100 justify-content-between mb-24">
    <div class="rs-product-price-menu rs-product-price-menu-2">
        <ul>
            <li style="width: 195px">
                <div class="rs-product-price-dropdown rs-product-price-dropdown-2">
                    <ul>
                        <li>
                            <a href="{{ route('seller-info', [
                                'id' => $user->id,
                                'tab' => 'posts',
                                'product_id' => request()->query('product_id')
                            ]) }}"
                                class="{{ !request()->has(['low_to_high', 'high_to_low', 'recent-item']) ? 'active' : '' }}">
                                {{ __('All') }}
                            </a>

                            <a href="{{ route('seller-info', [
                                'id' => $user->id,
                                'tab' => 'posts',
                                'product_id' => request()->query('product_id'),
                                'low_to_high' => 1
                            ]) }}"
                                class="{{ request()->query('low_to_high') ? 'active' : '' }}">
                                {{ __('Price - Low to High') }}
                            </a>

                            <a href="{{ route('seller-info', [
                                'id' => $user->id,
                                'tab' => 'posts',
                                'product_id' => request()->query('product_id'),
                                'high_to_low' => 1
                            ]) }}"
                                class="{{ request()->query('high_to_low') ? 'active' : '' }}">
                                {{ __('Price - High to Low') }}
                            </a>

                            <a href="{{ route('seller-info', [
                                'id' => $user->id,
                                'tab' => 'posts',
                                'product_id' => request()->query('product_id'),
                                'recent-item' => 1
                            ]) }}"
                                class="{{ request()->query('recent-item') ? 'active' : '' }}">
                                {{ __('Recent Item') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="javascript:void(0)" class="justify-content-between">
                    @if (request()->query('low_to_high'))
                        {{ __('Price - Low to High') }}
                    @elseif (request()->query('high_to_low'))
                        {{ __('Price - High to Low') }}
                    @elseif (request()->query('recent-item'))
                        {{ __('Recent Item') }}
                    @else
                        {{ __('All') }}
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                        fill="none">
                        <path
                            d="M9.35426 1.35328L5.35426 5.35328C5.25626 5.45128 5.12825 5.49928 5.00025 5.49928C4.87225 5.49928 4.74425 5.45028 4.64625 5.35328L0.64625 1.35328C0.45125 1.15828 0.45125 0.84125 0.64625 0.64625C0.84125 0.45125 1.15828 0.45125 1.35328 0.64625L4.99928 4.29225L8.64527 0.64625C8.84027 0.45125 9.1573 0.45125 9.3523 0.64625C9.5473 0.84125 9.54926 1.15728 9.35426 1.35328Z"
                            fill="#25314C" />
                    </svg>
                </a>
            </li>
        </ul>
    </div>

    <div class="rs-product-menu-icon rs-product-menu-icon-2 d-flex align-items-center gap-16">
        <a href="javascript:void(0)" class="rs-product-menu__icon rs-product-menu__icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                <path
                    d="M7.25 2.5C7.25 2.086 7.586 1.75 8 1.75H19C19.414 1.75 19.75 2.086 19.75 2.5C19.75 2.914 19.414 3.25 19 3.25H8C7.586 3.25 7.25 2.914 7.25 2.5ZM19 8.25H8C7.586 8.25 7.25 8.586 7.25 9C7.25 9.414 7.586 9.75 8 9.75H19C19.414 9.75 19.75 9.414 19.75 9C19.75 8.586 19.414 8.25 19 8.25ZM19 14.75H8C7.586 14.75 7.25 15.086 7.25 15.5C7.25 15.914 7.586 16.25 8 16.25H19C19.414 16.25 19.75 15.914 19.75 15.5C19.75 15.086 19.414 14.75 19 14.75ZM4.75 2.5C4.75 3.741 3.741 4.75 2.5 4.75C1.259 4.75 0.25 3.741 0.25 2.5C0.25 1.259 1.259 0.25 2.5 0.25C3.741 0.25 4.75 1.259 4.75 2.5ZM3.25 2.5C3.25 2.086 2.914 1.75 2.5 1.75C2.086 1.75 1.75 2.086 1.75 2.5C1.75 2.914 2.086 3.25 2.5 3.25C2.914 3.25 3.25 2.914 3.25 2.5ZM4.75 9C4.75 10.241 3.741 11.25 2.5 11.25C1.259 11.25 0.25 10.241 0.25 9C0.25 7.759 1.259 6.75 2.5 6.75C3.741 6.75 4.75 7.759 4.75 9ZM3.25 9C3.25 8.586 2.914 8.25 2.5 8.25C2.086 8.25 1.75 8.586 1.75 9C1.75 9.414 2.086 9.75 2.5 9.75C2.914 9.75 3.25 9.414 3.25 9ZM4.75 15.5C4.75 16.741 3.741 17.75 2.5 17.75C1.259 17.75 0.25 16.741 0.25 15.5C0.25 14.259 1.259 13.25 2.5 13.25C3.741 13.25 4.75 14.259 4.75 15.5ZM3.25 15.5C3.25 15.086 2.914 14.75 2.5 14.75C2.086 14.75 1.75 15.086 1.75 15.5C1.75 15.914 2.086 16.25 2.5 16.25C2.914 16.25 3.25 15.914 3.25 15.5Z"
                    fill="currentColor" />
            </svg>
        </a>

        <a href="javascript:void(0)" class="rs-product-menu__icon rs-product-menu__icon-2 active">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path
                    d="M15.5 7.75H12.5C11.091 7.75 10.25 6.909 10.25 5.5V2.5C10.25 1.091 11.091 0.25 12.5 0.25H15.5C16.909 0.25 17.75 1.091 17.75 2.5V5.5C17.75 6.909 16.909 7.75 15.5 7.75ZM12.5 1.75C11.911 1.75 11.75 1.911 11.75 2.5V5.5C11.75 6.089 11.911 6.25 12.5 6.25H15.5C16.089 6.25 16.25 6.089 16.25 5.5V2.5C16.25 1.911 16.089 1.75 15.5 1.75H12.5ZM5.5 7.75H2.5C1.091 7.75 0.25 6.909 0.25 5.5V2.5C0.25 1.091 1.091 0.25 2.5 0.25H5.5C6.909 0.25 7.75 1.091 7.75 2.5V5.5C7.75 6.909 6.909 7.75 5.5 7.75ZM2.5 1.75C1.911 1.75 1.75 1.911 1.75 2.5V5.5C1.75 6.089 1.911 6.25 2.5 6.25H5.5C6.089 6.25 6.25 6.089 6.25 5.5V2.5C6.25 1.911 6.089 1.75 5.5 1.75H2.5ZM15.5 17.75H12.5C11.091 17.75 10.25 16.909 10.25 15.5V12.5C10.25 11.091 11.091 10.25 12.5 10.25H15.5C16.909 10.25 17.75 11.091 17.75 12.5V15.5C17.75 16.909 16.909 17.75 15.5 17.75ZM12.5 11.75C11.911 11.75 11.75 11.911 11.75 12.5V15.5C11.75 16.089 11.911 16.25 12.5 16.25H15.5C16.089 16.25 16.25 16.089 16.25 15.5V12.5C16.25 11.911 16.089 11.75 15.5 11.75H12.5ZM5.5 17.75H2.5C1.091 17.75 0.25 16.909 0.25 15.5V12.5C0.25 11.091 1.091 10.25 2.5 10.25H5.5C6.909 10.25 7.75 11.091 7.75 12.5V15.5C7.75 16.909 6.909 17.75 5.5 17.75ZM2.5 11.75C1.911 11.75 1.75 11.911 1.75 12.5V15.5C1.75 16.089 1.911 16.25 2.5 16.25H5.5C6.089 16.25 6.25 16.089 6.25 15.5V12.5C6.25 11.911 6.089 11.75 5.5 11.75H2.5Z"
                    fill="currentColor" />
            </svg>
        </a>
    </div>

</div>

{{-- View 1 --}}
<div class="row rs-product-list-view-1">
    @foreach ($products as $product)
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <x-product-card :product="$product" :wishlist-ids="getWishlistIds()" />
        </div>
    @endforeach
</div>


{{-- View 2 --}}
<div class="row rs-product-list-view-2">
    @foreach ($products as $product)
        <div class="col-lg-12">
            <div class="rs-product-box rs-product-box-2 rs-product-box-3 d-flex align-items-center gap-16 flex-row">
                <div class="rs-product-thumb rs-product-thumb-2 p-relative">
                    <a class="popup-image"
                        href="{{ $product->profilePath ?? asset('assets/frontend/img/product/default.png') }}">
                        <img class="br-img-2-side" style="width: 240px; max-height: 160px;"
                            src="{{ $product->profilePath ?? asset('assets/frontend/img/product/default.png') }}"
                            alt="">
                    </a>
                    <div class="rs-product-thumb-love p-absolute" onClick="addToWishlist({{ $product->id }})">
                        <svg class="love-icon {{ in_array($product->id, getWishlistIds() ?? []) ? 'active' : '' }}"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 22"
                            fill="none">
                            <path
                                d="M12 21C11.7 21 11.4 20.93 11.15 20.8C7.2 18.75 1 14.28 1 8.5C1 5.42 3.42 3 6.5 3C8.24 3 9.91 3.81 11 5.08C12.09 3.81 13.76 3 15.5 3C18.58 3 21 5.42 21 8.5C21 14.28 14.8 18.75 10.85 20.8C10.6 20.93 10.3 21 10 21H12Z"
                                stroke="#17181D" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                </div>
                <div class="rs-product-content rs-product-content-2  p-0">
                    <div class="rs-product-location">
                        <a href="javascript:void(0)" class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                fill="none">
                                <path
                                    d="M7 0.6875C3.38125 0.6875 0.4375 3.63125 0.4375 7.25C0.4375 11.0885 3.96024 13.415 6.29124 14.9547L6.688 15.218C6.7825 15.281 6.89125 15.3125 7 15.3125C7.10875 15.3125 7.2175 15.281 7.312 15.218L7.70876 14.9547C10.0398 13.415 13.5625 11.0885 13.5625 7.25C13.5625 3.63125 10.6187 0.6875 7 0.6875ZM7.08925 14.0157L7 14.0751L6.91075 14.0157C4.65325 12.5247 1.5625 10.4832 1.5625 7.25C1.5625 4.2515 4.0015 1.8125 7 1.8125C9.9985 1.8125 12.4375 4.2515 12.4375 7.25C12.4375 10.4832 9.346 12.5255 7.08925 14.0157ZM7 4.8125C5.656 4.8125 4.5625 5.906 4.5625 7.25C4.5625 8.594 5.656 9.6875 7 9.6875C8.344 9.6875 9.4375 8.594 9.4375 7.25C9.4375 5.906 8.344 4.8125 7 4.8125ZM7 8.5625C6.27625 8.5625 5.6875 7.97375 5.6875 7.25C5.6875 6.52625 6.27625 5.9375 7 5.9375C7.72375 5.9375 8.3125 6.52625 8.3125 7.25C8.3125 7.97375 7.72375 8.5625 7 8.5625Z"
                                    fill="#358CEF" />
                            </svg>
                            {{ getLocationName($product->latitude, $product->longitude) }}
                        </a>
                    </div>
                    <a href="{{ route('product-details', $product->id) }}">
                        <h3 class="rs-product-title rs-product-title-2 mb-8">
                            {{ $product->name ?? 'Untitled Product' }}
                        </h3>
                    </a>

                    <a href="javascript:void(0)" class="rs-product-condition d-flex align-items-center mb-8">

                        <span class="rs-product-border">
                            {{ $product->conditions ?? 'N/A' }}
                        </span>
                        <span class="rs-product-time rs-product-time-2  ml-48">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                fill="none">
                                <path
                                    d="M9 0.9375C4.554 0.9375 0.9375 4.554 0.9375 9C0.9375 13.446 4.554 17.0625 9 17.0625C13.446 17.0625 17.0625 13.446 17.0625 9C17.0625 4.554 13.446 0.9375 9 0.9375ZM9 15.9375C5.17425 15.9375 2.0625 12.8258 2.0625 9C2.0625 5.17425 5.17425 2.0625 9 2.0625C12.8258 2.0625 15.9375 5.17425 15.9375 9C15.9375 12.8258 12.8258 15.9375 9 15.9375ZM11.6475 10.8525C11.8673 11.0722 11.8673 11.4285 11.6475 11.6483C11.538 11.7578 11.394 11.8132 11.25 11.8132C11.106 11.8132 10.962 11.7585 10.8525 11.6483L8.60248 9.39825C8.49673 9.2925 8.4375 9.14923 8.4375 9.00073V5.25073C8.4375 4.94023 8.6895 4.68823 9 4.68823C9.3105 4.68823 9.5625 4.94023 9.5625 5.25073V8.76746L11.6475 10.8525Z"
                                    fill="#687387" />
                            </svg>
                            {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}
                        </span>
                    </a>
                    <div
                        class="rs-product-price rs-product-price-2 d-flex align-items-center justify-content-between mb-12">
                        <b>
                            {{ currencyFormat($product->asking_price) ?? '0.00' }}
                        </b>
                    </div>
                </div>
                <div class="rs-product-btn rs-product-btn-2 d-flex flex-column gap-16 ml-auto mr-16">
                    <a href="{{ route('product-details', $product->id) }}"
                        class="rs-product-details-btn rs-product-details-btn-4 rs-product-details-btn-2 d-flex align-items-center justify-content-center p-0 p-0 ml-16  rs-product-btn-3 rs-seler-profile-product-btn">
                        {{ __('View Details') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                            fill="currentColor">
                            <path
                                d="M19.6919 8.28713C19.6539 8.37913 19.599 8.46203 19.53 8.53103L12.53 15.531C12.384 15.677 12.192 15.751 12 15.751C11.808 15.751 11.616 15.678 11.47 15.531C11.177 15.238 11.177 14.763 11.47 14.47L17.1899 8.75002H1C0.586 8.75002 0.25 8.41402 0.25 8.00002C0.25 7.58602 0.586 7.25002 1 7.25002H17.189L11.469 1.53005C11.176 1.23705 11.176 0.762018 11.469 0.469018C11.762 0.176018 12.237 0.176018 12.53 0.469018L19.53 7.46902C19.599 7.53802 19.6539 7.62091 19.6919 7.71291C19.7679 7.89691 19.7679 8.10313 19.6919 8.28713Z"
                                fill="currentColor" />
                        </svg>
                    </a>
                    <button
                        class="makeOfferBtn makeOfferBtn-2  rs-btn rs-product-offer-btn d-flex align-items-center justify-content-center ml-16  rs-product-btn-3 rs-seler-profile-product-btn">
                        {{ __('Make Offer') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                            fill="none">
                            <path d="M8.5 11L12.5 11" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M8.5 16H16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M21.5 9V18C21.5 20.2091 19.7091 22 17.5 22H7.5C5.29086 22 3.5 20.2091 3.5 18V6C3.5 3.79086 5.29086 2 7.5 2H14.5M21.5 9L14.5 2M21.5 9H18.5C16.2909 9 14.5 7.20914 14.5 5V2"
                                stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="my-4">
    {{ $products->links() }}
</div>
