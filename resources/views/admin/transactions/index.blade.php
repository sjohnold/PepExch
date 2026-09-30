@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'All Transactions'" :subtitle="'Manage and monitor aAll Transactions'" :icon="'fas fa-exchange-alt'" :showSearch="true" :searchValue="request()->search" />

    {{-- Transactions Table --}}
    <div class="ride-summary" data-bg-color="#fff" class="mb-5">
        <h3 class="tp-summary-title">{{ __('Transactions') }} <span>{{ __('(Latest)') }}</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:50px;">
                            {{ __('ID') }}
                        </th>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:50px;">
                            {{ __('Identifier') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Selling Post') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Boost Plan ') }}
                        </th>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Payment Gateway') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:100px;">
                            {{ __('Status') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:100px;">
                            {{ __('Amount') }}
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($transactions as $transaction)
                        <tr class="text-center">
                            <td class="align-middle">{{ $transaction->id }}</td>
                            <td class="align-middle">{{ $transaction->identifier ?? 'N/A' }}
                            </td>
                            <td class="align-middle">{{ optional($transaction->sellingPost)->name ?? 'Wallet Recherge' }}
                            </td>
                            <td class="align-middle">{{ optional($transaction->boostPlan)->name ?? 'Wallet Recherge' }}
                            </td>
                            <td class="align-middle">{{ optional($transaction->payment_method)->name ?? 'Wallet' }}</td>
                            <td class="align-middle">

                                @php
                                    $className = 'bg-success';
                                    if ($transaction->status == 'complete') {
                                        $className = 'text-success';
                                        $icon = 'fas fa-check-circle';
                                    } elseif ($transaction->status == 'pending') {
                                        $className = 'text-warning';
                                        $icon = 'fas fa-clock';
                                    }
                                @endphp

                                <x-table-status :className="$className" :status="$transaction->status" :icon="$icon"></x-table-status>
                            </td>
                            <td class="align-middle badge px-4 py-2 text-dark mt-2" style="font-size: 1.25rem">
                                {{ currencyFormat($transaction->amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">{{ __('No transactions found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $transactions->links() }}
    </div>
@endsection
