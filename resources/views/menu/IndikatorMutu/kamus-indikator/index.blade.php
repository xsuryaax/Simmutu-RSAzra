@extends('layouts.app')

@section('title', 'Kamus Indikator')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Profil Indikator Mutu </h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola kamus indikator mutu dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
                    @csrf
                    <button type="submit" class="btn btn-primary logout-btn">
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
                            Profil Indikator Mutu
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

{{-- Bagian Konten Utama --}}
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                <h5 class="card-title mb-0">Profil Indikator Mutu</h5>

                <a href="{{ route('kamus-indikator.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 300px;">Indikator</th>
                                <th>Dimensi Mutu</th>
                                <th>Metodologi Pengumpulan</th>
                                <th>Cakupan Data</th>
                                <th>Frekuensi Pengumpulan</th>
                                <th>Frekuensi Analisa</th>
                                <th>Metodologi Analisa</th>
                                <th>Interpretasi</th>
                                <th>Publikasi</th>
                                <th>Jenis Indikator</th>
                                <th>Kategori Indikator</th>
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
                                    <td>{{ $m->jenis_indikator }}</td>
                                    <td>{{ $m->kategori_indikator }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('kamus-indikator.edit', $m->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('kamus-indikator.destroy', $m->id) }}" method="POST"
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
