@extends('layouts.app')

@section('content')
    <x-table-header :title="'Global Reports Moderation'" :subtitle="'Manage and review all reports from users across the platform'" :icon="'fas fa-gavel'" />

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Reporter') }}</th>
                                    <th class="border-0 py-3">{{ __('Subject (Seller/User)') }}</th>
                                    <th class="border-0 py-3">{{ __('Type') }}</th>
                                    <th class="border-0 py-3">{{ __('Details') }}</th>
                                    <th class="border-0 py-3">{{ __('Date') }}</th>
                                    <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $report)
                                    <tr>
                                        <td class="px-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $report->reporter->profilePhotoPath }}" alt="" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $report->reporter->name }}</div>
                                                    <small class="text-muted">{{ $report->reporter->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $report->seller->id) }}" class="d-flex align-items-center text-decoration-none">
                                                <img src="{{ $report->seller->profilePhotoPath }}" alt="" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                <div class="fw-semibold text-primary">{{ $report->seller->name }}</div>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3">
                                                {{ $report->report_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 250px;" title="{{ $report->details }}">
                                                {{ $report->details }}
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            {{ $report->created_at->format('d M Y') }}
                                            <div class="small">{{ $report->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-4 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-sm btn-light rounded-pill" onclick="showFullDetails('{{ addslashes($report->details) }}', '{{ $report->reporter->name }}')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form action="{{ route('reports.delete', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 opacity-20"></i>
                                                <p>{{ __('No reports found in the system.') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($reports->hasPages())
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function showFullDetails(details, reporter) {
            Swal.fire({
                title: 'Report Details',
                html: `<div class="text-start">
                    <p class="mb-2"><strong>Reporter:</strong> ${reporter}</p>
                    <hr>
                    <p class="text-secondary">${details}</p>
                </div>`,
                icon: 'info',
                confirmButtonColor: '#10B981'
            });
        }
    </script>
@endsection
