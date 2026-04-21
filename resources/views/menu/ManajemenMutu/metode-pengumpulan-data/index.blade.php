@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Metode Pengumpulan Data')
@section('subtitle', 'Cara pengambilan data indikator (Retrospektif, Concurrent, dll)')

@section('content')
    <section class="section">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('metode-pengumpulan-data.create') }}" class="btn btn-primary shadow-sm btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Metode Pengumpulan Data
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
                                    @foreach ($metodePengumpulanData as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>

                                            <td>{{ $row->nama_metode_pengumpulan_data }}</td>
                                            <td>
                                                <a href="{{ route('metode-pengumpulan-data.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('metode-pengumpulan-data.destroy', $row->id) }}"
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
