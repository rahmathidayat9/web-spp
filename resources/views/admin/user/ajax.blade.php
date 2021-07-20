<script>
$(function () {
  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('user.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'username', name: 'username'},
          {data: 'email', name: 'email'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });
});


  // Reset Form
  function resetForm(){
      $("[name='name']").val("")
      $("[name='email']").val("")
      $("[name='password']").val("")
  }
  
  // Create 
  $("#createForm").on("submit",function(e){
    e.preventDefault()
    $.ajax({
        url: "{{ route('user.store') }}",
        method: "POST",
        data: $(this).serialize(),
        success:function(){
            $("#create-modal").modal("hide")
            $('#dataTable2').DataTable().ajax.reload();
            Swal.fire(
              'Simpan',
              'Data berhasil disimpan!',
              'success'
            )
            resetForm()
        }
    })
  })
  
  
  // Edit & Update
  $('body').on("click",".btn-edit",function(){
    var id = $(this).attr("id")

    $.ajax({
        url: "/admin/user/"+id+"/edit",
        method: "GET",
        success:function(response){
            $("#edit-modal").modal("show")
            $("#old_password").val(response.data.password)
            $("#id").val(response.data.id)
            $("#name").val(response.data.username)
            $("#email").val(response.data.email)
        }
    })
  });

  $("#editForm").on("submit",function(e){
    e.preventDefault()
    var id = $("#id").val()
    $.ajax({
        url: "/admin/user/"+id,
        method: "PATCH",
        data: $(this).serialize(),
        success:function(){
            $('#dataTable2').DataTable().ajax.reload();
            $("#edit-modal").modal("hide")
            Swal.fire(
              'Update',
              'Data berhasil diupdate!',
              'success'
            )
        }
    })
  })
  
  // delete
  $('body').on("click",".btn-delete",function(){
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
          url: "/admin/user/"+id,
          method: "DELETE",
          success: function() {
            $('#dataTable2').DataTable().ajax.reload()
            Swal.fire(
              'Delete',
              'Data berhasil dihapus!',
              'success'
            )
          }
        })
      }
    })
  });
</script>