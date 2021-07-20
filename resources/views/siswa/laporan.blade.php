@extends('layouts.backend.app')
@section('title', 'Laporan')
@section('content_title', 'Laporan')
@section('content')
<x-alert></x-alert>

<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Laporan Pembayaran</div>
			<div class="card-body">
				<form method="POST" action="{{ route('siswa.laporan-pembayaran.print-pdf') }}">
					@csrf
					<div class="form-group">
						<label for="tahun_bayar">Tahun</label>
						<select name="tahun_bayar" required="" class="form-control" id="tahun_bayar">
							<option disabled="" selected="">- PILIH TAHUN -</option>
							@foreach($spp as $row)
								<option value="{{ $row->tahun }}">{{ $row->tahun }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-sm">
							<i class="fas fa-print fa-fw"></i> CETAK LAPORAN
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection