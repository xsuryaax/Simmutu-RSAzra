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
                        <div class="col-6 col-lg-3 col-md-6">
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

                        <div class="col-6 col-lg-3 col-md-6">
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

                        <div class="col-6 col-lg-3 col-md-6">
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

                        <div class="col-6 col-lg-3 col-md-6">
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

                                    opt.textContent = indikatorObj[id].nama_indikator_unit ?? `Indikator ${id}`;

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
                    <div class="row adm-chart">
                        <div class="col-12">
                            <div class="card">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Indikator Mutu Nasional</h4>
                                    <div class="d-flex gap-2">
                                        <select id="indicatorsFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Indikator --</option>
                                            <option value="kebersihan_tangan" selected>Kepatuhan Kebersihan Tangan</option>
                                            <option value="apd">Kepatuhan Penggunaan APD</option>
                                        </select>

                                        <select id="inmFilterTahun" class="form-select form-select-sm">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
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
                            // 1. DUMMY DATA (Sesuai angka di gambar)
                            const rawData = {
                                "kebersihan_tangan": {
                                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agst', 'Sept', 'Okt', 'Nov', 'Des'],
                                    standar: [85, 85, 85, 85, 85, 85, 85, 85, 85, 85, 85, 85],
                                    capaian: [85.99, 87.50, 87.45, 86.22, 85.92, 87.13, 86.38, 85.78, 85.63, 87.08, 87.16, 86.52]
                                },
                                "apd": {
                                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agst', 'Sept', 'Okt', 'Nov', 'Des'],
                                    standar: [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100],
                                    capaian: [98, 99, 100, 97, 99, 100, 98, 99, 99, 100, 100, 100]
                                }
                            };

                            let myChart;
                            const ctxIMN = document.getElementById('chartINM').getContext('2d');

                            // 2. FUNGSI HITUNG TRENDLINE (Regresi Linear Sederhana)
                            function calculateTrendline(data) {
                                const n = data.length;
                                let sumX = 0,
                                    sumY = 0,
                                    sumXY = 0,
                                    sumXX = 0;
                                for (let i = 0; i < n; i++) {
                                    sumX += i;
                                    sumY += data[i];
                                    sumXY += i * data[i];
                                    sumXX += i * i;
                                }
                                const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
                                const intercept = (sumY - slope * sumX) / n;
                                return data.map((_, i) => slope * i + intercept);
                            }

                            // 3. FUNGSI UPDATE CHART
                            function updateChart() {
                                const indicator = document.getElementById('indicatorsFilter').value;
                                const periode = document.getElementById('inmFilterPeriode').value;
                                const type = document.getElementById('inmFilterTipeChart').value;

                                if (!indicator) {
                                    if (myChart) myChart.destroy();
                                    return;
                                }

                                let dataSrc = rawData[indicator];
                                let labels = [...dataSrc.labels];
                                let standar = [...dataSrc.standar];
                                let capaian = [...dataSrc.capaian];

                                // Filter Periode (Triwulan)
                                if (periode !== 'Tahun') {
                                    const qMap = {
                                        'Q1': [0, 3],
                                        'Q2': [3, 6],
                                        'Q3': [6, 9],
                                        'Q4': [9, 12]
                                    };
                                    const [start, end] = qMap[periode];
                                    labels = labels.slice(start, end);
                                    standar = standar.slice(start, end);
                                    capaian = capaian.slice(start, end);
                                }

                                const trendline = calculateTrendline(capaian);

                                if (myChart) myChart.destroy();

                                myChart = new Chart(ctxIMN, {
                                    type: type,
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                                label: 'Target',
                                                data: standar,
                                                borderColor: '#3498db',
                                                backgroundColor: '#3498db',
                                                borderWidth: 2,
                                                pointStyle: 'diamond',
                                                pointRadius: 6,
                                                type: 'line'
                                            },
                                            {
                                                label: 'Capaian',
                                                data: capaian,
                                                borderColor: '#e74c3c',
                                                backgroundColor: '#e74c3c',
                                                borderWidth: 2,
                                                pointStyle: 'diamond',
                                                pointRadius: 6,
                                            }
                                            // {
                                            //     label: 'Linear (Capaian)',
                                            //     data: trendline,
                                            //     borderColor: '#333',
                                            //     borderWidth: 1,
                                            //     pointRadius: 0, // Tanpa titik
                                            //     fill: false,
                                            //     type: 'line'
                                            // }
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

                            // 4. EVENT LISTENERS
                            document.getElementById('indicatorsFilter').addEventListener('change', updateChart);
                            document.getElementById('inmFilterPeriode').addEventListener('change', updateChart);
                            document.getElementById('inmFilterTipeChart').addEventListener('change', updateChart);
                            document.getElementById('inmFilterTahun').addEventListener('change', updateChart);

                            // Init pertama kali
                            updateChart();
                        </script>
                    </div>
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
                                                <option value="{{ $ind->id }}">{{ $ind->nama_indikator_unit }}
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

                                    <canvas id="chart-line-indikator"></canvas>
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
                                            max: 120
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

            {{-- ===================== SIDEBAR KANAN ===================== --}}

        </section>
    </div>

    {{-- modal untuk card --}}
    <div class="modal fade" id="modalSudahIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Daftar Unit Sudah Mengisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach ($unitsSudah as $unit)
                            <li class="list-group-item">
                                {{ $unit->nama_unit }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBelumIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Daftar Unit Belum Mengisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach ($unitsBelum as $unit)
                            <li class="list-group-item">
                                {{ $unit->nama_unit }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
