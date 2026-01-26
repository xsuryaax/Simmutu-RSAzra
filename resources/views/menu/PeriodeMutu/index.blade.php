@extends('layouts.app')

@section('title', 'Master Periode Mutu')

@section('page-title')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3>Master Periode Mutu</h3>
            <p class="text-subtitle text-muted">
                Pengaturan periode global untuk laporan indikator mutu.
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center">
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
                                Master Periode Mutu
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body table-responsive table-dark">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Daftar Periode Mutu</h5>
                    <a href="{{ route('periode-mutu.create') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Periode
                    </a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th>NAMA PERIODE</th>
                            <th class="text-center">TAHUN</th>
                            <th class="text-center">TANGGAL MULAI</th>
                            <th class="text-center">TANGGAL SELESAI</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periodes as $i => $periode)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $periode->nama_periode }}</td>
                                <td class="text-center">{{ $periode->tahun }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }}
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    @if($periode->status === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('periode-mutu.edit', $periode->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('periode-mutu.destroy', $periode->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada periode mutu
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection