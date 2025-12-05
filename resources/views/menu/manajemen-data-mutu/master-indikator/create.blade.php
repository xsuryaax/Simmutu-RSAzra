@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah Indikator</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk menambahkan indikator mutu RS Azra.
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
                            <a href="{{ url('/master-indikator') }}">Master Indikator</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Indikator
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
                <h4 class="card-title">Tambah Indikator</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="mobile-id-icon">Unit</label>
                                        <div class="position-relative">
                                            <fieldset class="form-group">
                                                <select class="form-select" id="basicSelect">
                                                    <option>IT</option>
                                                    <option>B</option>
                                                    <option>C</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">Nama Indikator</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Masukkan nama indikator"
                                                id="first-name-icon" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-journal-bookmark-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">Target Persentase</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan target persentase" id="first-name-icon" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-percent"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="mobile-id-icon">Tipe Indikator</label>
                                        <div class="position-relative">
                                            <fieldset class="form-group">
                                                <select class="form-select" id="basicSelect">
                                                    <option>A</option>
                                                    <option>B</option>
                                                    <option>C</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="email-id-icon">Tanggal Mulai Periode</label>
                                        <div class="position-relative">
                                            <input type="date" class="form-control"
                                                placeholder="Masukkan tanggal mulai periode" id="email-id-icon" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-calendar-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="password-id-icon">Tanggal Selesai Periode</label>
                                        <div class="position-relative">
                                            <input type="date" class="form-control"
                                                placeholder="Masukkan tanggal selesai periode" id="password-id-icon" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-calendar2-x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <div class="checkbox mt-2">
                                            <input type="checkbox" id="remember-me-v" class="form-check-input" checked />
                                            <label for="remember-me-v">Aktifkan Periode</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <div class="checkbox mt-2">
                                            <input type="checkbox" id="remember-me-v" class="form-check-input" checked />
                                            <label for="remember-me-v">Status Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        Simpan
                                    </button>
                                    <button class="btn btn-light-secondary me-1 mb-1">
                                        <a href="{{ url('/master-indikator') }}">Kembali</a>
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
