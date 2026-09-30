@extends('web.layouts.master')
@section('content')
    <!-- product details start -->
    <section class="rs-details-area mt-55">
        <div class="container">
            <div class="rs-details-wrapper mb-24 p-24 br-8" style="background: #f0fdf4; border: 1px solid #dcfce7;">
                <div class="row">

                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="swiper rs-details-slide-2 rounded-3xl overflow-hidden shadow-sm">
                            <div class="swiper-wrapper">
                                @foreach ($productImg->allImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image }}" alt="Product Image" class="w-100 object-fit-cover" style="height: 400px;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-12 col-md-12">
                        <div class="rs-product-details-info br-4 p-24 mb-24 fix bg-white shadow-sm rounded-3xl">
                            <h2 class="rs-product-details-info-title mb-4">
                                <a href="javascript:void(0)" class="text-dark fw-bold">
                                    {{ $products->name ?? 'Untitled Product' }}
                                </a>
                            </h2>
                            
                            <div class="d-flex flex-column gap-3 mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-calendar-alt text-success"></i>
                                    <span class="text-muted">{{ __('Posted on:') }}</span>
                                    <span class="fw-bold">{{ $products->created_at ? $products->created_at->diffForHumans() : 'Just now' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-tag text-success"></i>
                                    <span class="text-muted">{{ __('Condition:') }}</span>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $products->conditions ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-success"></i>
                                    <span class="text-muted">{{ __('Location:') }}</span>
                                    <span class="fw-bold">{{ $location_name ?? 'Unknown Location' }}</span>
                                </div>
                            </div>

                            <div class="rs-details-bottom-area border-top pt-4">
                                <div class="alert alert-success d-flex align-items-center gap-3 rounded-pill py-3 px-4 mb-4 border-0">
                                    <i class="fas fa-handshake fs-4"></i>
                                    <span class="fw-black text-uppercase tracking-wider">
                                        {{ __('Exchange Only') }}
                                    </span>
                                </div>
                                
                                <div class="d-grid gap-3">
                                    @if(auth()->id() == $products->user_id)
                                    <a href="{{ route('product.edit', $products->id) }}"
                                        class="btn btn-success btn-lg rounded-pill fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #16a34a; border: none;">
                                        <i class="fas fa-edit"></i>
                                        {{ __('Edit My Ad') }}
                                    </a>
                                    @else
                                    <a href="{{ route('chat.index', ['seller_id' => $products->user_id, 'post_id' => $products->id]) }}"
                                        class="btn btn-success btn-lg rounded-pill fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #16a34a; border: none;">
                                        <i class="fas fa-handshake"></i>
                                        {{ __('PONUDI RAZMENU') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- product info start -->
    <section class="rs-product-info-area mb-48">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-12 col-12">
                    <div class="rs-product-info-contant bg-white p-4 rounded-3xl shadow-sm border border-light">
                        <div class="rs-product-info-head mb-16 border-bottom pb-3">
                            <h3 class="rs-product-info-title fw-bold">
                                {{ __('Product Details') }}
                            </h3>
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-6">
                                <p class="text-muted mb-1 text-xs text-uppercase fw-bold">{{ __('Brand') }}</p>
                                <p class="fw-bold mb-0">{{ optional($products->brand)->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1 text-xs text-uppercase fw-bold">{{ __('Model') }}</p>
                                <p class="fw-bold mb-0">{{ $products->model ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1 text-xs text-uppercase fw-bold">{{ __('Warranty') }}</p>
                                <p class="fw-bold mb-0">{{ $products->warranty_left }} {{ __('days') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1 text-xs text-uppercase fw-bold">{{ __('Color') }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold">{{ $color->name ?? 'N/A' }}</span>
                                    @if ($products->color_code)
                                        <span class="rounded-circle border" style="width:16px; height:16px; background-color:{{ $products->color_code }};"></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top">
                            <h5 class="fw-bold mb-3">{{ __('Description') }}</h5>
                            <div class="text-muted leading-relaxed" style="white-space: pre-line;">
                                {{ $products->description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-12">
                    <div class="rs-product-location-area p-4 bg-white rounded-3xl shadow-sm border border-light">
                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            {{ $location_name ?? 'Unknown Location' }}
                        </h5>

                        <iframe class="rounded-2xl"
                            src="https://maps.google.com/maps?q={{ $products->latitude }},{{ $products->longitude }}&hl=es;z=15&output=embed"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product info start -->
@endsection
@push('style')
    <style>
        @media (max-width: 399px) {
            .rs-promotadd-mobilebtn {
                flex: 0 0 100% !important;
            }
        }

        .rs-promotadd-mobilebtn.disabled {
            pointer-events: none;
            opacity: 0.8;

        }

        .rs-btn.disabled:hover {
            cursor: not-allowed;
        }
    </style>
@endpush
