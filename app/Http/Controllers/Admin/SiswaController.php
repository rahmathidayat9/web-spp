<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\DataTables\SiswaDataTable;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-siswa'])->only(['index', 'show']);
        $this->middleware(['permission:create-siswa'])->only(['create', 'store']);
        $this->middleware(['permission:update-siswa'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-siswa'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SiswaDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        $siswa = Siswa::all();
        $spp = Spp::all();
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswa', 'spp', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required',
            'username' => 'required|unique:users',
            'nisn' => 'required|unique:siswa',
            'nis' => 'required|unique:siswa',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($validator->passes()) {
            DB::transaction(function() use($request){
                $user = User::create([
                    'username' => Str::lower($request->username),
                    'password' => Hash::make('sppr2021'),
                ]);

                $user->assignRole('siswa');

                Siswa::create([
                    'user_id' => $user->id,
                    'kode_siswa' => 'SSWR'.Str::upper(Str::random(5)),
                    'nisn' => $request->nisn,
                    'nis' => $request->nis,
                    'nama_siswa' => $request->nama_siswa,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                    'kelas_id' => $request->kelas_id,
                ]);
            });

            return response()->json(['message' => 'Data berhasil disimpan!']);   
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siswa = Siswa::with(['kelas', 'spp'])->findOrFail($id);
        return response()->json(['data' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($validator->passes()) {
            Siswa::findOrFail($id)->update([
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'kelas_id' => $request->kelas_id,
            ]);

            return response()->json(['message' => 'Data berhasil diupdate!']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        User::findOrFail($siswa->user_id)->delete();
        $siswa->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
