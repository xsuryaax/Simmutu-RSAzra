@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah Frekuensi Analisa Data</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk menambahkan Frekuensi Analisa Data RS Azra.
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
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ url('/frekuensi-analisa-data') }}">Frekuensi Analisa Data</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Frekuensi Analisa Data
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
            <div class="card-header">
                <h4 class="card-title">Tambah Frekuensi Analisa Data</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">Nama Frekuensi Analisa Data</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan nama Frekuensi Analisa Data" id="first-name-icon" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-folder2-open"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        Simpan
                                    </button>
                                    <button class="btn btn-light-secondary me-1 mb-1">
                                        <a href="{{ url('/frekuensi-analisa-data') }}">Kembali</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
