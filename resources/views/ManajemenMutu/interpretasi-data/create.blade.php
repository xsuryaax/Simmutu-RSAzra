@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Interpretasi Data</h3>
                    <p class="text-subtitle text-muted">Silakan isi data interpretasi data baru</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('interpretasi-data.index') }}">Interpretasi Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Interpretasi Data</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height">

                <div class="col-md-6 col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Tambah Interpretasi Data</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <form action="{{ route('interpretasi-data.store') }}" method="POST"
                                    class="form form-vertical">
                                    @csrf

                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label for="nama_interpretasi_data">Nama Interpretasi Data</label>
                                                <input type="text" id="nama_interpretasi_data"
                                                    name="nama_interpretasi_data"
                                                    class="form-control @error('nama_interpretasi_data') is-invalid @enderror"
                                                    value="{{ old('nama_interpretasi_data') }}"
                                                    placeholder="Masukkan nama interpretasi data" required>
                                                @error('nama_interpretasi_data')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <a href="{{ route('interpretasi-data.index') }}"
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

    </div>
@endsection