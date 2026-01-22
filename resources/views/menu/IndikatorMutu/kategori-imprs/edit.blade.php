@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Edit Kategori IMPRS')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Edit Kategori IMPRS</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola kategori imprs dalam sistem.
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
                            Form Edit Kategori IMPRS
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
                <h4 class="card-title">Form Edit Kategori IMPRS</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori-imprs.update', $kategoriimprs->id) }}" method="POST"
                    class="form form-vertical">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nama_kategori_imprs">Nama Kategori</label>
                                <input type="text" id="nama_kategori_imprs" name="nama_kategori_imprs"
                                    class="form-control @error('nama_kategori_imprs') is-invalid @enderror"
                                    value="{{ old('nama_kategori_imprs', $kategoriimprs->nama_kategori_imprs) }}"
                                    placeholder="Masukkan nama kategori" required>
                                @error('nama_kategori_imprs')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('kategori-imprs.index') }}" class="btn btn-light-secondary me-2">
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
    </section>
@endsection
