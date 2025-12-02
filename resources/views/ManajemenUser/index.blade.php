@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen User</h3>
                    <p class="text-subtitle text-muted">Pengaturan seluruh user aplikasi</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manajemen User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">

                {{-- ====================== CARD TAMBAH USER ======================= --}}
                <div class="col-md-4 col-12">
                    <div class="card shadow-sm" id="cardTambah">
                        <div class="card-header">
                            <h6 class="mb-0">Tambah User</h6>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('manajemen-user.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role_id" class="form-control" required>
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select name="unit_id" class="form-control">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status User</label>
                                    <select name="status_user" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="non-aktif">Non-Aktif</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Simpan User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ====================== TABLE USER ======================= --}}
                <div class="col-md-8 col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">Data User</div>

                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>
                                                <strong>{{ $u->nama_lengkap }}</strong><br>
                                                <small class="text-muted">{{ $u->username }}</small>
                                            </td>

                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->nama_role }}</td>
                                            <td>{{ $u->nama_unit ?? '-' }}</td>

                                            <td>
                                                @if ($u->status_user == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Non-Aktif</span>
                                                @endif
                                            </td>

                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick='openEditModal(@json($u))'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <form action="{{ route('manajemen-user.destroy', $u->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Hapus user ini?')">
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

    {{-- ====================== MODAL EDIT USER ======================= --}}
    <div class="modal fade" id="modalEditUser" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formEditUser" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" id="eNama" name="nama_lengkap" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" id="eUsername" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="eEmail" name="email" class="form-control" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Password (Opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role_id" id="eRole" class="form-control">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select name="unit_id" id="eUnit" class="form-control">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status User</label>
                                    <select name="status_user" id="eStatus" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="non-aktif">Non-Aktif</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update User
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

        .dataTable-dropdown,
        .dataTable-search {
            margin: 0 !important;
        }
    </style>
    <script>
        let dt = new simpleDatatables.DataTable("#table1");

        // ============== OPEN EDIT MODAL DAN ISI DATA ==============
        function openEditModal(user) {

            document.getElementById('eNama').value = user.nama_lengkap;
            document.getElementById('eUsername').value = user.username;
            document.getElementById('eEmail').value = user.email;
            document.getElementById('eRole').value = user.role_id;
            document.getElementById('eUnit').value = user.unit_id ?? "";
            document.getElementById('eStatus').value = user.status_user;

            // Set action form
            document.getElementById('formEditUser').action = "/manajemen-user/" + user.id;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('modalEditUser')).show();
        }
    </script>
@endpush