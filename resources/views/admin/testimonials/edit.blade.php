@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Edit Testimonial'" :buttonText="'Back'" :buttonRoute="route('testimonials.index')" :buttonIcon="'bi bi-arrow-left'" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name"
                        value="{{ old('name', $testimonial->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">{{ __('Designation') }}</label>
                    <input type="text" class="form-control" id="designation" name="designation"
                        placeholder="Enter Your Designation" value="{{ old('designation', $testimonial->designation) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">{{ __('Rating') }}</label>
                    <select class="form-select" id="rating" name="rating" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}"
                                {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} Star - {{ str_repeat('⭐', $i) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control" id="description" placeholder="Enter Description" name="description" rows="4"
                        required>{{ old('description', $testimonial->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Thumbnail') }}</label>

                    <div class="d-flex align-items-center gap-3">
                        <!-- Preview (Left side) -->
                        <img id="imagePreview" src="{{ $testimonial->thumbnailPath ?? 'https://placehold.co/300x200' }}"
                            style="width:300px; height:200px; border-radius:8px; object-fit:cover;">

                        <!-- File Input (Right side) -->
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*"
                            style="padding-top:15px;">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <!-- Hidden input ensures unchecked checkbox sends 0 -->
                    <input type="hidden" name="status" value="0">

                    <input type="checkbox" class="form-check-input" id="status" name="status" value="1"
                        {{ old('status', $testimonial->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ __('Active') }}</label>
                </div>


                <x-update-button :title="'Update Testimonial'" :icon="'fas fa-save'" />
            </form>
        </div>
    </div>

    <script>
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
