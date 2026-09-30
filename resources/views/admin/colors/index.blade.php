@extends('layouts.app')

@section('content')
    <x-table-header :title="'Colors'" :subtitle="'Manage All Colors'" :icon="'bi bi-folder'" :buttonText="'Add New Colors'" :buttonRoute="route('colors.create')" />


    {{-- Colors Table --}}
    <div class="ride-summary" data-bg-color="#fff">
        <h3 class="tp-summary-title">Colors <span>(Latest)</span></h3>
        <div class="ride-table-wrapper" style="overflow-x:auto;">
            <table class="ride-table" style="min-width: 700px;">
                <thead style="background-color: #f8f9fa !important; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:30px;">
                            #
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Name') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:100px;">
                            {{ __('Color') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:100px;">
                            {{ __('Code') }}
                        </th>

                        <th class="fw-semibold text-muted py-3 px-4 text-center" style="font-size: 0.875rem; width:150px;">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($colors as $color)
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle text-truncate" title="{{ $color->name }}">
                                {{ $color->name }}
                            </td>

                            <td class="align-middle">
                                <div
                                    style="width: 40px; height: 25px; background-color: {{ $color->code }}; border-radius: 5px; margin:auto;">
                                </div>
                            </td>

                            <td class="align-middle text-truncate" title="{{ $color->code }}">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span id="color-code-{{ $color->id }}">{{ $color->code }}</span>
                                    <button type="button" class="tp-btn-action btn-sm"
                                        onclick="copyColor('{{ $color->id }}')" title="Copy">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- View --}}
                                    <x-table-action :route="route('colors.show', $color->id)" :text="'View'" :icon="'far fa-eye'" :bgColor="'#60363b'"
                                        :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    {{-- Edit --}}

                                    <x-table-action :route="route('colors.edit', $color->id)" :text="'Edit'" :icon="'fas fa-edit'"
                                        :bgColor="'#023066'" :hoverShadow="'0 4px 12px rgba(72, 150, 137, 0.4)'" />

                                    {{-- Delete --}}

                                    <x-table-action :route="route('colors.destroy', $color->id)" :text="'Delete'" :icon="'fas fa-trash'"
                                        :bgColor="'#dc3545'" :hoverShadow="'0 4px 12px rgba(220, 53, 69, 0.4)'" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">{{ __('No colors found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mb-4 mt-5 px-3">
        {{ $colors->links() }}
    </div>



    {{-- Copy Color Script --}}
    <script>
        function copyColor(id) {
            const colorCode = document.getElementById('color-code-' + id).innerText;
            navigator.clipboard.writeText(colorCode).then(() => {
                alert('Color copied!'); // simple alert, no SweetAlert
            });
        }
    </script>
@endsection
