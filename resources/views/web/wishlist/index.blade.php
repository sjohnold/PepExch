@extends('web.layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center">{{ __('My Wishlist') }}</h2>

        @if ($products->count() > 0)
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
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
@endsection
