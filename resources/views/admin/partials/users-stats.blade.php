<div class="row">
    {{-- CARD TOTAL PDSA --}}
    <div class="col-12 col-lg-3 col-md-5 mb-3">
        <a href="{{ route('pdsa.index') }}" class="text-decoration-none">
            <div class="card h-100" style="cursor: pointer">
                <div class="card-body px-4 py-4-5">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted font-bold small mb-1">Total PDSA Unit</h6>
                        <h6 class="font-extrabold mb-0">{{ $pdsaTotal }}</h6>
                    </div>
                    <div class="stats-icon bg-orange">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                </div>
            </div>
        </a>
    </div>

    @php
        $pdsaPerluTindak = $pdsaList->whereIn('status_pdsa', ['assigned', 'revised']);
    @endphp

    @if($pdsaPerluTindak->count() > 0)
        <div class="col-12 col-lg-9 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-light-warning">
                <div class="card-body py-4 px-4 d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">Perhatian!</h5>
                        <p class="mb-0 text-dark">
                            Terdapat <strong>{{ $pdsaPerluTindak->count() }} PDSA</strong> yang perlu diisi atau diperbaiki.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
