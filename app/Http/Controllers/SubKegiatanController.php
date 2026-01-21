<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubKegiatanExport;
use App\Imports\SubKegiatanImport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SubKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Sub Kegiatan',
            'active_master_data' => 'active',
            'active_sub_kegiatan' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Sub Kegiatan',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $datasub = DB::table('sub_kegiatan')
                ->join('kegiatan', 'sub_kegiatan.id_kegiatan', '=', 'kegiatan.id')
                ->select('sub_kegiatan.id', 'sub_kegiatan.kode', 'sub_kegiatan.nama', 'kegiatan.nama as nama_kegiatan')
                ->orderBy('sub_kegiatan.kode', 'asc')
                ->get();

            return DataTables::of($datasub)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editSubKegiatan btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteSubKegiatan btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_sub_kegiatan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'id_kegiatan' => 'required|integer',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'id_kegiatan' => $request->id_kegiatan,
        ];

        if ($request->id) {
            SubKegiatan::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            SubKegiatan::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(SubKegiatan::find($id));
    }

    public function destroy($id)
    {
        SubKegiatan::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new SubKegiatanImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_sub_kegiatan.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'nama', 'id_kegiatan'];
            $rows = [
                ['1.01.01.01.01', 'Sub Kegiatan Rapat Koordinasi', 1],
                ['1.01.01.01.02', 'Sub Kegiatan Sosialisasi Program', 1],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($rows, NULL, 'A2');

            $writer = new Xlsx($spreadsheet);
            $writer->save($path);
        }

        return response()->download($path);
    }

    public function exportExcel()
    {
        $filename = 'Data_Sub_Kegiatan_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new SubKegiatanExport, $filename);
    }
}
