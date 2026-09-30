@extends('layouts.app')

@section('content')
    <div class="row mt-5">

        <x-table-header :title="'Payment Gateways'" :subtitle="'Manage All Payment Gateways'" :icon="'bi bi-cash-stack'" />

        @foreach ($paymentGateways as $gateway)
            <div class="col-md-4 d-flex">
                <div class="card h-100 shadow-sm border-0 rounded flex-fill d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <form action="{{ route('payment-gateways.update', $gateway->id) }}" method="POST"
                            enctype="multipart/form-data" class="d-flex flex-column h-100">
                            @csrf
                            @method('PUT')

                            {{-- Header: Name + Active Switch --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="h4 mb-0 fw-semibold">{{ ucfirst($gateway->name) }}</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active"
                                        id="is_active_{{ $gateway->id }}"
                                        {{ old('is_active', $gateway->is_active) ? 'checked' : '' }}
                                        style="cursor: pointer;">
                                    <label class="form-check-label" for="is_active_{{ $gateway->id }}" style="cursor: pointer;">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                            </div>

                            {{-- Gateway Image --}}
                            <div class="text-center mb-4 p-3 bg-light rounded">
                                <img src="{{ $gateway->imagePath }}" alt="{{ ucfirst($gateway->name) }}"
                                    class="object-fit-contain" width="160" height="120">
                            </div>

                            {{-- Ensure config is array --}}
                            @php
                                $config = is_array($gateway->config)
                                    ? $gateway->config
                                    : json_decode($gateway->config, true);
                            @endphp

                            {{-- Dynamic fields based on config --}}
                            @foreach ($config as $key => $value)
                                @if ($key === 'mode')
                                    @continue
                                @endif
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-secondary mb-2">
                                        <i class="bi bi-key-fill me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input type="text"
                                            name="{{ $key }}"
                                            id="{{ $key }}_{{ $gateway->id }}"
                                            value="{{ old($key, $value) }}"
                                            class="form-control border-start-0 @error($key) is-invalid @enderror"
                                            placeholder="Enter {{ strtolower(str_replace('_', ' ', $key)) }}"
                                            required>
                                    </div>
                                    @error($key)
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach

                            {{-- Mode field if exists --}}
                            @if (isset($config['mode']))
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-secondary mb-2">
                                        <i class="bi bi-toggle-on me-1"></i>
                                        {{ __('Mode') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-gear"></i>
                                        </span>
                                        <select name="mode"
                                            id="mode_{{ $gateway->id }}"
                                            class="form-select border-start-0 @error('mode') is-invalid @enderror">
                                            <option value="sandbox"
                                                {{ old('mode', $config['mode']) === 'sandbox' ? 'selected' : '' }}>
                                                <i class="bi bi-cone-striped"></i> {{ __('Sandbox (Testing)') }}
                                            </option>
                                            <option value="live"
                                                {{ old('mode', $config['mode']) === 'live' ? 'selected' : '' }}>
                                                {{ __('Live (Production)') }}
                                            </option>
                                        </select>
                                    </div>
                                    @error('mode')
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Submit Button (Always bottom right) --}}
                            <div class="mt-auto pt-3 border-top text-end">
                                <x-update-button :title="'Update ' . ucfirst($gateway->name)" :icon="'fas fa-save'" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
