@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Periode Pengumpulan Data')
@section('subtitle', 'Frekuensi pengambilan data indikator (Harian, Bulanan, Sewaktu-waktu)')

@section('content')
    <section class="section">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('periode-pengumpulan-data.create') }}" class="btn btn-primary shadow-sm btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Periode Pengumpulan Data
                    </a>
                </div>


                <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($periodePengumpulanData as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>

                                            <td>{{ $row->nama_periode_pengumpulan_data }}</td>
                                            <td>
                                                <a href="{{ route('periode-pengumpulan-data.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('periode-pengumpulan-data.destroy', $row->id) }}"
                                                    method="POST" style="display: inline;">
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
    </section>
@endsection
