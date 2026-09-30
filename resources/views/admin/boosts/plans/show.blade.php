@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Boost Plan Details'" :buttonText="'Back'" :buttonRoute="route('plans.index')" :buttonIcon="'bi bi-arrow-left'" />

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="row g-5">

                {{-- Left: Thumbnail --}}
                <div class="col-md-4 text-center">
                    <div class="rounded-4 p-4 border border-2">
                        <h6 class="fw-semibold text-muted mb-4">
                            <i class="bi bi-image me-2"></i> {{ __('Plan Thumbnail') }}
                        </h6>

                        @if ($plan->thumbnail && $plan->thumbnail->src)
                            <img src="{{ asset('storage/' . $plan->thumbnail->src) }}" alt="{{ $plan->name }}"
                                class="img-fluid rounded-4 shadow-sm"
                                style="width:100; height:100; object-fit:cover; border:4px solid #e9ecef;">
                        @else
                            <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center shadow-sm"
                                style="width:300px; height:300px; margin:0 auto; border:4px dashed #dee2e6;">
                                <i class="bi bi-image-alt fs-1 text-muted mb-3"></i>
                                <span class="text-muted small">{{ __('No image uploaded') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right: Details --}}
                <div class="col-md-8 p-4">

                    {{-- Plan Name --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing:0.08em;">
                            {{ __('Plan Name') }}
                        </span>
                        <h3 class="fw-bold mb-0 mt-2">
                            {{ $plan->name }}
                        </h3>
                    </div>

                    {{-- Payable Amount --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing:0.08em;">
                            {{ __('Payable Amount') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $plan->payable_amount }}
                        </p>
                    </div>

                    {{-- Discount Amount --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing:0.08em;">
                            {{ __('Discount Amount') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $plan->discount_amount ?? '-' }}
                        </p>
                    </div>

                    {{-- Sustain Days --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing:0.08em;">
                            {{ __('Sustain Days') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $plan->sustain_days }}
                        </p>
                    </div>

                    {{-- Plan Items --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium d-block mb-3" style="letter-spacing:0.08em;">
                            <i class="bi bi-list-check me-1"></i> {{ __('Plan Items') }}
                        </span>

                        @if (is_array($planItems))
                            <div class="list-group list-group-flush">
                                @foreach ($planItems as $item)
                                    <div class="list-group-item px-0 py-3 border-bottom" style="background:transparent;">
                                        <span class="fw-semibold">
                                            {{ $loop->iteration }}. {{ $item }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">-</p>
                        @endif
                    </div>


                    {{-- Description --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing:0.08em;">
                            {{ __('Description') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $plan->description }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
