@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Frekuensi Pengumpulan Data</h3>
                    <p class="text-subtitle text-muted">
                        Data frekuensi pengumpulan data rumah sakit Azra
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
                                    Tambah Frekuensi Pengumpulan Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @section('content')
        <section id="basic-vertical-layouts">
            <div class="row match-height">

                <div class="col-md-6 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Tambah Frekuensi Pengumpulan Data</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <form action="{{ route('frekuensi-pengumpulan-data.store') }}" method="POST"
                                    class="form form-vertical">
                                    @csrf

                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label for="nama_frekuensi_pengumpulan_data">Nama Frekuensi Pengumpulan
                                                    Data</label>
                                                <input type="text" id="nama_frekuensi_pengumpulan_data"
                                                    name="nama_frekuensi_pengumpulan_data"
                                                    class="form-control @error('nama_frekuensi_pengumpulan_data') is-invalid @enderror"
                                                    value="{{ old('nama_frekuensi_pengumpulan_data') }}"
                                                    placeholder="Masukkan nama frekuensi pengumpulan data" required>
                                                @error('nama_frekuensi_pengumpulan_data')
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
                    </div>
                </div>
            </div>
        </section>
    @endsection