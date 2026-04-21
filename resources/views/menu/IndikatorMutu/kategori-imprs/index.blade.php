@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Kategori IMPRS')
@section('subtitle', 'Pengelompokan indikator mutu berdasarkan standar akreditasi dan prioritas RS')

@section('content')
    <section class="section">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('kategori-imprs.create') }}" class="btn btn-primary shadow-sm btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
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
                                    @foreach ($kategoriimprs as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>

                                            <td>{{ $row->nama_kategori_imprs }}</td>

                                            <td>
                                                <a href="{{ route('kategori-imprs.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('kategori-imprs.destroy', $row->id) }}" method="POST"
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
