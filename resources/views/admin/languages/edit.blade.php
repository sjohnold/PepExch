@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header
            :title="'Edit Language'"
            :buttonText="'Back'"
            :buttonRoute="route('languages.index')"
            :buttonIcon="'bi bi-arrow-left'"
        />

        <div class="card-body p-4" style="padding-left:20px; margin-left:20px">
            <form action="{{ route('languages.update', $language->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Flag Image --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">{{ __('Flag (Thumbnail)') }}</label>

                        <div class="d-flex flex-column gap-3">
                            <div>
                                <img id="imagePreview"
                                    src="{{ $language->thumbnail ? asset('storage/' . $language->thumbnail->src) : 'https://placehold.co/600x400' }}"
                                    class="rounded-3"
                                    style="width:90%; height:280px; object-fit:cover; cursor:pointer; border:2px dashed #ccc;"
                                    onclick="document.getElementById('imageInput').click()">
                            </div>

                            <input type="file" name="thumbnail" id="imageInput" accept="image/*" class="d-none">

                            <small class="text-muted">
                                <strong>{{ __('Click on image to change flag (PNG, JPG – Max 2MB)') }}</strong>
                            </small>
                        </div>
                    </div>

                    {{-- Inputs --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Country Name --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Country Name') }}
                                </label>
                                <input type="text"
                                    name="title"
                                    class="form-control form-control-lg shadow-sm"
                                    placeholder="Country Name"
                                    value="{{ old('title', $language->title) }}"
                                    required
                                    style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Language Code --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Language Code') }}
                                </label>
                                <input type="text"
                                    name="name"
                                    class="form-control form-control-lg shadow-sm"
                                    placeholder="en, bn"
                                    value="{{ old('name', $language->name) }}"
                                    required
                                    style="padding:0.75rem 1rem;">
                            </div>

                            {{-- Status --}}
                            <div class="col-6 mt-4">
                                <div class="card border-0 bg-light shadow-sm">
                                    <div class="card-body">
                                        <label class="form-label fw-semibold mb-2">
                                            {{ __('Status') }}
                                        </label>
                                        <select name="status" class="form-select form-select-lg shadow-sm">
                                            <option value="1" {{ old('status', $language->status) == 1 ? 'selected' : '' }}>
                                                {{ __('Active') }}
                                            </option>
                                            <option value="0" {{ old('status', $language->status) == 0 ? 'selected' : '' }}>
                                                {{ __('Inactive') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 d-flex justify-content-end pt-3">
                        <x-update-button :title="'Update Language'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
