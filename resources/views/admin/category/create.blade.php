@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header :title="'Create New Category'" :subtitle="'Create Your Category Here'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('category.index')"
            :buttonIcon="'bi bi-arrow-left'" />

        <div class="card-body p-4" style="padding-left: 20px; margin-left:20px">
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Image  --}}
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">
                            {{ __('Image') }}
                        </label>

                        <div class="d-flex flex-column gap-3">
                            <!-- Clickable Image -->
                            <div>
                                <img id="imagePreview" src="https://placehold.co/600x400" alt="Preview" class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>

                            <!-- Hidden Input -->
                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong> Click on image to upload (JPG, PNG, JPEG – Max 2MB)</strong>
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="me-2 text-primary"></i>{{ __('Category Name') }}
                                </label>
                                <input type="text" name="name" class="form-control form-control-lg shadow-sm"
                                    placeholder="Enter category name" required
                                    style="border: 1px solid #dee2e6; padding: 0.75rem 1rem;">
                            </div>

                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="me-2 text-info"></i>{{ __('Parent Category') }}
                                </label>
                                <select name="parent_id" class="form-select form-select-lg shadow-sm"
                                    style="padding: 0.75rem 1rem;">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-6 mt-4">
                                <div class="card border-0 bg-light shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="is_featured" value="1"
                                                class="form-check-input" id="is_featured"
                                                style="width: 3rem; height: 1.5rem; cursor: pointer;"
                                                {{ old('is_featured', $category->is_featured ?? false) ? 'checked' : '' }}>
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

                    <div class="col-12 d-flex justify-content-end gap-2 pt-3">
                        <x-update-button :title="'Submit'" :icon="'fas fa-save'"></x-update-button>
                    </div>
                </div>

            </form>
        </div>
    </div>



    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {

            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (!file) {
                preview.src = 'https://placehold.co/600x400';
                return;
            }

            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(file);
        });
    </script>
@endsection
