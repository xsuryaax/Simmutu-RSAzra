@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

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
            <div class="col-12 col-lg-9">
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
                        <div class="card">
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
                        <div class="card">
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

                {{-- ===== CHART ADMIN ===== --}}
                @if (in_array($roleId, [1, 2]))
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Hasil Indikator Semua Unit</h4>

                                    <div class="d-flex gap-2">
                                        <select id="divisionFilter" class="form-select form-select-sm">
                                            <option value="all" selected>-- Semua Unit --</option>
                                        </select>

                                        <select id="indicatorFilter" class="form-select form-select-sm">
                                            <option value="">-- Pilih Indikator --</option>
                                            @foreach ($indikators as $ind)
                                                <option value="{{ $ind->id }}">{{ $ind->nama_indikator }}</option>
                                            @endforeach
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

                        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                        <script>
                            // ==================== DATA =======================
                            const allUnitData = @json($divisionData);

                            // tahun tersedia
                            const adminAvailableYears = Object.keys(allUnitData).reverse();
                            const sampleYear = adminAvailableYears[0];

                            // daftar unit (kecuali labels)
                            const unitNames = Object.keys(allUnitData[sampleYear]).filter(u => u !== "labels");

                            // ==================== ELEMENT =======================
                            const unitFilterEl = document.getElementById("divisionFilter");
                            const admFilterTahunEl = document.getElementById("admFilterTahun");
                            const admFilterPeriodeEl = document.getElementById("admFilterPeriode");
                            const admFilterTipeChartEl = document.getElementById("admFilterTipeChart");
                            const indicatorFilterEl = document.getElementById("indicatorFilter");

                            // ==================== ISI FILTER =======================
                            unitNames.forEach(unit => {
                                const opt = document.createElement("option");
                                opt.value = unit;
                                opt.textContent = unit;
                                unitFilterEl.appendChild(opt);
                            });

                            adminAvailableYears.forEach(year => {
                                const opt = document.createElement("option");
                                opt.value = year;
                                opt.textContent = year;
                                admFilterTahunEl.appendChild(opt);
                            });

                            // ==================== FUNGSI =======================
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

                            let divisionChart;
                            const ctx2 = document.getElementById("chartDivisionAchievement");

                            function renderEmptyDivisionChart() {
                                const tahun = admFilterTahunEl.value || adminAvailableYears[0];
                                const labels = allUnitData[tahun].labels;

                                if (divisionChart) divisionChart.destroy();

                                divisionChart = new Chart(ctx2, {
                                    type: "bar",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Tidak ada data",
                                            data: new Array(labels.length).fill(null),
                                            borderColor: "rgba(0,0,0,0)",
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

                                const unitData = allUnitData[tahun][unit]['indikators'][indikatorId];

                                const labels = getFilteredData(allUnitData[tahun].labels, periode);

                                const datasetTarget = getFilteredData(unitData.target, periode);
                                const datasetHasil = getFilteredData(unitData.hasil, periode);

                                if (divisionChart) divisionChart.destroy();

                                divisionChart = new Chart(ctx2, {
                                    type: type,
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Target",
                                            data: datasetTarget,
                                            borderColor: "rgba(255, 159, 64, 1)",
                                            backgroundColor: "rgba(255, 159, 64, 0.7)"
                                        },
                                        {
                                            label: "Hasil",
                                            data: datasetHasil,
                                            borderColor: "rgba(75, 192, 192, 1)",
                                            backgroundColor: "rgba(75, 192, 192, 0.7)"
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

                            // EVENT
                            unitFilterEl.addEventListener("change", updateDivisionChart);
                            admFilterTahunEl.addEventListener("change", updateDivisionChart);
                            admFilterPeriodeEl.addEventListener("change", updateDivisionChart);
                            admFilterTipeChartEl.addEventListener("change", updateDivisionChart);
                            indicatorFilterEl.addEventListener("change", updateDivisionChart);

                            updateDivisionChart();
                        </script>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
                                    <h4>Hasil Indikator Unit</h4>

                                    <div class="d-flex gap-2">
                                        {{-- FILTER INDIKATOR --}}
                                        <select id="filterIndikator" class="form-select form-select-sm">
                                            @foreach ($indikatorsForChart as $ind)
                                                <option value="{{ $ind->id }}">{{ $ind->nama_indikator }}</option>
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
                                    {{-- PESAN JIKA DATA KOSONG --}}
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
                            let start = 0, end = 12;

                            if (quarter === 'Q1') { start = 0; end = 3; }
                            if (quarter === 'Q2') { start = 3; end = 6; }
                            if (quarter === 'Q3') { start = 6; end = 9; }
                            if (quarter === 'Q4') { start = 9; end = 12; }

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

                            // 🔴 DATA TIDAK ADA
                            if (!allData[id] || !allData[id][thn]) {
                                if (myChart) myChart.destroy();
                                chartMessage.classList.remove('d-none');
                                return;
                            }

                            // 🟢 DATA ADA
                            chartMessage.classList.add('d-none');

                            const baseData = allData[id][thn];
                            const viewData = getQuarterData(baseData, periode);

                            if (myChart) myChart.destroy();

                            myChart = new Chart(ctx, {
                                type: type,
                                data: {
                                    labels: viewData.labels,
                                    datasets: [
                                        {
                                            label: "Target",
                                            data: viewData.target,
                                            borderColor: 'rgba(255,99,132,1)',
                                            backgroundColor: 'rgba(255,99,132,0.6)',
                                            tension: 0.2,
                                            fill: type === 'bar'
                                        },
                                        {
                                            label: "Hasil",
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
            <div class="col-12 col-lg-3">
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
        </section>
    </div>
@endsection