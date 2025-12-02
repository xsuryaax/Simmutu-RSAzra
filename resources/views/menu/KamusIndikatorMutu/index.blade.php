@extends('layouts.app')

@section('title', 'Kamus Indikator Mutu')

@section('page-title')
<div class="page-heading">
    <div class="page-title">
        <div class="row">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kamus Indikator Mutu</h3>
                <p class="text-subtitle text-muted">Data indikator mutu per unit rumah sakit</p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kamus Indikator Mutu</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
</div>
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Kamus Indikator Mutu</h5>

            <a href="{{ route('kamus-indikator-mutu.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
        </div>

        <div class="card-body">
            <table class="table table-striped" id="tableKamus">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Indikator</th>
                        <th>Dimensi Mutu</th>
                        <th>Pengumpulan</th>
                        <th>Cakupan</th>
                        <th>Frekuensi Kumpul</th>
                        <th>Frekuensi Analisa</th>
                        <th>Metode Analisa</th>
                        <th>Interpretasi</th>
                        <th>Publikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($mutu as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nama_indikator }}</td>
                            <td>{{ $m->nama_dimensi_mutu }}</td>
                            <td>{{ $m->nama_metodologi_pengumpulan_data }}</td>
                            <td>{{ $m->nama_cakupan_data }}</td>
                            <td>{{ $m->nama_frekuensi_pengumpulan_data }}</td>
                            <td>{{ $m->nama_frekuensi_analisis_data }}</td>
                            <td>{{ $m->nama_metodologi_analisis_data }}</td>
                            <td>{{ $m->nama_interpretasi_data }}</td>
                            <td>{{ $m->nama_publikasi_data }}</td>

                            <td>
                                <a href="{{ route('kamus-indikator-mutu.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('kamus-indikator-mutu.destroy', $m->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    new simpleDatatables.DataTable("#tableKamus");
</script>
@endpush
