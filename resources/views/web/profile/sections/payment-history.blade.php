@extends('web.profile.profile-master')
@section('payment-history-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">{{ __('Payment History') }}</h2>

        </div>

        <div class="rs-featured-ads-area not-found-bg">
            @forelse($transactions as $transaction)
                <div class="rs-featured-ads-card mb-16">
                    <div class="rs-featured-ads-card-top d-flex align-items-center justify-content-between mb-14 pb-14">
                        <h3 class="rs-featured-ads-title">
                            @if ($transaction->boostPlan)
                                {{ $transaction->boostPlan->name }}
                            @else
                                {{__('Wallet Recharge')}}
                            @endif
                        </h3>
                        <div class="rs-featured-top-info d-flex gap-16">
                            <span class="rs-featured-amount">{{ __('Amount') }}
                                <b>{{ number_format($transaction->amount, 2) }}</b></span>
                            <span class="rs-featured-method">{{ __('Method') }}
                                <b>{{ ucfirst($transaction->payment_method->name ?? 'N/A') }}</b></span>
                            <span class="rs-featured-transection">{{ __('Transaction ID') }}
                                <b>#{{ $transaction->identifier }}</b></span>
                        </div>
                    </div>

                    <div class="rs-featured-bottom-info d-flex align-items-center justify-content-between">
                        <div>
                            <p class="rs-featured-label">{{ __('Name') }}</p>
                            <p class="rs-featured-value">{{ $transaction->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="rs-featured-label">{{ __('Email') }}</p>
                            <p class="rs-featured-value">{{ $transaction->user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="rs-featured-label">{{ __('Phone No') }}</p>
                            <p class="rs-featured-value">{{ $transaction->user->phone_no ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="rs-featured-label">{{ __('Service Time') }}</p>
                            <p class="rs-featured-value">{{ $transaction->boostPlan->sustain_days ?? 'N/A' }}
                                {{ __('Days') }}</p>
                        </div>
                        <div>
                            <p class="rs-featured-label">{{ __('Date') }}</p>
                            <p class="rs-featured-value">{{ $transaction->created_at->format('d/m/Y') }}</p>
                        </div>
                         <div class="rs-transaction-item">
                            <p class="rs-featured-label">{{ __('Status') }}</p>
                            <div class="value">
                                @if ($transaction->status === 'pending')
                                    <span class="badge bg-danger">Cancel</span>
                                @else
                                    <span class="badge bg-success">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-center text-muted">{{ __('No payment history found') }}.</p>
            @endforelse
            {{-- Pagination --}}
                @if ($transactions->count())
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @endif
        </div>
    </div>
@endsection
