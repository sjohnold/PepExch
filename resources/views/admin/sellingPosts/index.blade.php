@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Products List'" :subtitle="'Manage and monitor all post'" :icon="'fas fa-shopping-cart'" :showSearch="true"
    :searchValue="request()->search" :showPerPage="true" :showDownload="true" :downloadRoute="route('products.export')" />

    {{-- Posts Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Selling Posts') }} <span>{{ __('(Latest)') }}</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width:1200px">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: auto;">
                            {{ __('#ID') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: auto;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: auto;">
                            {{ __('Condition') }}
                        </th>


                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: auto;">
                            {{ __('Status') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: auto;">
                            {{ __('Sold?') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width: auto;">
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($posts as $post)
                        <tr class="text-center">
                            <td class="align-middle">{{ $post->id }}</td>
                            <td class="align-middle text-truncate" style="max-width: 100px;" title="{{ $post->name }}">
                                <div class="text-truncate" style="max-width: 100px;">
                                    {{ $post->name }}
                                </div>
                            </td>

                            <td class="align-middle">{{ $post->conditions }}</td>


                            <td class="align-middle">

                                @php
                                    $className = '';
                                    $icon = '';

                                    if ($post->status === 'Approve') {
                                        $className = 'text-success';
                                        $icon = 'fas fa-check-circle';
                                    } elseif ($post->status === 'Pending') {
                                        $className = 'text-warning';
                                        $icon = 'fas fa-clock';
                                    } elseif ($post->status === 'Reject') {
                                        $className = 'text-danger';
                                        $icon = 'fas fa-times-circle';
                                    } elseif ($post->status === 'In-Review') {
                                        $className = 'text-info';
                                        $icon = 'fas fa-eye';
                                    } elseif ($post->status === 'Soled') {
                                        $className = 'text-secondary';
                                        $icon = 'fas fa-shopping-cart';
                                    }
                                @endphp

                                <x-table-status :className="$className" :status="$post->status" :icon="$icon" />
                            </td>





                            <td class="align-middle">
                                @if ($post->is_sold)
                                    <span class="badge bg-success"><i
                                            class="fas fa-check-circle"></i>{{ __('Yes') }}</span>
                                @else
                                    <span class="badge bg-danger"><i
                                            class="fas fa-times-circle"></i>{{ __('No') }}</span>
                                @endif
                            </td>


                            <td class="align-middle">
                                <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                                    @if ($post->trashed())
                                        <x-table-action :route="route('posts.restore', $post->id)" :text="'Restore'" :icon="'far fa-undo'"
                                            :bgColor="'#3A6F43'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                    @else
                                        {{-- Edit Button --}}
                                        @can('posts.edit')
                                            <x-table-action :route="route('posts.edit', $post->id)" :text="'Edit'" :icon="'fas fa-edit'"
                                                :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                        @endcan
                                        {{-- Delete Button --}}
                                        {{-- @can('posts.destroy') --}}
                                        <x-table-action :route="route('posts.destroy', $post->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                            :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                        {{-- @endcan --}}
                                    @endif

                                </div>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">{{ __('No posts found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $posts->links() }}
    </div>
@endsection
