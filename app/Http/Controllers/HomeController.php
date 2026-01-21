<?php

namespace App\Http\Controllers;

use App\Models\Sp2dModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index ()
    {
        $userId = Auth::guard('web')->user()->id;
        $data = array(
            'title'                 => 'Dashboard',
            'active_home'           => 'active',
            // 'active_subopd'         => 'active',
            // 'active_sideopd'        => 'active',
            'breadcumd'             => 'Home',
            'breadcumd1'            => 'Dashboard',
            'breadcumd2'            => 'Dashboard',
            'userx'                 => UserModel::where('id',$userId)->first(['fullname','role','gambar','tahun']),
            // 'total_ls'              => Sp2dModel::where('jenis', 'LS')->where('sp2d.nama_skpd', auth()->user()->nama_opd)->sum('nilai_sp2d'),
            // 'total_gu'              => Sp2dModel::where('jenis', 'GU')->where('sp2d.nama_skpd', auth()->user()->nama_opd)->sum('nilai_sp2d'),
            // 'total_all'             => Sp2dModel::where('sp2d.nama_skpd', auth()->user()->nama_opd)->sum('nilai_sp2d'),
            // 'total_all1'            => Sp2dModel::where('sp2d.nama_skpd', auth()->user()->nama_opd)->count('nilai_sp2d'),
        );

        return view('Dashboard.Dashboard_admin', $data);
    }

}
