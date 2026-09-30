@extends('web.profile.profile-master')
@section('review-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <h2 class="rs-profile-title">
                {{ __('Review') }}
            </h2>
        </div>
        <div class="rs-review-area br-8 p-16" data-bg-color="#F6F7F9">
            @forelse ($reviewes as $review)
                <div class="rs-review-box br-4 p-24" data-bg-color="#fff">
                    <div class="rs-review-top d-flex align-items-center justify-content-between mb-8">
                        <div class="rs-review-top-left d-flex align-items-center gap-8">
                            <div class="rs-review-img">
                                <img class="br-4" src="{{ asset('assets/frontend/img/abter/review-01.svg') }}"
                                    alt="">
                            </div>
                            <div class="rs-review-name">
                                <a href="javascript:void(0)">
                                    {{ $review->reviewer->name }}
                                </a>
                                <span>
                                    {{-- Student --}}
                                </span>
                            </div>
                        </div>

                        <div class="rs-review-right">
                            <button class="reportSellerBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                    fill="none">
                                    <path
                                        d="M12.4604 14.166H3.53788C2.57855 14.166 1.71188 13.6754 1.21854 12.8534C0.727211 12.0334 0.703115 11.0407 1.15311 10.1981L5.55709 1.96143C6.04575 1.04609 6.95917 0.5 7.99784 0.5C9.03651 0.5 9.94977 1.04609 10.4384 1.96143L14.8424 10.1981C15.2937 11.0407 15.2698 12.0334 14.7778 12.8534C14.2878 13.6754 13.4204 14.166 12.4604 14.166ZM7.99914 1.49935C7.33514 1.49935 6.7524 1.84797 6.43974 2.43197L2.03576 10.6686C1.75243 11.1986 1.76844 11.8227 2.07711 12.3387C2.38777 12.8567 2.93386 13.1654 3.53853 13.1654H12.4612C13.0659 13.1654 13.6125 12.856 13.9225 12.3387C14.2311 11.8234 14.2458 11.1993 13.9632 10.6686L9.5592 2.43197C9.24587 1.84797 8.66314 1.49935 7.99914 1.49935ZM8.49914 8.33268V5.66602C8.49914 5.39002 8.27514 5.16602 7.99914 5.16602C7.72314 5.16602 7.49914 5.39002 7.49914 5.66602V8.33268C7.49914 8.60868 7.72314 8.83268 7.99914 8.83268C8.27514 8.83268 8.49914 8.60868 8.49914 8.33268ZM8.67916 10.3327C8.67916 9.96468 8.38116 9.66602 8.01249 9.66602H8.00582C7.63782 9.66602 7.3424 9.96468 7.3424 10.3327C7.3424 10.7007 7.64449 10.9993 8.01249 10.9993C8.38049 10.9993 8.67916 10.7007 8.67916 10.3327Z"
                                        fill="#17181D"></path>
                                </svg>
                                {{ __('Report Seller') }}
                            </button>
                        </div>
                    </div>


                    <div class="rs-review-center d-flex align-items-center justify-content-between mb-12">
                        <div class="rs-riview-list-reating d-flex align-items-center">

                            @for ($i = 1; $i <= ($review->rating ?? 0); $i++)
                                <a href="javascript:void(0)">
                                    <img src="{{ asset('assets/frontend/img/icon/start-02.svg') }}" alt="">
                                </a>
                            @endfor
                        </div>

                        <div class="rs-review-date">
                            <span>{{ $review->created_at->diffForHumans() ?? '' }}</span>
                        </div>
                    </div>
                    <div class="rs-review-text">
                        <p>
                            {{ $review->comment ?? '' }}
                        </p>
                    </div>
                </div>

            @empty
                <div class="rs-profile-head d-flex align-items-center justify-content-center br-8 p-8 mb-8 not-found-bg">
                    <h2 class="text-center mb-0">
                        {{ __('No Reviews Found') }}
                    </h2>
                </div>
            @endforelse
            <!-- Pagination -->
            <div class="my-4">
                {{ $reviewes->links() }}
            </div>

        </div>

    </div>
@endsection
