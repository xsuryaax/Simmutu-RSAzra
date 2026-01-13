@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Kategori IMPRS')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Kategori Indikator Mutu Prioritas RS</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola kategori IMPRS dalam sistem.
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
                            Kategori IMPRS
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Kategori Indikator Mutu Prioritas RS</h5>

                <a href="{{ route('kategori-imprs.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Kategori
                </a>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped"  id="table1">
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
                                        <a href="{{ route('kategori-imprs.edit', $row->id) }}" class="btn btn-warning btn-sm">
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
        </div>
    </section>
@endsection
