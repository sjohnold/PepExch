@extends('layouts.app')

@section('content')


    {{-- Page Header --}}

    <x-table-header :title="'Testimonials'" :subtitle="'Manage All Testimonials'" :icon="'bi bi-folder'" :showSearch="true" :searchValue="request('search')"
        :buttonText="'Add Testimonial'" :buttonRoute="route('testimonials.create')" />

    {{-- Testimonials Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">{{ __('Testimonials') }} <span>{{ __('(Latest)') }}</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 1200px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            {{ __('#') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:80px;">
                            {{ __('Thumbnail') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:120px;">
                            {{ __('Designation') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:100px;">
                            {{ __('Rating') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4" style="font-size: 0.875rem; width:150px;">
                            {{ __('Description') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:80px;">
                            {{ __('Status') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:400px;">
                            {{ __('Actions') }}
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($testimonials as $testimonial)
                        <tr class="text-center">
                            <td class="align-middle">{{ $testimonial->id }}</td>
                            <td class="align-middle">
                                <img src="{{ $testimonial->thumbnailPath }}" width="60" height="60"
                                    style="object-fit: cover; border-radius:5px;" alt="Thumbnail">
                            </td>
                            <td class="align-middle"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">
                                {{ $testimonial->name }}
                            </td>
                            <td class="align-middle"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">
                                {{ $testimonial->designation }}
                            </td>
                            <td class="align-middle">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $testimonial->rating)
                                        <span class="text-warning">&#9733;</span>
                                    @else
                                        <span class="text-muted">&#9734;</span>
                                    @endif
                                @endfor
                            </td>
                            <td class="align-middle"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px;">
                                {{ \Illuminate\Support\Str::limit($testimonial->description, 100) }}
                            </td>

                            @php
                                if ($testimonial->status) {
                                    $className = 'text-success';
                                    $value = 'Active';
                                    $icon = 'fas fa-check-circle';
                                } else {
                                    $className = 'text-warning';
                                    $value = 'Inactive';
                                    $icon = 'fas fa-clock';
                                }
                            @endphp

                            <td class="align-middle">
                                <x-table-status :className="$className" :status="$value" :icon="$icon"></x-table-status>
                            </td>


                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">


                                    <x-table-action :route="route('testimonials.show', $testimonial->id)" :text="'View'" :icon="'far fa-eye'"
                                        :bgColor="'#60363b'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />


                                    <x-table-action :route="route('testimonials.edit', $testimonial->id)" :text="'Edit'" :icon="'fas fa-edit'"
                                        :bgColor="'#023066'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />


                                    <x-table-action :route="route('testimonials.destroy', $testimonial->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                        :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />


                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">{{ __('No testimonials found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
