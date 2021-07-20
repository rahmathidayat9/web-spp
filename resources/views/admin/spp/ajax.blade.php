<script>
$(function () {
  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('spp.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'tahun', name: 'tahun'},
          {data: 'nominal', name: 'nominal'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });
});


  // Reset Form
  function resetForm(){
      $("[name='nominal']").val("")
  }
  
  // Create 
  $("#store").on("submit",function(e){
    e.preventDefault()
    $.ajax({
      url: "{{ route('spp.store') }}",
      method: "POST",
      data: $(this).serialize(),
      success:function(response){
        if ($.isEmptyObject(response.error)) {
          $("#createModal").modal("hide")
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
      },
      error: function(err) {
        if (err.status == 403) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Not allowed!'
          })
        }
      }  
    })
  })
  
  // create-error-validation
  function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function(key, value) {
      $(".print-error-msg").find("ul").append('<li>'+value+'</li>')
    });
  }
  
  // Edit 
  $('body').on("click",".btn-edit",function(){
    var id = $(this).attr("id")

    $.ajax({
      url: "/admin/spp/"+id+"/edit",
      method: "GET",
      success:function(response){
        $("#editModal").modal("show")
        $("#id_edit").val(response.data.id)
        $("#tahun_edit").val(response.data.tahun)
        $("#nominal_edit").val(response.data.nominal)
      },
      error: function(err) {
        if (err.status == 403) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Not allowed!'
          })
        }
      }
    })
  });

  // update
  $("#update").on("submit",function(e){
    e.preventDefault()
    var id = $("#id_edit").val()
    $.ajax({
        url: "/admin/spp/"+id,
        method: "PATCH",
        data: $(this).serialize(),
        success:function(response){
          if ($.isEmptyObject(response.error)) {
              $('#dataTable2').DataTable().ajax.reload();
              $("#editModal").modal("hide")
              Swal.fire(
                '',
                response.message,
                'success'
              )
          }else{
            printErrorMsg(response.error)
          }
        },
        error: function(err) {
          if (err.status == 403) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Not allowed!'
            })
          }
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
          url: "/admin/spp/"+id,
          method: "DELETE",
          success: function(response) {
            $('#dataTable2').DataTable().ajax.reload()
            Swal.fire(
              '',
              response.message,
              'success'
            )
          },
          error: function(err) {
            if (err.status == 403) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Not allowed!'
              })
            }
          }
        })
      }
    })
  });
</script>