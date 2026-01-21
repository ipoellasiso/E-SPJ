<div class="modal fade" id="modalRincian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formRincian" name="formRincian">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Rincian Objek Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label>Kode Rincian</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: 5.1.1.01.001" required>
                    </div>

                    <div class="mb-3">
                        <label>Uraian Rincian</label>
                        <input type="text" class="form-control" id="uraian" name="uraian" placeholder="BELANJA GAJI PNS" required>
                    </div>

                    <div class="mb-3">
                        <label>Objek Belanja</label>
                        <select id="id_objek" name="id_objek" class="form-select" required>
                            <option value="">-- Pilih Objek Belanja --</option>
                            @foreach(DB::table('objek')->get() as $o)
                                <option value="{{ $o->id }}">{{ $o->uraian }}</option>
                            @endforeach
                        </select>
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
