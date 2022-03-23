@extends('master.master')

@section('content')
<div class="container">
    <h3>Orders</h3>
    <div class="col-md-10">
        <a class="btn btn-success" href="javascript:void(0)" id="createNewItem" style="margin-bottom: 15px"> Create New Item</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

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
                   {{-- <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Order</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" id="order" name="order" placeholder="Enter Order" value="" required="">
                    </div>
                </div> --}}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Item</label>
                        <div class="col-sm-12">
                            <select name="item" id="" class="form-control">
                                @foreach($item as $row)
                                <option class="form_control" value="{{ $row->code }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Qty</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter Qty" value="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" onkeyup="TotalHarga()" placeholder="Enter Price" value="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Total</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="total" name="total" placeholder="Enter Total" value="" readonly>
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
    <div class="order">
        <div class="col-md-8">
            <form name="custForm" class="form-horizontal" method="post" action="{{ url('order/store') }}">
                {{ csrf_field() }}
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
                         <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" value="" maxlength="50" required="">
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Customer</label>
                     <div class="col-sm-12">
                         <select class="form-control" name="customer_id" id="customer_id">
                            @foreach($customer as $row)
                            <option value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">SubTotal</label>
                     <div class="col-sm-12">
                         <input type="text" class="form-control" id="subtotals" name="subtotals" placeholder="Enter Subtotal" value="" required="">
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Discount</label>
                     <div class="col-sm-12">
                         <input type="text" class="form-control" id="discount" name="discount" onkeyup="Discounts()" placeholder="Enter Discount" value="" required="">
                     </div>
                 </div>
                 <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Total</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="totals" name="totals" placeholder="Enter Total" value="" required="">
                    </div>
                </div>
        
                 <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" value="create">Save changes
                  </button>
                 </div>
             </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    function TotalHarga() {
        let q = document.getElementById("qty").value;
        let p = document.getElementById("price").value;
        let z = q * p;
        document.getElementById("total").value = z;
    }
    function Discounts() {
        let S = document.getElementById("subtotals").value;
        let D = document.getElementById("discount").value;
        let T = S - D;
        document.getElementById('totals').value = T;
    }
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('orderTmp.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'item', name: 'item'},
              {data: 'qty', name: 'qty'},
              {data: 'price', name: 'price'},
              {data: 'total', name: 'total'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      $('#createNewItem').click(function () {
          $('#saveBtn').val("create-user");
          $('#user_id').val('');
          $('#custForm').trigger("reset");
          $('#headCustomer').html("Create New Order Item");
          $('#ajaxModel').modal('show');
      });
      $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('orderItem.index') }}" +'/' + user_id + '/edit', function (data) {
            $('#headCustomer').html("Edit Order Item");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#item').val(data.item);
            $('#qty').val(data.qty);
            $('#price').val(data.price);
            $('#total').val(data.total);
        })
     });
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Save');

          $.ajax({
            data: $('#custForm').serialize(),
            url: "{{ route('orderItem.store') }}",
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
                  url: "{{ route('orderItem.store') }}"+'/'+user_id,
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