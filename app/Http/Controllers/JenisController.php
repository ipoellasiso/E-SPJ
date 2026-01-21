<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JenisImport;
use App\Exports\JenisExport;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JenisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title' => 'Data Jenis Belanja',
            'active_master_data' => 'active',
            'active_rekening3' => 'active',
            'breadcumd' => 'Pengaturan',
            'breadcumd1' => 'Master Data',
            'breadcumd2' => 'Jenis Belanja',
            'userx' => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        if ($request->ajax()) {
            $dataJenis = DB::table('jenis')
                ->join('kelompok', 'jenis.id_kelompok', '=', 'kelompok.id')
                ->select('jenis.id', 'jenis.kode', 'jenis.uraian', 'kelompok.uraian as nama_kelompok')
                ->orderBy('jenis.kode', 'asc')
                ->get();

            return DataTables::of($dataJenis)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="editJenis btn btn-primary btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" class="deleteJenis btn btn-danger btn-sm" data-id="'.$row->id.'">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_jenis.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:jenis,kode,'.$request->id,
            'uraian' => 'required|string|max:255',
            'id_kelompok' => 'required|integer'
        ]);

        $data = [
            'kode' => $request->kode,
            'uraian' => $request->uraian,
            'id_kelompok' => $request->id_kelompok
        ];

        if ($request->id) {
            Jenis::find($request->id)->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } else {
            Jenis::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    public function edit($id)
    {
        return response()->json(Jenis::find($id));
    }

    public function destroy($id)
    {
        Jenis::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);

        try {
            Excel::import(new JenisImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_jenis.xlsx';
        $folderPath = public_path('template');
        $path = $folderPath . '/' . $filename;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        if (!File::exists($path)) {
            $headers = ['kode', 'uraian', 'id_kelompok'];
            $rows = [
                ['5.1.1', 'BELANJA PEGAWAI', 1],
                ['5.1.2', 'BELANJA BARANG DAN JASA', 1],
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
        $filename = 'Data_Jenis_Belanja_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new JenisExport, $filename);
    }
}
