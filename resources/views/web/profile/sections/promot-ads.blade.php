@extends('web.profile.profile-master')
@section('promot-content')
    <!-- promote-ads-start -->

    <div class="col-xl-12 promote-ads">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-24"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('Promote Ads') }}
            </h2>
        </div>
        <div class="row">
            @foreach ($boostPlans as $boostPlan)
                <div class="col-md-6 col-12">
                    <div class="rs-promote-box fix">
                        <div class="rs-promote-content">
                            <div class="rs-promote-day d-flex align-items-center mb-16">
                                <span>{{ $boostPlan->sustain_days }}</span>
                                <cite>{{ __('Days') }}</cite>
                            </div>
                            <h3 class="rs-promote-title">{{ $boostPlan->name }}</h3>
                            <div class="rs-promote-text mb-16">
                                <p>
                                    {{ $boostPlan->description ?? 'N/A' }}
                                </p>

                                @if (!empty($boostPlan->plan_items))
                                    @php
                                        $items = is_array($boostPlan->plan_items)
                                            ? $boostPlan->plan_items
                                            : json_decode($boostPlan->plan_items, true);
                                    @endphp
                                    @if (!empty($items))
                                        <ul>
                                            @foreach ($items as $value)
                                                <li>{{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            </div>

                            <div class="rs-promote-bottom d-flex align-items-center justify-content-between">
                                <div class="rs-promote-price d-flex align-items-center gap-8">
                                    @if (!empty($boostPlan->discount_amount) && $boostPlan->discount_amount > 0)
                                        {{-- Discount Price --}}
                                        <span class="fw-bold text-danger">
                                            {{ currencyFormat(number_format($boostPlan->discount_amount, 2) )}}
                                        </span>
                                        {{-- Old Price --}}
                                        <span class="text-muted text-decoration-line-through fs-6">
                                            {{ currencyFormat(number_format($boostPlan->payable_amount, 2))}}
                                        </span>
                                    @else
                                        {{-- Normal Price --}}
                                        <span class="fw-bold text-danger">
                                            {{ currencyFormat(number_format($boostPlan->payable_amount, 2))}}
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('selling-post.promot', ['product_id' => $product->id, 'boost_plan_id' => $boostPlan->id]) }}"
                                    class="rs-promote-btn rs-btn rs-btn-2">
                                    {{ __('Promote') }}
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
