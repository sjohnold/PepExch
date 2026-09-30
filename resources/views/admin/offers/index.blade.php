@extends('layouts.app')

@section('content')
    <x-table-header :title="'Exchange Offers'" :subtitle="'Monitor all barter proposals and completed trades'" :icon="'fas fa-handshake'" :showSearch="true"
    :searchValue="request()->search" :showPerPage="true" />

    <div class="ride-summary mt-4" data-bg-color="#fff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="tp-summary-title m-0">{{ __('Barter Flow') }}</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.offers.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">All</a>
                <a href="{{ route('admin.offers.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill px-3">Pending</a>
                <a href="{{ route('admin.offers.index', ['status' => 'accepted']) }}" class="btn btn-sm {{ request('status') == 'accepted' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3">Accepted</a>
                <a href="{{ route('admin.offers.index', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">Completed</a>
            </div>
        </div>

        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width:1000px">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="py-3 px-4">#ID</th>
                        <th class="py-3 px-4">Target Post</th>
                        <th class="py-3 px-4">Sender (Proposer)</th>
                        <th class="py-3 px-4">Receiver (Owner)</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Confirmation</th>
                        <th class="py-3 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                        <tr>
                            <td class="py-3 px-4">#{{ $offer->id }}</td>
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $offer->sellingPost?->profilePath }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    <span class="fw-bold text-truncate" style="max-width: 150px;">{{ $offer->sellingPost?->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">{{ $offer->sender?->name }}</td>
                            <td class="py-3 px-4">{{ $offer->receiver?->name }}</td>
                            <td class="py-3 px-4">
                                <span class="badge {{ $offer->status == 'completed' ? 'bg-success' : ($offer->status == 'pending' ? 'bg-warning' : 'bg-primary') }} rounded-pill px-3">
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="d-flex gap-2">
                                    <span title="Sender Confirmed" class="{{ $offer->sender_confirmed ? 'text-success' : 'text-muted' }}"><i class="fas fa-check-double"></i> S</span>
                                    <span title="Receiver Confirmed" class="{{ $offer->receiver_confirmed ? 'text-success' : 'text-muted' }}"><i class="fas fa-check-double"></i> R</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.offers.show', $offer->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('Delete this offer record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Delete Record">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No barter offers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $offers->links() }}
        </div>
    </div>
@endsection
