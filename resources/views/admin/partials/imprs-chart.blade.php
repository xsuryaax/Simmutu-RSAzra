<div class="row adm-chart">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
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
                        order : 2

                    },
                    {
                        label: 'Capaian',
                        data: dataObj.hasil.slice(start, end),
                        borderColor: '#e74c3c',
                        backgroundColor: '#e74c3c',
                        order : 1
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
