<div class="row adm-chart">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center chart-card-header">
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
