@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Edit Service'" :subtitle="'Complete Service information management'" :icon="'fas fa-user-edit'" :buttonText="'Back'" :buttonRoute="route('services.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <h2> {{ __('Edit Service') }}</h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Main Service Title --}}
        <div class="mb-3">
            <label class="form-label">{{ __('Main Title') }} <span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Main Description') }}</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
        </div>

        <hr>
        <h4>Services</h4>

        <div id="services-wrapper">
            @php $index = 1; @endphp
            @foreach ($service->services as $key => $item)
                <div class="service-item border rounded p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">{{ __('Service Title') }}</label>
                        <input type="text" name="services[service{{ $index }}][title]" class="form-control"
                            value="{{ $item['title'] ?? 'Service' . $index }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">{{ __('Thumbnail') }}</label>
                        <input type="file" name="services[service{{ $index }}][thumbnail_id]"
                            class="form-control thumbnail-input" data-preview="preview-{{ $index }}"
                            style="padding: 15px">
                        {{-- Hidden input to keep old thumbnail --}}
                        <input type="hidden" name="services[service{{ $index }}][old_thumbnail_id]"
                            value="{{ $item['thumbnail_id'] ?? '' }}">

                        @php
                            $media = \App\Models\Media::find($item['thumbnail_id']);
                            $thumbnailUrl = $media ? Storage::url($media->src) : 'https://placehold.jp/100x100.png';
                        @endphp
                        <img id="preview-{{ $index }}" src="{{ $thumbnailUrl }}" class="img-thumbnail mt-2"
                            style="max-width:100px;">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                        <input type="text" name="services[service{{ $index }}][service_title]"
                            class="form-control" required value="{{ $item['service_title'] ?? '' }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">{{ __('Subtitle') }}</label>
                        <input type="text" name="services[service{{ $index }}][subtitle]" class="form-control"
                            value="{{ $item['subtitle'] ?? '' }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="services[service{{ $index }}][description]" class="form-control" rows="2">{{ $item['description'] ?? '' }}</textarea>
                    </div>

                    {{-- Active/Inactive Status --}}
                    <div class="mb-2">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="services[service{{ $index }}][status]" class="form-control">
                            <option value="active" {{ ($item['status'] ?? 'active') === 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive" {{ ($item['status'] ?? '') === 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>

                    <button type="button"
                        class="btn btn-danger btn-sm remove-service {{ $index == 1 ? 'd-none' : '' }}">{{ __('Remove') }}</button>
                </div>
                @php $index++; @endphp
            @endforeach
        </div>

        <button type="button" id="add-service" class="btn btn-primary btn-sm mb-3">
            + {{ __('Add Service') }}
        </button>

        <div>
            <button type="submit" class="btn btn-success">{{ __('Update Service') }}</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>

    </form>


    {{-- Script for dynamic repeater + image preview --}}
    <script>
        let serviceIndex = {{ $index }};

        // Add new service
        document.getElementById('add-service').addEventListener('click', function() {
            let wrapper = document.getElementById('services-wrapper');
            let newItem = document.querySelector('.service-item').cloneNode(true);

            newItem.querySelectorAll('input, textarea, select').forEach(function(input) {
                let name = input.getAttribute('name');
                if (name) {
                    let newName = name.replace(/\[service\d+\]/, '[service' + serviceIndex + ']');
                    input.setAttribute('name', newName);

                    if (input.name.includes('[title]')) {
                        input.value = 'Service' + serviceIndex;
                    } else if (input.tagName.toLowerCase() === 'select') {
                        input.value = 'active';
                    } else {
                        input.value = '';
                    }

                    if (input.type === 'hidden' && input.name.includes('old_thumbnail_id')) {
                        input.value = '';
                    }
                }
            });

            // Set preview image for new item
            let previewImg = newItem.querySelector('img');
            previewImg.id = 'preview-' + serviceIndex;
            previewImg.src = 'https://placehold.jp/100x100.png';

            let fileInput = newItem.querySelector('.thumbnail-input');
            fileInput.setAttribute('data-preview', 'preview-' + serviceIndex);

            newItem.querySelector('.remove-service').classList.remove('d-none');
            wrapper.appendChild(newItem);

            serviceIndex++;
        });

        // Remove service
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-service')) {
                e.target.closest('.service-item').remove();
            }
        });

        // Live image preview
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('thumbnail-input')) {
                const previewId = e.target.getAttribute('data-preview');
                const previewImg = document.getElementById(previewId);
                if (e.target.files && e.target.files[0]) {
                    previewImg.src = URL.createObjectURL(e.target.files[0]);
                }
            }
        });
    </script>
@endsection
