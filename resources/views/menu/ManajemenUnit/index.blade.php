@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Manajemen Unit')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('subtitle', 'Halaman untuk mengelola unit dalam sistem.')

{{-- Bagian Konten Utama --}}
@section('content')
    <section class="section">
        {{-- total role, user, etc --}}
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Total Unit</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalUnit }}</h6>
                            </div>
                            <div class="stats-icon purple" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-buildings" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Unit Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $unitAktif }}</h6>
                            </div>
                            <div class="stats-icon green" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-building-check" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Unit Tidak Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $unitNonAktif }}</h6>
                            </div>
                            <div class="stats-icon red" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-building-x" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- main content --}}
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Unit Baru</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{ route('manajemen-unit.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Kode Unit</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="kode_unit"
                                                        value="{{ $kode }}" readonly>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-upc"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="nama_unit">Nama Unit</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="nama_unit"
                                                        name="nama_unit" placeholder="Masukkan nama unit">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-building"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="deskripsi_unit">Deskripsi</label>
                                                <div class="position-relative">
                                                    <textarea class="form-control" id="deskripsi_unit" name="deskripsi_unit" placeholder="Masukkan deskripsi unit"
                                                        rows="3"></textarea>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Checkbox Status -->
                                        <div class="col-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="status_unit"
                                                    name="status_unit" value="aktif" checked>
                                                <label class="form-check-label" for="status_unit">
                                                    Unit Aktif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Unit</h5>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-sm" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Unit</th>
                                        <th>Nama Unit</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_unit }}</td>
                                            <td>{{ $item->nama_unit }}</td>
                                            <td>{{ $item->deskripsi_unit }}</td>
                                            <td>
                                                @if ($item->status_unit == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('manajemen-unit.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('manajemen-unit.destroy', $item->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus unit ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            {{-- >>> END OF KOREKSI <<< --}}
        </div>
    </section>
@endsection
