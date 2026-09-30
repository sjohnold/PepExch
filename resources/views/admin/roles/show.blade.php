@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header
        :title="'Role Details'"
        :buttonText="'Back'"
        :buttonRoute="route('roles.index')"
        :buttonIcon="'bi bi-arrow-left'"
    />

    <div class="row mt-4 g-4 " style="height: calc(100vh - 100px);">
        {{-- Left Side: Role Info (Fixed) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 position-sticky" style="top: 20px;">
                <div class="card-header bg-white fw-bold fs-5">
                    {{ __('Role') }}: {{ $role->name }} (ID: {{ $role->id }})
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Created At') }}:</strong> {{ $role->created_at->format('d M, Y h:i A') }}</p>
                    <p><strong>{{ __('Updated At') }}:</strong> {{ $role->updated_at->format('d M, Y h:i A') }}</p>
                    <p><strong>{{ __('ID') }}:</strong> {{ $role->id }}</p>
                    <p><strong>{{ __('Name') }}:</strong> {{ $role->name }}</p>
                </div>
            </div>
        </div>

        {{-- Right Side: Permissions / Actions (Scrollable) --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold fs-5">
                    {{ __('Permissions / Actions') }}
                </div>
                <div class="card-body overflow-auto" style="max-height: calc(100vh - 160px);">
                    @if ($role->permissions->isNotEmpty())
                        {{-- Group permissions by resource --}}
                        @php
                            $grouped = [];
                            foreach ($role->permissions as $permission) {
                                $parts = explode('.', $permission->name);
                                $resource = $parts[0] ?? 'Other';
                                $grouped[$resource][] = $permission->name;
                            }
                        @endphp

                        @foreach ($grouped as $resource => $perms)
                            <div class="mb-3">
                                <h6 class="fw-semibold">{{ ucfirst($resource) }}</h6>
                                @foreach ($perms as $perm)
                                    <span class="badge me-1 py-1 px-2 fs-6  mb-3" style="background: linear-gradient(135deg, #46262a 0%, #16181c 100%);">{{ $perm }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">{{ __('No permissions assigned to this role.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="d-flex flex-wrap align-items-center gap-3 mt-4 mb-100">
        {{-- Edit Button --}}
        @if ($role->name !== 'Admin')
        <x-table-action
            :route="route('roles.edit', $role->id)"
            :text="'Edit Role'"
            :icon="'fas fa-user-check'"
            :bgColor="'#60363b'"
            :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'"
        />


        {{-- Delete Button --}}
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-lg"
                onclick="return confirm('{{ __('Are you sure you want to delete this role?') }}')">
                <i class="fas fa-trash me-2"></i> {{ __('Delete Role') }}
            </button>
        </form>
        @endif
    </div>
@endsection
