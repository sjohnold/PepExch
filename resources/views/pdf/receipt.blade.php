@php
    $completedAt = $offer->updated_at;
    $generatedAt = now();
    $senderItems = collect($offer->sender_items ?? [])->filter()->values();
    $receiverItems = collect($offer->receiver_items ?? [])->filter()->values();
    $documentHash = substr(hash('sha256', implode('|', [
        $offer->id,
        $offer->sender_id,
        $offer->receiver_id,
        $offer->selling_post_id,
        $completedAt?->toIso8601String(),
        $senderItems->implode(','),
        $receiverItems->implode(','),
    ])), 0, 24);
@endphp
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <title>PepExch - Potvrda o razmeni #{{ $offer->id }}</title>
    <style>
        @page {
            margin: 28px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "DejaVu Sans", sans-serif;
            color: #172033;
            font-size: 12px;
            line-height: 1.45;
            background: #ffffff;
        }

        .document {
            width: 100%;
        }

        .top-rule {
            height: 6px;
            background: #1f7a4d;
            margin-bottom: 22px;
        }

        .header-table,
        .summary-table,
        .details-table,
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .brand {
            font-size: 25px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: 0.2px;
            color: #172033;
        }

        .brand-mark {
            color: #1f7a4d;
        }

        .document-title {
            text-align: right;
            font-size: 17px;
            font-weight: 800;
            color: #172033;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .document-subtitle {
            margin-top: 5px;
            text-align: right;
            color: #657084;
            font-size: 11px;
        }

        .meta-strip {
            margin: 22px 0 18px;
            border: 1px solid #d9e2dc;
            background: #f7faf8;
        }

        .meta-strip td {
            width: 25%;
            padding: 11px 13px;
            border-right: 1px solid #d9e2dc;
            vertical-align: top;
        }

        .meta-strip td:last-child {
            border-right: 0;
        }

        .meta-label {
            display: block;
            margin-bottom: 4px;
            font-size: 9px;
            color: #6d7787;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 700;
        }

        .meta-value {
            font-size: 12px;
            font-weight: 800;
            color: #172033;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 9px;
            border: 1px solid #1f7a4d;
            color: #1f7a4d;
            background: #eef8f1;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section {
            margin-top: 16px;
            border: 1px solid #d9e2dc;
        }

        .section-title {
            padding: 10px 13px;
            border-bottom: 1px solid #d9e2dc;
            background: #f3f6f5;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #273244;
        }

        .section-body {
            padding: 12px 13px;
        }

        .details-table th,
        .details-table td {
            padding: 8px 9px;
            border-bottom: 1px solid #e8eee9;
            vertical-align: top;
            text-align: left;
        }

        .details-table tr:last-child th,
        .details-table tr:last-child td {
            border-bottom: 0;
        }

        .details-table th {
            width: 30%;
            color: #657084;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 800;
        }

        .details-table td {
            color: #172033;
            font-weight: 600;
        }

        .party-table {
            width: 100%;
            border-collapse: collapse;
        }

        .party-table td {
            width: 50%;
            padding: 0;
            vertical-align: top;
        }

        .party-table .party-left {
            padding-right: 8px;
        }

        .party-table .party-right {
            padding-left: 8px;
        }

        .party-box {
            border: 1px solid #d9e2dc;
            min-height: 92px;
        }

        .party-head {
            padding: 9px 11px;
            border-bottom: 1px solid #d9e2dc;
            background: #fbfcfb;
            color: #657084;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .party-name {
            padding: 13px 11px 4px;
            font-size: 14px;
            font-weight: 800;
            color: #172033;
        }

        .party-note {
            padding: 0 11px 13px;
            color: #657084;
            font-size: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 10px 12px;
            border: 1px solid #d9e2dc;
            vertical-align: top;
        }

        .items-table th {
            background: #f3f6f5;
            color: #273244;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 800;
            text-align: left;
        }

        .items-table ol {
            margin: 0;
            padding-left: 17px;
        }

        .items-table li {
            margin-bottom: 5px;
        }

        .muted {
            color: #657084;
        }

        .declaration {
            padding: 13px 15px;
            border-left: 4px solid #1f7a4d;
            background: #f7faf8;
            color: #273244;
            font-size: 11px;
        }

        .signature-table {
            margin-top: 24px;
        }

        .signature-table td {
            width: 50%;
            padding-top: 26px;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #9aa5b1;
            padding-top: 7px;
            width: 82%;
            color: #657084;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 800;
        }

        .footer {
            margin-top: 24px;
            padding-top: 11px;
            border-top: 1px solid #d9e2dc;
            color: #657084;
            font-size: 9px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="document">
        <div class="top-rule"></div>

        <table class="header-table">
            <tr>
                <td>
                    <div class="brand">Pep<span class="brand-mark">Exch</span></div>
                    <div class="muted">Platforma za sigurnu razmenu</div>
                </td>
                <td>
                    <div class="document-title">Potvrda o razmeni</div>
                    <div class="document-subtitle">Sistemski generisan PDF dokument</div>
                </td>
            </tr>
        </table>

        <table class="meta-strip">
            <tr>
                <td>
                    <span class="meta-label">Broj potvrde</span>
                    <span class="meta-value">#{{ str_pad((string) $offer->id, 6, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td>
                    <span class="meta-label">Status</span>
                    <span class="status-pill">Završeno</span>
                </td>
                <td>
                    <span class="meta-label">Datum završetka</span>
                    <span class="meta-value">{{ $completedAt?->format('d.m.Y. H:i') }}</span>
                </td>
                <td>
                    <span class="meta-label">Generisano</span>
                    <span class="meta-value">{{ $generatedAt->format('d.m.Y. H:i') }}</span>
                </td>
            </tr>
        </table>

        <div class="section">
            <div class="section-title">Podaci o razmeni</div>
            <div class="section-body">
                <table class="details-table">
                    <tr>
                        <th>Predmet oglasa</th>
                        <td>{{ $offer->sellingPost->name ?? 'Nije dostupno' }}</td>
                    </tr>
                    <tr>
                        <th>ID oglasa</th>
                        <td>#{{ $offer->selling_post_id }}</td>
                    </tr>
                    <tr>
                        <th>ID transakcije</th>
                        <td>#{{ $offer->id }}</td>
                    </tr>
                    <tr>
                        <th>Kontrolni kod</th>
                        <td>{{ strtoupper($documentHash) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Učesnici</div>
            <div class="section-body">
                <table class="party-table">
                    <tr>
                        <td class="party-left">
                            <div class="party-box">
                                <div class="party-head">Pošiljalac ponude</div>
                                <div class="party-name">{{ $offer->sender->name ?? 'Nije dostupno' }}</div>
                                <div class="party-note">Korisnički ID: #{{ $offer->sender_id }}</div>
                            </div>
                        </td>
                        <td class="party-right">
                            <div class="party-box">
                                <div class="party-head">Vlasnik oglasa</div>
                                <div class="party-name">{{ $offer->receiver->name ?? 'Nije dostupno' }}</div>
                                <div class="party-note">Korisnički ID: #{{ $offer->receiver_id }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Predmeti razmene</div>
            <div class="section-body">
                <table class="items-table">
                    <tr>
                        <th width="50%">Predmeti koje daje pošiljalac</th>
                        <th width="50%">Predmeti koje daje vlasnik oglasa</th>
                    </tr>
                    <tr>
                        <td>
                            @if($senderItems->isNotEmpty())
                                <ol>
                                    @foreach($senderItems as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <span class="muted">Nema navedenih predmeta.</span>
                            @endif
                        </td>
                        <td>
                            @if($receiverItems->isNotEmpty())
                                <ol>
                                    @foreach($receiverItems as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <span class="muted">Nema navedenih dodatnih predmeta.</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Izjava o potvrdi</div>
            <div class="section-body">
                <div class="declaration">
                    Ovim dokumentom se potvrđuje da su obe strane označile razmenu kao završenu na PepExch platformi.
                    Potvrda je generisana automatski na osnovu podataka zabeleženih u sistemu i služi kao dokaz o završetku razmene između navedenih korisnika.
                </div>

                <table class="signature-table">
                    <tr>
                        <td>
                            <div class="signature-line">Potvrda pošiljaoca ponude</div>
                        </td>
                        <td>
                            <div class="signature-line">Potvrda vlasnika oglasa</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td>PepExch - automatski generisan dokument, bez potrebe za ručnim potpisom.</td>
                    <td>Kontrolni kod: {{ strtoupper($documentHash) }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
