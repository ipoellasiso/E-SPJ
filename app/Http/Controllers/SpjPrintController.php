<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SpjPrintController extends Controller
{
    public function cetakResmi($id)
    {
        $spj = Spj::with(['details', 'anggaran.subKegiatan.kegiatan.program'])->findOrFail($id);
        $user = Auth::user();

        $data = [
            'spj' => $spj,
            'user' => $user,
            'instansi' => 'PEMERINTAH KOTA PALU',
            'unit_kerja' => 'KANTOR KECAMATAN ULUJADI',
            'alamat' => 'Jalan Malonda Lorong Mawar Kelurahan Tipo',
            'bendahara' => [
                'nama' => 'DESSI AGNES',
                'nip' => '19830604 200501 2 009',
                'jabatan' => 'Bendahara Pengeluaran',
            ],
            'pptk' => [
                'nama' => 'IMANUDDIN',
                'nip' => '19701227 199101 1 004',
                'jabatan' => 'Pejabat Pelaksana Teknis Kegiatan',
            ],
            'pengguna' => [
                'nama' => 'JHAMMAD SHAFA’AD, S.Sos., M.Si.',
                'nip' => '19790504 200212 1 003',
                'jabatan' => 'Pengguna Anggaran',
            ],
            'penerima' => [
                'nama' => 'CAMAT ULUJADI',
                'jabatan' => 'Penerima Barang',
            ]
        ];

        $pdf = Pdf::loadView('Spj.Cetak.Resmi', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream("SPJ_RESMI_{$spj->nomor_spj}.pdf");
    }

    public function cetakKwitansi($id)
    {
        $spj = Spj::with('details', 'anggaran.subKegiatan')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.Kwitansi', compact('spj'))->setPaper('a4');
        return $pdf->stream("Kwitansi_{$spj->nomor_kwitansi}.pdf");
    }

    public function cetakNota($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.Nota', compact('spj'))->setPaper('a4');
        return $pdf->stream("NotaPesanan_{$spj->nomor_nota}.pdf");
    }

    public function cetakBAPP($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.BAPP', compact('spj'))->setPaper('a4');
        return $pdf->stream("BA_Pengadaan_{$spj->nomor_bapp}.pdf");
    }

    public function cetakBAPB($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.BAPB', compact('spj'))->setPaper('a4');
        return $pdf->stream("BA_Pemeriksaan_{$spj->nomor_bapb}.pdf");
    }

    public function cetakBAST($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.BAST', compact('spj'))->setPaper('a4');
        return $pdf->stream("BA_SerahTerima_{$spj->nomor_bast}.pdf");
    }

    public function cetakPenerimaan($id)
    {
        $spj = Spj::with('details')->findOrFail($id);
        $pdf = Pdf::loadView('Spj.Cetak.Penerimaan', compact('spj'))->setPaper('a4');
        return $pdf->stream("BA_Penerimaan_{$spj->nomor_ba_penerimaan}.pdf");
    }
    
}
