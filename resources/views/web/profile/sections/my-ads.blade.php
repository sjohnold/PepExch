@extends('web.profile.profile-master')
@section('my-ads-contnet')
    <!-- Error Modal -->
    <div id="errorModal" class="rs-payment-popup" style="display:none;">
        <div class="rs-payment-popup-content text-center p-relative">
            <button class="rs-payment-popup-close"><i class="fal fa-times"></i></button>
            <div class="rs-payment-popup-icon error mb-20">
                <img src="{{ asset('assets/frontend/img/icon/times-circle.svg') }}" alt="">
            </div>
            <h2>{{ __('Something Went Wrong') }}</h2>
            <p>{{ __('Payment Failed') }} </p>
            <button class="rs-modal-btn rs-btn rs-error-btn actionBtn">{{ __('Try Again') }}</button>
        </div>
    </div>
    <div class="rs-profile-head d-flex align-items-center justify-content-between mb-16">
        <div class="profile-side-bar d-xl-none">
            <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
        </div>
        <h2 class="rs-profile-title">
            {{ __('My Ads') }}
        </h2>
        <div class="d-flex gap-2">
            <button
                class="rs-btn {{ request()->routeIs('user.my-ads') && !request()->has('sold') ? '' : 'bg-light text-dark shadow-none' }}"
                onclick="window.location='{{ route('user.my-ads') }}'">
                {{ __('Active') }}
            </button>
            <button
                class="rs-btn {{ request()->routeIs('user.soldout') ? '' : 'bg-light text-dark shadow-none' }}"
                onclick="window.location='{{ route('user.soldout') }}'">
                {{ __('Exchanged') }}
            </button>
        </div>
    </div>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rs-product-box rs-product-box-2">
                        <div class="rs-product-thumb p-relative">
                            <a class="popup-image" href="{{ $product->profilePath }}">
                                <img src="{{ $product->profilePath }}" alt="{{ $product->name }}">
                            </a>


                            <div class="rs-more-option p-absolute">
                                <a href="javascript:void(0)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="5" height="20" viewBox="0 0 5 20"
                                        fill="none">
                                        <path
                                            d="M2.02063 4C0.91663 4 0.015625 3.104 0.015625 2C0.015625 0.896 0.90562 0 2.01062 0H2.02063C3.12463 0 4.02063 0.896 4.02063 2C4.02063 3.104 3.12563 4 2.02063 4ZM4.02063 10C4.02063 8.896 3.12463 8 2.02063 8H2.01062C0.90662 8 0.015625 8.896 0.015625 10C0.015625 11.104 0.91563 12 2.02063 12C3.12563 12 4.02063 11.104 4.02063 10ZM4.02063 18C4.02063 16.896 3.12463 16 2.02063 16H2.01062C0.90662 16 0.015625 16.896 0.015625 18C0.015625 19.104 0.91563 20 2.02063 20C3.12563 20 4.02063 19.104 4.02063 18Z"
                                            fill="#25314C" />
                                    </svg>
                                </a>
                                <div class="rs-more-option-item">
                                    <ul>
                                        @if ($product->status !== 'Soled')
                                            <li class="soldOutBtn" onclick="handleId({{ $product->id }})">
                                                <a href="javascript:void(0)">{{ __('Mark as Exchanged') }}</a>
                                            </li>




                                        @endif

                                        <li>
                                            <form action="{{ route('product.makeCopy', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit">{{ 'Make Copy' }}</button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('selling-post.trash', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit">{{ 'Move To Trash' }}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="rs-product-content">
                            <a href="{{ route('post-details', $product->id) }}"
                                class="d-flex align-items-center justify-content-between">
                                <h3 class="rs-product-title mb-8">{{ $product->name ?? 'Untitled Product' }}</h3>
                                <span class="rs-product-status">
                                    {{ $product->status }}
                                </span>
                            </a>

                            <div class="rs-product-price d-flex align-items-center justify-content-between mb-12">
                                <span class="rs-product-time">
                                    {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}
                                </span>

                            </div>
                            <div class="rs-product-btn d-flex align-items-center justify-content-between">
                                <a href="{{ route('product.edit', $product->id) }}"
                                    class="rs-product-details-btn d-flex align-items-center justify-content-center">
                                    {{ __('Edit Ads') }}
                                    <svg class="rotate-0" xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                        viewBox="0 0 25 24" fill="none">
                                        <path
                                            d="M21.77 13.72L20.78 12.73C20.47 12.42 20.0591 12.25 19.6221 12.25C19.6211 12.25 19.6201 12.25 19.6201 12.25C19.1821 12.25 18.7689 12.422 18.4609 12.733L12.97 18.249C12.829 18.389 12.751 18.58 12.751 18.778V21C12.751 21.414 13.087 21.75 13.501 21.75H15.7241C15.9221 21.75 16.1129 21.671 16.2529 21.531L21.769 16.04C22.08 15.731 22.25 15.319 22.251 14.881C22.25 14.443 22.08 14.031 21.77 13.72ZM19.6211 13.75C19.6471 13.75 19.685 13.757 19.719 13.791L20.709 14.781C20.743 14.815 20.75 14.854 20.75 14.88C20.75 14.906 20.743 14.944 20.709 14.978L20.073 15.611L18.8889 14.427L19.522 13.791C19.557 13.757 19.5951 13.75 19.6211 13.75ZM15.4131 20.25H14.25V19.087L17.8311 15.49L19.01 16.669L15.4131 20.25ZM10.5 19.25H6.5C4.923 19.25 4.25 18.577 4.25 17V5C4.25 3.423 4.923 2.75 6.5 2.75H11.75V5C11.75 7.418 13.082 8.75 15.5 8.75H17.75V10C17.75 10.414 18.086 10.75 18.5 10.75C18.914 10.75 19.25 10.414 19.25 10V8C19.25 7.801 19.171 7.61 19.03 7.47L13.03 1.47C12.889 1.329 12.699 1.25 12.5 1.25H6.5C4.082 1.25 2.75 2.582 2.75 5V17C2.75 19.418 4.082 20.75 6.5 20.75H10.5C10.914 20.75 11.25 20.414 11.25 20C11.25 19.586 10.914 19.25 10.5 19.25ZM13.25 5V3.811L16.689 7.25H15.5C13.923 7.25 13.25 6.577 13.25 5ZM7.5 10.25C7.086 10.25 6.75 10.586 6.75 11C6.75 11.414 7.086 11.75 7.5 11.75H14.5C14.914 11.75 15.25 11.414 15.25 11C15.25 10.586 14.914 10.25 14.5 10.25H7.5ZM11.5 14.25H7.5C7.086 14.25 6.75 14.586 6.75 15C6.75 15.414 7.086 15.75 7.5 15.75H11.5C11.914 15.75 12.25 15.414 12.25 15C12.25 14.586 11.914 14.25 11.5 14.25Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </a>




                            </div>
                        </div>
                    </div>
                </div>

                <div id="soldOutModal" class="rs-product-make-offer" style="display:none;">
                    <div class="rs-product-make-offer-content text-center">
                        <button class="rs-product-make-offer-close" id="closeSoldOut">
                            <i class="fas fa-times"></i>
                        </button>
                        <h2 class="rs-sold-out-modal-title">{{ __('Great! Your Product is Sold') }}
                        </h2>
                        <h4 class="rs-sold-out-modal-sub-title">
                            {{ __('Just Complete the Form to Mark It as Sold') }}</h4>
                        <p>
                            {{ __("Here's a list of all the items you've successfully sold") }}.
                            {{ __('Keep track of your past listings and buyer activity') }}.
                        </p>

                        <form class="sold-out-form" action="{{ route('user.soldout-mark') }}" method="POST">
                            @csrf

                            <input type="text" id="product-ID" hidden name="product_id">

                            <div class="form-group mb-10 text-start">
                                <label for="buyerName" class="d-block mb-8">{{ __('Buyer/Exchange Partner Name') }}</label>
                                <input type="text" id="buyerName" name="buyer_name" placeholder="Enter Name">
                            </div>

                            <div class="sold-out-btn d-flex align-items-center justify-content-center gap-20 mt-20">
                                <button type="button" class="rs-sold-out-cancel-btn"
                                    id="cancelSoldOut">{{ __('Cancel') }}</button>
                                <button type="submit" class="rs-btn rs-sold-out-submit-btn">{{ __('Submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center p-40 br-8 not-found-bg" data-bg-color="#F6F7F9">
                        <h4 class="mb-8">{{ __('No Post Found') }}</h4>
                        <p class="text-muted">
                            {{ __('You have not posted any ads yet.') }}
                        </p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .rs-btn.disabled {
            pointer-events: none;
            opacity: 0.5;

        }

        .rs-btn.active {
            background-color: var(--tp-red-color);
            color: #fff;
        }


        /* Cursor color trick (visual red effect) */
        .rs-btn.disabled:hover {
            cursor: not-allowed;
        }
    </style>
@endpush


@push('script')
    <script>
        const handleId = (id) => {
            $productInput = document.querySelector('#product-ID');
            $productInput.value = id;
        }
    </script>

    {{-- model --}}
    @if (session('success') || session('error'))
        <script>
            const successModal = document.getElementById('successModal');
            const errorModal = document.getElementById('errorModal');

            @if (session('success'))
                successModal.style.display = 'flex';
            @elseif (session('error'))
                errorModal.style.display = 'flex';
            @endif

            function closeModal() {
                successModal.style.display = 'none';
                errorModal.style.display = 'none';

            }

            document.querySelectorAll('.rs-payment-popup-close, .actionBtn').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            overlay.addEventListener('click', closeModal);
        </script>
    @endif
@endpush
