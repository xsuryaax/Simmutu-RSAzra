@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kamus Indikator Mutu</h3>
                    <p class="text-subtitle text-muted">
                        Data indikator mutu per unit di rumah sakit Azra
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <div class="justify-content-end d-flex">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                    <div>
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Kamus Indikator Mutu
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
@endsection

    {{-- Bagian Konten Utama --}}
    @section('content')
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-3">
                    <h5 class="card-title mb-0">Kamus Indikator Mutu</h5>

                    <a href="{{ route('kamus-indikator-mutu.create') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>INDIKATOR</th>
                                    <th>DIMENSI MUTU</th>
                                    <th>METODOLOGI PENGUMPULAN</th>
                                    <th>CAKUPAN DATA</th>
                                    <th>FREKUENSI PENGUMPULAN</th>
                                    <th>FREKUENSI ANALISA</th>
                                    <th>METODOLOGI ANALISA</th>
                                    <th>INTERPRETASI</th>
                                    <th>PUBLIKASI</th>
                                    <th>AKSI</th>
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
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('kamus-indikator-mutu.edit', $m->id) }}"
                                                    class="btn btn-warning btn-sm">
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
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endsection