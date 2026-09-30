@extends('web.profile.profile-master')
@section('wishlist-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('Wishlist') }}
            </h2>
        </div>
        <div class="row">

            @if ($products->count() > 0)
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <x-product-card :product="$product" :wishlist-ids="$wishlistIds" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <strong>{{ __('Your wishlist is empty!') }}</strong><br>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary mt-3">{{ __('Continue Shopping') }}</a>
                </div>
            @endif

        </div>
    </div>

@endsection
