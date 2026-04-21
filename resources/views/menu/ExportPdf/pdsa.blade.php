<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data PDSA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1c1c1c;
            background: #fff;
            padding: 32px 36px 48px;
        }

        /* ── HEADER ── */
        .header {
            display: table;
            width: 100%;
            padding-bottom: 14px;
            margin-bottom: 20px;
            border-bottom: 2.5px solid #1a3c6e;
        }

        .header-logo-wrap {
            display: table-cell;
            vertical-align: middle;
            width: 64px;
        }

        .header-logo {
            height: 52px;
            width: auto;
        }

        .header-body {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 20px;
        }

        .rs-name {
            font-size: 11px;
            font-weight: bold;
            color: #1a3c6e;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .doc-title {
            font-size: 15px;
            font-weight: bold;
            color: #1a3c6e;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .doc-sub {
            font-size: 9px;
            color: #888;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }

        .header-meta {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 120px;
        }

        .header-meta p {
            font-size: 8px;
            color: #666;
            line-height: 1.9;
        }

        .header-meta strong {
            color: #1a1a1a;
            font-size: 9px;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
        }

        thead th {
            background-color: #1a3c6e;
            color: #fff;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            padding: 8px 6px;
            border: 1px solid #15305a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        tbody td {
            font-size: 9px;
            padding: 7px 7px;
            border: 1px solid #dde4f0;
            vertical-align: top;
            line-height: 1.6;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f7fc;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        td.center {
            text-align: center;
            vertical-align: middle;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-done {
            background: #d4edda;
            color: #155724;
        }

        .badge-progress {
            background: #fff3cd;
            color: #856404;
        }

        .badge-plan {
            background: #cce5ff;
            color: #004085;
        }

        .badge-default {
            background: #e9ecef;
            color: #495057;
        }

        /* Empty */
        .empty td {
            text-align: center;
            color: #bbb;
            font-style: italic;
            padding: 24px;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #dde4f0;
            font-size: 8px;
            color: #aaa;
            text-align: center;
            line-height: 1.8;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="header-logo-wrap" style="width: 150px; vertical-align: middle;">
            <div style="font-size: 16px; font-weight: bold; color: #007774; letter-spacing: 1px;">RS AZRA</div>
            <div style="font-size: 8px; color: #666; margin-top: 2px;">BOGOR</div>
        </div>
        <div class="header-body">
            <div class="doc-title">Laporan Data PDSA</div>
            <div class="doc-sub">Plan &ndash; Do &ndash; Study &ndash; Action</div>
        </div>
        <div class="header-meta">
            <p>Tanggal Cetak<br><strong>{{ date('d F Y') }}</strong></p>
            <p style="margin-top:6px;">Total Data<br><strong>{{ count($data) }} Record</strong></p>
        </div>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:17%">Indikator</th>
                <th style="width:7%">Unit</th>
                <th style="width:8%">Periode</th>
                <th style="width:17%">Plan</th>
                <th style="width:17%">Do</th>
                <th style="width:17%">Study</th>
                <th style="width:17%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
                @php
                    $s = strtolower($row->status_pdsa ?? '');
                    $badge = match (true) {
                        str_contains($s, 'done') => 'badge-done',
                        str_contains($s, 'progress') => 'badge-progress',
                        str_contains($s, 'plan') => 'badge-plan',
                        default => 'badge-default',
                    };
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $row->nama_indikator }}</td>
                    <td class="center">{{ $row->nama_unit }}</td>
                    <td class="center">
                        {{ $row->tahun }} / {{ $row->quarter }}
                    </td>
                    <td>{{ $row->plan }}</td>
                    <td>{{ $row->do }}</td>
                    <td>{{ $row->study }}</td>
                    <td>{{ $row->action }}</td>
                </tr>
            @empty
                <tr class="empty">
                    <td colspan="8">Tidak ada data yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Sistem Informasi Manajemen Mutu &nbsp;&bull;&nbsp; {{ date('Y') }} Rumah Sakit AZRA</p>
    </div>

</body>

</html>
