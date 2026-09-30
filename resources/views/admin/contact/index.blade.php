@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'All Contact Us Message Lists'" :subtitle="'Manage All Message Lists'" :icon="'fas fa-paper-plane'" />

    {{-- Messages Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Messages') }} <span>(Latest)</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:120px;">
                            Name
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:120px;">
                            Subject
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            Message
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            Email
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:100px;">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($contacts as $contact)
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle text-truncate" title="{{ $contact->name }}">
                                {{ $contact->name }}
                            </td>

                            <td class="align-middle text-truncate" style="max-width:250px;" title="{{ $contact->subject }}">
                                {{ $contact->subject }}
                            </td>

                            <td class="align-middle text-truncate" style="max-width:300px;" title="{{ $contact->message }}">
                                {{ Str::limit($contact->message, 100) }}
                            </td>

                            <td class="align-middle text-truncate" title="{{ $contact->email }}">
                                {{ $contact->email }}
                            </td>

                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">

                                    {{-- View  --}}
                                    <x-table-action :route="route('contact.show', $contact->id)" :text="'View'" :icon="'far fa-eye'" :bgColor="'#60363b'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    {{-- Delete --}}
                                    <x-table-action :route="route('contact.destroy', $contact->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                        :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('No messages found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-4 mt-5 px-3">
        {{ $contacts->links() }}
    </div>
@endsection
