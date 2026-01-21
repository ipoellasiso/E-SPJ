<!-- Modal Upload SP2D -->
<div class="modal fade" id="modalUploadSp2d" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa fa-upload"></i> Upload Dokumen SP2D (PDF)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="uploadForm" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Pilih File PDF</label>
            <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
          </div>
          <div class="progress mt-3" style="height: 20px; display:none;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" form="uploadForm" class="btn btn-success">
          <i class="fa fa-cloud-upload-alt"></i> Upload
        </button>
      </div>
    </div>
  </div>
</div>
