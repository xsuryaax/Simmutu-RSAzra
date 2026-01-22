<div class="col-5 col-lg-2a col-md-5">
    <div class="card" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalPDSA">
        <div class="card-body px-4 py-4-5">
            <div class="row">
                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon bg-orange">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="col-8 col-xxl-7">
                    <h6 class="text-muted font-semibold mb-1">PDSA Perlu Ditindaklanjuti</h6>
                    <h6 class="font-extrabold mb-0">{{ $pdsaTotal }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL PDSA ===== --}}
<div class="modal fade" id="modalPDSA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h5 class="text-white">Daftar PDSA Perlu Ditindaklanjuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Indikator</th>
                            <th class="text-center">Quarter</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pdsaList as $ind)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ind->nama_indikator }}</td>
                                <td class="text-center">{{ $ind->quarter }}</td>
                                <td class="text-center">{{ $ind->tahun }}</td>
                                <td class="text-center">
                                    {{-- BELUM DIISI --}}
                                    @if ($ind->status_pdsa === 'assigned')
                                        <a href="{{ route('pdsa.submit.form', $ind->id) }}"
                                            class="btn btn-sm btn-primary" title="Isi PDSA">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @else
                                        ($ind->status_pdsa === 'submitted')
                                        <a href="{{ route('pdsa.edit', $ind->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit PDSA">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada PDSA
                                    aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
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
