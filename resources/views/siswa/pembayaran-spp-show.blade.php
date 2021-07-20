@extends('layouts.backend.app')
@section('title', 'Data Pembayaran')
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush
@section('content_title', 'Pembayaran Tahun '.$spp->tahun)
@section('content')
<x-alert></x-alert>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('siswa.pembayaran-spp') }}" class="btn btn-danger btn-sm">
          <i class="fas fa-fw fa-arrow-left"></i> KEMBALI
        </a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if($pembayaran->count() > 0)
        <table id="dataTable2" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nisn</th>
            <th>Tanggal Bayar</th>
            <th>Nama Petugas</th>
            <th>Untuk Bulan</th>
            <th>Untuk Tahun</th>
            <th>Nominal</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach($pembayaran as $row)
          <tr>
          	<td>{{ $loop->iteration }}</td>
            <td>{{ $row->siswa->nama_siswa }}</td>
            <td>{{ $row->siswa->kelas->nama_kelas }}</td>
            <td>{{ $row->nisn }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y') }}</td>
            <td>{{ $row->petugas->nama_petugas }}</td>
            <td>{{ $row->bulan_bayar }}</td>
            <td>{{ $row->tahun_bayar }}</td>
            <td>{{ $row->jumlah_bayar }}</td>
            <td>
            	<a href="javascript:(0)" class="btn btn-success btn-sm"><i class=""></i> DIBAYAR</a>
            </td>
          </tr>
 		      @endforeach
          </tbody>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Data Pembayaran Tidak Tersedia!</h4>
          <p>Pembayaran Spp Anda di Tahun {{ $spp->tahun }} tidak tersedia.</p>
        </div>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="javascript:void(0)" class="btn btn-primary btn-sm">
          <i class="fas fa-fw fa-circle"></i> STATUS PEMBAYARAN
        </a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if($pembayaran->count() > 0)
        <table id="" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Bulan</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach(Universe::bulanAll() as $key => $value)
          <tr>
            <td>{{ $value['nama_bulan'] }}</td>
            <td>
              @if(Universe::statusPembayaranBulan($value['nama_bulan'], $spp->tahun) == 'DIBAYAR')
                <a href="javascript:(0)" class="btn btn-success btn-sm"><i class=""></i> 
                  {{ Universe::statusPembayaranBulan($value['nama_bulan'], $spp->tahun) }}
                </a>
              @else
                <a href="javascript:(0)" class="btn btn-danger btn-sm"><i class=""></i> 
                  {{ Universe::statusPembayaranBulan($value['nama_bulan'], $spp->tahun) }}
                </a>
              @endif
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Data Status Pembayaran Tidak Tersedia!</h4>
          <p>Status Pembayaran Spp Anda di Tahun {{ $spp->tahun }} tidak tersedia.</p>
        </div>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@stop

@push('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $("#dataTable1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $('#dataTable2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush