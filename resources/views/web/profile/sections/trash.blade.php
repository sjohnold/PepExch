@extends('web.profile.profile-master')
@section('trash-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">

            <div>
                <h2 class="rs-profile-title mb-4">
                    {{ __('Trash') }}
                </h2>
                <small class="rs-trash-date text-muted">
                    {{ __('Items in trash will be permanently removed after 7 days') }}
                </small>
            </div>

            <span class="badge bg-warning text-dark px-12 py-6">
                {{ __('Auto Delete') }}
            </span>
        </div>


        <div class="row">
            @forelse ($products as $product)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="rs-product-box wow tpFadeInUp" data-wow-duration="1s" data-wow-delay=".01s">
                        <div class="rs-product-thumb p-relative">
                            <a class="popup-image" href="{{ $product->profilePath }}">
                                <img src="{{ $product->profilePath }}" alt="{{ $product->name }}">
                            </a>
                            {{-- <div class="rs-more-option p-absolute">
                                <a href="javascript:void(0)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="5" height="20" viewBox="0 0 5 20"
                                        fill="none">
                                        <path
                                            d="M2.02063 4C0.91663 4 0.015625 3.104 0.015625 2C0.015625 0.896 0.90562 0 2.01062 0H2.02063C3.12463 0 4.02063 0.896 4.02063 2C4.02063 3.104 3.12563 4 2.02063 4ZM4.02063 10C4.02063 8.896 3.12463 8 2.02063 8H2.01062C0.90662 8 0.015625 8.896 0.015625 10C0.015625 11.104 0.91563 12 2.02063 12C3.12563 12 4.02063 11.104 4.02063 10ZM4.02063 18C4.02063 16.896 3.12463 16 2.02063 16H2.01062C0.90662 16 0.015625 16.896 0.015625 18C0.015625 19.104 0.91563 20 2.02063 20C3.12563 20 4.02063 19.104 4.02063 18Z"
                                            fill="#25314C"></path>
                                    </svg>
                                </a>
                            </div> --}}
                        </div>
                        <div class="rs-product-content">
                            <a href="javascript:void(0)">
                                <h3 class="rs-product-title mb-8">
                                    <h3 class="rs-product-title mb-8">{{ $product->name ?? 'Untitled Product' }}</h3>
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
                                <form action="{{ route('selling-post.restore', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rs-restore-btn d-block w-100 rs-btn rs-btn-2">
                                        {{ __('Restore') }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center p-40 br-8 not-found-bg d-flex flex-column align-items-center" data-bg-color="#F6F7F9">

                        <div class="rs-empty-icon mb-12">
                            <i class="ri-delete-bin-line"></i>
                        </div>

                        <h4 class="mb-4 fw-600">
                            {{ __('No Trashed Posts') }}
                        </h4>

                        <p class="text-muted mb-0">
                            {{ __('You don’t have any items in the trash right now.') }}
                        </p>
                    </div>
                </div>
            @endforelse


        </div>
    </div>
@endsection
