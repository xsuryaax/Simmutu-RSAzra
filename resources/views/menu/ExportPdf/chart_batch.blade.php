<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Grafik Indikator (Batch)</title>
    <style>
        @page { margin: 25px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            color: #1c1c1c;
            background: #fff;
            padding: 0 15px;
        }
        .header {
            width: 100%;
            margin-top: 0.5cm;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a3c6e;
            padding-bottom: 15px;
        }
        .header table { width: 100%; border-collapse: collapse; }
        .rs-name { font-size: 10px; font-weight: bold; color: #1a3c6e; text-transform: uppercase; }
        .doc-title { font-size: 12px; font-weight: bold; color: #1a3c6e; }

        .indicator-block {
            padding: 20px 30px;
            border-bottom: 1px dashed #eee;
            page-break-inside: avoid;
        }
        .indicator-block:last-child { border-bottom: none; }
        
        .ind-header { margin-bottom: 10px; }
        .ind-title { font-size: 9px; font-weight: bold; color: #1a2b4b; margin-bottom: 2px; }
        .ind-meta { font-size: 7px; color: #666; }

        .content-wrapper { display: table; width: 100%; border-spacing: 20px 0; margin-left: -20px; }
        .left-col { display: table-cell; width: 60%; vertical-align: top; }
        .right-col { display: table-cell; width: 40%; vertical-align: top; }

        .chart-container { text-align: center; padding: 5px; border: 1px solid #f1f4f8; border-radius: 4px; background: #fff; }
        .chart-image { width: 100%; height: auto; display: block; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 2px; }
        .data-table th { background: #1a3c6e; color: #fff; padding: 4px 2px; font-size: 7px; border: 1px solid #1a3c6e; }
        .data-table td { padding: 3px 2px; border: 1px solid #dde4f0; text-align: center; font-size: 7px; }
        
        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 7px;
            color: #ccc;
        }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td style="width: 150px; vertical-align: middle;">
                <img src="{{ public_path('assets/logo/azra-logo.png') }}" style="height: 35px;">
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <div class="rs-name">Rumah Sakit AZRA</div>
                <div class="doc-title">Laporan Indikator Mutu {{ $judul }}</div>
            </td>
            <td style="text-align: right; font-size: 7px; color: #999; width: 150px; line-height: 1.2; vertical-align: middle;">
                Tahun Laporan: <strong>{{ $tahun }}</strong><br>
                Dicetak: {{ date('d/m/Y H:i') }}
            </td>
        </tr>
    </table>
</div>

<div class="main-content">
    @foreach($indicators as $item)
        @php
            $indicator = $item['indicator'];
            $monthlyData = $item['monthlyData'];
        @endphp
        <div class="indicator-block">
            <div class="ind-header">
                <div class="ind-title">{{ $indicator->nama_indikator }}</div>
                <div class="ind-meta">
                    Unit: {{ $indicator->nama_unit ?? 'Seluruh RS' }} | Std: {{ $indicator->arah_target === 'lebih_kecil' ? '≤' : '≥' }} {{ round($indicator->target_indikator) }}%
                </div>
            </div>

            <div class="content-wrapper">
                <div class="left-col">
                    <div class="chart-container">
                        <img src="{{ $item['chart'] }}" class="chart-image">
                    </div>
                </div>
                <div class="right-col">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Bln</th>
                                <th>N</th>
                                <th>D</th>
                                <th>%</th>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="footer">
    SIM Mutu &bull; RS AZRA Bogor &bull; Dicetak {{ date('d/m/Y H:i') }}
</div>

</body>
</html>
