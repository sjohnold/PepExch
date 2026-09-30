<section class="rs-category-area fix pb-48 mb-48">
    <div class="container">
        <div class="rs-section-title-wrapper text-center mb-40 wow tpFadeInUp pt-7" data-wow-duration="1s"
            data-wow-delay=".01s">
            <span class="rs-section-sub-title mb-6">
                {{ __('Category ') }}
            </span>
            <h2 class="rs-section-title fnw-600">
                {{ __('Explore Our Marketplace') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="rs-category-wrapper d-flex align-items-center justify-content-center">
                    @forelse ($frontendCategories as $category)
                        <div class="rs-category-box text-center wow tpFadeInUp" data-wow-duration="1s"
                            data-wow-delay=".01s">
                            <div class="rs-category-img">
                                @if ($category->thumbnail && $category->thumbnail->src)
                                    <img src="{{ asset('storage/' . $category->thumbnail->src) }}"
                                        alt="{{ $category->name }}">
                                @else
                                    <img src="{{ asset('assets/frontend/img/cat/default.png') }}"
                                        alt="{{ substr($category->name,0,20).'...' }}">
                                @endif
                            </div>
                            <h3 class="rs-category-title">
                                <a href="{{ route('products', $category->id) }}">
                                    {{ substr($category->name,0,20).'...' }}
                                </a>
                            </h3>
                            <span class="rs-category-item">
                                 {{ $category->activePost }} {{ __('ads Available') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-muted">{{ __('No categories available') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
