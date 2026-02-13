@extends('Template.Layout')
@section('content')

<style>
/* Bungkus teks uraian agar turun ke bawah */
td.wrap-uraian {
    white-space: normal !important;
    word-break: break-word !important;
    white-space: pre-line !important;
    max-width: 350px;   /* Bisa disesuaikan */
}

</style>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h4 class="card-title">{{ $title ?? 'Data SPJ' }}</h4>
            </div>
            <div class="col-md-8"></div>
            <div class="col-md-1">
                <a href="javascript:void(0)" id="createSpj" class="btn btn-outline-primary btn-tone m-r-5 btn-xs ml-auto">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </div>
        </div>

        <br>
        <div class="m-t-25 table-responsive">
            <table id="tabelSpj" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nomor SPJ</th>
                        <th>Tanggal</th>
                        <th>Uraian</th>
                        <th>Total</th>
                        <th>Unit</th>
                        <th class="text-center" width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@include('Spj.Modal.Tambah')
@include('Spj.Fungsi.Fungsi')

@endsection
