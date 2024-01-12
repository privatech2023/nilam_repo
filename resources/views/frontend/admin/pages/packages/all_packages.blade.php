@extends('layouts.adminFrontend')
@section('main-container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Packages</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Packages</a></li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">All packages</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                data-target="#modal-add">Add Package</button>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- Custom Filter -->
                        <table class="float-right">
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm" id='searchByStatus'>
                                        <option value=''>-- Status--</option>
                                        <option value='2'>Pending</option>
                                        <option value='1'>Active</option>
                                    </select>
                                </td>
                            </tr>
                        </table>


                        <table id="dataTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Price</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<!-- Add Modal-->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Package</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- form start -->
                <form role="form" action="{{ url('/admin/createPackages')}}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="name">Package Name *</label>
                                    <input type="text" class="form-control" name="package_name"
                                        placeholder="Name of Package" autocomplete="off" required>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">Duration in days</label>
                                    <input type="number" class="form-control" name="duration"
                                        placeholder="Duration in days" min="0" required autocomplete="off">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control net-amt" name="amount" placeholder="Amount"
                                        required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Tax ({{ $gst_rate}}%)</label>
                                    <input type="number" class="form-control tax-amt" name="tax" placeholder="Tax amount" 
                                        required readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">Price</label>
                                    <input type="number" class="form-control price-amt" name="price" placeholder="Price" required
                                        readonly>

                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Disabled </option>

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm swalDefaultSuccess">CREATE</button>
                    </div>
                </form>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>

</div> <!-- /.modal-dialog -->





<!-- Update Modal-->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- form start -->
                <form role="form" action="{{ url('/admin/updatePackages')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="row_id" id="update_id">

                        <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="name">Package Name *</label>
                                    <input type="text" class="form-control" name="package_name" id="idPackageName"
                                        placeholder="Name of Package" autocomplete="off" required>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">Duration in days</label>
                                    <input type="number" class="form-control" name="duration" id="idDuration"
                                        placeholder="Duration in days" min="0" required autocomplete="off">
                                </div>

                            </div>


                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control net-amt" name="amount" id="idAmount" placeholder="Amount"
                                        required autocomplete="off" value="">

                                </div>


                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="amount">Tax </label>
                                    <input type="number" class="form-control tax-amt" name="tax" id="idTax" placeholder="Tax amount"
                                        required readonly>
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">Price</label>
                                    <input type="number" class="form-control price-amt" name="price" id="idPrice" placeholder="Price" required
                                        readonly>

                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label>Status</label>
                                    <select class="form-control" name="status" id="idStatus" >
                                        <option value="1" selected>Active</option>
                                        <option value="0">Disabled </option>

                                    </select>
                                </div>
                            </div>


                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm swalDefaultSuccess">UPDATE</button>
                    </div>
                </form>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>

</div> <!-- /.modal-dialog -->



<!--Delete Modal-->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Package</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> the Package <strong><span id="delName"></span></strong> ?</p>
                <form action="{{ url('/admin/deletePackages')}}" method="post">
                    @csrf
                    <input type="hidden" name="row_id" id="del_id">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Confirm</button>
                    </div>

                </form>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal end -->




@if(session()->get('success'))
<script type="text/javascript">
    toastr.success('{{session('success')}}')
</script>
@endif
@if(session()->get('error'))
<script type="text/javascript">
    toastr.warning('{{session('error')}}')
</script>
@endif

<script>
    $(document).ready(function () {

        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


        $("#packageTree").addClass('menu-open');
    $("#packageMenu").addClass('active');
    $("#packageSubMenuManage").addClass('active');

    var i = 1;

    var dataTable = $('#dataTable').DataTable({
        lengthMenu: [
            [10, 30, -1],
            [10, 30, "All"]
        ], // page length options
        bProcessing: true,
        serverSide: true,
        scrollY: "400px",
        scrollCollapse: true,
        ajax: {
            url: "/admin/packages/ajaxCallAllPackages", 
            type: "post",
  
            data: function(data) {
                // key1: value1 - in case if we want send data with request      
                var type = $('#searchByStatus').val();
                // Append to data
                data.status = type;
            }
        },
        columns: [{
                mRender: function(data, type, full, meta) {
                    return i++;
                }
            },
            {
                data: "name"
            },
            {
                data: "duration_in_days"
            },
            {
                data: "net_amount"
            },
            {
                data: "tax"
            },
            {
                data: "price"
            },
            {
                mRender: function(data, type, row) {
                    if (row.is_active == 1) {
                        return '<span class="badge bg-success">ACTIVE</span>';
                    } else {
                        return '<span class="badge bg-warning">DISABLED</span>';
                    }
                }
            },
            {
                mRender: function(data, type, row) {
                    return '<button class="btn btn-outline-warning btn-xs edit-button" data-toggle="modal" data-target="#modal-update" data-id="' +
                        row.id + '" data-name="'+ row.name +'" data-duration="'+ row.duration_in_days +'" data-amount="'+ row.net_amount+'" data-tax="' + row.tax + '" data-price="'+ row.price+'" data-status="'+row.is_active+'" >Edit</button> <button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' + row.id + '" data-name="' + row.name + '" >Del</button>'
                }
            },
        ],
        columnDefs: [

            {
                orderable: false,
                targets: [0, 1, 2, 3]
            },
            {
                className: 'text-center',
                targets: [1, 2, 3, 4, 5]
            },
            {
                "targets": [1, 2, 3, 4, 5],
                "render": function(data) {
                    return data.toUpperCase();
                },
            },

        ],
        bFilter: true, // to display datatable search
    });


    $('#searchByStatus').change(function() {
        dataTable.draw();
    });



    // Handle the "Edit" button click event
    $('#dataTable tbody').on('click', '.edit-button', function() {
        var rowIndex = dataTable.row($(this).closest('tr')).index(); 
    var rowData = dataTable.row(rowIndex).data(); 
    var edit_id = rowData.id;
    var edit_name = rowData.name;
    var edit_duration = rowData.duration_in_days;
    var edit_amount = rowData.net_amount;
    var edit_tax = rowData.tax;
    var edit_price = rowData.price;
    var edit_status = rowData.is_active;

    $('#update_id').val(edit_id);
    $('#idPackageName').val(edit_name);
    $('#idDuration').val(edit_duration);
    $('#idAmount').val(edit_amount);
    $('#idTax').val(edit_tax);
    $('#idPrice').val(edit_price);
    $('#idStatus').val(edit_status);
    });



    $('#modal-delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var todo_id = button.data('id')
        var todo_name = button.data('name')

        var modal = $(this)
        modal.find('.modal-body #del_id').val(todo_id)
        modal.find('.modal-body #delName').text(todo_name)

    });

        $(document).on('keyup', '.net-amt', function(){
        updatePrice();
        });

    function updatePrice(){
    var tmp_amt =  $('.net-amt').val();
    var gst = {{ $gst_rate}};
    var tax_amt = parseFloat(tmp_amt*gst)/100;
    var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
    new_price = new_price.toFixed(2);
    $('.tax-amt').val(tax_amt);
    $('.price-amt').val(new_price);
    }
    });
</script>
@endsection