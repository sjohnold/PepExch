@extends('layouts.app')
@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Edit User Profile'" :subtitle="'Complete user information management'" :icon="'fas fa-user-edit'" :buttonText="'Back to Users'" :buttonRoute="route('users.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <div class="container-fluid px-0">
        <div class="row g-4">

            {{-- Left Column: Profile Photo & Quick Info --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-5">
                            <h6 class="fw-bold mb-3 text-muted small text-uppercase">{{ __('Profile Photo') }}</h6>
                            <div class="position-relative d-inline-block mb-4">
                                <img id="profilePreview"
                                    src="{{ $user->profilePhotoPath ?? asset('images/default-avatar.png') }}"
                                    alt="Profile Image" class="rounded-circle border border-3 border-white shadow"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <span
                                    class="position-absolute bottom-0 end-0 bg-{{ $user->status === 'Approve' ? 'success' : ($user->status === 'Pending' ? 'warning' : 'danger') }} rounded-circle border border-4 border-white"
                                    style="width: 24px; height: 24px;"></span>
                            </div>
                            <div class="mt-3">
                                <label for="profilePhotoInput" class="btn btn-sm rounded px-3 text-white"
                                    style="background: linear-gradient(135deg, #46262a 0%, #16181c 100%); border: none;">
                                    <i class="fas fa-camera me-1"></i>{{ __('Change Photo') }}
                                </label>

                                <input type="file" id="profilePhotoInput" name="thumbnail" class="d-none"
                                    accept="image/*" form="editUserForm">
                                <p class="text-muted small mb-0 mt-2">{{ __('JPG, PNG or GIF • Max 2MB') }}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div>
                            <h6 class="fw-bold mb-3 text-muted small text-uppercase">{{ __('Quick Information') }}</h6>
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Member Since') }}</small>
                                <span class="fw-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('Last Active') }}</small>
                                <span
                                    class="fw-medium">{{ $user->last_active ? \Carbon\Carbon::parse($user->last_active)->diffForHumans() : 'Never' }}</span>
                            </div>
                            <div class="mb-4">
                                <small class="text-muted d-block">{{ __('User ID') }}</small>
                                <span class="fw-medium text-primary">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>



                            {{-- Delete / Restore Button moved here --}}
                            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger w-100 deleteUserBtn">
                                <i class="fas fa-trash me-1"></i> Delete User
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Edit Form --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Basic Information Section --}}
                            <div class="mb-4 mt-5">
                                <h5 class="fw-bold mb-3 pb-2 border-bottom">{{ __('Basic Information') }}</h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Full Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-2"
                                            value="{{ old('name', $user->name) }}" required placeholder="Enter full name">
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Email Address') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-2"
                                            value="{{ old('email', $user->email) }}" required
                                            placeholder="email@example.com">
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Phone Number') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone_no" class="form-control rounded-2"
                                            value="{{ old('phone_no', $user->phone_no) }}" required
                                            placeholder="+1 (555) 000-0000">
                                        @error('phone_no')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('WhatsApp Number') }}</label>
                                        <input type="text" name="whatsapp_number" class="form-control rounded-2"
                                            value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                                            placeholder="+1 (555) 000-0000">
                                        @error('whatsapp_number')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">{{ __('Address') }}</label>
                                        <textarea name="address" class="form-control rounded-2" rows="3" placeholder="Enter full address">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Location Information Section --}}
                            <div class="mb-4 mt-5">
                                <h5 class="fw-bold mb-3 pb-2 border-bottom">{{ __('Location Coordinates') }}</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Latitude') }}</label>
                                        <input type="text" name="latitude" class="form-control rounded-2"
                                            value="{{ old('latitude', $user->latitude) }}" placeholder="e.g., 40.7128">
                                        @error('latitude')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Longitude') }}</label>
                                        <input type="text" name="longitude" class="form-control rounded-2"
                                            value="{{ old('longitude', $user->longitude) }}"
                                            placeholder="e.g., -74.0060">
                                        @error('longitude')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Account Settings Section --}}
                            <div class="mb-4 mt-5">
                                <h5 class="fw-bold mb-3 pb-2 border-bottom">{{ __('Account Settings') }}</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Account Status') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="status" class="form-select rounded-2" required>
                                            @foreach (\App\Enums\UserStatus::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ $user->status === $status->value ? 'selected' : '' }}>
                                                    {{ $status->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Assign Role</label>
                                        <select name="role" class="form-select rounded-2">
                                            <option value="">{{ __('Select Role') }}</option>
                                            @foreach ($roles as $id => $name)
                                                <option value="{{ $name }}"
                                                    {{ $user->roles->pluck('name')->contains($name) ? 'selected' : '' }}>
                                                    {{ ucfirst($name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email Verified At</label>
                                        <input type="datetime-local" name="email_verified_at"
                                            class="form-control rounded-2"
                                            value="{{ old('email_verified_at', $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d\TH:i') : '') }}">
                                        @error('email_verified_at')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">Leave empty if not verified</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Phone Verified At</label>
                                        <input type="datetime-local" name="phone_verified_at"
                                            class="form-control rounded-2"
                                            value="{{ old('phone_verified_at', $user->phone_verified_at ? \Carbon\Carbon::parse($user->phone_verified_at)->format('Y-m-d\TH:i') : '') }}">
                                        @error('phone_verified_at')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">Leave empty if not verified</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Password Section --}}
                            <div class="mb-4 mt-5">
                                <h5 class="fw-bold mb-3 pb-2 border-bottom">Password Management</h5>
                                <p class="text-muted small mb-3">Leave empty to keep current password</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">New Password</label>
                                        <input type="password" name="password" class="form-control rounded-2"
                                            placeholder="Enter new password">
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">Minimum 8 characters</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Confirm Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control rounded-2" placeholder="Confirm new password">
                                        @error('password_confirmation')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons (Only Update & Cancel) --}}
                            <div class="d-flex flex-wrap gap-3 pt-3 border-top">
                                <x-update-button :title="'Update User Profile'" :icon="'fas fa-user-check'"></x-update-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Image Preview JavaScript --}}
    <script>
        document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        const btn = document.querySelector('.deleteUserBtn');
        btn.addEventListener('click', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = btn.href;
                }
            });
        });
    </script>


    {{-- Soft focus style --}}
    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }
    </style>
@endsection
