@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Dashboard')

@section('page-title')
    <div class="dash-header">
        <div class="dash-header-left">
            <h3>Profile Statistics</h3>
        </div>
        <div class="dash-header-right">
            <form method="POST" action="/logout">
                <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->username }}</strong></span>
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
@endsection

{{-- Bagian Konten Utama --}}
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                {{-- ===== CHART ADMIN ===== --}}
                @if (in_array($roleId, [1, 2]))
                    <div class="row mb-4">
                        <div class="col-5 col-lg-2a col-md-5">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple">
                                                <i class="bi bi-buildings"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 col-xxl-7">
                                            <h6 class="text-muted font-semibold mb-1">Total Unit</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalUnit }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-5 col-lg-2a col-md-5">
                            <div class="card" style="cursor: pointer" data-bs-toggle="modal"
                                data-bs-target="#modalSudahIsi">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green">
                                                <i class="bi bi-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 col-xxl-7">
                                            <h6 class="text-muted font-semibold mb-1">Unit Sudah Mengisi</h6>
                                            <h6 class="font-extrabold mb-0">{{ $unitSudahIsi }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-5 col-lg-2a col-md-5">
                            <div class="card" style="cursor: pointer" data-bs-toggle="modal"
                                data-bs-target="#modalBelumIsi">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon red">
                                                <i class="bi bi-x-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 col-xxl-7">
                                            <h6 class="text-muted font-semibold mb-1">Unit Belum Mengisi</h6>
                                            <h6 class="font-extrabold mb-0">{{ $unitBelumIsi }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-5 col-lg-2a col-md-5">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue">
                                                <i class="bi bi-bookmark"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 col-xxl-7">
                                            <h6 class="text-muted font-semibold mb-1">Total Indikator</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalIndikator }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-5 col-lg-2a col-md-5">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon bg-orange">
                                                <i class="bi bi-file-earmark-excel"></i>
                                            </div>
                                        </div>
                                        <div class="col-8 col-xxl-7">
                                            <h6 class="text-muted font-semibold mb-1">Total PDSA</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalIndikator }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row adm-chart">
                        <div class="col-9 left-chart">
                            <div class="card">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Hasil Indikator Semua Unit</h4>

                                    <div class="d-flex gap-2">
                                        <select id="divisionFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Unit --</option>
                                            @foreach ($unitIndikatorMap as $unitName => $items)
                                                <option value="{{ $unitName }}">{{ $unitName }}</option>
                                            @endforeach
                                        </select>

                                        <select id="indicatorFilter" class="form-select form-select-sm" disabled>
                                            <option value="">-- Pilih Indikator --</option>
                                        </select>

                                        <select id="admFilterTahun" class="form-select form-select-sm">
                                        </select>

                                        <select id="admFilterPeriode" class="form-select form-select-sm">
                                            <option value="Tahun" selected>Data Satu Tahun</option>
                                            <option value="Q1">Q1 (Jan-Mar)</option>
                                            <option value="Q2">Q2 (Apr-Jun)</option>
                                            <option value="Q3">Q3 (Jul-Sep)</option>
                                            <option value="Q4">Q4 (Okt-Des)</option>
                                        </select>

                                        <select id="admFilterTipeChart" class="form-select form-select-sm">
                                            <option value="line" selected>Line Chart</option>
                                            <option value="bar">Bar Chart</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <canvas id="chartDivisionAchievement"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 right-chart">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Terakhir Mengisi</h4>
                                </div>
                                <div class="card-content pb-3">
                                    @foreach ($recentIsi as $row)
                                        <div class="recent-message d-flex px-4 py-3 align-items-center">
                                            <div class="avatar avatar-lg">
                                                @php
                                                    $imgIndex = ($row->unit_id % 10) + 1;
                                                @endphp
                                                <img src="{{ asset("assets/faces/{$imgIndex}.jpg") }}">
                                            </div>
                                            <div class="name ms-3">
                                                <h6 class="mb-1">{{ $row->nama_unit }}</h6>
                                                <small class="text-muted">
                                                    {{ date('d F Y', strtotime($row->tanggal_laporan)) }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                        <script>
                            /* ==================== DATA ======================= */
                            const allUnitData = @json($divisionData);

                            const adminAvailableYears = Object.keys(allUnitData).reverse();
                            const defaultYear = adminAvailableYears[0];

                            /* ==================== ELEMENT ======================= */
                            const unitFilterEl = document.getElementById("divisionFilter");
                            const admFilterTahunEl = document.getElementById("admFilterTahun");
                            const admFilterPeriodeEl = document.getElementById("admFilterPeriode");
                            const admFilterTipeChartEl = document.getElementById("admFilterTipeChart");
                            const indicatorFilterEl = document.getElementById("indicatorFilter");

                            const ctx2 = document.getElementById("chartDivisionAchievement");
                            let divisionChart = null;

                            /* ==================== INIT DROPDOWN ======================= */

                            // isi tahun
                            adminAvailableYears.forEach(year => {
                                const opt = document.createElement("option");
                                opt.value = year;
                                opt.textContent = year;
                                admFilterTahunEl.appendChild(opt);
                            });
                            admFilterTahunEl.value = defaultYear;

                            indicatorFilterEl.disabled = true;

                            /* ==================== UTIL ======================= */
                            function getFilteredData(data, periode) {
                                let start = 0,
                                    end = 12;
                                if (periode === "Q1") end = 3;
                                if (periode === "Q2") {
                                    start = 3;
                                    end = 6;
                                }
                                if (periode === "Q3") {
                                    start = 6;
                                    end = 9;
                                }
                                if (periode === "Q4") {
                                    start = 9;
                                    end = 12;
                                }
                                return data.slice(start, end);
                            }

                            /* ==================== EMPTY CHART ======================= */
                            function renderEmptyDivisionChart() {
                                const labels = allUnitData[defaultYear].labels;

                                if (divisionChart) divisionChart.destroy();

                                divisionChart = new Chart(ctx2, {
                                    type: "bar",
                                    data: {
                                        labels,
                                        datasets: [{
                                            label: "Tidak ada data",
                                            data: new Array(labels.length).fill(null),
                                            backgroundColor: "rgba(0,0,0,0)"
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                min: 0,
                                                max: 120
                                            }
                                        }
                                    }
                                });
                            }

                            /* ==================== UPDATE INDIKATOR ======================= */
                            function updateIndicatorDropdown() {
                                const unit = unitFilterEl.value;
                                const tahun = admFilterTahunEl.value;

                                indicatorFilterEl.innerHTML = '<option value="">-- Pilih Indikator --</option>';
                                indicatorFilterEl.disabled = true;

                                if (!unit || !allUnitData[tahun][unit]) return;

                                const indikatorObj = allUnitData[tahun][unit].indikators;

                                Object.keys(indikatorObj).forEach(id => {
                                    const opt = document.createElement("option");
                                    opt.value = id;

                                    opt.textContent = indikatorObj[id].nama_indikator ?? `Indikator ${id}`;

                                    indicatorFilterEl.appendChild(opt);
                                });

                                indicatorFilterEl.disabled = false;
                            }

                            /* ==================== UPDATE CHART ======================= */
                            function updateDivisionChart() {
                                const unit = unitFilterEl.value;
                                const tahun = admFilterTahunEl.value;
                                const periode = admFilterPeriodeEl.value;
                                const type = admFilterTipeChartEl.value;
                                const indikatorId = indicatorFilterEl.value;

                                if (!unit || !tahun || !indikatorId) {
                                    renderEmptyDivisionChart();
                                    return;
                                }

                                const indikatorData = allUnitData[tahun][unit]?.indikators?.[indikatorId];
                                if (!indikatorData) {
                                    renderEmptyDivisionChart();
                                    return;
                                }

                                const labels = getFilteredData(allUnitData[tahun].labels, periode);
                                const target = getFilteredData(indikatorData.target, periode);
                                const hasil = getFilteredData(indikatorData.hasil, periode);

                                if (divisionChart) divisionChart.destroy();

                                divisionChart = new Chart(ctx2, {
                                    type,
                                    data: {
                                        labels,
                                        datasets: [{
                                                label: "Target",
                                                data: target,
                                                backgroundColor: "rgba(255,159,64,0.7)",
                                                borderColor: "rgba(255, 159, 64, 1)"
                                            },
                                            {
                                                label: "Realisasi",
                                                data: hasil,
                                                backgroundColor: "rgba(75,192,192,0.7)",
                                                borderColor: "rgba(75, 192, 192, 1)"
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                min: 0,
                                                max: 120
                                            }
                                        }
                                    }
                                });
                            }

                            /* ==================== EVENT ======================= */
                            unitFilterEl.addEventListener("change", () => {
                                updateIndicatorDropdown();
                                updateDivisionChart();
                            });

                            admFilterTahunEl.addEventListener("change", () => {
                                updateIndicatorDropdown();
                                updateDivisionChart();
                            });

                            admFilterPeriodeEl.addEventListener("change", updateDivisionChart);
                            admFilterTipeChartEl.addEventListener("change", updateDivisionChart);
                            indicatorFilterEl.addEventListener("change", updateDivisionChart);

                            renderEmptyDivisionChart();
                        </script>
                    </div>

                    <!-- Indikator Mutu Nasional -->
                    <div class="row adm-chart">
                        <div class="col-12">
                            <div class="card">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Indikator Mutu Nasional</h4>
                                    <div class="d-flex gap-2">
                                        <select id="indicatorsFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Indikator --</option>
                                            @foreach ($indikatorNasionalList as $ind)
                                                <option value="{{ $ind->id }}">
                                                    {{ $ind->nama_indikator }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select id="inmFilterTahun" class="form-select form-select-sm">
                                            @foreach ($nasionalYears as $th)
                                                <option value="{{ $th }}">{{ $th }}</option>
                                            @endforeach
                                        </select>
                                        <select id="inmFilterPeriode" class="form-select form-select-sm">
                                            <option value="Tahun" selected>Data Satu Tahun</option>
                                            <option value="Q1">Q1 (Jan-Mar)</option>
                                            <option value="Q2">Q2 (Apr-Jun)</option>
                                            <option value="Q3">Q3 (Jul-Sep)</option>
                                            <option value="Q4">Q4 (Okt-Des)</option>
                                        </select>

                                        <select id="inmFilterTipeChart" class="form-select form-select-sm">
                                            <option value="line" selected>Line Chart</option>
                                            <option value="bar">Bar Chart</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div style="height: 400px;">
                                        <canvas id="chartINM"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                        <script>
                            const nasionalData = @json($nasionalChartJson);

                            let inmChart;
                            const ctxIMN = document.getElementById('chartINM').getContext('2d');
                            const chartType = document.getElementById('inmFilterTipeChart').value;

                            function getQuarterData(data, periode) {
                                let start = 0,
                                    end = 12;
                                if (periode === 'Q1') end = 3;
                                if (periode === 'Q2') {
                                    start = 3;
                                    end = 6;
                                }
                                if (periode === 'Q3') {
                                    start = 6;
                                    end = 9;
                                }
                                if (periode === 'Q4') {
                                    start = 9;
                                    end = 12;
                                }

                                return {
                                    labels: data.labels.slice(start, end),
                                    target: data.target.slice(start, end),
                                    hasil: data.hasil.slice(start, end),
                                };
                            }

                            function showNoData(message = 'Tidak ada data untuk ditampilkan') {
                                const canvas = document.getElementById('chartINM');
                                const ctx = canvas.getContext('2d');

                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                ctx.font = '16px Arial';
                                ctx.fillStyle = '#6c757d';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(message, canvas.width / 2, canvas.height / 2);
                            }

                            function updateINMChart() {
                                const indikatorId = document.getElementById('indicatorsFilter').value;
                                const tahun = document.getElementById('inmFilterTahun').value;
                                const periode = document.getElementById('inmFilterPeriode').value;
                                const type = document.getElementById('inmFilterTipeChart').value;

                                if (!indikatorId || !nasionalData[indikatorId] || !nasionalData[indikatorId][tahun]) {
                                    if (inmChart) inmChart.destroy();
                                    return;
                                }

                                const base = nasionalData[indikatorId][tahun];
                                const view = getQuarterData(base, periode);

                                if (inmChart) inmChart.destroy();

                                inmChart = new Chart(ctxIMN, {
                                    type: type,
                                    data: {
                                        labels: view.labels,
                                        datasets: [{
                                                label: 'Target',
                                                data: view.target,
                                                borderColor: '#3498db',
                                                backgroundColor: '#3498db',
                                                borderWidth: 2,
                                                pointStyle: 'diamond',
                                                pointRadius: type === 'line' ? 6 : 0
                                            },
                                            {
                                                label: 'Realisasi',
                                                data: view.hasil,
                                                borderColor: '#e74c3c',
                                                backgroundColor: '#e74c3c',
                                                borderWidth: 2,
                                                pointStyle: 'diamond',
                                                pointRadius: type === 'line' ? 6 : 0
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                min: 0,
                                                max: 105,
                                                ticks: {
                                                    stepSize: 5
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    }
                                });
                            }

                            document.getElementById('indicatorsFilter').addEventListener('change', updateINMChart);
                            document.getElementById('inmFilterTahun').addEventListener('change', updateINMChart);
                            document.getElementById('inmFilterPeriode').addEventListener('change', updateINMChart);
                            document.getElementById('inmFilterTipeChart').addEventListener('change', updateINMChart);

                            // auto render pertama
                            updateINMChart();
                        </script>
                    </div>

                    {{-- Indikator Mutu Prioritas RS --}}
                    <div class="row adm-chart">
                        <div class="col-12">
                            <div class="card">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Indikator Mutu Prioritas Rumah Sakit</h4>
                                    <div class="d-flex gap-2">
                                        <select id="catFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Kategori --</option>
                                        </select>
                                        <select id="indicatsFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Indikator --</option>
                                        </select>
                                        <select id="imprsFilterTahun" class="form-select form-select-sm">
                                        </select>
                                        <select id="imprsFilterPeriode" class="form-select form-select-sm">
                                            <option value="Tahun" selected>Data Satu Tahun</option>
                                            <option value="Q1">Q1 (Jan-Mar)</option>
                                            <option value="Q2">Q2 (Apr-Jun)</option>
                                            <option value="Q3">Q3 (Jul-Sep)</option>
                                            <option value="Q4">Q4 (Okt-Des)</option>
                                        </select>

                                        <select id="imprsFilterTipeChart" class="form-select form-select-sm">
                                            <option value="line" selected>Line Chart</option>
                                            <option value="bar">Bar Chart</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div style="height: 400px;">
                                        <canvas id="chartIMPRS"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                    <script>
                        const IMPRS_DATA = @json($chartIMPRSJson);
                        const YEARS = @json($chartIMPRSYears);

                        const labelsBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                        const catFilter = document.getElementById('catFilter');
                        const indFilter = document.getElementById('indicatsFilter');
                        const tahunFilter = document.getElementById('imprsFilterTahun');
                        const periodeFilter = document.getElementById('imprsFilterPeriode');
                        const tipeFilter = document.getElementById('imprsFilterTipeChart');
                        const ctx = document.getElementById('chartIMPRS').getContext('2d');

                        let chart = null;

                        function init() {

                            catFilter.innerHTML = `<option value="">-- Pilih Kategori --</option>`;
                            indFilter.innerHTML = `<option value="">-- Pilih Indikator --</option>`;
                            tahunFilter.innerHTML = '';

                            Object.keys(IMPRS_DATA).forEach(cat => {

                                catFilter.innerHTML += `<option value="${cat}">${cat}</option>`;

                            });

                            YEARS.forEach(y => {
                                tahunFilter.innerHTML += `<option value="${y}">${y}</option>`;
                            });

                            emptyChart('Pilih kategori');
                        }

                        catFilter.onchange = () => {
                            const cat = catFilter.value;
                            indFilter.innerHTML = `<option value="">-- Pilih Indikator --</option>`;

                            if (!cat) return emptyChart('Pilih indikator');

                            Object.entries(IMPRS_DATA[cat].indikators).forEach(([id, obj]) => {
                                indFilter.innerHTML += `<option value="${id}">${obj.judul}</option>`;
                            });

                            emptyChart('Pilih indikator');
                        };

                        [indFilter, tahunFilter, periodeFilter, tipeFilter].forEach(el => {
                            el.onchange = renderChart;
                        });

                        function renderChart() {

                            const cat = catFilter.value;
                            const ind = indFilter.value;
                            const year = tahunFilter.value;
                            const periode = periodeFilter.value;
                            const tipe = tipeFilter.value;

                            if (!cat || !ind || !year) {
                                return emptyChart('Lengkapi filter');
                            }

                            const dataObj = IMPRS_DATA[cat].indikators[ind].data[year];

                            let start = 0,
                                end = 12;
                            if (periode !== 'Tahun') {
                                const map = {
                                    Q1: [0, 3],
                                    Q2: [3, 6],
                                    Q3: [6, 9],
                                    Q4: [9, 12]
                                };
                                [start, end] = map[periode];
                            }

                            chart?.destroy();

                            chart = new Chart(ctx, {
                                type: tipe,
                                data: {
                                    labels: labelsBulan.slice(start, end),
                                    datasets: [{
                                            label: 'Standar',
                                            data: dataObj.target.slice(start, end),
                                            borderColor: '#3498db',
                                            backgroundColor: '#3498db',

                                        },
                                        {
                                            label: 'Capaian',
                                            data: dataObj.hasil.slice(start, end),
                                            borderColor: '#e74c3c',
                                            backgroundColor: '#e74c3c',
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 110,
                                            ticks: {
                                                stepSize: 10,
                                                callback: function(value) {
                                                    return value;
                                                }
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                boxWidth: 12
                                            }
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    }
                                }
                            });
                        }

                        function emptyChart(text) {
                            chart?.destroy();
                            chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [''],
                                    datasets: [{
                                        data: [0],
                                        label: text
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: false
                                        },
                                        y: {
                                            display: false
                                        }
                                    }
                                }
                            });
                        }

                        init();
                    </script>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Hasil Indikator Unit</h4>

                                    <div class="d-flex gap-2">
                                        {{-- FILTER INDIKATOR --}}
                                        <select id="filterIndikator" class="form-select form-select-sm">
                                            @foreach ($indikatorsForChart as $ind)
                                                <option value="{{ $ind->id }}">{{ $ind->nama_indikator }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select id="filterTahun" class="form-select form-select-sm">
                                            @foreach ($years as $th)
                                                <option value="{{ $th }}">{{ $th }}</option>
                                            @endforeach
                                        </select>

                                        <select id="filterPeriode" class="form-select form-select-sm">
                                            <option value="Tahun" selected>Data Satu Tahun</option>
                                            <option value="Q1">Q1 (Jan-Mar)</option>
                                            <option value="Q2">Q2 (Apr-Jun)</option>
                                            <option value="Q3">Q3 (Jul-Sep)</option>
                                            <option value="Q4">Q4 (Okt-Des)</option>
                                        </select>

                                        <select id="filterTipeChart" class="form-select form-select-sm">
                                            <option value="line" selected>Line Chart</option>
                                            <option value="bar">Bar Chart</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="chartMessage" class="text-center text-muted py-3 d-none">
                                        Data belum tersedia untuk indikator & tahun ini
                                    </div>

                                    <canvas id="chart-line-indikator" style="height:400px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                    <script>
                        const allData = {!! $allDataJson !!};
                        const ctx = document.getElementById('chart-line-indikator');
                        const chartMessage = document.getElementById('chartMessage');

                        let myChart;

                        const filterIndikator = document.getElementById('filterIndikator');
                        const filterTahun = document.getElementById('filterTahun');
                        const filterPeriode = document.getElementById('filterPeriode');
                        const filterTipe = document.getElementById('filterTipeChart');

                        function getQuarterData(data, quarter) {
                            let start = 0,
                                end = 12;

                            if (quarter === 'Q1') {
                                start = 0;
                                end = 3;
                            }
                            if (quarter === 'Q2') {
                                start = 3;
                                end = 6;
                            }
                            if (quarter === 'Q3') {
                                start = 6;
                                end = 9;
                            }
                            if (quarter === 'Q4') {
                                start = 9;
                                end = 12;
                            }

                            return {
                                labels: data.labels.slice(start, end),
                                target: data.target.slice(start, end),
                                hasil: data.hasil.slice(start, end)
                            };
                        }

                        function updateChart() {
                            const id = filterIndikator.value;
                            const thn = filterTahun.value;
                            const periode = filterPeriode.value;
                            const type = filterTipe.value;

                            if (!allData[id] || !allData[id][thn]) {
                                if (myChart) myChart.destroy();
                                chartMessage.classList.remove('d-none');
                                return;
                            }

                            chartMessage.classList.add('d-none');

                            const baseData = allData[id][thn];
                            const viewData = getQuarterData(baseData, periode);

                            if (myChart) myChart.destroy();

                            myChart = new Chart(ctx, {
                                type: type,
                                data: {
                                    labels: viewData.labels,
                                    datasets: [{
                                            label: "Target",
                                            data: viewData.target,
                                            borderColor: 'rgba(255,99,132,1)',
                                            backgroundColor: 'rgba(255,99,132,0.6)',
                                            tension: 0.2,
                                            fill: type === 'bar'
                                        },
                                        {
                                            label: "Realisasi",
                                            data: viewData.hasil,
                                            borderColor: 'rgba(54,162,235,1)',
                                            backgroundColor: 'rgba(54,162,235,0.6)',
                                            tension: 0.2,
                                            fill: type === 'bar'
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            min: 0,
                                            max: 100
                                        }
                                    }
                                }
                            });
                        }

                        filterIndikator.addEventListener('change', updateChart);
                        filterTahun.addEventListener('change', updateChart);
                        filterPeriode.addEventListener('change', updateChart);
                        filterTipe.addEventListener('change', updateChart);

                        updateChart();
                    </script>
                @endif

            </div>

        </section>
    </div>

    {{-- modal untuk card --}}
    <div class="modal fade" id="modalSudahIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="text-white">Daftar Progress Indikator Terisi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 30%;">Nama Unit</th>
                                <th>Indikator Sudah Terisi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitsSudah as $unit)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $unit->nama_unit }}</td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($unit->list_sudah as $ind)
                                                <li>{{ $ind }} <i
                                                        class="bi bi-check-circle text-success ms-1"></i></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="fw-normal text-primary">
                                            {{ count($unit->list_sudah) }} / {{ $unit->total_indikator }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBelumIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="text-white">Daftar Indikator Belum Terisi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 30%;">Nama Unit</th>
                                <th>Indikator Belum Terisi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitsBelum as $unit)
                                <tr>
                                    <td class="fw-bold text-danger">{{ $unit->nama_unit }}</td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($unit->list_belum as $ind)
                                                <li>{{ $ind }} <i class="bi bi-x-circle text-danger ms-1"></i>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="fw-bold text-danger">
                                        <div class="fw-normal">{{ count($unit->list_sudah) }} /
                                            {{ count($unit->list_sudah) + count($unit->list_belum) }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
