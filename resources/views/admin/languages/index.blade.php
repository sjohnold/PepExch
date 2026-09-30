@extends('layouts.app')

@section('content')
    <x-table-header :title="'Languages'" :subtitle="'Manage all Languages'" :icon="'bi bi-folder'" :buttonText="'Add New Languages'" :buttonRoute="route('languages.create')" />

    {{-- Table --}}
    <table class="ride-table table-striped">
        <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
            <tr>

                <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:60px;">
                    {{ __('ID') }}
                </th>

                <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:200px;">
                    {{ __('Title') }}
                </th>

                <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:180px;">
                    {{ __('Name') }}
                </th>

                <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:130px;">
                    {{ __('Status') }}
                </th>

                <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:160px;">
                    {{ __('Created At') }}
                </th>

                <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:120px;">
                    {{ __('Actions') }}
                </th>

            </tr>
        </thead>


        <tbody>
            @forelse($languages as $language)
                <tr>
                    <td>{{ $language->id }}</td>
                   <td class="d-flex align-items-center gap-2">
    <img src="{{ $language->thumbnail_id && $language->thumbnail ? asset('storage/' . $language->thumbnail->src) : asset('assets/frontend/img/flag/default-flag.png') }}"
         alt=""
         width="40"
         height="30"
         class="rounded"
         style="object-fit: cover;">
    <span>{{ $language->title }}</span>
</td>

                    <td>{{ $language->name }}</td>
                    <td>
                        @if ($language->status)
                            <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                    <td>{{ $language->created_at->format('d M, Y') }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-1">

                            {{-- Edit --}}
                            <x-table-action :route="route('languages.edit', $language->id)" :text="'Edit'" :icon="'fas fa-edit'" :bgColor="'#023066'"
                                :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                            {{-- Delete --}}
                            <x-table-action :route="route('languages.destroy', $language->id)" :text="'Delete'" :icon="'fas fa-trash'" :bgColor="'#dc3545'"
                                :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">{{ __('No languages found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
