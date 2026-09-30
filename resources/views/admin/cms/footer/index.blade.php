@extends('layouts.app')

@section('content')
    <x-table-header :title="'Footer Organizer'" :subtitle="'Dynamically Manage all Footer Settings'" :icon="'bi bi-building'" />

    <div class="row g-4 mt-3">
        {{-- Footer Logo --}}
        <div class="col-md-4">
            <form action="{{ route('general-settings.update.footerlogo') }}" method="POST" enctype="multipart/form-data"
                class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                @csrf
                @method('PUT')

                <div class="card-body p-3 d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                            <i class="fas fa-image text-warning" style="font-size: 1rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-0 small">{{ __('Footer Logo') }}</h6>
                    </div>

                    <div class="d-flex flex-column mb-2 flex-grow-1">
                        <div class="border border-secondary border-opacity-25 rounded-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center mb-2"
                            style="width: 100%; height: 120px; background: transparent;">
                            <img id="footerlogo-preview"
                                src="{{ $footerLogoUrl ? $footerLogoUrl : 'https://placehold.jp/250x250.png' }}"
                                alt="Footer Logo" class="img-fluid"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>

                        <div class="text-start">
                            <label for="footerlogo_input" class="form-label fw-medium text-dark mb-1 d-block"
                                style="font-size: 0.85rem;">
                                {{ $footerLogoUrl ? 'Change Footer Logo' : 'Upload Footer Logo' }}
                            </label>
                            <p class="small text-muted mb-0" style="font-size: 0.75rem;">PNG, JPG, SVG</p>
                        </div>
                    </div>

                    @error('footerlogo')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <input type="file" class="form-control form-control-sm border rounded-3" id="footerlogo_input"
                            name="footerlogo" accept="image/png,image/jpeg,image/svg+xml" style="padding: 18px !important">
                    </div>

                    <div class="text-start mt-auto">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" small />
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer Subtitle & Copyright --}}
        <div class="col-md-8">
            <form action="{{ route('cms-footer.update-subtite') }}" method="POST"
                class="card border-0 shadow-sm rounded-4 h-100" style="background-color: rgb(252, 252, 252);">
                @csrf

                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="mb-2 fw-bold small">{{ __('Footer Content') }}</h6>

                    <div class="flex-grow-1">
                        <div class="row g-2">
                            <div class="col-12">
                                <label for="footer_subtitle" class="form-label fw-medium mb-1"
                                    style="font-size: 0.85rem;">Footer Subtitle</label>
                                <textarea name="footer_subtitle" id="footer_subtitle" rows="3"
                                    class="form-control form-control-sm rounded-3 border-secondary-subtle" placeholder="Write footer subtitle...">{{ $footerSubtitle ?? '' }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="footer_copyright" class="form-label fw-medium mb-1"
                                    style="font-size: 0.85rem;">Footer Copyright</label>
                                <input type="text" name="footer_copyright" id="footer_copyright"
                                    class="form-control form-control-sm rounded-3 border-secondary-subtle"
                                    placeholder="© 2026 Your Company" value="{{ $footerCopyright ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-auto pt-2">
                        <x-update-button :title="'Update'" :icon="'fas fa-save'" small />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Social Links --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mt-4" style="background-color: rgb(252, 252, 252);">
        <h6 class="fw-bold mb-3 text-muted small">{{ __('Social Links') }}</h6>

        <form action="{{ route('cms-footer.update-social') }}" method="POST">
            @csrf

            <div id="social-links-container" class="links-list">
                @if (count($socialLinksData) > 0)
                    @foreach ($socialLinksData as $index => $link)
                        <div class="link-row">
                            <span class="row-num">#{{ $index + 1 }}</span>

                            <div class="icon-selector">
                                <button type="button" class="selected-icon" onclick="toggleIconDropdown(this)">
                                    <i class="fab fa-{{ $link['icon'] ?? 'facebook' }}"></i>
                                </button>
                                <input type="hidden" name="social_links[{{ $index }}][icon]"
                                    value="{{ $link['icon'] ?? 'facebook' }}" class="icon-value">

                                <div class="icon-dropdown">
                                    <div class="icon-option" data-icon="facebook" onclick="selectIcon(this)">
                                        <i class="fab fa-facebook"></i>
                                    </div>
                                    <div class="icon-option" data-icon="twitter" onclick="selectIcon(this)">
                                        <i class="fab fa-twitter"></i>
                                    </div>
                                    <div class="icon-option" data-icon="instagram" onclick="selectIcon(this)">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <div class="icon-option" data-icon="linkedin" onclick="selectIcon(this)">
                                        <i class="fab fa-linkedin"></i>
                                    </div>
                                    <div class="icon-option" data-icon="youtube" onclick="selectIcon(this)">
                                        <i class="fab fa-youtube"></i>
                                    </div>
                                    <div class="icon-option" data-icon="github" onclick="selectIcon(this)">
                                        <i class="fab fa-github"></i>
                                    </div>
                                    <div class="icon-option" data-icon="whatsapp" onclick="selectIcon(this)">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="icon-option" data-icon="telegram" onclick="selectIcon(this)">
                                        <i class="fab fa-telegram"></i>
                                    </div>
                                    <div class="icon-option" data-icon="tiktok" onclick="selectIcon(this)">
                                        <i class="fab fa-tiktok"></i>
                                    </div>
                                    <div class="icon-option" data-icon="pinterest" onclick="selectIcon(this)">
                                        <i class="fab fa-pinterest"></i>
                                    </div>
                                </div>
                            </div>

                            <input type="text" name="social_links[{{ $index }}][label]" class="input-box"
                                placeholder="label" value="{{ $link['label'] ?? '' }}">

                            <input type="url" name="social_links[{{ $index }}][url]"
                                class="input-box input-url" placeholder="url" value="{{ $link['url'] ?? '' }}">

                            <button type="button" class="remove-btn" onclick="removeRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="link-row">
                        <span class="row-num">#1</span>

                        <div class="icon-selector">
                            <button type="button" class="selected-icon" onclick="toggleIconDropdown(this)">
                                <i class="fab fa-facebook"></i>
                            </button>
                            <input type="hidden" name="social_links[0][icon]" value="facebook" class="icon-value">

                            <div class="icon-dropdown">
                                <div class="icon-option" data-icon="facebook" onclick="selectIcon(this)">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <div class="icon-option" data-icon="twitter" onclick="selectIcon(this)">
                                    <i class="fab fa-twitter"></i>
                                </div>
                                <div class="icon-option" data-icon="instagram" onclick="selectIcon(this)">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <div class="icon-option" data-icon="linkedin" onclick="selectIcon(this)">
                                    <i class="fab fa-linkedin"></i>
                                </div>
                                <div class="icon-option" data-icon="youtube" onclick="selectIcon(this)">
                                    <i class="fab fa-youtube"></i>
                                </div>
                                <div class="icon-option" data-icon="github" onclick="selectIcon(this)">
                                    <i class="fab fa-github"></i>
                                </div>
                                <div class="icon-option" data-icon="whatsapp" onclick="selectIcon(this)">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="icon-option" data-icon="telegram" onclick="selectIcon(this)">
                                    <i class="fab fa-telegram"></i>
                                </div>
                                <div class="icon-option" data-icon="tiktok" onclick="selectIcon(this)">
                                    <i class="fab fa-tiktok"></i>
                                </div>
                                <div class="icon-option" data-icon="pinterest" onclick="selectIcon(this)">
                                    <i class="fab fa-pinterest"></i>
                                </div>
                            </div>
                        </div>

                        <input type="text" name="social_links[0][label]" class="input-box" placeholder="label">
                        <input type="url" name="social_links[0][url]" class="input-box input-url" placeholder="url">

                        <button type="button" class="remove-btn" onclick="removeRow(this)" style="display:none;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>

            <div class="button-area">
                <button type="button" id="add-link-btn" class="btn btn-add-link btn-sm">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Link') }}
                </button>

                <button type="submit" class="btn btn-save-primary btn-sm">
                    <i class="fas fa-check me-1"></i> {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Footer Menu Cards with Drag & Drop --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-light mt-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-muted mb-0 small">{{ __('Footer Menu Management') }} </h6>
            <button type="button" class="btn btn-sm btn-outline-danger btn-reset" id="reset-menu-btn">
                <i class="fas fa-undo me-1"></i> {{ __('Back to Default') }}
            </button>
        </div>

        <div class="row g-3" id="sortable-footer-cards">
            @foreach ($footerMenuCards as $card)
                <div class="col-md-3" data-card-id="{{ $card['id'] }}">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-3">
                            {{-- Card Header --}}
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-grip-vertical text-muted me-2 drag-handle-icon"></i>
                                    <h6 class="fw-bold text-muted mb-0" style="font-size: 0.85rem;">{{ $card['label'] }}
                                    </h6>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input card-switch" type="checkbox" role="switch"
                                        {{ $card['is_active'] ? 'checked' : '' }} data-card-id="{{ $card['id'] }}">
                                </div>
                            </div>

                            {{-- Sortable Items --}}
                            <div class="sortable-items" data-card-id="{{ $card['id'] }}"
                                data-protected="{{ $card['id'] === 'footer-info' ? 'true' : 'false' }}">
                                @if ($card['id'] === 'footer-info')
                                    {{-- Footer Info Items --}}
                                    @foreach ($card['items'] as $item)
                                        <div class="item-row mb-2" data-item-id="{{ $item['id'] }}">
                                            <div class="d-flex align-items-start gap-2">
                                                <i class="fas fa-grip-vertical text-muted mt-2 drag-handle-item"></i>
                                                <div class="flex-grow-1">
                                                    @if ($item['id'] === 'address')
                                                        <textarea id="footer_address" class="form-control footer-info-input" rows="2" placeholder="enter address">{{ $address ?? '' }}</textarea>
                                                    @elseif($item['id'] === 'support_mail')
                                                        <input type="email" id="footer_support_mail"
                                                            class="form-control footer-info-input"
                                                            value="{{ $supportMail ?? '' }}" placeholder="support email">
                                                    @elseif($item['id'] === 'support_contact')
                                                        <div class="d-flex gap-2">
                                                            <select id="footer_country_code"
                                                                class="form-select country-code-select footer-info-input">
                                                                @php
                                                                    $countryCodes = [
                                                                        '+880' => '🇧🇩 +880',
                                                                        '+1' => '🇺🇸 +1',
                                                                        '+44' => '🇬🇧 +44',
                                                                        '+91' => '🇮🇳 +91',
                                                                        '+86' => '🇨🇳 +86',
                                                                        '+81' => '🇯🇵 +81',
                                                                        '+82' => '🇰🇷 +82',
                                                                        '+92' => '🇵🇰 +92',
                                                                        '+62' => '🇮🇩 +62',
                                                                        '+60' => '🇲🇾 +60',
                                                                        '+65' => '🇸🇬 +65',
                                                                        '+66' => '🇹🇭 +66',
                                                                        '+84' => '🇻🇳 +84',
                                                                        '+63' => '🇵🇭 +63',
                                                                        '+971' => '🇦🇪 +971',
                                                                        '+966' => '🇸🇦 +966',
                                                                    ];

                                                                    $fullContact = $supportContact ?? '';
                                                                    $selectedCode = '+880';
                                                                    $phoneNumber = '';

                                                                    foreach (array_keys($countryCodes) as $code) {
                                                                        if (str_starts_with($fullContact, $code)) {
                                                                            $selectedCode = $code;
                                                                            $phoneNumber = substr(
                                                                                $fullContact,
                                                                                strlen($code),
                                                                            );
                                                                            break;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @foreach ($countryCodes as $code => $label)
                                                                    <option value="{{ $code }}"
                                                                        {{ $selectedCode === $code ? 'selected' : '' }}>
                                                                        {{ $label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="text" id="footer_support_contact"
                                                                class="form-control footer-info-input flex-grow-1"
                                                                value="{{ $phoneNumber }}" placeholder="phone number">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light dropdown-toggle-icon"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <div
                                                                class="dropdown-item d-flex align-items-center justify-content-between">
                                                                <span class="small">{{ __('Active') }}</span>
                                                                <div class="form-check form-switch ms-2">
                                                                    <input class="form-check-input item-switch"
                                                                        type="checkbox"
                                                                        {{ $item['is_active'] ? 'checked' : '' }}
                                                                        data-item-id="{{ $item['id'] }}">
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Submit Button for Footer Info --}}
                                    <button type="button" class="btn btn-update-info btn-sm w-100 mt-3"
                                        id="update-footer-info-btn">
                                        <i class="fas fa-save me-1"></i> {{ __('Update Info') }}
                                    </button>
                                @else
                                    {{-- Other Cards - URL in Dropdown Menu --}}
                                    @foreach ($card['items'] as $item)
                                        <div class="item-row mb-2" data-item-id="{{ $item['id'] }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-grip-vertical text-muted drag-handle-item"></i>
                                                <input type="text" class="form-control flex-grow-1 item-label-input"
                                                    value="{{ $item['label'] }}" placeholder="item label">

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light dropdown-toggle-icon"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-wide">
                                                        <li>
                                                            <div
                                                                class="dropdown-item d-flex align-items-center justify-content-between">
                                                                <span class="small">Active</span>
                                                                <div class="form-check form-switch ms-2">
                                                                    <input class="form-check-input item-switch"
                                                                        type="checkbox"
                                                                        {{ $item['is_active'] ? 'checked' : '' }}
                                                                        data-item-id="{{ $item['id'] }}">
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        {{--  URL Field in Dropdown --}}
                                                        <li class="px-3 py-2">
                                                            <label class="small text-muted mb-1 d-block">custom
                                                                url:</label>
                                                            <input type="text"
                                                                class="form-control form-control-sm item-url-input"
                                                                value="{{ $item['url'] ?? '' }}"
                                                                placeholder="https://example.com"
                                                                data-item-id="{{ $item['id'] }}">
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                onclick="deleteItem(this)">
                                                                <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <button type="button" class="btn btn-add-item btn-sm w-100 mt-3 add-item-btn"
                                        data-card-id="{{ $card['id'] }}" onclick="addNewItem(this)">
                                        <i class="fas fa-plus me-1"></i> {{ __('Add Item') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-end mt-4">
            <button type="button" class="btn btn-save-menu btn-sm" id="save-menu-btn">
                <i class="fas fa-save me-1"></i> {{ __('Save Menu Order') }}
            </button>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Image Preview
        (function() {
            const input = document.getElementById('footerlogo_input');
            const preview = document.getElementById('footerlogo-preview');
            if (input) {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;
                    if (!['image/png', 'image/jpeg', 'image/svg+xml'].includes(file.type) || file.size > 2 *
                        1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File',
                            text: 'Use PNG, JPEG, SVG under 2MB',
                            confirmButtonText: 'OK'
                        });
                        this.value = '';
                        preview.src = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => preview.src = e.target.result;
                    reader.readAsDataURL(file);
                });
            }
        })();

        // Social Links
        (function() {
            let rowNumber = document.querySelectorAll('.link-row').length;

            document.getElementById('add-link-btn').addEventListener('click', function() {
                const container = document.getElementById('social-links-container');
                const row = document.createElement('div');
                row.className = 'link-row new';
                row.innerHTML = `
                    <span class="row-num">#${rowNumber + 1}</span>
                    <div class="icon-selector">
                        <button type="button" class="selected-icon" onclick="toggleIconDropdown(this)">
                            <i class="fab fa-facebook"></i>
                        </button>
                        <input type="hidden" name="social_links[${rowNumber}][icon]" value="facebook" class="icon-value">
                        <div class="icon-dropdown">
                            <div class="icon-option" data-icon="facebook" onclick="selectIcon(this)"><i class="fab fa-facebook"></i></div>
                            <div class="icon-option" data-icon="twitter" onclick="selectIcon(this)"><i class="fab fa-twitter"></i></div>
                            <div class="icon-option" data-icon="instagram" onclick="selectIcon(this)"><i class="fab fa-instagram"></i></div>
                            <div class="icon-option" data-icon="linkedin" onclick="selectIcon(this)"><i class="fab fa-linkedin"></i></div>
                            <div class="icon-option" data-icon="youtube" onclick="selectIcon(this)"><i class="fab fa-youtube"></i></div>
                            <div class="icon-option" data-icon="github" onclick="selectIcon(this)"><i class="fab fa-github"></i></div>
                            <div class="icon-option" data-icon="whatsapp" onclick="selectIcon(this)"><i class="fab fa-whatsapp"></i></div>
                            <div class="icon-option" data-icon="telegram" onclick="selectIcon(this)"><i class="fab fa-telegram"></i></div>
                            <div class="icon-option" data-icon="tiktok" onclick="selectIcon(this)"><i class="fab fa-tiktok"></i></div>
                            <div class="icon-option" data-icon="pinterest" onclick="selectIcon(this)"><i class="fab fa-pinterest"></i></div>
                        </div>
                    </div>
                    <input type="text" name="social_links[${rowNumber}][label]" class="input-box" placeholder="label">
                    <input type="url" name="social_links[${rowNumber}][url]" class="input-box input-url" placeholder="url">
                    <button type="button" class="remove-btn" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                `;
                container.appendChild(row);
                rowNumber++;
                updateRowIndexes();
                showHideRemoveButtons();
            });

            window.toggleIconDropdown = function(button) {
                const dropdown = button.nextElementSibling.nextElementSibling;
                document.querySelectorAll('.icon-dropdown').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });
                dropdown.classList.toggle('show');
            };

            window.selectIcon = function(option) {
                const selector = option.closest('.icon-selector');
                selector.querySelector('.selected-icon i').className = option.querySelector('i').className;
                selector.querySelector('.icon-value').value = option.getAttribute('data-icon');
                selector.querySelector('.icon-dropdown').classList.remove('show');
            };

            window.removeRow = function(button) {
                button.closest('.link-row').remove();
                updateRowIndexes();
                showHideRemoveButtons();
            };

            function updateRowIndexes() {
                document.querySelectorAll('.link-row').forEach((row, index) => {
                    row.querySelector('.row-num').textContent = '#' + (index + 1);
                    row.querySelector('.icon-value').name = `social_links[${index}][icon]`;
                    row.querySelector('input[placeholder="label"]').name = `social_links[${index}][label]`;
                    row.querySelector('input[placeholder="url"]').name = `social_links[${index}][url]`;
                });
                rowNumber = document.querySelectorAll('.link-row').length;
            }

            function showHideRemoveButtons() {
                const count = document.querySelectorAll('.link-row').length;
                document.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.style.display = count > 1 ? 'block' : 'none';
                });
            }

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.icon-selector')) {
                    document.querySelectorAll('.icon-dropdown').forEach(d => d.classList.remove('show'));
                }
            });

            updateRowIndexes();
            showHideRemoveButtons();
        })();

        // Footer Menu Drag & Drop with SweetAlert
        (function() {
            if (typeof Sortable === 'undefined') {
                console.error('SortableJS not loaded');
                return;
            }

            const cardsContainer = document.getElementById('sortable-footer-cards');
            if (!cardsContainer) return;

            // Card Drag & Drop with SweetAlert
            Sortable.create(cardsContainer, {
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                handle: '.drag-handle-icon',
                draggable: '.col-md-3',
                onEnd: function(evt) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Card moved! Click "Save Menu Order" to update.',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                    });
                }
            });

            // Item Drag & Drop with SweetAlert
            document.querySelectorAll('.sortable-items').forEach(container => {
                const isProtected = container.getAttribute('data-protected') === 'true';

                Sortable.create(container, {
                    animation: 200,
                    ghostClass: 'sortable-ghost',
                    handle: '.drag-handle-item',
                    draggable: '.item-row',
                    group: isProtected ? 'footer-info-only' : 'shared-items',

                    onAdd: function(evt) {
                        const targetContainer = evt.to;
                        const isTargetProtected = targetContainer.getAttribute('data-protected') ===
                            'true';

                        if (isTargetProtected) {
                            evt.from.appendChild(evt.item);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Not Allowed!',
                                text: 'Cannot add items to Footer Information card.',
                                confirmButtonText: 'OK',
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Item moved! Click "Save Menu Order" to update.',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                            });
                        }
                    },

                    onEnd: function(evt) {
                        if (evt.from === evt.to) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: 'Item reordered! Click "Save Menu Order" to update.',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                            });
                        }
                    }
                });
            });

            //  Add New Item with URL field in dropdown
            window.addNewItem = function(button) {
                const cardId = button.getAttribute('data-card-id');
                const container = button.closest('.sortable-items');

                const itemId = 'item_' + Date.now();
                const itemDiv = document.createElement('div');
                itemDiv.className = 'item-row mb-2';
                itemDiv.setAttribute('data-item-id', itemId);
                itemDiv.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-grip-vertical text-muted drag-handle-item"></i>
                        <input type="text" class="form-control flex-grow-1 item-label-input" value="New Item" placeholder="item label">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle-icon" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-wide">
                                <li>
                                    <div class="dropdown-item d-flex align-items-center justify-content-between">
                                        <span class="small">Active</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input item-switch" type="checkbox" checked data-item-id="${itemId}">
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="px-3 py-2">
                                    <label class="small text-muted mb-1 d-block">custom url:</label>
                                    <input type="text" class="form-control form-control-sm item-url-input" value="" placeholder="https://example.com" data-item-id="${itemId}">
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteItem(this)">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                `;

                button.parentElement.insertBefore(itemDiv, button);

                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: 'Item added!',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            };

            window.deleteItem = function(button) {
                Swal.fire({
                    title: 'Delete this item?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('.item-row').remove();
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Item deleted!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            };

            //  Save Menu with URL collection
            document.getElementById('save-menu-btn').addEventListener('click', function() {
                const cards = [];
                let cardOrder = 1;

                document.querySelectorAll('#sortable-footer-cards > div').forEach(cardEl => {
                    const cardId = cardEl.getAttribute('data-card-id');
                    const cardSwitch = cardEl.querySelector('.card-switch');
                    const isCardActive = cardSwitch.checked;

                    const items = [];
                    let itemOrder = 1;

                    cardEl.querySelectorAll('.item-row').forEach(itemEl => {
                        const itemId = itemEl.getAttribute('data-item-id');
                        const itemSwitch = itemEl.querySelector('.item-switch');
                        const isItemActive = itemSwitch.checked;

                        let itemLabel = '';
                        const labelInput = itemEl.querySelector('.item-label-input');
                        if (labelInput) {
                            itemLabel = labelInput.value.trim();
                        } else {
                            itemLabel = itemId;
                        }

                        //  Collect URL from dropdown
                        let itemUrl = '';
                        const urlInput = itemEl.querySelector('.item-url-input');
                        if (urlInput) {
                            itemUrl = urlInput.value.trim();
                        }

                        items.push({
                            id: itemId,
                            label: itemLabel,
                            is_active: isItemActive,
                            order: itemOrder++,
                            url: itemUrl
                        });
                    });

                    const cardLabel = cardEl.querySelector('h6').textContent.trim();

                    cards.push({
                        id: cardId,
                        label: cardLabel,
                        is_active: isCardActive,
                        order: cardOrder++,
                        items: items
                    });
                });

                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait while we save your changes',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('cms-footer.update-menu-order') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cards: cards
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: 'Footer menu updated successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to save changes.',
                        });
                    });
            });

            document.getElementById('reset-menu-btn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Reset to Default?',
                    text: 'This will restore the footer menu to its original seeded state. All changes will be lost!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Reset!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Resetting...',
                            text: 'Please wait while we restore default settings',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Send reset request
                        fetch("{{ route('cms-footer.reset-menu') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Reset Complete!',
                                        text: data.message ||
                                            'Footer menu has been reset to default.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    throw new Error(data.message || 'Reset failed');
                                }
                            })
                            .catch(err => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: err.message || 'Failed to reset footer menu.',
                                });
                            });
                    }
                });
            });

            document.getElementById('update-footer-info-btn').addEventListener('click', function() {
                const address = document.getElementById('footer_address').value;
                const supportMail = document.getElementById('footer_support_mail').value;
                const countryCode = document.getElementById('footer_country_code').value;
                const supportContact = document.getElementById('footer_support_contact').value;

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('address', address);
                formData.append('support_mail', supportMail);
                formData.append('country_code', countryCode);
                formData.append('support_contact', supportContact);

                fetch("{{ route('cms-footer.update-footer-info') }}", {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: data.message || 'Footer information updated successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            throw new Error(data.message || 'Update failed');
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: err.message || 'Failed to update footer information.',
                        });
                    });
            });
        })();
    </script>
@endpush
