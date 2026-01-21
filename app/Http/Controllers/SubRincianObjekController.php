<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\SubRincianObjek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SubRincianObjekImport;
use App\Exports\SubRincianObjekExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SubRincianObjekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Sub Rincian Objek Belanja',
            'active_master_data' => 'active',
            'active_rekening6' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Sub Rincian Objek',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataSub = DB::table('sub_rincian_objek')
                ->join('rincian_objek', 'sub_rincian_objek.id_rincian_objek', '=', 'rincian_objek.id')
                ->select('sub_rincian_objek.id', 'sub_rincian_objek.kode', 'sub_rincian_objek.uraian', 'rincian_objek.uraian as nama_rincian')
                ->orderBy('sub_rincian_objek.kode', 'asc')
                ->get();

            return DataTables::of($dataSub)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editSub btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteSub btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_sub_rincian_objek.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:15|unique:sub_rincian_objek,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
            'id_rincian_objek' => 'required|integer'
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
            'id_rincian_objek' => $request->id_rincian_objek
        ];

        if ($request->id) {
            SubRincianObjek::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            SubRincianObjek::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(SubRincianObjek::find($id));
    }

    public function destroy($id)
    {
        SubRincianObjek::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);
        try {
            Excel::import(new SubRincianObjekImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_sub_rincian.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) File::makeDirectory($folderPath, 0755, true);

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian', 'id_rincian_objek'];
            $rows = [
                ['5.1.1.01.001.01', 'BELANJA GAJI PNS GOL II', 1],
                ['5.1.1.01.001.02', 'BELANJA GAJI PNS GOL III', 1],
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
        $filename = 'Data_Sub_Rincian_Objek_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new SubRincianObjekExport, $filename);
    }
}
