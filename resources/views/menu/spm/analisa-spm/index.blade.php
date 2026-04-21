@extends('layouts.app')

@section('title', 'Analisa dan Visualisasi')

@section('title', 'Analisa SPM')
@section('subtitle', 'Visualisasi capaian dan analisis tindak lanjut Standar Pelayanan Minimal')

@section('content')
    <section class="section">
        {{-- Filter & Legend Section --}}
        <div class="table-filter-section mb-4">
            <div class="row align-items-end">
                <div class="col">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="filter-label">Tahun</label>
                            <select name="tahun" class="form-select" onchange="this.form.submit()">
                                @foreach ($tahunAktif as $t)
                                    <option value="{{ $t }}" {{ $tahunDipilih == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="filter-label">Bulan</label>
                            <select name="bulan" class="form-select" onchange="this.form.submit()">
                                @for ($b = 1; $b <= 12; $b++)
                                    <option value="{{ $b }}" {{ $bulanDipilih == $b ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-auto pb-2">
                    <div id="table-legend-placeholder"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="row flex-wrap flex-xl-nowrap mb-4">
                <div class="col-12 col-xl table-column-grow px-2" style="min-width: 0;">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div>
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th style="min-width: 350px;">SPM</th>
                                            <th class="text-center">UNIT</th>
                                            <th class="text-center">ANALISA</th>
                                            <th class="text-center">RENCANA TINDAK LANJUT</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($spms as $i => $ind)
                                            <tr>
                                                <td class="text-center">{{ $i + 1 }}</td>
                                                <td class="fw-semibold">{{ $ind->nama_spm }}</td>

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
                                                        onclick="openModal({{ $ind->id }}, '{{ addslashes($ind->nama_spm) }}', '{{ addslashes($analisaData[$ind->id]['analisa'] !== '-' ? $analisaData[$ind->id]['analisa'] : '') }}', '{{ addslashes($analisaData[$ind->id]['tindak_lanjut'] !== '-' ? $analisaData[$ind->id]['tindak_lanjut'] : '') }}')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-info"
                                                        onclick="loadChart({{ $ind->id }}, '{{ addslashes($ind->nama_spm) }}', '{{ addslashes($ind->nama_unit ?? '') }}', 'SPM')">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center text-muted">-</td>
                                                <td class="text-center text-muted">Tidak ada data spm</td>
                                                <td class="text-center text-muted">-</td>
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

                <div class="col-12 col-xl-5 px-2">
                    <div class="card shadow-sm border-0">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-center align-items-center text-center">
                                <div>
                                    <h5 class="mb-1" id="chart-title">Nama SPM</h5>
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
                        <input type="hidden" id="spm_id">

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
        const firstSpm = @json($firstSpm ?? null);
        const csrfToken = "{{ csrf_token() }}";
        const analisaStoreUrl = "{{ route('analisa-spm.store') }}";
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
        .chart-table th, .chart-table td {
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
