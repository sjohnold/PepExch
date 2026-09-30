@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Edit Color'" :buttonText="'Back'" :buttonRoute="route('colors.show', $color->id)" :buttonIcon="'bi bi-arrow-left'" />

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <form action="{{ route('colors.update', $color->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body p-4 p-md-5">
                <div class="row g-5">

                    {{-- Left: Color Preview --}}
                    <div class="col-md-4 text-center">
                        <div class="h-100 d-flex flex-column justify-content-center p-4">
                            <h6 class="fw-semibold text-muted mb-4">
                                <i class="bi bi-palette me-2"></i> {{ __('Color Preview') }}
                            </h6>

                            <div id="colorPreview" class="rounded-4 shadow-sm mx-auto"
                                style="width: 280px; height: 280px; background-color: {{ $color->code }};"></div>

                            <div class="mt-4">
                                <span id="colorCodeDisplay" class="px-4 py-2 rounded-3 text-white fw-bold shadow-sm fs-5"
                                    style="background-color: {{ $color->code }}; letter-spacing: 0.1em;">
                                    {{ strtoupper($color->code) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Form Fields --}}
                    <div class="col-md-8 p-4">

                        {{-- Color Name --}}
                        <div class="p-3 rounded-4 mb-4">
                            <label class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                                {{ __('Color Name *') }}
                            </label>
                            <input type="text" name="name" class="form-control form-control-lg border-0 shadow-sm mt-2 fw-bold"
                                placeholder="e.g. Red" value="{{ old('name', $color->name) }}">

                            @error('name')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Color Code --}}
                        <div class="p-3 rounded-4 mb-4">
                            <label class="text-uppercase text-muted small fw-medium" style="letter-spacing: 0.08em;">
                                {{ __('Color Code') }}
                            </label>
                            <div class="d-flex gap-3 mt-2">
                                <input type="color" id="colorPicker" class="form-control form-control-lg form-control-color shadow-sm"
                                    value="{{ old('code', $color->code) }}" style="height: 50px; width: 80px; border: 0;">

                                <input type="text" id="colorCode" name="code" class="form-control form-control-lg border-0 shadow-sm flex-grow-1 fw-bold"
                                    placeholder="#000000" value="{{ old('code', $color->code) }}">
                            </div>

                            @error('code')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex justify-content-end pt-3">
                            <x-update-button :title="'Update Color'" :icon="'fas fa-save'" />
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const colorPicker = document.getElementById('colorPicker');
        const colorCode = document.getElementById('colorCode');
        const colorPreview = document.getElementById('colorPreview');
        const colorCodeDisplay = document.getElementById('colorCodeDisplay');

        function updateColor(color) {
            colorPreview.style.backgroundColor = color;
            colorCodeDisplay.style.backgroundColor = color;
            colorCodeDisplay.textContent = color.toUpperCase();
        }

        // Update preview and code when color picker changes
        colorPicker.addEventListener('input', function() {
            colorCode.value = this.value;
            updateColor(this.value);
        });

        // Update preview and picker when code input changes
        colorCode.addEventListener('input', function() {
            const value = this.value;
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                colorPicker.value = value;
                updateColor(value);
            }
        });

        // Set initial color
        updateColor(colorCode.value);
    </script>
@endsection
