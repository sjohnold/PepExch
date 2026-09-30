<section class="rs-mobile-app-area pt-96 pb-105  p-relative fix">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12">
                <div class="rs-mobile-img d-flex align-items-end wow tpFadeInUp mr-16" data-wow-duration="1s"
                    data-wow-delay=".01s">
                    <a href="javascript:void(0)" class="rs-mobile-img-1 p-relative">
                        <img src="{{ asset('assets/frontend/mobile-mark/phone-small.png') }}" alt="">
                        <img src="{{ $allData->thumbnail1 ?? asset('media/market/m-1.jpg') }}" alt="App screen"
                            class="rs-mobile-app-screen p-absolute phone-screen">
                    </a>
                    <a href="javascript:void(0)" class="rs-mobile-img-2 p-relative">
                        <img src="{{ asset('assets/frontend/mobile-mark/phone-big.png') }}" alt="">
                        <img src="{{ $allData->thumbnail2 ?? asset('media/market/m-2.jpg') }}" alt="App screen"
                            class="rs-mobile-app-screen p-absolute phone-screen">
                    </a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12">
                <div class="rs-mobile-right d-flex flex-column justify-content-center h-100 wow slideinup"
                    data-wow-duration="1s" data-wow-delay=".01s">
                    <div class="rs-section-title-wrappe mb-24">
                        <span class="rs-section-sub-title mb-6" data-color="#17181D">
                            {{ $allData->title ?? 'Type Your Title Here' }}
                        </span>
                        <h2 class="rs-section-title fnw-600 fns-56 mb-20" data-color="{{ $themeColors['primary_color'] }}">
                            {{ $allData->subtitle ?? 'This is for Sub Title' }} <br>
                            <span class="mt-22 d-block" data-color="#17181D">

                            </span>
                        </h2>
                        <p class="fns-16 mobile-dsc" >
                            {{ $allData->description ?? 'This is the description field' }}

                        </p>
                    </div>

                    <div class="rs-mobile-app-wrapper d-flex align-items-center gap-24">
                        <div class="rs-mobile-app-box d-flex align-items-center gap-24">
                            <div class="rs-mobile-app-qr">

                                {{-- QR Code generate --}}
                                <a href="{{ $allData->app_store_url ?? 'https://placehold.co/600x400' }}"
                                    class="popup-image" target="_blank">
                                    {!! QrCode::size(80)->generate($allData->app_store_url ?? 'https://placehold.co/600x400') !!}
                                </a>

                            </div>
                            <div class="rs-mobile-app-content">
                                <a href="javascript:void(0)" class="rs-mobile-app-logo">
                                    <img src="{{ asset('assets/frontend/img/mobile-app/apple-logo.png') }}"
                                        alt="">
                                </a>
                                <div class="rs-mobile-app-Download mt-16">
                                    <a href="{{ $allData->app_store_url ?? '' }}" class="rs-mobile-app-Download-btn">
                                        {{ __('Download ') }}
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="rs-mobile-app-box d-flex align-items-center gap-24">
                            <div class="rs-mobile-app-qr">
                                {{-- QR Code generate --}}
                                <a href="{{ $allData->play_store_url ?? '' }}" class="popup-image" target="_blank">
                                    {!! QrCode::size(80)->generate($allData?->play_store_url ?? 'https://placehold.co/600x400') !!}
                                </a>
                            </div>
                            <div class="rs-mobile-app-content">
                                <a href="javascript:void(0)" class="rs-mobile-app-logo d-flex align-item-center gap-2">
                                    <img class="play-store-logo" src="{{ asset('assets/frontend/img/mobile-app/play-store-logo.png') }}"
                                        alt="">
                                        <img src="{{ asset('assets/frontend/img/mobile-app/play-store-logo-text.png') }}"
                                        alt="">
                                </a>
                                <div class="rs-mobile-app-Download mt-16">
                                    <a href="{{ $allData->play_store_url ?? '' }}" class="rs-mobile-app-Download-btn">
                                        {{ __('Download ') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
