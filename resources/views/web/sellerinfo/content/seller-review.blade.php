<div id="reviewModal" class="rs-product-make-offer" style="display: none;">
    <form action="{{ route('seller-info.review') }}" method="POST">
        @csrf
        <div class="rs-product-make-offer-content">
            <!-- Close Button -->
            <button class="rs-product-make-offer-close" id="closeReviewModal">
                <i class="fal fa-times"></i>
            </button>
            <h2 class="fns-40 fnw-600 text-center mb-24">{{ __('Give Review') }}</h2>

                <div class="rating text-center d-flex align-items-center gap-10 justify-content-center mb-14"
                    id="starRating">
                    <i class="fal fa-star" data-value="1"></i>
                    <i class="fal fa-star" data-value="2"></i>
                    <i class="fal fa-star" data-value="3"></i>
                    <i class="fal fa-star" data-value="4"></i>
                    <i class="fal fa-star" data-value="5"></i>
                    <input type="hidden" id="ratingValue" name="rating" value="0">
                    <input type="hidden" id="seller_id" name="seller_id" value="{{ $user->id }}">
                    <input type="hidden" id="reviewer_id" name="reviewer_id" value="{{ auth()->id() }}">
                </div>

            <div class="form-group">
                <label for="reviewMessage">{{ __('Details') }}</label>
                <textarea id="reviewMessage" name="comment" placeholder="Write Details"></textarea>
            </div>
            <div class="rs-payment-method-btn d-flex align-items-center gap-16 w-100">
                <button type="submit" class="rs-btn"> {{ __('Submit') }}</button>
            </div>
        </div>
    </form>
</div>
<!-- Review Modal eND -->

<div class="rs-riview-list-area p-24 br-4" data-bg-color="#F6F7F9">
    <div class="rs-riview-list-head d-flex align-items-center justify-content-between mb-24">
        <h4 class="rs-riview-list-title">
            {{ __(' All Review List ') }}
        </h4>
          @if ($product->user_id !== auth()->id())
        <button class="rs-header-btn rs-riview-list-btn rs-btn mr-0"
            id="openReviewModal">
            {{ __('Give Review ') }}
        </button>
        @endif
    </div>

    @forelse ($reviewes as $review)
        <div class="rs-riview-list-body">
            <div class="rs-riview-list-box p-24 br-4" data-bg-color="#fff">
                <div class="rs-riview-list-top d-flex align-items-center pb-16 mb-16">
                    <div class="rs-riview-list-author">
                        <img src="{{ $review->reviewer?->profilePhotoPath }}" alt="">
                    </div>
                    <div class="rs-riview-list-content d-flex align-items-center w-100">
                        <div class="rs-riview-list-name">
                            <span>{{ $review->reviewer?->name ?? '' }}</span>

                            <div class="rs-riview-list-reating d-flex align-items-center">
                                @for ($i = 1; $i <= ($review->rating ?? 0); $i++)
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset('assets/frontend/img/icon/start-02.svg') }}" alt="">
                                    </a>
                                @endfor
                                <span>({{ $review->rating ?? 'N/A' }})</span>

                            </div>
                        </div>
                        <div class="rs-riview-list-date">
                            <span>{{ $review->created_at->diffForHumans() ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="rs-riview-list-text">
                    <p>{{ $review->comment ?? '' }}</p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center">{{ __('No reviews found.') }}</p>
    @endforelse


    <!-- Pagination -->
    {{ $reviewes->links() }}
</div>
