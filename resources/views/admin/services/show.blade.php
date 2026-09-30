@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Service Details'" :subtitle="'View All Service Details'" :icon="'bi bi-tools'" :buttonText="'Back'" :buttonRoute="route('services.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4 class="text-secondary">{{ $service->title }}</h4>
            <p class="text-muted">{{ $service->description }}</p>

            <h5 class="mt-4 text-success">{{ __('All Services') }}
                ({{ is_array($service->services) ? count($service->services) : 0 }})</h5>

            @if (is_array($service->services) && count($service->services) > 0)
                <div class="table-responsive">
                    <table class="service_show_table table-bordered table-striped mt-2 align-middle text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Service Title') }}</th>
                                <th>{{ __('Subtitle') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service->services as $key => $item)
                                @php
                                    $media = \App\Models\Media::find($item['thumbnail_id']);
                                    $thumbnailUrl = $media
                                        ? Storage::url($media->src)
                                        : 'https://placehold.jp/100x100.png';
                                    $status = $item['status'] ?? 'inactive';
                                @endphp
                                <tr class="table-light">
                                    <td class="fw-bold text-dark">{{ $item['title'] ?? '-' }}</td>
                                    <td>
                                        <img src="{{ $thumbnailUrl }}" alt="{{ __('Thumbnail') }}" class="img-thumbnail"
                                            style="max-width:100px;">
                                    </td>
                                    <td class="text-success">{{ $item['service_title'] ?? '-' }}</td>
                                    <td>{{ $item['subtitle'] ?? '-' }}</td>
                                    <td class="text-muted text-start">{{ $item['description'] ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('services.updateStatus') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                                            <input type="hidden" name="key" value="{{ $key }}">

                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="active"
                                                    {{ ($item['status'] ?? '') == 'active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="inactive"
                                                    {{ ($item['status'] ?? '') == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-danger mt-2 fw-bold">{{ __('No services available.') }}</p>
            @endif
        </div>
    </div>
@endsection
