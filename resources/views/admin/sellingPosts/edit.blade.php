@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Edit Product'" :subtitle="'Manage All Selling Posts'" :icon="'bi bi-pencil-square'" :buttonText="'Back to Posts'" :buttonRoute="route('posts.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <div class="card shadow border-0 mt-3 mb-100">
        <div class="card-body">

            @can('posts.update')
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name & Condition --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                value="{{ old('name', $post->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Condition') }}</label>
                            <input type="text" name="condition" class="form-control form-control-lg"
                                value="{{ old('condition', $post->conditions) }}">
                            @error('condition')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    {{-- Contact --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control form-control-lg"
                                value="{{ old('phone', $post->contact_number) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                value="{{ old('email', $post->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Description') }}</label>
                        <textarea name="description" rows="4" class="form-control form-control-lg">{{ old('description', $post->description) }}</textarea>
                    </div>

                    {{-- Brand / Model / Color --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('Brand') }}</label>
                            <select name="brand" class="form-select form-select-lg">
                                <option value="">-- Select Brand --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $post->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('Model') }}</label>
                            <input type="text" name="model" class="form-control form-control-lg"
                                value="{{ old('model', $post->model) }}">
                            @error('model')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('Color Code') }}</label>
                            <input type="text" name="color" class="form-control form-control-lg"
                                value="{{ old('color', $post->color_code) }}">
                            @error('color')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Status & Sold --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Status') }}</label>
                            <select name="status" class="form-select form-select-lg">
                                @foreach (\App\Enums\PostStatus::cases() as $statusOption)
                                    <option value="{{ $statusOption->value }}"
                                        {{ old('status', $post->status) == $statusOption->value ? 'selected' : '' }}>
                                        {{ $statusOption->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Sold?') }}</label>
                            <select name="is_sold" class="form-select form-select-lg">
                                <option value="0" {{ !$post->is_sold ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $post->is_sold ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Thumbnail') }}
                            <span style="color: #9ca3af; font-size: 0.8rem; font-weight: 400;">(Max 2MB)</span>
                        </label>
                        <div id="thumbnailPreview" class="mt-2 d-flex gap-2">
                            @if ($post->profile)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $post->profile->src) }}" width="200"
                                        class="rounded border shadow-sm">
                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-thumb">×</button>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="form-control mt-2"
                            style="padding: 15px">
                        @error('thumbnail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    {{-- Additional Images --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Additional Images') }}</label>
                        <div id="existingImages" class="d-flex flex-wrap gap-2">
                            @if ($post->thumbnails && $post->thumbnails->count() > 0)
                                @foreach ($post->thumbnails as $media)
                                    <div class="position-relative image-box" style="width: 150px; height: 150px;">
                                        <img src="{{ asset('storage/' . $media->src) }}"
                                            class="img-fluid rounded border shadow-sm"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                        <input type="hidden" name="existing_additional_images[]"
                                            value="{{ $media->src }}">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing"
                                            style="padding: 0.2rem 0.4rem; font-size: 0.8rem;">×</button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">{{ 'No additional images uploaded yet' }}.</p>
                            @endif
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            {{ __('Add More Images') }}
                            <span style="color: #9ca3af; font-size: 0.8rem; font-weight: 400;">(Max 2MB)</span>
                        </label>
                        <input type="file" name="additional_images[]" id="additionalImagesInput" class="form-control"
                            multiple style="padding: 15px">

                        @if ($errors->hasAny(['additional_images', 'additional_images.*']))
                            <div class="mt-1">
                                @foreach ($errors->get('additional_images.*') as $messages)
                                    @foreach ($messages as $message)
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @endforeach
                                @endforeach
                                @error('additional_images')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

                        <div id="newImagesPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    {{-- Categories --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Category') }}</label>
                            <select name="category" class="form-select form-select-lg">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $post->categories->contains($cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Sub Category') }}</label>
                            <select name="subcategory" class="form-select form-select-lg">
                                <option value="">-- Select Subcategory --</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ $post->categories->contains($sub->id) ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" />
                    </div>

                    <input type="hidden" name="redirect_status" value="{{ request()->route('status') ?? $post->status }}">

                </form>
            @endcan

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Thumbnail Preview
        const thumbnailInput = document.getElementById('thumbnailInput');
        const thumbnailPreview = document.getElementById('thumbnailPreview');

        thumbnailInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            thumbnailPreview.innerHTML = '';

            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative');
            wrapper.style.width = '150px';
            wrapper.style.height = '150px';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 150;
            img.height = 150;
            img.style.objectFit = 'cover';
            img.classList.add('rounded', 'border', 'shadow-sm');

            // Remove button
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerText = '×';
            btn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0', 'end-0', 'remove-thumb');
            btn.style.padding = '0.2rem 0.4rem';
            btn.style.fontSize = '0.8rem';

            wrapper.appendChild(img);
            wrapper.appendChild(btn);
            thumbnailPreview.appendChild(wrapper);
        });

        // Click handlers for removing images
        document.addEventListener('click', function(e) {
            // Remove new thumbnail
            if (e.target.classList.contains('remove-thumb')) {
                thumbnailPreview.innerHTML = '';
                thumbnailInput.value = '';
            }

            // Remove existing additional images
            if (e.target.classList.contains('remove-existing')) {
                const box = e.target.closest('.image-box');
                const src = box.dataset.src;

                // Add hidden input to mark for removal
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_additional_images[]';
                input.value = src;
                document.querySelector('form').appendChild(input);

                box.remove();
            }

            // Remove new additional images
            if (e.target.classList.contains('remove-new')) {
                e.target.closest('.image-box').remove();
                // Optional: remove file from input (advanced, needs DataTransfer)
            }
        });

        // New Additional Images Preview
        const additionalInput = document.getElementById('additionalImagesInput');
        const newPreview = document.getElementById('newImagesPreview');

        additionalInput?.addEventListener('change', function() {
            newPreview.innerHTML = ''; // clear previous previews

            [...this.files].forEach(file => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative', 'image-box');
                wrapper.style.width = '150px';
                wrapper.style.height = '150px';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 150;
                img.height = 150;
                img.style.objectFit = 'cover';
                img.classList.add('rounded', 'border', 'shadow-sm');

                // Remove button
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = '×';
                btn.classList.add('btn', 'btn-sm', 'btn-danger', 'position-absolute', 'top-0', 'end-0',
                    'remove-new');
                btn.style.padding = '0.2rem 0.4rem';
                btn.style.fontSize = '0.8rem';

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                newPreview.appendChild(wrapper);
            });
        });
    </script>
@endpush
