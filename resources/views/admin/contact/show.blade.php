@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <x-table-header :title="'Contact Message Details'" :subtitle="'Show All Message Lists'" :icon="'fas fa-paper-plane'" :buttonText="'Back'" :buttonRoute="route('contact.index')"
        :buttonIcon="'bi bi-arrow-left'" />

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">

            {{-- Name & Email --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-uppercase text-muted fw-semibold" style="letter-spacing:.08em;">
                            {{ __('Name') }}
                        </small>
                        <div class="mt-2 fw-semibold text-dark fs-6">
                            {{ $contact->name }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-uppercase text-muted fw-semibold" style="letter-spacing:.08em;">
                            {{ __(' Email') }}
                        </small>
                        <div class="mt-2 fw-semibold text-dark fs-6">
                            {{ $contact->email }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Subject --}}
            <div class="mb-4">
                <div class="p-3 rounded-3 bg-light">
                    <small class="text-uppercase text-muted fw-semibold" style="letter-spacing:.08em;">
                        {{ __('Subject') }}
                    </small>
                    <div class="mt-2 fw-semibold text-dark fs-6">
                        {{ $contact->subject }}
                    </div>
                </div>
            </div>

            {{-- Message --}}
            <div>
                <div class="p-3 rounded-3 bg-light" style=" line-height: 1.6; min-height: 180px;">
                    <small class="text-uppercase text-muted fw-semibold d-block mb-2" style="letter-spacing:.08em;">
                        {{ __(' Message') }}
                    </small>

                    <div class="text-body fs-5">
                        {{ $contact->message }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
