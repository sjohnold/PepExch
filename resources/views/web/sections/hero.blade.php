<section class="rs-hero-area pt-48 pb-96 fix">
    <div class="container">
        <div class="row reverse-md-column">
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="rs-hero-content d-flex flex-column justify-content-center h-100">
                    <div class="rs-hero-sub-title wow img-custom-anim-left pt-10" data-wow-duration="1s"
                        data-wow-delay=".01s">
                        <span>
                            {{ __($banner->title) }}
                        </span>
                    </div>

                    @php
                        $words = explode(' ', trim(__($banner->sub_title)));
                        $firstThree = implode(' ', array_slice($words, 0, 3));
                        $remaining = implode(' ', array_slice($words, 3));
                    @endphp

                    <h1 class="rs-hero-title wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay=".03s">
                        {{-- Red part --}}
                        {{ $firstThree }}
                        {{-- Black part --}}
                        @if ($remaining)
                            <span style="color:black;">
                                {{ $remaining }}
                            </span>
                        @endif
                    </h1>

                    <p class="rs-hero-text wow img-custom-anim-left" data-wow-duration="1.9s" data-wow-delay=".03s">
                        {{ __($banner->description) }}
                    </p>
                    <a href="javascript:void(0)" class="rs-hero-location mb-32 wow tpFadeInUp" data-wow-duration="1.6s"
                        data-wow-delay=".03s">
                        <i class="rs-hero-location-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                fill="none">
                                <path
                                    d="M9 0.25C4.175 0.25 0.25 4.175 0.25 9C0.25 14.118 4.94699 17.2199 8.05499 19.2729L8.584 19.624C8.71 19.708 8.855 19.75 9 19.75C9.145 19.75 9.29 19.708 9.416 19.624L9.94501 19.2729C13.053 17.2199 17.75 14.118 17.75 9C17.75 4.175 13.825 0.25 9 0.25ZM9.119 18.021L9 18.1001L8.881 18.021C5.871 16.033 1.75 13.311 1.75 9C1.75 5.002 5.002 1.75 9 1.75C12.998 1.75 16.25 5.002 16.25 9C16.25 13.311 12.128 16.034 9.119 18.021ZM9 5.75C7.208 5.75 5.75 7.208 5.75 9C5.75 10.792 7.208 12.25 9 12.25C10.792 12.25 12.25 10.792 12.25 9C12.25 7.208 10.792 5.75 9 5.75ZM9 10.75C8.035 10.75 7.25 9.965 7.25 9C7.25 8.035 8.035 7.25 9 7.25C9.965 7.25 10.75 8.035 10.75 9C10.75 9.965 9.965 10.75 9 10.75Z"
                                    fill="#ffffff" />
                            </svg>
                        </i>
                        <span class="rs-hero-location-text">
                            {{ __($banner->address) }}
                        </span>
                    </a>
                    <div class="rs-hero-btn wow tpFadeInUp" data-wow-duration="1.9s" data-wow-delay=".03s">
                        <a href="{{ route('products') }}">
                            {{ __('Explore Products') }}
                            <i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                                    fill="none">
                                    <path
                                        d="M19.6919 8.28787C19.6539 8.37987 19.599 8.46276 19.53 8.53176L12.53 15.5318C12.384 15.6778 12.192 15.7517 12 15.7517C11.808 15.7517 11.616 15.6788 11.47 15.5318C11.177 15.2388 11.177 14.7637 11.47 14.4707L17.1899 8.75076H1C0.586 8.75076 0.25 8.41476 0.25 8.00076C0.25 7.58676 0.586 7.25076 1 7.25076H17.189L11.469 1.53079C11.176 1.23779 11.176 0.76275 11.469 0.46975C11.762 0.17675 12.237 0.17675 12.53 0.46975L19.53 7.46975C19.599 7.53875 19.6539 7.62165 19.6919 7.71365C19.7679 7.89765 19.7679 8.10387 19.6919 8.28787Z"
                                        fill="white" />
                                </svg>
                            </i>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="rs-hero-img-area p-relative ">

                    <div class="rs-hero-big-img p-absolute">
                        <div class="rs-hero-img-shadow">
                            <img id="bigImage" class="br-8" style="object-fit: cover;"
                                src="{{ $bannerPaths[0] ?? asset('assets/frontend/img/hero/default.png') }}"
                                alt="">
                        </div>
                    </div>

                    <div class="row g-0">
                        @foreach ($bannerPaths ?? [] as $img)
                            <div class="col-md-4 col-4 g-0">
                                <div class="rs-hero-img mr-25">
                                    <img class="br-4 mb-25 small-img" style="height:198px; object-fit: cover;"
                                        src="{{ $img ?? asset('assets/frontend/img/hero/default.png') }}"
                                        alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
