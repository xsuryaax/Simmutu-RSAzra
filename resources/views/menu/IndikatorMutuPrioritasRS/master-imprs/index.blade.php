@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Master IMPRS')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Master Indikator Mutu Prioritas Rumah Sakit</h3>
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
                            Master IMPRS
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
            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                <h5 class="card-title mb-0">Master Indikator Mutu Prioritas Rumah Sakit</h5>

                <a href="{{ route('master-imprs.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th style="width: 150px;">KAT</th>
                                <th>NO</th>
                                <th style="width: 300px;">INDIKATOR</th>
                                <th>STANDAR</th>
                                <th>PERIODE</th>
                                <th>RENTANG WAKTU</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikators as $key => $rows)
                                <tr>
                                    <td>{{ $rows->nama_kategori_imprs }}</td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $rows->nama_imprs }}</td>
                                    <td>{{ rtrim(rtrim($rows->target_imprs, '0'), '.') }}%</td>
                                    <td>{{ $rows->periode_tahun }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($rows->tanggal_mulai)->format('j') }}
                                        -
                                        {{ \Carbon\Carbon::parse($rows->tanggal_selesai)->format('j') }}
                                    </td>
                                    <td>
                                        @if ($rows->status_imprs == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('master-imprs.edit', $rows->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('master-imprs.destroy', $rows->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data ini?')">
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
    </section>
@endsection
