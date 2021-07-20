@extends('layouts.backend.app')
@section('title', 'Data History Pembayaran')
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush
@section('content_title', 'History Pembayaran')
@section('content')
<x-alert></x-alert>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">

      </div>
      <!-- /.card-header -->
      <div class="card-body">
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
            <th>Print</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          	<td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          </tbody>
        </table>
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

  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('pembayaran.history-pembayaran') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'siswa.nama_siswa', name: 'siswa.nama_siswa'},
          {data: 'siswa.kelas.nama_kelas', name: 'siswa.kelas.nama_kelas'},
          {data: 'siswa.nisn', name: 'siswa.nisn'},
          {data: 'tanggal_bayar', name: 'tanggal_bayar'},
          {data: 'petugas.nama_petugas', name: 'petugas.nama_petugas'},
          {data: 'bulan_bayar', name: 'bulan_bayar'},
          {data: 'tahun_bayar', name: 'tahun_bayar'},
          {data: 'jumlah_bayar', name: 'jumlah_bayar'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });

});
</script>
@endpush