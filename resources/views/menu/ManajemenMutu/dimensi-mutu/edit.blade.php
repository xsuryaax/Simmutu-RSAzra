@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Dimensi Mutu</h3>
                    <p class="text-subtitle text-muted">Silakan ubah data dimensi mutu</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dimensi-mutu.index') }}">Dimensi Mutu</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Dimensi Mutu</li>
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
                            <h4 class="card-title">Form Edit Dimensi Mutu</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <form action="{{ route('dimensi-mutu.update', $dimensimutu->id) }}" method="POST"
                                    class="form form-vertical">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="nama_dimensi_mutu">Nama Dimensi Mutu</label>
                                                <input type="text" id="nama_dimensi_mutu" name="nama_dimensi_mutu"
                                                    class="form-control @error('nama_dimensi_mutu') is-invalid @enderror"
                                                    value="{{ old('nama_dimensi_mutu', $dimensimutu->nama_dimensi_mutu) }}"
                                                    placeholder="Masukkan nama dimensi mutu" required>
                                                @error('nama_dimensi_mutu')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <a href="{{ route('dimensi-mutu.index') }}"
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