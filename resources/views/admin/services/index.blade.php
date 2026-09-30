@extends('layouts.app')

@section('content')


    {{-- Page Header --}}
    <x-table-header :title="'Services List'" :subtitle="'Manage All Services'" :icon="'bi bi-pencil-square'" :buttonText="'Update Main Service'" :buttonRoute="$services->isNotEmpty() ? route('services.edit', $services->first()->id) : '#'" />


    @if ($services->count() > 0)
        {{-- Services Table --}}
        <div class="ride-summary" data-bg-color="#fff">
            <h3 class="tp-summary-title">Services <span>(Latest)</span></h3>
            <div class="ride-table-wrapper" style="overflow-x:auto;">
                <table class="ride-table" style="min-width: 900px;">

                    <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                        <tr>
                            <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                                #
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                                {{ __('Title') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:200px;">
                                {{ __('Description') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-center"
                                style="font-size: 0.875rem; width:100px;">
                                {{ __('Total Services') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-center"
                                style="font-size: 0.875rem; width:150px;">
                                {{ __('Status') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-center"
                                style="font-size: 0.875rem; width:150px;">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($services as $service)
                            <tr class="text-center">
                                <td class="align-middle">{{ $service->id }}</td>
                                <td class="align-middle text-truncate" title="{{ $service->title }}">
                                    {{ $service->title }}
                                </td>
                                <td class="align-middle text-truncate" style="max-width:300px;"
                                    title="{{ $service->description }}">
                                    {{ Str::limit($service->description, 100) }}
                                </td>
                                <td class="align-middle">
                                    {{ is_array($service->services) ? count($service->services) : 0 }}
                                </td>
                                <td class="align-middle">
                                    @if (is_array($service->services) && count($service->services) > 0)
                                        @php
                                            // Count active and inactive services
                                            $activeCount = collect($service->services)
                                                ->where('status', 'active')
                                                ->count();
                                            $inactiveCount = count($service->services) - $activeCount;
                                        @endphp
                                        <span class="badge bg-success">{{ $activeCount }} Active</span>
                                        <span class="badge bg-secondary">{{ $inactiveCount }} Inactive</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2 justify-content-center">
                                        {{-- View --}}
                                        <x-table-action :route="Route('services.show', $service->id)" :text="'View'" :icon="'far fa-eye'"
                                            :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {{ __('No services found.') }}
        </div>
    @endif


@endsection
