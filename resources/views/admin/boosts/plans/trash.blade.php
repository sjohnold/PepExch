@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-100">
        {{-- Page Header --}}
        <x-table-header :title="'Trash Plans'" :icon="'bi bi-plus-circle-fill'" />

        {{-- Trash Plans Table --}}
        <div class="ride-summary" data-bg-color="#fff">
            <h3 class="tp-summary-title">{{ __('Deleted Plans') }} <span>(Latest)</span></h3>
            <div class="ride-table-wrapper" style="overflow-x:auto;">
                <table class="ride-table" style="min-width:800px;">
                    <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                        <tr>

                            <th class="fw-semibold text-muted py-3 px-4 text-start" style="font-size: 0.875rem; width:30px;">
                                #
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:150px;">
                                {{ __('Plan Name') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:120px;">
                                {{ __('Payable Amount') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:100px;">
                                {{ __('Discount') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:100px;">
                                {{ __('Sustain Days') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:150px;">
                                {{ __('Deleted At') }}
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($plans as $plan)
                            <tr class="text-center">
                                <td class="align-middle">{{ $plan->id }}</td>
                                <td class="align-middle text-truncate" title="{{ $plan->name }}">
                                    {{ $plan->name }}
                                </td>
                                <td class="align-middle">{{ currencyFormat($plan->payable_amount) }}</td>
                                <td class="align-middle">{{ currencyFormat($plan->discount_amount) }}</td>
                                <td class="align-middle">{{ $plan->sustain_days }}</td>
                                <td class="align-middle">{{ $plan->deleted_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">{{ __('No deleted plans found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
