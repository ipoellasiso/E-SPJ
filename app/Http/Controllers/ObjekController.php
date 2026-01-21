<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Objek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ObjekImport;
use App\Exports\ObjekExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ObjekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Objek Belanja',
            'active_master_data' => 'active',
            'active_rekening4' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Objek Belanja',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataObjek = DB::table('objek')
                ->join('jenis', 'objek.id_jenis', '=', 'jenis.id')
                ->select('objek.id', 'objek.kode', 'objek.uraian', 'jenis.uraian as nama_jenis')
                ->orderBy('objek.kode', 'asc')
                ->get();

            return DataTables::of($dataObjek)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editObjek btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteObjek btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_objek.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:objek,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
            'id_jenis' => 'required|integer'
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
            'id_jenis' => $request->id_jenis
        ];

        if ($request->id) {
            Objek::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Objek::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(Objek::find($id));
    }

    public function destroy($id)
    {
        Objek::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);

        try {
            Excel::import(new ObjekImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_objek.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian', 'id_jenis'];
            $rows = [
                ['5.1.1.01', 'BELANJA GAJI DAN TUNJANGAN', 1],
                ['5.1.1.02', 'BELANJA INSENTIF', 1],
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
        $filename = 'Data_Objek_Belanja_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new ObjekExport, $filename);
    }
}
