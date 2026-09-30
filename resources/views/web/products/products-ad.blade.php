@extends('web.layouts.master')
@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- product area start -->
        <div id="smooth-wrapper">
            <div id="smooth-content">
                <section class="rs-post-ad-area mt-32">
                    <div class="container">
                        <div class="rs-post-ad-box p-16 br-8 mb-32" data-bg-color="#F6F7F9">
                            <div class="row App align-items-center">
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <div class="rs-post-ad-head">
                                        <h2 class="rs-post-ad-title">{{ __('Post Ad') }}</h2>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 align-self-end">
                                    <div class="rs-post-ad-info pt-54">
                                        <div class="rs-post-tabs d-flex align-items-center gap-40 justify-content-end">
                                            <a href="javascript:void(0)" class="step-tab p-relative active" data-step="0">
                                                <svg class="step-tab-svg-1 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <circle cx="20" cy="20" r="19" stroke="currentColor"
                                                        stroke-width="2" />
                                                    <circle cx="20" cy="20" r="10" fill="currentColor" />
                                                </svg>
                                                <svg class="step-tab-svg-3 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <path
                                                        d="M19.9997 3.33398C10.7997 3.33398 3.33301 10.8007 3.33301 20.0007C3.33301 29.2007 10.7997 36.6673 19.9997 36.6673C29.1997 36.6673 36.6663 29.2007 36.6663 20.0007C36.6663 10.8007 29.1997 3.33398 19.9997 3.33398ZM26.7163 17.0007L18.933 24.7673C18.6997 25.0173 18.383 25.134 18.0497 25.134C17.733 25.134 17.4163 25.0173 17.1663 24.7673L13.283 20.884C12.7997 20.4007 12.7997 19.6006 13.283 19.1173C13.7663 18.6339 14.5663 18.6339 15.0497 19.1173L18.0497 22.1174L24.9497 15.234C25.433 14.734 26.233 14.734 26.7163 15.234C27.1997 15.7173 27.1997 16.5007 26.7163 17.0007Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <svg class="step-tab-svg-2 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="14" height="13" viewBox="0 0 14 13" fill="none">
                                                    <path
                                                        d="M6.09299 0.953555C6.45135 0.181704 7.54865 0.181706 7.90701 0.953557L13.5 13H0.5L6.09299 0.953555Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Product Information') }}
                                            </a>
                                            <a href="" class="step-tab p-relative" data-step="1">
                                                <svg class="step-tab-svg-1 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <circle cx="20" cy="20" r="19" stroke="currentColor"
                                                        stroke-width="2" />
                                                    <circle cx="20" cy="20" r="10" fill="currentColor" />
                                                </svg>
                                                <svg class="step-tab-svg-3 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <path
                                                        d="M19.9997 3.33398C10.7997 3.33398 3.33301 10.8007 3.33301 20.0007C3.33301 29.2007 10.7997 36.6673 19.9997 36.6673C29.1997 36.6673 36.6663 29.2007 36.6663 20.0007C36.6663 10.8007 29.1997 3.33398 19.9997 3.33398ZM26.7163 17.0007L18.933 24.7673C18.6997 25.0173 18.383 25.134 18.0497 25.134C17.733 25.134 17.4163 25.0173 17.1663 24.7673L13.283 20.884C12.7997 20.4007 12.7997 19.6006 13.283 19.1173C13.7663 18.6339 14.5663 18.6339 15.0497 19.1173L18.0497 22.1174L24.9497 15.234C25.433 14.734 26.233 14.734 26.7163 15.234C27.1997 15.7173 27.1997 16.5007 26.7163 17.0007Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <svg class="step-tab-svg-2 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="14" height="13" viewBox="0 0 14 13" fill="none">
                                                    <path
                                                        d="M6.09299 0.953555C6.45135 0.181704 7.54865 0.181706 7.90701 0.953557L13.5 13H0.5L6.09299 0.953555Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Extra Information') }}
                                            </a>
                                            <a href="javascript:void(0)" class="step-tab p-relative" data-step="2">
                                                <svg class="step-tab-svg-1 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <circle cx="20" cy="20" r="19" stroke="currentColor"
                                                        stroke-width="2" />
                                                    <circle cx="20" cy="20" r="10" fill="currentColor" />
                                                </svg>
                                                <svg class="step-tab-svg-3 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                    <path
                                                        d="M19.9997 3.33398C10.7997 3.33398 3.33301 10.8007 3.33301 20.0007C3.33301 29.2007 10.7997 36.6673 19.9997 36.6673C29.1997 36.6673 36.6663 29.2007 36.6663 20.0007C36.6663 10.8007 29.1997 3.33398 19.9997 3.33398ZM26.7163 17.0007L18.933 24.7673C18.6997 25.0173 18.383 25.134 18.0497 25.134C17.733 25.134 17.4163 25.0173 17.1663 24.7673L13.283 20.884C12.7997 20.4007 12.7997 19.6006 13.283 19.1173C13.7663 18.6339 14.5663 18.6339 15.0497 19.1173L18.0497 22.1174L24.9497 15.234C25.433 14.734 26.233 14.734 26.7163 15.234C27.1997 15.7173 27.1997 16.5007 26.7163 17.0007Z"
                                                        fill="currentColor" />

                                                </svg>
                                                <svg class="step-tab-svg-2 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="14" height="13" viewBox="0 0 14 13" fill="none">
                                                    <path
                                                        d="M6.09299 0.953555C6.45135 0.181704 7.54865 0.181706 7.90701 0.953557L13.5 13H0.5L6.09299 0.953555Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Product Image') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Step Content -->
                                <div class="rs-post-step-content">
                                    <!-- Step 1 -->
                                    <div class="step-pane active" data-step="0">
                                        <div class="rs-post-cta mb-24">
                                            <h3 class="rs-post-cta-title">{{ __('Category') }}</h3>
                                            <div class="rs-post-cta-select d-flex align-items-center gap-32">
                                                <div class="w-50">
                                                    <select id="category" name="category">
                                                        <option value="" hidden>{{ __('Select Product Category') }}
                                                        </option>
                                                        @foreach ($categories as $cat)
                                                            @if (!$cat->parent_id)
                                                                <option value="{{ $cat->id }}">{{ $cat->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="w-50 pb-1">
                                                    <select id="subcategory" name="subcategory" class="form-control">
                                                        <option value="">{{ __('Select Subcategory') }}</option>
                                                    </select>
                                                    @error('subcategory')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rs-post-info mb-16">
                                            <h3 class="rs-post-cta-title rs-post-info-title">
                                                {{ __('Product Information') }}</h3>
                                            <div class="rs-post-cta-contant br-8 p-24" data-bg-color="#F6F7F9">
                                                <h4 class="rs-post-cta-title-2">{{ __('Product Name') }}<span>*</span>
                                                </h4>
                                                <div class="w-100 mb-16">
                                                    <input class="mb-0" type="text" name="name"
                                                        placeholder="Write Your Product Name"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="rs-post-cta-title-small d-flex gap-32">
                                                    <h4 class="rs-post-cta-title-2">
                                                        {{ __('Product Condition') }}<span>*</span></h4>
                                                    <h4
                                                        class="rs-post-cta-title-2 d-none d-md-flex align-items-center justify-content-between">
                                                        {{ __('Product Price') }}<span class="mr-auto">*</span>
                                                        <label class="custom-checkbox">
                                                            <input type="checkbox" name="negotiable"
                                                                {{ old('negotiable') ? 'checked' : '' }}>
                                                            <span class="checkmark">
                                                                <svg class="checkmark-svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14.03 8.20001L9.35999 12.86C9.21999 13.01 9.02999 13.08 8.82999 13.08C8.63999 13.08 8.44999 13.01 8.29999 12.86L5.97 10.53C5.68 10.24 5.68 9.75997 5.97 9.46997C6.26 9.17997 6.74 9.17997 7.03 9.46997L8.82999 11.27L12.97 7.14001C13.26 6.84001 13.74 6.84001 14.03 7.14001C14.32 7.43001 14.32 7.90001 14.03 8.20001Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                            <cite>{{ __('negotiable') }}</cite>
                                                        </label>
                                                    </h4>
                                                </div>
                                                <div
                                                    class="rs-post-cta-select rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <div class="w-50">
                                                        <select id="condition" name="condition" required>
                                                            <option value="" hidden>
                                                                {{ __('Select Product Condition') }}
                                                            </option>
                                                            @foreach (\App\Enums\Conditions::cases() as $condition)
                                                                <option value="{{ $condition->value }}"
                                                                    {{ old('condition') == $condition->value ? 'selected' : '' }}>
                                                                    {{ $condition->label() }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('condition')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <h4
                                                        class="rs-post-cta-title-2 d-flex align-center justify-content-between d-md-none">
                                                        {{ __('Product Price') }}<span class="mr-auto">*</span>

                                                        <label class="custom-checkbox">
                                                            <input type="checkbox" id="negotiableMobile"
                                                                name="negotiable" value="true"
                                                                {{ old('negotiable') === 'true' ? 'checked' : '' }}>
                                                            <span class="checkmark">
                                                                <svg class="checkmark-svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14.03 8.20001L9.35999 12.86C9.21999 13.01 9.02999 13.08 8.82999 13.08C8.63999 13.08 8.44999 13.01 8.29999 12.86L5.97 10.53C5.68 10.24 5.68 9.75997 5.97 9.46997C6.26 9.17997 6.74 9.17997 7.03 9.46997L8.82999 11.27L12.97 7.14001C13.26 6.84001 13.74 6.84001 14.03 7.14001C14.32 7.43001 14.32 7.90001 14.03 8.20001Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                            <cite>{{ __('Negotiable') }}</cite>
                                                        </label>
                                                    </h4>

                                                    <div class="w-50">
                                                        <input type="number" name="price"
                                                            placeholder="Write Your Product Price"
                                                            value="{{ old('price') }}" step="0.01" min="1">
                                                        @error('price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="rs-post-cta-title-small d-flex gap-32">
                                                    <h4 class="rs-post-cta-title-2">{{ __('Phone Number') }}<span>*</span>
                                                    </h4>
                                                    <h4 class="rs-post-cta-title-2 d-none d-md-block">
                                                        {{ __('Email Address') }}<span>*</span>
                                                    </h4>
                                                </div>
                                                <div class="rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <div class="w-50">
                                                        <input type="text" name="phone"
                                                            placeholder="Write Your Phone Number"
                                                            value="{{ old('phone') }}">
                                                        @error('phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <h4 class="rs-post-cta-title-2 d-md-none">
                                                        {{ __('Email Address') }}<span>*</span>
                                                    </h4>
                                                    <div class="w-50">
                                                        <input type="email" name="email"
                                                            placeholder="Write Your Email Address"
                                                            value="{{ old('email') }}">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <h4 class="rs-post-cta-title-2">
                                                    {{ __('Product Description') }}<span>*</span></h4>
                                                <textarea class="mb-0" name="description" placeholder="Write Your Product Description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="rs-post-location mb-24">
                                            <h3 class="rs-post-cta-title rs-post-location-title">{{ __('Location') }}</h3>
                                            <div class="rs-post-location-contant br-8 p-24 pb-20" data-bg-color="#F6F7F9">
                                                <div class="rs-post-cta-title-small d-flex gap-32">
                                                    <h4 class="rs-post-cta-title-2">{{ __('Add Location') }}<span>*</span>
                                                    </h4>
                                                </div>
                                                <div class="rs-post-cta-select d-flex align-items-center gap-32">
                                                    <div class="w-100 p-relative">
                                                        <input class="mb-16" type="text" id="locationInput"
                                                            name="location" placeholder="Choose Your Location"
                                                            value="{{ old('location') }}">
                                                    </div>
                                                </div>
                                                <div id="map" style="height: 450px; width: 100%;" class="br-8">
                                                </div>
                                                <!-- Location name display -->
                                                <div class="mt-2">
                                                    <strong>{{ __('Selected Location:') }}</strong>
                                                    <span id="locationDisplay">{{ __('Not selected') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Hidden inputs for lat/lng -->
                                        <input type="hidden" name="latitude" value="{{ old('latitude') }}">
                                        <input type="hidden" name="longitude" value="{{ old('longitude') }}">
                                        <div class="step-nav d-flex gap-8 justify-content-end mb-4">
                                            <button type="button"
                                                class="next-btn btn btn-primary d-flex align-items-center justify-content-center gap-12">
                                                {{ __('Next') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                    viewBox="0 0 20 16" fill="none">
                                                    <path
                                                        d="M19.6919 8.28787C19.6539 8.37987 19.599 8.46276 19.53 8.53176L12.53 15.5318C12.384 15.6778 12.192 15.7517 12 15.7517C11.808 15.7517 11.616 15.6788 11.47 15.5318C11.177 15.2388 11.177 14.7637 11.47 14.4707L17.1899 8.75076H1C0.586 8.75076 0.25 8.41476 0.25 8.00076C0.25 7.58676 0.586 7.25076 1 7.25076H17.189L11.469 1.53079C11.176 1.23779 11.176 0.76275 11.469 0.46975C11.762 0.17675 12.237 0.17675 12.53 0.46975L19.53 7.46975C19.599 7.53875 19.6539 7.62165 19.6919 7.71365C19.7679 7.89765 19.7679 8.10387 19.6919 8.28787Z"
                                                        fill="white" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Step 2 -->
                                    <div class="step-pane" data-step="1">
                                        <div class="rs-post-info mb-24">
                                            <h3 class="rs-post-cta-title rs-post-info-title rs-post-info-title-2">
                                                {{ __('Add Product Others Information') }}
                                            </h3>
                                            <div class="rs-post-cta-contant br-8 p-24 pb-16" data-bg-color="#F6F7F9">
                                                <div class="rs-post-cta-title-small d-flex gap-32 d-none d-md-flex">
                                                    <h4 class="rs-post-cta-title-2">{{ 'Product Brand' }}</h4>
                                                    <h4 class="rs-post-cta-title-2">{{ 'Product Model' }}</h4>
                                                    <h4 class="rs-post-cta-title-2">{{ 'Warranty' }}</h4>
                                                </div>
                                                <div
                                                    class="rs-post-cta-select rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Product Brand') }}
                                                    </h4>
                                                    <div class="w-50">
                                                        <select id="brand" name="brand">
                                                            <option value="" hidden>{{ __('Select Product Brand') }}
                                                            </option>
                                                            @foreach ($brands as $brand)
                                                                @if (!$brand->brand_id)
                                                                    <option value="{{ $brand->id }}">
                                                                        {{ $brand->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('brand')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Product Model') }}
                                                    </h4>
                                                    <input type="text" name="model"
                                                        placeholder="e.g. MacBook Air M2" value="{{ old('model') }}">
                                                    @error('model')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Warranty') }}</h4>
                                                    <input type="number" name="warranty"
                                                        placeholder="Enter Number in Days" value="{{ old('warranty') }}">
                                                    @error('warranty')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Color Selection -->
                                            <div class="product-colors mt-4">
                                                @foreach ($colors as $color)
                                                    <label class="color-option" style="">
                                                        <input type="radio" name="color"
                                                            value="{{ $color->code }}">
                                                        <div class="color-dot"
                                                            style="background-color: {{ $color->code }}"></div>
                                                        <span class="color-name">{{ $color->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="step-nav d-flex gap-8 justify-content-end mb-4">
                                            <button type="button"
                                                class="prev-btn btn btn-secondary d-flex align-items-center gap-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16"
                                                    viewBox="0 0 21 16" fill="none">
                                                    <path
                                                        d="M20.1919 8.28787C20.1539 8.37987 20.099 8.46276 20.03 8.53176L13.03 15.5318C12.884 15.6778 12.692 15.7517 12.5 15.7517C12.308 15.7517 12.116 15.6788 11.97 15.5318C11.677 15.2388 11.677 14.7637 11.97 14.4707L17.6899 8.75076H1.5C1.086 8.75076 0.75 8.41476 0.75 8.00076C0.75 7.58676 1.086 7.25076 1.5 7.25076H17.689L11.969 1.53079C11.676 1.23779 11.676 0.76275 11.969 0.46975C12.262 0.17675 12.737 0.17675 13.03 0.46975L20.03 7.46975C20.099 7.53875 20.1539 7.62165 20.1919 7.71365C20.2679 7.89765 20.2679 8.10387 20.1919 8.28787Z"
                                                        fill="white" />
                                                </svg>
                                                {{ __('Back') }}
                                            </button>
                                            <button type="button"
                                                class="next-btn btn btn-primary d-flex align-items-center justify-content-center gap-12">
                                                {{ __('Next') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                    viewBox="0 0 20 16" fill="none">
                                                    <path
                                                        d="M19.6919 8.28787C19.6539 8.37987 19.599 8.46276 19.53 8.53176L12.53 15.5318C12.384 15.6778 12.192 15.7517 12 15.7517C11.808 15.7517 11.616 15.6788 11.47 15.5318C11.177 15.2388 11.177 14.7637 11.47 14.4707L17.1899 8.75076H1C0.586 8.75076 0.25 8.41476 0.25 8.00076C0.25 7.58676 0.586 7.25076 1 7.25076H17.189L11.469 1.53079C11.176 1.23779 11.176 0.76275 11.469 0.46975C11.762 0.17675 12.237 0.17675 12.53 0.46975L19.53 7.46975C19.599 7.53875 19.6539 7.62165 19.6919 7.71365C19.7679 7.89765 19.7679 8.10387 19.6919 8.28787Z"
                                                        fill="white" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Step 3 -->
                                    <div class="step-pane" data-step="2">
                                        <!-- Thumbnail -->
                                        <div class="rs-post-info mb-6">
                                            <h3 class="rs-post-cta-title rs-post-info-title">
                                                {{ __('Product Thumbnail') }}<span>*</span>
                                            </h3>
                                            <div class="upload-gallery-wrapper upload-gallery-wrapper-2">
                                                <div class="upload-box br-8 p-24 drop-zone" id="thumbDrop">
                                                    <input type="file" id="thumbnailInput2" name="thumbnail"
                                                        accept="image/*" class="d-none">
                                                    <label for="thumbnailInput2" class="upload-label p-relative">
                                                        <div class="upload-inner d-flex flex-column align-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="56"
                                                                height="56" viewBox="0 0 56 56" fill="none">
                                                                <g clip-path="url(#clip0_296_14225)">
                                                                    <path
                                                                        d="M44.5883 4.16016H18.8984V14.8135H50.075V9.64471C50.075 6.62024 47.6136 4.16016 44.5883 4.16016Z"
                                                                        fill="#FBE5E5" />
                                                                    <path
                                                                        d="M30.0469 16.4537H0V6.56848C0 2.94629 2.94757 0 6.57104 0H16.1781C17.133 0 18.0529 0.201233 18.8885 0.579346C20.0558 1.10529 21.0585 1.97217 21.7618 3.1048L30.0469 16.4537Z"
                                                                        fill="currentColor" />
                                                                    <path
                                                                        d="M56 18.6665V50.5083C56 53.5366 53.5348 55.9997 50.5052 55.9997H5.49481C2.46521 55.9997 0 53.5366 0 50.5083V13.1738H50.5052C53.5348 13.1738 56 15.6378 56 18.6665Z"
                                                                        fill="#C93939" />
                                                                    <path
                                                                        d="M56 18.6665V50.5083C56 53.5366 53.5348 55.9997 50.5052 55.9997H28V13.1738H50.5052C53.5348 13.1738 56 15.6378 56 18.6665Z"
                                                                        fill="#A92C2C" />
                                                                    <path
                                                                        d="M42.7307 34.5861C42.7307 42.7093 36.1225 49.3179 28.0001 49.3179C19.8777 49.3179 13.2695 42.7093 13.2695 34.5861C13.2695 26.4641 19.8777 19.8555 28.0001 19.8555C36.1225 19.8555 42.7307 26.4641 42.7307 34.5861Z"
                                                                        fill="#FDF3F3" />
                                                                    <path
                                                                        d="M42.7306 34.5861C42.7306 42.7093 36.1224 49.3179 28 49.3179V19.8555C36.1224 19.8555 42.7306 26.4641 42.7306 34.5861Z"
                                                                        fill="#FBE5E5" />
                                                                    <path
                                                                        d="M32.7489 34.7664C32.4417 35.0266 32.0653 35.1535 31.6924 35.1535C31.2254 35.1535 30.7614 34.9557 30.4367 34.5703L29.6416 33.6278V39.7985C29.6416 40.7043 28.9067 41.4391 28.0009 41.4391C27.0952 41.4391 26.3603 40.7043 26.3603 39.7985V33.6278L25.5652 34.5703C24.9799 35.2629 23.9455 35.3513 23.253 34.7664C22.5608 34.1824 22.472 33.1476 23.056 32.455L26.3035 28.6051C26.7269 28.1044 27.3447 27.8164 28.0009 27.8164C28.6572 27.8164 29.275 28.1044 29.6984 28.6051L32.9459 32.455C33.5299 33.1476 33.4411 34.1824 32.7489 34.7664Z"
                                                                        fill="#A92C2C" />
                                                                    <path
                                                                        d="M32.748 34.7664C32.4408 35.0266 32.0644 35.1535 31.6914 35.1535C31.2244 35.1535 30.7604 34.9557 30.4357 34.5703L29.6406 33.6278V39.7985C29.6406 40.7043 28.9058 41.4391 28 41.4391V27.8164C28.6562 27.8164 29.274 28.1044 29.6974 28.6051L32.9449 32.455C33.529 33.1476 33.4401 34.1824 32.748 34.7664Z"
                                                                        fill="#A92C2C" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_296_14225">
                                                                        <rect width="56" height="56"
                                                                            fill="white" />
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            <p class="Drag-text">
                                                                {{ __('Drag your file\'s to start uploading') }}<br><span>or</span>
                                                            </p>
                                                            <button type="button"
                                                                class="browse-btn">{{ __('Browse files') }}</button>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div>
                                                    <div id="thumbnailPreview" class="preview-item"></div>
                                                    @error('thumbnail')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <span class="file-info">{{ __('Only support pg, png and svg files') }}</span>
                                        <!-- Gallery -->
                                        <div class="rs-post-info mb-24">
                                            <h3 class="rs-post-cta-title rs-post-info-title">
                                                {{ __('Product Additional Image') }} <span
                                                    class="max-img">{{ __('(Max 10 Images)') }}</span></h3>
                                            <div class="upload-gallery-wrapper">
                                                <div class="drop-zone" id="galleryDrop">
                                                    <input type="file" id="additionalImagesInput"
                                                        name="additional_images[]" accept="image/*" multiple
                                                        class="d-none">
                                                    <label for="additionalImagesInput" class="upload-label p-relative">
                                                        <div class="upload-inner">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="56"
                                                                height="56" viewBox="0 0 56 56" fill="none">
                                                                <g clip-path="url(#clip0_296_14249)">
                                                                    <path
                                                                        d="M44.5883 4.16016H18.8984V14.8135H50.075V9.64471C50.075 6.62024 47.6136 4.16016 44.5883 4.16016Z"
                                                                        fill="#FBE5E5" />
                                                                    <path
                                                                        d="M30.0469 16.4537H0V6.56848C0 2.94629 2.94757 0 6.57104 0H16.1781C17.133 0 18.0529 0.201233 18.8885 0.579346C20.0558 1.10529 21.0585 1.97217 21.7618 3.1048L30.0469 16.4537Z"
                                                                        fill="currentColor" />
                                                                    <path
                                                                        d="M56 18.6665V50.5083C56 53.5366 53.5348 55.9997 50.5052 55.9997H5.49481C2.46521 55.9997 0 53.5366 0 50.5083V13.1738H50.5052C53.5348 13.1738 56 15.6378 56 18.6665Z"
                                                                        fill="#C93939" />
                                                                    <path
                                                                        d="M56 18.6665V50.5083C56 53.5366 53.5348 55.9997 50.5052 55.9997H28V13.1738H50.5052C53.5348 13.1738 56 15.6378 56 18.6665Z"
                                                                        fill="#A92C2C" />
                                                                    <path
                                                                        d="M42.7307 34.5861C42.7307 42.7093 36.1225 49.3179 28.0001 49.3179C19.8777 49.3179 13.2695 42.7093 13.2695 34.5861C13.2695 26.4641 19.8777 19.8555 28.0001 19.8555C36.1225 19.8555 42.7307 26.4641 42.7307 34.5861Z"
                                                                        fill="#FDF3F3" />
                                                                    <path
                                                                        d="M42.7306 34.5861C42.7306 42.7093 36.1224 49.3179 28 49.3179V19.8555C36.1224 19.8555 42.7306 26.4641 42.7306 34.5861Z"
                                                                        fill="#FBE5E5" />
                                                                    <path
                                                                        d="M32.7489 34.7664C32.4417 35.0266 32.0653 35.1535 31.6924 35.1535C31.2254 35.1535 30.7614 34.9557 30.4367 34.5703L29.6416 33.6278V39.7985C29.6416 40.7043 28.9067 41.4391 28.0009 41.4391C27.0952 41.4391 26.3603 40.7043 26.3603 39.7985V33.6278L25.5652 34.5703C24.9799 35.2629 23.9455 35.3513 23.253 34.7664C22.5608 34.1824 22.472 33.1476 23.056 32.455L26.3035 28.6051C26.7269 28.1044 27.3447 27.8164 28.0009 27.8164C28.6572 27.8164 29.275 28.1044 29.6984 28.6051L32.9459 32.455C33.5299 33.1476 33.4411 34.1824 32.7489 34.7664Z"
                                                                        fill="#A92C2C" />
                                                                    <path
                                                                        d="M32.748 34.7664C32.4408 35.0266 32.0644 35.1535 31.6914 35.1535C31.2244 35.1535 30.7604 34.9557 30.4357 34.5703L29.6406 33.6278V39.7985C29.6406 40.7043 28.9058 41.4391 28 41.4391V27.8164C28.6562 27.8164 29.274 28.1044 29.6974 28.6051L32.9449 32.455C33.529 33.1476 33.4401 34.1824 32.748 34.7664Z"
                                                                        fill="#A92C2C" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_296_14249">
                                                                        <rect width="56" height="56"
                                                                            fill="white" />
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            <p class="Drag-text">
                                                                {{ __('Drag your files to start uploading') }}<br><span>or</span>
                                                            </p>
                                                            <button type="button"
                                                                class="browse-btn">{{ __('Browse files') }}</button>
                                                            <span class="file-info-2"
                                                                id="galleryCounter">{{ __('0 / 9') }}</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="preview-gallery" id="gallery">
                                                </div>
                                                @error('additional_images.*')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div id="galleryError"></div>
                                            <!-- Navigation Buttons -->
                                            <div class="step-nav d-flex gap-8 justify-content-end mb-4">
                                                <button type="button"
                                                    class="prev-btn btn btn-secondary d-flex align-items-center gap-12">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16"
                                                        viewBox="0 0 21 16" fill="none">
                                                        <path
                                                            d="M20.1919 8.28787C20.1539 8.37987 20.099 8.46276 20.03 8.53176L13.03 15.5318C12.884 15.6778 12.692 15.7517 12.5 15.7517C12.308 15.7517 12.116 15.6788 11.97 15.5318C11.677 15.2388 11.677 14.7637 11.97 14.4707L17.6899 8.75076H1.5C1.086 8.75076 0.75 8.41476 0.75 8.00076C0.75 7.58676 1.086 7.25076 1.5 7.25076H17.689L11.969 1.53079C11.676 1.23779 11.676 0.76275 11.969 0.46975C12.262 0.17675 12.737 0.17675 13.03 0.46975L20.03 7.46975C20.099 7.53875 20.1539 7.62165 20.1919 7.71365C20.2679 7.89765 20.2679 8.10387 20.1919 8.28787Z"
                                                            fill="white" />
                                                    </svg>
                                                    {{ __('Back') }}
                                                </button>
                                                @guest
                                                    <button type="button"
                                                        class="submit-btn btn btn-primary d-flex align-items-center justify-content-center gap-12"
                                                        onclick="toggleModal('sign_up_popup')">

                                                        <span class="btn-text">{{ __('Please Login First') }}</span>

                                                        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg"
                                                            width="21" height="16" viewBox="0 0 21 16"
                                                            fill="none">
                                                            <path d="M20.1919 8.28787..." fill="white" />
                                                        </svg>
                                                    </button>
                                                    @else
                                                    <button type="submit" id="submitBtn"
                                                        class="submit-btn btn btn-primary d-flex align-items-center justify-content-center gap-12"
                                                        onclick="return validateThumbnail();">

                                                        <span class="btn-text">{{ __(' Submit Post') }}</span>

                                                        <span class="btn-loader d-none">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                            {{ __('Processing') }}...
                                                        </span>

                                                        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg"
                                                            width="21" height="16" viewBox="0 0 21 16"
                                                            fill="none">
                                                            <path d="M20.1919 8.28787..." fill="white" />
                                                        </svg>
                                                    </button>
                                                @endguest

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </form>

    {{-- *****  JS VALIDATION FUNCTION ***** --}}

    <script>
        function validatePostStep2() {
            let valid = true;

            // --- Thumbnail validation (jemon age) ---
            const thumbInput = document.getElementById('thumbnailInput2');
            const thumbPreview = document.getElementById('thumbnailPreview');

            const hasThumbFile = thumbInput && thumbInput.files && thumbInput.files.length > 0;
            const hasThumbPrev = thumbPreview && thumbPreview.querySelector('img');

            // Remove old error
            const oldThumbErr = thumbPreview.parentNode.querySelector('.thumb-err');
            if (oldThumbErr) oldThumbErr.remove();

            if (!hasThumbFile && !hasThumbPrev) {
                const err = document.createElement('span');
                err.className = 'text-danger thumb-err';
                err.textContent = 'Product Thumbnail is required.';
                thumbPreview.parentNode.appendChild(err);
                valid = false;
            }

            if (hasThumbFile) {
                const file = thumbInput.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    const err = document.createElement('p');
                    err.className = 'text-danger thumb-err';
                    err.textContent = 'Thumbnail cannot exceed 2MB.';
                    thumbPreview.parentNode.appendChild(err);
                    valid = false;
                }
            }

            // --- Additional Images validation ---
            const addInput = document.getElementById('additionalImagesInput');
            const gallery = document.getElementById('gallery'); // preview gallery
            const files = addInput?.files;
            const errorBox = document.getElementById('galleryError');
            const maxImages = 10;

            // Remove old errors in gallery
            const oldImgErr = gallery.querySelector('.img-err');
            if (oldImgErr) oldImgErr.remove();

            errorBox.innerHTML = '';
            if (files && files.length > 0) {
                if (files.length > maxImages) {
                    const err = document.createElement('p');
                    err.className = 'text-danger';
                    err.textContent = `You can upload a maximum of ${maxImages} images.`;
                    // gallery.appendChild(err);
                    errorBox.appendChild(err);
                    valid = false;
                }

                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > 2 * 1024 * 1024) {
                        const err = document.createElement('p');
                        err.className = 'text-danger';
                        err.textContent = `Image "${files[i].name}" cannot exceed 2MB.`;
                        // gallery.appendChild(err);
                        errorBox.appendChild(err);
                        valid = false;
                    }
                }
            }

            // Show loader if valid
            if (valid) {
                const btn = document.getElementById('submitBtn');
                btn.querySelector('.btn-text').classList.add('d-none');
                btn.querySelector('.btn-icon').classList.add('d-none');
                btn.querySelector('.btn-loader').classList.remove('d-none');
            }

            return valid; // false → stay on step 2
        }

        // Attach to submit button
        document.getElementById('submitBtn').onclick = function() {
            return validatePostStep2();
        };

        // Update counter live
        const galleryCounter = document.getElementById('galleryCounter');
        const addInput = document.getElementById('additionalImagesInput');
        addInput.addEventListener('change', function() {
            galleryCounter.textContent = `${this.files.length} / 10`;
        });
    </script>
@endsection

@push('styles')
    <style>
        .step-pane {
            display: none;
        }

        .step-pane.active {
            display: block;
        }

        .step-tab.active {
            color: var(--tp-red-color);
        }

        .text-danger {
            color: var(--tp-red-color);
            font-size: .875rem;
            margin-top: .25rem;
            display: block;
        }

        .thumbnail-preview,
        .preview-gallery {
            gap: 10px;
        }

        .thumbnail-preview img,
        .preview-gallery img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .preview-gallery .image-container {
            position: relative;
        }

        .remove-btn,
        .preview-gallery .remove-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            background: var(--tp-grey-color);
            backdrop-filter: blur(4px);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--tp-white-color);
            text-align: center;
            font-weight: 500;
            border-radius: 4px;
            background: var(--Primary, #dd5454);
            line-height: 48px;
        }

        .btn-primary {
            background: #DD5454;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .drop-zone.dragover {
            border: 2px dashed #DD5454;
            background: #FBE5E5;
        }

        .product-colors {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .color-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            transition: all .25s ease;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .color-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, .12);
        }

        .color-option.active {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, .12);
        }

        .color-option input[type=radio] {
            display: none;
        }

        .color-dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            transition: all .25s ease;
        }

        .color-name {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
        }

        .color-option input[type=radio]:checked+.color-dot {
            border-color: #BBDCE5;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .25);
        }

        .color-option input[type=radio]:checked~.color-name {
            color: var(--tp-red-color);
            font-weight: 600;
        }

        .color-option:has(input[type=radio]:checked) {
            border: 1px solid #DD5454;
            box-shadow: 0 0 0 3px rgba(221, 84, 84, .25);
            transition: all .3s ease;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Category and Subcategory AJAX
            $('#category').on('change', function() {
                let categoryId = $(this).val();
                let subcategorySelect = $('#subcategory');
                subcategorySelect.html('<option>Loading...</option>');
                if (categoryId) {
                    $.ajax({
                        url: '/get-subcategories/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            subcategorySelect.empty();
                            if (response.status === 'success') {
                                subcategorySelect.append(
                                    '<option value="">Select Subcategory</option>');
                                $.each(response.data, function(index, subcat) {
                                    subcategorySelect.append('<option value="' + subcat
                                        .id + '">' + subcat.name + '</option>');
                                });
                            } else {
                                subcategorySelect.append(
                                    '<option value="">No Sub Category</option>');
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                            subcategorySelect.html(
                                '<option value="">Error loading subcategories</option>');
                        }
                    });
                } else {
                    subcategorySelect.html('<option value="">Select Subcategory</option>');
                }
            });

            // Back Previous Page
            $('.prev-btn').on('click', function() {
                const currentStep = parseInt($('.step-pane.active').data('step'));

                if (currentStep > 0) {
                    goToStep(currentStep - 1);
                }
            });


            function validateStep(step) {
                let valid = true;

                const stepPane = $('.step-pane[data-step="' + step + '"]');

                function showError($el, msg) {
                    if ($el.next('.text-danger').length === 0) {
                        $el.after(`<span class="text-danger">${msg}</span>`);
                    }
                    valid = false;
                }

                stepPane.find('.text-danger').not('.server-error').remove();


                if (step === 0) {

                    const fields = [{
                            sel: '#category',
                            name: 'Category'
                        },
                        {
                            sel: 'input[name="name"]',
                            name: 'Product Name'
                        },
                        {
                            sel: '#condition',
                            name: 'Product Condition'
                        },
                        {
                            sel: 'input[name="price"]',
                            name: 'Product Price'
                        },
                        {
                            sel: 'input[name="phone"]',
                            name: 'Phone Number'
                        },
                        {
                            sel: 'input[name="email"]',
                            name: 'Email Address'
                        },
                        {
                            sel: 'textarea[name="description"]',
                            name: 'Product Description'
                        },
                        {
                            sel: 'input[name="location"]',
                            name: 'Location'
                        }
                    ];

                    fields.forEach(f => {
                        const $el = stepPane.find(f.sel);
                        if (!$el.val() || !$el.val().trim()) {
                            showError($el, `${f.name} is required.`);
                        }
                    });

                    /* PRICE VALIDATION */
                    const priceEl = stepPane.find('input[name="price"]');
                    const priceVal = priceEl.val()?.trim();

                    if (priceVal) {
                        const priceNum = Number(priceVal);

                        if (isNaN(priceNum)) {
                            showError(priceEl, 'Price must be a number.');
                        } else if (priceNum < 1) {
                            showError(priceEl, 'Price must be at least 1.');
                        } else if (priceVal.replace(/\D/g, '').length > 11) {
                            showError(priceEl, 'Price cannot exceed 11 digits.');
                        } else if (!/^\d+(\.\d{1,2})?$/.test(priceVal)) {
                            showError(priceEl, 'Only up to 2 decimal places are allowed.');
                        }
                    }

                    /* EMAIL FORMAT */
                    const emailEl = stepPane.find('input[name="email"]');
                    const emailVal = emailEl.val()?.trim();
                    if (emailVal) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
                        if (!emailRegex.test(emailVal)) {
                            showError(emailEl, 'Please enter a valid email address.');
                        }
                    }

                    /* LOCATION (MAP) */
                    const lat = stepPane.find('input[name="latitude"]').val();
                    const lng = stepPane.find('input[name="longitude"]').val();

                    if (!lat || !lng || lat == 0 || lng == 0) {
                        showError(stepPane.find('#locationInput'), 'Please select a valid location on the map.');
                    }
                }


                if (step === 1) {
                    const brandEl = stepPane.find('#brand');
                    if (!brandEl.val()) {
                        showError(brandEl, 'Product Brand is required.');
                    }
                }


                if (step === 2) {

                    /* WARRANTY */
                    const warrantyEl = stepPane.find('input[name="warranty"]');
                    const warrantyVal = warrantyEl.val()?.trim();

                    if (!warrantyVal) {
                        warrantyEl.val(null);
                    } else {
                        const warrantyNum = Number(warrantyVal);
                        if (isNaN(warrantyNum)) {
                            showError(warrantyEl, 'Warranty must be a number.');
                        } else if (warrantyNum < 0) {
                            showError(warrantyEl, 'Warranty cannot be negative.');
                        } else if (warrantyVal.length > 3) {
                            showError(warrantyEl, 'Warranty cannot exceed 3 digits.');
                        } else {
                            warrantyEl.val(warrantyNum);
                        }
                    }

                    /* ADDITIONAL IMAGES */
                    const input = document.getElementById('additionalImagesInput');
                    const files = input?.files;
                    const galleryWrapper = document.getElementById('galleryDrop');

                    const oldErr = galleryWrapper.querySelector('.img-err');
                    if (oldErr) oldErr.remove();

                    if (files && files.length > 0) {
                        const maxImages = 10;
                        const maxSize = 2 * 1024 * 1024;

                        if (files.length > maxImages) {
                            const err = document.createElement('span');
                            err.className = 'text-danger img-err';
                            err.textContent = `You can upload a maximum of ${maxImages} images.`;
                            galleryWrapper.appendChild(err);
                            valid = false;
                        }

                        for (let i = 0; i < files.length; i++) {
                            if (files[i].size > maxSize) {
                                const err = document.createElement('span');
                                err.className = 'text-danger img-err';
                                err.textContent = `Image "${files[i].name}" cannot exceed 2MB.`;
                                galleryWrapper.appendChild(err);
                                valid = false;
                            }
                        }
                    }
                }

                return valid;
            }

            // -------------------------------
            // GO TO STEP FUNCTION
            // -------------------------------
            function goToStep(step) {
                $('.step-pane').removeClass('active')
                    .filter('[data-step="' + step + '"]').addClass('active');

                $('.step-tab').removeClass('active')
                    .filter('[data-step="' + step + '"]').addClass('active');
            }

            $(document).ready(function() {

                const tabs = document.querySelectorAll(".step-tab");
                const panes = document.querySelectorAll(".step-pane");
                let currentStep = 0;

                function renderStep(index) {
                    // Step Tabs → active / complete
                    tabs.forEach((t, i) => {
                        t.classList.remove("active", "completed");
                        if (i < index) t.classList.add("completed");
                        else if (i === index) t.classList.add("active");
                    });

                    // Step Panes → active
                    panes.forEach(p => p.classList.remove("active"));
                    if (panes[index]) panes[index].classList.add("active");

                    currentStep = index;
                }

                // Initial render
                renderStep(currentStep);

                // -------------------------------
                // NEXT BUTTON CLICK
                // -------------------------------
                $('.next-btn').on('click', function() {
                    if (validateStep(currentStep)) {
                        const nextIndex = currentStep + 1;
                        if (panes[nextIndex]) {
                            renderStep(nextIndex);
                        }
                    }
                });

                // -------------------------------
                // PREV BUTTON CLICK
                // -------------------------------
                $('.prev-btn').on('click', function() {
                    const prevIndex = currentStep - 1;
                    if (panes[prevIndex]) {
                        renderStep(prevIndex);
                    }
                });

                // -------------------------------
                // STEP TAB CLICK (Validation Enabled)
                // -------------------------------
                $('.step-tab').on('click', function(e) {
                    e.preventDefault();
                    const targetStep = parseInt($(this).data('step'));

                    // Moving backward → allow without validation
                    if (targetStep < currentStep) {
                        renderStep(targetStep);
                        return;
                    }

                    // Moving forward → validate current step
                    if (validateStep(currentStep)) {
                        renderStep(targetStep);
                    }
                });

            });


            // -------------------------------
            // STEP TAB CLICK (Validation Enabled)
            // -------------------------------
            $('.step-tab').on('click', function(e) {
                e.preventDefault();

                const targetStep = parseInt($(this).data('step'));
                const currentStep = parseInt($('.step-pane.active').data('step'));

                // If moving backward → allow without validation
                if (targetStep < currentStep) {
                    goToStep(targetStep);
                    return;
                }

                // Moving forward → run validation
                if (validateStep(currentStep)) {
                    goToStep(targetStep);
                }
            });


            // Thumbnail Upload
            $('#thumbnailInput2').on('change', function(e) {
                const preview = $('#thumbnailPreview');
                preview.empty();
                const file = e.target.files[0];
                if (file) {
                    const container = $('<div>').addClass('preview-item');
                    const img = $('<img>').attr({
                        src: URL.createObjectURL(file),
                        style: 'width:100%;border-radius:8px;'
                    });
                    const removeBtn = $('<button>').addClass('remove-btn').text('×').on('click',
                        function() {
                            container.remove();
                            $('#thumbnailInput2').val('');
                        });
                    container.append(img).append(removeBtn);
                    preview.append(container);
                }
            });

            $('#thumbDrop .browse-btn').on('click', function() {
                $('#thumbnailInput2').click();
            });

            // Thumbnail Drag & Drop
            const thumbDrop = $('#thumbDrop');
            thumbDrop.on('dragover', e => {
                    e.preventDefault();
                    $(this).addClass('dragover');
                })
                .on('dragleave', () => {
                    $(this).removeClass('dragover');
                })
                .on('drop', e => {
                    e.preventDefault();
                    $(this).removeClass('dragover');
                    const file = e.originalEvent.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        $('#thumbnailInput2').prop('files', e.originalEvent.dataTransfer.files);
                        $('#thumbnailInput2').trigger('change');
                    }
                });

            // Additional Images Upload

            const maxImages = 10;
            const dt = new DataTransfer(); // 🔥 global file store

            $('#additionalImagesInput').on('change', function(e) {
                const preview = $('#gallery');
                const counter = $('#galleryCounter');

                const files = Array.from(e.target.files);

                files.forEach(file => {
                    if (dt.files.length >= maxImages) return;

                    dt.items.add(file); // ✅ accumulate file

                    const container = $('<div>').addClass('preview-item');

                    const img = $('<img>').attr({
                        src: URL.createObjectURL(file),
                        style: 'width:100%;border-radius:8px;'
                    });

                    const removeBtn = $('<button>')
                        .addClass('remove-btn')
                        .text('×')
                        .on('click', function() {
                            const index = container.index();
                            container.remove();
                            dt.items.remove(index); // ✅ remove from actual files
                            $('#additionalImagesInput')[0].files = dt.files;
                            counter.text(dt.files.length + ' / ' + maxImages);
                            $('#additionalImagesInput').prop('disabled', false);
                        });

                    container.append(img).append(removeBtn);
                    preview.append(container);
                });

                // 🔥 VERY IMPORTANT
                $('#additionalImagesInput')[0].files = dt.files;

                counter.text(dt.files.length + ' / ' + maxImages);

                if (dt.files.length >= maxImages) {
                    $('#additionalImagesInput').prop('disabled', true);
                }
            });


            $('#galleryDrop .browse-btn').on('click', function() {
                $('#additionalImagesInput').click();
            });

            // Additional Images Drag & Drop

            $('#galleryDrop').on('drop', function(e) {
                e.preventDefault();

                const files = Array.from(e.originalEvent.dataTransfer.files);

                files.forEach(file => {
                    if (dt.files.length < maxImages) {
                        dt.items.add(file);
                    }
                });

                $('#additionalImagesInput')[0].files = dt.files;
                $('#additionalImagesInput').trigger('change');
            });


            // Debug form submit
            $('#productForm').on('submit', function(e) {
                console.log('Form submitting...');
                console.log('Thumbnail files:', $('#thumbnailInput2').prop('files'));
                console.log('Additional images files:', $('#additionalImagesInput').prop('files'));
            });
        });
    </script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const latInput = document.querySelector('input[name="latitude"]');
        const lngInput = document.querySelector('input[name="longitude"]');
        const locationInput = document.getElementById('locationInput');
        const locationDisplay = document.getElementById('locationDisplay');

        let defaultLat = parseFloat(latInput.value) || 23.8103;
        let defaultLng = parseFloat(lngInput.value) || 90.4125;

        const map = L.map('map').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        function updateLatLngAndName(lat = null, lng = null) {
            const pos = lat && lng ? L.latLng(lat, lng) : marker.getLatLng();
            marker.setLatLng(pos);
            map.setView(pos, 13);
            latInput.value = pos.lat;
            lngInput.value = pos.lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${pos.lat}&lon=${pos.lng}`)
                .then(r => r.json())
                .then(d => {
                    const name = d.display_name || 'Unknown Location';
                    locationDisplay.innerText = name;
                    locationInput.value = name;
                })
                .catch(() => {
                    locationDisplay.innerText = 'Unknown Location';
                });
        }

        marker.on('dragend', updateLatLngAndName);
        map.on('click', e => updateLatLngAndName(e.latlng.lat, e.latlng.lng));

        locationInput.addEventListener('change', function() {
            const q = locationInput.value;
            if (!q) return;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(d => {
                    if (d.length > 0) updateLatLngAndName(parseFloat(d[0].lat), parseFloat(d[0].lon));
                });
        });

        updateLatLngAndName();
    </script>
@endpush
