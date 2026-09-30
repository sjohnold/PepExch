@extends('layouts.app')

@section('content')
    <x-table-header :title="'User Reports'" :buttonText="'Back'" :buttonRoute="route('users.index')" :buttonIcon="'bi bi-arrow-left'" />

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-start">
                <!-- User Profile Image -->
                <div class="me-4">
                    <img src="{{ $user->profilePhotoPath }}" alt="{{ $user->name }}" class="rounded-circle border"
                        style="width: 80px; height: 80px; object-fit: cover;">
                </div>

                <!-- User Info -->
                <div class="flex-grow-1">
                    <h3 class="mb-2 fw-semibold">{{ $user->name }}</h3>
                    <div class="d-flex align-items-center gap-3 text-muted">
                        <span>
                            <i class="bi bi-envelope me-1"></i>
                            {{ $user->email }}
                        </span>
                        <span>
                            <i class="bi bi-flag-fill me-1 text-danger"></i>
                            {{ count($reports) }} {{ count($reports) === 1 ? 'Report' : 'Reports' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports List -->
    <div class="row g-4">
        @forelse ($reports as $report)
            <div class="col-12">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <!-- Reporter Image -->
                            <div class="me-3">
                                <img src="{{ $report->reporter->profilePhotoPath ?? asset('images/default-avatar.png') }}"
                                    alt="{{ $report->reporter->name }}" class="rounded-circle border"
                                    style="width: 48px; height: 48px; object-fit: cover;">
                            </div>

                            <!-- Reporter Info & Timestamp -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $report->reporter->name }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $report->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                        {{ $report->report_type }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Report Details -->
                        <div class="ms-5 ps-4 border-start border-2">
                            <h6 class="text-muted mb-2 text-uppercase small fw-semibold">{{ __('Report Details') }}</h6>
                            <p class="mb-0 text-secondary lh-base">{{ $report->details }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5 text-center">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mb-0 mt-3">{{ __('No reports found for this user.') }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
