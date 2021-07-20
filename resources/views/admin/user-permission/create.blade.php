@extends('layouts.backend.app')
@section('title', 'User Permission')
@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content_title', 'User Handle Permission')
@section('content')
<x-alert></x-alert>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('user-permission.index') }}" class="btn btn-danger btn-sm">
          <i class="fas fa-window-close fa-fw"></i> BACK TO LIST
        </a>
        <a href="javascript:void(0)" class="btn btn-primary btn-sm">
          <i class="fas fa-user-tie fa-fw"></i> USERNAME : {{ $user->username }}
        </a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form method="POST" action="{{ route('user-permission.store', $user->id) }}">
          @csrf
          <div class="form-group select2-purple">
            <label>Permissions:</label>
            <select class="select2" name="permission[]" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a Permission" style="width: 100%;">
              @foreach($permissions as $row)
                @if($user->hasAnyPermission($row->name))
                  <option selected="" value="{{ $row->id }}">{{ $row->name }}</option>
                @else
                  <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endif  
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save fa-fw"></i> SIMPAN
            </button>
          </div>
        </form>
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
<!-- Select2 -->
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })
</script>
@endpush