@extends('Template.Layout')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-10">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
            <div class="col-md-2 text-end">
                <a href="javascript:void(0)" id="createJenis" class="btn btn-outline-primary btn-tone btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
                <a href="{{ route('jenis.template') }}" class="btn btn-outline-success btn-tone btn-sm">
                    <i class="fas fa-download"></i> Template
                </a>
                <button class="btn btn-outline-info btn-tone btn-sm" id="importExcelBtn">
                    <i class="fas fa-file-import"></i> Import
                </button>
                <a href="{{ route('jenis.export') }}" class="btn btn-outline-warning btn-tone btn-sm">
                    <i class="fas fa-file-excel"></i> Export
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelJenis" class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Uraian Jenis</th>
                        <th>Kelompok Belanja</th>
                        <th class="text-center" width="100px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('Master_Data.Data_jenis.Modal.Tambah')
@include('Master_Data.Data_jenis.Modal.Import')
@include('Master_Data.Data_jenis.Fungsi.Fungsi')

@endsection
