@extends('Template.Layout')
@section('content')

<style>
    .toggle-child {
        border: none;
        background: transparent;
        padding: 0;
        margin-right: 5px;
    }

    tr[data-level] td {
        padding-left: calc(var(--level, 0) * 20px);
    }

    .collapsed-row {
        display: none;
    }

    .text-indent {
        text-indent: -10px;   /* geser teks pertama ke kiri sedikit */
        padding-left: 20px;   /* buat jarak antara tanda – dan teks */
    }

    .td-uraian {
        white-space: normal;          /* biar teks bisa turun ke baris berikutnya */
        line-height: 1.4;             /* biar rapi jarak antar baris */
    }

    .td-uraian .subtext {
        display: block;               /* jadi elemen blok */
        padding-left: 18px;           /* jarak dari margin kiri */
        text-indent: -10px;           /* geser tanda “–” ke kiri */
    }

    .td-uraian .subtext::before {
        content: "– ";                /* otomatis tambahkan tanda – */
    }
</style>


<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h4>{{ $title }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('rka.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                {{-- Dropdown Aksi --}}
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear"></i> Aksi
                    </button>
                    <ul class="dropdown-menu shadow">
                        <li class="dropdown-header text-muted small">📁 Export</li>
                        <li>
                            <a class="dropdown-item" href="{{ route('rka.export.excel', $anggaran->id) }}">
                                <i class="bi bi-file-earmark-excel text-success"></i> Export Excel
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('rka.export.pdf', $anggaran->id) }}">
                                <i class="bi bi-file-earmark-pdf text-danger"></i> Export PDF
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-header text-muted small">🧾 Rincian</li>
                        <li>
                            {{-- <a class="dropdown-item" href="javascript:void(0)" id="createRincian">
                                <i class="bi bi-plus-circle text-primary"></i> Tambah Rincian
                            </a> --}}
                            @if($active_lock->is_locked == 0)
                                <button id="createRincian" class="dropdown-item">
                                    <i class="bi bi-plus-circle"></i> Tambah Rincian
                                </button>
                            @else
                                <button class=" dropdown-item" disabled>
                                    <i class="bi bi-lock-fill"></i> Rincian Terkunci
                                </button>
                            @endif
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" id="importRincianBtn">
                                <i class="bi bi-upload text-warning"></i> Import Excel
                            </a>
                        </li>
                        <li>
                            {{-- Tombol download template --}}
                            <a class="dropdown-item" href="{{ route('rka.rincian.template') }}">
                                <i class="bi bi-download"></i> Download Template
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <table class="table table-borderless small">
            <tr><td width="200"><b>Urusan</b></td><td>: {{ $anggaran->subKegiatan->kegiatan->program->bidang->urusan->kode ?? '-' }}  -  {{ $anggaran->subKegiatan->kegiatan->program->bidang->urusan->nama ?? '-' }}</td></tr>
            <tr><td width="200"><b>Bidang Urusan</b></td><td>: {{ $anggaran->subKegiatan->kegiatan->program->bidang->kode ?? '-' }}  -  {{ $anggaran->subKegiatan->kegiatan->program->bidang->nama ?? '-' }}</td></tr>
            <tr><td width="200"><b>Program</b></td><td>: {{ $anggaran->subKegiatan->kegiatan->program->kode ?? '-' }}  -  {{ $anggaran->subKegiatan->kegiatan->program->nama ?? '-' }}</td></tr>
            <tr><td><b>Kegiatan</b></td><td>: {{ $anggaran->subKegiatan->kegiatan->kode ?? '-' }}  -  {{ $anggaran->subKegiatan->kegiatan->nama ?? '-' }}</td></tr>
            <tr><td><b>Sub Kegiatan</b></td><td>: {{ $anggaran->subKegiatan->kode ?? '-' }}  -  {{ $anggaran->subKegiatan->nama ?? '-' }}</td></tr>
            <tr><td width="200"><b>Unit Organisasi</b></td><td>: {{ $anggaran->unit ? $anggaran->unit->kode : '-' }} - {{ $anggaran->unit ? $anggaran->unit->nama : '-' }} </td></tr>
            <tr><td><b>Sumber Dana</b></td><td>: {{ $anggaran->sumber_dana }}</td></tr>
            <tr><td><b>Pagu</b></td><td><p id="totalPagu">: Rp. {{ number_format($anggaran->pagu_anggaran, 0, ',', '.') }} </p></td></tr>
        </table>

        <hr>

        <div class="d-flex justify-content-end mb-2">
            <button id="toggleErrorFilter" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-filter-circle"></i> Tampilkan Hanya Kode Error
            </button>
        </div>

        <div class="table-responsive">
            <table id="tabelRincian" class="table table-bordered small align-middle">
                {{-- HEADER TABEL HANYA SEKALI --}}
                <thead class="table-primary">
                <tr>
                    <th width="180">Kode Rekening</th>
                    <th>Uraian</th>
                    <th width="100">Koefisien</th>
                    <th width="100">Satuan</th>
                    <th width="120">Harga</th>
                    <th width="150">Jumlah</th>
                    <th width="80">Aksi</th>
                </tr>
                </thead>

                {{-- ISI TABEL (BODY) --}}
                <tbody>
                @foreach ($rincian as $r)
                    @include('laporan.partials.rincian-row', [
                    'rincian' => $r,
                    'level' => 0
                    ])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('laporan.Modal.Rincian')
@include('laporan.Fungsi.RincianAjax')
@include('laporan.Modal.Import')

@endsection
