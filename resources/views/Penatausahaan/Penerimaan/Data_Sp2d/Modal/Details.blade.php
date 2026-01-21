<!-- Modal Detail SP2D -->
<div class="modal fade" id="modalDetailSp2d" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold"><i class="fa fa-file-alt me-2"></i> Detail SP2D</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="sp2dTabs" role="tablist">
          <li class="nav-item"><button class="nav-link active" id="tab-header" data-bs-toggle="tab" data-bs-target="#content-header" type="button" role="tab">Header</button></li>
          <li class="nav-item"><button class="nav-link" id="tab-belanja" data-bs-toggle="tab" data-bs-target="#content-belanja" type="button" role="tab">Rekening Belanja</button></li>
          <li class="nav-item"><button class="nav-link" id="tab-potongan" data-bs-toggle="tab" data-bs-target="#content-potongan" type="button" role="tab">Potongan</button></li>
        </ul>

        <div class="tab-content">
          <!-- TAB HEADER -->
          <div class="tab-pane fade show active" id="content-header" role="tabpanel">
            <div id="sp2dHeader" class="p-3 border rounded bg-light"></div>
          </div>

          <!-- TAB BELANJA -->
          <div class="tab-pane fade" id="content-belanja" role="tabpanel">
            <table class="table table-bordered table-sm align-middle mt-2" id="tblBelanja">
              <thead class="table-primary">
                <tr>
                  <th style="width:5%">No</th>
                  <th>Kode Rekening</th>
                  <th>Uraian</th>
                  <th class="text-end">Nilai (Rp)</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total Belanja:</th>
                  <th id="totalBelanja" class="text-end text-primary"></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- TAB POTONGAN -->
          <div class="tab-pane fade" id="content-potongan" role="tabpanel">
            <table class="table table-bordered table-sm align-middle mt-2" id="tblPotongan">
              <thead class="table-danger">
                <tr>
                  <th style="width:5%">No</th>
                  <th>Uraian</th>
                  <th class="text-end">Nilai (Rp)</th>
                  <th>ID Billing</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">Total Potongan:</th>
                  <th id="totalPotongan" class="text-end text-danger"></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>
