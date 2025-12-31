@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Tambah Unit')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Tambah Unit</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola unit dalam sistem.
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
                            Tambah Unit
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Form Section --}}
    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Unit</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form action="{{ route('manajemen-unit.store') }}" method="POST" class="form form-vertical">
                                @csrf

                                <div class="form-body">
                                    <div class="row">
                                        {{-- Kode Unit --}}
                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="kode_unit">Kode Unit</label>
                                                <input type="text" id="kode_unit" name="kode_unit" class="form-control"
                                                    value="{{ $kode }}" readonly>

                                                @error('kode_unit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Nama Unit --}}
                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="nama_unit">Nama Unit</label>
                                                <input type="text" id="nama_unit" name="nama_unit"
                                                    class="form-control @error('nama_unit') is-invalid @enderror"
                                                    placeholder="Masukkan nama unit" value="{{ old('nama_unit') }}"
                                                    required>

                                                @error('nama_unit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Keterangan --}}
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="deskripsi_unit">Keterangan</label>
                                                <textarea id="deskripsi_unit" name="deskripsi_unit" rows="3"
                                                    class="form-control @error('deskripsi_unit') is-invalid @enderror" placeholder="Masukkan keterangan unit">{{ old('deskripsi_unit') }}</textarea>

                                                @error('deskripsi_unit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-3 mb-3">
                                            <label class="form-label d-block">Status</label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_unit"
                                                    id="status_aktif" value="aktif"
                                                    {{ old('status_unit', 'aktif') == 'aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_aktif">Aktif</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_unit"
                                                    id="status_non_aktif" value="non-aktif"
                                                    {{ old('status_unit') == 'non-aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_non_aktif">Non-Aktif</label>
                                            </div>

                                            @error('status_unit')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Tombol --}}
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('manajemen-unit.index') }}"
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
