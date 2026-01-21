<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KegiatanExport;
use App\Imports\KegiatanImport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Kegiatan',
            'active_master_data' => 'active',
            'active_kegiatan' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Kegiatan',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $datakeg = DB::table('kegiatan')
                ->join('program', 'kegiatan.id_program', '=', 'program.id')
                ->select('kegiatan.id', 'kegiatan.kode', 'kegiatan.nama', 'program.nama as nama_program')
                ->orderBy('kegiatan.kode', 'asc')
                ->get();

            return DataTables::of($datakeg)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editKegiatan btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteKegiatan btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_kegiatan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'id_program' => 'required|integer',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'id_program' => $request->id_program,
        ];

        if ($request->id) {
            Kegiatan::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Kegiatan::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        $data = Kegiatan::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Kegiatan::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    // === IMPORT ===
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new KegiatanImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    // === DOWNLOAD TEMPLATE ===
    public function downloadTemplate()
    {
        $filename = 'template_kegiatan.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'nama', 'id_program'];
            $rows = [
                ['1.01.01.01', 'Kegiatan Belajar Mengajar', 1],
                ['1.01.01.02', 'Kegiatan Pelatihan Guru', 1],
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

    // === EXPORT ===
    public function exportExcel()
    {
        $filename = 'Data_Kegiatan_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new KegiatanExport, $filename);
    }
}
