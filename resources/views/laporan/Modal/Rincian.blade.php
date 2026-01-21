<div class="modal fade" id="modalRincian" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formRincian">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah / Edit Rincian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="mb-2">
                <label>Kode Rekening</label>
                <input type="text" class="form-control" id="kode_rekening" name="kode_rekening" required>
            </div>
            <div class="mb-2">
                <label>Uraian</label>
                <input type="text" class="form-control" id="uraian" name="uraian" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                  <label>Koefisien</label>
                  <input type="number" step="any" class="form-control" id="koefisien" name="koefisien">
              </div>
                <div class="col-md-6 mb-2">
                    <label>Satuan</label>
                    <input type="text" class="form-control" id="satuan" name="satuan">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Harga</label>
                    <input type="number" step="any" class="form-control" id="harga" name="harga">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" readonly>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="saveBtn" class="btn btn-primary btn-sm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
