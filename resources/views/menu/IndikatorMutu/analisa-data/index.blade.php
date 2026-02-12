@extends('layouts.app')

@section('title', 'Analisa dan Visualisasi')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Analisa dan Visualisasi</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola menganalisis laporan dan visualisasi data indikator mutu.
            </p>
        </div>
        <div class="page-header-right">
            <div class="logout-btn">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Analisa dan Visualisasi
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="row row-cols-sm-1 mb-4">
                <div class="col-12 col-md-5 col-lg-7 col-md-5 px-2">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Laporan Indikator</h5>
                        </div>

                        <div class="card-body">
                            <div class="table-parent-container table-responsive-md table-dark">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th>INDIKATOR</th>
                                            <th class="text-center">ANALISA</th>
                                            <th class="text-center">RENCANA TINDAK LANJUT</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Data dummy tabel --}}
                                        <tr data-indikator="Indikator A">
                                            <td class="text-center">1</td>
                                            <td>Indikator A</td>
                                            <td class="text-center">Analisa untuk Indikator A</td>
                                            <td class="text-center">Rencana tindak lanjut untuk Indikator A</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" onclick="showChart('Indikator A')">
                                                    <i class="bi bi-bar-chart"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="openModal('Indikator A')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-indikator="Indikator B">
                                            <td class="text-center">2</td>
                                            <td>Indikator B</td>
                                            <td class="text-center">Analisa untuk Indikator B</td>
                                            <td class="text-center">Rencana tindak lanjut untuk Indikator B</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" onclick="showChart('Indikator B')">
                                                    <i class="bi bi-bar-chart"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="openModal('Indikator B')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-indikator="Indikator C">
                                            <td class="text-center">3</td>
                                            <td>Indikator C</td>
                                            <td class="text-center">Analisa untuk Indikator C</td>
                                            <td class="text-center">Rencana tindak lanjut untuk Indikator C</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info" onclick="showChart('Indikator C')">
                                                    <i class="bi bi-bar-chart"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="openModal('Indikator C')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-5 col-md-5 px-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-center align-items-center text-center">
                                <div>
                                    <h5 class="mb-1" id="chart-title">Bulan Januari - Desember</h5>
                                    <small class="text-muted" id="chart-subtitle">
                                        Indikator A
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button class="btn btn-sm btn-outline-primary me-2" id="line-chart-btn">Line Chart</button>
                                <button class="btn btn-sm btn-outline-secondary" id="bar-chart-btn">Bar Chart</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="analyst-chart border-0 shadow-sm rounded-3">
                                <canvas id="indicatorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal buat input analisa dan RTL --}}
    <div class="modal fade" id="analysisModal" tabindex="-1" aria-labelledby="analysisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="analysisModalLabel">Input Analisa dan Rencana Tindak Lanjut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="analysisForm">
                        <div class="mb-3">
                            <label for="analisa" class="form-label">Analisa</label>
                            <textarea class="form-control" id="analisa" rows="3" placeholder="Masukkan analisa..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rencana" class="form-label">Rencana Tindak Lanjut</label>
                            <textarea class="form-control" id="rencana" rows="3" placeholder="Masukkan rencana tindak lanjut..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveAnalysis()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dummyData = {
            'Indikator A': {
                target: [100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210],
                realisasi: [95, 105, 115, 125, 135, 145, 155, 165, 175, 185, 195, 205]
            },
            'Indikator B': {
                target: [200, 210, 220, 230, 240, 250, 260, 270, 280, 290, 300, 310],
                realisasi: [190, 200, 210, 220, 230, 240, 250, 260, 270, 280, 290, 300]
            },
            'Indikator C': {
                target: [50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100, 105],
                realisasi: [45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100]
            }
        };

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let currentIndicator = 'Indikator A';
        let chartType = 'line';
        let chart;

        function createChart() {
            const ctx = document.getElementById('indicatorChart');
            if (!ctx) return;

            const data = dummyData[currentIndicator];
            if (chart) chart.destroy();

            chart = new Chart(ctx.getContext('2d'), {
                type: chartType,
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Target',
                            data: data.target,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: chartType === 'bar' ? 'rgba(75, 192, 192, 0.7)' : 'transparent',
                        },
                        {
                            label: 'Realisasi',
                            data: data.realisasi,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: chartType === 'bar' ? 'rgba(255, 99, 132, 0.7)' : 'transparent',
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            });
        }

        window.showChart = function(indicator) {
            console.log("Memuat chart untuk:", indicator);
            currentIndicator = indicator;
            document.getElementById('chart-subtitle').textContent = indicator;
            createChart();
        };

        window.openModal = function(indicator) {
            currentIndicator = indicator;
            document.getElementById('analysisModalLabel').textContent = `Input Analisa untuk ${indicator}`;
            document.getElementById('analisa').value = '';
            document.getElementById('rencana').value = '';

            const modalElement = document.getElementById('analysisModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        };

        window.saveAnalysis = function() {
            const analisa = document.getElementById('analisa').value;
            const rencana = document.getElementById('rencana').value;
            alert(`Tersimpan!\nIndikator: ${currentIndicator}\nAnalisa: ${analisa}`);

            const modalElement = document.getElementById('analysisModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        };

        document.addEventListener('DOMContentLoaded', function() {
            createChart();

            document.getElementById('line-chart-btn').addEventListener('click', () => {
                chartType = 'line';
                createChart();
            });

            document.getElementById('bar-chart-btn').addEventListener('click', () => {
                chartType = 'bar';
                createChart();
            });
        });
    </script>
@endpush
