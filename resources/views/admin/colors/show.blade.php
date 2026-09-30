@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Color Details'" :subtitle="'View Colors Details Here'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('colors.index')" :buttonIcon="'bi bi-arrow-left'" />

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="row g-5">

                {{-- Left: Color Preview --}}
                <div class="col-md-4 text-center">
                    <div class="rounded-4 h-100 p-4 border border-2">
                        <h6 class="fw-semibold text-muted mb-4">
                            <i class="bi bi-palette me-2"></i> {{ __('Color Preview') }}
                        </h6>

                        <div class="rounded-4 shadow-sm mx-auto"
                            style="width: 270px; height: 270px; background-color: {{ $color->code }}; border: 4px solid #e9ecef;"
                            aria-label="Color preview: {{ $color->code }}"></div>

                        <div class="mt-4">
                            <span class="px-4 py-2 rounded-3 text-white fw-bold shadow-sm fs-5"
                                style="background-color: {{ $color->code }}; letter-spacing: 0.1em;">
                                {{ strtoupper($color->code) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right: Details --}}
                <div class="col-md-8">
                    {{-- Color Name --}}
                    <div class="mb-4 p-2 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Color Name') }}
                        </span>
                        <h3 class="fw-bold mb-0 mt-2">{{ $color->name }}</h3>
                    </div>

                    {{-- Hex Code --}}
                    <div class="mb-4 p-2 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Hex Code') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">{{ strtoupper($color->code) }}</p>
                    </div>

                    {{-- Created At --}}
                    <div class="mb-4 p-2 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Created At') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $color->created_at->format('d M Y \a\t H:i') }}
                        </p>
                    </div>

                    {{-- Updated At --}}
                    <div class="p-2 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Updated At') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $color->updated_at->format('d M Y \a\t H:i') }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
