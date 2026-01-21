<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SPJ - {{ $spj->nomor_spj }}</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 12px; line-height: 1.4; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .no-border td { border: none !important; }
        .kop { text-align: center; border-bottom: 3px double #000; margin-bottom: 10px; }
        h3, h4, h5 { margin: 5px 0; text-align: center; }
        .page-break { page-break-after: always; }
        .signature td { text-align: center; border: none !important; padding-top: 20px; }
    </style>
</head>
<body>

{{-- ====== KOP SURAT ====== --}}
<div class="kop">
    <img src="{{ public_path('logo_palu.png') }}" style="width:70px; float:left;">
    <h3>{{ strtoupper($instansi) }}</h3>
    <h4>{{ strtoupper($unit_kerja) }}</h4>
    <p><i>{{ $alamat }}</i></p>
</div>

{{-- KWITANSI --}}
<h3><u>KWITANSI</u></h3>
<table class="no-border">
    <tr><td>Nomor</td><td>: {{ $spj->nomor_spj }}</td></tr>
    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($spj->tanggal)->translatedFormat('d F Y') }}</td></tr>
    <tr><td>Telah terima dari</td><td>: <b>{{ $bendahara['jabatan'] }}</b></td></tr>
    <tr><td>Untuk pembayaran</td><td>: {{ $spj->uraian }}</td></tr>
    <tr><td>Jumlah uang</td><td>: <b>Rp {{ number_format($spj->total, 0, ',', '.') }}</b></td></tr>
</table>

<br><br>
<table class="signature">
    <tr>
        <td width="50%"></td>
        <td>Palu, {{ \Carbon\Carbon::parse($spj->tanggal)->translatedFormat('d F Y') }}<br><b>{{ $penerima['jabatan'] }}</b></td>
    </tr>
    <tr>
        <td></td>
        <td><br><br><u>{{ $penerima['nama'] }}</u></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- NOTA PESANAN --}}
<h3><u>NOTA PESANAN</u></h3>
<p>Nomor : {{ $spj->nomor_spj }}</p>
<p>Tanggal : {{ \Carbon\Carbon::parse($spj->tanggal)->translatedFormat('d F Y') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($spj->details as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_barang }}</td>
            <td class="text-center">{{ $d->volume }}</td>
            <td class="text-center">{{ $d->satuan }}</td>
            <td class="text-right">{{ number_format($d->harga, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" class="text-right"><b>Total</b></td>
            <td class="text-right"><b>{{ number_format($spj->total, 0, ',', '.') }}</b></td>
        </tr>
    </tbody>
</table>

<div class="page-break"></div>

{{-- BERITA ACARA PENGADAAN --}}
<h4><u>BERITA ACARA PENGADAAN BARANG</u></h4>
<p>Pada hari ini, tanggal {{ \Carbon\Carbon::parse($spj->tanggal)->translatedFormat('d F Y') }},
telah dilakukan pengadaan barang berupa:</p>

<ul>
@foreach ($spj->details as $d)
<li>{{ $d->nama_barang }} ({{ $d->volume }} {{ $d->satuan }})</li>
@endforeach
</ul>

<p>Demikian berita acara ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>

<div class="page-break"></div>

{{-- BERITA ACARA PEMERIKSAAN --}}
<h4><u>BERITA ACARA PEMERIKSAAN BARANG</u></h4>
<p>Pada hari ini, dilakukan pemeriksaan terhadap barang-barang hasil pengadaan:</p>
<ul>
@foreach ($spj->details as $d)
<li>{{ $d->nama_barang }} - {{ $d->volume }} {{ $d->satuan }}</li>
@endforeach
</ul>

<p>Semua barang telah diperiksa dan sesuai dengan spesifikasi yang ditentukan.</p>

<div class="page-break"></div>

{{-- BERITA ACARA PENYERAHAN --}}
<h4><u>BERITA ACARA PENYERAHAN BARANG</u></h4>
<p>Pada hari ini, barang berikut telah diserahkan kepada {{ $penerima['jabatan'] }}:</p>
<ul>
@foreach ($spj->details as $d)
<li>{{ $d->nama_barang }} - {{ $d->volume }} {{ $d->satuan }}</li>
@endforeach
</ul>

<div class="page-break"></div>

{{-- BERITA ACARA PENERIMAAN --}}
<h4><u>BERITA ACARA PENERIMAAN BARANG</u></h4>
<p>Telah diterima barang-barang hasil pengadaan dengan rincian berikut:</p>
<ul>
@foreach ($spj->details as $d)
<li>{{ $d->nama_barang }} - {{ $d->volume }} {{ $d->satuan }}</li>
@endforeach
</ul>

<p>Barang diterima dalam kondisi baik dan lengkap.</p>

<br><br>
<table class="signature">
    <tr>
        <td>
            Mengetahui,<br><b>{{ $pengguna['jabatan'] }}</b><br><br><br><u>{{ $pengguna['nama'] }}</u><br>NIP. {{ $pengguna['nip'] }}
        </td>
        <td>
            Palu, {{ \Carbon\Carbon::parse($spj->tanggal)->translatedFormat('d F Y') }}<br><b>{{ $penerima['jabatan'] }}</b><br><br><br><u>{{ $penerima['nama'] }}</u>
        </td>
    </tr>
</table>

</body>
</html>
