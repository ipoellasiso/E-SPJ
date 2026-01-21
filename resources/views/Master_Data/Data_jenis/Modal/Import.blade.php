<div class="modal fade" id="modalImportJenis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formImportJenis" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel Jenis Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Pilih File Excel (.xlsx / .xls)</label>
                        <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".xlsx, .xls" required>
                    </div>

                    <p class="text-muted small">
                        📄 Format kolom Excel:
                        <b>kode | uraian | id_kelompok</b><br>
                        <a href="{{ route('jenis.template') }}" class="btn btn-sm btn-outline-success mt-2">
                            <i class="fas fa-download"></i> Download Template
                        </a>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnImport" class="btn btn-outline-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
