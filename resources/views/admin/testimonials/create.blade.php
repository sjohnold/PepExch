@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header
            :title="'Create Testimonial'"
            :buttonText="'Back'"
            :buttonRoute="route('testimonials.index')"
            :buttonIcon="'bi bi-arrow-left'"
        />

        <div class="card-body p-4" style="padding-left:20px; margin-left:20px">
            <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Image --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">{{ __('Thumbnail') }}</label>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <img id="imagePreview"
                                    src="https://placehold.co/600x400"
                                    class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>
                               
                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong>{{ __('Click on image to upload (JPG, PNG, JPEG – Max 2MB)') }}</strong>
                            </small>
                        </div>
                    </div>

                    {{-- Inputs --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">{{ __('Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control form-control-lg shadow-sm"
                                    placeholder="Enter Name"
                                    value="{{ old('name') }}"
                                    required
                                    style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Designation --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">{{ __('Designation') }}</label>
                                <input type="text" name="designation"
                                    class="form-control form-control-lg shadow-sm"
                                    placeholder="Enter Designation"
                                    value="{{ old('designation') }}"
                                    required
                                    style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Rating --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">{{ __('Rating') }}</label>
                                <select name="rating"
                                    class="form-select form-select-lg shadow-sm"
                                    required
                                    style="padding:0.75rem 1rem;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} Star {{ str_repeat('⭐', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Status --}}
                            <div class="col-6 mt-4">
                                <div class="card border-0 bg-light shadow-sm">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" name="status" value="1"
                                                class="form-check-input"
                                                style="width:3rem; height:1.5rem; cursor:pointer;"
                                                {{ old('status', 1) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold ms-2">
                                                {{ __('Active') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold text-dark">{{ __('Description') }}</label>
                                <textarea name="description"
                                    rows="4"
                                    class="form-control shadow-sm"
                                    placeholder="Enter Description"
                                    style="padding:0.75rem 1rem;"
                                    required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 d-flex justify-content-end pt-3">
                        <x-update-button :title="'Create Testimonial'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
