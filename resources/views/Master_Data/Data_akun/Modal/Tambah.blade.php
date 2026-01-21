<div class="modal fade" id="modalAkun" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formAkun" name="formAkun">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Akun Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Akun</label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Contoh: 5" required>
                    </div>

                    <div class="mb-3">
                        <label for="uraian" class="form-label">Uraian Akun</label>
                        <input type="text" class="form-control" name="uraian" id="uraian" placeholder="BELANJA" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="saveBtn" class="btn btn-outline-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
