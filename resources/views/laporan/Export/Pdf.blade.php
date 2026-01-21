<h4 style="text-align:center;">RINCIAN ANGGARAN BELANJA KEGIATAN (RKA)</h4>

<table width="100%" style="font-size:13px; margin-bottom:10px;">
    <tr><td width="200">Program</td><td>: {{ $anggaran->subKegiatan->kegiatan->program->nama }}</td></tr>
    <tr><td>Kegiatan</td><td>: {{ $anggaran->subKegiatan->kegiatan->nama }}</td></tr>
    <tr><td>Sub Kegiatan</td><td>: {{ $anggaran->subKegiatan->nama }}</td></tr>
    <tr><td>Sumber Dana</td><td>: {{ $anggaran->sumber_dana }}</td></tr>
    <tr><td>Pagu</td><td>: Rp{{ number_format($anggaran->pagu_anggaran,0,',','.') }}</td></tr>
</table>

<table border="1" width="100%" cellspacing="0" cellpadding="4" style="font-size:12px;">
    <thead>
        <tr>
            <th>Kode Rekening</th>
            <th>Uraian</th>
            <th>Koefisien</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rincian as $r)
            @include('laporan.partials.rincian-row', ['rincian' => $r, 'level' => 0])
        @endforeach
    </tbody>
</table>
