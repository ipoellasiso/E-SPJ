{{-- ═══════════════════════════════════════════ --}}
{{-- MODAL PREVIEW PROFIL USER                   --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="modal fade" id="modalProfil" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-user-circle"></i> Detail Profil User
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">

                {{-- Banner + Foto --}}
                <div class="text-center py-4"
                     style="background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);">
                    <img id="profil-foto"
                         src="https://via.placeholder.com/100"
                         alt="Foto Profil"
                         class="rounded-circle border border-3 border-white shadow"
                         width="100" height="100"
                         style="object-fit:cover;">
                    <h5 class="text-white mt-2 mb-0" id="profil-nama">-</h5>
                    <span class="badge bg-light text-primary mt-1" id="profil-role-badge">-</span>
                </div>

                {{-- Detail Info --}}
                <div class="px-4 py-3">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-semibold" style="width:40%">
                                    <i class="fa fa-building me-1"></i> OPD
                                </td>
                                <td>:</td>
                                <td id="profil-opd">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">
                                    <i class="fa fa-envelope me-1"></i> Email
                                </td>
                                <td>:</td>
                                <td id="profil-email">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">
                                    <i class="fa fa-user-tag me-1"></i> Role
                                </td>
                                <td>:</td>
                                <td id="profil-role">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">
                                    <i class="fa fa-toggle-on me-1"></i> Status
                                </td>
                                <td>:</td>
                                <td id="profil-status">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">
                                    <i class="fa fa-calendar me-1"></i> Tahun
                                </td>
                                <td>:</td>
                                <td id="profil-tahun">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>{{-- end modal-body --}}

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>

        </div>
    </div>
</div>