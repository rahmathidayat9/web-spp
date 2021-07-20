<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;
use PDF;

class SiswaController extends Controller
{
    public function pembayaranSpp()
    {
        $spp = Spp::all();

        return view('siswa.pembayaran-spp', compact('spp'));
    }

    public function pembayaranSppShow(Spp $spp)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)
            ->first();

        $pembayaran = Pembayaran::with(['petugas', 'siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $spp->tahun)
            ->oldest()
            ->get();

        return view('siswa.pembayaran-spp-show', compact('pembayaran', 'siswa', 'spp'));
    }

    public function historyPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $siswa = Siswa::where('user_id', Auth::user()->id)
                ->first();
            
            $data = Pembayaran::with(['petugas', 'siswa' => function($query) {
                $query->with(['kelas']);
            }])
                ->where('siswa_id', $siswa->id)
                ->latest()
                ->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="row"><a href="'.route('siswa.history-pembayaran.preview', $row->id).'"class="btn btn-danger btn-sm ml-2" target="_blank">
                    <i class="fas fa-print fa-fw"></i>
                    </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    	
    	return view('siswa.history-pembayaran');
    }

    public function previewHistoryPembayaran($id)
    {
        $data['siswa'] = Siswa::where('user_id', Auth::user()->id)
            ->first();
        
        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->where('id', $id)
            ->where('siswa_id', $data['siswa']->id)
            ->first();
        
        $pdf = PDF::loadView('siswa.history-pembayaran-preview',$data);
        return $pdf->stream();
    }

    public function laporanPembayaran()
    {
        $spp = Spp::all();
        return view('siswa.laporan', compact('spp'));
    }

    public function printPdf(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)
            ->first();

        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->get();

        $data['data_siswa'] = $siswa;

        if ($data['pembayaran']->count() > 0) {
            $pdf = PDF::loadView('siswa.laporan-preview', $data);
            return $pdf->download('pembayaran-spp-'.$siswa->nama_siswa.'-'.
                $siswa->nisn.'-'.
                $request->tahun_bayar.'-'.
                Str::random(9).'.pdf');
        }else{
            return back()->with('error', 'Data Pembayaran Spp Anda Tahun '.$request->tahun_bayar.' tidak tersedia');
        }
    }
}
