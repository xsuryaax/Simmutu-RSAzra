{{-- 
    Combined Dashboard Chart Partial
    - Extracted CSS: public/style/dashboard/css/combined-chart.css
    - Extracted JS:  public/style/dashboard/js/combined-chart.js
--}}

@push('css')
    <link rel="stylesheet" href="{{ asset('style/dashboard/css/combined-chart.css') }}">
@endpush

<div class="row mt-4">
    <div class="col-12">
        <div class="p-4 rounded-top border-bottom shadow-sm">
            {{-- ── Header Title Row ── --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>
                    <h4 class="mb-0 fw-bold" id="multiChartTitle" style="line-height:1;">Indikator Mutu Nasional — Tahun {{ $tahunAktif }}</h4>
                    <span class="badge bg-primary text-white ms-3 rounded-pill px-3 py-1 fw-semibold shadow-sm" style="font-size: 0.85rem;" id="totalIndikatorBadge">Total: 0 Indikator</span>
                </div>
            </div>

            {{-- ── Control Bar Row ── --}}
            <div class="chart-controls d-flex justify-content-between align-items-center flex-wrap gap-2">
                
                {{-- Left: Filter Group --}}
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    {{-- Pencarian Indikator --}}
                    <div class="search-container my-0">
                        <div class="input-group input-group-sm mb-0" style="width: 180px;">
                            <span class="input-group-text border-end-0 bg-transparent text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="indicatorSearch" class="form-control border-start-0" placeholder="Cari indikator...">
                        </div>
                    </div>

                    {{-- Filter Jenis --}}
                    <select id="jenisFilter" class="form-select form-select-sm filter-select fw-semibold text-primary" style="width: 140px;">
                        <option value="imn" selected>Nasional (IMN)</option>
                        <option value="imprs">Prioritas RS</option>
                        <option value="unit">Prioritas Unit</option>
                    </select>

                    {{-- Filter Unit (Admin Only) --}}
                    @if(in_array($roleId, [1, 2]))
                    <select id="unitFilter" name="unit_id" class="form-select form-select-sm filter-select fw-semibold text-dark" style="width: 160px;">
                        <option value="">Semua Unit</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                        @endforeach
                    </select>
                    @endif

                    {{-- Filter Tahun --}}
                    <select id="tahunFilter" class="form-select form-select-sm filter-select" style="width: 100px;">
                        @foreach($daftarTahun as $t)
                            <option value="{{ $t }}" {{ $t == $tahunAktif ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Right: Actions Group --}}
                <div class="d-flex align-items-center gap-2">
                    {{-- Filter Quarter --}}
                    <div class="btn-group btn-group-sm p-1 rounded border shadow-sm" role="group" aria-label="Filter Kuartal">
                        <button class="btn btn-sm btn-primary active btn-quarter" data-q="Tahun" aria-pressed="true">All</button>
                        <button class="btn btn-sm btn-light btn-quarter" data-q="Q1" aria-pressed="false">Q1</button>
                        <button class="btn btn-sm btn-light btn-quarter" data-q="Q2" aria-pressed="false">Q2</button>
                        <button class="btn btn-sm btn-light btn-quarter" data-q="Q3" aria-pressed="false">Q3</button>
                        <button class="btn btn-sm btn-light btn-quarter" data-q="Q4" aria-pressed="false">Q4</button>
                    </div>

                    {{-- Tipe Chart --}}
                    <div class="btn-group btn-group-sm rounded border overflow-hidden shadow-sm" role="group" aria-label="Tipe Grafik">
                        <button id="btnLine" class="btn btn-brand-standar active" onclick="gantiTipeChart('line')" title="Line Chart" aria-label="Tampilkan grafik garis" aria-pressed="true">
                            <i class="bi bi-graph-up"></i>
                        </button>
                        <button id="btnBar" class="btn btn-light border-start" onclick="gantiTipeChart('bar')" title="Bar Chart" aria-label="Tampilkan grafik batang" aria-pressed="false">
                            <i class="bi bi-bar-chart"></i>
                        </button>
                    </div>

                    {{-- Export PDF --}}
                    <button class="btn btn-sm btn-brand-pencapaian px-3 shadow-sm" onclick="downloadSemuaPDF(event)" aria-label="Download Laporan PDF">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>    </div>

        {{-- ── Chart Grid Container ── --}}
        <div id="chartGridWrapper" class="rounded-bottom border border-top-0 shadow-sm min-vh-50">
            <div id="chartGrid">
                <div class="chart-grid-loader col-12">
                    <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                    Menyiapkan dashboard...
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Form for PDF Export --}}
<form id="exportPdfForm" method="POST" action="{{ route('export.pdf.chart') }}" target="_blank" style="display:none;">
    @csrf
    <input type="hidden" name="chart_image">
    <input type="hidden" name="judul">
    <input type="hidden" name="indicator_id">
    <input type="hidden" name="tahun">
    <input type="hidden" name="is_batch">
    <input type="hidden" name="batch">
    <input type="hidden" name="include_pdsa" id="inputIncludePdsa">
</form>

{{-- Progress Overlay for Batch Export --}}
<div id="batchExportOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; flex-direction:column; align-items:center; justify-content:center;">
    <div class="spinner-border text-primary mb-3" role="status"></div>
    <div class="h5 fw-bold text-primary mb-1">Menyiapkan Laporan PDF...</div>
    <div id="batchExportProgress" class="text-muted">Memproses indikator 0 / 0</div>
</div>

@push('js')
    {{-- Dependensi Chart.js (Local) --}}
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    
    {{-- Config Passing --}}
    <script>
        window.DashboardChartConfig = {
            chartUrl: "{{ route('dashboard.chart-data') }}",
            exportUrl: "{{ route('export.pdf.chart') }}"
        };
    </script>

    {{-- Dashboard Logic --}}
    <script src="{{ asset('style/dashboard/js/combined-chart.js') }}"></script>
@endpush