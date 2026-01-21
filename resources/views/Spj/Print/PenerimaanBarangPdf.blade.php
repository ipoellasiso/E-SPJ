<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: "Book Antiqua"; font-size: 15px; }
        table { width: 100%; border-collapse: collapse; }
        .table-bordered td, .table-bordered th { border: 1px solid black; padding: 6px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .ttd { width: 33%; height: 100px; vertical-align: bottom; }
    </style>
</head>
<body>

{{-- HEADER --}}
<!-- HEADER -->
<table width="100%" class="noborder">
    <tr>
        <!-- LOGO -->
        <td style="width: 60px; text-align: left; vertical-align: top;">
            <img src="{{ public_path('logo/palu.png') }}" style="width: 50px;">
        </td>

        <!-- TEKS HEADER -->
        <td style="text-align: center;">
            <div style="font-size: 18px; font-weight: bold; display:flex; align-items:center; margin-right:80px;">
                PEMERINTAH KOTA PALU
            </div>

            <div style="font-size: 18px; font-weight: bold; margin-top:2px; display:flex; align-items:center; margin-right:80px;">
                {{ strtoupper($unit->nama ?? '-') }}
            </div>

            <div style="font-size: 12px; margin-top:2px; display:flex; align-items:center; margin-right:80px;">
                {{ $unit->alamat ?? '' }}
            </div>
        </td>
    </tr>
</table>

<hr style="margin-top:10px; border: 1px solid #000;">

<br>
<div class="center bold" style="font-size: 17px;">
    <u>BERITA ACARA PENERIMAAN BARANG</u>
</div>
<div class="center">
    Nomor : {{ $nomor }}
</div>

<br>

{{-- REDAKSI --}}
<p>
    Pada hari ini <b>{{ $hari }}</b> tanggal <b>{{ $hariHuruf }}</b> bulan <b>{{ $bulanHuruf }}</b> tahun <b>{{ $tahunHuruf }}</b>,
    kami yang bertanda tangan di bawah ini :
</p>

<table style="width: 60%;">
    <tr><td>Nama</td><td>: {{ $pengurus_barang }}</td></tr>
    <tr><td>NIP</td><td>: {{ $nip_pengurus }}</td></tr>
    <tr><td>Jabatan</td><td>: Pengurus Barang</td></tr>
</table>

<p style="text-align:justify;">
    Berdasarkan keputusan Walikota Palu Nomor : <b>{{ $sk_nomor ?? '-' }}</b>, Tanggal <b>{{ $sk_tanggal ?? '-' }}</b> Sesuai dengan Surat Pesanan/SPK/Nota Pesanan Nomor : <b>{{ $spj->nomor_nota }}</b>, Menyatakan telah menerima barang yang diserahkan oleh penyedia Barang/Jasa, dalam keadaan baik dan Atau barang yang telah diadakan sesuai sebagaimana yang tercamtum di bawah ini :
</p>

<br>

{{-- TABEL BARANG --}}
<table class="table-bordered">
    <thead class="center bold">
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
            <td class="center">{{ $i+1 }}</td>
            <td>{{ $d->nama_barang }}</td>
            <td style="text-align:center;">{{ rtrim(rtrim(number_format($d->volume,2,'.',''), '0'), '.') }}</td>
            <td class="center">{{ $d->satuan }}</td>
            <td style="text-align:right;">{{ number_format($d->harga,0,',','.') }}</td>
            <td style="text-align:right;">{{ number_format($d->jumlah,0,',','.') }}</td>
        </tr>
        @endforeach
        <tr class="bold">
            <td colspan="5" class="center">Total</td>
            <td style="text-align:right;">{{ number_format($total,0,',','.') }}</td>
        </tr>
        <tr>
            <td colspan="6"><i>Terbilang : {{ $terbilang }}</i></td>
        </tr>
    </tbody>
</table>

<br><br>

{{-- TTD --}}
<table width="100%">
    <tr class="center">
        <td>PEJABAT PEMBUAT KOMITMEN</td>
        <td>PENGURUS BARANG</td>
    </tr>

    <tr>
        <td class="ttd center bold">{{ $ppk }}</td>
        <td class="ttd center bold">{{ $pengurus_barang }}</td>
    </tr>

    <tr>
        <td class="center">NIP. {{ $nip_ppk }}</td>
        <td class="center">NIP. {{ $nip_pengurus }}</td>
    </tr>
</table>

{{-- <br><br><br><br>

<div class="center bold">Mengetahui</div>
<div class="center bold">PENGGUNA ANGGARAN</div>
<br><br><br><br><br>

<div class="center bold">{{ $pengguna_anggaran }}</div>
<div class="center">NIP. {{ $nip_pengguna }}</div> --}}

</body>
</html>
