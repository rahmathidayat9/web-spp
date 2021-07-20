<script> 
$(function () {
  
  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('siswa.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'nama_siswa', name: 'nama_siswa'},
          {data: 'nisn', name: 'nisn'},
          {data: 'kelas.nama_kelas', name: 'kelas.nama_kelas'},
          {data: 'jenis_kelamin', name: 'jenis_kelamin'},
          {data: 'no_telepon', name: 'no_telepon'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });

});

// Reset Form
function resetForm(){
    $("[name='nama_siswa']").val("")
    $("[name='username']").val("")
    $("[name='nisn']").val("")
    $("[name='nis']").val("")
    $("[name='alamat']").val("")
    $("[name='no_telepon']").val("")
}

// create
$("#store").on("submit", function(e) {
  e.preventDefault()
  $.ajax({
    url: "{{ route('siswa.store') }}",
    method: "POST",
    data: $(this).serialize(),
    success:function(response) {
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
    url: "/admin/siswa/"+id+"/edit",
    method: "GET",
    success: function(response) {
      $("#id_edit").val(response.data.id)
      $("#nama_siswa_edit").val(response.data.nama_siswa)
      $("#alamat_edit").val(response.data.alamat)
      $("#no_telepon_edit").val(response.data.no_telepon)
      $("#jenis_kelamin_edit").val(response.data.jenis_kelamin)
      $("#kelas_id_edit").val(response.data.kelas_id)
      $("#editModal").modal("show")
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

// update
$("#update").on("submit", function(e) {
  e.preventDefault()
  var id = $("#id_edit").val()
  $.ajax({
    url: "/admin/siswa/"+id,
    method: "PATCH",
    data: $(this).serialize(),
    success: function(response) {
      if ($.isEmptyObject(response.error)) {
        $("#editModal").modal("hide")
        $('#dataTable2').DataTable().ajax.reload()
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
        url: "/admin/siswa/"+id,
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
})

//Initialize Select2 Elements
$('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})  
</script>