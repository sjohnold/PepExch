@extends('layouts.app')
@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'All Attributes'" :subtitle="'Manage All Attributes'" :icon="'bi bi-folder'" :showSearch="true" :searchValue="request('search')"
        :buttonText="'Add New Attributes'" :buttonRoute="route('attributes.create')" />

    {{-- Attributes Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">Attributes <span>(Latest)</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            {{ __('Category') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:120px;">
                            {{ __('Parent') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attributes as $attr)
                        <tr class="text-center">
                            <td class="align-middle">{{ $attr->id }}</td>
                            <td class="align-middle text-truncate" title="{{ $attr->name }}">
                                {{ $attr->name }}
                            </td>
                            <td class="align-middle text-truncate">
                                {{ $attr->category->name ?? '-' }}
                            </td>
                            <td class="align-middle text-truncate">
                                {{ $attr->parent_id ?? '-' }}
                            </td>
                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- View --}}
                                    <a href="{{ route('attributes.show', $attr->id) }}" class="tp-btn-action"
                                        title="View">
                                        <i class="far fa-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('attributes.edit', $attr->id) }}" class="tp-btn-action"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('attributes.destroy', $attr->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tp-btn-action" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">{{ __('No attributes found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $attributes->links() }}
    </div>
@endsection
