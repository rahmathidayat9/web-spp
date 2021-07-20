<script>
$(function () {
  
  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('admin-list.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'username', name: 'username'},
          {data: 'petugas.nama_petugas', name: 'petugas.nama_petugas'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });

});

// Reset Form
  function resetForm(){
      $("[name='username']").val("")
      $("[name='nama_petugas']").val("")
  }

// create
$("#store").on("submit", function(e) {
  e.preventDefault()
  $.ajax({
    url: "{{ route('admin-list.store') }}",
    method: "POST",
    data: $(this).serialize(),
    success:function(response) {
      if ($.isEmptyObject(response.error)) {
        $("#createModal").modal("hide")
        resetForm()
        $('#dataTable2').DataTable().ajax.reload()
        Swal.fire(
          '',
          response.message,
          'success'
        )
        resetForm()
      }else{
        printErrorMsg(response.error)
      }
    }
  });
})

// create-error-validation
function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display', 'block');
  $.each(msg, function(key, value) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>')
  });
}

// edit
$("body").on("click", ".btn-edit", function() {
  var id = $(this).attr("id")
  $.ajax({
    url: "/admin/admin-list/"+id+"/edit",
    method: "GET",
    success: function(response) {
      $("#id_edit").val(response.data.id)
      $("#nama_petugas_edit").val(response.data.petugas.nama_petugas)
      $("#editModal").modal("show")
    }
  })
})

// update
$("#update").on("submit", function(e) {
  e.preventDefault()
  var id = $("#id_edit").val()
  $.ajax({
    url: "/admin/admin-list/"+id,
    method: "PATCH",
    data: $(this).serialize(),
    success: function(response) {
      if ($.isEmptyObject(response.error)) {
        $("#editModal").modal("hide")
        resetForm()
        $('#dataTable2').DataTable().ajax.reload()
        Swal.fire(
          '',
          response.message,
          'success'
        )
      }else{
        printErrorMsg(response.error)
      }
    }
  })
})

// delete
$("body").on("click", ".btn-delete", function() {
  var id = $(this).attr("id")

  Swal.fire({
    title: 'Yakin hapus data ini?',
    // text: "You won't be able to revert",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/admin/admin-list/"+id,
        method: "DELETE",
        success: function(response) {
          $('#dataTable2').DataTable().ajax.reload()
          Swal.fire(
            '',
            response.message,
            'success'
          )
        }
      })
    }
  })
})
</script>