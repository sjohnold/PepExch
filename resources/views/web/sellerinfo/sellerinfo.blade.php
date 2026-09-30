@extends('web.layouts.master')

@section('content')
    <section class="rs-seler-profile-area mt-24">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="rs-seler-profile-bg p-24 br-8"
                        data-bg-img="{{ asset('assets/frontend/img/bg/seler-profile-bg.jpg') }}">
                        <div class="rs-seler-profile-content d-flex align-items-end gap-24 p-relative z-1 mt-80">
                            <div class="rs-seler-profile-author">
                                <img src="{{ $user->profilePhotoPath ?? '' }}" alt="">
                            </div>
                            <div class="rs-seler-info">
                                <span class="rs-seler-name d-flex align-items-center gap-16 mb-20">
                                    {{ $user->name }}
                                    <img src="{{ asset('assets/frontend/img/icon/badge-check.svg') }}" alt="">
                                </span>
                                <span class="rs-seler-location d-flex align-items-center gap-12 mb-20">
                                    <img src="{{ asset('assets/frontend/img/icon/location-pin-2.svg') }}" alt="">
                                    {{ getLocationName($user->latitude, $user->longitude) }}
                                </span>
                                <span class="rs-seler-rating d-flex align-items-center">
                                    <img class="mr-6" src="{{ asset('assets/frontend/img/icon/star.svg') }}"
                                        alt="">
                                    {{ $averageRating }}
                                    <cite>({{ $totalReviews }})</cite>
                                </span>
                            </div>
                        </div>
                        @auth
                            @if (auth()->user()->id != $user->id)
                                <div class="rs-review-right rs-review-right-2 p-absolute z-1">
                                    <button class="reportSellerBtn">
                                        {{ __('Report Seller') }}
                                        <img src="{{ asset('assets/frontend/img/icon/triangle-exclamation.svg') }}" alt="">
                                    </button>
                                </div>
                            @endif
                        @endauth

                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="rs-seler-information-area">
                        <h4 class="rs-seler-information-title">
                            {{ __(' Seller Information ') }}
                        </h4>
                        <a href="#" class="rs-seler-information-number">
                            <img src="{{ asset('assets/frontend/img/icon/phone.svg') }}" alt="">
                            {{ $user->phone_no ?? 'No Phone Number' }}
                        </a>
                        <a href="#" class="rs-seler-information-gmail">
                            <img src="{{ asset('assets/frontend/img/icon/user-star.svg') }}" alt="">
                            {{ $user->email ?? 'No Email' }}
                        </a>
                        <a href="#" class="rs-seler-information-year">
                            <img src="{{ asset('assets/frontend/img/icon/envelope.svg') }}" alt="">
                            {{ $user->created_at ? $user->created_at->format('F Y') : 'Not Found' }}
                        </a>


                        @if (isset($product) && $product->user_id == auth()->id())
                            <div class="rs-seler-information-btn d-flex align-items-center justify-content-between">
                                @auth
                                    @if (isset($product) && $product->user_id != auth()->id())
                                        <div class="rs-seler-information-btn d-flex align-items-center justify-content-between">
                                            <button class="rs-header-btn rs-btn"
                                                onclick='openMessageModal({{ $product->user_id }}, @json($product->name), {{ $product->id }})'>
                                                {{-- SVG icon --}}
                                                {{ __('Message Seller') }}
                                            </button>
                                            <button class="rs-seler-information-share-btn m-0">
                                                <img src="{{ asset('assets/frontend/img/icon/share.svg') }}" alt="">
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <a href="#" class="rs-header-btn flex-1 mb-0" onclick="toggleModal('sign_in_popup')"
                                        <svg class="mr-10" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.75 19.5C0.653 19.5 0.555891 19.481 0.462891 19.443C0.182891 19.327 0 19.053 0 18.75V3.75C0 1.332 1.332 0 3.75 0H15.75C18.168 0 19.5 1.332 19.5 3.75V12.75C19.5 15.168 18.168 16.5 15.75 16.5H4.06104L1.28101 19.28C1.13701 19.424 0.945 19.5 0.75 19.5ZM3.75 1.5C2.173 1.5 1.5 2.173 1.5 3.75V16.939L3.21997 15.219C3.36097 15.078 3.551 14.999 3.75 14.999H15.75C17.327 14.999 18 14.326 18 12.749V3.74902C18 2.17202 17.327 1.49902 15.75 1.49902H3.75V1.5ZM14.5 6.25C14.5 5.836 14.164 5.5 13.75 5.5H5.75C5.336 5.5 5 5.836 5 6.25C5 6.664 5.336 7 5.75 7H13.75C14.164 7 14.5 6.664 14.5 6.25ZM11.5 10.25C11.5 9.836 11.164 9.5 10.75 9.5H5.75C5.336 9.5 5 9.836 5 10.25C5 10.664 5.336 11 5.75 11H10.75C11.164 11 11.5 10.664 11.5 10.25Z"
                                            fill="currentColor" />
                                        </svg>
                                        {{ __(' Massage Seller ') }}
                                    </a>
                                    <button class="rs-seler-information-share-btn m-0">
                                        <img src="{{ asset('assets/frontend/img/icon/share.svg') }}" alt="">
                                    </button>

                                @endauth

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- product-view-area start -->
    <section class="rs-product-view-area mt-24">

        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-12 col-12">
                    <div class="rs-product-head-2 mb-24">
                        <div class="rs-product-head-top mb-24 br-8 p-16" data-bg-color="#F6F7F9">

                            <div class="rs-product-head-top-btn d-flex gap-16">
                                <a href="{{ route('seller-info', ['id' => $user->id, 'tab' => 'posts', 'product_id' => request()->query('product_id')]) }}"
                                    class="rs-product-head-top-btn {{ request()->query('tab', 'posts') == 'posts' ? 'active' : '' }}">
                                    {{ __('All Live Ads') }}
                                </a>

                                <a href="{{ route('seller-info', ['id' => $user->id, 'tab' => 'reviews', 'product_id' => request()->query('product_id')]) }}"
                                    class="rs-product-head-top-btn {{ request()->query('tab') == 'reviews' ? 'active' : '' }}">
                                    {{ __('Review') }}
                                </a>
                            </div>

                        </div>
                    </div>

                @section('tab-content')
                    @if (request()->query('tab', 'posts') == 'posts')
                        @include('web.sellerinfo.content.seller-post')
                    @elseif(request()->query('tab') == 'reviews')
                        @include('web.sellerinfo.content.seller-review')
                    @endif
                @show
            </div>

            {{-- Related Items --}}
            <div class="col-xl-4">
                <section class="rs-related-item-area">
                    <div class="rs-product-head-top br-8" data-bg-color="#F6F7F9"
                        style="background-color: rgb(246, 247, 249);">
                        <h4 class="rs-related-item-title">
                            {{ __(' Related Item ') }}
                        </h4>
                    </div>
                    <div class="rs-related-item-card-box p-24" data-bg-color="#F6F7F9">
                        @if ($relatedPosts->isEmpty())
                            <p class="text-center text-muted py-2">
                                {{ __('There are no related items for this product.') }}
                            </p>
                        @endif

                        @foreach ($relatedPosts as $product)
                            <x-product-card :product="$product" :wishlist-ids="getWishlistIds()" />
                        @endforeach
                    </div>
                </section>
            </div>

        </div>
    </div>
</section>



<!-- Report Seller Modal -->
<div id="reportModal" class="rs-product-make-offer" style="display:none;">
    <div class="rs-product-make-offer-content">
        <button class="rs-product-make-offer-close" id="closeReport">
            <i class="fas fa-times"></i>
        </button>

        <h2 class="rs-product-make-offer-title">{{ __('Report Seller') }}</h2>
        <p>{{ __('Help us maintain a safe community by reporting suspicious behavior.') }}</p>

        <form action="{{ route('report.seller.store') }}" method="POST">
            @csrf
            <div class="form-group mb-20">
                <label for="reportReason" class="d-block mb-8">{{ __('Report type') }}</label>
                <select id="reportReason" name="report_type">
                    <option value="" disabled selected>{{ __('Select a Reason') }}</option>
                    @foreach (\App\Enums\ReportSeller::cases() as $reason)
                        <option value="{{ $reason->value }}">{{ $reason->value }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="reportMessage">{{ __('Details') }}</label>
                <textarea id="reportMessage" name="details" placeholder="Write Details"></textarea>
            </div>

            <!-- Hidden Fields -->
            <input type="hidden" name="seller_id" value="{{ $user->id }}">
            <input type="hidden" name="reporter_id" value="{{ auth()->id() }}">

            <div class="rs-payment-method-btn d-flex align-items-center gap-16 w-100">
                <button type="submit" class="rs-btn">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>
<!-- Report Seller Modal End -->

{{-- message modal --}}
<div id="messageModal" class="rs-product-make-offer" style="display:none;">
    <div class="rs-product-make-offer-content rs-payment-popup-content-2">
        <button type="button" class="rs-product-make-offer-close rs-payment-popup-close-3"
            id="closeMessage"><i class="fas fa-times"></i></button>

        <h2 class="rs-product-make-offer-title">{{ __('Pošalji Poruku') }}</h2>
        <p>{{ __('Pošaljite poruku prodavcu direktno sa platforme.') }}</p>

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
@endsection
@push('script')
    <script>
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
            modal.style.display = 'flex';
        }

        // Close button
        document.getElementById('closeMessage').addEventListener('click', function() {
            document.getElementById('messageModal').style.display = 'none';
        });



        document.querySelector('#reportModal form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            axios.post(form.action, formData)
                .then(function(response) {
                    document.getElementById('reportModal').style.display = 'none';
                    form.reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    });
                })
                .catch(function(error) {
                    const errors = error.response.data.errors;
                    document.querySelectorAll('.report-error').forEach(el => el.remove());
                    Object.values(errors).forEach(function(messages) {
                        messages.forEach(function(msg) {
                            const p = document.createElement('p');
                            p.className = 'report-error';
                            p.style.color = 'red';
                            p.textContent = msg;
                            form.appendChild(p);
                        });
                    });
                });
        });
    </script>
@endpush
