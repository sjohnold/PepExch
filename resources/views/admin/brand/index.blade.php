@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Brands'" :subtitle="'Manage All Brands'" :icon="'bi bi-folder'" :buttonText="'Create New Brand'" :buttonRoute="route('brand.create')" />

    {{-- Brands Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Brands ') }} <span>({{ __('Latest ') }})</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">

            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:200px;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Thumbnail') }}
                        </th>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Status') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($brands as $brand)
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle text-truncate" title="{{ $brand->name }}">
                                {{ $brand->name }}
                            </td>

                            <td class="align-middle" style="height:60px;">
                                @if ($brand->thumbnailPath)
                                    <img src="{{ $brand->thumbnailPath }}" alt="{{ $brand->name }}" class="rounded"
                                        style="width:60px; height:60px; object-fit:cover; display:block; margin:auto;">
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" alt="{{ __('No Image') }}"
                                        class="rounded"
                                        style="width:60px; height:60px; object-fit:cover; display:block; margin:auto;">
                                    <span class="text-muted small d-block mt-1">{{ __('No Image') }}</span>
                                @endif
                            </td>
                             <td class="align-middle text-truncate" title="{{ $brand->name }}">
                               {{ $brand->is_active ? 'Active' : 'Inactive' }}

                            </td>

                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">

                                    <x-table-action :route="route('brand.show', $brand->id)" :text="'View'" :icon="'far fa-eye'" :bgColor="'#60363b'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    {{-- Edit --}}

                                    <x-table-action :route="route('brand.edit', $brand->id)" :text="'Edit'" :icon="'fas fa-edit'"
                                        :bgColor="'#023066'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    {{-- Delete --}}
                                    <x-table-action :route="route('brand.destroy', $brand->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                        :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                {{ __('No brands found') }}{{ request('search') ? ' ' . __('for') . ' "' . request('search') . '"' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $brands->links() }}
    </div>
@endsection
