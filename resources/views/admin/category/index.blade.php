@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Categories'" :subtitle="'Manage all categories'" :icon="'bi bi-folder'" :showSearch="true" :searchValue="request('search')"
        :buttonText="'Add New Category'" :buttonRoute="route('category.create')" :buttonPermission="'category.create'" />

    {{-- Categories Table --}}
    <div class="card border-0 shadow-sm rounded-3 mt-3 mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class=" table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">#</th>
                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem;">{{ __('Name') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem;">
                                {{ __('Parent Category') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Thumbnail') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Featured') }}</th>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem;">
                                {{ __('Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categoryPaginations as $category)
                            <tr style="border-bottom: 1px solid #f1f3f5;">
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-light text-dark fw-semibold"
                                        style="font-size: 0.875rem;">{{ $loop->iteration }}</span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="fw-semibold text-dark" style="font-size: 0.95rem;">
                                        {{ $category->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-truncate"
                                    title="{{ $category->parent_id ? $category->parent->name : '-' }}">
                                    {{ $category->parent_id ? $category->parent->name : '-' }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if ($category->thumbnail_id && $category->thumbnail)
                                        <img src="{{ asset('storage/' . $category->thumbnail->src) }}" alt="Thumbnail"
                                            class="rounded"
                                            style="width:50px; height:50px; object-fit: cover; border: 2px solid #e9ecef;">
                                    @else
                                        <span class="badge bg-secondary">{{ __('No Image') }}</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @php
                                        $isFeatured = $category->is_featured;
                                        $bgColor = $isFeatured ? 'bg-success' : 'bg-danger';
                                        $textColor = $isFeatured ? 'text-white' : 'text-white';
                                        $statusText = $isFeatured ? 'Yes' : 'No';
                                    @endphp
                                    <span class="badge {{ $bgColor }} {{ $textColor }}"
                                        style="padding: 0.5em 0.75em; font-size:0.875rem; border-radius: 0.5rem;">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        @can('category.show')
                                            <x-table-action :route="route('category.show', $category)" :text="'View'" :icon="'far fa-eye'"
                                                :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                        @endcan
                                        @can('category.edit')
                                            <x-table-action :route="route('category.edit', $category)" :text="'Edit'" :icon="'fas fa-edit'"
                                                :bgColor="'#023066'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                        @endcan
                                        @can('category.destroy')
                                            <x-table-action :route="route('category.destroy', $category->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                                :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    {{ __('No categories found.') }}
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
        {{ $categoryPaginations->links() }}
    </div>
@endsection
