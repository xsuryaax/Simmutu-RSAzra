<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Grafik Indikator</title>
    <style>
        @page {
            margin: 25px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1c1c1c;
            padding: 30px;
        }

        .header {
            width: 100%;
            margin-top: 0.5cm;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a3c6e;
            padding-bottom: 15px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .rs-name {
            font-size: 12px;
            font-weight: bold;
            color: #1a3c6e;
            text-transform: uppercase;
        }

        .doc-title {
            font-size: 15px;
            font-weight: bold;
            color: #1a3c6e;
        }

        .ind-header {
            margin-bottom: 15px;
        }

        .ind-title {
            font-size: 14px;
            font-weight: bold;
            color: #1a2b4b;
            margin-bottom: 5px;
        }

        .ind-meta {
            font-size: 10px;
            color: #666;
        }

        .content-wrapper {
            display: table;
            width: 100%;
            border-spacing: 20px 0;
            margin-left: -20px;
        }

        .left-col {
            display: table-cell;
            width: 65%;
            vertical-align: top;
        }

        .right-col {
            display: table-cell;
            width: 35%;
            vertical-align: top;
        }

        .chart-container {
            text-align: center;
            padding: 10px;
            border: 1px solid #f1f4f8;
            border-radius: 8px;
        }

        .chart-image {
            width: 100%;
            height: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .data-table th {
            background: #1a3c6e;
            color: #fff;
            padding: 6px 4px;
            font-size: 9px;
            border: 1px solid #1a3c6e;
        }

        .data-table td {
            padding: 5px 4px;
            border: 1px solid #dde4f0;
            text-align: center;
            font-size: 9px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #aaa;
        }
    </style>
</head>

<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 150px; vertical-align: middle;">
                    <img src="{{ public_path('assets/logo/azra-logo.png') }}" style="height: 45px;">
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <div class="rs-name">Rumah Sakit AZRA</div>
                    <div class="doc-title">Laporan Grafik Indikator Mutu</div>
                </td>
                <td
                    style="text-align: right; font-size: 8px; color: #999; width: 150px; line-height: 1.3; vertical-align: middle;">
                    Periode: <strong>{{ $tahun }}</strong><br>
                    Dicetak: {{ date('d F Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="ind-header">
        <div class="ind-title">{{ $indicator->nama_indikator }}</div>
        <div class="ind-meta">
            <strong>Unit:</strong> {{ $indicator->nama_unit ?? 'Seluruh Rumah Sakit' }} &nbsp; | &nbsp;
            <strong>Kategori:</strong> {{ $indicator->kategori_indikator }} &nbsp; | &nbsp;
            <strong>Standar:</strong> {{ $indicator->arah_target === 'lebih_kecil' ? '≤' : '≥' }}
            {{ round($indicator->target_indikator) }}%
        </div>
    </div>

    <div class="content-wrapper">
        <div class="left-col">
            <div class="chart-container">
                <img src="{{ $chart }}" class="chart-image">
            </div>
            <div style="margin-top: 10px; font-size: 8px; color: #888; font-style: italic;">
                * Grafik menampilkan tren bulanan periode tahun {{ $tahun }}
            </div>
        </div>
        <div class="right-col">
            <div style="font-weight: bold; color: #1a3c6e; margin-bottom: 5px; font-size: 10px;">Rincian Nilai Bulanan
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="2">Bulan</th>
                        <th colspan="2">Data Dasar</th>
                        <th rowspan="2">%</th>
                    </tr>
                    <tr>
                        <th>N</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyData as $row)
                        <tr>
                            <td style="text-align: left; font-weight: bold;">{{ substr($row['bulan'], 0, 3) }}</td>
                            <td>{{ number_format($row['numerator'], 0, ',', '.') }}</td>
                            <td>{{ number_format($row['denominator'], 0, ',', '.') }}</td>
                            <td
                                style="font-weight: bold; color: {{ $row['pencapaian'] >= $row['target'] ? '#198754' : '#dc3545' }};">
                                {{ floor($row['pencapaian']) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($pdsaData))
        <div style="margin-top: 30px; page-break-inside: avoid;">
            <div style="font-weight: bold; color: #1a3c6e; margin-bottom: 5px; font-size: 10px; border-bottom: 1px solid #1a3c6e; padding-bottom: 3px;">
                Status PDSA (Plan-Do-Study-Act) Tahun {{ $tahun }}
            </div>
            <table class="data-table" style="margin-top: 10px; font-size: 9px;">
                <thead>
                    <tr>
                        <th style="width: 6%;">Quarter</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 20.5%;">Plan</th>
                        <th style="width: 20.5%;">Do</th>
                        <th style="width: 20.5%;">Study</th>
                        <th style="width: 20.5%;">Act</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pdsaData as $tw => $pdsa)
                        @if ($pdsa)
                            <tr>
                                <td style="font-weight: bold;">{{ $tw }}</td>
                                <td>{{ $pdsa['status'] }}</td>
                                <td style="text-align: left; vertical-align: top;">{{ $pdsa['plan'] ?: '-' }}</td>
                                <td style="text-align: left; vertical-align: top;">{{ $pdsa['do'] ?: '-' }}</td>
                                <td style="text-align: left; vertical-align: top;">{{ $pdsa['study'] ?: '-' }}</td>
                                <td style="text-align: left; vertical-align: top;">{{ $pdsa['action'] ?: '-' }}</td>
                            </tr>
                        @else
                            <tr style="color: #aaa; font-style: italic;">
                                <td style="font-weight: bold; color: #999;">{{ $tw }}</td>
                                <td style="color: #aaa;">Belum ada PDSA</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        Dicetak pada {{ date('d F Y H:i') }} &bull; SIM Mutu RS AZRA Bogor
    </div>

</body>

</html>
