@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Role</h3>
                <p class="text-subtitle text-muted">Pengaturan seluruh role pengguna</p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manajemen Role</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- ==================== CARD STATISTIK ===================== --}}
    <div class="row">

        <div class="col-md-4 col-12">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Role</h6>
                        <h2 class="fw-bold mb-0">{{ $total_role }}</h2>
                    </div>
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-people" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-success mb-1">Role Aktif</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $role_aktif }}</h2>
                    </div>
                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-check-circle" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger mb-1">Role Non-Aktif</h6>
                        <h2 class="fw-bold text-danger mb-0">{{ $role_nonaktif }}</h2>
                    </div>
                    <div class="rounded-circle bg-danger text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-x-circle" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <section class="section mt-3">
        <div class="row">

            {{-- ================= CARD TAMBAH ================= --}}
            <div class="col-md-4 col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Tambah Role</h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('manajemen-role.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Role</label>
                                <input type="text" name="nama_role" class="form-control" placeholder="Contoh: Admin, Petugas" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi_role" class="form-control" rows="3" placeholder="Deskripsi role"></textarea>
                            </div>

                            <button class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Simpan Role
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="col-md-8 col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Data Role</span>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                    <th>Deskripsi</th>
                                    <th>Total User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->nama_role }}</td>
                                        <td>{{ $role->deskripsi_role }}</td>
                                        <td>
                                            @if($role->total_user > 0)
                                                <span class="badge bg-success">{{ $role->total_user }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" onclick='openEditModal(@json($role))'>
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ route('manajemen-role.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
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

        </div>
    </section>

</div>

{{-- ===================== MODAL EDIT ROLE ===================== --}}
<div class="modal fade" id="modalEditRole" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="formEditRole">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Role</label>
                        <input type="text" id="editNamaRole" name="nama_role" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea id="editDeskripsiRole" name="deskripsi_role" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .dataTable-wrapper .dataTable-pagination a {
        padding: 3px 6px !important;
        font-size: 11px !important;
        min-width: 28px !important;
    }
    .dataTable-wrapper .dataTable-selector {
        width: 60px !important;
        padding: 4px 6px !important;
        font-size: 12px !important;
    }
    .dataTable-wrapper .dataTable-input {
        padding: 4px 8px !important;
        font-size: 12px !important;
        height: 32px !important;
    }
    .dataTable-top {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>

<script>
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

    function openEditModal(role) {
        document.getElementById('editNamaRole').value = role.nama_role;
        document.getElementById('editDeskripsiRole').value = role.deskripsi_role ?? '';

        document.getElementById('formEditRole').action = "/manajemen-role/" + role.id;

        let modal = new bootstrap.Modal(document.getElementById('modalEditRole'));
        modal.show();
    }
</script>
@endpush
