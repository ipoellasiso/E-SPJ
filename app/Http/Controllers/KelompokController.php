<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Kelompok;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelompokImport;
use App\Exports\KelompokExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Kelompok Belanja',
            'active_master_data' => 'active',
            'active_rekening2' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Kelompok Belanja',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataKelompok = DB::table('kelompok')
                ->join('akun', 'kelompok.id_akun', '=', 'akun.id')
                ->select('kelompok.id', 'kelompok.kode', 'kelompok.uraian', 'akun.uraian as nama_akun')
                ->orderBy('kelompok.kode', 'asc')
                ->get();

            return DataTables::of($dataKelompok)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editKelompok btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteKelompok btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_kelompok.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kelompok,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
            'id_akun' => 'required|integer'
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
            'id_akun' => $request->id_akun
        ];

        if ($request->id) {
            Kelompok::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Kelompok::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(Kelompok::find($id));
    }

    public function destroy($id)
    {
        Kelompok::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);

        try {
            Excel::import(new KelompokImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_kelompok.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian', 'id_akun'];
            $rows = [
                ['5.1', 'BELANJA OPERASI', 1],
                ['5.2', 'BELANJA MODAL', 1],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($rows, NULL, 'A2');
            (new Xlsx($spreadsheet))->save($path);
        }

        return response()->download($path);
    }

    public function exportExcel()
    {
        $filename = 'Data_Kelompok_Belanja_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new KelompokExport, $filename);
    }
}
