@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Frekuensi Pengumpulan Data</h3>
                    <p class="text-subtitle text-muted">Silakan ubah data frekuensi pengumpulan data</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('frekuensi-pengumpulan-data.index') }}">Frekuensi Pengumpulan Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Frekuensi Pengumpulan Data</li>
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
                            <h4 class="card-title">Form Edit Frekuensi Pengumpulan Data</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <form action="{{ route('frekuensi-pengumpulan-data.update', $frekuensiPengumpulanData->id) }}" method="POST"
                                    class="form form-vertical">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="nama_frekuensi_pengumpulan_data">Nama Frekuensi Pengumpulan Data</label>
                                                <input type="text" id="nama_frekuensi_pengumpulan_data" name="nama_frekuensi_pengumpulan_data"
                                                    class="form-control @error('nama_frekuensi_pengumpulan_data') is-invalid @enderror"
                                                    value="{{ old('nama_frekuensi_pengumpulan_data', $frekuensiPengumpulanData->nama_frekuensi_pengumpulan_data) }}"
                                                    placeholder="Masukkan nama frekuensi pengumpulan data" required>
                                                @error('nama_frekuensi_pengumpulan_data')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <a href="{{ route('frekuensi-pengumpulan-data.index') }}"
                                                    class="btn btn-light-secondary me-2">
                                                    Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check-circle"></i> Update
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