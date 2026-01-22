@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Tambah Metodologi Pengumpulan Data')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Tambah Metodologi Pengumpulan Data</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola metodologi pengumpulan data dalam sistem.
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
                            Tambah Metodologi Pengumpulan Data
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section" id="basic-vertical-layouts">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Metodologi Pengumpulan Data</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('metodologi-pengumpulan-data.store') }}" method="POST" class="form form-vertical">
                    @csrf

                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="nama_metodologi_pengumpulan_data">Nama Metodologi Pengumpulan
                                    Data</label>
                                <input type="text" id="nama_metodologi_pengumpulan_data"
                                    name="nama_metodologi_pengumpulan_data"
                                    class="form-control @error('nama_metodologi_pengumpulan_data') is-invalid @enderror"
                                    value="{{ old('nama_metodologi_pengumpulan_data') }}"
                                    placeholder="Masukkan nama metodologi pengumpulan data" required>
                                @error('nama_metodologi_pengumpulan_data')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('metodologi-pengumpulan-data.index') }}"
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
    </section>
@endsection
