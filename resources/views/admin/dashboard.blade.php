@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Konten Utama --}}
@section('content')
    <div class="page-heading">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Profile Statistics</h3>
            <form method="POST" action="/logout">
                <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->name }}</strong></span>
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-13 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-buildings"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Total Unit
                                        </h6>
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Unit Sudah Mengisi Indikator</h6>
                                        <h6 class="font-extrabold mb-0">80.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-x-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Unit Belum Mengisi Indikator</h6>
                                        <h6 class="font-extrabold mb-0">112</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- chart ditampilkan sesuai role login --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Hasil Pelaksanaan Indikator Unit</h4>

                                <div class="d-flex gap-2">
                                    <select id="filterTahun" class="form-select form-select-sm" style="width: 100px;">
                                    </select>

                                    <select id="filterPeriode" class="form-select form-select-sm" style="width: 170px;">
                                        <option value="Tahun" selected>Data Satu Tahun</option>
                                        <option value="Q1">Q1 (Jan-Mar)</option>
                                        <option value="Q2">Q2 (Apr-Jun)</option>
                                        <option value="Q3">Q3 (Jul-Sep)</option>
                                        <option value="Q4">Q4 (Okt-Des)</option>
                                    </select>

                                    <select id="filterTipeChart" class="form-select form-select-sm" style="width: 130px;">
                                        <option value="line" selected>Line Chart</option>
                                        <option value="bar">Bar Chart</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chart-line-indikator"></canvas>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

                    <script>
                        const allData = {
                            '2024': {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                target: [10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65],
                                achievement: [12, 14, 18, 23, 32, 33, 38, 47, 49, 53, 58, 62]
                            },
                            '2023': {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                target: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60],
                                achievement: [6, 8, 14, 22, 28, 29, 36, 42, 44, 48, 52, 58]
                            }
                        };
                        const availableYears = Object.keys(allData).reverse();

                        const ctx1 = document.getElementById('chart-line-indikator');
                        let myChart;

                        const filterTahunEl = document.getElementById('filterTahun');
                        const filterPeriodeEl = document.getElementById('filterPeriode');
                        const filterTipeChartEl = document.getElementById('filterTipeChart');

                        // Isi filter Tahun 
                        availableYears.forEach(year => {
                            const option = document.createElement('option');
                            option.value = year;
                            option.textContent = year;
                            filterTahunEl.appendChild(option);
                        });

                        // Logika Pemrosesan Data Triwulan
                        function getQuarterData(data, quarter) {
                            let start, end;
                            switch (quarter) {
                                case 'Q1':
                                    start = 0;
                                    end = 3;
                                    break; // Jan, Feb, Mar (index 0, 1, 2)
                                case 'Q2':
                                    start = 3;
                                    end = 6;
                                    break; // Apr, Mei, Jun
                                case 'Q3':
                                    start = 6;
                                    end = 9;
                                    break; // Jul, Agu, Sep
                                case 'Q4':
                                    start = 9;
                                    end = 12;
                                    break; // Okt, Nov, Des
                                case 'Tahun': // Tampilkan seluruh tahun
                                default:
                                    start = 0;
                                    end = 12;
                                    break;
                            }

                            // Potong array data
                            return {
                                labels: data.labels.slice(start, end),
                                target: data.target.slice(start, end),
                                achievement: data.achievement.slice(start, end)
                            };
                        }

                        // Filter untuk perubahan bentuk chart (line/bar)
                        function updateChart() {
                            const selectedYear = filterTahunEl.value;
                            const selectedPeriode = filterPeriodeEl.value;
                            const selectedTipe = filterTipeChartEl.value;

                            const baseData = allData[selectedYear];

                            // Ambil data yang sudah difilter (sesuai tahun, periode, dll)
                            const currentData = getQuarterData(baseData, selectedPeriode);

                            // Hapus chart lama (kalau ada)
                            if (myChart) {
                                myChart.destroy();
                            }

                            // Buat Chart Baru
                            myChart = new Chart(ctx1, {
                                type: selectedTipe,
                                data: {
                                    labels: currentData.labels,
                                    datasets: [{
                                            label: 'Target',
                                            data: currentData.target,
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                            fill: selectedTipe === 'line' ? false : true,
                                            tension: 0.1
                                        },
                                        {
                                            label: 'Hasil',
                                            data: currentData.achievement,
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                            fill: selectedTipe === 'line' ? false : true,
                                            tension: 0.1
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    // label sumbu X merupakan periode (tahun) yang dipilih
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: selectedPeriode === 'Tahun' ? `Bulan pada Tahun ${selectedYear}` :
                                                    `${selectedPeriode} Tahun ${selectedYear}`
                                            }
                                        },
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }

                        filterTahunEl.addEventListener('change', updateChart);
                        filterPeriodeEl.addEventListener('change', updateChart);
                        filterTipeChartEl.addEventListener('change', updateChart);

                        updateChart();
                    </script>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon blue mb-2">
                                    <i class="bi bi-bookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Indikator</h6>
                                <h6 class="font-extrabold mb-0">127</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Terakhir Mengisi</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/faces/4.jpg') }}" />
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">SIRS</h5>
                                <h6 class="text-muted mb-0">08:12:2025 14:48</h6>
                            </div>
                        </div>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/faces/5.jpg') }}" />
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Marketing</h5>
                                <h6 class="text-muted mb-0">08:12:2025 13:39</h6>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <h4>Visitors Profile</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div> --}}
            </div>
        </section>
        <section>
            {{-- chart untuk admin --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Hasil Indikator Semua Unit</h4>

                            <div class="d-flex gap-2">
                                <select id="divisionFilter" class="form-select form-select-sm" style="width: 150px;">
                                    <option value="all" selected>-- Semua Unit --</option>
                                </select>

                                <select id="admFilterTahun" class="form-select form-select-sm" style="width: 100px;">
                                </select>

                                <select id="admFilterPeriode" class="form-select form-select-sm" style="width: 170px;">
                                    <option value="Tahun" selected>Data Satu Tahun</option>
                                    <option value="Q1">Q1 (Jan-Mar)</option>
                                    <option value="Q2">Q2 (Apr-Jun)</option>
                                    <option value="Q3">Q3 (Jul-Sep)</option>
                                    <option value="Q4">Q4 (Okt-Des)</option>
                                </select>

                                <select id="admFilterTipeChart" class="form-select form-select-sm" style="width: 130px;">
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
                    // --- DATA DUMMY LENGKAP (Bulanan per Tahun per Unit) ---
                    const allUnitData = {
                        '2024': {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            'IT': {
                                targets: [10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65],
                                achievements: [12, 14, 18, 23, 32, 33, 38, 47, 49, 53, 58, 62]
                            },
                            'Marketing': {
                                targets: [20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75],
                                achievements: [18, 27, 32, 33, 42, 43, 49, 57, 61, 63, 68, 70]
                            }
                        },
                        '2023': {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            'IT': {
                                targets: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60],
                                achievements: [6, 8, 14, 22, 28, 29, 36, 42, 44, 48, 52, 58]
                            },
                            'Marketing': {
                                targets: [15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70],
                                achievements: [14, 22, 24, 32, 36, 42, 43, 52, 53, 58, 62, 68]
                            }
                        }
                    };
                    const adminAvailableYears = Object.keys(allUnitData).reverse();
                    const unitNames = Object.keys(allUnitData['2024']).filter(key => key !== 'labels');

                    const ctx2 = document.getElementById('chartDivisionAchievement');
                    let divisionChart;

                    // Dapatkan elemen filter
                    const unitFilterEl = document.getElementById('divisionFilter');
                    const admFilterTahunEl = document.getElementById('admFilterTahun');
                    const admFilterPeriodeEl = document.getElementById('admFilterPeriode');
                    const admFilterTipeChartEl = document.getElementById('admFilterTipeChart');

                    // Isi filter Unit dan Tahun secara dinamis
                    unitNames.forEach(name => {
                        const option = document.createElement('option');
                        option.value = name;
                        option.textContent = name;
                        unitFilterEl.appendChild(option);
                    });
                    adminAvailableYears.forEach(year => {
                        const option = document.createElement('option');
                        option.value = year;
                        option.textContent = year;
                        admFilterTahunEl.appendChild(option);
                    });

                    // --- Logika Pemotongan Data (Quarter/Tahun) ---
                    function getFilteredData(data, periode) {
                        let start, end;
                        switch (periode) {
                            case 'Q1':
                                start = 0;
                                end = 3;
                                break;
                            case 'Q2':
                                start = 3;
                                end = 6;
                                break;
                            case 'Q3':
                                start = 6;
                                end = 9;
                                break;
                            case 'Q4':
                                start = 9;
                                end = 12;
                                break;
                            case 'Tahun':
                            default:
                                start = 0;
                                end = 12;
                                break;
                        }

                        // Ambil data bulanan yang sudah dipotong (slice)
                        const filtered = {
                            labels: data.labels.slice(start, end)
                        };

                        // Ambil data target/achievement per unit yang sudah dipotong
                        unitNames.forEach(unit => {
                            filtered[unit] = {
                                targets: data[unit].targets.slice(start, end),
                                achievements: data[unit].achievements.slice(start, end)
                            };
                        });
                        return filtered;
                    }


                    // Fungsi Utama untuk Membuat/Memperbarui Chart
                    function updateDivisionChart() {
                        const selectedUnit = unitFilterEl.value;
                        const selectedYear = admFilterTahunEl.value;
                        const selectedPeriode = admFilterPeriodeEl.value;
                        const selectedTipe = admFilterTipeChartEl.value;

                        const baseDataPerYear = allUnitData[selectedYear];

                        // 1. Filter Data Berdasarkan Periode (Q1, Q2, Q3, Q4, atau Tahun)
                        const currentData = getFilteredData(baseDataPerYear, selectedPeriode);

                        // 2. Tentukan Datasets Berdasarkan Filter Unit
                        let datasets = [];

                        if (selectedUnit === 'all') {
                            // Semua Unit (Hanya Hasil)
                            unitNames.forEach((unit, index) => {
                                datasets.push({
                                    label: `Hasil ${unit}`,
                                    data: currentData[unit].achievements,
                                    borderColor: `hsl(${index * 60}, 70%, 50%)`,
                                    backgroundColor: `hsla(${index * 60}, 70%, 50%, 0.7)`,
                                    fill: selectedTipe === 'line' ? false : true,
                                    tension: 0.1
                                });
                            });

                        } else {
                            // Unit Tertentu (Target & Hasil)
                            const unitData = currentData[selectedUnit];
                            datasets.push({
                                label: 'Target Unit ' + selectedUnit,
                                data: unitData.targets,
                                borderColor: 'rgba(255, 159, 64, 1)',
                                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                                fill: selectedTipe === 'line' ? false : true,
                                tension: 0.1
                            });
                            datasets.push({
                                label: 'Hasil Unit ' + selectedUnit,
                                data: unitData.achievements,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                fill: selectedTipe === 'line' ? false : true,
                                tension: 0.1
                            });
                        }

                        // Hancurkan dan Buat Chart Baru
                        if (divisionChart) {
                            divisionChart.destroy();
                        }

                        divisionChart = new Chart(ctx2, {
                            type: selectedTipe,
                            data: {
                                labels: currentData.labels,
                                datasets: datasets,
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        stacked: false,
                                        title: {
                                            display: true,
                                            text: `${selectedPeriode} Tahun ${selectedYear}`
                                        }
                                    },
                                    y: {
                                        stacked: false,
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    unitFilterEl.addEventListener('change', updateDivisionChart);
                    admFilterTahunEl.addEventListener('change', updateDivisionChart);
                    admFilterPeriodeEl.addEventListener('change', updateDivisionChart);
                    admFilterTipeChartEl.addEventListener('change', updateDivisionChart);

                    updateDivisionChart();
                </script>
            </div>
        </section>
    </div>
@endsection
