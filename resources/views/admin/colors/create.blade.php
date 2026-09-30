@extends('layouts.app')

@section('content')
    <div class="card shadow-lg rounded-3">
        {{-- Page Header --}}
        <x-table-header :title="'Add Color'" :subtitle="'Create color for your products'" :icon="'bi bi-plus'" :buttonText="'Back'" :buttonRoute="route('colors.index')" :buttonIcon="'bi bi-arrow-left'" />

        <div class="card-body p-4" style="padding-left:20px; margin-left:20px">
            <form action="{{ route('colors.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Left: Color Preview --}}
                    <div class="col-4">
                        <label class="form-label fw-semibold text-dark">
                            {{ __('Color Preview') }}
                        </label>

                        <div class="d-flex flex-column gap-3">
                            <div id="colorPreview" class="rounded-3 shadow-sm"
                                style="width:90%; height:280px; background:#000000; border:2px dashed #ccc;">
                            </div>

                            <div>
                                <span id="colorCodeDisplay"
                                    class="px-4 py-2 rounded-3 text-white fw-bold shadow-sm d-inline-block"
                                    style="background:#000000; letter-spacing:0.1em;">
                                    #000000
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Form Fields --}}
                    <div class="col-8">
                        <div class="row">
                            {{-- Color Name --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Color Name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-lg shadow-sm @error('name') is-invalid @enderror"
                                    placeholder="e.g. Red" required style="border:1px solid #dee2e6; padding:0.75rem 1rem;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Color Code --}}
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    {{ __('Color Code') }}
                                </label>

                                <div class="d-flex gap-3">
                                    <input type="color" id="colorPicker" class="form-control form-control-color shadow-sm"
                                        value="{{ old('code', '#000000') }}" style="height:50px; width:80px; border:0;">

                                    <input type="text" id="colorCode" name="code" value="{{ old('code', '#000000') }}"
                                        class="form-control form-control-lg shadow-sm @error('code') is-invalid @enderror"
                                        placeholder="#000000" style="border:1px solid #dee2e6;">
                                </div>

                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="col-12 d-flex justify-content-end gap-2 pt-3">
                        <x-update-button :title="'Save Color'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Color Sync Script --}}
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

        colorPicker.addEventListener('input', function() {
            colorCode.value = this.value;
            updateColor(this.value);
        });

        colorCode.addEventListener('input', function() {
            const value = this.value;
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                colorPicker.value = value;
                updateColor(value);
            }
        });

        updateColor(colorCode.value);
    </script>
@endsection
