@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bodi">
    <h3>Orders</h3>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Create New Order</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>No Order</th>
                <th>Date</th>
                <th>Customer</th>
                <th>SubTotal</th>
                <th>Discount</th>
                <th>Total</th>
                <th width="100px">Action</th>
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
                <h4 class="modal-title" id="headCustomer"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <form id="custForm" name="custForm" class="form-horizontal">
                   <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">No Order</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="no" name="no" placeholder="Enter No Order" value="" maxlength="5" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Customer</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="customer" id="customer">
                                @foreach($merks as $mk)
								<option value="{{ $mk->merk_id }}">{{ $mk->nama }}</option>
								@endforeach
                                <option value=""> -- Pilih Customer --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
          ajax: "{{ route('order.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'no', name: 'no'},
              {data: 'date', name: 'date'},
              {data: 'customer_id', name: 'customer_id'},
              {data: 'subtotal', name: 'subtotal'},
              {data: 'discount', name: 'discount'},
              {data: 'total', name: 'total'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      $('#createNewUser').click(function () {
          $('#saveBtn').val("create-user");
          $('#user_id').val('');
          $('#custForm').trigger("reset");
          $('#headCustomer').html("Create New Order");
          $('#ajaxModel').modal('show');
      });
      $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('order.index') }}" +'/' + user_id + '/edit', function (data) {
            $('#headCustomer').html("Edit Order");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#code').val(data.code);
            $('#name').val(data.name);
        })
     });
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Save');

          $.ajax({
            data: $('#custForm').serialize(),
            url: "{{ route('order.store') }}",
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

      $('body').on('click', '.deleteCust', function () {

          var user_id = $(this).data("id");
          $confirm = confirm("Are You sure want to delete !");
          if($confirm == true ){
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('order.store') }}"+'/'+user_id,
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

