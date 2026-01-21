<div class="modal fade" id="modalObjek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formObjek" name="formObjek">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Objek Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label>Kode Objek</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: 5.1.1.01" required>
                    </div>

                    <div class="mb-3">
                        <label>Uraian Objek</label>
                        <input type="text" class="form-control" id="uraian" name="uraian" placeholder="BELANJA GAJI" required>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Belanja</label>
                        <select id="id_jenis" name="id_jenis" class="form-select" required>
                            <option value="">-- Pilih Jenis Belanja --</option>
                            @foreach(DB::table('jenis')->get() as $j)
                                <option value="{{ $j->id }}">{{ $j->uraian }}</option>
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
