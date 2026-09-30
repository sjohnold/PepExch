@extends('web.layouts.master')
@section('content')
    <!-- product details start -->
    <section class="rs-details-area mt-55">
        <div class="container">
            <div class="rs-details-wrapper mb-24 p-24 br-8" data-bg-color="#F6F7F9">
                <div class="row">
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="swiper rs-details-slide-2">
                            <div class="swiper-wrapper">
                                @foreach ($product->allImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image }}" alt="Product Image">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="swiper rs-details-slide">
                            <div class="swiper-wrapper">
                                @foreach ($product->allImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image }}" alt="Product Image">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="rs-product-details-info br-4 p-16 mb-24" data-bg-color="#fff">
                            <h2 class="rs-product-details-info-title">
                                <a href="javascript:void(0)">
                                    {{ $product->name ?? 'Untitled Product' }}
                                </a>
                            </h2>
                            <a href="javascript:void(0)"
                                class="rs-product-details-info-posted d-flex align-items-center mb-12 gap-61">{{ __('Posted on') }}:<span>
                                    {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}</span></a>
                            <a href="javascript:void(0)"
                                class="rs-product-details-info-condition d-flex align-items-center mb-12 gap-62">{{ __('Condition') }}:<span>{{ $product?->conditions ?? 'N/A' }}</span></a>
                            <a href="javascript:void(0)"
                                class="rs-product-details-info-location d-flex align-items-center gap-72">{{ __('Location') }}:<span>{{ $location_name ?? 'Unknown Location' }}</span></a>
                            <div class="rs-details-bottom-area">
                                <div
                                    class="rs-product-details-price mt-24 mb-24 d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0)">
                                        {{ currencyFormat($product?->asking_price) ?? '0.00' }}
                                        <span>
                                            {{ $product->is_negotiable == 1 ? __('Negotiable') : __('Fixed Price') }}
                                        </span>

                                        <div class="rs-product-details-price-contact-icon d-flex align-items-center gap-16">

                                            <a href="#"
                                                onclick="return confirmAlert(event,'{{ route('wishlist.add', $product->id) }}', {{ in_array($product->id, getWishlistIds() ?? []) ? 'true' : 'false' }})"
                                                class="rs-product-details-price-contact-icon-bg d-flex align-items-center justify-content-center">

                                                <svg class="love-icon {{ in_array($product->id, getWishlistIds() ?? []) ? 'active' : '' }}"
                                                    xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                                    viewBox="0 0 24 22" fill="none">
                                                    <path
                                                        d="M12 21C11.7 21 11.4 20.93 11.15 20.8C7.2 18.75 1 14.28 1 8.5C1 5.42 3.42 3 6.5 3C8.24 3 9.91 3.81 11 5.08C12.09 3.81 13.76 3 15.5 3C18.58 3 21 5.42 21 8.5C21 14.28 14.8 18.75 10.85 20.8C10.6 20.93 10.3 21 10 21H12Z"
                                                        stroke="#17181D" stroke-width="2" fill="none" />
                                                </svg>
                                            </a>

                                        </div>
                                    </a>
                                </div>

                                @if ($product->user_id && $product->user_id != auth()->id())
                                    <div
                                        class="rs-product-details-info-btn d-flex align-items-center justify-content-between gap-16">


                                        @auth
                                            <a href="javascript:void(0)"
                                                class="rs-product-details-massage-btn rs-btn d-flex align-items-center justify-content-center gap-10"
                                                onclick='openMessageModal({{ $product->user_id }}, @json($product->name), {{ $product->id }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M1 19.75C0.903 19.75 0.805891 19.731 0.712891 19.693C0.432891 19.577 0.25 19.303 0.25 19V4C0.25 1.582 1.582 0.25 4 0.25H16C18.418 0.25 19.75 1.582 19.75 4V13C19.75 15.418 18.418 16.75 16 16.75H4.31104L1.53101 19.53C1.38701 19.674 1.195 19.75 1 19.75ZM4 1.75C2.423 1.75 1.75 2.423 1.75 4V17.189L3.46997 15.469C3.61097 15.328 3.801 15.249 4 15.249H16C17.577 15.249 18.25 14.576 18.25 12.999V3.99902C18.25 2.42202 17.577 1.74902 16 1.74902H4V1.75ZM14.75 6.5C14.75 6.086 14.414 5.75 14 5.75H6C5.586 5.75 5.25 6.086 5.25 6.5C5.25 6.914 5.586 7.25 6 7.25H14C14.414 7.25 14.75 6.914 14.75 6.5ZM11.75 10.5C11.75 10.086 11.414 9.75 11 9.75H6C5.586 9.75 5.25 10.086 5.25 10.5C5.25 10.914 5.586 11.25 6 11.25H11C11.414 11.25 11.75 10.914 11.75 10.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Message Seller') }}
                                            </a>
                                        @else
                                            <a href="#" onclick="toggleModal('sign_in_popup')"
                                                class="rs-product-details-massage-btn rs-btn d-flex align-items-center justify-content-center gap-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M1 19.75C0.903 19.75 0.805891 19.731 0.712891 19.693C0.432891 19.577 0.25 19.303 0.25 19V4C0.25 1.582 1.582 0.25 4 0.25H16C18.418 0.25 19.75 1.582 19.75 4V13C19.75 15.418 18.418 16.75 16 16.75H4.31104L1.53101 19.53C1.38701 19.674 1.195 19.75 1 19.75ZM4 1.75C2.423 1.75 1.75 2.423 1.75 4V17.189L3.46997 15.469C3.61097 15.328 3.801 15.249 4 15.249H16C17.577 15.249 18.25 14.576 18.25 12.999V3.99902C18.25 2.42202 17.577 1.74902 16 1.74902H4V1.75ZM14.75 6.5C14.75 6.086 14.414 5.75 14 5.75H6C5.586 5.75 5.25 6.086 5.25 6.5C5.25 6.914 5.586 7.25 6 7.25H14C14.414 7.25 14.75 6.914 14.75 6.5ZM11.75 10.5C11.75 10.086 11.414 9.75 11 9.75H6C5.586 9.75 5.25 10.086 5.25 10.5C5.25 10.914 5.586 11.25 6 11.25H11C11.414 11.25 11.75 10.914 11.75 10.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Message Seller') }}
                                            </a>
                                        @endauth

                                        @auth
                                            <button
                                                class="makeOfferBtn rs-btn rs-product-offer-btn d-flex align-items-center justify-content-center"
                                                onclick="openOfferModal({{ $product->user_id }}, '{{ addslashes($product->name) }}', {{ $product->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M8 11L12 11" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path d="M8 16H16" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path
                                                        d="M21 9V18C21 20.2091 19.2091 22 17 22H7C4.79086 22 3 20.2091 3 18V6C3 3.79086 4.79086 2 7 2H14M21 9L14 2M21 9H18C15.7909 9 14 7.20914 14 5V2"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                </svg>
                                                {{ __('Make Offer') }}
                                            </button>
                                        @else
                                            <a href="#" onclick="toggleModal('sign_in_popup')"
                                                class="rs-product-offer-btn d-flex align-items-center justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M8 11L12 11" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path d="M8 16H16" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path
                                                        d="M21 9V18C21 20.2091 19.2091 22 17 22H7C4.79086 22 3 20.2091 3 18V6C3 3.79086 4.79086 2 7 2H14M21 9L14 2M21 9H18C15.7909 9 14 7.20914 14 5V2"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                                </svg>
                                                {{ __('Make Offer') }}
                                            </a>
                                        @endauth

                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="rs-product-details-info-bottom br-4 p-16 d-flex justify-content-between gap-16"
                            data-bg-color="#fff">
                            <div class="rs-product-details-info-box">
                                <div class="rs-product-details-info-rating-area d-flex align-items-center gap-8 pb-8">
                                    <a class="rs-product-details-info-rating-author-thumb">
                                        <img src="{{ $product->user->profilePhotoPath ?? asset('media/demo-img.png') }}" alt="">
                                    </a>
                                    <div class="rs-product-details-info-rating-author-content">
                                        <a href="{{ $product->user ? route('seller-info', ['id' => $product->user->id, 'product_id' => $product->id]) : 'javascript:void(0)' }}"
                                            class="rs-product-details-info-rating-author-name d-flex align-items-center">
                                            {{ $product->user?->name ?? 'N/A' }}

                                            @if ($product->user?->email_verified_at || $product->user?->phone_verified_at)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M17.1221 6.87926L16.6812 6.43825C16.4002 6.15725 16.2421 5.77524 16.2421 5.37724V4.75624C16.2421 3.10024 14.9002 1.75825 13.2442 1.75825H12.6232C12.2252 1.75825 11.8442 1.60026 11.5622 1.31926L11.1212 0.87825C9.95017 -0.29275 8.05218 -0.29275 6.88118 0.87825L6.44014 1.31926C6.15914 1.60026 5.77723 1.75825 5.37923 1.75825H4.75826C3.10225 1.75825 1.76021 3.10024 1.76021 4.75624V5.37724C1.76021 5.77524 1.60224 6.15625 1.32124 6.43825L0.880203 6.87926C-0.290797 8.05026 -0.290797 9.94825 0.880203 11.1192L1.32124 11.5603C1.60224 11.8413 1.76021 12.2233 1.76021 12.6213V13.2423C1.76021 14.8983 3.10225 16.2402 4.75826 16.2402H5.37923C5.77723 16.2402 6.15814 16.3982 6.44014 16.6792L6.88118 17.1203C8.05218 18.2913 9.95017 18.2913 11.1212 17.1203L11.5622 16.6792C11.8432 16.3982 12.2252 16.2402 12.6232 16.2402H13.2442C14.9002 16.2402 16.2421 14.8983 16.2421 13.2423V12.6213C16.2421 12.2233 16.4002 11.8423 16.6812 11.5603L17.1221 11.1192C18.2931 9.94825 18.2931 8.05026 17.1221 6.87926ZM12.5302 7.52925L8.53023 11.5293C8.38423 11.6753 8.1922 11.7493 8.0002 11.7493C7.8082 11.7493 7.61617 11.6763 7.47017 11.5293L5.47017 9.52925C5.17717 9.23625 5.17717 8.76125 5.47017 8.46825C5.76317 8.17525 6.2382 8.17525 6.5312 8.46825L8.00117 9.93825L11.4711 6.46825C11.7641 6.17525 12.2392 6.17525 12.5322 6.46825C12.8232 6.76125 12.8232 7.23725 12.5302 7.52925Z"
                                                        fill="#067BFF" />
                                                </svg>
                                            @endif
                                        </a>

                                        <div class="rs-product-details-info-rating">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                viewBox="0 0 18 17" fill="none">
                                                <path
                                                    d="M9.96163 0.59625L11.9036 4.51324C12.0496 4.80824 12.3316 5.01226 12.6586 5.05926L17.1416 5.70721C17.9636 5.82621 18.2916 6.83423 17.6966 7.41223L14.4556 10.5572C14.2186 10.7872 14.1106 11.1182 14.1666 11.4432L14.9076 15.7473C15.0576 16.6203 14.1406 17.2862 13.3546 16.8752L9.46663 14.8403C9.17463 14.6873 8.8266 14.6873 8.5356 14.8403L4.65059 16.8732C3.86359 17.2852 2.94356 16.6182 3.09456 15.7432L3.83565 11.4432C3.89165 11.1182 3.78359 10.7872 3.54659 10.5572L0.305622 7.41223C-0.290378 6.83423 0.0375539 5.82621 0.860554 5.70721L5.34359 5.05926C5.66959 5.01226 5.95159 4.80824 6.09859 4.51324L8.04061 0.59625C8.43161 -0.19875 9.56763 -0.19875 9.96163 0.59625Z"
                                                    fill="#FFC107" />
                                            </svg>
                                            <span>
                                                {{ $averageRating }}
                                            </span>

                                            <cite>({{ $totalReviews }})</cite>

                                        </div>
                                    </div>
                                </div>
                                <div class="rs-product-details-info-rating-year pt-8">
                                    <span>
                                        {{ __('Member Since') }}:
                                        {{ $product?->user?->created_at?->format('Y') ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <div class="rs-product-details-info-box">
                                <div class="rs-product-details-contact">
                                    <a href="tel:+876786759574" class="d-flex align-items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M14.5518 19.7514C14.0928 19.7514 13.6309 19.6894 13.1749 19.5644C7.00986 17.8724 2.12885 12.9944 0.435851 6.83344C0.0508506 5.43244 0.261798 3.97243 1.0318 2.72443C1.8048 1.47043 3.07586 0.585427 4.51886 0.297427C5.47886 0.105427 6.42785 0.533434 6.91485 1.35443L8.47784 3.99442C9.23684 5.27642 8.85971 6.92742 7.61871 7.75342L6.48785 8.50543C7.54485 10.6754 9.3227 12.4584 11.4837 13.5144L12.2459 12.3774C13.0769 11.1384 14.7278 10.7674 16.0088 11.5304L18.6519 13.1064C19.4699 13.5944 19.8928 14.5494 19.7068 15.4814C19.4188 16.9244 18.5338 18.1954 17.2808 18.9684C16.4388 19.4864 15.5018 19.7514 14.5518 19.7514ZM4.97784 1.74942C4.92884 1.74942 4.87887 1.75444 4.83087 1.76444C3.77687 1.97544 2.86387 2.61042 2.30987 3.51142C1.76087 4.40142 1.60985 5.44043 1.88385 6.43543C3.43685 12.0884 7.91584 16.5654 13.5718 18.1174C14.5678 18.3904 15.6037 18.2384 16.4927 17.6904C17.3927 17.1354 18.0289 16.2214 18.2359 15.1854C18.2979 14.8744 18.1569 14.5554 17.8829 14.3924L15.2408 12.8164C14.6458 12.4624 13.8778 12.6354 13.4918 13.2104L12.3768 14.8754C12.1768 15.1734 11.7909 15.2874 11.4649 15.1494C8.5019 13.9104 6.09089 11.4944 4.85089 8.52042C4.71289 8.18842 4.82875 7.80642 5.12775 7.60742L6.78888 6.50241C7.36488 6.11941 7.53983 5.35242 7.18683 4.75742L5.62384 2.11841C5.48684 1.88641 5.23884 1.74942 4.97784 1.74942Z"
                                                fill="#DD5454" />
                                        </svg>
                                        {{ $product->user?->phone_no ?? 'N/A' }}
                                    </a>
                                    <a href="mailto: example@gmail.com" class="d-flex align-items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                            viewBox="0 0 20 17" fill="none">
                                            <path
                                                d="M16 16.75H4C1.582 16.75 0.25 15.418 0.25 13V4C0.25 1.582 1.582 0.25 4 0.25H16C18.418 0.25 19.75 1.582 19.75 4V13C19.75 15.418 18.418 16.75 16 16.75ZM4 1.75C2.423 1.75 1.75 2.423 1.75 4V13C1.75 14.577 2.423 15.25 4 15.25H16C17.577 15.25 18.25 14.577 18.25 13V4C18.25 2.423 17.577 1.75 16 1.75H4ZM11.0291 9.179L15.9409 5.60699C16.2759 5.36399 16.35 4.89401 16.106 4.55901C15.863 4.22501 15.3951 4.149 15.0581 4.394L10.146 7.966C10.058 8.03 9.94103 8.03 9.85303 7.966L4.94092 4.394C4.60292 4.149 4.13607 4.22601 3.89307 4.55901C3.64907 4.89401 3.72311 5.36299 4.05811 5.60699L8.96997 9.17999C9.27797 9.40399 9.63902 9.515 9.99902 9.515C10.359 9.515 10.7221 9.403 11.0291 9.179Z"
                                                fill="#DD5454" />
                                        </svg>
                                        {{ $product->user?->email ?? 'N/A' }}
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
    <!-- product details start -->

    <!-- product info start -->
    <section class="rs-product-info-area mb-48">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-12 col-12">
                    <div class="rs-product-info-contant">
                        <div class="rs-product-info-head mb-16">
                            <h3 class="rs-product-info-title">
                                {{ __('Product Information') }}
                            </h3>
                        </div>
                        <div class="rs-product-about pl-16 mb-24">
                            <h4 class="rs-product-about-title">
                                {{ __('About Product') }}
                            </h4>
                            <div class="rs-product-brand d-flex align-items-center gap-16">
                                <p>{{ __('Brand') }}</p>
                                <span>{{ optional($product->brand)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="rs-product-brand d-flex align-items-center gap-16">
                                <p>{{ __('Model') }}</p>
                                <span>{{ $product->model ?? 'N/A' }}</span>
                            </div>

                            <div class="rs-product-warranty d-flex align-items-center gap-16">
                                <p>{{ __('Warranty') }}</p>
                                <span>{{ $product->warranty_left ? $product->warranty_left . ' days' : 'N/A' }}</span>

                            </div>

                            <div class="rs-product-color d-flex align-items-center gap-16">
                                <p>{{ __('Color') }}</p>
                                <span>{{ $color->name ?? '' }}</span>
                                @if ($product->color_code)
                                    <span
                                        style="display:inline-block;width:16px;height:16px;border:1px solid #ccc;background-color:{{ $product->color_code ?? 'N/A' }};margin-left:8px;border-radius:3px;"></span>
                                @endif
                            </div>
                        </div>
                        <div class="rs-product-description pl-16">
                            <div class="rs-product-description-content">
                                <h4 class="rs-product-description-title mb-16">
                                    {{ __('Description') }}
                                </h4>
                                <ul class="rs-product-description-text">

                                    {{ $product->description }}
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-12">
                    <div class="rs-product-location-area p-24" data-bg-color="#F6F7F9">
                        <a href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                fill="none">
                                <path
                                    d="M9 0.25C4.175 0.25 0.25 4.175 0.25 9C0.25 14.118 4.94699 17.2199 8.05499 19.2729L8.584 19.624C8.71 19.708 8.855 19.75 9 19.75C9.145 19.75 9.29 19.708 9.416 19.624L9.94501 19.2729C13.053 17.2199 17.75 14.118 17.75 9C17.75 4.175 13.825 0.25 9 0.25ZM9.119 18.021L9 18.1001L8.881 18.021C5.871 16.033 1.75 13.311 1.75 9C1.75 5.002 5.002 1.75 9 1.75C12.998 1.75 16.25 5.002 16.25 9C16.25 13.311 12.128 16.034 9.119 18.021ZM9 5.75C7.208 5.75 5.75 7.208 5.75 9C5.75 10.792 7.208 12.25 9 12.25C10.792 12.25 12.25 10.792 12.25 9C12.25 7.208 10.792 5.75 9 5.75ZM9 10.75C8.035 10.75 7.25 9.965 7.25 9C7.25 8.035 8.035 7.25 9 7.25C9.965 7.25 10.75 8.035 10.75 9C10.75 9.965 9.965 10.75 9 10.75Z"
                                    fill="#DD5454" />
                            </svg>
                            {{ $location_name ?? 'Unknown Location' }}
                        </a>

                        <iframe class="br-8"
                            src="https://maps.google.com/maps?q={{ $product->latitude }},{{ $product->longitude }}&hl=es;z=15&output=embed"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product info start -->

    <!-- product area start -->

    @if ($relatedProducts->count() > 0)
        <section class="rs-product-area mb-8 fix p-relative">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9">
                        <div class="rs-section-title-wrapperr rs-product-section-title-wrapper mb-35">
                            <h2 class="rs-section-title">
                                {{__('Related Items')}}
                            </h2>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 self-center">
                        <div class="rs-product-top-btn d-flex align-items-center justify-content-end">
                            <a href="{{ route('products') }}">
                                {{ __('View All') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                    viewBox="0 0 20 16" fill="currentColor">
                                    <path
                                        d="M19.6919 8.28787C19.6539 8.37987 19.599 8.46276 19.53 8.53176L12.53 15.5318C12.384 15.6778 12.192 15.7517 12 15.7517C11.808 15.7517 11.616 15.6788 11.47 15.5318C11.177 15.2388 11.177 14.7637 11.47 14.4707L17.1899 8.75076H1C0.586 8.75076 0.25 8.41476 0.25 8.00076C0.25 7.58676 0.586 7.25076 1 7.25076H17.189L11.469 1.53079C11.176 1.23779 11.176 0.76275 11.469 0.46975C11.762 0.17675 12.237 0.17675 12.53 0.46975L19.53 7.46975C19.599 7.53875 19.6539 7.62165 19.6919 7.71365C19.7679 7.89765 19.7679 8.10387 19.6919 8.28787Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper rs-product-slide-2 p-relative">
                        <div class="swiper-wrapper d-flex">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div class="swiper-slide">
                                    <x-product-card :product="$relatedProduct" :wishlist-ids="getWishlistIds()" />
                                </div>
                            @endforeach
                        </div>
                        <div class="rs-navigation-button">
                            <div class="rs-product-button-next-2 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16"
                                    fill="none">
                                    <path
                                        d="M7.50003 14.6004L2.0667 9.16706C1.42503 8.52539 1.42503 7.47539 2.0667 6.83372L7.50003 1.40039"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="rs-product-button-prev-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16"
                                    fill="none">
                                    <path
                                        d="M7.50003 14.6004L2.0667 9.16706C1.42503 8.52539 1.42503 7.47539 2.0667 6.83372L7.50003 1.40039"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- product area end -->

    {{-- message modal --}}
    <div id="messageModal" class="rs-product-make-offer rs-product-make-offer-2" style="display:none;">
        <div class="rs-product-make-offer-content rs-payment-popup-content-2 rs-payment-popup-content-3">
            <button type="button" class="rs-product-make-offer-close rs-payment-popup-close-3"
                id="closeMessage">X</button>

            <h2 class="rs-product-make-offer-title">{{ __('Seller Message') }}</h2>
            <p>{{ __('Buy smarter. Make an offer and get the best deal') }}.</p>

            <form action="{{ route('make.offer') }}" method="POST">
                @csrf
                <!-- Unique IDs for message modal -->
                <input type="hidden" name="receiver_id" id="message_receiver_id">
                <input type="hidden" name="selling_post_id" id="message_selling_post_id">
                <input type="hidden" name="product_name" id="message_product_name">

                <label>{{ __('Message') }}</label>
                <textarea name="offer_message" id="message_text" placeholder="Write your message" required></textarea>

                <button type="submit" id="submitMessageBtn" class="rs-btn-primary">
                    {{ __('Submit Message') }}
                </button>
            </form>
        </div>
    </div>
@endsection

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

        //message Seller
        function openMessageModal(receiverId, productName, sellingPostId) {
            const modal = document.getElementById('messageModal');
            if (!modal) return;

            // Populate hidden fields (use message_* IDs)
            document.getElementById('message_receiver_id').value = receiverId;
            document.getElementById('message_product_name').value = productName;
            document.getElementById('message_selling_post_id').value = sellingPostId;

            // Clear previous message
            document.getElementById('message_text').value = '';

            // Show modal
            modal.style.display = 'block';
        }

        // Close button
        document.getElementById('closeMessage').addEventListener('click', function() {
            document.getElementById('messageModal').style.display = 'none';
        });
    </script>
@endpush
