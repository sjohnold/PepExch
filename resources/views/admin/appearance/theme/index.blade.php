@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Header Section -->
            <x-table-header :title="'Theme Customization'" :subtitle="'Customize your website colors and appearance'" :icon="'fas fa-palette'" />

            <!-- Main Form Card -->
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-0">
                    <form action="{{ route('theme.update') }}" method="POST" id="themeForm">
                        @csrf

                        <div class="row g-0">
                            <!-- Left Side - Color Inputs -->
                            <div class="col-lg-7 p-4 p-lg-5">
                                <h5 class="fw-bold mb-4 text-dark">{{ __('Appearance Settings') }}</h5>

                                <!-- Primary Color -->
                                <div class="mb-4 p-3 bg-light rounded-3">
                                    <label class="form-label fw-semibold d-flex align-items-center mb-3">
                                        <span class="color-dot me-2 rounded-circle"
                                            style="width: 12px; height: 12px; background: {{ old('primary_color', $themeData['primary_color'] ?? '#0d6efd') }};"></span>
                                        {{ __('Primary Color') }}
                                    </label>
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <input type="color" name="primary_color" id="primary_color"
                                                class="form-control form-control-color border-2"
                                                style="width: 80px; height: 50px; cursor: pointer;"
                                                value="{{ old('primary_color', $themeData['primary_color'] ?? '#0d6efd') }}"
                                                onchange="updateColorDisplay(this, 'primary')">
                                        </div>
                                        <div class="col">
                                            <input type="text" id="primary_color_text"
                                                class="form-control border-2 text-uppercase fw-bold"
                                                style="font-family: 'Courier New', monospace; height: 50px;"
                                                value="{{ old('primary_color', $themeData['primary_color'] ?? '#0d6efd') }}"
                                                pattern="^#[0-9A-Fa-f]{6}$" placeholder="#0d6efd"
                                                onchange="updateColorPicker(this, 'primary')">
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">{{ __('Used for main buttons, highlights and Sidebar active states') }}</small>
                                </div>

                                <!-- Secondary Color -->
                                <div class="mb-4 p-3 bg-light rounded-3">
                                    <label class="form-label fw-semibold d-flex align-items-center mb-3">
                                        <span class="color-dot me-2 rounded-circle"
                                            style="width: 12px; height: 12px; background: {{ old('secondary_color', $themeData['secondary_color'] ?? '#6c757d') }};"></span>
                                        {{ __('Secondary Color') }}
                                    </label>
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <input type="color" name="secondary_color" id="secondary_color"
                                                class="form-control form-control-color border-2"
                                                style="width: 80px; height: 50px; cursor: pointer;"
                                                value="{{ old('secondary_color', $themeData['secondary_color'] ?? '#6c757d') }}"
                                                onchange="updateColorDisplay(this, 'secondary')">
                                        </div>
                                        <div class="col">
                                            <input type="text" id="secondary_color_text"
                                                class="form-control border-2 text-uppercase fw-bold"
                                                style="font-family: 'Courier New', monospace; height: 50px;"
                                                value="{{ old('secondary_color', $themeData['secondary_color'] ?? '#6c757d') }}"
                                                pattern="^#[0-9A-Fa-f]{6}$" placeholder="#6C757D"
                                                onchange="updateColorPicker(this, 'secondary')">
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">{{ __('Used for secondary actions and subtle accents') }}</small>
                                </div>

                                <!-- Text Color -->
                                <div class="mb-4 p-3 bg-light rounded-3">
                                    <label class="form-label fw-semibold d-flex align-items-center mb-3">
                                        <span class="color-dot me-2 rounded-circle"
                                            style="width: 12px; height: 12px; background: {{ old('text_color', $themeData['text_color'] ?? '#000000') }};"></span>
                                        {{ __('Main Text Color') }}
                                    </label>
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <input type="color" name="text_color" id="text_color"
                                                class="form-control form-control-color border-2"
                                                style="width: 80px; height: 50px; cursor: pointer;"
                                                value="{{ old('text_color', $themeData['text_color'] ?? '#000000') }}"
                                                onchange="updateColorDisplay(this, 'text')">
                                        </div>
                                        <div class="col">
                                            <input type="text" id="text_color_text"
                                                class="form-control border-2 text-uppercase fw-bold"
                                                style="font-family: 'Courier New', monospace; height: 50px;"
                                                value="{{ old('text_color', $themeData['text_color'] ?? '#000000') }}"
                                                pattern="^#[0-9A-Fa-f]{6}$" placeholder="#000000"
                                                onchange="updateColorPicker(this, 'text')">
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">{{ __('Primary text color for all content') }}</small>
                                </div>

                                <!-- Font Family -->
                                <div class="mb-4 p-3 bg-light rounded-3">
                                    <label class="form-label fw-semibold d-flex align-items-center mb-3">
                                        <i class="fas fa-font me-2 text-primary"></i>
                                        {{ __('Font Family') }}
                                    </label>
                                    <select name="font_family" id="font_family" class="form-select border-2" style="height: 50px;" onchange="updateFontPreview(this.value)">
                                        <option value="'Poppins', sans-serif" {{ (old('font_family', $themeData['font_family'] ?? '') == "'Poppins', sans-serif") ? 'selected' : '' }}>Poppins (Default)</option>
                                        <option value="'Inter', sans-serif" {{ (old('font_family', $themeData['font_family'] ?? '') == "'Inter', sans-serif") ? 'selected' : '' }}>Inter</option>
                                        <option value="'Roboto', sans-serif" {{ (old('font_family', $themeData['font_family'] ?? '') == "'Roboto', sans-serif") ? 'selected' : '' }}>Roboto</option>
                                        <option value="'Outfit', sans-serif" {{ (old('font_family', $themeData['font_family'] ?? '') == "'Outfit', sans-serif") ? 'selected' : '' }}>Outfit</option>
                                        <option value="'Montserrat', sans-serif" {{ (old('font_family', $themeData['font_family'] ?? '') == "'Montserrat', sans-serif") ? 'selected' : '' }}>Montserrat</option>
                                    </select>
                                    <small class="text-muted d-block mt-2">{{ __('Select the primary font for the entire platform') }}</small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 mt-5">
                                    <x-update-button :title="'Save Appearance'" :icon="'fas fa-save'"></x-update-button>

                                    <button type="button" onclick="resetToDefault()"
                                        class="btn btn-lg btn-outline-secondary px-4">
                                        <i class="fas fa-undo me-2"></i>{{ __('Reset Defaults') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Right Side - Live Preview -->
                            <div class="col-lg-5 bg-light p-4 p-lg-5 border-start">
                                <h5 class="fw-bold mb-4 text-dark">{{ __('Live Preview') }}</h5>

                                <div class="p-4 bg-white rounded-4 shadow-sm border" id="preview_container" style="font-family: {{ old('font_family', $themeData['font_family'] ?? "'Poppins', sans-serif") }}">
                                    <div class="mb-4">
                                        <div class="text-center py-3 rounded-3 fw-bold text-white shadow-sm" id="preview_primary"
                                            style="background: {{ old('primary_color', $themeData['primary_color'] ?? '#0d6efd') }};">
                                            {{ __('Primary Element') }}
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="text-center py-3 rounded-3 fw-bold text-white shadow-sm" id="preview_secondary"
                                            style="background: {{ old('secondary_color', $themeData['secondary_color'] ?? '#6c757d') }};">
                                            {{ __('Secondary Element') }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="p-4 bg-light rounded-4 border">
                                            <h4 class="fw-bold mb-2" id="preview_text_heading"
                                                style="color: {{ old('text_color', $themeData['text_color'] ?? '#000000') }};">
                                                {{ __('PepExch Platform') }}
                                            </h4>
                                            <p class="mb-0 text-muted" id="preview_text_body"
                                                style="color: {{ old('text_color', $themeData['text_color'] ?? '#000000') }}; opacity: 0.8;">
                                                {{ __('Zameni, Promeni, Bilo Šta, Bilo Gde. Ovo je primer kako će izgledati vaš tekst sa odabranim fontom и bojom.') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 pt-4 border-top">
                                        <button class="btn w-100 rounded-pill py-2 fw-bold text-white shadow-sm" id="preview_btn" style="background: {{ old('primary_color', $themeData['primary_color'] ?? '#0d6efd') }};">
                                            {{ __('Primary Button') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="alert alert-success border-0 mt-4 rounded-4 shadow-sm">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-magic fa-2x opacity-50"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ __('Modern UI Sync') }}</h6>
                                            <small class="d-block">{{ __('Changes will be automatically synced with the SPA frontend components.') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control-color { padding: 4px; border-radius: 8px !important; }
        .color-dot { display: inline-block; transition: all 0.3s ease; }
        .card { border-radius: 1.5rem !important; }
        #preview_container { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .is-invalid { border-color: #dc3545 !important; }
    </style>

    <script>
        function updateColorDisplay(input, type) {
            const color = input.value;
            document.getElementById(type + '_color_text').value = color;
            const dot = input.closest('.bg-light').querySelector('.color-dot');
            if (dot) dot.style.background = color;
            updatePreview(type, color);
        }

        function updateColorPicker(input, type) {
            let color = input.value.trim();
            if (!/^#[0-9A-Fa-f]{6}$/.test(color)) {
                input.classList.add('is-invalid');
                return;
            }

            input.classList.remove('is-invalid');
            document.getElementById(type + '_color').value = color;
            const dot = input.closest('.bg-light').querySelector('.color-dot');
            if (dot) dot.style.background = color;
            updatePreview(type, color);
        }

        function updateFontPreview(font) {
            document.getElementById('preview_container').style.fontFamily = font;
        }

        function updatePreview(type, color) {
            switch (type) {
                case 'primary':
                    document.getElementById('preview_primary').style.background = color;
                    document.getElementById('preview_btn').style.background = color;
                    break;
                case 'secondary':
                    document.getElementById('preview_secondary').style.background = color;
                    break;
                case 'text':
                    document.getElementById('preview_text_heading').style.color = color;
                    document.getElementById('preview_text_body').style.color = color;
                    break;
            }
        }

        function resetToDefault() {
            Swal.fire({
                title: 'Reset to Defaults?',
                text: "All your custom appearance settings will be lost.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reset All'
            }).then((result) => {
                if (result.isConfirmed) {
                    const defaults = {
                        primary: '#10B981',
                        secondary: '#34D399',
                        text: '#1F2937'
                    };

                    Object.keys(defaults).forEach(type => {
                        const color = defaults[type];
                        document.getElementById(type + '_color').value = color;
                        document.getElementById(type + '_color_text').value = color;
                        updatePreview(type, color);
                        const dot = document.getElementById(type + '_color').closest('.bg-light').querySelector('.color-dot');
                        if (dot) dot.style.background = color;
                    });

                    document.getElementById('font_family').value = "'Poppins', sans-serif";
                    updateFontPreview("'Poppins', sans-serif");

                    Swal.fire('Restored!', 'Theme settings reset to PepExch defaults.', 'success');
                }
            });
        }
    </script>
@endsection
