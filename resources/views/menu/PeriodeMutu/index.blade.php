@extends('layouts.app')

@section('title', 'Manajemen Periode Mutu')
@section('subtitle', 'Halaman untuk mengelola periode waktu pelaporan mutu.')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('periode-mutu.create') }}" class="btn btn-primary btn-sm px-3 rounded-pill" style="height: 38px; display: flex; align-items: center; gap: 5px;">
                        <i class="bi bi-plus-lg"></i> Tambah Periode
                    </a>
                </div>

                    <table class="table table-striped table-hover" id="table1">
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
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    @if ($periode->status === 'aktif')
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
