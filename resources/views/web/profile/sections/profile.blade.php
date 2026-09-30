@extends('web.profile.profile-master')
@section('profile-content')
    <div class="rs-profile-head d-flex align-items-center justify-content-between mb-16">
        <div class="profile-side-bar d-xl-none">
            <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
        </div>
        <h2 class="rs-profile-title">
            {{ __('My Profile') }}
        </h2>
        @if ($myProfileData->email_verified_at || $myProfileData->phone_verified_at)
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">{{ __('Verified') }}</span>
        @else
            <button
                class="verifiedBtn rs-btn">
                {{ __('Get Verified') }}
            </button>
        @endif
    </div>
    <div class="rs-profile-body p-24 mb-16 p-relative">
        <div class="rs-profile-info-form">
            <form action="{{ route('user.profile-update', $myProfileData->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="rs-profile-img text-center mb-32">
                    <label class="rs-profile-img-add p-relative" style="cursor:pointer; display: inline-block;">
                        <img class="br-100 shadow-lg border-4 border-white" src="{{ $myProfileData->profilePhotoPath ?? asset('media/demo-img.png') }}"
                            alt="Profile Image" id="profile_preview" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="absolute bottom-0 right-0 bg-green-600 text-white w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                            <i class="fas fa-camera text-xs"></i>
                        </div>
                        <input type="file" name="profile_photo" accept="image/*" class="d-none" id="profile_input">
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-20">
                        <h4 class="rs-profile-input-title">{{ __('Name') }}</h4>
                        <input type="name" name="name" value="{{ $myProfileData->name }}"
                            placeholder="Vaše ime">
                    </div>
                    <div class="col-md-6 mb-20">
                        <h4 class="rs-profile-input-title">{{ __('Phone Number') }}</h4>
                        <input type="text" name="phone_no" value="{{ $myProfileData->phone_no }}"
                            placeholder="+381...">
                    </div>
                    <div class="col-md-6 mb-20">
                        <h4 class="rs-profile-input-title">{{ __('Email Address') }}</h4>
                        <input type="email" name="email" value="{{ $myProfileData->email }}"
                            placeholder="example@gmail.com" readonly style="opacity: 0.7; cursor: not-allowed;">
                    </div>
                    <div class="col-md-6 mb-20">
                        <h4 class="rs-profile-input-title">{{ __('WhatsApp No') }} <span>(Optional)</span></h4>
                        <input type="text" name="whatsapp_number" value="{{ $myProfileData->whatsapp_number }}"
                            placeholder="+381...">
                    </div>

                    <div class="col-md-12 mb-20">
                        <h4 class="rs-profile-input-title">{{ __('Address') }}</h4>
                        <input type="text" id="address" name="address" value="{{ $myProfileData->address }}"
                            placeholder="Vaša adresa" class="form-control mb-2">
                        <input type="hidden" id="latitude" name="latitude" value="{{ $myProfileData->latitude }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ $myProfileData->longitude }}">

                        <div class="w-100 rounded-3xl mt-3 overflow-hidden shadow-sm border border-gray-100">
                            <img id="map"
                                src="https://maps.locationiq.com/v3/staticmap?key=pk.77d8acf7e277575f160ceecdd8b83ac3&center={{ $myProfileData->latitude ?? 23.8103 }},{{ $myProfileData->longitude ?? 90.4125 }}&zoom=15&size=1200x450&format=png"
                                alt="Map Preview" class="img-fluid w-100"
                                style="height: 300px; object-fit: cover; border:0;">
                        </div>
                    </div>

                </div>

                <div class="mt-32 text-end">
                    <button type="submit" class="rs-btn px-40">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('profile_input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile_preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }

        })
    </script>

    <script>
        const addressInput = document.getElementById('address');
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const mapIframe = document.getElementById('map');

        const locationIQKey = 'pk.77d8acf7e277575f160ceecdd8b83ac3';

        let timeout = null;
        addressInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;

            if (query.length < 3) return;

            timeout = setTimeout(() => {
                fetch(
                        `https://us1.locationiq.com/v1/autocomplete.php?key=${locationIQKey}&q=${encodeURIComponent(query)}&format=json`
                    )
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const place = data[0];

                            // Latitude & Longitude set
                            latInput.value = place.lat;
                            lngInput.value = place.lon;

                            // Map update
                            mapIframe.src =
                                `https://maps.locationiq.com/v3/staticmap?key=${locationIQKey}&center=${place.lat},${place.lon}&zoom=15&size=600x400&format=png`;
                        }
                    })
                    .catch(err => console.error(err));
            }, 500);
        });
    </script>
@endpush
