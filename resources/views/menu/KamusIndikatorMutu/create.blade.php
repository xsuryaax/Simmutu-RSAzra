@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Tambah Kamus Indikator Mutu</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola kamus indikator mutu dalam sistem.
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
                            Form Tambah Kamus Indikator Mutu
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
                        <h4 class="card-title">Form Tambah Kamus Indikator Mutu</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form action="{{ route('kamus-indikator-mutu.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Dasar</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Indikator <span
                                                        class="text-danger">*</span></label>
                                                <select name="indikator_id" class="form-select">
                                                    <option value="">Pilih Indikator</option>
                                                    @foreach ($indikator as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama_indikator }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Definisi Operasional <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="definisi_operasional" class="form-control" rows="4"></textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tujuan <span class="text-danger">*</span></label>
                                                <textarea name="tujuan" class="form-control" rows="4"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Metodologi</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dimensi Mutu <span
                                                        class="text-danger">*</span></label>
                                                <select name="dimensi_mutu_id" class="form-select">
                                                    <option value="">Pilih Dimensi Mutu</option>
                                                    @foreach ($dimensi as $d)
                                                        <option value="{{ $d->id }}">{{ $d->nama_dimensi_mutu }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dasar Pemikiran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="dasar_pemikiran" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Formula Pengukuran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="formula_pengukuran" class="form-control" rows="3"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Pengumpulan Data</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Metodologi <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="metodologi" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jenis Metodologi <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($metodologiPengumpulan as $item)
                                                    @php($id = 'jenis_' . $item->id)

                                                    <input type="radio" class="btn-check"
                                                        name="metodologi_pengumpulan_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}" autocomplete="off">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_metodologi_pengumpulan_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Cakupan Data <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($cakupan as $item)
                                                    @php($id = 'cakupan_' . $item->id)

                                                    <input type="radio" class="btn-check" name="cakupan_data_id"
                                                        id="{{ $id }}" value="{{ $item->id }}">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_cakupan_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Detail Pengukuran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="detail_pengukuran" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Frekuensi Pengumpulan *</label>

                                                <select class="form-select" name="frekuensi_pengumpulan_data_id" required>
                                                    <option value="">Pilih Frekuensi</option>

                                                    @foreach ($frekuensiPengumpulan as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama_frekuensi_pengumpulan_data }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Sumber Data <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="sumber_data" class="form-control" rows="3"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Analisis Data</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Frekuensi Analisa <span
                                                        class="text-danger">*</span></label>

                                                <select class="form-select" name="frekuensi_analisis_data_id" required>
                                                    <option value="">Pilih Frekuensi</option>

                                                    @foreach ($frekuensiAnalisis as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama_frekuensi_analisis_data }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Metodologi Analisa <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($metodologiAnalisis as $item)
                                                    @php($id = 'analisis_' . $item->id)

                                                    <input type="radio" class="btn-check"
                                                        name="metodologi_analisis_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_metodologi_analisis_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Interpretasi Data <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($interpretasi as $item)
                                                    @php($id = 'interpretasi_' . $item->id)

                                                    <input type="radio" class="btn-check" name="interpretasi_data_id"
                                                        id="{{ $id }}" value="{{ $item->id }}">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_interpretasi_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Penanggung Jawab <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="penanggung_jawab" class="form-control" rows="4" placeholder="Isi penanggung jawab..."></textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Publikasi Data <span
                                                    class="text-danger">*</span></label><br>

                                            @foreach ($publikasi as $item)
                                                @php($id = 'publikasi_' . $item->id)

                                                <input type="radio" class="btn-check" name="publikasi_data_id"
                                                    id="{{ $id }}" value="{{ $item->id }}">

                                                <label class="btn btn-outline-primary" for="{{ $id }}">
                                                    {{ $item->nama_publikasi_data }}
                                                </label>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('kamus-indikator-mutu.index') }}"
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
