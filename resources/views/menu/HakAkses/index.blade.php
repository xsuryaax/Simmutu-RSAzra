@extends('layouts.app')

@section('title', 'Manajemen Hak Akses')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Hak Akses</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola hak akses dalam sistem.
            </p>
        </div>
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
                            Manajemen Hak Akses
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="card shadow-sm p-4 rounded-4">

        {{-- PILIH ROLE --}}
        <form method="GET" action="">
            <div class="mb-3">
                <label class="fw-semibold">Pilih Role</label>
                <select name="role_id" class="form-select" onchange="this.form.submit()">
                    @foreach ($roles as $r)
                        <option value="{{ $r->id }}" {{ $selectedRole == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- FORM HAK AKSES --}}
        <form method="POST" action="{{ route('hak-akses.update', $selectedRole) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="role_id" value="{{ $selectedRole }}">

            @foreach ($menuStructure as $groupKey => $group)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            @if ($groupKey === 'main')
                                <i class="bi bi-grid-fill"></i>
                            @elseif($groupKey === 'manajemen')
                                <i class="bi bi-layers-fill"></i>
                            @else
                                <i class="bi bi-folder-fill"></i>
                            @endif
                            {{ $group['title'] }}
                        </h5>

                        <div class="row g-3">
                            @foreach ($group['menus'] as $menu)
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 d-flex align-items-center menu-card" 
                                         style="cursor: pointer;"
                                         data-target="checkbox-{{ $menu['key'] }}">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="checkbox" name="menu_key[]"
                                                id="checkbox-{{ $menu['key'] }}"
                                                value="{{ $menu['key'] }}"
                                                {{ in_array($menu['key'], $hakAkses) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="checkbox-{{ $menu['key'] }}">
                                                {{ $menu['label'] }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endforeach

            <button class="btn btn-primary px-4 py-2">
                Simpan Perubahan
            </button>

        </form>

    </div>

@push('css')
<style>
    .menu-card {
        transition: all 0.2s ease-in-out;
        border: 2px solid #e2e8f0 !important;
    }
    .menu-card:hover {
        background-color: #f8f9fa;
        border-color: #198754 !important;
        transform: translateY(-2px);
    }
    .menu-card.active {
        background-color: #e8f5e9;
        border-color: #198754 !important;
    }
    .menu-card .form-check-input {
        cursor: pointer;
    }
    .menu-card .form-check-label {
        cursor: pointer;
        user-select: none;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.menu-card');
        
        cards.forEach(card => {
            const checkbox = card.querySelector('.form-check-input');
            
            // Initial active state
            if (checkbox.checked) {
                card.classList.add('active');
            }
            
            card.addEventListener('click', function(e) {
                // If clicking the checkbox or its label, the browser handles the toggle.
                // We just need to let it bubble up, but AVOID re-toggling here.
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') {
                    return;
                }
                
                // If they clicked the card background/whitespace
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
            
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });
        });
    });
</script>
@endpush
@endsection
