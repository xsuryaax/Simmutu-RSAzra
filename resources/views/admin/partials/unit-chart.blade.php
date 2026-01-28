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
        <div class="card" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalSudahIsi">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Indikator Terisi</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalIndikatorSudah }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5 col-lg-2a col-md-5">
        <div class="card" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalBelumIsi">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon red">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Indikator Belum</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalIndikatorBelum }}</h6>
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

    <div class="col-5 col-lg-2a col-md-5" data-bs-toggle="modal" data-bs-target="#modalPdsaList"
        style="cursor: pointer;">
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
                        <h6 class="font-extrabold mb-0">{{ $pdsaTotal }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row adm-chart">
    <div class="col-9 left-chart">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
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
                            borderColor: "rgba(255, 159, 64, 1)",
                            order: 2
                        },
                        {
                            label: "Realisasi",
                            data: hasil,
                            backgroundColor: "rgba(75,192,192,0.7)",
                            borderColor: "rgba(75, 192, 192, 1)",
                            order: 1
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
