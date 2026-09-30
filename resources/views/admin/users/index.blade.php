@extends('layouts.app')

@section('content')
    {{-- Page Header --}}

    <x-table-header :title="'All Users'" :subtitle="'Manage and monitor all registered users'" :icon="'fas fa-users'" :showSearch="true" :searchValue="request()->search"
        :showPerPage="true" :showDownload="true" :downloadRoute="route('users.export')" />


    {{-- Users Table --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class=" table-hover align-middle mb-0" style="min-width: 1000px;">
                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem;">
                                {{ __('#ID') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem;">
                                {{ __('Name') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem;">
                                {{ __('Email/Phone') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Status') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Verified') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr style="border-bottom: 1px solid #f1f3f5;">
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark fw-semibold" style="font-size: 0.875rem;">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->profilePhotoPath ? $user->profilePhotoPath : asset('assets/frontend/img/abter/profile-img.png') }}"
                                            alt="Profile" class="rounded-circle shadow-sm me-3"
                                            style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #e9ecef;">
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size: 0.95rem;">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-muted" style="font-size: 0.875rem;">
                                        {{ $user->email ?? $user->phone_no }}
                                    </span>
                                </td>


                                <td class="px-4 py-3 text-center">
                                    @php
                                        if ($user->trashed()) {
                                            // Soft deleted → red + single option
                                            $textColor = 'color: #dc3545;';
                                            $borderColor = 'border: 2px solid #dc3545;';
                                        } else {
                                            // Active users → status color
                                            $textColor = match ($user->status) {
                                                'Approve' => 'color: #16a34a;',
                                                'Pending' => 'color: #d97706;',
                                                'Block' => 'color: #e24343;',
                                                default => 'color: #6b7280;',
                                            };
                                            $borderColor = match ($user->status) {
                                                'Approve' => 'border: 2px solid #86efac;',
                                                'Pending' => 'border: 2px solid #fde68a;',
                                                'Block' => 'border: 2px solid #e24343;',
                                                default => 'border: 2px solid #e5e7eb;',
                                            };
                                        }
                                    @endphp

                                    <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                            style="
                                                    padding: 8px 10px;
                                                    border-radius: 10px;
                                                    font-size: 15px;
                                                    font-weight: 600;
                                                    width: 130px;
                                                    cursor: {{ $user->trashed() ? 'not-allowed' : 'pointer' }};
                                                    background: {{ $user->trashed() ? '#f8f9fa' : 'white' }};
                                                    {{ $user->trashed() ? '' : $textColor }}
                                                    {{ $user->trashed() ? '' : $borderColor }}
                                                "
                                            onchange="this.form.submit()" @if ($user->trashed()) disabled @endif>
                                            @if ($user->trashed())
                                                <option selected>Deleted</option>
                                            @else
                                                @foreach (\App\Enums\UserStatus::cases() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ $user->status === $status->value ? 'selected' : '' }}>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </form>
                                </td>


                                <td class="px-4 py-3 text-center">
                                    @php
                                        $bgColor = 'bg-success';
                                        $textColor = 'text-success';

                                        if ($user->email_verified_at || $user->phone_verified_at) {
                                            $bgColor = 'bg-success';
                                            $textColor = 'text-success';
                                            $status = 'Verified';
                                        } else {
                                            $bgColor = 'bg-danger';
                                            $textColor = 'text-danger';
                                            $status = 'Not Verified';
                                        }
                                    @endphp

                                    <x-table-verify :bgColor="$bgColor" :textColor='$textColor' :status="$status">
                                    </x-table-verify>

                                </td>



                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-2 justify-content-center">

                                        {{-- Restore User --}}
                                        @if ($user->trashed())
                                            <x-table-action :route="route('users.restore', $user->id)" :text="'Restore User'" :icon="'fas fa-undo'"
                                                :bgColor="'#198754'" :hoverShadow="'0 4px 12px rgba(25, 135, 84, 0.4)'" />
                                        @else
                                            {{-- Review Button --}}
                                            <x-table-action :route="route('users.edit', $user->id)" :text="'Edit User'" :icon="'fas fa-user-check'"
                                                :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                            {{-- View Report Button --}}
                                            <x-table-action :route="route('users.show.reports', $user->id)" :text="'View Report'" :icon="'fas fa-flag'"
                                                :bgColor="'#45556C'" :hoverShadow="'0 4px 12px rgba(91, 33, 182, 0.4)'" />
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0 fw-semibold" style="font-size: 1.1rem;">
                                            {{ __('No users found') }}
                                        </p>
                                        <p class="small text-muted mb-0">{{ __('Try adjusting your search criteria') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $users->links() }}
    </div>

    </div>
@endsection
