<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AkunImport;
use App\Exports\AkunExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AkunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Akun Belanja',
            'active_master_data' => 'active',
            'active_rekening' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Akun Belanja',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataAkun = DB::table('akun')->select('id', 'kode', 'uraian')->orderBy('kode', 'asc')->get();

            return DataTables::of($dataAkun)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editAkun btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteAkun btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_akun.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:akun,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
        ];

        if ($request->id) {
            Akun::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Akun::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(Akun::find($id));
    }

    public function destroy($id)
    {
        Akun::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    // === IMPORT EXCEL ===
    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);

        try {
            Excel::import(new AkunImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    // === DOWNLOAD TEMPLATE ===
    public function downloadTemplate()
    {
        $filename = 'template_akun.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian'];
            $rows = [
                ['5', 'BELANJA'],
                ['6', 'PEMBIAYAAN'],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($rows, NULL, 'A2');
            (new Xlsx($spreadsheet))->save($path);
        }

        return response()->download($path);
    }

    // === EXPORT EXCEL ===
    public function exportExcel()
    {
        $filename = 'Data_Akun_Belanja_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new AkunExport, $filename);
    }
}
