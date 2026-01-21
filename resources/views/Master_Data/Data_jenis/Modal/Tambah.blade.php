<div class="modal fade" id="modalJenis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formJenis" name="formJenis">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Jenis Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jenis</label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Contoh: 5.1.1" required>
                    </div>

                    <div class="mb-3">
                        <label for="uraian" class="form-label">Uraian Jenis</label>
                        <input type="text" class="form-control" name="uraian" id="uraian" placeholder="BELANJA PEGAWAI" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_kelompok" class="form-label">Kelompok Belanja</label>
                        <select name="id_kelompok" id="id_kelompok" class="form-select" required>
                            <option value="">-- Pilih Kelompok --</option>
                            @foreach(DB::table('kelompok')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->uraian }}</option>
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
