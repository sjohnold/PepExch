@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'All Announcements'" :subtitle="'Manage All Announcements'" :icon="'bi bi-folder'" :buttonText="'Create Announcement'" :buttonRoute="route('announcements.create')" />

    @php
        // Custom colors for badges
        $typeColors = [
            'Update' => '#0d6efd', // blue
            'Message' => '#198754', // green
            'Offer' => '#ffc107', // yellow
            'Alert' => '#dc3545', // red
            'Notice' => '#0dcaf0', // cyan
            'News' => '#6c757d', // gray
            'Other' => '#343a40', // dark
        ];
    @endphp

    {{-- Announcements Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Announcements') }} <span>({{ __('Latest') }})</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 900px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width: 40px;">#
                        </th>
                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: 180px;">
                            {{ __('Title') }}</th>
                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: 250px;">
                            {{ __('Message') }}</th>
                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: 120px;">
                            {{ __('Type') }}</th>
                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width: 120px;">
                            {{ __('Sent To') }}</th>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width: 300px;">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($announcements as $announcement)
                        @php
                            $message = json_decode($announcement->message);
                            $users = json_decode($announcement->user_ids) ?? [];
                            $color = $typeColors[$message->type] ?? '#adb5bd'; // default gray
                        @endphp
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle text-truncate" title="{{ $message->title }}">
                                {{ $message->title }}
                            </td>

                            <td class="align-middle text-truncate" title="{{ $message->body }}">
                                {{ \Illuminate\Support\Str::limit($message->body, 50) }}
                            </td>

                            {{-- Type Badge --}}
                            <td class="align-middle">
                                <span class="d-inline-block fw-semibold text-truncate"
                                    style="width: 100px; text-align: center;
                                             border: 2px solid {{ $color }};
                                             border-radius: .375rem;
                                             padding: .25rem .5rem;
                                             color: {{ $color }};">
                                    {{ $message->type }}
                                </span>
                            </td>

                            {{-- Sent To Badge --}}
                            <td class="align-middle">
                                <span class="d-inline-block fw-semibold text-truncate"
                                    style="width: 100px; text-align: center;
                                             border: 2px solid #6c757d;
                                             border-radius: .375rem;
                                             padding: .25rem .5rem;
                                             color: #6c757d;">
                                    {{ count($users) }} {{ __('Users') }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    <x-table-action :route="route('announcements.show', $announcement->id)" :text="'View'" :icon="'far fa-eye'" :bgColor="'#60363b'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    <x-table-action :route="route('announcements.destroy', $announcement->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                        :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('No announcements found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $announcements->links() }}
    </div>
@endsection
