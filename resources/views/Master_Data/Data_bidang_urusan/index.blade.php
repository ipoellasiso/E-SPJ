@extends('Template.Layout')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-7">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
            <div class="col-md-5 text-end">
                <a href="javascript:void(0)" id="createBidang" class="btn btn-outline-primary btn-tone btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
                <a href="{{ route('bidang-urusan.template') }}" class="btn btn-outline-success btn-tone btn-sm">
                    <i class="fas fa-download"></i> Template
                </a>
                <button class="btn btn-outline-info btn-tone btn-sm" id="importExcelBtn">
                    <i class="fas fa-file-import"></i> Import Excel
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelBidang" class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Bidang Urusan</th>
                        <th>Nama Urusan</th>
                        <th class="text-center" width="100px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@include('Master_Data.Data_bidang_urusan.Modal.Tambah')
@include('Master_Data.Data_bidang_urusan.Modal.Import')
@include('Master_Data.Data_bidang_urusan.Fungsi.Fungsi')

@endsection