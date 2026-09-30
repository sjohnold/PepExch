@extends('layouts.app')

@section('content')
    {{-- App Logo --}}
    @php
        $logo = $generalSettings->where('type', 'App Logo')->first();
        $logoData = $logo ? $logo->data ?? [] : [];
        $logoUrl = $logoData['logo_url'] ?? null;
    @endphp

    {{-- Fav Icon --}}
    @php
        $fabicon = $generalSettings->where('type', 'Fab Icon')->first();
        $fabiconData = $fabicon ? $fabicon->data ?? [] : [];
        $fabiconUrl = $fabiconData['fav_url'] ?? null;
    @endphp

    {{-- Footer Logo --}}
    @php
        $footerLogo = $generalSettings->where('type', 'Footer Logo')->first();
        $footerLogoData = $footerLogo ? $footerLogo->data ?? [] : [];
        $footerLogoUrl = $footerLogoData['footer_url'] ?? null;
    @endphp


    {{-- Additional Settings --}}
    @php
        $appName = $generalSettings->where('type', 'App Name')->first()->data['value'] ?? '';
        $themeColor = $generalSettings->where('type', 'Theme Color')->first()->data['value'] ?? '#000000';
    @endphp


    {{-- Downloadable Link --}}
    @php
        $downloadLinks = $generalSettings->where('type', 'Download Links')->first();
        $downloadLinksData = $downloadLinks && is_array($downloadLinks->data) ? $downloadLinks->data : [];
        $thumbnailUrl = $downloadLinksData['thumbnail1'] ?? null;
        $thumbnailUrl2 = $downloadLinksData['thumbnail2'] ?? null;
    @endphp



    {{-- Social Links --}}
    @php
        $socialLinksData = $generalSettings->where('type', 'Social Links')->first()->data ?? [];
        $facebookUrl = $socialLinksData['facebook']['url'] ?? '';
        $linkedinUrl = $socialLinksData['linkedin']['url'] ?? '';
        $instagramUrl = $socialLinksData['instagram']['url'] ?? '';
        $youtubeUrl = $socialLinksData['youtube']['url'] ?? '';
    @endphp



    {{-- Mail Configuration --}}
    @php
        $mailSetting = $generalSettings->where('type', 'Mail Config')->first();
        $mailData = $mailSetting ? $mailSetting->data : [];
    @endphp


    {{-- SMS Configuration --}}
    @php
        $smsSetting = $generalSettings->where('type', 'SMS Config')->first();
        $smsData = $smsSetting && is_array($smsSetting->data) ? $smsSetting->data : [];
    @endphp

    <x-table-header :title="'General Settings'" :subtitle="'Manage all General Settings'" :icon="'bi bi-gear-fill'" />

    <div class="row g-4 rounded-3 mb-4">
        {{-- App Logo --}}
        <div class="col-md-3">
            <form action="{{ route('general-settings.update.logo') }}" method="POST" enctype="multipart/form-data"
                class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                @csrf
                @method('PUT')

                <div class="card-body p-4 d-flex flex-column">
                    {{-- Header with Icon --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                            <i class="fas fa-image text-primary" style="font-size: 1.1rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-0">{{ __('App Logo') }}</h6>
                    </div>

                    {{-- Logo Preview Section --}}
                    <div class="d-flex flex-column mb-3 flex-grow-1">
                        {{-- Image Container --}}
                        <div class="border border-secondary border-opacity-25 rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center mb-3"
                            style="width: 100%; height: 150px; background: transparent;">
                            <img id="logo-preview" src="{{ $logoUrl ? $logoUrl : 'https://placehold.jp/250x250.png' }}"
                                alt="App Logo" class="img-fluid"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>

                        {{-- Upload Info --}}
                        <div class="text-start">
                            <label for="logo_input" class="form-label fw-medium text-dark mb-1 d-block"
                                style="font-size: 0.9rem;">
                                {{ $logoUrl ? 'Change Logo' : 'Upload Logo' }}
                            </label>
                            <p class="small text-muted mb-0">PNG, JPG, SVG</p>
                        </div>
                    </div>

                    @error('logo')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- File Input --}}
                    <div class="mb-3">
                        <input type="file" class="form-control form-control-sm border rounded-3" id="logo_input"
                            name="logo" accept="image/png,image/jpeg,image/svg+xml" style="padding: 15px">
                    </div>

                    {{-- Update Button --}}
                    <div class="text-start mt-auto">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>

        {{-- Fav Icon --}}
        <div class="col-md-3">
            <form action="{{ route('general-settings.update.fabicon') }}" method="POST" enctype="multipart/form-data"
                class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                @csrf
                @method('PUT')

                <div class="card-body p-4 d-flex flex-column">
                    {{-- Header with Icon --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                            <i class="fas fa-star text-success" style="font-size: 1.1rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-0">{{ __('Fav Icon') }}</h6>
                    </div>

                    {{-- Favicon Preview Section --}}
                    <div class="d-flex flex-column mb-3 flex-grow-1">
                        {{-- Image Container --}}
                        <div class="border border-secondary border-opacity-25 rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center mb-3"
                            style="width: 100%; height: 150px; background: transparent;">
                            <img id="fabicon-preview"
                                src="{{ $fabiconUrl ? $fabiconUrl : 'https://placehold.jp/250x250.png' }}" alt="Fav Icon"
                                class="img-fluid" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>

                        {{-- Upload Info --}}
                        <div class="text-start">
                            <label for="fabicon_input" class="form-label fw-medium text-dark mb-1 d-block"
                                style="font-size: 0.9rem;">
                                {{ $fabiconUrl ? 'Change Fav Icon' : 'Upload Fav Icon' }}
                            </label>
                            <p class="small text-muted mb-0">PNG, JPG, SVG</p>
                        </div>
                    </div>

                    @error('fabicon')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- File Input --}}
                    <div class="mb-3">
                        <input type="file" class="form-control form-control-sm border rounded-3" id="fabicon_input"
                            name="fabicon" accept="image/png,image/jpeg,image/svg+xml" style="padding: 15px">
                    </div>

                    {{-- Update Button --}}
                    <div class="text-start mt-auto">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>

        {{-- Additional Settings --}}
        <div class="col-md-6">
            <form method="POST" action="{{ route('general-settings.update.additional') }}"
                class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                @csrf
                @method('PUT')

                <div class="card-body p-4 d-flex flex-column">
                    {{-- Header --}}
                    <h6 class="mb-3 fw-bold">{{ __('Additional Settings') }}</h6>

                    <div class="flex-grow-1">
                        <div class="row g-3">
                            {{-- App Name --}}
                            <div class="col-md-6">
                                <label for="app_name" class="form-label fw-medium small">{{ __('App Name') }}</label>
                                <input type="text" class="form-control form-control-sm" id="app_name" name="app_name"
                                    value="{{ $appName }}" placeholder="Enter App Name">
                                @error('app_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Time Zone --}}
                            <div class="col-md-6">
                                <label for="timezoneInput" class="form-label fw-medium small">{{ __('Timezone') }}</label>
                                <select id="instructorInput" class="form-select form-select-sm" name="timezone">
                                    @foreach ($timezones as $timezone)
                                        <option value="{{ $timezone['zone'] }}"
                                            {{ $timezone['zone'] === config('app.timezone') ? 'selected' : '' }}>
                                            {{ $timezone['diff_from_GMT'] }} - {{ $timezone['zone'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Update Button --}}
                    <div class="text-end mt-auto pt-3">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" />
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Downloadable Link --}}
    <form action="{{ route('general-settings.update.downloadlink') }}" method="POST"
        class="p-4 card shadow-sm rounded-3 mb-4 border-0" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h5 class="mb-4 fw-semibold">{{ __('Downloadable Link Section') }}</h5>

        <div class="row g-4 align-items-center">

            {{-- Thumbnail 1 --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                    <div class="card-body p-4">
                        {{-- Header with Icon --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                <i class="fas fa-image text-warning" style="font-size: 1rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-0 small">{{ __('Thumbnail 1') }}</h6>
                        </div>

                        {{-- Thumbnail Preview Section --}}
                        <div class="d-flex flex-column align-items-center mb-3">
                            <div class="mb-3">
                                {{-- Image Container --}}
                                <div class="border border-secondary border-opacity-25 rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 120px; height: 120px; background: transparent;">
                                    <img id="thumbnail1-preview"
                                        src="{{ $thumbnailUrl ?? 'https://placehold.jp/250x250.png' }}" alt="Thumbnail 1"
                                        class="img-fluid"
                                        style="display:{{ $thumbnailUrl ? 'block' : 'none' }}; max-width: 100%; max-height: 100%; object-fit: contain;">
                                    <span id="thumbnail1-placeholder" class="text-muted small"
                                        style="display:{{ $thumbnailUrl ? 'none' : 'block' }};">
                                        {{ __('No Thumbnail') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Upload Info --}}
                            <div class="text-center">
                                <label for="thumbnail1_input" class="form-label fw-medium text-dark mb-2 d-block"
                                    style="font-size: 0.9rem;">
                                    {{ __('Upload Thumbnail') }}
                                </label>
                                <p class="small text-muted mb-0">PNG, JPG, SVG</p>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <div class="mb-2">
                            <input type="file" class="form-control border rounded-3" id="thumbnail1_input"
                                name="thumbnail1" style="padding:15px; font-size: 0.85rem;"
                                accept="image/png,image/jpeg,image/svg+xml">
                        </div>

                        {{-- Error Message --}}
                        @error('thumbnail1')
                            <span class="text-danger small d-block mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Thumbnail 2 --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                    <div class="card-body p-4">
                        {{-- Header with Icon --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-2">
                                <i class="fas fa-image text-danger" style="font-size: 1rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-0 small">{{ __('Thumbnail 2') }}</h6>
                        </div>

                        {{-- Thumbnail Preview Section --}}
                        <div class="d-flex flex-column align-items-center mb-3">
                            <div class="mb-3">
                                {{-- Image Container --}}
                                <div class="border border-secondary border-opacity-25 rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 120px; height: 120px; background: transparent;">
                                    <img id="thumbnail2-preview"
                                        src="{{ $thumbnailUrl2 ?? 'https://placehold.jp/250x250.png' }}"
                                        alt="Thumbnail 2" class="img-fluid"
                                        style="display:{{ $thumbnailUrl2 ? 'block' : 'none' }}; max-width: 100%; max-height: 100%; object-fit: contain;">
                                    <span id="thumbnail2-placeholder" class="text-muted small"
                                        style="display:{{ $thumbnailUrl2 ? 'none' : 'block' }};">
                                        {{ __('No Thumbnail') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Upload Info --}}
                            <div class="text-center">
                                <label for="thumbnail2_input" class="form-label fw-medium text-dark mb-2 d-block"
                                    style="font-size: 0.9rem;">
                                    {{ __('Upload Thumbnail') }}
                                </label>
                                <p class="small text-muted mb-0">PNG, JPG, SVG</p>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <div class="mb-2">
                            <input type="file" class="form-control border rounded-3" id="thumbnail2_input"
                                name="thumbnail2" style="padding: 15px; font-size: 0.85rem;"
                                accept="image/png,image/jpeg,image/svg+xml">
                        </div>

                        {{-- Error Message --}}
                        @error('thumbnail2')
                            <span class="text-danger small d-block mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Inputs --}}
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Title') }}</label>
                        <input type="text" class="form-control form-control-sm" name="title"
                            placeholder="{{ __('Enter Your Title') }}"
                            value="{{ old('title', $downloadLinksData['title'] ?? '') }}">
                        @error('title')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('Sub Title') }}</label>
                        <input type="text" class="form-control form-control-sm" name="subtitle"
                            placeholder="{{ __('Enter Your Sub Title') }}"
                            value="{{ old('subtitle', $downloadLinksData['subtitle'] ?? '') }}">
                        @error('subtitle')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">{{ __('Description') }}</label>
                        <input type="text" class="form-control form-control-sm" name="description"
                            placeholder="{{ __('Enter Your Description') }}"
                            value="{{ old('description', $downloadLinksData['description'] ?? '') }}">
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('App Store URL') }}</label>
                        <input type="text" class="form-control form-control-sm" name="app_store_url"
                            placeholder="{{ __('Enter App Store URL') }}"
                            value="{{ old('app_store_url', $downloadLinksData['app_store_url'] ?? '') }}">
                        @error('app_store_url')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('Google Play URL') }}</label>
                        <input type="text" class="form-control form-control-sm" name="play_store_url"
                            placeholder="{{ __('Enter Google Play URL') }}"
                            value="{{ old('play_store_url', $downloadLinksData['play_store_url'] ?? '') }}">
                        @error('play_store_url')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 text-end">
            <x-update-button :title="'Update'" :icon="'fas fa-save'" />
        </div>
    </form>

    {{-- Mail Configuration --}}
    <form action="{{ route('general-settings.update.mail') }}" method="POST"
        class="p-4 card shadow-sm rounded-3 mb-4 border-0" style="background-color:white;">
        @csrf
        @method('PUT')

        <h5 class="mb-3 fw-semibold">{{ __('Mail Configuration') }}</h5>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail Mailer') }}</label>
                <input type="text" class="form-control form-control-sm" name="mailer"
                    value="{{ $mailData['mailer'] ?? '' }}" placeholder="{{ __('smtp') }}" style="padding:0.5rem;">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail Host') }}</label>
                <input type="text" class="form-control form-control-sm" name="host"
                    value="{{ $mailData['host'] ?? '' }}" placeholder="{{ __('mail.example.com') }}"
                    style="padding:0.5rem;">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail Port') }}</label>
                <input type="text" class="form-control form-control-sm" name="port"
                    value="{{ $mailData['port'] ?? '' }}" placeholder="{{ __('587') }}" style="padding:0.5rem;">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail Username') }}</label>
                <input type="text" class="form-control form-control-sm" name="username"
                    value="{{ $mailData['username'] ?? '' }}" placeholder="{{ __('your@email.com') }}"
                    style="padding:0.5rem;">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail Password') }}</label>
                <input type="text" class="form-control form-control-sm" name="password"
                    value="{{ $mailData['password'] ?? '' }}" placeholder="{{ __('********') }}"
                    style="padding:0.5rem;">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium small">{{ __('Mail From Address') }}</label>
                <input type="text" class="form-control form-control-sm" name="from_address"
                    value="{{ $mailData['from_address'] ?? '' }}" placeholder="{{ __('noreply@example.com') }}"
                    style="padding:0.5rem;">
            </div>
        </div>

        <div class="mt-3 text-end">
            <x-update-button :title="'Update'" :icon="'fas fa-save'" />
        </div>
    </form>

    {{-- SMS Configuration --}}
    <form action="{{ route('general-settings.update.sms') }}" method="POST"
        class="p-4 card shadow-sm rounded-3 mb-4 border-0">
        @csrf
        @method('PUT')
        <h5 class="mb-3 fw-semibold">{{ __('SMS Configuration') }}</h5>
        <div class="row g-3">
            <div class="col-lg-12">
                <label>{{ __('URL') }}</label>
                <input type="text" name="url" class="form-control form-control-sm"
                    value="{{ old('url', $smsData['url'] ?? '') }}" placeholder="{{ __('https://api.example.com') }}">
            </div>

            <div class="col-md-6">
                <label>{{ __('User Name') }}</label>
                <input type="text" name="user_name" class="form-control form-control-sm"
                    value="{{ old('user_name', $smsData['user_name'] ?? '') }}" placeholder="{{ __('Your Username') }}">
            </div>

            <div class="col-md-6">
                <label>{{ __('Password') }}</label>
                <input type="text" name="password" class="form-control form-control-sm"
                    value="{{ old('password', $smsData['password'] ?? '') }}" placeholder="{{ __('********') }}">
            </div>

            <div class="col-md-6">
                <label>{{ __('Originator') }}</label>
                <input type="text" name="originator" class="form-control form-control-sm"
                    value="{{ old('originator', $smsData['originator'] ?? '') }}" placeholder="{{ __('CompanyName') }}">
            </div>

            <div class="col-md-6">
                <label>{{ __('Route') }}</label>
                <input type="text" name="route" class="form-control form-control-sm"
                    value="{{ old('route', $smsData['route'] ?? '') }}" placeholder="{{ __('Default') }}">
            </div>
        </div>

        <div class="mt-3 text-end">
            <x-update-button :title="'Update'" :icon="'fas fa-save'" />
        </div>


    </form>

    {{-- Reusable Image Preview Script --}}
    <script>
        function setupImagePreview(inputId, previewId, placeholderId) {
            var input = document.getElementById(inputId);
            var preview = document.getElementById(previewId);
            var placeholder = document.getElementById(placeholderId);

            if (input) {
                input.addEventListener('change', function() {
                    var file = this.files[0];
                    if (!file) return;

                    // File type & size validation
                    if (['image/png', 'image/jpeg', 'image/svg+xml'].indexOf(file.type) === -1 || file.size > 2 *
                        1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File',
                            text: 'Use PNG, JPEG, SVG under 2MB.',
                            confirmButtonText: 'OK'
                        });

                        this.value = '';
                        preview.style.display = 'none';
                        placeholder.style.display = 'block';
                        return;
                    }


                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        placeholder.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Initialize all image previews
        setupImagePreview('logo_input', 'logo-preview', 'logo-placeholder');
        setupImagePreview('fabicon_input', 'fabicon-preview', 'fabicon-placeholder');
        setupImagePreview('footerlogo_input', 'footerlogo-preview', 'footerlogo-placeholder');
        setupImagePreview('thumbnail1_input', 'thumbnail1-preview', 'thumbnail1-placeholder');
        setupImagePreview('thumbnail2_input', 'thumbnail2-preview', 'thumbnail2-placeholder');
    </script>
@endsection
