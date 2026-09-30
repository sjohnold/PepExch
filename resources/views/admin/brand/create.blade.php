@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header :title="'Create New Brand'" :subtitle="'Create Your Own Brand'" :icon="'bi bi-plus-circle'" :buttonText="'Back'" :buttonRoute="route('brand.index')"
            :buttonIcon="'bi bi-arrow-left'" />

        <div class="card-body p-4" style="padding-left:20px; margin-left:20px">
            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Left Image Upload --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">
                            {{ __('Brand Image') }}
                        </label>

                        <div class="d-flex flex-column gap-3">
                            {{-- Clickable Image --}}
                            <div>
                                <img id="imagePreview" src="https://placehold.co/600x400" alt="Preview" class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>

                            {{-- Hidden Input --}}
                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong>Click on image to upload (JPG, PNG, JPEG – Max 2MB)</strong>
                            </small>

                            @error('thumbnail')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Form Fields --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Brand Name --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Brand Name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-lg shadow-sm @error('name') is-invalid @enderror"
                                    placeholder="Enter brand name" required
                                    style="border:1px solid #dee2e6; padding:0.75rem 1rem;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Brand Status --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Status') }}
                                </label>

                                <select name="is_active"
                                    class="form-select form-select-lg shadow-sm @error('is_active') is-invalid @enderror"
                                    style="border:1px solid #dee2e6; padding:0.75rem 1rem;">
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 d-flex justify-content-end gap-2 pt-3">
                        <x-update-button :title="'Save Brand'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (!file) {
                preview.src = 'https://placehold.co/600x400';
                return;
            }

            const reader = new FileReader();
            reader.onload = () => preview.src = reader.result;
            reader.readAsDataURL(file);
        });
    </script>
@endsection
