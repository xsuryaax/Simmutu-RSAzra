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
                                        @forelse($indikators as $i => $ind)
                                            <tr>
                                                <td class="text-center">{{ $i + 1 }}</td>
                                                <td>{{ $ind->nama_indikator }}</td>

                                                <td class="text-center">
                                                    {{ $analisaData[$ind->id]['analisa'] ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $analisaData[$ind->id]['tindak_lanjut'] ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning" onclick="openModal(
                                                        {{ $ind->id }},
                                                        '{{ addslashes($ind->nama_indikator) }}',
                                                        '{{ addslashes($analisaData[$ind->id]['analisa'] !== '-' ? $analisaData[$ind->id]['analisa'] : '') }}',
                                                        '{{ addslashes($analisaData[$ind->id]['tindak_lanjut'] !== '-' ? $analisaData[$ind->id]['tindak_lanjut'] : '') }}'
                                                    )">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-info"
                                                        onclick="loadChart({{ $ind->id }}, '{{ $ind->nama_indikator }}', '{{ $ind->nama_unit }}')">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    Tidak ada data indikator
                                                </td>
                                            </tr>
                                        @endforelse
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
                                    <h5 class="mb-1" id="chart-title">Nama Indikator</h5>
                                    <small class="text-muted" id="chart-subtitle">
                                        Nama Unit
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
                        @csrf
                        <input type="hidden" id="indikator_id">

                        <div class="mb-3">
                            <label class="form-label">Analisa</label>
                            <textarea class="form-control" id="analisa"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tindak Lanjut</label>
                            <textarea class="form-control" id="tindak_lanjut"></textarea>
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
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'];

        let chart;
        let chartType = 'line';

        function renderChart(targetData, realisasiData) {

            const ctx = document.getElementById('indicatorChart');

            if (chart) chart.destroy();

            chart = new Chart(ctx.getContext('2d'), {
                type: chartType,
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Target',
                            data: targetData
                        },
                        {
                            label: 'Realisasi',
                            data: realisasiData
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            });
        }

        window.loadChart = function (indikatorId, namaIndikator, namaUnit) {

            // Judul = Nama indikator
            document.getElementById('chart-title').textContent = namaIndikator;

            // Subtitle = Unit
            document.getElementById('chart-subtitle').textContent = namaUnit;

            fetch(`/analisa-data/chart/${indikatorId}`)
                .then(res => res.json())
                .then(res => {
                    renderChart(res.target, res.realisasi);
                })
                .catch(err => {
                    console.log(err);
                    alert("Gagal memuat chart");
                });
        };

        window.openModal = function (id, nama, analisa = '', tindakLanjut = '') {
            document.getElementById('indikator_id').value = id;
            document.getElementById('analysisModalLabel').textContent = `Edit Analisa untuk ${nama}`;
            document.getElementById('analisa').value = analisa;
            document.getElementById('tindak_lanjut').value = tindakLanjut;
            const modal = new bootstrap.Modal(document.getElementById('analysisModal'));
            modal.show();
        };


        window.saveAnalysis = function () {

            let indikator_id = document.getElementById('indikator_id').value;
            let analisa = document.getElementById('analisa').value;
            let tindak_lanjut = document.getElementById('tindak_lanjut').value;

            let formData = new FormData();
            formData.append('indikator_id', indikator_id);
            formData.append('analisa', analisa);
            formData.append('tindak_lanjut', tindak_lanjut);

            fetch("{{ route('analisa-data.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert("Analisa berhasil disimpan");
                        location.reload();
                    }
                })
                .catch(err => {
                    console.log(err);
                    alert("Terjadi error di server");
                });
        };

        document.addEventListener('DOMContentLoaded', function () {

            @if($firstIndikator)
                loadChart(
                                            {{ $firstIndikator->id }},
                    "{{ $firstIndikator->nama_indikator }}",
                    "{{ $firstIndikator->nama_unit }}"
                );
            @endif

            document.getElementById('line-chart-btn').addEventListener('click', () => {
                chartType = 'line';
                if (chart) renderChart(chart.data.datasets[0].data, chart.data.datasets[1].data);
            });

            document.getElementById('bar-chart-btn').addEventListener('click', () => {
                chartType = 'bar';
                if (chart) renderChart(chart.data.datasets[0].data, chart.data.datasets[1].data);
            });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush