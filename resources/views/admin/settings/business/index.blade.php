@extends('layouts.app')

@section('content')
    {{-- HTML Start --}}
    <x-table-header :title="'Business Settings'" :subtitle="'Manage all Business Settings'" :icon="'bi bi-building'" />

    <form method="POST" action="{{ route('business-settings.update') }}" enctype="multipart/form-data"
        class="card shadow-sm p-4 rounded-3 border-0" style="background-color: #ffffff;">
        @csrf

        <div class="row g-4">
            <!-- Currency Symbol -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box rounded-3 p-2 me-3" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#495057"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                </svg>
                            </div>
                            <label for="currency_symbol" class="form-label fw-semibold mb-0"
                                style="color: #495057;">{{ __('Currency Symbol') }}</label>
                        </div>
                        <input type="text" class="form-control form-control-lg rounded-3 border" id="currency_symbol"
                            name="currency_symbol" value="{{ $currencySetting->data->symbol ?? '' }}"
                            placeholder="৳, $, €, £" style="background-color: #ffffff; border-color: #dee2e6;">
                    </div>
                </div>
            </div>

            <!-- Currency -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box rounded-3 p-2 me-3" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#495057"
                                    viewBox="0 0 16 16">
                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                    <path
                                        d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z" />
                                </svg>
                            </div>
                            <label for="currency" class="form-label fw-semibold mb-0"
                                style="color: #495057;">{{ __('Currency') }}</label>
                        </div>
                        <input type="text" class="form-control form-control-lg rounded-3 border text-uppercase"
                            id="currency" name="currency" value="{{ $currencySetting->data->currency ?? '' }}"
                            placeholder="BDT, USD, EUR"
                            style="background-color: #ffffff; border-color: #dee2e6; text-transform: uppercase;"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
            </div>

            <!-- Currency Position -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box rounded-3 p-2 me-3" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#495057"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
                                </svg>
                            </div>
                            <label for="currency_position" class="form-label fw-semibold mb-0" style="color: #495057;">
                                {{ __('Currency Position') }}
                            </label>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-4 p-3 rounded-3 currency_position"
                            style="background-color: #ffffff; border: 1px solid #dee2e6;">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="currency_position" id="leftOption"
                                    value="left"
                                    {{ ($currencySetting->data->position ?? '') == 'left' ? 'checked' : '' }}>
                                <label class="form-check-label" for="leftOption">
                                    <span class="badge px-3 py-2 rounded-pill"
                                        style=" color: #495057; font-weight: 500;">Left</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="currency_position" id="rightOption"
                                    value="right"
                                    {{ ($currencySetting->data->position ?? '') == 'right' ? 'checked' : '' }}>
                                <label class="form-check-label" for="rightOption">
                                    <span class="badge px-3 py-2 rounded-pill"
                                        style=" color: #495057; font-weight: 500;">Right</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GST -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box rounded-3 p-2 me-3" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#495057"
                                    viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                            </div>
                            <label class="form-label fw-semibold mb-0" style="color: #495057;">{{ __('GST') }}</label>
                        </div>
                        <div class="input-group input-group-lg">
                            <select name="gst_type" class="form-select rounded-start"
                                style="background-color: #ffffff; border-color: #dee2e6;">
                                <option value="percentage"
                                    {{ ($gstSetting->data->type ?? '') == 'percentage' ? 'selected' : '' }}>
                                    Percentage (%)</option>
                                <option value="flat" {{ ($gstSetting->data->type ?? '') == 'flat' ? 'selected' : '' }}>
                                    Flat
                                </option>
                            </select>
                            <input type="number" name="gst_value" class="form-control rounded-end"
                                value="{{ $gstSetting->data->value ?? '' }}" placeholder="{{ __('Enter GST Value') }}"
                                style="background-color: #ffffff; border-color: #dee2e6; border-left: none;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tax -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box rounded-3 p-2 me-3" style="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#495057"
                                    viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                                </svg>
                            </div>
                            <label class="form-label fw-semibold mb-0"
                                style="color: #495057;">{{ __('Tax') }}</label>
                        </div>
                        <div class="input-group input-group-lg">
                            <select name="tax_type" class="form-select rounded-start"
                                style="background-color: #ffffff; border-color: #dee2e6;">
                                <option value="percentage"
                                    {{ ($taxSetting->data->type ?? '') == 'percentage' ? 'selected' : '' }}>
                                    Percentage (%)</option>
                                <option value="flat" {{ ($taxSetting->data->type ?? '') == 'flat' ? 'selected' : '' }}>
                                    Flat
                                </option>
                            </select>
                            <input type="number" name="tax_value" class="form-control rounded-end"
                                value="{{ $taxSetting->data->value ?? '' }}" placeholder="{{ __('Enter Tax Value') }}"
                                style="background-color: #ffffff; border-color: #dee2e6; border-left: none;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            <x-update-button :title="'Update'" :icon="'fas fa-save'" />
        </div>
    </form>
@endsection

<style>
    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-input:checked+.form-check-label .badge {
        background-color: #0d6efd !important;
        color: white !important;
    }

    /* Remove spinner from number inputs */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .input-group-lg>.form-control,
        .input-group-lg>.form-select {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
