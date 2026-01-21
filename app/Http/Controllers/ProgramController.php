<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramExport;
use App\Imports\ProgramImport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Program',
            'active_master_data' => 'active',
            'active_program' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Program',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataProgram = DB::table('program')
                ->leftJoin('bidang_urusan', 'program.id_bidang', '=', 'bidang_urusan.id')
                ->leftJoin('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
                ->select(
                    'program.id',
                    'program.kode',
                    'program.nama',
                    DB::raw("CONCAT(bidang_urusan.kode, ' - ', bidang_urusan.nama) as nama_bidang"),
                    DB::raw("CONCAT(urusan.kode, ' - ', urusan.nama) as nama_urusan")
                )
                ->orderBy('program.kode', 'asc')
                ->get();

            return DataTables::of($dataProgram)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editProgram btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteProgram btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_program.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'id_bidang' => 'required|integer',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'id_bidang' => $request->id_bidang,
        ];

        if ($request->id) {
            Program::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Program::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        $data = Program::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Program::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    // === IMPORT EXCEL ===
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new ProgramImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    // === DOWNLOAD TEMPLATE ===
    public function downloadTemplate()
    {
        $filename = 'template_program.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'nama', 'id_bidang'];
            $rows = [
                ['1.01.01', 'Program Pendidikan Dasar', 1],
                ['1.02.01', 'Program Kesehatan Masyarakat', 2],
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

    // === EXPORT EXCEL ===
    public function exportExcel()
    {
        $filename = 'Data_Program_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new ProgramExport, $filename);
    }
}
