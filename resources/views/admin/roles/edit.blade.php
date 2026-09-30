@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header
        :title="'Update Role'"
        :subtitle="'Complete Role Information Management'"
        :icon="'fas fa-user-edit'"
        :buttonText="'Back'"
        :buttonRoute="route('roles.index')"
        :buttonIcon="'bi bi-arrow-left'"
    />

    <div class="row mt-4 g-4">
        {{-- Left Side: Role Info --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 position-sticky" style="top: 20px;">
                <div class="card-header fw-bold fs-5 bg-white">
                    {{ __('Role Info') }}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('ID') }}:</strong> {{ $role->id }}</p>
                    <p><strong>{{ __('Name') }}:</strong> {{ $role->name }}</p>
                    <p><strong>{{ __('Created At') }}:</strong> {{ $role->created_at->format('d M, Y h:i A') }}</p>
                    <p><strong>{{ __('Updated At') }}:</strong> {{ $role->updated_at->format('d M, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Right Side: Update Role Form --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Role Name --}}
                        <div class="mb-4">
                            <label for="roleName" class="form-label fw-bold">{{ __('Role Name') }}</label>
                            <input
                                type="text"
                                name="name"
                                id="roleName"
                                class="form-control form-control-lg"
                                value="{{ $role->name }}"
                                placeholder="Enter role name"
                                required
                            >
                        </div>

                        {{-- Permissions Grouped by Resource --}}
                        <div class="mb-5">
                            <h4 class="mb-3 fw-semibold">{{ __('Permissions') }}</h4>
                            <div class="overflow-auto" style="max-height: 60vh;">
                                @php
                                    // Group permissions by resource
                                    $groupedPermissions = [];
                                    foreach ($permissions as $permission) {
                                        $parts = explode('.', $permission->name);
                                        $resource = $parts[0] ?? 'Other';
                                        $action = $parts[1] ?? $permission->name;
                                        $groupedPermissions[$resource][] = [
                                            'name' => $permission->name,
                                            'action' => $action
                                        ];
                                    }
                                @endphp

                                @foreach ($groupedPermissions as $resource => $perms)
                                    <div class="card mb-3 shadow-sm">
                                        <div class="card-header bg-light fw-semibold">
                                            {{ ucfirst($resource) }}
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-2">
                                                @foreach ($perms as $perm)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <label class="card p-2 border rounded text-center cursor-pointer d-flex flex-column align-items-center justify-content-center
            @if($role->hasPermissionTo($perm['name'])) border-success bg-success bg-opacity-10 @else bg-light @endif
            hover-shadow">

            {{-- Checkbox on top --}}
            <input
                class="form-check-input mb-2"
                type="checkbox"
                name="permissions[]"
                value="{{ $perm['name'] }}"
                {{ $role->hasPermissionTo($perm['name']) ? 'checked' : '' }}
            >

            {{-- Permission Name below --}}
            <span class="fs-6 fw-medium text-truncate">{{ $perm['action'] }}</span>
        </label>
    </div>
@endforeach

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-check me-2"></i> {{ __('Update Role') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Hover Shadow --}}
    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }
    </style>
@endsection
