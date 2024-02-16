@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Activation Codes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Activation Code</a></li>
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
                            <h3 class="card-title">All Activation Codes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal-add">Create New
                                </button>
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
                                <tr><th>Expiry date</th>
                                    <th>Code</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Price</th>
                                    <th>Devices</th>
                                    <th>STATUS</th>
                                    <th>Used by</th>
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

    {{-- add modal --}}
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <!-- form start -->
                    <form role="form" action="{{ url('/admin/createActivationCode')}}" method="post">
                        @csrf
                        <div class="card-body">
    
                            <div class="row">
    
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
                                        <label for="name">Code Name *</label>
                                        <input type="text" class="form-control" name="code_name"
                                            placeholder="Activation Code" autocomplete="off" required>
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
                                        <label for="amount">Expiry date</label>
                                        <input type="date" class="form-control" name="expiry_date" placeholder="Expiry date"
                                            required autocomplete="off">
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="amount">Tax ( {{$gst_rate}}%)</label>
                                        <input type="number" class="form-control tax-amt" name="tax" placeholder="Tax amount" 
                                            required readonly>
                                    </div>
    
                                </div>
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
    
                                        <label for="amount">Price</label>
                                        <input type="number" class="form-control price-amt" name="price" placeholder="Price" required
                                            readonly>
    
                                    </div>
    
                                </div>
    
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
    
                                    <div class="form-group input-group-sm">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Used</option>
    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="form-group input-group-sm">
                                    <label for="devices">Number of devices</label>
                                    <select class="form-control" name="devices" required>
                                        @for ($i = 1; $i <= config('devices.max_devices'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
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
    </div>


    {{-- delete modal --}}
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are You sure to <strong>Delete</strong> the Code <strong><span id="delName"></span></strong> ?</p>
                    <form action="{{ url('/admin/deleteActivationCode')}}" method="post">
                        @csrf
                        <input type="hidden" name="row_id" id="del_id">
    
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Confirm</button>
                        </div>
    
                    </form>
    
                </div>
    
            </div>
        </div>
    </div>



    {{-- Update Modal --}}
    <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form start -->
                    <form role="form" action="{{ url('/admin/updateActivationCode')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <input type="hidden" id="c_id" name="c_id" value="" />
                                        <label for="name">Code Name *</label>
                                        <input type="text" class="form-control" name="code_name"
                                            placeholder="Activation Code" autocomplete="off" required>
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
                                        <input type="number" class="form-control net-amt2" name="amount" value="" placeholder="Amount"
                                            required >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="amount">Expiry date</label>
                                        <input type="date" class="form-control" name="expiry_date" placeholder="Expiry date"
                                            required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="amount">Tax ( {{$gst_rate}}%)</label>
                                        <input type="number" class="form-control tax-amt2" name="tax" placeholder="Tax amount" 
                                            required readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="amount">Price</label>
                                        <input type="number" class="form-control price-amt2" name="price" placeholder="Price" required
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Used</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="form-group input-group-sm">
                                    <label for="devices">Number of devices</label>
                                    <select class="form-control" name="devices" required>
                                        @for ($i = 1; $i <= config('devices.max_devices'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
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
    </div>

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
        
        $(document).ready(function() {

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        
            $("#packageTree").addClass('menu-open');
            $("#packageMenu").addClass('active');
            $("#packageSubMenuCodes").addClass('active');
            var i = 1;
        
            var dataTable = $('#dataTable').DataTable({
                lengthMenu: [
                    [10, 30, -1],
                    [10, 30, "All"]
                ], 
                bProcessing: true,
                serverSide: true,
                scrollY: "400px",
                scrollCollapse: true,
                ajax: {
                    url: "/admin/activationCodes/ajaxCallAllCodes", 
                    type: "post",
                    data: function(data) {  
                        var type = $('#searchByStatus').val();

                        data.status = type;
                    }
                },
                columns: [{
                    data: "expiry_date", 
                    render: function (data, type, row, meta) {
                        return data;
                        }
                    },
                    {
                        data: "code"
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
                        data: "devices"
                    },
                    {
                        mRender: function(data, type, row) {
                            if (row.is_active == 1) {
                                return '<span class="badge bg-success">ACTIVE</span>';
                            } else if(row.is_active == 2){
                                return '<span class="badge bg-warning">DISABLED</span>';
                            }                                       
                            else  {
                                return '<span class="badge bg-danger">USED</span>';
                            }
                        }
                    },
                    {
                        data: "client_name"
                    },
                    {
                        mRender: function(data, type, row) {
                            var viewButton = '';
    if (row.used_by !== null) {
        var viewLink = '{{ url('admin/view-client') }}' + '/' + row.used_by;
        viewButton = '<a href="' + viewLink + '" class="btn btn-outline-info btn-xs">VIEW USER</a>';
    }

    var editButton = '<button class="btn btn-outline-warning btn-xs edit-button" data-toggle="modal" data-target="#modal-update" data-id="' +
        row.c_id + '" data-name="' + row.code + '" data-expiry="'+row.expiry_date+'" data-validity="' + row.duration_in_days + '" data-status="' + row.is_active +'" data-netAmount="' + row.net_amount +'" data-tax="' + row.tax +'" data-price="' + row.price +'" data-devices="' + row.devices +'" >Edit</button>';
    var deleteButton = '<button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' + row.c_id + '" data-name="' + row.code + '" >Del</button>';

    var buttons = editButton + ' ' + deleteButton + ' ' + viewButton;
    return buttons;
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
                            return data;
                        },
                    },
        
                ],
                bFilter: true, 
            });
        
        
            $('#searchByStatus').change(function() {
                dataTable.draw();
            });
        
        
            $('#modal-delete').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) 
                var todo_id = button.data('id')
                var todo_name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #del_id').val(todo_id)
                modal.find('.modal-body #delName').text(todo_name)
            });

            $('#dataTable tbody').on('click', '.edit-button', function() {

                $('#modal-update').find('input[name="code_name"]').prop('disabled', false);
            $('#modal-update').find('input[name="duration"]').prop('disabled', false);
            $('#modal-update').find('input[name="amount"]').prop('disabled', false);
        $('#modal-update').find('input[name="expiry_date"]').prop('disabled', false);
        $('#modal-update').find('input[name="tax"]').prop('disabled', false);
        $('#modal-update').find('input[name="price"]').prop('disabled', false);
        $('#modal-update').find('select[name="status"]').prop('disabled', false);
        $('#modal-update').find('select[name="devices"]').prop('disabled', false);
                var button = $(this);
                var id = button.data('id');
    var name = button.data('name');
    var validity = button.data('validity');
    var status = button.data('status');
    var netAmount = button.data('netamount');
    var tax = button.data('tax');
    var price = button.data('price');
    var expiry = button.data('expiry');
    var devices = button.data('devices');

    // Set modal fields with data
    $('#c_id').val(id);
    $('#modal-update').find('input[name="code_name"]').val(name);
    $('#modal-update').find('input[name="duration"]').val(validity);
    $('#modal-update').find('input[name="amount"]').val(netAmount);
    $('#modal-update').find('input[name="expiry_date"]').val(expiry); 
    $('#modal-update').find('input[name="tax"]').val(tax);
    $('#modal-update').find('input[name="price"]').val(price);
    $('#modal-update').find('select[name="status"]').val(status);
    $('#modal-update').find('select[name="devices"]').val(devices);
    if (status == '0') {
        $('#modal-update').find('input[name="code_name"]').prop('disabled', true);
        $('#modal-update').find('input[name="duration"]').prop('disabled', true);
        $('#modal-update').find('input[name="amount"]').prop('disabled', true);
        $('#modal-update').find('input[name="expiry_date"]').prop('disabled', true);
        $('#modal-update').find('input[name="tax"]').prop('disabled', true);
        $('#modal-update').find('input[name="price"]').prop('disabled', true);
        $('#modal-update').find('select[name="status"]').prop('disabled', true);
        $('#modal-update').find('select[name="devices"]').prop('disabled', true);
    }
});
            $(document).on('keyup', '.net-amt', function(){        
                updatePrice();
            }); 

            $(document).on('keyup', '.net-amt2', function(){  
                var gst = "<?php echo $gst_rate; ?>";
                var amount = $(this).val();
                updatePrice2(gst, amount);
            }); 
        });        
            //Update Tax Rate
            function updatePrice(){
                var tmp_amt =  $('.net-amt2').val();
                var tax_amt = parseFloat(tmp_amt*gst)/100;
                var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
                new_price = new_price.toFixed(2);
                $('.tax-amt').val(tax_amt);
                $('.price-amt').val(new_price);
                }


                function updatePrice2(gst, amount ){
                var tmp_amt = amount;
                var gst = gst;
                var tax_amt = parseFloat(tmp_amt*gst)/100;
                var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
                new_price = new_price.toFixed(2);
                $('.tax-amt2').val(tax_amt);
                $('.price-amt2').val(new_price);
                }
        </script>
@endsection
