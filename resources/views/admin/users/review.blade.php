@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="background: linear-gradient(145deg,#ffffff,#f0f0f0);">
            <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                <div class="me-4 position-relative">
                    <img src="{{ $user->profilePhotoPath ? $user->profilePhotoPath : asset('assets/frontend/img/abter/profile-img.png') }}"
                        alt="Profile Image" class="rounded-circle me-2" width="140" height="140">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white p-1"></span>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold">{{ $user->name }}</h2>
                    <p class="text-muted mb-0">{{ $user->getRoleNames()->first() ?? 'No Role' }}</p>
                    <small class="text-secondary">{{ __('User ID:') }} {{ $user->id }}</small>
                </div>
            </div>

            @can('users.updateReview')
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Email') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Phone') }}</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->phone_no }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Current Status') }}</label>
                            <select name="status" class="form-select">
                                @foreach (\App\Enums\UserStatus::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ $user->status === $status->value ? 'selected' : '' }}>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('Assign Role (optional)') }}</label>
                            <select name="role" class="form-select">
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach ($roles as $id => $name)
                                    <option value="{{ $name }}"
                                        {{ $user->roles->pluck('name')->contains($name) ? 'selected' : '' }}>
                                        {{ ucfirst($name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-user-check me-2"></i> {{ __('Update Review') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </form>
            @endcan
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
        }

        .form-select,
        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #4e73df, #224abe);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #224abe, #4e73df);
        }
    </style>
@endsection
