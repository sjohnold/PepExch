@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header :title="'Edit Fast Selling'" :subtitle="'Showing Fast Selling Items'" :icon="'bi bi-folder'" :buttonText="'Back'" :buttonRoute="route('fast-selling.index')"
            :buttonIcon="'bi bi-arrow-left'" />

        <div class="card-body p-4" style="padding-left:20px; margin-left:20px">
            <form action="{{ route('fast-selling.update', $fastSelling->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Image --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">{{ __('Thumbnail') }}</label>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <img id="imagePreview"
                                    src="{{ $fastSelling->thumbnail ? asset('storage/' . $fastSelling->thumbnail->src) : 'https://placehold.co/600x400' }}"
                                    class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>

                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong>{{ __('Click on image to change (JPG, PNG, JPEG – Max 2MB)') }}</strong>
                            </small>
                        </div>
                    </div>

                    {{-- Inputs --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Title --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Title') }}
                                </label>
                                <input type="text" name="title" class="form-control form-control-lg shadow-sm"
                                    value="{{ old('title', $fastSelling->title) }}" required style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Subtitle --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Subtitle') }}
                                </label>
                                <input type="text" name="subtitle" class="form-control form-control-lg shadow-sm"
                                    value="{{ old('subtitle', $fastSelling->subtitle) }}" style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Description --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Description') }}
                                </label>
                                <textarea name="description" rows="4" class="form-control shadow-sm" style="padding:0.75rem 1rem;">{{ old('description', $fastSelling->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 d-flex justify-content-end pt-3">
                        <x-update-button :title="'Update Fast Selling'" :icon="'fas fa-save'" />
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
