@extends('layouts.app')
@section('content')
    <div class="container-fluid banner-form-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <!-- Header Card -->
                <x-table-header :title="'Update Banner'" :subtitle="'Update banner information and images'" :icon="'bi bi-folder'" />

                <!-- Main Form Card -->
                <form action="{{ route('banners.update', $banner->id ?? 1) }}" method="POST" id="bannerForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-semibold">
                                <i class="bi bi-info-circle me-2 text-primary"></i>{{ __('Banner Details') }}
                            </h5>

                            <div class="row g-3">
                                <!-- Title -->
                                <div class="col-md-6">
                                    <label for="title" class="form-label fw-semibold">
                                        {{ __('Title') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title"
                                        class="form-control form-control-lg border-secondary-subtle @error('title') is-invalid @enderror"
                                        placeholder="{{ __('Enter banner title') }}"
                                        value="{{ old('title', $banner->title ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sub Title -->
                                <div class="col-md-6">
                                    <label for="sub_title" class="form-label fw-semibold">
                                        {{ __('Sub Title') }}
                                    </label>
                                    <input type="text" name="sub_title" id="sub_title"
                                        class="form-control form-control-lg border-secondary-subtle @error('sub_title') is-invalid @enderror"
                                        placeholder="{{ __('Enter sub title') }}"
                                        value="{{ old('sub_title', $banner->sub_title ?? '') }}">
                                    @error('sub_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-semibold">
                                        {{ __('Address') }}
                                    </label>
                                    <input type="text" name="address" id="address"
                                        class="form-control form-control-lg border-secondary-subtle @error('address') is-invalid @enderror"
                                        placeholder="{{ __('Enter address') }}"
                                        value="{{ old('address', $banner->address ?? '') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">
                                        {{ __('Description') }}
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                        class="form-control border-secondary-subtle @error('description') is-invalid @enderror"
                                        style="font-size: 20px !important;" placeholder="{{ __('Enter banner description') }}">{{ old('description', $banner->description ?? '') }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>





                    <!-- Images Section -->
                    <!-- Hidden container for real file inputs -->
                    <div id="realFileInputs" class="d-none"></div>

                    <!-- Hidden field for removed images -->
                    <input type="hidden" name="removed_images" id="removedImages" value="">

                    <div class="row g-3" id="imageGrid">
                        <!-- Upload Trigger -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="upload-trigger cursor-pointer d-block">
                                <div
                                    class="upload-box border-2 border-primary border-dashed rounded-3 bg-primary bg-opacity-10 d-flex flex-column align-items-center justify-content-center text-center p-4 h-100">
                                    <i class="bi bi-cloud-upload fs-1 text-primary mb-2"></i>
                                    <p class="mb-0 fw-semibold text-primary">{{ __('Select Images') }}</p>
                                    <small class="text-muted">{{ __('Up to 9 images') }}</small>
                                </div>
                                <input type="file" name="images[]" accept="image/*" multiple class="d-none temp-input">
                            </div>
                        </div>

                        <!-- Existing Images -->
                        @if (isset($banner) && $banner->thumbnails->count() > 0)
                            @foreach ($banner->thumbnails as $thumb)
                                <div class="col-6 col-md-4 col-lg-3 existing-image" data-id="{{ $thumb->id }}">
                                    <div class="position-relative">
                                        <div class="border rounded-3 overflow-hidden bg-white shadow-sm"
                                            style="height:180px;">
                                            <img src="{{ Storage::url($thumb->src) }}" class="w-100 h-100 object-fit-cover"
                                                alt="Banner Image">
                                        </div>
                                        <button type="button"
                                            class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-2 remove-existing"
                                            data-id="{{ $thumb->id }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="existing_images[]" value="{{ $thumb->id }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <x-update-button :title="'Update Banner'" :icon="'fas fa-save'" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            console.log('Clicked element:', e.target);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.querySelector('.upload-trigger');
            const tempInput = document.querySelector('.temp-input');
            const realContainer = document.getElementById('realFileInputs');
            const grid = document.getElementById('imageGrid');

            let totalImages = document.querySelectorAll('.existing-image').length;
            const MAX_IMAGES = 9;

            trigger.addEventListener('click', () => tempInput.click());

            tempInput.addEventListener('change', function() {
                const files = Array.from(this.files);
                const remaining = MAX_IMAGES - totalImages;

                if (files.length > remaining) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Too many images!',
                        text: `Maximum ${MAX_IMAGES} images allowed.`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                    this.value = '';
                    return;
                }

                files.forEach(file => {
                    const realInput = document.createElement('input');
                    realInput.type = 'file';
                    realInput.name = 'images[]';
                    realInput.classList.add('d-none');
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    realInput.files = dt.files;
                    realContainer.appendChild(realInput);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4 col-lg-3 new-image';
                        col.innerHTML = `
                    <div class="position-relative">
                        <div class="border rounded-3 overflow-hidden bg-white shadow-sm" style="height:180px;">
                            <img src="${e.target.result}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-2"
                                onclick="removeNewImage(this)">X</button>
                        <span class="badge bg-success position-absolute bottom-0 start-0 m-2">New</span>
                    </div>
                `;
                        grid.appendChild(col);
                        totalImages++;
                    };
                    reader.readAsDataURL(file);
                });
                this.value = '';
            });

            window.removeNewImage = function(button) {
                button.closest('.col-6,.col-md-4,.col-lg-3').remove();
                realContainer.removeChild(realContainer.lastChild);
                totalImages--;
            };

            // AJAX DELETE WITH AXIOS
            document.addEventListener('click', async function(e) {
                if (e.target.closest('.remove-existing')) {
                    e.preventDefault();

                    const btn = e.target.closest('.remove-existing');

                    const mediaId = btn.dataset.id;
                    const box = btn.closest('.existing-image');
                    const bannerId = "{{ $banner->id }}";

                    const result = await Swal.fire({
                        title: 'Remove this image?',
                        text: 'This will be deleted permanently!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger px-4 mx-2',
                            cancelButton: 'btn btn-secondary px-4 mx-2'
                        }
                    });

                    if (!result.isConfirmed) return;

                    // Loading state
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    try {
                        const response = await axios.post("{{ route('banners.remove-image') }}", {
                            banner_id: bannerId,
                            media_id: mediaId
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        // Success → remove from UI
                        box.remove();
                        totalImages--;

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.data.message || 'Image removed successfully',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            showConfirmButton: false
                        });

                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: error.response?.data?.message || 'Something went wrong',
                        });
                    }
                }
            });
        });
    </script>


    <style>
        .banner-form-wrapper .upload-box {
            height: 180px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .banner-form-wrapper .upload-box:hover {
            background-color: rgba(13, 110, 253, 0.15) !important;
        }

        .banner-form-wrapper .preview-image {
            height: 180px;
            object-fit: cover;
        }

        .banner-form-wrapper .remove-btn {
            width: 32px;
            height: 32px;
            padding: 0;
        }
    </style>
@endsection
