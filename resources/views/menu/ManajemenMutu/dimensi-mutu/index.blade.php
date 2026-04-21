@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Dimensi Mutu')
@section('subtitle', 'Daftar kategori dimensi mutu pelayanan kesehatan (Akses, Efisiensi, Keselamatan, dll)')

@section('content')
    <section class="section">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('dimensi-mutu.create') }}" class="btn btn-primary shadow-sm btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Dimensi Mutu
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
                                    @foreach ($dimensimutu as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>

                                            <td>{{ $row->nama_dimensi_mutu }}</td>
                                            <td>
                                                <a href="{{ route('dimensi-mutu.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('dimensi-mutu.destroy', $row->id) }}" method="POST"
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
    </section>
@endsection
