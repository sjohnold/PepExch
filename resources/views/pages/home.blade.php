@extends('layouts.app')

@section('style')
<style>
    .admin-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }
    .metric-card {
        padding: 18px;
    }
    .metric-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: color-mix(in srgb, var(--theme-primary) 12%, white);
        color: var(--theme-primary);
    }
    .quick-action {
        border-radius: 6px;
        font-weight: 700;
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">{{ __('Admin Workbench') }}</h2>
            <p class="text-muted mb-0">{{ __('Moderation, exchanges and support items that need attention.') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('posts.index', 'Pending') }}" class="btn btn-success quick-action">
                <i class="fas fa-check-circle me-2"></i>{{ __('Review Pending') }}
            </a>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-danger quick-action">
                <i class="fas fa-flag me-2"></i>{{ __('Open Reports') }}
            </a>
            <a href="{{ route('admin.offers.index') }}" class="btn btn-outline-primary quick-action">
                <i class="fas fa-handshake me-2"></i>{{ __('Manage Offers') }}
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([
            ['label' => 'Pending posts', 'value' => $workbenchStats['pending_posts'], 'icon' => 'fa-clipboard-check', 'url' => route('posts.index', 'Pending')],
            ['label' => 'Pending offers', 'value' => $workbenchStats['pending_offers'], 'icon' => 'fa-hourglass-half', 'url' => route('admin.offers.index')],
            ['label' => 'Reports', 'value' => $workbenchStats['reports'], 'icon' => 'fa-flag', 'url' => route('reports.index')],
            ['label' => 'Disputes', 'value' => $workbenchStats['disputes'], 'icon' => 'fa-scale-balanced', 'url' => route('admin.offers.index')],
            ['label' => 'Support tickets', 'value' => $workbenchStats['support_tickets'], 'icon' => 'fa-life-ring', 'url' => route('contact.index')],
        ] as $metric)
            <div class="col-xl col-md-4 col-sm-6">
                <a href="{{ $metric['url'] }}" class="admin-card metric-card d-block text-decoration-none text-dark h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">{{ __($metric['label']) }}</div>
                            <div class="fs-3 fw-bold mt-1">{{ $metric['value'] }}</div>
                        </div>
                        <span class="metric-icon"><i class="fas {{ $metric['icon'] }}"></i></span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="admin-card metric-card h-100">
                <div class="text-muted small text-uppercase fw-bold">{{ __('Total Offers') }}</div>
                <div class="fs-3 fw-bold">{{ $barterStats['total_offers'] }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="admin-card metric-card h-100">
                <div class="text-muted small text-uppercase fw-bold">{{ __('Accepted Offers') }}</div>
                <div class="fs-3 fw-bold">{{ $barterStats['accepted_offers'] }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="admin-card metric-card h-100">
                <div class="text-muted small text-uppercase fw-bold">{{ __('Successful') }}</div>
                <div class="fs-3 fw-bold">{{ $barterStats['completed_exchanges'] }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="admin-card metric-card h-100">
                <div class="text-muted small text-uppercase fw-bold">{{ __('Active Users') }}</div>
                <div class="fs-3 fw-bold">{{ $activeUsers }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="admin-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">{{ __('Recent Listings') }}</h5>
                    <a href="{{ route('posts.index') }}" class="text-decoration-none fw-bold">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Owner') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Offers') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellingPosts as $post)
                                <tr>
                                    <td class="fw-semibold">{{ $post->name }}</td>
                                    <td>
                                        <div>{{ $post->user?->name ?? __('Unknown') }}</div>
                                        <small class="text-muted">{{ $post->user?->email }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $post->status }}</span></td>
                                    <td>{{ $post->created_at?->format('Y-m-d') }}</td>
                                    <td>{{ $post->offers_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">{{ __('Edit') }}</a>
                                        <a href="{{ route('product-details', $post->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">{{ __('View') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">{{ __('No listings found') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="admin-card p-3 mb-3">
                <h5 class="fw-bold mb-3">{{ __('Top Exchange Partners') }}</h5>
                @forelse ($topSellers as $sellerData)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $sellerData['profile_photo'] }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <div class="fw-semibold">{{ $sellerData['seller']?->name ?? __('Unknown') }}</div>
                                <small class="text-muted">{{ $sellerData['email'] }}</small>
                                <div class="small text-warning">
                                    <i class="fas fa-star"></i> {{ $sellerData['avg_rating'] }} · {{ $sellerData['review_count'] }} {{ __('reviews') }}
                                </div>
                            </div>
                        </div>
                        <div class="text-end small">
                            <div>{{ $sellerData['completed_exchanges'] }} {{ __('done') }}</div>
                            <div class="text-muted">{{ $sellerData['post_count'] }} {{ __('active ads') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0">{{ __('No active partners found') }}</p>
                @endforelse
            </div>

            <div class="admin-card p-3">
                <h5 class="fw-bold mb-3">{{ __('Recent Activity') }}</h5>
                @forelse ($recentActivity as $activity)
                    <a href="{{ $activity['url'] }}" class="d-flex justify-content-between gap-3 py-2 border-bottom text-decoration-none text-dark">
                        <div>
                            <span class="badge bg-light text-dark">{{ __($activity['type']) }}</span>
                            <div class="fw-semibold mt-1">{{ $activity['title'] }}</div>
                        </div>
                        <small class="text-muted text-nowrap">{{ $activity['date']?->diffForHumans() }}</small>
                    </a>
                @empty
                    <p class="text-muted text-center py-4 mb-0">{{ __('No recent activity') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
