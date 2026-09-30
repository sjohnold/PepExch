<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Products Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #333;
            padding: 40px;
        }

        /* ── HEADER ── */
        .header {
            position: relative;
            text-align: center;
            margin-bottom: 28px;
        }

        .header .logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: auto;
        }

        .header h1 {
            color: #46262a;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header .line {
            width: 50px;
            height: 3px;
            background: #46262a;
            margin: 8px auto;
        }

        .header p {
            color: #888;
            font-size: 12px;
        }

        /* ── STATS ── */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e2e2;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 10px;
            background: #f9f9f9;
        }

        .stats-table td {
            padding: 10px 14px;
            border-right: 1px solid #e2e2e2;
            white-space: nowrap;
            font-size: 12px;
            color: #444;
        }

        .stats-table td:last-child {
            border-right: none;
        }

        .stats-table .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 7px;
            vertical-align: middle;
        }

        .stats-table .num {
            font-weight: 700;
            color: #46262a;
            margin-left: 5px;
        }

        /* ── INFO ── */
        .info {
            font-size: 11px;
            color: #888;
            margin-bottom: 20px;
            padding: 6px 0;
        }

        .info strong {
            color: #46262a;
        }

        /* ── MAIN TABLE ── */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e2e2;
            overflow: hidden;
        }

        .main-table thead {
            background: #46262a;
        }

        .main-table th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .main-table th:last-child {
            text-align: right;
        }

        .main-table td {
            padding: 9px 14px;
            font-size: 12px;
            border-bottom: 1px solid #eeeeee;
            color: #444;
        }

        .main-table td:last-child {
            text-align: right;
            color: #888;
        }

        .main-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .main-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: #e6f4ea;
            color: #2e7d32;
        }

        .badge-warning {
            background: #fef3e2;
            color: #e65100;
        }

        .badge-danger {
            background: #fce8e6;
            color: #c62828;
        }

        .badge-info {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge-dark {
            background: #e0e0e0;
            color: #424242;
        }

        /* ── NO DATA ── */
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 13px;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 22px;
            text-align: center;
            padding-top: 12px;
            border-top: 1px solid #e2e2e2;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>

<body>

    {{-- Header --}}
<div class="header">
    {{-- Logo Right Side --}}
    @if($applogo && $applogo->logo_url)
        @php
            $logoPath = str_replace(url('/') . '/', '', $applogo->logo_url);
        @endphp
        <img src="{{ public_path($logoPath) }}" alt="Logo" class="logo">
    @endif

    <h1>Products Report</h1>
    <div class="line"></div>
    <p>{{ $dateTitle }}</p>
</div>

    {{-- Stats --}}
    <table class="stats-table">
        <tr>
            <td><span class="dot" style="background:#46262a;"></span>Total<span class="num">{{ $stats['total'] }}</span></td>
            <td><span class="dot" style="background:#2e7d32;"></span>Approved<span class="num">{{ $stats['approved'] }}</span></td>
            <td><span class="dot" style="background:#e65100;"></span>Pending<span class="num">{{ $stats['pending'] }}</span></td>
            <td><span class="dot" style="background:#1976d2;"></span>In Review<span class="num">{{ $stats['blocked'] }}</span></td>
        </tr>
        <tr>
            <td><span class="dot" style="background:#c62828;"></span>Rejected<span class="num">{{ $stats['Reject'] }}</span></td>
            <td><span class="dot" style="background:#2e7d32;"></span>Sold<span class="num">{{ $stats['Soled'] }}</span></td>
            <td colspan="2"><span class="dot" style="background:#424242;"></span>Cancelled<span class="num">{{ $stats['Cancel'] }}</span></td>
        </tr>
    </table>

    {{-- Info --}}
    <div class="info">
        <strong>Generated:</strong> {{ $generatedAt }} &nbsp;&nbsp;&nbsp; <strong>Type:</strong> Products List with Complete Details
    </div>

    {{-- Table --}}
    @if ($products->count() > 0)
        <table class="main-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Seller</th>
                    <th>Status</th>
                    <th>Posted Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($product->name, 40) }}</td>
                        <td>{{ $product->conditions ?? 'N/A' }}</td>
                        <td>{{ number_format($product->asking_price, 2) }}</td>
                        <td>{{ $product->user->name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $badgeClass = match ($product->status) {
                                    'Approve' => 'badge-success',
                                    'Pending' => 'badge-warning',
                                    'InReview' => 'badge-info',
                                    'Reject' => 'badge-danger',
                                    'Soled' => 'badge-success',
                                    'Cancel' => 'badge-dark',
                                    default => 'badge-warning',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $product->status }}</span>
                        </td>
                        <td>{{ $product->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            No products found for the selected date range.
        </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        Computer-generated report &nbsp;&bull;&nbsp; {{ now()->format('d M Y, h:i A') }}
    </div>

</body>

</html>
