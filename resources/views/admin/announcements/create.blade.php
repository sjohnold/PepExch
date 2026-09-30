@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <x-table-header :title="'Create New Announcement'" :buttonText="'Back'" :buttonRoute="route('announcements.index')" :buttonIcon="'bi bi-arrow-left'" />

                    <div class="card-body p-4">
                        <form action="{{ route('announcements.store') }}" method="POST">
                            @csrf

                            {{-- Announcement Details --}}
                           <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-secondary">{{ __('Announcement Details') }}</h6>
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-medium">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Here"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label fw-medium">{{ __('Message') }} <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="body" name="body" rows="6" placeholder="Enter Description Here">{{ old('body') }}</textarea>
                                    @error('body')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Type / Purpose --}}
                            <div class="mb-4">
                                <h6 class="mb-3">{{ __('Announcement Type (Select Only 1)') }}<span class="text-danger">*</span></h6>
                                <div class="type-grid" id="typeGrid">
                                    @php
                                        $types = ['Update', 'Message', 'Offer', 'Alert', 'Notice', 'News', 'Other'];
                                    @endphp
                                    @foreach ($types as $type)
                                        <div class="type-checkbox-item d-flex align-items-center justify-content-center gap-2"
                                            data-type="{{ $type }}">
                                            <input type="checkbox" name="types[]" value="{{ $type }}">
                                            <span>{{ $type }}</span>
                                            <span class="check-mark">✔</span>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="text" id="otherTypeInput" name="other_type" class="form-control mt-2"
                                    placeholder="{{ __('Specify type') }}" style="display:none;">
                                    @error('types')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                            </div>

                            <hr class="my-4">

                            {{-- Select Users --}}
                            <div class="mb-4">
                                <h6 class="mb-3">{{ __('Select Users') }}<span class="text-danger">*</span></h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-bold mb-3 text-secondary"
                                        for="selectAll">{{ __('Select All Users') }}</label>
                                </div>

                                <div class="user-list-grid" id="userList">
                                    @foreach ($users as $user)
                                        <div class="user-checkbox-item" data-user-id="{{ $user->id }}">
                                            <label>{{ $user->name }}</label>
                                            <span class="check-mark">✔</span>
                                            <input type="checkbox" name="users[]" value="{{ $user->id }}">
                                        </div>
                                    @endforeach
                                </div>
                                @error('users')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <x-update-button :title="'Send Announcement'" :icon="'fas fa-paper-plane'"></x-update-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .card-header-custom {
            border-bottom: 1px solid #dee2e6;
        }

        .user-list-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            max-height: 300px;
            overflow-y: auto;
            padding: 5px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #fff;
        }

        .user-checkbox-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4px 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #f8f9fa;
            font-size: 0.75rem;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .user-checkbox-item input[type="checkbox"] {
            display: none;
        }

        .user-checkbox-item .check-mark {
            display: none;
            color: #0d6efd;
            font-weight: bold;
        }

        .user-checkbox-item.selected {
            background-color: #e9ecef;
            border-color: #0d6efd;
        }

        .user-checkbox-item.selected .check-mark {
            display: inline;
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
        }

        .type-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 8px;
        }

        .type-checkbox-item {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-size: 0.85rem;
            position: relative;
        }

        .type-checkbox-item input[type="checkbox"] {
            display: none;
        }

        .type-checkbox-item .check-mark {
            display: none;
            position: absolute;
            right: 8px;
            color: #0d6efd;
            font-weight: bold;
        }

        .type-checkbox-item.selected .check-mark {
            display: inline;
        }

        #otherTypeInput {
            display: none;
            margin-top: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All Users
            const selectAllCheckbox = document.getElementById('selectAll');
            const userItems = document.querySelectorAll('.user-checkbox-item');

            selectAllCheckbox.addEventListener('change', function() {
                const checked = this.checked;
                userItems.forEach(item => {
                    const cb = item.querySelector('input[type="checkbox"]');
                    cb.checked = checked;
                    item.classList.toggle('selected', checked);
                });
            });

            // Individual user toggle
            userItems.forEach(item => {
                const cb = item.querySelector('input[type="checkbox"]');
                item.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'INPUT') {
                        cb.checked = !cb.checked;
                    }
                    item.classList.toggle('selected', cb.checked);
                });
            });

            // Type selection (only 1 allowed)
            const typeItems = document.querySelectorAll('.type-checkbox-item');
            const otherTypeInput = document.getElementById('otherTypeInput');

            typeItems.forEach(item => {
                const cb = item.querySelector('input[type="checkbox"]');
                item.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'INPUT') cb.checked = true;

                    typeItems.forEach(i => {
                        if (i !== item) {
                            i.classList.remove('selected');
                            i.querySelector('input[type="checkbox"]').checked = false;
                        }
                    });

                    item.classList.add('selected');

                    if (item.dataset.type === 'Other') {
                        otherTypeInput.style.display = 'block';
                    } else {
                        otherTypeInput.style.display = 'none';
                        otherTypeInput.value = '';
                    }
                });
            });
        });
    </script>
@endpush
