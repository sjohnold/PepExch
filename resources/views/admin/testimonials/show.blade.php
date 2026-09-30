@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Testimonials Details'" :buttonText="'Back'" :buttonRoute="route('testimonials.index')" :buttonIcon="'bi bi-arrow-left'" />


    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Main Card --}}
            <div class="card border-0 rounded-4 overflow-hidden shadow-lg"
                style="background: linear-gradient(135deg, #46262a 0%, #000000 100%);">

                <div class="card-body p-5">
                    {{-- Profile Section --}}
                    <div class="d-flex align-items-center mb-5 position-relative">
                        {{-- Avatar with Glow Effect --}}
                        <div class="position-relative me-4">
                            <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle"
                                style="background: linear-gradient(135deg, #3282b8, #0f4c75);
                                            filter: blur(15px); opacity: 0.6;
                                            transform: scale(1.1);">
                            </div>
                            <img src="{{ $testimonial->thumbnail_path }}" alt="{{ $testimonial->name }}"
                                class="rounded-circle position-relative border border-3 border-light"
                                style="width: 110px;
                                            height: 110px;
                                            object-fit: cover;
                                            box-shadow: 0 8px 25px rgba(50, 130, 184, 0.4);">
                        </div>

                        {{-- Name & Designation --}}
                        <div class="flex-grow-1">
                            <h3 class="mb-2 fw-bold text-white" style="letter-spacing: 0.5px;">
                                {{ $testimonial->name }}
                            </h3>
                            <div class="d-inline-block px-3 py-1 rounded-pill"
                                style="background: rgba(50, 130, 184, 0.2);
                                            border: 1px solid rgba(187, 225, 250, 0.3);">
                                <h6 class="mb-0 text-light fw-normal" style="font-size: 0.95rem;">
                                    {{ $testimonial->designation }}
                                </h6>
                            </div>
                        </div>

                        {{-- Decorative Quote Icon --}}
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="fas fa-quote-right" style="font-size: 4rem; color: #3282b8;"></i>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <hr style="border-color: rgba(187, 225, 250, 0.2); margin: 2rem 0;">

                    {{-- Rating Stars --}}
                    <div class="mb-4 d-flex align-items-center gap-3">
                        <div class="fs-4" style="letter-spacing: 4px;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $testimonial->rating)
                                    <i class="fas fa-star"
                                        style="color: #ffd700; text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);"></i>
                                @else
                                    <i class="far fa-star" style="color: #666;"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="badge rounded-pill px-3 py-2"
                            style="background: linear-gradient(135deg, #ffd700, #ffed4e);
                                         color: #1a1a2e;
                                         font-weight: 600;
                                         font-size: 0.9rem;">
                            {{ $testimonial->rating }}/5
                        </span>
                    </div>

                    {{-- Description/Testimonial --}}
                    <div class="position-relative">
                        {{-- Left Quote Mark --}}
                        <i class="fas fa-quote-left position-absolute"
                            style="font-size: 2rem;
                                      color: rgba(50, 130, 184, 0.3);
                                      top: -10px;
                                      left: -10px;"></i>

                        <p class="mb-0 text-white-50 ps-4 pe-3"
                            style="font-size: 1.15rem;
                                      line-height: 2;
                                      font-weight: 300;
                                      letter-spacing: 0.3px;
                                      text-align: justify;">
                            {{ $testimonial->description }}
                        </p>

                        {{-- Right Quote Mark --}}
                        <i class="fas fa-quote-right position-absolute"
                            style="font-size: 2rem;
                                      color: rgba(50, 130, 184, 0.3);
                                      bottom: -10px;
                                      right: 0;"></i>
                    </div>
                </div>
            </div>

            {{-- Subtle Shadow Effect Below Card --}}
            <div class="text-center mt-3">
                <div
                    style="width: 80%;
                                height: 15px;
                                margin: 0 auto;
                                background: radial-gradient(ellipse, rgba(49, 38, 9, 0.3) 0%, transparent 70%);
                                filter: blur(8px);">
                </div>
            </div>
        </div>
    </div>
@endsection
