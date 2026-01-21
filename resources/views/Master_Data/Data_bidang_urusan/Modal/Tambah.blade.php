<div class="modal fade" id="modalBidang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formBidang" name="formBidang">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label>Kode Bidang</label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode Bidang" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Bidang</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Bidang" required>
                    </div>
                    <div class="mb-3">
                        <label>Urusan</label>
                        <select name="id_urusan" id="id_urusan" class="form-control">
                            @foreach(DB::table('urusan')->get() as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="saveBtn" class="btn btn-outline-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
