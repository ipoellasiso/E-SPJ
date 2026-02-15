<div class="modal modal-right fade" id="tambahuser" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="side-modal-wrapper">

                <div class="modal-header">
                    <h4 class="modal-title" id="modalUserTitle">Tambah Data User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="userForm" name="userForm" method="POST"
                      action="/user/store" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">

                        {{-- ════════════════════════════ --}}
                        {{-- SECTION: Info Akun           --}}
                        {{-- ════════════════════════════ --}}
                        <div class="mb-3">
                            <p class="fw-bold text-primary border-bottom pb-1 mb-3">
                                <i class="fa fa-user-circle me-1"></i> Informasi Akun
                            </p>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">OPD <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_opd" id="id_opd" style="width:100%" required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="fullname" id="fullname"
                                           placeholder="Nama Lengkap ...." required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Email ...." required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="Kosongkan jika tidak diubah">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fa fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="" hidden>-- Pilih Role --</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Foto Profil</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar"
                                           accept="image/*" onchange="readURL(this);">
                                    <input type="hidden" name="hidden_image" id="hidden_image">
                                    <small class="text-muted">Format: JPG, JPEG, PNG | Maks. 5MB</small>
                                </div>
                                <div class="col-12 text-center mb-2">
                                    <img id="modal-preview"
                                         src="https://via.placeholder.com/100"
                                         alt="Preview Foto"
                                         class="rounded-circle border hidden"
                                         width="80" height="80"
                                         style="object-fit:cover;">
                                </div>
                            </div>
                        </div>

                    </div>{{-- end modal-body --}}

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                        <button type="submit" id="saveBtn" value="create-user" class="btn btn-primary btn-sm">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>