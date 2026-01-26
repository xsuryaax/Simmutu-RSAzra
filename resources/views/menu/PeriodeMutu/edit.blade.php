@extends('layouts.app')

@section('title', 'Edit Periode Mutu')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Edit Periode Mutu</h3>
            <p class="text-subtitle text-muted">
                Ubah data periode mutu yang sudah ada.
            </p>
        </div>
        <div class="page-header-right">
            <a href="{{ route('periode-mutu.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('periode-mutu.update', $periode->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="nama_periode" class="form-label">Nama Periode</label>
                        <input type="text" class="form-control" id="nama_periode" name="nama_periode"
                            value="{{ old('nama_periode', $periode->nama_periode) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun"
                            value="{{ old('tahun', $periode->tahun) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($periode->tanggal_selesai)->format('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="aktif" {{ old('status', $periode->status) == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="non-aktif" {{ old('status', $periode->status) == 'non-aktif' ? 'selected' : '' }}>
                                Non-Aktif</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
@endsection