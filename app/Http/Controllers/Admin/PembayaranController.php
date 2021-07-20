<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\DataTables\PembayaranDataTable;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PembayaranDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        return view('admin.pembayaran.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pembayaran::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Data permbayaran berhasil dihapus!',
            'status' => 'OK',
        ]);
    }
}
