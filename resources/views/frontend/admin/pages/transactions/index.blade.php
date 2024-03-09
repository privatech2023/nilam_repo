@extends('layouts.adminFrontend')

@section('main-container')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transactions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transactions</a></li>
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
                        <h3 class="card-title">All Transactions</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                data-target="#modal-add">Create Transaction</button>
                            <button type="button" class="btn btn-block btn-warning btn-sm" data-toggle="modal"
                                data-target="#modal-update">Update manual transaction</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">

                        <!-- Custom Filter -->
                        <table class="float-right">
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm" id='searchByStatus'>
                                        <option value=''>-- Status--</option>
                                        <option value='1'>Pending</option>
                                        <option value='2'>Success</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <table id="dataTable" class="table table-xs text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Txn ID</th>
                                    <th>Dated</th>
                                    <th>Client</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>validity</th>
                                    <th>Mode</th>
                                    <th>Amt</th>
                                    <th>Tax</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Package</th>
                                    <th>Act Code</th>
                                    <th>Coupon</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->




    <!-- Add Modal-->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form role="form" action="{{ url('/admin/createTransaction')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="name">Client mobile number</label>
                                    <input type="text" class="form-control" name="client_mobile"
                                        placeholder="Enter client id" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">Storage limit in GB</label>
                                    <input type="number" class="form-control" name="storage"
                                        placeholder="Storage limit" min="0" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="status">Validity</label>
                                    <select class="form-control" name="storage_validity" required>
                                    <option value="" selected>Select</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Device</label>
                                    <input type="number" class="form-control tax-amt" name="device" placeholder="Number of devices" 
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Subscription validity</label>
                                    <input type="number" class="form-control tax-amt" name="subscription_validity" placeholder="subscription validity" 
                                        required>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm swalDefaultSuccess">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 



{{-- update modal --}}
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form role="form" action="{{ url('/admin/updateTransaction')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="name">Client mobile number</label>
                                    <input type="text" class="form-control" name="client_mobile"
                                        placeholder="Enter client id" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">Storage limit in GB</label>
                                    <input type="number" class="form-control" name="storage"
                                        placeholder="Storage limit" min="0" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="status">Validity</label>
                                    <select class="form-control" name="storage_validity" >
                                    <option value="" selected>Select</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Device</label>
                                    <input type="number" class="form-control tax-amt" name="device" placeholder="Number of devices" 
                                        >
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Subscription validity</label>
                                    <input type="number" class="form-control tax-amt" name="subscription_validity" placeholder="subscription validity" 
                                        required>
                                </div>
                            </div> --}}
                        </div>                       
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm swalDefaultSuccess">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
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
        $("#transactionsMenu").addClass('active');

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        var dataTable = $('#dataTable').DataTable({
            lengthMenu: [
            [10, 30, -1],
            [10, 30, "All"]
        ], 
        bProcessing: true,
        serverSide: true,
        responsive: true,
        scrollCollapse: true,
        ajax: {
            url: "/admin/transactions/ajaxCallAllTxn", // json datasource
            type: "post",
            data: function(data) {
                // key1: value1 - in case if we want send data with request      
                var type = $('#searchByStatus').val();
                // Append to data
                data.status = type;
            }
        },
        columns: [{
                data: "t_id"
            },
            {
                data: "txn_id"
            },
            {
                data: "updated_at"
            },
            {
                data: "name"
            },
            {
                data: "mobile_number"
            },   
            {
                data: "txn_type"
            },           
            {
                data: "plan_validity_days"
            },           
             {
                data: "txn_mode"
            },           
             {
                data: "net_amount"
            },            
            {
                data: "tax_amt"
            },           
             {
                data: "price"
            },            
            {
                data: "discount_amt"
            },            
            {
                data: "package_name"
            },            
            {
                data: "activation_code"
            },            
            {
                data: "coupon_code"
            },
            {
                mRender: function(data, type, row) {
                    if (row.status == 2) {
                        return '<span class="badge bg-success">Success</span>';
                    } else {
                        return '<span class="badge bg-warning">Pending</span>';
                    }
                }
            },

        ],
        columnDefs: [     
            {
                orderable: false,
                searchable: false,
                targets: [0,1,4,5,6,7,8,9,10,11,12,13,14]
            },
            {
                className: 'text-center',
                targets: [1, 2, 3, 4, 5,6]
            },
            {
                "targets": [1, 2, 3, 4, 5],
                "render": function(data) {
                    return data;
                },
            },
        ],
        "order": [[ 1, 'asc' ]],
        bFilter: true, // to display datatable search

        "drawCallback": function(settings) {
            var api = this.api();
            var startIndex = api.context[0]._iDisplayStart;

            api.column(0).nodes().each(function(cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
        }
        });

        $('#searchByStatus').change(function() {
            dataTable.draw();
        });
    });
</script>
@endsection
