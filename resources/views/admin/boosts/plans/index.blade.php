@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Boost Plans'" :subtitle="'Manage All Boost Plans'" :icon="'bi bi-plus-circle-fill'" :buttonText="'Add New Plan'" :buttonRoute="route('plans.create')" />

    {{-- Boost Plans Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Plans List') }} <span>(Latest)</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width:900px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:50px;">
                            {{ __('ID') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:150px;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:150px;">
                            {{ __('Description') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:120px;">
                            {{ __('Payable Amount') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:120px;">
                            {{ __('Discount Amount') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:250px;">
                            {{ __('Plan Items') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:100px;">
                            {{ __('Sustain Days') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:100px;">
                            {{ __('Thumbnail') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:400px;">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($plans as $plan)
                        @php
                            $planItems = json_decode($plan->plan_items, true) ?? [];
                        @endphp
                        <tr class="text-center">
                            <td class="align-middle">{{ $plan->id }}</td>
                            <td class="align-middle">{{ Illuminate\Support\Str::limit($plan->name, 10, '...') }}</td>
                            <td class="align-middle">
                                {{ $plan->description ? Illuminate\Support\Str::limit($plan->description, 10) : 'N/A' }}
                            </td>
                            <td class="align-middle">{{ currencyFormat($plan->payable_amount) }}</td>
                            <td class="align-middle">
                                {{ $plan->discount_amount && $plan->discount_amount > 0 ? currencyFormat($plan->discount_amount) : '-' }}
                            </td>

                            <td class="align-middle text-start" style="max-width:250px;">
                                <ul class="mb-0 ps-3 text-start">
                                    @forelse($planItems as $item)
                                        <li>
                                            @php
                                                $text = is_array($item) ? json_encode($item) : $item;
                                            @endphp

                                            {{ Illuminate\Support\Str::limit($text, 10, '...') }}
                                        </li>
                                    @empty
                                        <li>-</li>
                                    @endforelse
                                </ul>
                            </td>

                            <td class="align-middle">{{ $plan->sustain_days }}</td>
                            <td class="align-middle">
                                @if ($plan->thumbnail)
                                    <img src="{{ asset('storage/' . $plan->thumbnail->src) }}" alt="Thumbnail"
                                        class="rounded" style="width:50px; height:50px; object-fit:cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    @can('plans.edit')
                                        <x-table-action :route="route('plans.edit', $plan->id)" :text="'Edit'" :icon="'fas fa-edit'" :bgColor="'#023066'"
                                            :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                    @endcan


                                    @can('plans.show')
                                        <x-table-action :route="route('plans.show', $plan->id)" :text="'View'" :icon="'far fa-eye'"
                                            :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />
                                    @endcan


                                    @can('plans.destroy')
                                        <x-table-action :route="route('plans.destroy', $plan->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                            :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted"> {{ __('No Boost Plans Found') }} </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $plans->links() }}
    </div>
@endsection
