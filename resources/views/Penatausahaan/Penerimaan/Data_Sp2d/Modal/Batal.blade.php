<div class="modal fade bd-example-modal-xl" id="batalsp2dtpp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <!-- <div class="modal-dialog modal-dialog-scrollable modal-dialog modal-xl"> -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
  
        <div class="modal-content">
            <div class="modal-header bg-primary">
                {{-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
              <div class="modal-body">
                    <form id="userFormBatal" name="userFormBatal" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="row mb-4">
                                    <div class="col">
                                        <label>Id SP2D</label>
                                        <input type="text" class="form-control" name="idhalaman" id="idhalaman12" value="" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <label>Nomor SP2D</label>
                                        <input type="text" class="form-control" name="nomor_sp2d" id="nomor_sp2d" value="" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger m-b-xs" data-bs-dismiss="modal">
                    <i class="fas fa-times-circle"></i> Close
                </button>
                <button type="submit" id="saveBtnBatal" value="create" class="btn btn-outline-primary m-b-xs">
                    <i class="fa fa-save"></i>  Batalkan
                </button>
            </div>
              </div>
            </form>
            </div>
        </div>
    </div>
</div>

