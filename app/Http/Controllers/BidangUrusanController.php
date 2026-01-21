<?php

namespace App\Http\Controllers;

use App\Models\BidangUrusan;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Imports\BidangUrusanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class BidangUrusanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $data = [
            'title'              => 'Data Bidang Urusan',
            'active_master_data' => 'active',
            'active_bidang'      => 'active',
            'breadcumd'          => 'Pengaturan',
            'breadcumd1'         => 'Master Data',
            'breadcumd2'         => 'Bidang Urusan',
            'userx'              => UserModel::where('id', $userId)->first(['fullname','role','gambar','tahun']),
        ];

        // === Handle Ajax Request for DataTables ===
        if ($request->ajax()) {
            $dataBidang = DB::table('bidang_urusan')
                ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
                ->select('bidang_urusan.id', 'bidang_urusan.kode', 'bidang_urusan.nama', 'urusan.nama as nama_urusan')
                ->orderBy('bidang_urusan.kode', 'asc')
                ->get();

            return DataTables::of($dataBidang)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                        <a href="javascript:void(0)" title="Edit Data" data-id="'.$row->id.'" class="editBidang btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript:void(0)" title="Hapus Data" data-id="'.$row->id.'" class="deleteBidang btn btn-danger btn-sm">
                            <i class="bi bi-trash3"></i>
                        </a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Master_Data.Data_bidang_urusan.index', $data);
    }

    // === STORE / UPDATE ===
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'id_urusan' => 'required|integer',
        ]);

        $data = [
            'id_urusan' => $request->id_urusan,
            'kode' => $request->kode,
            'nama' => $request->nama,
        ];

        // Jika ada ID, maka update
        if ($request->id) {
            $bidang = BidangUrusan::find($request->id);
            if (!$bidang) {
                return response()->json(['error' => 'Data tidak ditemukan!']);
            }
            $bidang->update($data);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        } 
        else {
            // Cek duplikasi berdasarkan kode
            $exists = BidangUrusan::where('kode', $request->kode)->exists();
            if ($exists) {
                return response()->json(['error' => 'Kode sudah digunakan!']);
            }
            BidangUrusan::create($data);
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
    }

    // === EDIT ===
    public function edit($id)
    {
        $data = BidangUrusan::find($id);
        return response()->json($data);
    }

    // === DELETE ===
    public function destroy($id)
    {
        $data = BidangUrusan::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan!']);
        }
        $data->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }

    // === IMPORT EXCEL ===
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new BidangUrusanImport, $request->file('file_excel'));
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal import: '.$e->getMessage()]);
        }
    }

    // === DOWNLOAD TEMPLATE ===
    public function downloadTemplate()
    {
        $filename = 'template_bidang_urusan.xlsx';
        $path = public_path('template/'.$filename);

        if (!file_exists($path)) {
            // Generate file template jika belum ada
            $headers = ['Kode', 'Nama', 'Id_Urusan'];
            $rows = [
                ['1.01', 'Bidang Pendidikan', 1],
                ['1.02', 'Bidang Kesehatan', 1],
            ];

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($headers, NULL, 'A1');
            $sheet->fromArray($rows, NULL, 'A2');

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($path);
        }

        return Response::download($path);
    }

}
