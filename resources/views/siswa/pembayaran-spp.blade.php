@extends('layouts.backend.app')
@section('title', 'Pembayaran')
@section('content_title', 'Pembayaran')
@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Pilih Tahun</div>
			<div class="card-body">
				<div class="list-group">
				  @foreach($spp as $row)
				  	@if($row->tahun == date('Y'))
				  	<a href="{{ route('siswa.pembayaran-spp.pembayaranSppShow', $row->tahun) }}" class="list-group-item list-group-item-action active">
				  		{{ $row->tahun }}
				  	</a>
				  	@else
				  	<a href="{{ route('siswa.pembayaran-spp.pembayaranSppShow', $row->tahun) }}" class="list-group-item list-group-item-action">
				  		{{ $row->tahun }}
				  	</a>
				  	@endif
				  @endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
    <div class="callout callout-danger">
        <h5>Pemberitahuan!</h5>

        <p>Garis biru pada list tahun menandakan tahun aktif / tahun sekarang.</p>
      </div>
  </div>
</div>
@endsection