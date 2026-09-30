@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Brand Details'" :subtitle="'Manage All Brands'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('brand.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="row g-5">

                {{-- Left: Thumbnail --}}
                <div class="col-md-4 text-center">
                    <div class="rounded-4 h-100 p-4 border border-2">
                        <h6 class="fw-semibold text-muted mb-4">
                            <i class="bi bi-image me-2"></i> {{ __('Brand Logo') }}
                        </h6>

                        @if ($brand->thumbnail && $brand->thumbnail->src)
                            <img src="{{ asset('storage/' . $brand->thumbnail->src) }}" alt="{{ $brand->name }}"
                                class="img-fluid rounded-4 shadow-sm"
                                style="width: 300px; height: 300px; object-fit: cover; border: 4px solid #e9ecef;">
                        @else
                            <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center shadow-sm"
                                style="width: 300px; height: 300px; margin: 0 auto; border: 4px dashed #dee2e6;">
                                <i class="bi bi-image-alt fs-1 text-muted mb-3"></i>
                                <span class="text-muted small">{{ __('No logo uploaded') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right: Details --}}
                <div class="col-md-8 p-4">

                    {{-- Brand Name --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Brand Name') }}
                        </span>
                        <h3 class="fw-bold mb-0 mt-2">{{ $brand->name }}</h3>
                    </div>

                    {{-- Created At --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Created At') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $brand->created_at->timezone(config('app.timezone'))->format('d M Y \a\t H:i') }}
                        </p>

                    </div>

                    {{-- Updated At (optional, for consistency) --}}
                    <div class="p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Updated At') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $brand->updated_at->format('d M Y \a\t H:i') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Action Buttons (Bottom Right) --}}
            <x-edit-button :route="route('brand.edit', $brand->id)" :name="'Edit'">
            </x-edit-button>
        </div>
    @endsection
