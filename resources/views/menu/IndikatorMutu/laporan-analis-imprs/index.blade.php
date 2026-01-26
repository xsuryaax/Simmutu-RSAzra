@extends('layouts.app')

@section('title', 'Laporan dan Analisis IMPRS')

@php
    $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);
@endphp

@php
    use Carbon\Carbon;
    $indikatorMulai = $indikators->min(fn($i) => $i->tanggal_mulai);
    $indikatorSelesai = $indikators->max(fn($i) => $i->tanggal_selesai);

    $periodeMulai = Carbon::parse($indikatorMulai);
    $periodeSelesai = Carbon::parse($indikatorSelesai);
    $tahunAktif = range($periodeMulai->year, $periodeSelesai->year);
@endphp

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis IMPRS</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis Indikator Mutu Prioritas RS.
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
                            Laporan dan Analisis IMPRS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">

        {{-- FILTER BULAN & TAHUN --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Bulan</label>
                        <select name="bulan" class="form-select">
                            @php
                                $tahunDipilih = request('tahun', $periodeMulai->year);
                                $bulanMulai = ($tahunDipilih == $periodeMulai->year) ? $periodeMulai->month : 1;
                                $bulanSelesai = ($tahunDipilih == $periodeSelesai->year) ? $periodeSelesai->month : 12;
                            @endphp
                            @for($b = $bulanMulai; $b <= $bulanSelesai; $b++)
                                <option value="{{ $b }}" {{ request('bulan', $periodeMulai->month) == $b ? 'selected' : '' }}>
                                    {{ Carbon::create()->month($b)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tahun</label>
                        <select name="tahun" class="form-select">
                            @foreach($tahunAktif as $t)
                                <option value="{{ $t }}" {{ request('tahun', $periodeMulai->year) == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- REKAP BULANAN --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>Rekap Bulanan IMPRS</h5>
            </div>
            <div class="card-body table-responsive table-dark">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th>KATEGORI</th>
                            <th>INDIKATOR</th>
                            <th class="text-center">TARGET</th>
                            <th class="text-center">NILAI</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($indikators as $indikator)
                            @php
                                $nilaiRekap = $rekapBulanan[$indikator->id]->nilai_rekap ?? null;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $indikator->nama_kategori_imprs }}</td>
                                <td>{{ $indikator->nama_indikator }}</td>
                                <td class="text-center">{{ number_format($indikator->target_indikator, 0) }}%</td>
                                <td class="text-center">
                                    @if($nilaiRekap !== null)
                                        {{ floor($nilaiRekap) == $nilaiRekap ? number_format($nilaiRekap, 0) : number_format($nilaiRekap, 2) }}%
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($nilaiRekap !== null)
                                        @if($nilaiRekap >= $indikator->target_indikator)
                                            <span class="badge bg-success">Tercapai</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tercapai</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Belum Mengisi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="openInputModal({{ $indikator->id }})"
                                        class="text-primary">
                                        <i class="bi bi-pencil-square fs-5 text-dark"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Data Laporan Per Indikator (Semua Data)</h5>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="tableAll">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                @if ($isAdminMutu)
                                    <th class="text-center">UNIT</th>
                                @endif
                                <th class="text-center">PERIODE</th>
                                <th class="text-center">CAPAIAN</th>
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">FILE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @foreach ($indikators as $indikator)
                                @foreach ($laporanAll[$indikator->id] ?? [] as $lap)
                                    @php $no++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $indikator->nama_indikator }}</td>
                                        @if ($isAdminMutu)
                                            <td class="text-center">{{ $lap->nama_unit }}</td>
                                        @endif
                                        <td class="text-center">
                                            {{ Carbon::parse($lap->tanggal_laporan)->translatedFormat('F Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $lap->numerator }} / {{ $lap->denominator }}
                                        </td>
                                        <td class="text-center">{{ number_format($indikator->target_indikator, 0) }}%</td>
                                        <td class="text-center">{{ rtrim(rtrim($lap->nilai, '0'), '.') }}%</td>
                                        <td class="text-center">
                                            @if(!empty($lap->file_laporan))
                                                <a href="{{ asset('storage/' . $lap->file_laporan) }}" target="_blank"
                                                    class="btn btn-lg text-primary" title="Download File Laporan">
                                                    <i class="bi bi-file-earmark-arrow-down fs-5"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL INPUT DATA --}}
        <div class="modal fade" id="modalInputData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-success fw-semibold">+ Tambah Data Indikator</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" enctype="multipart/form-data" action="{{ route('laporan-analis-imprs.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="indikator_id" id="modal_indikator_id">
                            <input type="hidden" name="bulan" value="{{ request('bulan', $periodeMulai->month) }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun', $periodeMulai->year) }}">
                            <input type="hidden" name="tanggal_laporan" id="tanggal_laporan">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Pengisian</label>
                                <input type="text" id="tanggal_laporan_view" class="form-control" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numerator</label>
                                <input type="number" name="numerator" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Denominator</label>
                                <input type="number" name="denominator" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Unggah File</label>
                                <input type="file" name="file_laporan" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script>
        function openInputModal(indikatorId) {
            document.getElementById('modal_indikator_id').value = indikatorId;

            const bulan = String(document.querySelector('input[name="bulan"]').value).padStart(2, '0');
            const tahun = document.querySelector('input[name="tahun"]').value;

            // 🔹 Tanggal laporan untuk backend tetap tanggal 1
            const tanggalLaporan = `${tahun}-${bulan}-01`;
            document.getElementById('tanggal_laporan').value = tanggalLaporan;

            // 🔹 Tanggal yang tampil di modal adalah hari ini
            const today = new Date();
            document.getElementById('tanggal_laporan_view').value =
                today.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });

            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }
    </script>
@endpush