<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profil Indikator</title>

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

        /* ───────── HEADER ───────── */
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
        }

        .header-body {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
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
            line-height: 1.8;
        }

        .header-meta strong {
            font-size: 9px;
            color: #000;
        }

        /* ───────── SECTION TITLE ───────── */
        .section-title {
            margin-top: 18px;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 11px;
            color: #1a3c6e;
            border-bottom: 1px solid #1a3c6e;
            padding-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ───────── TABLE DETAIL ───────── */
        table.detail {
            width: 100%;
            border-collapse: collapse;
        }

        table.detail td {
            padding: 6px 6px;
            border: 1px solid #dde4f0;
            vertical-align: top;
        }

        table.detail td.label {
            width: 25%;
            font-weight: bold;
            background: #f4f7fc;
        }

        table.detail td.value {
            width: 75%;
            text-align: justify;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #fff;
        }

        .nasional { background: #dc3545; }
        .rs { background: #198754; }
        .unit { background: #6c757d; }

        /* Footer */
        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #dde4f0;
            font-size: 8px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>

<body>

@php
    $kategoriClass = '';
    if(str_contains($data->kategori_indikator,'Nasional')) $kategoriClass='nasional';
    elseif(str_contains($data->kategori_indikator,'Prioritas RS')) $kategoriClass='rs';
    else $kategoriClass='unit';
@endphp

<!-- HEADER -->
<div class="header">
    <div class="header-logo-wrap">
        <img src="{{ public_path('assets/logo/azra-logo.png') }}" class="header-logo">
    </div>

    <div class="header-body">
        <div class="rs-name">Rumah Sakit AZRA</div>
        <div class="doc-title">Profil Indikator Mutu</div>
        <div class="doc-sub">Dokumen Sistem Informasi Manajemen Mutu</div>
    </div>

    <div class="header-meta">
        <p>Tanggal Cetak<br><strong>{{ date('d F Y') }}</strong></p>
        <p style="margin-top:6px;">Unit<br><strong>{{ $data->nama_unit }}</strong></p>
    </div>
</div>

<div class="section-title">Identitas Indikator</div>
<table class="detail">
    <tr>
        <td class="label">Nama Indikator</td>
        <td class="value"><strong>{{ $data->nama_indikator }}</strong></td>
    </tr>
    <tr>
        <td class="label">Kategori Indikator</td>
        <td class="value">
            <span>
                {{ $data->kategori_indikator }}
            </span>
        </td>
    </tr>
    <tr>
        <td class="label">Dimensi Mutu</td>
        <td class="value">{{ $data->nama_dimensi_mutu }}</td>
    </tr>
    <tr>
        <td class="label">Jenis Indikator</td>
        <td class="value">{{ $data->nama_jenis_indikator }}</td>
    </tr>
</table>

<!-- RINCIAN -->
<div class="section-title">Rincian Indikator</div>
<table class="detail">
    <tr><td class="label">Dasar Pemikiran</td><td class="value">{{ $data->dasar_pemikiran }}</td></tr>
    <tr><td class="label">Tujuan</td><td class="value">{{ $data->tujuan }}</td></tr>
    <tr><td class="label">Definisi Operasional</td><td class="value">{{ $data->definisi_operasional }}</td></tr>
    <tr><td class="label">Numerator</td><td class="value">{{ $data->numerator }}</td></tr>
    <tr><td class="label">Denominator</td><td class="value">{{ $data->denominator }}</td></tr>
    <tr><td class="label">Formula</td><td class="value">{{ $data->formula }}</td></tr>
    <tr><td class="label">Satuan Pengukuran</td><td class="value">{{ $data->satuan_pengukuran }}</td></tr>
    <tr><td class="label">Target Pencapaian</td><td class="value">{{ $data->target_pencapaian }}</td></tr>
    <tr><td class="label">Kriteria Inklusi</td><td class="value">{{ $data->kriteria_inklusi }}</td></tr>
    <tr><td class="label">Kriteria Eksklusi</td><td class="value">{{ $data->kriteria_eksklusi }}</td></tr>
    <tr><td class="label">Metode Pengumpulan Data</td><td class="value">{{ $data->metode_pengumpulan_data }}</td></tr>
    <tr><td class="label">Sumber Data</td><td class="value">{{ $data->sumber_data }}</td></tr>
    <tr><td class="label">Instrumen Pengambilan Data</td><td class="value">{{ $data->instrumen_pengambilan_data }}</td></tr>
    <tr><td class="label">Populasi</td><td class="value">{{ $data->populasi }}</td></tr>
    <tr><td class="label">Sampel</td><td class="value">{{ $data->sampel }}</td></tr>
</table>

<!-- PERIODE -->
<div class="section-title">Periode & Pelaporan</div>
<table class="detail">
    <tr><td class="label">Periode Pengumpulan</td><td class="value">{{ $data->nama_periode_pengumpulan_data }}</td></tr>
    <tr><td class="label">Periode Analisis</td><td class="value">{{ $data->nama_periode_analisis_data }}</td></tr>
    <tr><td class="label">Penyajian Data</td><td class="value">{{ $data->nama_penyajian_data }}</td></tr>
    <tr><td class="label">Penanggung Jawab</td><td class="value">{{ $data->penanggung_jawab }}</td></tr>
</table>

<!-- FOOTER -->
<div class="footer">
    Sistem Informasi Manajemen Mutu &nbsp;&bull;&nbsp; {{ date('Y') }} Rumah Sakit AZRA
</div>

</body>
</html>