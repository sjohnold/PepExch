@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Category Details'" :buttonText="'Back'" :buttonRoute="route('category.index')" :buttonIcon="'bi bi-arrow-left'" />

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="row g-5">

                {{-- Left: Thumbnail --}}
                <div class="col-md-4 text-center">
                    <div class="rounded-4 h-100 p-4 border border-2">
                        <h6 class="fw-semibold text-muted mb-4">
                            <i class="bi bi-image me-2"></i> {{ __('Category Image') }}
                        </h6>

                        @if ($category->thumbnail && $category->thumbnail->src)
                            <img src="{{ asset('storage/' . $category->thumbnail->src) }}" alt="{{ $category->name }}"
                                class="img-fluid rounded-4 shadow-sm"
                                style="width: 300px; height: 300px; object-fit: cover; border: 4px solid #e9ecef;">
                        @else
                            <div class="bg-light rounded-4 d-flex flex-column align-items-center justify-content-center shadow-sm"
                                style="width: 300px; height: 300px; margin: 0 auto; border: 4px dashed #dee2e6;">
                                <i class="bi bi-image-alt fs-1 text-muted mb-3"></i>
                                <span class="text-muted small">{{ __('No image uploaded') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right: Details --}}
                <div class="col-md-8 p-4">

                    {{-- Category Name --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Category Name') }}
                        </span>
                        <h3 class="fw-bold mb-0 mt-2">{{ $category->name }}</h3>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-4 p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                            {{ __('Parent Category') }}
                        </span>
                        <p class="fw-semibold mb-0 mt-2">
                            {{ $category->parent_id ? $category->parent->name : 'No Parent' }}
                        </p>
                    </div>

                    {{-- Sub Categories --}}
                    <div class="p-4 rounded-4 bg-light">
                        <span class="text-uppercase text-muted small fw-medium d-block mb-3" style="letter-spacing: 0.08em;">
                            <i class="bi bi-diagram-3 me-1"></i> {{ __('Sub Categories') }}
                        </span>

                        @if ($category->child->count())
                            <div class="list-group list-group-flush">

                                @foreach ($category->child as $sub)
                                    <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center border-bottom"
                                        style="background:transparent; transition:0.25s ease;"
                                        onmouseover="this.style.background='#ffffff'"
                                        onmouseout="this.style.background='transparent'">

                                        <div class="d-flex align-items-center gap-3">
                                            @if ($sub->thumbnail && $sub->thumbnail->src)
                                                <img src="{{ asset('storage/' . $sub->thumbnail->src) }}"
                                                    alt="{{ $sub->name }}" class="rounded-3 shadow-sm"
                                                    style="width:48px;height:48px;object-fit:cover;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width:48px;height:48px;">
                                                    <i class="bi bi-folder text-muted"></i>
                                                </div>
                                            @endif

                                            <span class="fw-semibold">{{ $sub->name }}</span>
                                        </div>

                                        <a href="{{ route('category.show', $sub->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <p class="text-muted mb-0">{{ __('No sub categories available.') }}</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
