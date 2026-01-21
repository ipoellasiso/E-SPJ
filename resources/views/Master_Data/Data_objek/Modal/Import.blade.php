<div class="modal fade" id="modalImportObjek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <form id="formImportObjek" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">Import Excel Objek Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label>File Excel (.xlsx / .xls)</label>
                        <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".xlsx,.xls" required>
                    </div>

                    <p class="text-muted small">
                        Format kolom Excel:
                        <b>kode | uraian | id_jenis</b><br>
                        <a href="{{ route('objek.template') }}" class="btn btn-sm btn-outline-success mt-2">
                            Download Template
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
