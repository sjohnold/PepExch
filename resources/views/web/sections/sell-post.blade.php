<section class="rs-sell-area mb-40">
    <div class="rs-sell-bg jarallax pb-96 pt-96" data-bg-img="{{ asset('assets/frontend/img/bg/sell-bg.png') }}">
        <div class="container">
            <div class="row reverse-md-column">
                <div class="col-xl-7 col-lg-7 col-12">
                    <div class="rs-sell-content">
                        <span class="rs-sell-sub-title wow img-custom-anim-left" data-wow-duration="1s"
                            data-wow-delay=".01s">
                            {{ $fastSelling->subtitle ?? 'No Fees, No Hassles' }}
                        </span>
                        <h2 class="rs-sell-title wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay=".05s">
                            {{ $fastSelling->title ?? 'Just Fast Selling' }}
                        </h2>
                        <p class="wow img-custom-anim-left" data-wow-duration="1s" data-wow-delay=".3s">
                            {{ $fastSelling->description ?? 'Reach thousands of local buyers instantly. List your old products in seconds with zero listing fees. No commissions, no middlemen just a simple way to sell fast and earn more. Start selling today with just a photo and a price.' }}
                        </p>
                        <div class="rs-sell-btn wow tpFadeInUp" data-wow-duration="1s" data-wow-delay=".01s">
                            <a href="{{ route('product-ad') }}" class="rs-header-btn d-flex align-items-center">
                                {{ __('Post Your Ad') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-12">
                    <div class="rs-sell-right">
                        <div class="rs-sell-img wow img-custom-anim-right" data-wow-duration="1s" data-wow-delay=".01s">
                            <img src="{{ $fastSelling->thumbnailPath ?? 'https://placehold.co/600x400/png' }}"
                                alt="{{ $fastSelling->title ?? 'Fast Selling' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
