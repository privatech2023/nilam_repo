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
                                        <input type="date" class="form-control net-amt" name="expiry_date" placeholder="Expiry date"
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                    data: "expiry_date", // Use expiry_date from your data
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
                        mRender: function(data, type, row) {
                            return '<button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' + row.c_id + '" data-name="' + row.code + '" >Del</button>'
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
                var button = $(event.relatedTarget) // Button that triggered the modal
                var todo_id = button.data('id')
                var todo_name = button.data('name')
        
                var modal = $(this)
                modal.find('.modal-body #del_id').val(todo_id)
                modal.find('.modal-body #delName').text(todo_name)
        
            });
        
        
            $(document).on('change', '.net-amt', function(){
        
                updatePrice();
         
            }); 
        });
        
            //Update Tax Rate
            function updatePrice(){
        
                var tmp_amt =  $('.net-amt').val();
                var gst = "<?php echo $gst_rate; ?>";
                var tax_amt = parseFloat(tmp_amt*gst)/100;
                var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
                new_price = new_price.toFixed(2);
                $('.tax-amt').val(tax_amt);
                $('.price-amt').val(new_price);
        
                }
        </script>
@endsection
