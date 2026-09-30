@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">{{ __('Add Role') }}</h2>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        {{-- Role Name --}}
        <div class="mb-4">
            <label for="roleName" class="form-label fw-semibold">{{ __('Role Name') }}</label>
            <input type="text" name="name" id="roleName" class="form-control form-control-lg" 
                   placeholder="{{ __('Enter role name') }}" required>
        </div>

        {{-- Permissions --}}
        <div class="mb-5">
            <h4 class="mb-3 fw-semibold">{{ __('Permissions') }}:</h4>
            <div class="row g-3">
                @foreach($permissions as $permission)
                    <div class="col-md-4 col-sm-6">
                        <label class="card text-center p-2 border-primary bg-info bg-opacity-10 d-flex align-items-center justify-content-center cursor-pointer">
                            <input class="form-check-input me-2" type="checkbox" name="permissions[]"
                                   value="{{ $permission->name }}" id="permission-{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success btn-lg">{{ __('Save Role') }}</button>
        </div>
    </form>
</div>
@endsection
