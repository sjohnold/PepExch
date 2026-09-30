@extends('layouts.app')

@section('content')
    <x-table-header :title="'Edit Boost Plan'" :subtitle="'Create Your Boost Plan Here'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('plans.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <form action="{{ route('plans.update', $plan->id) }}" method="POST" enctype="multipart/form-data" class="mb-100">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required
                placeholder="Enter Boost Plan Name">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>{{ __('Description') }}</label>
            <textarea name="description" class="form-control" required placeholder="Enter description">{{ old('description', $plan->description) }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="mb-3">
            <label>{{ __('Payable Amount') }}</label>
            <input type="text" name="payable_amount" class="form-control" value="{{ $plan->payable_amount }}" required
                placeholder="Enter Payable Ammount">
            @error('payable_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>{{ __('Discount Amount') }}</label>
            <input type="text" name="discount_amount" class="form-control" value="{{ $plan->discount_amount }}"
                placeholder="Enter Discount Ammount">
            @error('discount_amount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">

            <div id="planItemsWrapper">
                @php
                    $planItems = json_decode($plan->plan_items, true) ?? [];
                @endphp
                <label>{{ __('Plan Items') }}</label>
                @foreach ($planItems as $item)
                    <div class="input-group mb-2 plan-item">
                        <input type="text" name="plan_items[]" class="form-control"
                            value="{{ is_array($item) ? json_encode($item) : $item }}">
                        <button type="button" class="btn btn-danger remove-item">{{ __('Remove') }}</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary mt-3 mb-3 shadow-sm" id="add-item">
                <i class="bi bi-plus-circle me-1"></i> {{ __('Add Item') }}
            </button>
        </div>

        <div class="mb-3">
            <label>{{ __('Sustain Days') }}</label>
            <input type="number" name="sustain_days" class="form-control" value="{{ $plan->sustain_days }}" required
                placeholder="Enter Days (Max:3000 days)">
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            {{-- Preview --}}
            <div class="mt-3" id="thumbnailPreview">
                @if ($plan->thumbnail)
                    <p class="mb-1">{{ __('Current Image:') }}</p>
                    <img src="{{ asset('storage/' . $plan->thumbnail->src) }}" alt="Thumbnail" width="150"
                        height="150" class="rounded">
                @endif
            </div>

            <label class="form-label">{{ __('Thumbnail') }}</label>
            <input type="file" name="thumbnail" id="thumbnailInput" class="form-control" style="padding: 15px">
        </div>


        <x-update-button :title="'Update'" :icon="'fas fa-save'"></x-update-button>
    </form>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.getElementById('planItemsWrapper');
                const addBtn = document.getElementById('addPlanItem');

                addBtn.addEventListener('click', function() {
                    const div = document.createElement('div');
                    div.classList.add('input-group', 'mb-2', 'plan-item');
                    div.innerHTML = `
                <input type="text" name="plan_items[]" class="form-control" placeholder="New item">
                <button type="button" class="btn btn-danger remove-item">Remove</button>
            `;
                    wrapper.appendChild(div);
                });

                wrapper.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-item')) {
                        e.target.closest('.plan-item').remove();
                    }
                });
            });
        </script>
        <script>
            const thumbnailInput = document.getElementById('thumbnailInput');
            const thumbnailPreview = document.getElementById('thumbnailPreview');

            thumbnailInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Remove old preview
                thumbnailPreview.innerHTML = '';

                // Create new image preview
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 150;
                img.height = 150;
                img.classList.add('rounded');

                thumbnailPreview.appendChild(img);
            });
        </script>
    @endpush
@endsection
