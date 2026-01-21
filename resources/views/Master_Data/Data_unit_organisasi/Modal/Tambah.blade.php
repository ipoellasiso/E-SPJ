<div class="modal fade" id="modalUnit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formUnit" name="formUnit">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Unit Organisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Unit</label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Contoh: 1.01.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Unit Organisasi</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama unit..." required>
                    </div>

                    <div class="mb-3">
                        <label for="id_bidang" class="form-label">Bidang Urusan</label>
                        <select name="id_bidang" id="id_bidang" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach(DB::table('bidang_urusan')->get() as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
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
