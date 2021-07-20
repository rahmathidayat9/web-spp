<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;
use App\DataTables\KelasDataTable;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-kelas'])->only(['index', 'show']);
        $this->middleware(['permission:create-kelas'])->only(['create', 'store']);
        $this->middleware(['permission:update-kelas'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-kelas'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, KelasDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();    
        }

        return view('admin.kelas.index');
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
            'nama_kelas' => 'required|unique:kelas',
            'kompetensi_keahlian' => 'required',
        ],[
            'nama_kelas.required' => 'nama kelas tidak boleh kosong!',
            'nama_kelas.unique' => 'nama kelas sudah terdaftar!',
            'kompetensi_keahlian.required' => 'kompetensi keahlian tidak boleh kosong!',
        ]);

        if ($validator->passes()) {
            Kelas::create($request->all());

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
        $kelas = Kelas::findOrFail($id);

        return response()->json(['data' => $kelas]);
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
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required',
        ],[
            'nama_kelas.required' => 'nama kelas tidak boleh kosong!',
            'kompetensi_keahlian.required' => 'kompetensi keahlian tidak boleh kosong!',
        ]);

        if ($validator->passes()) {
            Kelas::findOrFail($id)->update($request->all());

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
        Kelas::findOrFail($id)->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
