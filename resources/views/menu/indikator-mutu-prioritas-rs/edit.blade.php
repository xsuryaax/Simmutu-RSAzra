@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Edit Indikator Mutu Prioritas Rumah Sakit</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola Indikator Mutu Prioritas Rumah Sakit dalam sistem.
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
                            Form Edit Indikator Mutu Prioritas Rumah Sakit
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
                        <h4 class="card-title">Form Edit Indikator Mutu Prioritas Rumah Sakit</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form action="{{ route('kamus-indikator-mutu.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Edit Indikator</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                {{-- dibuat sesuai id & disetting muted --}}
                                                <label class="form-label">KAT <span class="text-danger">*</span></label>
                                                <select name="indikator_id" class="form-select">
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Indikator <span
                                                        class="text-danger">*</span></label>
                                                <input name="indikator_id" class="form-control">
                                                </input>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Standar Pencapaian Indikator<span
                                                        class="text-danger">*</span></label>
                                                <input name="indikator_id" class="form-control">
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('indikator-mutu-prioritas-rs.index') }}"
                                        class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
