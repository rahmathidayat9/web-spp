@extends('layouts.backend.app')
@section('title', 'User Role')
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush
@section('content_title', 'User Role')
@section('content')
<x-alert></x-alert>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
      	<a href="javascript:void(0)" class="btn btn-primary btn-sm">
          <i class="fas fa-users fa-fw"></i> User List
        </a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="dataTable2" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
        @foreach($users as $row)
          <tr>
          	<td>{{ $loop->iteration }}</td>
            <td>{{ $row->username }}</td>
            <td>
              @foreach($row->roles as $role)
                @if($row->hasAnyRole('admin'))
                  <span class="badge badge-primary">
                    {{ $role->name }}
                  </span>
                @endif
                @if($row->hasAnyRole('petugas'))
                  <span class="badge badge-success">
                    {{ $role->name }}
                  </span>
                @endif
                @if($row->hasAnyRole('siswa'))
                  <span class="badge badge-danger">
                    {{ $role->name }}
                  </span>
                @endif
              @endforeach
            </td>
            <td>
            	<div class="row mx-auto">
            		<a href="{{ route('user-role.create', $row->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-edit fa-fw"></i> Handle
                </a>
            	</div>
            </td>
          </tr>
        @endforeach
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
    $("#dataTable1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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