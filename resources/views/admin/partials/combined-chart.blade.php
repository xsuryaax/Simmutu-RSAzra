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
        <div class="bg-white text-dark p-3 rounded-top d-flex justify-content-between align-items-center flex-wrap border-bottom shadow-sm">
            <h5 class="mb-0 text-dark fw-bold" id="multiChartTitle">
                <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>Indikator Mutu Nasional — Tahun {{ $tahunAktif }}
            </h5>

            {{-- ── Control Bar ── --}}
            <div class="chart-controls">
                {{-- Filter Jenis --}}
                <select id="jenisFilter" class="form-select form-select-sm filter-select text-primary" style="width: 220px; font-weight: 600;">
                    <option value="imn" selected>Indikator Mutu Nasional</option>
                    <option value="imprs">Indikator Mutu Prioritas RS</option>
                    <option value="unit">Prioritas Unit</option>
                </select>

                {{-- Filter Tahun --}}
                <select id="tahunFilter" class="form-select form-select-sm filter-select text-dark" style="width: 100px;">
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $t == $tahunAktif ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>

                <div class="vr mx-1 opacity-50"></div>

                {{-- Filter Quarter --}}
                <div class="btn-group btn-group-sm bg-white p-1 rounded border shadow-sm">
                    <button class="btn btn-sm btn-primary active btn-quarter" data-q="Tahun">All</button>
                    <button class="btn btn-sm btn-light btn-quarter" data-q="Q1">Q1</button>
                    <button class="btn btn-sm btn-light btn-quarter" data-q="Q2">Q2</button>
                    <button class="btn btn-sm btn-light btn-quarter" data-q="Q3">Q3</button>
                    <button class="btn btn-sm btn-light btn-quarter" data-q="Q4">Q4</button>
                </div>

                {{-- Tipe Chart --}}
                <div class="btn-group btn-group-sm rounded border overflow-hidden shadow-sm">
                    <button id="btnLine" class="btn btn-brand-standar active" onclick="gantiTipeChart('line')" title="Line Chart">
                        <i class="bi bi-graph-up"></i>
                    </button>
                    <button id="btnBar" class="btn btn-light border-start" onclick="gantiTipeChart('bar')" title="Bar Chart">
                        <i class="bi bi-bar-chart"></i>
                    </button>
                </div>

                <div class="vr mx-1 opacity-50"></div>

                {{-- Export PDF --}}
                <button class="btn btn-sm btn-brand-pencapaian px-3 shadow-sm" onclick="downloadSemuaPDF(event)">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download Laporan (Semua)
                </button>
            </div>
        </div>

        {{-- ── Chart Grid Container ── --}}
        <div id="chartGridWrapper" class="bg-white rounded-bottom border border-top-0 shadow-sm min-vh-50">
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
</form>

@push('js')
    {{-- Dependensi Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
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