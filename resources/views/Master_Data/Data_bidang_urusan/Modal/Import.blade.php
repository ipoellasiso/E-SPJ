<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formImportExcel" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Upload File Excel (.xlsx / .xls)</label>
                        <input type="file" class="form-control" name="file_excel" id="file_excel" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnImport" class="btn btn-outline-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
