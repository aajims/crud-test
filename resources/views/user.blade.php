@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bodi">
    <h3>Users</h3>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Create New User</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>E-mail</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                   <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter E-mail" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="current-password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" maxlength="50" required="">
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      $('#createNewUser').click(function () {
          $('#saveBtn').val("create-user");
          $('#user_id').val('');
          $('#userForm').trigger("reset");
          $('#modelHeading').html("Create New User");
          $('#ajaxModel').modal('show');
      });
      $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('users.index') }}" +'/' + user_id +'/edit', function (data) {
            $('#modelHeading').html("Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#password').val(data.password);
        })
     });
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Save');

          $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                if(data.success){
                    console.log('Success:', data);
                    alert(Object.values(data));
                    $('#bookForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                }else{
                    console.log('Error:', data);
                    alert("Erro: "+ Object.values(data));
                    $('#saveBtn').html('Save Changes');
                }
            },
            error: function (data) {
                console.log('Error:', data);
                //alert("Erro: "+ Object.values(data));
                $('#saveBtn').html('Save Changes');
            }
        });
      });

      $('body').on('click', '.deleteUser', function () {

          var user_id = $(this).data("id");
          $confirm = confirm("Are You sure want to delete !");
          if($confirm == true ){
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('users.store') }}"+'/'+user_id,
                  success: function (data) {
                      table.draw();
                      alert(Object.values(data));

                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          }
      });

    });
  </script>

@endsection

