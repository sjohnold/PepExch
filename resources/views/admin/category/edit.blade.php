@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header :title="'Edit Category'" :subtitle="'Edit and Manage Your category Here'" :icon="'bi bi-folder'":buttonText="'Back'" :buttonRoute="route('category.index')"
            :buttonIcon="'bi bi-arrow-left'" />

        <div class="card-body p-4" style="padding-left: 20px; margin-left:20px">
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Image --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">{{ __('Image') }}</label>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <img id="imagePreview"
                                    src="{{ $category->thumbnail ? asset('storage/' . $category->thumbnail->src) : 'https://placehold.co/600x400' }}"
                                    alt="Preview" class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>

                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong> {{ __('Click on image to Change ') }}(JPG, PNG, JPEG – Max 2MB)</strong>
                            </small>
                        </div>
                    </div>

                    {{-- Inputs --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Category Name --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="me-2 text-primary"></i>{{ __('Category Name') }}
                                </label>
                                <input type="text" name="name" class="form-control form-control-lg shadow-sm"
                                    value="{{ old('name', $category->name) }}" required
                                    style="border: 1px solid #dee2e6; padding: 0.75rem 1rem;">
                            </div>

                            {{-- Parent Category --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="me-2 text-info"></i>{{ __('Parent Category') }}
                                </label>
                                <select name="parent_id" class="form-select form-select-lg shadow-sm"
                                    style="padding: 0.75rem 1rem;">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach ($parents as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $category->parent_id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Featured --}}
                            <div class="col-6 mt-4">
                                <div class="card border-0 bg-light shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="is_featured" value="1"
                                                class="form-check-input" id="is_featured"
                                                style="width: 3rem; height: 1.5rem; cursor: pointer;"
                                                {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                            <label for="is_featured" class="form-check-label fw-semibold ms-2"
                                                style="cursor: pointer;">
                                                <i class="bi bi-star me-2 text-warning"></i>{{ __('Is Featured?') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 d-flex justify-content-end gap-2 pt-3">
                        <x-update-button :title="'Update Category'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (!file) return;

            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
