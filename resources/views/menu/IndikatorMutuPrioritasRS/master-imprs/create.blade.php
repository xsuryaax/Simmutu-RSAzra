@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Tambah Master Data IMPRS')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Tambah Master Indikator Mutu Prioritas RS</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator mutu prioritas RS dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
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
                            Form Tambah Master Indikator Mutu Prioritas RS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Indikator Mutu Prioritas RS</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form action="{{ route('master-imprs.store') }}" method="POST" class="form form-vertical">
                                @csrf

                                <div class="form-body">
                                    <div class="row">

                                        {{-- Nama Indikator --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_imprs">Nama Indikator</label>
                                            <input type="text" id="nama_imprs" name="nama_imprs"
                                                class="form-control @error('nama_imprs') is-invalid @enderror"
                                                value="{{ old('nama_imprs') }}"
                                                placeholder="Masukkan nama indikator" required>
                                            @error('nama_imprs')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Kategori --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori_id">Kategori</label>
                                            <select id="kategori_id" name="kategori_id"
                                                class="form-control @error('kategori_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Kategori --</option>

                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori_imprs }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('kategori_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Target --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="target_imprs">Target</label>
                                            <input type="number" id="target_imprs" name="target_imprs"
                                                class="form-control @error('target_imprs') is-invalid @enderror"
                                                value="{{ old('target_imprs') }}"
                                                placeholder="Masukkan target indikator" required>
                                            @error('target_imprs')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Tipe Indikator --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="tipe_imprs">Tipe Indikator</label>
                                            <select id="tipe_imprs" name="tipe_imprs"
                                                class="form-control @error('tipe_imprs') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="lokal"
                                                    {{ old('tipe_imprs') == 'lokal' ? 'selected' : '' }}>Lokal
                                                </option>
                                                <option value="nasional"
                                                    {{ old('tipe_imprs') == 'nasional' ? 'selected' : '' }}>
                                                    Nasional</option>

                                            </select>
                                            @error('tipe_imprs')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Periode Tahun --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="periode_tahun">Periode Tahun</label>
                                            <input type="number" id="periode_tahun" name="periode_tahun"
                                                class="form-control @error('periode_tahun') is-invalid @enderror"
                                                value="{{ old('periode_tahun') }}" placeholder="Masukkan periode tahun"
                                                required>
                                            @error('periode_tahun')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Tanggal Mulai --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                value="{{ old('tanggal_mulai') }}" required>
                                            @error('tanggal_mulai')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Tanggal Selesai --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                value="{{ old('tanggal_selesai') }}" required>
                                            @error('tanggal_selesai')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Status Periode --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Status Periode</label>
                                            <div class="d-flex gap-4 mt-1">

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_periode"
                                                        id="status_aktif" value="aktif"
                                                        {{ old('status_periode', 'aktif') == 'aktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_aktif">Aktif</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_periode"
                                                        id="status_non_aktif" value="non-aktif"
                                                        {{ old('status_periode') == 'non-aktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="status_non_aktif">Non-Aktif</label>
                                                </div>

                                            </div>

                                            @error('status_periode')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Status Indikator --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Status Indikator</label>
                                            <div class="d-flex gap-4 mt-1">

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="status_imprs" id="status_aktif" value="aktif"
                                                        {{ old('status_imprs', 'aktif') == 'aktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_aktif">Aktif</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="status_imprs" id="status_non_aktif"
                                                        value="non-aktif"
                                                        {{ old('status_imprs') == 'non-aktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="status_non_aktif">Non-Aktif</label>
                                                </div>

                                            </div>

                                            @error('status_imprs')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Tombol --}}
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('master-imprs.index') }}"
                                                class="btn btn-light-secondary me-2">
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle"></i> Simpan
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
