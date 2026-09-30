@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Roles'" :subtitle="'Manage all Roles'" :icon="'bi bi-person-lock'" :showSearch="true" :searchValue="request('search')"
        :buttonText="'Add New Roles'" :buttonRoute="route('roles.create')" />

    {{-- Roles Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">Roles <span>(Latest)</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 600px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>

                        <th class="fw-semibold text-muted py-3 px-4 text-center"
                            style="font-size: 0.875rem; width:20px !important;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:50px !important;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-end"
                            style="font-size: 0.875rem; width:30px !important;">
                            {{ __('Actions') }}
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="tp-ride-order-id-title">{{ $loop->iteration }}</td>
                            <td class="tp-ride-order-location"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                {{ $role->name }}
                            </td>
                            <td class="d-flex align-items-center justify-content-end gap-2">

                                @can('roles.show')
                                    <x-table-action :route="route('roles.show', $role->id)" :text="'View'" :icon="'far fa-eye'" :bgColor="'#60363b'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                @endcan

                                {{-- Only show Edit/Delete if NOT admin --}}
                                @if ($role->name !== 'Admin')
                                    @can('roles.edit')
                                        <x-table-action :route="route('roles.edit', $role->id)" :text="'Edit'" :icon="'fas fa-edit'"
                                            :bgColor="'#023066'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                    @endcan

                                    @can('roles.destroy')
                                        <x-table-action :route="route('roles.destroy', $role->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                            :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                    @endcan
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">{{ __('No roles found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
