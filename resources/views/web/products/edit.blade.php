@extends('web.layouts.master')
@section('content')
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

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
                            <div class="row align-items-center">
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <div class="rs-post-ad-head">
                                        <h2 class="rs-post-ad-title">{{ __('Post Edit') }}</h2>
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
                                                        fill="#DD5454" />
                                                </svg>
                                                <svg class="step-tab-svg-2 p-absolute" xmlns="http://www.w3.org/2000/svg"
                                                    width="14" height="13" viewBox="0 0 14 13" fill="none">
                                                    <path
                                                        d="M6.09299 0.953555C6.45135 0.181704 7.54865 0.181706 7.90701 0.953557L13.5 13H0.5L6.09299 0.953555Z"
                                                        fill="currentColor" />
                                                </svg>
                                                {{ __('Product Information') }}
                                            </a>
                                            <a href="javascript:void(0)" class="step-tab p-relative" data-step="1">
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
                                                        fill="#DD5454" />
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
                                                        fill="#DD5454" />
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
                                                <select id="category" name="category">
                                                    <option value="" hidden>{{ __('Select Product Category') }}
                                                    </option>
                                                    @foreach ($categories as $cat)
                                                        @if (!$cat->parent_id)
                                                            <option value="{{ $cat->id }}"
                                                                {{ old('category', $mainCategoryId) == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                <select id="subcategory" name="subcategory">
                                                    <option value="">{{ __('Select Subcategory') }}</option>
                                                    @foreach ($categories as $sub)
                                                        @if ($sub->parent_id == $mainCategoryId)
                                                            <option value="{{ $sub->id }}"
                                                                {{ old('subcategory', $subCategoryId) == $sub->id ? 'selected' : '' }}>
                                                                {{ $sub->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('subcategory')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="rs-post-info mb-16">
                                            <h3 class="rs-post-cta-title rs-post-info-title">
                                                {{ __('Product Information') }}</h3>
                                            <div class="rs-post-cta-contant br-8 p-24" data-bg-color="#F6F7F9">
                                                <h4 class="rs-post-cta-title-2">{{ __('Product Name') }}<span>*</span>
                                                </h4>
                                                <input class="mb-16" type="text" name="name"
                                                    placeholder="Write Your Product Name"
                                                    value="{{ old('name', $product->name) }}" maxlength="255"
                                                    oninput="this.value = this.value.slice(0, 255)">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                <div class="rs-post-cta-title-small d-flex gap-32">
                                                    <h4 class="rs-post-cta-title-2">
                                                        {{ __('Product Condition') }}<span>*</span></h4>
                                                    <h4
                                                        class="rs-post-cta-title-2 d-none d-md-flex align-items-center justify-content-between">
                                                        {{ __(' Product Price') }}<span class="mr-auto">*</span>
                                                        <label class="custom-checkbox">
                                                            <input type="checkbox" name="negotiable" value="1"
                                                                {{ old('negotiable', $product->is_negotiable) ? 'checked' : '' }}>

                                                            <span class="checkmark">
                                                                <svg class="checkmark-svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14.03 8.20001L9.35999 12.86C9.21999 13.01 9.02999 13.08 8.82999 13.08C8.63999 13.08 8.44999 13.01 8.29999 12.86L5.97 10.53C5.68 10.24 5.68 9.75997 5.97 9.46997C6.26 9.17997 6.74 9.17997 7.03 9.46997L8.82999 11.27L12.97 7.14001C13.26 6.84001 13.74 6.84001 14.03 7.14001C14.32 7.43001 14.32 7.90001 14.03 8.20001Z"
                                                                        fill="#DD5454"></path>
                                                                </svg>
                                                            </span>
                                                            <cite>{{ __('negotiable') }}</cite>
                                                        </label>
                                                    </h4>
                                                </div>

                                                <div
                                                    class="rs-post-cta-select rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <select id="condition" name="condition" required>
                                                        <option value="" hidden>{{ __('Select Product Condition') }}
                                                        </option>
                                                        @foreach (\App\Enums\Conditions::cases() as $condition)
                                                            <option value="{{ $condition->value }}"
                                                                {{ old('condition', $product->conditions->value ?? $product->conditions) == $condition->value ? 'selected' : '' }}>
                                                                {{ $condition->label() }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('condition')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror


                                                    <h4
                                                        class="rs-post-cta-title-2 d-flex align-center justify-content-between d-md-none">
                                                        {{ __('Product Price') }}<span class="mr-auto">*</span>
                                                        <input type="hidden" name="negotiable" value="false">
                                                        <label class="custom-checkbox">
                                                            <input type="checkbox" id="negotiableMobile"
                                                                name="negotiable" value="false"
                                                                {{ old('negotiable', $product->negotiable) ? 'checked' : '' }}>
                                                            <span class="checkmark">
                                                                <svg class="checkmark-svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14.03 8.20001L9.35999 12.86C9.21999 13.01 9.02999 13.08 8.82999 13.08C8.63999 13.08 8.44999 13.01 8.29999 12.86L5.97 10.53C5.68 10.24 5.68 9.75997 5.97 9.46997C6.26 9.17997 6.74 9.17997 7.03 9.46997L8.82999 11.27L12.97 7.14001C13.26 6.84001 13.74 6.84001 14.03 7.14001C14.32 7.43001 14.32 7.90001 14.03 8.20001Z"
                                                                        fill="#DD5454"></path>
                                                                </svg>
                                                            </span>
                                                            <cite>{{ __('Negotiable') }}</cite>
                                                        </label>
                                                    </h4>
                                                    <input type="text" name="price"
                                                        placeholder="Write Your Product Price"
                                                        value="{{ old('price', $product->asking_price) }}">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="rs-post-cta-title-small d-flex gap-32">
                                                    <h4 class="rs-post-cta-title-2">{{ __('Phone Number') }}<span>*</span>
                                                    </h4>
                                                    <h4 class="rs-post-cta-title-2 d-none d-md-block">
                                                        {{ __('Email
                                                                                                                                                                                                                                Address') }}<span>*</span>
                                                    </h4>
                                                </div>

                                                <div class="rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <input type="text" name="phone"
                                                        placeholder="Write Your Phone Number"
                                                        value="{{ old('phone', $product->contact_number) }}">
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                    <h4 class="rs-post-cta-title-2 d-md-none">
                                                        {{ __('Email Address') }}<span>*</span>
                                                    </h4>
                                                    <input type="email" name="email"
                                                        placeholder="Write Your Email Address"
                                                        value="{{ old('email', $product->email) }}">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <h4 class="rs-post-cta-title-2">
                                                    {{ __('Product Description') }}<span>*</span></h4>
                                                <textarea class="mb-0" name="description" placeholder="Write Your Product Description">{{ old('description', $product->description) }}</textarea>
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
                                                        <input class="mb-16" type="text" name="location"
                                                            placeholder="Choose Your Location"
                                                            value="{{ old('location', getLocationName($product->latitude, $product->longitude)) }}">
                                                        @error('location')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div id="map" style="height: 450px; width: 100%;" class="br-8">
                                                </div>

                                                <!-- Location name display -->
                                                <div class="mt-2">
                                                    <strong>{{ __('Selected Location: ') }}</strong>
                                                    <span id="locationDisplay">
                                                        {{ old('location', getLocationName($product->latitude, $product->longitude)) ?? 'Not selected' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden inputs for lat/lng -->
                                        <input type="hidden" name="latitude"
                                            value="{{ old('latitude', $product->latitude) }}">
                                        <input type="hidden" name="longitude"
                                            value="{{ old('longitude', $product->longitude) }}">

                                        <div class="step-nav d-flex gap-8 justify-content-end ">
                                            <button type="button"
                                                class="next-btn btn btn-primary d-flex align-items-center justify-content-center gap-12">Next
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
                                                {{ __('Add
                                                                                                                                                                                                Product Others Information') }}
                                            </h3>
                                            <div class="rs-post-cta-contant br-8 p-24 pb-16" data-bg-color="#F6F7F9">
                                                <div class="rs-post-cta-title-small d-flex gap-32 d-none d-md-flex">
                                                    <h4 class="rs-post-cta-title-2">{{ __('Product Brand') }}</h4>
                                                    <h4 class="rs-post-cta-title-2">{{ __('Product Model') }}</h4>
                                                    <h4 class="rs-post-cta-title-2">{{ __('Warranty') }}</h4>
                                                </div>
                                                <div
                                                    class="rs-post-cta-select rs-post-cta-form d-flex align-items-center gap-32 mb-16">
                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Product Brand') }}
                                                    </h4>
                                                    <select id="brand" name="brand">
                                                        <option value="" hidden>{{ __('Select Product Brand') }}
                                                        </option>
                                                        @foreach ($brands as $brand)
                                                            @if (!$brand->brand_id)
                                                                <option value="{{ $brand->id }}"
                                                                    {{ old('brand', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                                    {{ $brand->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('brand')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Product Model') }}
                                                    </h4>
                                                    <input type="text" name="model"
                                                        placeholder="e.g. MacBook Air M2"
                                                        value="{{ old('model', $product->model) }}">
                                                    @error('model')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                    <h4 class="rs-post-cta-title-2 d-md-none">{{ __('Warranty') }}</h4>
                                                    <input type="number" name="warranty" placeholder="Enter Number in Days"
                                                        value="{{ old('warranty', $product->warranty_left ?? '') }}">
                                                    @error('warranty')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="product-colors mt-4">
                                                @foreach ($colors as $color)
                                                    <label
                                                        class="color-option {{ $product->color_code == $color->code ? 'active' : '' }}"
                                                        style="{{ $product->color_code == $color->code ? 'border: 1px solid' . $color->code : '' }}">
                                                        <input type="radio" name="color" value="{{ $color->code }}"
                                                            {{ $product->color_code == $color->code ? 'checked' : '' }}>
                                                        <div class="color-dot"
                                                            style="background-color: {{ $color->code }}"></div>
                                                        <span class="color-name"
                                                            style="{{ $product->color_code == $color->code ? 'color:' . $color->code . '!important' : '' }}">{{ $color->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>

                                            @error('color')
                                                <span class="text-danger d-block mt-1">{{ $message }}</span>
                                            @enderror


                                        </div>

                                        <div class="step-nav d-flex gap-8 justify-content-end ">
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
                                                {{ __('Product
                                                                                                                                                                                                Thumbnail') }}<span>*</span>
                                            </h3>
                                            <div class="upload-gallery-wrapper upload-gallery-wrapper-2">
                                                <div class="upload-box br-8 p-24 drop-zone" id="thumbDrop">
                                                    <input type="file" id="thumbnailInput2" name="thumbnail"
                                                        accept="image/*" class="d-none">
                                                    <label for="thumbnailInput2" class="upload-label p-relative">
                                                        <div class="upload-inner d-flex flex-column align-center">
                                                            <!-- SVG omitted for brevity -->
                                                            <p class="Drag-text">
                                                                {{ __('Drag your file(s) to start
                                                                                                                                                                                                                                                                uploading') }}<br><span>{{ __('or') }}</span>
                                                            </p>
                                                            <button type="button"
                                                                class="browse-btn">{{ __('Browse
                                                                                                                                                                                                                                                                files') }}</button>
                                                        </div>
                                                    </label>
                                                </div>

                                                <!-- Existing Thumbnail Preview -->
                                                <div id="thumbnailPreview" class="preview-item">
                                                    <img src="{{ $product->profilePath }}" alt="Thumbnail"
                                                        class="br-8" style="width:100%;height:100%;">
                                                </div>


                                                @error('thumbnail')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <span class="file-info">{{ __('Only support jpg, png and svg files') }}</span>

                                        <!-- Gallery -->
                                        <div class="rs-post-info mb-24">
                                            <h3 class="rs-post-cta-title rs-post-info-title">
                                                {{ __('Product Additional Image') }}<span
                                                    class="max-img">{{ __('(Max 10 Images)') }}</span></h3>
                                            <div class="upload-gallery-wrapper">
                                                <div class="drop-zone" id="galleryDrop">
                                                    <input type="file" id="additionalImagesInput"
                                                        name="additional_images[]" accept="image/*" multiple
                                                        class="d-none">
                                                    <label for="additionalImagesInput" class="upload-label p-relative">
                                                        <div class="upload-inner">
                                                            <!-- SVG omitted for brevity -->
                                                            <p class="Drag-text">
                                                                {{ __('Drag your files to start uploading') }}
                                                                <br><span>or</span>
                                                            </p>
                                                            <button type="button"
                                                                class="browse-btn">{{ __('Browse
                                                                                                                                                                                                                                                                files') }}</button>
                                                            <span class="file-info-2"
                                                                id="galleryCounter">{{ $product->additional_images ? count($product->additional_images) : 0 }}
                                                                {{ __('/ 10') }}</span>
                                                        </div>
                                                    </label>
                                                </div>

                                                <!-- Existing Gallery Preview -->
                                                <div class="preview-gallery" id="gallery">
                                                    @php
                                                        $galleryImages = $product->thumbnails->where(
                                                            'pivot.default',
                                                            0,
                                                        );
                                                    @endphp

                                                    @if ($galleryImages->isNotEmpty())
                                                        @foreach ($galleryImages as $image)
                                                            <div class="gallery-item br-8"
                                                                style="display:inline-block; position:relative; margin:5px;">
                                                                <img src="{{ asset('storage/' . $image->src) }}"
                                                                    alt="Additional Image"
                                                                    style="width:100%;height:100%;">
                                                                <button type="button"
                                                                    class="remove-image btn btn-sm btn-danger"
                                                                    data-image="{{ $image->src }}"
                                                                    style="position:absolute;top:0;right:0;">&times;</button>
                                                            </div>
                                                            <input type="hidden" name="existing_additional_images[]"
                                                                value="{{ $image->src }}">
                                                        @endforeach
                                                    @endif
                                                </div>

                                                @error('additional_images.*')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Navigation Buttons -->
                                        <div class="step-nav d-flex gap-8 justify-content-end ">
                                            <button type="button"
                                                class="prev-btn btn btn-secondary d-flex align-items-center gap-12">
                                                <!-- Back SVG omitted for brevity -->
                                                {{ __('Back') }}
                                            </button>
                                            <button type="submit"
                                                class="submit-btn btn btn-primary d-flex align-items-center justify-content-center gap-12">
                                                {{ __(' Update Post') }}
                                                <!-- Submit SVG omitted for brevity -->
                                            </button>
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
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

        .preview-gallery .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--tp-red-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .drop-zone.dragover {
            border: 2px dashed #DD5454;
            background-color: #FBE5E5;
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
            transition: all 0.25s ease;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .color-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
        }

        .color-option.active {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
        }

        .color-option input[type="radio"] {
            display: none;
        }

        .color-dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            transition: all 0.25s ease;
        }

        .color-name {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
        }

        /* Active / Selected state */
        .color-option input[type="radio"]:checked+.color-dot {
            border-color: #BBDCE5;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .color-option input[type="radio"]:checked~.color-name {
            color: var(--tp-red-color);
            font-weight: 600;
        }

        .color-option:has(input[type="radio"]:checked) {
            border: 1px solid #DD5454;
            box-shadow: 0 0 0 3px rgba(221, 84, 84, 0.25);
            transition: all 0.3s ease;
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

            // Step Navigation
            $('.step-tab').on('click', function() {
                const step = $(this).data('step');
                $('.step-pane').removeClass('active').filter('[data-step="' + step + '"]').addClass(
                    'active');
                $('.step-tab').removeClass('active');
                $(this).addClass('active');
            });

            $('.next-btn').on('click', function() {
                const currentPane = $('.step-pane.active');
                const nextPane = currentPane.next('.step-pane');
                if (nextPane.length) {
                    currentPane.removeClass('active');
                    nextPane.addClass('active');
                    $('.step-tab').removeClass('active').filter('[data-step="' + nextPane.data('step') +
                        '"]').addClass('active');
                }
            });

            $('.prev-btn').on('click', function() {
                const currentPane = $('.step-pane.active');
                const prevPane = currentPane.prev('.step-pane');
                if (prevPane.length) {
                    currentPane.removeClass('active');
                    prevPane.addClass('active');
                    $('.step-tab').removeClass('active').filter('[data-step="' + prevPane.data('step') +
                        '"]').addClass('active');
                }
            });
            const maxGalleryImages = 10; // Ensure this matches your HTML

            // ================= Thumbnail =================
            function renderThumbnail(file, existing = false) {
                const preview = $('#thumbnailPreview');
                preview.empty();
                const container = $('<div>').addClass('preview-item');

                const imgSrc = existing ? file : URL.createObjectURL(file);
                const img = $('<img>').attr({
                    src: imgSrc,
                    style: 'width:100%;border-radius:8px;'
                });

                const removeBtn = $('<button>').addClass('remove-btn').text('×');

                removeBtn.on('click', function() {
                    container.remove();
                    if (!existing) $('#thumbnailInput2').val('');
                    else $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_thumbnail',
                        value: '1'
                    }).appendTo('#productForm');
                });

                container.append(img).append(removeBtn);

                // Add hidden input for existing thumbnail
                if (existing) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'existing_thumbnail',
                        value: file
                    }).appendTo(container);
                }

                preview.append(container);
            }

            // Render existing thumbnail on page load
            const existingThumb = $('#thumbnailPreview').find('img').attr('src');
            if (existingThumb) renderThumbnail(existingThumb, true);

            $('#thumbnailInput2').on('change', function(e) {
                const file = e.target.files[0];
                if (file) renderThumbnail(file);
            });

            $('#thumbDrop').on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            }).on('dragleave', function() {
                $(this).removeClass('dragover');
            }).on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                const file = e.originalEvent.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    $('#thumbnailInput2').prop('files', e.originalEvent.dataTransfer.files).trigger(
                        'change');
                }
            });

            // ================= Gallery (Additional Images) =================
            function addGalleryImage(file, existing = false) {
                const preview = $('#gallery');
                const counter = $('#galleryCounter');
                const container = $('<div>').addClass('gallery-item br-8').css({
                    display: 'inline-block',
                    position: 'relative',
                    margin: '5px'
                });

                const imgSrc = existing ? file : URL.createObjectURL(file);
                const img = $('<img>').attr({
                    src: imgSrc,
                    style: 'width:100%;height:100%;'
                });

                const removeBtn = $('<button>').addClass('remove-image btn btn-sm btn-danger').text('×');

                removeBtn.on('click', function() {
                    container.remove();

                    if (existing) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'remove_additional_images[]',
                            value: file
                        }).appendTo('#productForm');
                    }

                    counter.text(preview.find('img').length + ' / ' + maxGalleryImages);
                    if (preview.find('img').length < maxGalleryImages) $('#additionalImagesInput').prop(
                        'disabled', false);
                });

                container.append(img).append(removeBtn);

                // Hidden input for existing images
                if (existing) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'existing_additional_images[]',
                        value: file
                    }).appendTo(container);
                }

                preview.append(container);
                counter.text(preview.find('img').length + ' / ' + maxGalleryImages);

                if (preview.find('img').length >= maxGalleryImages) $('#additionalImagesInput').prop('disabled',
                    true);
            }

            // Render existing gallery images on page load
            $('#gallery').find('.gallery-item').each(function() {
                const imgSrc = $(this).find('img').attr('src');
                if (imgSrc) {
                    const container = $(this);
                    const removeBtn = container.find('.remove-image');
                    removeBtn.on('click', function() {
                        container.remove();
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'remove_additional_images[]',
                            value: imgSrc
                        }).appendTo('#productForm');

                        // Update counter
                        const preview = $('#gallery');
                        const counter = $('#galleryCounter');
                        counter.text(preview.find('img').length + ' / ' + maxGalleryImages);
                        if (preview.find('img').length < maxGalleryImages) $(
                            '#additionalImagesInput').prop('disabled', false);
                    });
                }
            });

            $('#additionalImagesInput').on('change', function(e) {
                const files = Array.from(e.target.files);
                files.forEach(f => addGalleryImage(f));
            });

            $('#galleryDrop').on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            }).on('dragleave', function() {
                $(this).removeClass('dragover');
            }).on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                const files = e.originalEvent.dataTransfer.files;
                if (files.length) $('#additionalImagesInput').prop('files', files).trigger('change');
            });
        });
        // Debug Form Submission
        $('#productForm').on('submit', function(e) {
            console.log('Form submitting...');
            console.log('Thumbnail files:', $('#thumbnailInput').prop('files'));
            console.log('Additional images files:', $('#additionalImagesInput').prop('files'));
        });
    </script>


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const latInput = document.querySelector('input[name="latitude"]');
        const lngInput = document.querySelector('input[name="longitude"]');
        const locationInput = document.querySelector('input[name="location"]');
        const locationDisplay = document.getElementById('locationDisplay');

        // Default map coordinates
        let defaultLat = parseFloat(latInput.value) || 23.8103;
        let defaultLng = parseFloat(lngInput.value) || 90.4125;

        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        // OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker
        let marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        // Update lat/lng and name on marker drag
        marker.on('dragend', updateLatLngAndName);

        // Update marker and lat/lng on map click
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            marker.setLatLng([lat, lng]);
            updateLatLngAndName();
        });

        // Update map when user types location
        locationInput.addEventListener('change', function() {
            const query = locationInput.value;
            if (!query) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 13);
                        updateLatLngAndName();
                    } else {
                        alert('Location not found!');
                    }
                });
        });

        // Function to update lat/lng hidden inputs + location name
        function updateLatLngAndName() {
            const pos = marker.getLatLng();
            latInput.value = pos.lat;
            lngInput.value = pos.lng;

            // Reverse geocoding to get name
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${pos.lat}&lon=${pos.lng}`)
                .then(res => res.json())
                .then(data => {
                    locationDisplay.innerText = data.display_name || 'Unknown Location';
                })
                .catch(err => {
                    console.error(err);
                    locationDisplay.innerText = 'Unknown Location';
                });
        }

        // Initialize display name on page load
        updateLatLngAndName();
    </script>
@endpush
