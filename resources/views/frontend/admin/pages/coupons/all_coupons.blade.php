@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Discount Coupons</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Coupons</a></li>
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
                            <h3 class="card-title">All Coupons</h3>
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
                                <tr>
                                    <th>#</th>
                                    <th>Coupon</th>
                                    <th>Promoter</th>
                                    <th>Discount(%)</th>
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

    {{-- Add Modal --}}
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <!-- form start -->
                    <form role="form" action="{{ url('/admin/createCoupon')}}" method="post">
                        @csrf
                        <div class="card-body">
    
                            <div class="row">
    
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
                                        <label for="name">Coupon Name *</label>
                                        <input type="text" class="form-control" name="coupon_name" placeholder="Name of Coupon Code" autocomplete="off" required>
                                    </div>
    
                                </div>
    
                                <div class="col-sm-6"></div>
    
                            </div>
    
                            <div class="row">
    
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
                                        <label for="exampleInputPassword1">Promoter Name (optional)</label>
                                        <input type="text" class="form-control" name="promoter" placeholder="Promoter Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
    
                            </div>
    
    
                            <div class="row">
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
    
                                        <label for="amount">Discount (%)</label>
                                        <input type="number" class="form-control price-amt" name="discount_pcn" placeholder="Discount" value="0">
    
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
    
    </div>

    {{-- Update Modal --}}
    <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <!-- form start -->
                    <form role="form" action="{{ url('/admin/updateCoupon')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="row_id" id="update_id">
                            <div class="row">
    
                                <div class="col-sm-6">
    
    
                                    <div class="form-group input-group-sm">
                                        <label for="name">Coupon Name *</label>
                                        <input type="text" class="form-control" name="coupon_name" id="idCouponName" placeholder="Name of Coupon Code" autocomplete="off" required>
                                    </div>
    
                                </div>
    
                                <div class="col-sm-6"></div>
    
    
                            </div>
    
    
                            <div class="row">
    
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
                                        <label for="exampleInputPassword1">Promoter Name (optional)</label>
                                        <input type="text" class="form-control" name="promoter" id="idPromoter" placeholder="Promoter Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
    
                            </div>
    
    
    
                            <div class="row">
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
    
                                        <label for="amount">Discount (%)</label>
                                        <input type="number" class="form-control price-amt" name="discount_pcn" id="idDiscount" placeholder="Discount" value="0">
    
                                    </div>
                                </div>
                                <div class="col-sm-6">
    
                                    <div class="form-group input-group-sm">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="idStatus">
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
    
    </div>

   
    <!--Delete Modal-->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Coupon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> the Coupon <strong><span id="delName"></span></strong> ?</p>
                <form action="{{ url('/admin/deleteCoupon')}}" method="post">
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
        $("#packageSubMenuCoupons").addClass('active');
    
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
                url:"/admin/coupons/ajaxCallAllCoupons", 
                type: "post",
                data: function(data) {
                    var type = $('#searchByStatus').val();
                    data.status = type;
                }
            },
            columns: [
                {
                    mRender: function(data, type, full, meta) {
                        return i++;
                    }
                },
                {
                    data: "coupon"
                },
                {
                    data: "promoter_name"
                },
                {
                    data: "discount_percentage"
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
                            row.cp_id + '" data-name="' + row.coupon + '" data-promoter="' + row
                            .promoter_name + '" data-discount="' + row.discount_percentage +
                            '" data-status="' + row.is_active +
                            '" >Edit</button> <button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' +
                            row.cp_id + '" data-name="' + row.coupon + '" >Del</button>'
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
            bFilter: true,
        });
    
        $('#searchByStatus').change(function() {
            dataTable.draw();
        });
    
        // Handle the "Edit" button click event
        $('#dataTable tbody').on('click', '.edit-button', function() {
            var data = dataTable.row($(this).parents('tr')).data();
            var edit_id = $(this).data('id');
            var edit_name = $(this).data('name');
            var edit_promoter = $(this).data('promoter');
            var edit_discount = $(this).data('discount');
            var edit_status = $(this).data('status');
    
            $('#update_id').val(edit_id);
            $('#idCouponName').val(edit_name);
            $('#idPromoter').val(edit_promoter);
            $('#idDiscount').val(edit_discount);
            $('#idStatus').val(edit_status);
        });
    
        $('#modal-delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var todo_id = button.data('id');
            var todo_name = button.data('name');
    
            var modal = $(this);
            modal.find('.modal-body #del_id').val(todo_id);
            modal.find('.modal-body #delName').text(todo_name);
        });
    
    });
</script> 

@endsection
