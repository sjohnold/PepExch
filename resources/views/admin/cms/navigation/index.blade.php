@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <x-table-header :title="'CMS Navigation'" :subtitle="'Edit main menu, SPA sidebar and footer navigation'" :icon="'fas fa-sitemap'" />

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">{{ __('Add menu item') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cms-navigation.store') }}">
                        @csrf
                        @include('admin.cms.navigation.partials.form', ['item' => null, 'parents' => $parents])
                        <button class="btn btn-success w-100 mt-3" type="submit">
                            <i class="fas fa-plus me-1"></i>{{ __('Create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">{{ __('Menu items') }}</h5>
                    <div class="d-flex align-items-center gap-2">
                        <form method="POST" action="{{ route('cms-navigation.install-defaults') }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary" type="submit">
                                <i class="fas fa-wand-magic-sparkles me-1"></i>{{ __('Install defaults') }}
                            </button>
                        </form>
                        <span class="badge bg-light text-dark">{{ $items->count() }} {{ __('items') }}</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Label') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Visibility') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $item->location }}</span></td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->label }}</div>
                                        <small class="text-muted">
                                            {{ $item->parent ? 'Parent: '.$item->parent->label.' · ' : '' }}
                                            {{ $item->route_name ?: $item->url ?: $item->type }}
                                        </small>
                                    </td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <span class="badge {{ $item->is_visible ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->is_visible ? __('Visible') : __('Hidden') }}
                                        </span>
                                        <span class="badge bg-light text-dark">{{ $item->visibility }}</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-nav-{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('cms-navigation.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse" id="edit-nav-{{ $item->id }}">
                                    <td colspan="5" class="bg-light">
                                        <form method="POST" action="{{ route('cms-navigation.update', $item) }}" class="p-3">
                                            @csrf
                                            @method('PUT')
                                            @include('admin.cms.navigation.partials.form', ['item' => $item, 'parents' => $parents])
                                            <button class="btn btn-primary mt-3" type="submit">
                                                <i class="fas fa-save me-1"></i>{{ __('Save changes') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        {{ __('No custom menu items yet. Defaults are being used on the frontend.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
