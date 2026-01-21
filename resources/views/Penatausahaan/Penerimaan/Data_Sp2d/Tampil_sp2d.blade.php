@extends('Template.Layout')
@section('content')

<div class="tab-content m-t-15" id="myTabContentJustified">
    <div class="tab-pane fade show active" id="bku" role="tabpanel" aria-labelledby="home-tab-justified">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>

                    <div class="col-md-8 text-end">
                        <button id="btnUploadSp2d" class="btn btn-success btn-sm">
                            <i class="fa fa-upload"></i> Upload SP2D (PDF)
                        </button>
                    </div>
                </div>

                {{-- ✅ TABEL DATA SP2D --}}
                <div class="m-t-25 table-responsive">
                    <table id="data-table" class="datasp2d table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor SPM</th>
                                <th>Tanggal SP2D</th>
                                <th>Nomor SP2D</th>
                                <th>Unit SKPD</th>
                                <th>Nama Penerima</th>
                                <th>Keterangan</th>
                                <th>Jenis SP2D</th>
                                <th>Nilai SP2D</th>                                
                                <th class="text-center" width="100px">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Penatausahaan.Penerimaan.Data_Sp2d.Fungsi.Fungsi')
@include('Penatausahaan.Penerimaan.Data_Sp2d.Modal.Details')
@include('Penatausahaan.Penerimaan.Data_Sp2d.Modal.Upload')

@endsection


