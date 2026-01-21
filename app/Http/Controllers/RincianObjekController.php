<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\RincianObjek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RincianObjekImport;
use App\Exports\RincianObjekExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RincianObjekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Rincian Objek Belanja',
            'active_master_data' => 'active',
            'active_rekening5' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Rincian Objek Belanja',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataRincian = DB::table('rincian_objek')
                ->join('objek', 'rincian_objek.id_objek', '=', 'objek.id')
                ->select('rincian_objek.id', 'rincian_objek.kode', 'rincian_objek.uraian', 'objek.uraian as nama_objek')
                ->orderBy('rincian_objek.kode', 'asc')
                ->get();

            return DataTables::of($dataRincian)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editRincian btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteRincian btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_rincian_objek.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:rincian_objek,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
            'id_objek' => 'required|integer'
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
            'id_objek' => $request->id_objek
        ];

        if ($request->id) {
            RincianObjek::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            RincianObjek::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(RincianObjek::find($id));
    }

    public function destroy($id)
    {
        RincianObjek::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);
        try {
            Excel::import(new RincianObjekImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_rincian_objek.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian', 'id_objek'];
            $rows = [
                ['5.1.1.01.001', 'BELANJA GAJI PNS', 1],
                ['5.1.1.01.002', 'BELANJA TUNJANGAN', 1],
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
        $filename = 'Data_Rincian_Objek_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new RincianObjekExport, $filename);
    }
}
