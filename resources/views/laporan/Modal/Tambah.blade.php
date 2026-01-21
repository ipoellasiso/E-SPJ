<div class="modal fade" id="tambahRka" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah / Edit RKA</h5>
      </div>
      <form id="formRka">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal-body">
            <div class="form-group mb-2">
              <label>Sub Kegiatan</label>
              <select name="id_subkegiatan" id="id_subkegiatan" class="form-control" style="width: 100%">
                  <option value="">Pilih Sub Kegiatan...</option>
              </select>
            </div>
            <div class="form-group mb-2">
              <label>PPTK</label>
              <select name="id_pptk" id="id_pptk" class="form-control">
                  <option value="">Pilih PPTK...</option>
                  @foreach($pptk as $p)
                      <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group mb-2">
                <label>Sumber Dana</label>
                <input type="text" name="sumber_dana" id="sumber_dana" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>Pagu Anggaran</label>
                <input type="number" name="pagu_anggaran" id="pagu_anggaran" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" id="saveBtn" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
