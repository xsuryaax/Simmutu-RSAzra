{{-- MODAL DETAIL DATA --}}
<div class="modal fade" id="modalDetailData" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title text-primary fw-semibold">
                        <i class="bi bi-eye"></i> Detail Laporan
                    </h5>
                    <small class="text-muted">{{ $selectedIndikator->nama_indikator ?? '' }}</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal Laporan</label>
                        <p class="form-control-plaintext" id="detail_tanggal">-</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal Pengisian</label>
                        <p class="form-control-plaintext">
                            <span class="fs-6 text-muted" id="detail_tanggal_pengisian">-</span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Numerator</label>
                        <p class="form-control-plaintext" id="detail_numerator">-</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Denominator</label>
                        <p class="form-control-plaintext" id="detail_denominator">-</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Nilai</label>
                        <p class="form-control-plaintext">
                            <span class="fs-6 text-muted" id="detail_nilai">-</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Status Pencapaian</label>
                        <p class="form-control-plaintext">
                            <span class="badge" id="detail_pencapaian">-</span>
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">File Laporan</label>
                    <p class="form-control-plaintext">
                        <a href="#" id="detail_file_link" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                        </a>
                    </p>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if($isAdminMutu || (isset($isValidatorPage) && $isValidatorPage))
                     <button type="button" class="btn btn-warning" onclick="openEditModal()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                @elseif(isset($isAnalisPage) && $isAnalisPage)
                     <button type="button" class="btn btn-warning" onclick="openEditModal()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
