<script>
$(function () {
  
  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('roles.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });

});

function resetForm(){
  $("[name='name[]']").val("")
}

// store
$('#store').on('submit', function(e){
  e.preventDefault()
  $.ajax({
      url:'{{ route("roles.store") }}',
      method:'POST',
      data:$(this).serialize(),
      success:function(response){
        resetForm()
        dynamic_field(1);
        $("#createModal").modal("hide")
        $('#dataTable2').DataTable().ajax.reload()
        Swal.fire(
          '',
          response.message,
          'success'
        )
      }
  });
 });

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
    url: "/admin/roles/"+id+"/edit",
    method: "GET",
    success: function(response) {
      $("#id_edit").val(response.data.id)
      $("#name_edit").val(response.data.name)
      $("#editModal").modal("show")
    }
  })
})

// update
$("#update").on("submit", function(e) {
  e.preventDefault()
  var id = $("#id_edit").val()
  $.ajax({
    url: "/admin/roles/"+id,
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
        url: "/admin/roles/"+id,
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

// form tambah dinamis 
var count = 1;
 dynamic_field(count);
 function dynamic_field(number)
 {
  html = '<tr>';
        html += '<td><input type="text" required id="tag" name="name[]" class="form-control" /></td>';
        if(number > 1)
        {
            html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove"><i class="fas fa-window-close fa-fw"></i> REMOVE</button></td></tr>';
            $('tbody').append(html);
        }
        else
        {   
            html += '<td><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus fa-fw"></i> ADD</button></td></tr>';
            $('tbody').html(html);
        }
 }

 $(document).on('click', '#add', function(){
  count++;
  dynamic_field(count);
 });

 $(document).on('click', '.remove', function(){
  count--;
  $(this).closest("tr").remove();
 });
</script>