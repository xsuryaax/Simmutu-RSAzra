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
                        <h6 class="text-muted font-semibold mb-1">Indikator Sudah Terisi</h6>
                        <h6 class="font-extrabold mb-0">{{ $unitSudahIsi }}</h6>
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
                        <h6 class="text-muted font-semibold mb-1">Indikator Belum Terisi</h6>
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
            <div class="card-header">
                {{-- BARIS 1 --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0">Indikator Mutu Prioritas Unit</h4>

                    <button class="btn btn-danger btn-sm" onclick="exportChart(divisionChart, 'Grafik Indikator Unit')">
                        Export PDF
                    </button>

                </div>

                {{-- BARIS 2 --}}
                <div class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <select id="admFilterTahun" class="form-select form-select-sm"></select>
                    </div>

                    <div class="col-md-3">
                        <select id="divisionFilter" class="form-select form-select-sm">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($unitIndikatorMap as $unitName => $items)
                                <option value="{{ $unitName }}">{{ $unitName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="indicatorFilter" class="form-select form-select-sm" disabled>
                            <option value="">-- Pilih Indikator --</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select id="admFilterPeriode" class="form-select form-select-sm">
                            <option value="Tahun">Data Satu Tahun</option>
                            <option value="Q1">Q1</option>
                            <option value="Q2">Q2</option>
                            <option value="Q3">Q3</option>
                            <option value="Q4">Q4</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select id="admFilterTipeChart" class="form-select form-select-sm">
                            <option value="line">Line</option>
                            <option value="bar">Bar</option>
                        </select>
                    </div>
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

    <form id="exportPdfForm" method="POST" action="{{ route('export.pdf.chart') }}" target="_blank">
        @csrf
        <input type="hidden" name="chart_image">
        <input type="hidden" name="judul">
    </form>

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
                    responsive: true, // ✅ Tetap responsive untuk tampilan
                    maintainAspectRatio: true,
                    devicePixelRatio: 2, // ✅ Naikkan dikit biar lebih tajam
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
                    }]
                },
                options: {
                    responsive: true, // ✅ Tetap responsive
                    maintainAspectRatio: true,
                    devicePixelRatio: 2, // ✅ Naikkan dikit
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

        /* ==================== EXPORT CHART (YANG PALING PENTING) ======================= */
        function exportChart(chartInstance, judul) {
            if (!chartInstance) {
                alert('Chart belum tersedia');
                return;
            }

            // Validasi chart tidak kosong
            const hasData = chartInstance.data.datasets.some(dataset =>
                dataset.data && dataset.data.some(v => v !== null && v !== undefined)
            );

            if (!hasData) {
                alert('Silakan pilih unit & indikator terlebih dahulu');
                return;
            }

            // 🔥 KUNCI: Buat canvas HD temporary tanpa ganggu tampilan
            const originalCanvas = chartInstance.canvas;

            // Ukuran HD untuk export (landscape A4 optimal)
            const exportWidth = 1600;  // Lebar HD
            const exportHeight = 900;  // Tinggi HD (ratio 16:9)

            // Buat canvas temporary
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = exportWidth;
            tempCanvas.height = exportHeight;

            const tempCtx = tempCanvas.getContext('2d');

            // Background putih
            tempCtx.fillStyle = 'white';
            tempCtx.fillRect(0, 0, exportWidth, exportHeight);

            // Hitung scale ratio
            const scaleX = exportWidth / originalCanvas.width;
            const scaleY = exportHeight / originalCanvas.height;

            // Gunakan scale yang lebih kecil agar proporsional
            const scale = Math.min(scaleX, scaleY);

            // Hitung posisi center
            const x = (exportWidth - (originalCanvas.width * scale)) / 2;
            const y = (exportHeight - (originalCanvas.height * scale)) / 2;

            // Render chart dengan kualitas tinggi
            tempCtx.imageSmoothingEnabled = true;
            tempCtx.imageSmoothingQuality = 'high';
            tempCtx.drawImage(
                originalCanvas,
                x, y,
                originalCanvas.width * scale,
                originalCanvas.height * scale
            );

            // Convert ke base64 dengan kualitas maksimal
            const base64Image = tempCanvas.toDataURL('image/png', 1.0);

            document.querySelector('[name=chart_image]').value = base64Image;
            document.querySelector('[name=judul]').value = judul;
            document.getElementById('exportPdfForm').submit();
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