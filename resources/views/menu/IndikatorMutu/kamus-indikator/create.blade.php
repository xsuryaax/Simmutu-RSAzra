@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah Kamus Indikator Mutu</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola kamus indikator mutu dalam sistem.
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

                            <form action="{{ route('kamus-indikator.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Dasar</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Indikator <span
                                                        class="text-danger">*</span></label>
                                                <select name="indikator_id" class="form-select right-input">
                                                    <option value="">Pilih Indikator</option>
                                                    @foreach ($indikator as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama_indikator }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Definisi Operasional <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="definisi_operasional" class="form-control right-input" rows="4"></textarea>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Tujuan <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="tujuan" class="form-control right-input" rows="4"></textarea>
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

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Dimensi Mutu <span class="text-danger">*</span></label>
                                                    <div class="right-input">
                                                        @foreach ($dimensi as $d)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="dimensi_mutu_id[]" value="{{ $d->id }}" id="dimensi_{{ $d->id }}">
                                                                <label class="form-check-label" for="dimensi_{{ $d->id }}">
                                                                    {{ $d->nama_dimensi_mutu }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Dasar Pemikiran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="dasar_pemikiran" class="form-control right-input" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Formula Pengukuran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="formula_pengukuran" class="form-control right-input" rows="3"></textarea>
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

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Metodologi <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="metodologi" class="form-control right-input" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Jenis Metodologi <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($metodologiPengumpulan as $item)
                                                    @php($id = 'jenis_' . $item->id)

                                                    <input type="radio" class="btn-check right-input"
                                                        name="metodologi_pengumpulan_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}" autocomplete="off">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_metodologi_pengumpulan_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Cakupan Data <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($cakupan as $item)
                                                    @php($id = 'cakupan_' . $item->id)

                                                    <input type="radio" class="btn-check right-input"
                                                        name="cakupan_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_cakupan_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Detail Pengukuran <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="detail_pengukuran" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Frekuensi Pengumpulan *</label>

                                                <select class="form-select right-input"
                                                    name="frekuensi_pengumpulan_data_id" required>
                                                    <option value="">Pilih Frekuensi</option>

                                                    @foreach ($frekuensiPengumpulan as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama_frekuensi_pengumpulan_data }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Sumber Data <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="sumber_data" class="form-control right-input" rows="3"></textarea>
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
                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Frekuensi Analisa <span
                                                        class="text-danger">*</span></label>

                                                <select class="form-select right-input" name="frekuensi_analisis_data_id"
                                                    required>
                                                    <option value="">Pilih Frekuensi</option>

                                                    @foreach ($frekuensiAnalisis as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama_frekuensi_analisis_data }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Metodologi Analisa <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($metodologiAnalisis as $item)
                                                    @php($id = 'analisis_' . $item->id)

                                                    <input type="radio" class="btn-check right-input"
                                                        name="metodologi_analisis_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}">

                                                    <label class="btn btn-outline-primary" for="{{ $id }}">
                                                        {{ $item->nama_metodologi_analisis_data }}
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12 mb-3 add-input">
                                                <label class="form-label left-input">Interpretasi Data <span
                                                        class="text-danger">*</span></label><br>

                                                @foreach ($interpretasi as $item)
                                                    @php($id = 'interpretasi_' . $item->id)

                                                    <input type="radio" class="btn-check right-input"
                                                        name="interpretasi_data_id" id="{{ $id }}"
                                                        value="{{ $item->id }}">

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
                                        <div class="col-md-12 mb-3 add-input">
                                            <label class="form-label left-input">Penanggung Jawab <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="penanggung_jawab" class="form-control right-input" rows="4"
                                                placeholder="Isi penanggung jawab..."></textarea>
                                        </div>

                                        <div class="col-md-12 mb-3 add-input">
                                            <label class="form-label left-input">Publikasi Data <span
                                                    class="text-danger">*</span></label><br>

                                            @foreach ($publikasi as $item)
                                                @php($id = 'publikasi_' . $item->id)

                                                <input type="radio" class="btn-check right-input"
                                                    name="publikasi_data_id" id="{{ $id }}"
                                                    value="{{ $item->id }}">

                                                <label class="btn btn-outline-primary" for="{{ $id }}">
                                                    {{ $item->nama_publikasi_data }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3 add-input">
                                            <label class="form-label left-input">
                                                Jenis Indikator <span class="text-danger">*</span>
                                            </label>
                                            @foreach (['Prioritas Unit', 'Nasional', 'Prioritas RS'] as $jenis)
                                                @php($id = 'jenis_' . strtolower(str_replace(' ', '_', $jenis)))
                                                <input type="checkbox"
                                                    class="btn-check jenis-indikator right-input"name="jenis_indikator[]"
                                                    id="{{ $id }}" value="{{ $jenis }}">
                                                <label class="btn btn-outline-primary" for="{{ $id }}">
                                                    {{ $jenis }}
                                                </label>
                                            @endforeach
                                        </div>

                                        <div class="col-md-12 mb-3 add-input">
                                            <div id="kategoriImprsWrapper" class="d-none">
                                                <label class="form-label left-input">
                                                    Kategori IMPRS <span class="text-danger">*</span>
                                                </label>
                                                <select name="kategori_id" class="form-select right-input">
                                                    <option value="">Pilih Kategori IMPRS</option>
                                                    @foreach ($kategoriImprs as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nama_kategori_imprs }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-4">
                                    <button class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('kamus-indikator.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const indikatorCheckbox = document.querySelectorAll('.jenis-indikator');
            const kategoriWrapper = document.getElementById('kategoriImprsWrapper');

            function toggleKategori() {
                let isPrioritasRS = false;

                indikatorCheckbox.forEach(cb => {
                    if (cb.checked && cb.value === 'Prioritas RS') {
                        isPrioritasRS = true;
                    }
                });

                kategoriWrapper.classList.toggle('d-none', !isPrioritasRS);
            }

            indikatorCheckbox.forEach(cb => {
                cb.addEventListener('change', toggleKategori);
            });

            toggleKategori(); // untuk reload / edit
        });
    </script>
@endpush
