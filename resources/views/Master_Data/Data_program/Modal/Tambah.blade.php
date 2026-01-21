<div class="modal fade" id="modalProgram" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formProgram" name="formProgram">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Program</label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Contoh: 1.01.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Program</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama program..." required>
                    </div>

                    <div class="mb-3">
                        <label for="id_unit" class="form-label">Unit Organisasi</label>
                        <select name="id_unit" id="id_unit" class="form-select" required>
                            <option value="">-- Pilih Unit Organisasi --</option>
                            @foreach(DB::table('unit_organisasi')->get() as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
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
