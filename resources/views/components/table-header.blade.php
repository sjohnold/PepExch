{{-- resources/views/components/table-header.blade.php --}}

<div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded shadow-sm"
    style="background: linear-gradient(135deg, #46262a 0%, #16181c 100%);">

    {{-- Title Section --}}
    <div class="d-flex flex-column">
        <h3 class="fw-bold text-white mb-1 d-flex align-items-center">
            @if ($icon)
                <i class="{{ $icon }} me-2" style="font-size: 20px;"></i>
            @endif
            {{ $title }}
        </h3>

        <p class="text-white-50 small mb-0">
            {{ __($subtitle) }}
        </p>
    </div>

    {{-- Right Side Controls --}}
    <div class="d-flex justify-content-between align-items-center gap-3">

        {{-- Per Page Selector --}}
        @if ($showPerPage)
            <div class="d-flex align-items-center gap-2">
                <label class="text-white small mb-0">{{ __('Show') }}:</label>
                <select class="form-select form-select-sm" style="width: 80px; height: 35px;"
                    onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page', 10) == 30 ? 'selected' : '' }}>30</option>
                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ request('per_page', 10) == 200 ? 'selected' : '' }}>200</option>
                </select>
            </div>
        @endif


        {{-- Download Report Button --}}
        @if ($showDownload)
            <div class="btn-group" style="position: relative;">

                <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="dropdown"
                    aria-expanded="false" style="height: 40px; border: none; border-radius: 8px; font-size: 15px; background: #437177;">
                    <i class="fas fa-download"></i>
                    {{ __('Export Report') }}
                </button>

                {{-- Dropdown Menu --}}
                <ul class="dropdown-menu dropdown-menu-end p-0 overflow-visible report-dropdown-padding"
                    style="min-width: 340px; border: none; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.18); z-index: 9999;"
                    onclick="event.stopPropagation()">

                    {{-- Dropdown Header --}}
                    <li>
                        <div class="px-4 pt-4 pb-2">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-file-export" style="color: #46262a; font-size: 18px;"></i>
                                <span class="fw-bold"
                                    style="font-size: 17px; color: #1e1e1e;">{{ __('Export Report') }}</span>
                            </div>
                            <p class="mb-0" style="font-size: 13px; color: #6c757d;">
                                {{ __('Choose format and date range') }}</p>
                        </div>
                    </li>

                    {{-- Divider --}}
                    <li>
                        <hr class="dropdown-divider my-1" style="border-color: #eee;">
                    </li>

                    {{-- Export Format Selection --}}
                    <li>
                        <div class="px-4 py-2">
                            <label class="fw-semibold mb-2 d-block"
                                style="font-size: 13px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Format') }}</label>

                            <div class="d-flex gap-3">

                                {{-- PDF Option --}}
                                <label
                                    class="d-flex align-items-center gap-2 px-3 py-2 rounded-2 cursor-pointer flex-grow-1"
                                    style="border: 2px solid #dee2e6; background: #fff; cursor: pointer; transition: all 0.2s ease;"
                                    onmouseover="this.style.borderColor='#46262a'; this.style.background='#faf8f8';"
                                    onmouseout="if(!this.querySelector('input').checked){ this.style.borderColor='#dee2e6'; this.style.background='#fff'; }">
                                    <input class="form-check-input m-0" type="radio" name="export_format"
                                        id="formatPDF" value="pdf" checked
                                        style="width: 18px; height: 18px; accent-color: #46262a;"
                                        onchange="updateFormatStyles()">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 18px;"></i>
                                        <span class="pdf-dark-theme" style="font-size: 15px; font-weight: 600; color: #1e1e1e;">PDF</span>
                                    </div>
                                </label>

                                {{-- CSV Option --}}
                                <label
                                    class="d-flex align-items-center gap-2 px-3 py-2 rounded-2 cursor-pointer flex-grow-1"
                                    style="border: 2px solid #dee2e6; background: #fff; cursor: pointer; transition: all 0.2s ease;"
                                    onmouseover="this.style.borderColor='#46262a'; this.style.background='#faf8f8';"
                                    onmouseout="if(!this.querySelector('input').checked){ this.style.borderColor='#dee2e6'; this.style.background='#fff'; }">
                                    <input class="form-check-input m-0" type="radio" name="export_format"
                                        id="formatCSV" value="csv"
                                        style="width: 18px; height: 18px; accent-color: #46262a;"
                                        onchange="updateFormatStyles()">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-file-csv" style="color: #198754; font-size: 18px;"></i>
                                        <span class="pdf-dark-theme" style="font-size: 15px; font-weight: 600; color: #1e1e1e;">CSV</span>
                                    </div>
                                </label>

                            </div>
                        </div>
                    </li>

                    {{-- Divider --}}
                    <li>
                        <hr class="dropdown-divider my-1" style="border-color: #eee;">
                    </li>

                    {{-- Date Range Selection --}}
                    <select class="form-select" id="dateRangeSelect" onchange="handleDateRangeChange()">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last_7_days">Last 7 Days</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="custom">Custom Range</option>
                    </select>

                    {{-- Custom Date Range Inputs --}}
                    <li id="customDateRange" style="display: none;">
                        <div class="px-4 py-1">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label mb-1"
                                        style="font-size: 13px; color: #6c757d;">{{ __('From') }}</label>
                                    <input type="date" class="form-control" id="startDate"
                                        style="font-size: 14px; height: 38px; border: 2px solid #dee2e6; border-radius: 8px;">
                                </div>
                                <div class="col-6">
                                    <label class="form-label mb-1"
                                        style="font-size: 13px; color: #6c757d;">{{ __('To') }}</label>
                                    <input type="date" class="form-control" id="endDate"
                                        style="font-size: 14px; height: 38px; border: 2px solid #dee2e6; border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Divider --}}
                    <li>
                        <hr class="dropdown-divider my-1" style="border-color: #eee;">
                    </li>

                    {{-- Generate Report Button --}}
                    <li>
                        <div class="px-4 py-3">
                            <button
                                class="btn w-100 text-white fw-semibold d-flex align-items-center justify-content-center gap-2"
                                onclick="startDownload('{{ $downloadRoute }}')"
                                style="height: 42px; border: none; border-radius: 8px; font-size: 15px; background: linear-gradient(135deg, #46262a 0%, #16181c 100%); transition: opacity 0.2s;"
                                onmouseover="this.style.opacity='0.85';" onmouseout="this.style.opacity='1';">
                                <i class="fas fa-download"></i> {{ __('Generate Report') }}
                            </button>
                        </div>
                    </li>

                </ul>
            </div>
        @endif

        {{-- Optional Add Button --}}
        @if ($buttonText && $buttonRoute)
            @can($buttonPermission)
                <a href="{{ $buttonRoute }}"
                    class="btn btn-light border text-success fw-semibold d-flex align-items-center" style="gap:4px;">
                    <i class="{{ $buttonIcon ?? 'bi bi-plus-lg' }}"></i>
                    {{ $buttonText }}
                </a>
            @endcan
        @endif

        {{-- Search Bar --}}
        @if ($showSearch)
            <div class="d-flex justify-content-end">
                <form action="{{ $searchAction }}" method="GET">
                    <div class="input-group shadow-sm" style="width:300px;">
                        <input type="text" name="{{ $searchName }}" value="{{ $searchValue }}"
                            class="form-control px-3 py-0" placeholder="{{ __('Search...') }}"
                            style="background: #f8f9fa; border: 1px solid #dee2e6; height: 40px;">

                        <button type="submit" class="btn px-4 header-search-admin"
                            style="background: linear-gradient(135deg, #46262a 0%, #16181c 100%);
                                       color: white;
                                       border: 1px solid #46262a; z-index:0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

{{-- JavaScript Functions --}}
<script>
    function changePerPage(perPageValue) {
        let currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', perPageValue);
        window.location.href = currentUrl.toString();
    }

    function handleDateRangeChange() {
        let selectedRange = document.getElementById('dateRangeSelect').value;
        let customDiv = document.getElementById('customDateRange');

        if (selectedRange == 'custom') {
            customDiv.style.display = 'block';
        } else {
            customDiv.style.display = 'none';
        }
    }

    // Format card border highlight on select
    function updateFormatStyles() {
        document.querySelectorAll('input[name="export_format"]').forEach(function(radio) {
            let card = radio.closest('label');
            if (radio.checked) {
                card.style.borderColor = '#46262a';
                card.style.background = '#faf8f8';
            } else {
                card.style.borderColor = '#dee2e6';
                card.style.background = '#fff';
            }
        });
    }

    // Init format card on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateFormatStyles();
    });

    function startDownload(downloadRoute) {
        let selectedFormat = document.querySelector('input[name="export_format"]:checked').value;
        let selectedRange = document.getElementById('dateRangeSelect').value;
        let downloadUrl = downloadRoute + '?format=' + selectedFormat + '&range=' + selectedRange;

        if (selectedRange === 'custom') {
            let startDate = document.getElementById('startDate').value;
            let endDate = document.getElementById('endDate').value;

            if (!startDate || !endDate) {
                alert('Please select both start and end dates');
                return;
            }

            downloadUrl += '&start_date=' + startDate + '&end_date=' + endDate;
        }

        window.location.href = downloadUrl;
    }
</script>
