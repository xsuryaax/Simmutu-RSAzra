@extends('layouts.app')

@section('title', 'Analisa dan Visualisasi')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Analisa dan Visualisasi</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola menganalisis laporan dan visualisasi data indikator mutu.
            </p>
        </div>
        <div class="page-header-right">
            <div class="logout-btn">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Analisa dan Visualisasi
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="row row-cols-sm-1 mb-4">
                <div class="col-12 col-md-5 col-lg-7 col-md-5 px-2">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Laporan Indikator</h5>
                        </div>



                        <div class="card-body">
                            <form method="GET" class="row mb-3">


                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Jenis Indikator</label>
                                    <select name="kategori_indikator" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Indikator</option>
                                        <option value="Nasional" {{ $kategoriDipilih == 'Nasional' ? 'selected' : '' }}>
                                            Nasional
                                        </option>
                                        <option value="Prioritas RS"
                                            {{ $kategoriDipilih == 'Prioritas RS' ? 'selected' : '' }}>
                                            Prioritas RS</option>
                                        <option value="Prioritas Unit"
                                            {{ $kategoriDipilih == 'Prioritas Unit' ? 'selected' : '' }}>Prioritas Unit
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Tahun</label>
                                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                                        @foreach ($tahunAktif as $t)
                                            <option value="{{ $t }}" {{ $tahunDipilih == $t ? 'selected' : '' }}>
                                                {{ $t }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Bulan</label>
                                    <select name="bulan" class="form-select" onchange="this.form.submit()">
                                        @for ($b = 1; $b <= 12; $b++)
                                            <option value="{{ $b }}" {{ $bulanDipilih == $b ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </form>

                            {{-- Legend --}}
                            <div class="mb-3 d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2 legend-box">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Nasional</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2 legend-box">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Prioritas RS</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light me-2 legend-box">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Unit</small>
                                </div>
                            </div>

                            <div class="table-parent-container table-responsive-md">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th>INDIKATOR</th>
                                            <th class="text-center">UNIT</th>
                                            <th class="text-center">ANALISA</th>
                                            <th class="text-center">RENCANA TINDAK LANJUT</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($indikators as $i => $ind)
                                            @php
                                                $colColor = '';
                                                $filterKategori = strtolower(request('kategori_indikator'));
                                                $jenisDb = strtolower($ind->kategori_indikator ?? '');

                                                if ($filterKategori) {
                                                    if ($filterKategori === 'nasional') {
                                                        $colColor = 'table-danger';
                                                    } elseif ($filterKategori === 'prioritas rs') {
                                                        $colColor = 'table-success';
                                                    } elseif ($filterKategori === 'prioritas unit') {
                                                        $colColor = 'table-light';
                                                    }
                                                } else {
                                                    if (str_contains($jenisDb, 'nasional')) {
                                                        $colColor = 'table-danger';
                                                    } elseif (str_contains($jenisDb, 'prioritas rs')) {
                                                        $colColor = 'table-success';
                                                    } elseif (str_contains($jenisDb, 'prioritas unit')) {
                                                        $colColor = 'table-light';
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $i + 1 }}</td>
                                                <td class="{{ $colColor }}">{{ $ind->nama_indikator }}</td>

                                                <td class="text-center">
                                                    {{ $ind->nama_unit ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $analisaData[$ind->id]['analisa'] ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $analisaData[$ind->id]['tindak_lanjut'] ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning"
                                                        onclick="openModal(
                                                                                                                                                                                                                                        {{ $ind->id }},
                                                                                                                                                                                                                                        '{{ addslashes($ind->nama_indikator) }}',
                                                                                                                                                                                                                                        '{{ addslashes($analisaData[$ind->id]['analisa'] !== '-' ? $analisaData[$ind->id]['analisa'] : '') }}',
                                                                                                                                                                                                                                        '{{ addslashes($analisaData[$ind->id]['tindak_lanjut'] !== '-' ? $analisaData[$ind->id]['tindak_lanjut'] : '') }}'
                                                                                                                                                                                                                                    )">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-info"
                                                        onclick="loadChart({{ $ind->id }}, '{{ $ind->nama_indikator }}', '{{ $ind->nama_unit }}')">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center text-muted">-</td>
                                                <td class="text-center text-muted">Tidak ada data indikator</td>
                                                <td class="text-center text-muted">-</td>
                                                <td class="text-center text-muted">-</td>
                                                <td class="text-center text-muted">-</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-5 col-md-5 px-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-center align-items-center text-center">
                                <div>
                                    <h5 class="mb-1" id="chart-title">Nama Indikator</h5>
                                    <small class="text-muted" id="chart-subtitle">
                                        Nama Unit
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <div class="chart-legend">
                                    <span class="legend-item">
                                        <span class="legend-dot realisasi"></span> Pencapaian
                                    </span>

                                    <span class="legend-item ms-3">
                                        <span class="legend-dot standar"></span> Standar
                                    </span>
                                </div>

                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-sm btn-danger" id="line-chart-btn" title="Line Chart">
                                        <i class="bi bi-graph-up"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info" id="bar-chart-btn" title="Bar Chart">
                                        <i class="bi bi-bar-chart"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="analyst-chart border-0 shadow-sm rounded-3 mb-2">
                                <canvas id="indicatorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal buat input analisa dan RTL --}}
    <div class="modal fade" id="analysisModal" tabindex="-1" aria-labelledby="analysisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="analysisModalLabel">Input Analisa dan Rencana Tindak Lanjut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="analysisForm">
                        @csrf
                        <input type="hidden" id="indikator_id">

                        <div class="mb-3">
                            <label class="form-label">Analisa</label>
                            <textarea class="form-control" id="analisa" rows="5"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindak Lanjut</label>
                            <textarea class="form-control" id="tindak_lanjut" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveAnalysis()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        const firstIndikator = @json($firstIndikator ?? null);
        const csrfToken = "{{ csrf_token() }}";
        const analisaStoreUrl = "{{ route('analisa-data.store') }}";
    </script>

    <script src="{{ asset('style/assets/js/pages/analisa-chart.js') }}"></script>
@endpush

@push('css')
    <style>
        .legend-box {
            width: 20px;
            height: 20px;
            border: 1px solid #f0f2f4;
        }

        .chart-table {
            font-size: 11px;
            margin-bottom: 0;
        }

        .analyst-chart {
            height: 300px;
        }

        .chart-table th,
        .chart-table td {
            padding: 2px 4px;
            white-space: nowrap;
        }

        .chart-table tr {
            line-height: 1.2;
        }

        .chart-legend {
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .legend-dot.realisasi {
            background-color: #e63757;
        }

        .legend-dot.standar {
            background-color: #2c7be5;
        }
    </style>
@endpush
