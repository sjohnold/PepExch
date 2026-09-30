@extends('layouts.app')

@section('content')
    <x-table-header :title="'Announcement Details'" :buttonText="'Back to List'" :buttonRoute="route('announcements.index')" :buttonIcon="'bi bi-arrow-left'" />

    <!-- Main Content Card -->


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
        <!-- Card Header with Title -->
        <div class="card-header bg-white border-0 py-5 px-5">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0 me-4">
                    <div class="icon-shape icon-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-megaphone fs-3"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h3 class="mb-2 fw-bold text-dark">{{ $announcement->title }}</h3>
                    <div class="d-flex flex-wrap gap-3 text-muted small">
                        <span><i class="bi bi-calendar-event me-1"></i>
                            {{ $announcement->created_at->format('M d, Y') }}</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                            {{ json_decode($announcement->message, true)['type'] ?? 'General' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body px-5 pb-5">
            <!-- Message Section -->
            <div class="mb-5">
                <h5 class="fw-semibold text-secondary mb-3 d-flex align-items-center">
                    <i class="bi bi-chat-left-text-fill text-info me-2"></i>
                    {{ __('Message') }}
                </h5>
                <div class="bg-light rounded-4 p-4 shadow-sm border" style="line-height: 1.8; min-height: 150px;">
                    <div class="text-body">
                        {!! nl2br(e(json_decode($announcement->message, true)['body'] ?? '')) !!}
                    </div>
                </div>
            </div>

            <!-- Recipients Section -->
            @php
                $userIds = json_decode($announcement->user_ids, true) ?? [];
                $users = \App\Repositories\UserRepository::query()->whereIn('id', $userIds)->get();
            @endphp

            <div class="mt-5">
                <h5 class="fw-semibold text-secondary mb-3 d-flex align-items-center justify-content-between">
                    <span>
                        <i class="bi bi-people-fill text-success me-2"></i>
                        {{ __(' Sent to Users') }}
                    </span>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                        {{ count($users) }} Recipient{{ count($users) !== 1 ? 's' : '' }}
                    </span>
                </h5>

                @if ($users->isNotEmpty())
                    <div class="table-responsive rounded-4 border bg-white shadow-sm overflow-hidden">
                        <table class=" table-hover mb-0 align-middle">
                            <thead class="bg-light border-bottom">
                                <tr class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">
                                    <th class="ps-4" style="width: 8%;">#</th>
                                    <th style="width: 50%;">{{ __('Name') }}</th>
                                    <th style="width: 42%;">{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr class="border-bottom">
                                        <td class="ps-4 fw-medium">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar avatar-sm rounded-circle bg-secondary-subtle text-white me-3 d-flex align-items-center justify-content-center">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 mb-3 opacity-50"></i>
                        <p>{{ __('No specific users selected - sent to all.') }}</p>
                    </div>
                @endif
            </div>
        </div>

    @endsection
