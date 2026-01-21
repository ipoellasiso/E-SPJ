<div class="modal fade" id="modalSubRincian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formSubRincian" name="formSubRincian">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Sub Rincian Objek Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label>Kode Sub Rincian</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: 5.1.1.01.001.01" required>
                    </div>

                    <div class="mb-3">
                        <label>Uraian Sub Rincian</label>
                        <input type="text" class="form-control" id="uraian" name="uraian" placeholder="BELANJA GAJI PNS GOL II" required>
                    </div>

                    <div class="mb-3">
                        <label>Rincian Objek</label>
                        <select id="id_rincian_objek" name="id_rincian_objek" class="form-select" required>
                            <option value="">-- Pilih Rincian Objek --</option>
                            @foreach(DB::table('rincian_objek')->get() as $r)
                                <option value="{{ $r->id }}">{{ $r->uraian }}</option>
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
