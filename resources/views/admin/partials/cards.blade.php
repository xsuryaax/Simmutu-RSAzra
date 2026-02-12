<div class="row mb-4">
    <div class="col-5 col-lg-2a col-md-5">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon purple">
                            <i class="bi bi-buildings"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Total Unit</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalUnit }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5 col-lg-2a col-md-5">
        <div class="card" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalSudahIsi">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Indikator Terisi</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalIndikatorSudah }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5 col-lg-2a col-md-5">
        <div class="card" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#modalBelumIsi">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon red">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Indikator Belum</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalIndikatorBelum }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5 col-lg-2a col-md-5">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon blue">
                            <i class="bi bi-bookmark"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Total Indikator</h6>
                        <h6 class="font-extrabold mb-0">{{ $totalIndikator }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="col-5 col-lg-2a col-md-5" href="{{ route('pdsa.index') }}"
        style="cursor: pointer; text-decoration: none;">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                        <div class="stats-icon bg-orange">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                    </div>
                    <div class="col-8 col-xxl-7">
                        <h6 class="text-muted font-semibold mb-1">Total PDSA</h6>
                        <h6 class="font-extrabold mb-0">{{ $pdsaTotal }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
