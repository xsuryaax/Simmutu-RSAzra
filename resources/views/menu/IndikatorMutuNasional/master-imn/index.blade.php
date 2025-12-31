@extends('layouts.app')

@section('title', 'Master IMN')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Master Indikator Mutu Nasional</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola Indikator Mutu Nasional dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-primary logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Indikator Mutu Nasional
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                <h5 class="card-title mb-0">Indikator Mutu Nasional</h5>

                <a href="{{ route('master-imn.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th style="width:300px;">INDIKATOR</th>
                                <th>TAHUN</th>
                                <th>STANDAR</th>
                                <th>PERIODE</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($indikators as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_indikator_nasional }}</td>

                                    <td>{{ $row->periode_tahun }}</td>

                                    <td>
                                        {{ rtrim(rtrim($row->target_indikator_nasional, '0'), '.') }}%
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('j') }} -
                                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('j') }}
                                    </td>

                                    <td>
                                        @if ($row->status_indikator_nasional === 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="{{ route('master-imn.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('master-imn.destroy', $row->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus indikator ini?')">
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
