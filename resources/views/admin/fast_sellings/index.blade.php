@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Fast Selling Items'" :subtitle="'Manage Fast Selling Items'" :icon="'bi bi-folder'" />


    {{-- Fast Selling Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Fast Selling') }} <span>({{ __('Latest') }})</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:200px;">
                            {{ __('Title') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:200px;">
                            {{ __('Description') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Thumbnail') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Actions') }}
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse($fastSellings as $item)
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle text-truncate text-center" title="{{ $item->title }}">
                                {{ $item->title }}
                            </td>
                            <td class="align-middle text-center" style="white-space: normal;">
                                {{ $item->description }}
                            </td>

                            <td class="align-middle" style="height:60px;">
                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail->src) }}" alt="{{ $item->title }}"
                                        class="rounded"
                                        style="width:60px; height:60px; object-fit:cover; display:block; margin:auto;">
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" alt="{{ __('No Image') }}"
                                        class="rounded"
                                        style="width:60px; height:60px; object-fit:cover; display:block; margin:auto;">
                                    <span class="text-muted small d-block mt-1">{{ __('No Image') }}</span>
                                @endif
                            </td>

                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- Edit --}}
                                    <x-table-action :route="route('fast-selling.edit', $item->id)" :text="'Edit'" :icon="'fas fa-edit'" :bgColor="'#023066'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                {{ __('No fast selling items found') }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- Pagination --}}
        {{ $fastSellings->links() }}

    </div>
@endsection
