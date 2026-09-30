@extends('web.profile.profile-master')
@section('sold-out-content')
    <div class="col-xl-12 sold-out">
        <div class="rs-profile-head my-adds-header d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('My Ads') }}
            </h2>
            <button
                class="rs-btn rs-btn-2 rs-my-page-btn rs-my-page-btn-adds rs-product-offer-btn d-flex align-items-center justify-content-between rs-btn ml-auto mr-16
        {{ request()->routeIs('user.my-ads') ? 'active' : '' }}"
                onclick="window.location='{{ route('user.my-ads') }}?all=1'">
                {{ __('All Ads') }}
            </button>

            <button
                class="rs-my-page-btn Sold__out__btn sold-out-btn  rs-product-offer-btn my-adds-btn-2 rs-btn
        {{ request()->routeIs('user.soldout') ? 'active' : '' }}"
                onclick="window.location='{{ route('user.soldout') }}?all=1'">
                {{ __('Sold out') }}
            </button>

        </div>
        <div class="row">
            @forelse ($soldOutAds as $product)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="rs-product-box rs-product-box-2 wow tpFadeInUp" data-wow-duration="1s"
                        data-wow-delay=".01s">
                        <div class="rs-product-thumb p-relative">
                            <a class="popup-image" href="{{ $product->profilePath }}">
                                <img src="{{ $product->profilePath }}" alt="{{ $product->name }}">
                            </a>

                        </div>
                        <div class="rs-product-content">
                            <a href="javascript:void(0)">
                                <h3 class="rs-product-title mb-8">
                                    {{ $product->name ?? 'Untitled Product' }}
                                </h3>
                            </a>
                            <div class="rs-product-price d-flex align-items-center justify-content-between mb-16">
                                <b>
                                    {{ currencyFormat($product->asking_price) ?? '$0.00' }}
                                </b>
                                <span class="rs-product-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M9 0.9375C4.554 0.9375 0.9375 4.554 0.9375 9C0.9375 13.446 4.554 17.0625 9 17.0625C13.446 17.0625 17.0625 13.446 17.0625 9C17.0625 4.554 13.446 0.9375 9 0.9375ZM9 15.9375C5.17425 15.9375 2.0625 12.8258 2.0625 9C2.0625 5.17425 5.17425 2.0625 9 2.0625C12.8258 2.0625 15.9375 5.17425 15.9375 9C15.9375 12.8258 12.8258 15.9375 9 15.9375ZM11.6475 10.8525C11.8673 11.0722 11.8673 11.4285 11.6475 11.6483C11.538 11.7578 11.394 11.8132 11.25 11.8132C11.106 11.8132 10.962 11.7585 10.8525 11.6483L8.60248 9.39825C8.49673 9.2925 8.4375 9.14923 8.4375 9.00073V5.25073C8.4375 4.94023 8.6895 4.68823 9 4.68823C9.3105 4.68823 9.5625 4.94023 9.5625 5.25073V8.76746L11.6475 10.8525Z"
                                            fill="#687387" />
                                    </svg>
                                    {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}
                                </span>
                            </div>
                            <div class="rs-restore-button text-center">
                                <a href="javascript:void(0)" class="rs-restore-btn d-block w-100">
                                    {{ __('Sold out') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center p-40 br-8 not-found-bg" data-bg-color="#F6F7F9">
                        <h4 class="mb-8">{{ __('No Post Found') }}</h4>
                        <p class="text-muted">
                            {{ __('You have not Sold Out any ads yet.') }}
                        </p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection
