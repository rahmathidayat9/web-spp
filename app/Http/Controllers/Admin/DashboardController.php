<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa_laki_laki = DB::table('siswa')->where('jenis_kelamin', 'Laki-laki')->count();
        $siswa_perempuan = DB::table('siswa')->where('jenis_kelamin', 'Perempuan')->count();

    	return view('admin.dashboard', [
    		'total_siswa' => DB::table('siswa')->count(),
    		'total_kelas' => DB::table('kelas')->count(),
    		'total_admin' => DB::table('model_has_roles')->where('role_id', 1)->count(),
    		'total_petugas' => DB::table('petugas')->count(),
            'siswa_laki_laki' => $siswa_laki_laki,
            'siswa_perempuan' => $siswa_perempuan,
    	]);
    }
}
