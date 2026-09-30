@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-100">
        {{-- Page Header --}}
        <x-table-header :title="'Sold / Expired Plans'" :subtitle="'Manage All Sold / Expired Plans'" :icon="'bi bi-plus-circle-fill'" />

        {{-- Plans Table --}}
        <div class="ride-summary" data-bg-color="#fff">
            <h3 class="tp-summary-title">{{ __('Plans List') }} <span>(Latest)</span></h3>
            <div class="ride-table-wrapper" style="overflow-x:auto;">
                <table class="ride-table" style="min-width:900px;">
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
                                style="font-size: 0.875rem; width:120px;">
                                {{ __('Selling Post ID') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:150px;">
                                {{ __('Expired At') }}
                            </th>

                            <th class="fw-semibold text-muted py-3 px-4 text-start"
                                style="font-size: 0.875rem; width:100px;">
                                {{ __('Status') }}
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($soldPlans as $sold)
                            <tr class="text-center">
                                <td class="align-middle">{{ $sold->id }}</td>
                                <td class="align-middle text-truncate" title="{{ $sold->boostPlan?->name ?? 'N/A' }}">
                                    {{ $sold->boostPlan?->name ?? 'N/A' }}
                                </td>
                                <td class="align-middle">{{ currencyFormat($sold->boostPlan?->payable_amount) ?? 0 }}</td>
                                <td class="align-middle">{{ currencyFormat($sold->boostPlan?->discount_amount) ?? 0 }}</td>
                                <td class="align-middle">{{ $sold->boostPlan?->sustain_days ?? 0 }}</td>
                                <td class="align-middle">{{ $sold?->selling_post_id }}</td>
                                <td class="align-middle">{{ $sold?->expired_at }}</td>
                                <td class="align-middle">
                                    @if ($sold->expired_at > now())
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('Expired') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">{{ __('No plans found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
