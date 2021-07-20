<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Siswa;

class Universe
{	
	public static function petugas()
	{
		return Petugas::where('user_id', Auth::user()->id)->first();
	}

	public static function siswa()
	{
		return Siswa::where('user_id', Auth::user()->id)->first(); 
	}

	public static function bulanAll()
	{
		return collect([
			[
				'nama_bulan' => 'Januari',
				'kode_bulan' => '01',
			],
			[
				'nama_bulan' => 'Februari',
				'kode_bulan' => '02',
			],
			[
				'nama_bulan' => 'Maret',
				'kode_bulan' => '03',
			],
			[
				'nama_bulan' => 'April',
				'kode_bulan' => '04',
			],
			[
				'nama_bulan' => 'Mei',
				'kode_bulan' => '05',
			],
			[
				'nama_bulan' => 'Juni',
				'kode_bulan' => '06',
			],
			[
				'nama_bulan' => 'Juli',
				'kode_bulan' => '07',
			],
			[
				'nama_bulan' => 'Agustus',
				'kode_bulan' => '08',
			],
			[
				'nama_bulan' => 'September',
				'kode_bulan' => '09',
			],
			[
				'nama_bulan' => 'Oktober',
				'kode_bulan' => '10',
			],
			[
				'nama_bulan' => 'November',
				'kode_bulan' => '11',
			],
			[
				'nama_bulan' => 'Desember',
				'kode_bulan' => '12',
			],
		]);
	}

	// cek status pembayaran (diakses oleh siswa)
	public static function statusPembayaranBulan($bulan, $spp_tahun)
	{
		$siswa = Siswa::where('user_id', Auth::user()->id)
            ->first();

	    $pembayaran = Pembayaran::where('siswa_id', $siswa->id)
	        ->where('tahun_bayar', $spp_tahun)
	        ->oldest()
	        ->pluck('bulan_bayar')->toArray();


	    foreach ($pembayaran as $key => $bayar) {
	    	if ($bayar == $bulan) {
	    		return "DIBAYAR";
	    	}
	    }

	    // jika pembayaran dibulan tertentu bulan belum dibayar
	    return "BELUM DIBAYAR";
	}


	// cek status pembayaran (diakses oleh petugas)
	public static function statusPembayaran($siswa_id, $tahun, $bulan)
	{
	    $pembayaran = Pembayaran::where('siswa_id', $siswa_id)
	        ->where('tahun_bayar', $tahun)
	        ->oldest()
	        ->pluck('bulan_bayar')->toArray();

	    foreach ($pembayaran as $key => $bayar) {
	    	if ($bayar == $bulan) {
	    		return "DIBAYAR";
	    	}
	    }

	    // jika pembayaran dibulan tertentu bulan belum dibayar
	    return "BELUM DIBAYAR";
	}
}