@extends('web.layouts.master')
@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <!-- Filter Offcanvas -->
    <div class="rs-filter-offcanvas d-lg-none">
        <div class="rs-filter-inner">

        </div>
    </div>
    <div class="rs-filter-overlay d-lg-none"></div>
    <!-- header end -->
    <!-- product-view-area start -->
    <section class="rs-product-view-area mt-33">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <div class="rs-product-filter-area">
                        <div class="rs-product-filter-head d-flex align-items-center justify-content-between">
                            <h5 class="rs-product-filter-title">
                                {{ __('Filter ') }}
                            </h5>
                            <button class="rs-filter-close d-lg-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none">
                                    <path
                                        d="M13.5297 12.4707C13.8227 12.7637 13.8227 13.2388 13.5297 13.5318C13.3837 13.6778 13.1917 13.7517 12.9997 13.7517C12.8077 13.7517 12.6158 13.6788 12.4698 13.5318L6.99975 8.06173L1.52975 13.5318C1.38375 13.6778 1.19175 13.7517 0.999749 13.7517C0.807749 13.7517 0.61575 13.6788 0.46975 13.5318C0.17675 13.2388 0.17675 12.7637 0.46975 12.4707L5.93975 7.00076L0.46975 1.53079C0.17675 1.23779 0.17675 0.76275 0.46975 0.46975C0.76275 0.17675 1.23775 0.17675 1.53075 0.46975L7.00076 5.93978L12.4707 0.46975C12.7637 0.17675 13.2387 0.17675 13.5317 0.46975C13.8247 0.76275 13.8247 1.23779 13.5317 1.53079L8.06175 7.00076L13.5297 12.4707Z"
                                        fill="#F04438"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="filter-box">
                            <!-- Filter by Price -->
                            <form id="filterForm" method="GET" action="{{ route('products') }}">
                                <div class="d-flex justify-content-between align-items-center mb-26">
                                    <h6 class="filter-title">{{ __('Filter by Price') }}</h6>
                                    <a href="{{ route('products') }}"
                                        class="btn-filter rs-btn ml-auto mr-5">{{ __('Reset') }}</a>
                                    <button class="btn-filter rs-btn">{{ __('Filter') }}</button>
                                </div>

                                <!-- Dual Range Slider -->
                                <div class="range-slider">
                                    <div class="progress" id="progress"></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" class="min-range" name="min_price" min="0" max="67000"
                                        step="10" value="{{ request('min_price', 0) }}">
                                    <input type="range" class="max-range" name="max_price" min="0" max="67000"
                                        step="10" value="{{ request('max_price', 67000) }}">
                                </div>

                                <p class="range-values">
                                    {{ __('Price') }}:
                                    <cite>
                                        <span id="minVal">{{ request('min_price', 0) }}</span>

                                    </cite>
                                    <cite>
                                        <span id="maxVal">{{ request('max_price', 67000) }}</span>


                                    </cite>
                                </p>



                                <!-- Accordion Filters -->
                                <div class="accordion" id="filterAccordion">

                                    <!-- Condition -->

                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button
                                                class="rs-product-filter-accordion collapsed d-flex align-items-center justify-content-between w-100"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseCondition">
                                                {{ __('Condition') }}
                                                <div class="rs-product-filter-accordion-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                                        viewBox="0 0 10 6" fill="none">
                                                        <path
                                                            d="M4.99978 5.75076C4.80778 5.75076 4.61575 5.67778 4.46975 5.53079L0.46975 1.53079C0.17675 1.23779 0.17675 0.76275 0.46975 0.46975C0.76275 0.17675 1.23779 0.17675 1.53079 0.46975L5.00076 3.93972L8.47073 0.46975C8.76373 0.17675 9.23876 0.17675 9.53176 0.46975C9.82476 0.76275 9.82476 1.23779 9.53176 1.53079L5.53176 5.53079C5.38376 5.67778 5.19178 5.75076 4.99978 5.75076Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapseCondition" class="accordion-collapse collapse show"
                                            data-bs-parent="#filterAccordion">
                                            <div class="accordion-body pl-0 pt-0 pb-16 pr-0">
                                                @foreach ($conditions as $condition)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="conditions[]"
                                                            value="{{ $condition }}"
                                                            onchange="document.getElementById('filterForm').submit()"
                                                            @if (is_array(request('conditions')) && in_array($condition, request('conditions'))) checked @endif>
                                                        <label>{{ $condition }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button
                                                class="rs-product-filter-accordion collapsed d-flex align-items-center justify-content-between w-100"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseLocation">
                                                {{ __('Location') }}
                                                <div class="rs-product-filter-accordion-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                                        viewBox="0 0 10 6" fill="none">
                                                        <path
                                                            d="M4.99978 5.75076C4.80778 5.75076 4.61575 5.67778 4.46975 5.53079L0.46975 1.53079C0.17675 1.23779 0.17675 0.76275 0.46975 0.46975C0.76275 0.17675 1.23779 0.17675 1.53079 0.46975L5.00076 3.93972L8.47073 0.46975C8.76373 0.17675 9.23876 0.17675 9.53176 0.46975C9.82476 0.76275 9.82476 1.23779 9.53176 1.53079L5.53176 5.53079C5.38376 5.67778 5.19178 5.75076 4.99978 5.75076Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapseLocation" class="accordion-collapse collapse show"
                                            data-bs-parent="#filterAccordion">
                                            <div class="accordion-body pl-0 pt-0 pb-16 pr-0">
                                                @php $count = 0; @endphp
                                                @foreach ($locations as $location => $countValue)
                                                    @if ($location)
                                                        <div class="form-check location-item"
                                                            style="{{ $count < 15 ? '' : 'display:none;' }}">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="location[]" value="{{ $location }}"
                                                                onchange="this.form.submit()"
                                                                @if (is_array(request('location')) && in_array($location, request('location'))) checked @endif>
                                                            <label>
                                                                {{ Str::limit($location, 25, '...') }}
                                                                <span>{{ $countValue }}</span>
                                                            </label>
                                                        </div>
                                                        @php $count++; @endphp
                                                    @endif
                                                @endforeach

                                                @if ($count > 15)
                                                    <button id="loadMoreLocations"
                                                        class="btn btn-link mt-2">{{ __('Load More') }}</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Brand -->
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button
                                                class="rs-product-filter-accordion collapsed d-flex align-items-center justify-content-between w-100"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand">
                                                {{ __('Brand ') }}
                                                <div class="rs-product-filter-accordion-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                                        viewBox="0 0 10 6" fill="none">
                                                        <path
                                                            d="M4.99978 5.75076C4.80778 5.75076 4.61575 5.67778 4.46975 5.53079L0.46975 1.53079C0.17675 1.23779 0.17675 0.76275 0.46975 0.46975C0.76275 0.17675 1.23779 0.17675 1.53079 0.46975L5.00076 3.93972L8.47073 0.46975C8.76373 0.17675 9.23876 0.17675 9.53176 0.46975C9.82476 0.76275 9.82476 1.23779 9.53176 1.53079L5.53176 5.53079C5.38376 5.67778 5.19178 5.75076 4.99978 5.75076Z"
                                                            fill="currentColor" />
                                                    </svg></div>
                                            </button>
                                        </h2>
                                        <div id="collapseBrand" class="accordion-collapse collapse show"
                                            data-bs-parent="#filterAccordion">
                                            <div class="accordion-body pl-0 pt-0 pb-16 pr-0">
                                                @foreach ($brands as $brand => $count)
                                                    @if ($brand)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="brand[]" value="{{ $brand }}"
                                                                onchange="document.getElementById('filterForm').submit()"
                                                                @if (is_array(request('brand')) && in_array($brand, request('brand'))) checked @endif>
                                                            <label>{{ Str::limit($brand, 25, '...') }}
                                                                <span>{{ $count }}</span></label>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Date Posted -->
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button
                                                class="rs-product-filter-accordion collapsed d-flex align-items-center justify-content-between w-100"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseDate">
                                                {{ __('Date Posted') }}
                                                <div class="rs-product-filter-accordion-icon"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                                        viewBox="0 0 10 6" fill="none">
                                                        <path
                                                            d="M4.99978 5.75076C4.80778 5.75076 4.61575 5.67778 4.46975 5.53079L0.46975 1.53079C0.17675 1.23779 0.17675 0.76275 0.46975 0.46975C0.76275 0.17675 1.23779 0.17675 1.53079 0.46975L5.00076 3.93972L8.47073 0.46975C8.76373 0.17675 9.23876 0.17675 9.53176 0.46975C9.82476 0.76275 9.82476 1.23779 9.53176 1.53079L5.53176 5.53079C5.38376 5.67778 5.19178 5.75076 4.99978 5.75076Z"
                                                            fill="currentColor" />
                                                    </svg></div>
                                            </button>
                                        </h2>
                                        <div id="collapseDate" class="accordion-collapse collapse show"
                                            data-bs-parent="#filterAccordion">
                                            <div class="accordion-body pl-0 pt-0 pb-16 pr-0">
                                                @foreach ($DateFilters as $label => $count)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="date[]"
                                                            value="{{ $label }}"
                                                            onchange="document.getElementById('filterForm').submit()"
                                                            @if (is_array(request('date')) && in_array($label, request('date'))) checked @endif>
                                                        <label>{{ $label }}
                                                            <span>{{ $count }}</span></label>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-12">
                <div class="rs-product-head d-flex align-items-center justify-content-between mb-16">
                    <h2 class="rs-product-head-title">
                        {{ __('Product List') }}
                    </h2>
                    <div class="rs-product-head-right d-flex align-items-center gap-16">
                        <div class="rs-filter-side-btn rs-filter-open-btn">
                            <button class="d-lg-none d-flex align-items-center gap-16">
                                {{ __('Filter ') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18"
                                    viewBox="0 0 16 18" fill="none">
                                    <path
                                        d="M1.5 0H14.5C15.328 0 16 0.672 16 1.5V3.75699C16 4.15499 15.842 4.53599 15.561 4.81799L10.4399 9.939C10.1589 10.22 10.001 10.602 10.001 11V18L6.00098 15V11C6.00098 10.602 5.84302 10.221 5.56202 9.939L0.441044 4.81799C0.160044 4.53699 0.00195758 4.15499 0.00195758 3.75699V1.5C-4.24227e-05 0.672 0.672004 0 1.5 0Z"
                                        fill="#17181D" />
                                </svg>
                            </button>
                        </div>
                        <div class="rs-product-price-menu">
                            <ul>
                                <li>
                                    <div class="rs-product-price-dropdown">
                                        <ul>
                                            <li>
                                                <a
                                                    onclick="window.location.href='{{ route('products', ['price_sort' => 'all']) }}'">
                                                    {{ __('All') }}
                                                </a>
                                                <a
                                                    onclick="window.location.href='{{ route('products', ['price_sort' => 'low_high']) }}'">
                                                    {{ __('Price - Low to High') }}
                                                </a>
                                                <a
                                                    onclick="window.location.href='{{ route('products', ['price_sort' => 'high_low']) }}'">
                                                    {{ __('Price - High to Low') }}
                                                </a>
                                                <a
                                                    onclick="window.location.href='{{ route('products', ['price_sort' => 'recent']) }}'">
                                                    {{ __('Recent Item') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="javascript:void(0)">
                                        {{ __('Price - Low to High') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                            viewBox="0 0 10 6" fill="none">
                                            <path
                                                d="M9.35426 1.35328L5.35426 5.35328C5.25626 5.45128 5.12825 5.49928 5.00025 5.49928C4.87225 5.49928 4.74425 5.45028 4.64625 5.35328L0.64625 1.35328C0.45125 1.15828 0.45125 0.84125 0.64625 0.64625C0.84125 0.45125 1.15828 0.45125 1.35328 0.64625L4.99928 4.29225L8.64527 0.64625C8.84027 0.45125 9.1573 0.45125 9.3523 0.64625C9.5473 0.84125 9.54926 1.15728 9.35426 1.35328Z"
                                                fill="currentColor" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="rs-product-menu-icon d-flex align-items-center gap-16">
                            <a href="javascript:void(0)" class="rs-product-menu__icon rs-product-menu__icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                                    viewBox="0 0 20 18" fill="none">
                                    <path
                                        d="M7.25 2.5C7.25 2.086 7.586 1.75 8 1.75H19C19.414 1.75 19.75 2.086 19.75 2.5C19.75 2.914 19.414 3.25 19 3.25H8C7.586 3.25 7.25 2.914 7.25 2.5ZM19 8.25H8C7.586 8.25 7.25 8.586 7.25 9C7.25 9.414 7.586 9.75 8 9.75H19C19.414 9.75 19.75 9.414 19.75 9C19.75 8.586 19.414 8.25 19 8.25ZM19 14.75H8C7.586 14.75 7.25 15.086 7.25 15.5C7.25 15.914 7.586 16.25 8 16.25H19C19.414 16.25 19.75 15.914 19.75 15.5C19.75 15.086 19.414 14.75 19 14.75ZM4.75 2.5C4.75 3.741 3.741 4.75 2.5 4.75C1.259 4.75 0.25 3.741 0.25 2.5C0.25 1.259 1.259 0.25 2.5 0.25C3.741 0.25 4.75 1.259 4.75 2.5ZM3.25 2.5C3.25 2.086 2.914 1.75 2.5 1.75C2.086 1.75 1.75 2.086 1.75 2.5C1.75 2.914 2.086 3.25 2.5 3.25C2.914 3.25 3.25 2.914 3.25 2.5ZM4.75 9C4.75 10.241 3.741 11.25 2.5 11.25C1.259 11.25 0.25 10.241 0.25 9C0.25 7.759 1.259 6.75 2.5 6.75C3.741 6.75 4.75 7.759 4.75 9ZM3.25 9C3.25 8.586 2.914 8.25 2.5 8.25C2.086 8.25 1.75 8.586 1.75 9C1.75 9.414 2.086 9.75 2.5 9.75C2.914 9.75 3.25 9.414 3.25 9ZM4.75 15.5C4.75 16.741 3.741 17.75 2.5 17.75C1.259 17.75 0.25 16.741 0.25 15.5C0.25 14.259 1.259 13.25 2.5 13.25C3.741 13.25 4.75 14.259 4.75 15.5ZM3.25 15.5C3.25 15.086 2.914 14.75 2.5 14.75C2.086 14.75 1.75 15.086 1.75 15.5C1.75 15.914 2.086 16.25 2.5 16.25C2.914 16.25 3.25 15.914 3.25 15.5Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="rs-product-menu__icon rs-product-menu__icon-2 active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M15.5 7.75H12.5C11.091 7.75 10.25 6.909 10.25 5.5V2.5C10.25 1.091 11.091 0.25 12.5 0.25H15.5C16.909 0.25 17.75 1.091 17.75 2.5V5.5C17.75 6.909 16.909 7.75 15.5 7.75ZM12.5 1.75C11.911 1.75 11.75 1.911 11.75 2.5V5.5C11.75 6.089 11.911 6.25 12.5 6.25H15.5C16.089 6.25 16.25 6.089 16.25 5.5V2.5C16.25 1.911 16.089 1.75 15.5 1.75H12.5ZM5.5 7.75H2.5C1.091 7.75 0.25 6.909 0.25 5.5V2.5C0.25 1.091 1.091 0.25 2.5 0.25H5.5C6.909 0.25 7.75 1.091 7.75 2.5V5.5C7.75 6.909 6.909 7.75 5.5 7.75ZM2.5 1.75C1.911 1.75 1.75 1.911 1.75 2.5V5.5C1.75 6.089 1.911 6.25 2.5 6.25H5.5C6.089 6.25 6.25 6.089 6.25 5.5V2.5C6.25 1.911 6.089 1.75 5.5 1.75H2.5ZM15.5 17.75H12.5C11.091 17.75 10.25 16.909 10.25 15.5V12.5C10.25 11.091 11.091 10.25 12.5 10.25H15.5C16.909 10.25 17.75 11.091 17.75 12.5V15.5C17.75 16.909 16.909 17.75 15.5 17.75ZM12.5 11.75C11.911 11.75 11.75 11.911 11.75 12.5V15.5C11.75 16.089 11.911 16.25 12.5 16.25H15.5C16.089 16.25 16.25 16.089 16.25 15.5V12.5C16.25 11.911 16.089 11.75 15.5 11.75H12.5ZM5.5 17.75H2.5C1.091 17.75 0.25 16.909 0.25 15.5V12.5C0.25 11.091 1.091 10.25 2.5 10.25H5.5C6.909 10.25 7.75 11.091 7.75 12.5V15.5C7.75 16.909 6.909 17.75 5.5 17.75ZM2.5 11.75C1.911 11.75 1.75 11.911 1.75 12.5V15.5C1.75 16.089 1.911 16.25 2.5 16.25H5.5C6.089 16.25 6.25 16.089 6.25 15.5V12.5C6.25 11.911 6.089 11.75 5.5 11.75H2.5Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>


                @if ($products->isEmpty())
                    <div class="text-center py-40">
                        <p>{{ __('No posts found in this category.') }}</p>
                    </div>
                @else

                    <form id="filterByCategory" method="GET" action="{{ route('products') }}">
                        <div class="rs-product-name">
                            <div class="swiper rs-product-name-slide">

                                {{-- Preserve other filters --}}
                                @if (request('conditions'))
                                    @foreach (request('conditions') as $cond)
                                        <input type="hidden" name="conditions[]" value="{{ $cond }}">
                                    @endforeach
                                @endif

                                @if (request('brand'))
                                    @foreach (request('brand') as $b)
                                        <input type="hidden" name="brand[]" value="{{ $b }}">
                                    @endforeach
                                @endif

                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">

                                <div class="swiper-wrapper">
                                    @foreach ($allCategories as $category)
                                        <div class="swiper-slide">
                                            <button type="button"
                                                class="rs-product-filter {{ request('category') == $category->id ? 'active' : '' }}"
                                                onclick="
                                document.getElementById('categoryInput').value='{{ $category->id }}';
                                document.getElementById('filterByCategory').submit();
                            ">
                                                {{ $category->name }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="rs-navigation-button p-relative">
                            <div class="rs-product-button-next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16"
                                    fill="none">
                                    <path
                                        d="M7.50003 14.6004L2.0667 9.16706C1.42503 8.52539 1.42503 7.47539 2.0667 6.83372L7.50003 1.40039"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="rs-product-button-prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16"
                                    fill="none">
                                    <path
                                        d="M7.50003 14.6004L2.0667 9.16706C1.42503 8.52539 1.42503 7.47539 2.0667 6.83372L7.50003 1.40039"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>


                        {{-- Selected category --}}
                        <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
                    </form>
                @endif


                    <div class="row rs-product-list-view-1">
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                <x-product-card :product="$product" :wishlist-ids="getWishlistIds()" />
                            </div>
                        @endforeach
                    </div>

                    <div class="row grid rs-product-list-view-2">
                        @foreach ($products as $product)
                            <div class="col-lg-12 grid-item">
                                <div
                                    class="rs-product-box rs-product-box-2 rs-product-box-3 d-flex align-items-center gap-16">
                                    <div class="rs-product-thumb rs-product-thumb-2 p-relative">
                                        <a class="popup-image"
                                            href="{{ Storage::url($product->thumbnails->first()?->src) ?? asset('assets/frontend/img/product/default.png') }}">
                                            <img src="{{ Storage::url($product->thumbnails->first()?->src) ?? asset('assets/frontend/img/product/default.png') }}"
                                                alt="">
                                        </a>
                                        <div class="rs-product-thumb-love p-absolute"
                                            onClick="addToWishlist({{ $product->id }}, this)">
                                            <svg class="love-icon {{ in_array($product->id, getWishlistIds() ?? []) ? 'active' : '' }}"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="22"
                                                viewBox="0 0 24 22" fill="none">
                                                <path
                                                    d="M12 21C11.7 21 11.4 20.93 11.15 20.8C7.2 18.75 1 14.28 1 8.5C1 5.42 3.42 3 6.5 3C8.24 3 9.91 3.81 11 5.08C12.09 3.81 13.76 3 15.5 3C18.58 3 21 5.42 21 8.5C21 14.28 14.8 18.75 10.85 20.8C10.6 20.93 10.3 21 10 21H12Z"
                                                    stroke="#17181D" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="rs-product-content rs-product-content-2  p-0">
                                        <div class="rs-product-location">
                                            <a href="javascript:void(0)" class="mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path
                                                        d="M7 0.6875C3.38125 0.6875 0.4375 3.63125 0.4375 7.25C0.4375 11.0885 3.96024 13.415 6.29124 14.9547L6.688 15.218C6.7825 15.281 6.89125 15.3125 7 15.3125C7.10875 15.3125 7.2175 15.281 7.312 15.218L7.70876 14.9547C10.0398 13.415 13.5625 11.0885 13.5625 7.25C13.5625 3.63125 10.6187 0.6875 7 0.6875ZM7.08925 14.0157L7 14.0751L6.91075 14.0157C4.65325 12.5247 1.5625 10.4832 1.5625 7.25C1.5625 4.2515 4.0015 1.8125 7 1.8125C9.9985 1.8125 12.4375 4.2515 12.4375 7.25C12.4375 10.4832 9.346 12.5255 7.08925 14.0157ZM7 4.8125C5.656 4.8125 4.5625 5.906 4.5625 7.25C4.5625 8.594 5.656 9.6875 7 9.6875C8.344 9.6875 9.4375 8.594 9.4375 7.25C9.4375 5.906 8.344 4.8125 7 4.8125ZM7 8.5625C6.27625 8.5625 5.6875 7.97375 5.6875 7.25C5.6875 6.52625 6.27625 5.9375 7 5.9375C7.72375 5.9375 8.3125 6.52625 8.3125 7.25C8.3125 7.97375 7.72375 8.5625 7 8.5625Z"
                                                        fill="#358CEF" />
                                                </svg>
                                                <td>{{ getLocationName($product->latitude, $product->longitude) }}</td>
                                            </a>
                                        </div>
                                        <a href="{{ route('product-details', $product->id) }}">
                                            <h3 class="rs-product-title view-2-product-title">
                                                {{ $product->name ?? 'Untitled Product' }}</h3>

                                        </a>
                                        <a href="javascript:void(0)"
                                            class="rs-product-condition d-flex align-items-center mb-8">
                                            {{ __('Condition:') }} &nbsp;
                                            <span class="rs-product-border">
                                                {{ $product->conditions ?? 'N/A' }}
                                            </span>
                                            <span class="rs-product-time rs-product-time-2  ml-48">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M9 0.9375C4.554 0.9375 0.9375 4.554 0.9375 9C0.9375 13.446 4.554 17.0625 9 17.0625C13.446 17.0625 17.0625 13.446 17.0625 9C17.0625 4.554 13.446 0.9375 9 0.9375ZM9 15.9375C5.17425 15.9375 2.0625 12.8258 2.0625 9C2.0625 5.17425 5.17425 2.0625 9 2.0625C12.8258 2.0625 15.9375 5.17425 15.9375 9C15.9375 12.8258 12.8258 15.9375 9 15.9375ZM11.6475 10.8525C11.8673 11.0722 11.8673 11.4285 11.6475 11.6483C11.538 11.7578 11.394 11.8132 11.25 11.8132C11.106 11.8132 10.962 11.7585 10.8525 11.6483L8.60248 9.39825C8.49673 9.2925 8.4375 9.14923 8.4375 9.00073V5.25073C8.4375 4.94023 8.6895 4.68823 9 4.68823C9.3105 4.68823 9.5625 4.94023 9.5625 5.25073V8.76746L11.6475 10.8525Z"
                                                        fill="#687387" />
                                                </svg>
                                                {{ $product->created_at ? $product->created_at->diffForHumans() : 'Just now' }}
                                            </span>
                                        </a>
                                        <div
                                            class="rs-product-price rs-product-price-2 d-flex align-items-center justify-content-between mb-12">
                                            <b>
                                                {{ currencyFormat($product->asking_price) ?? '0.00' }}
                                            </b>
                                        </div>
                                    </div>
                                    <div class="rs-product-btn rs-product-btn-2 d-flex flex-column gap-16 ml-auto mr-16">
                                        <a href="{{ route('product-details', $product->id) }}"
                                            class="rs-product-details-btn rs-product-details-btn-3 rs-product-details-btn-2 d-flex align-items-center justify-content-between ml-16  rs-product-btn-3">
                                            {{ __('View Details') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                viewBox="0 0 20 16" fill="currentColor">
                                                <path
                                                    d="M19.6919 8.28713C19.6539 8.37913 19.599 8.46203 19.53 8.53103L12.53 15.531C12.384 15.677 12.192 15.751 12 15.751C11.808 15.751 11.616 15.678 11.47 15.531C11.177 15.238 11.177 14.763 11.47 14.47L17.1899 8.75002H1C0.586 8.75002 0.25 8.41402 0.25 8.00002C0.25 7.58602 0.586 7.25002 1 7.25002H17.189L11.469 1.53005C11.176 1.23705 11.176 0.762018 11.469 0.469018C11.762 0.176018 12.237 0.176018 12.53 0.469018L19.53 7.46902C19.599 7.53802 19.6539 7.62091 19.6919 7.71291C19.7679 7.89691 19.7679 8.10313 19.6919 8.28713Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </a>
                                        <button
                                            class="makeOfferBtn makeOfferBtn-2  rs-btn rs-product-offer-btn d-flex align-items-center justify-content-center ml-16  rs-product-btn-3">
                                            {{ __('Make Offer') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                                viewBox="0 0 25 24" fill="none">
                                                <path d="M8.5 11L12.5 11" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path d="M8.5 16H16.5" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path
                                                    d="M21.5 9V18C21.5 20.2091 19.7091 22 17.5 22H7.5C5.29086 22 3.5 20.2091 3.5 18V6C3.5 3.79086 5.29086 2 7.5 2H14.5M21.5 9L14.5 2M21.5 9H18.5C16.2909 9 14.5 7.20914 14.5 5V2"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="pagination-wrapper text-center mt-2 mb-5">
                        {{ $products->links() }}
                    </div>
            </div>
        </div>
    </section>
@endsection
@push('styles')
    <style>
        .view-2-product-title {
            display: block;
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .view-2-product-title {
                max-width: 160px;
            }
        }
    </style>
@endpush
@push('script')
    <script>
        document.getElementById('loadMoreLocations')?.addEventListener('click', function() {
            const hiddenItems = document.querySelectorAll('.location-item[style*="display:none"]');
            hiddenItems.forEach(item => item.style.display = 'block');
            this.style.display = 'none'; // hide the button after loading
        });
    </script>
@endpush
