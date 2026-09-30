<section class="rs-count-area rs-count-cercle pb-60 pt-60 mb-85 fix">
    <div class="container">
        @if ($mainService)
            <div class="row">

                {{-- Main Section Title --}}
                <div class="rs-section-title-wrapper text-center mb-32">
                    <h2 class="rs-section-title mb-14">
                        {{ $mainService->title }}
                    </h2>
                    <p>
                        {{ $mainService->description }}
                    </p>
                </div>

                {{-- Loop Services --}}
                @foreach ($services as $service)
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-16">
                        <div class="rs-count-item d-flex align-items-start">
                            <div class="rs-count-icon">
                                <img src="{{ $service['thumbnail_url'] ?? 'https://placehold.co/250x250' }}"
                                    class="rounded-circle" style="width:60px; height:60px;">
                            </div>
                            <div class="rs-count-content">
                                <h3 class="rs-count-counter">
                                    <span class="text-red">
                                        {{ $service['title'] }}
                                    </span>
                                </h3>
                                <h5 class="rs-count-title">
                                    {{ $service['service_title'] }}
                                </h5>
                                <p class="rs-count-text">
                                    {{ $service['description'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
</section>
