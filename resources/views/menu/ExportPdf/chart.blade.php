<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Grafik Indikator</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #1c1c1c;
            padding: 25px 35px;
        }
        .header {
            display: table;
            width: 100%;
            padding-bottom: 8px;
            margin-bottom: 15px;
            border-bottom: 2px solid #1a3c6e;
        }
        .header-logo-wrap { display: table-cell; vertical-align: middle; width: 50px; }
        .header-logo { height: 45px; }
        .header-body { display: table-cell; vertical-align: middle; text-align: center; }
        .rs-name { font-size: 11px; font-weight: bold; color: #1a3c6e; text-transform: uppercase; }
        .doc-title { font-size: 14px; font-weight: bold; color: #1a3c6e; margin-top: 2px; }
        .header-meta { display: table-cell; vertical-align: middle; text-align: right; width: 120px; font-size: 7px; color: #666; }

        .info-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .info-table td.label { width: 18%; font-weight: bold; color: #1a3c6e; }
        .info-table td.separator { width: 2%; }
        
        /* Layout Side-by-Side */
        .content-wrapper { display: table; width: 100%; border-spacing: 15px 0; margin-left: -15px; }
        .left-col { display: table-cell; width: 62%; vertical-align: top; }
        .right-col { display: table-cell; width: 38%; vertical-align: top; }

        .chart-container { text-align: center; padding: 10px; border: 1px solid #eee; border-radius: 6px; background: #fff; }
        .chart-image { width: 100%; height: auto; display: block; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #1a3c6e; color: #fff; padding: 6px 4px; font-size: 8px; text-transform: uppercase; border: 1px solid #1a3c6e; }
        .data-table td { padding: 5px 3px; border: 1px solid #dde4f0; text-align: center; font-size: 8px; }
        .data-table tr:nth-child(even) { background: #f9f9f9; }
        
        .section-sub { color: #1a3c6e; font-weight: bold; margin-bottom: 6px; border-bottom: 1px solid #eee; padding-bottom: 3px; font-size: 10px; }
        .footer { position: fixed; bottom: 20px; left: 35px; right: 35px; border-top: 1px solid #dde4f0; padding-top: 8px; font-size: 7px; color: #aaa; text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-logo-wrap">
        <img src="{{ public_path('assets/logo/azra-logo.png') }}" class="header-logo">
    </div>
    <div class="header-body">
        <div class="rs-name">Rumah Sakit AZRA</div>
        <div class="doc-title">Laporan Grafik Indikator Mutu</div>
    </div>
    <div class="header-meta">
        Dicetak pada:<br><strong>{{ date('d F Y H:i') }}</strong>
    </div>
</div>

<table class="info-table">
    <tr>
        <td class="label">Nama Indikator</td>
        <td class="separator">:</td>
        <td><strong>{{ $indicator->nama_indikator }}</strong></td>
    </tr>
    <tr>
        <td class="label">Unit / Kategori</td>
        <td class="separator">:</td>
        <td>{{ $indicator->nama_unit ?? 'Seluruh Rumah Sakit' }} / {{ $indicator->kategori_indikator }}</td>
    </tr>
    <tr>
        <td class="label">Tahun Laporan</td>
        <td class="separator">:</td>
        <td>{{ $tahun }}</td>
    </tr>
</table>

<div class="content-wrapper">
    <!-- Kolom Kiri: Chart -->
    <div class="left-col">
        <div class="section-sub">Visualisasi Tren</div>
        <div class="chart-container">
            <img src="{{ $chart }}" class="chart-image">
        </div>
        <div style="margin-top: 10px; font-size: 7px; color: #888; font-style: italic;">
            * Grafik menampilkan tren bulanan untuk tahun periode {{ $tahun }}
        </div>
    </div>

    <!-- Kolom Kanan: Tabel -->
    <div class="right-col">
        <div class="section-sub">Rincian Nilai</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">Bulan</th>
                    <th colspan="2">Data Dasar</th>
                    <th rowspan="2">Capai</th>
                    <th rowspan="2">Std</th>
                </tr>
                <tr>
                    <th>N</th>
                    <th>D</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $row)
                <tr>
                    <td style="text-align: left; font-weight: bold;">{{ substr($row['bulan'], 0, 3) }}</td>
                    <td>{{ number_format($row['numerator'], 0, ',', '.') }}</td>
                    <td>{{ number_format($row['denominator'], 0, ',', '.') }}</td>
                    <td style="font-weight: bold; color: {{ $row['pencapaian'] >= $row['target'] ? '#198754' : '#dc3545' }};">
                        {{ floor($row['pencapaian']) }}%
                    </td>
                    <td style="background: #f4f7fc; color: #666;">
                        {{ $indicator->arah_target === 'lebih_kecil' ? '≤' : '≥' }} {{ round($row['target']) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="footer">
    Sistem Informasi Manajemen Mutu &bull; Rumah Sakit AZRA Bogor &bull; {{ date('Y') }}
</div>

</body>
</html>
