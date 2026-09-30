@if ($boostedProducts->count() > 0)
    <section class="rs-product-area mb-8 fix p-relative">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9">
                    <div class="rs-section-title-wrapper text-center text-md-start mb-40 wow tpFadeInUp"
                        data-wow-duration="1s" data-wow-delay=".01s">
                        <span class="rs-section-sub-title fns-24">
                            {{ __('Featured Product') }}
                        </span>
                        <h2 class="rs-section-title">
                            {{ __('Grab Them Before They’re Gone!') }}
                        </h2>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 self-center">
                    <div class="rs-product-top-btn d-flex align-items-center justify-content-end">
                        <a href="{{ route('products') }}">
                            {{ __('View All') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                                fill="currentColor">
                                <path
                                    d="M19.6919 8.28787C19.6539 8.37987 19.599 8.46276 19.53 8.53176L12.53 15.5318C12.384 15.6778 12.192 15.7517 12 15.7517C11.808 15.7517 11.616 15.6788 11.47 15.5318C11.177 15.2388 11.177 14.7637 11.47 14.4707L17.1899 8.75076H1C0.586 8.75076 0.25 8.41476 0.25 8.00076C0.25 7.58676 0.586 7.25076 1 7.25076H17.189L11.469 1.53079C11.176 1.23779 11.176 0.76275 11.469 0.46975C11.762 0.17675 12.237 0.17675 12.53 0.46975L19.53 7.46975C19.599 7.53875 19.6539 7.62165 19.6919 7.71365C19.7679 7.89765 19.7679 8.10387 19.6919 8.28787Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 d-md-none d-block">
                <div class="swiper rs-product-slide">
                    <div class="swiper-wrapper d-flex">
                        @foreach ($boostedProducts as $product)
                            <div class="swiper-slide">
                                <x-product-card :product="$product" :wishlist-ids="$wishlistIds" />
                            </div>
                        @endforeach
                    </div>
                    <div class="rs-product-pagination swiper-pagination"></div>
                </div>
            </div>

            <div class="rs-product d-none d-md-block">
                <div class="row g-4">
                    @foreach ($boostedProducts as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <x-product-card :product="$product" :wishlist-ids="$wishlistIds" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
