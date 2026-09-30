@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    @php
        $title = $page?->name;
    @endphp

    <x-table-header :title="$title" :subtitle="'Edit and manage your page content'" :icon="'bi bi-folder'" />

    {{-- Editor Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <form action="{{ route('pages.update', $page?->section) }}" method="POST">
                @csrf

                <div class="p-4 p-lg-5">
                    <!-- Title Field -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-3" style="font-size: 0.95rem;">
                            <i class="fas fa-heading me-2 text-muted"></i>{{ __('Page Title') }}
                        </label>
                        <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm"
                            placeholder="{{ __('Enter page title') }}" name="title" value="{{ $page->data[0]?->title }}"
                            style="padding: 0.8rem 1.2rem; font-size: 1rem; border-color: #e9ecef;">
                    </div>

                    <!-- Content Field -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-3" style="font-size: 0.95rem;">
                            <i class="fas fa-align-left me-2 text-muted"></i>{{ __('Page Content') }}
                        </label>
                        <div class="border-2 rounded-3 overflow-hidden shadow-sm" style="border-color: #e9ecef;">
                            <textarea class="form-control border-0" id="summernote" name="description" rows="20"
                                placeholder="{{ __('Write your content here...') }}" style="resize: none;">{!! $page->data[0]?->description !!}</textarea>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>{{ __('Use the editor toolbar to format your content') }}
                        </small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="text-muted small">
                            <i class="fas fa-clock me-1"></i>
                        </div>
                        <button type="submit" class="btn btn-lg shadow-sm text-white fw-semibold"
                            style="background: linear-gradient(135deg, #60363b 0%, #1f242c 100%); border: none; border-radius: 8px; padding: 0.7rem 2rem; transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(96, 54, 59, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">
                            <i class="fas fa-save me-2"></i>{{ __('Update') }} {{ $page?->name }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="alert alert-light border-0 shadow-sm mt-4 rounded-3" style="background-color: #f8f9fa;">
        <div class="d-flex align-items-start">
            <i class="fas fa-lightbulb text-warning me-3 mt-1" style="font-size: 1.3rem;"></i>
            <div>
                <h6 class="fw-bold mb-2">{{ __('Tips for better content') }}</h6>
                <ul class="mb-0 small text-muted ps-3">
                    <li>{{ __('Keep your content clear and concise') }}</li>
                    <li>{{ __('Use headings and paragraphs to organize information') }}</li>
                    <li>{{ __('Preview your changes before saving') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: '{{ __('Write your content here...') }}',
                height: 400,
                minHeight: 300,
                maxHeight: 600,
                focus: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        $('.note-editable').css({
                            'background-color': '#ffffff',
                            'color': '#212529'
                        });
                    }
                }
            });
        });
    </script>
@endpush
