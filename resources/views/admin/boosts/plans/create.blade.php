@extends('layouts.app')
@section('content')

    {{-- Page Header --}}
    <x-table-header :title="'Create Boost Plan'" :subtitle="'Create Your Boost Plan Here'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('plans.index')"
        :buttonIcon="'bi bi-arrow-left'" />
    <form action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data" class="mb-100">
        @csrf

        <div class="mb-3">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" required placeholder="Enter Boost Plan Name"
                value="{{ old('name') }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>{{ __('Description') }}</label>
            <textarea name="description" class="form-control" required placeholder="Enter description">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="mb-3">
            <label>{{ __('Payable Amount') }}</label>
            <input type="number" name="payable_amount" class="form-control" required placeholder="Enter Payable Amount"
                value="{{ old('payable_amount') }}">
            @error('payable_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>{{ __('Discount Amount') }}</label>
            <input type="number" name="discount_amount" class="form-control" placeholder="Enter Discount Amount"
                value="{{ old('discount_amount') }}">
            @error('discount_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- Plan Items Section --}}
        <label>{{ __('Plan Items') }}</label>
        <ul id="plan-items-wrapper" class="list-unstyled">
            @if (old('plan_items'))
                @foreach (old('plan_items') as $item)
                    <li class="d-flex mb-2 plan-item">
                        <input type="text" name="plan_items[]" class="form-control" placeholder="Enter plan item"
                            value="{{ $item }}" required>
                        <button type="button" class="btn btn-danger ms-2 remove-item">{{ __('X') }}</button>
                    </li>
                @endforeach
            @else
                <li class="d-flex mb-2 plan-item">
                    <input type="text" name="plan_items[]" class="form-control" placeholder="Enter plan item" required>
                    <button type="button" class="btn btn-danger ms-2 remove-item"
                        style="visibility: hidden;">{{ __('X') }}</button>
                </li>
            @endif
        </ul>
        <button type="button" class="btn btn-secondary mt-3 mb-3 shadow-sm" id="add-item">
            <i class="bi bi-plus-circle me-1"></i> {{ __('Add Item') }}
        </button>

        <!-- Sustain Days Input -->
        <div class=" pt-3">
            <label for="sustain_days" class="mb-1">{{ __('Sustain Days') }}</label>
            <input type="number" id="sustain_days" name="sustain_days" class="form-control" min="1" required
                placeholder="Enter Days (Max:3000 days)" value="{{ old('sustain_days') }}">
            @error('sustain_days')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Thumbnail Select -->
        <div class="pt-3">
            <label class="mb-1">{{ __('Thumbnail') }}</label>

            <!-- Image Preview Box (Upore) -->
            <div id="thumbnail-preview" class="mb-3" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-3">
                        <img id="preview-image" src="" alt="Thumbnail Preview" class="img-fluid rounded"
                            style="max-height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <input type="file" name="thumbnail" class="form-control" id="thumbnail-input" accept="image/*"
                style="padding: 15px">
            @error('thumbnail')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-4 pt-5">
            <x-update-button :title="'Submit'" :icon="'fas fa-save'"></x-update-button>
        </div>
    </form>


    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const wrapper = document.getElementById("plan-items-wrapper");
                const addBtn = document.getElementById("add-item");

                // Add new item
                addBtn.addEventListener("click", function() {

                    const li = document.createElement("li");
                    li.classList.add("d-flex", "mb-2", "plan-item");
                    li.innerHTML = `
                    <input type="text" name="plan_items[]" class="form-control" placeholder="Enter plan item" required>
                    <button type="button" class="btn btn-danger ms-2 remove-item">X</button>
                `;
                    wrapper.appendChild(li);
                });

                // Remove item
                wrapper.addEventListener("click", function(e) {
                    if (e.target.classList.contains("remove-item")) {
                        e.target.closest(".plan-item").remove();
                    }
                });
            });
        </script>

        <script>
            // Thumbnail Preview
            const thumbnailInput = document.getElementById('thumbnail-input');
            const previewBox = document.getElementById('thumbnail-preview');
            const previewImage = document.getElementById('preview-image');

            if (thumbnailInput) {
                thumbnailInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            previewImage.src = event.target.result;
                            previewBox.style.display = 'block';
                        };

                        reader.readAsDataURL(file);
                    } else {
                        previewBox.style.display = 'none';
                    }
                });
            }
        </script>
    @endpush

@endsection
