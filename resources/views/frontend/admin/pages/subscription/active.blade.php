@extends('layouts.adminFrontend')

@section('main-container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Active Subscriptions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Clients</a></li>
                        <li class="breadcrumb-item active">Active Subscriptions</li>
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
                        <h3 class="card-title">Active Subscriptions</h3>
                        <div class="card-tools">
                            <span>
                                <a href="{{ url('/') }}" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-long-arrow-alt-left mr-1"></i>Back
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Custom Filter -->
                        <table class="float-right">
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm" id='searchByStatus'>
                                        <option value=''>-- Status--</option>
                                        <option value='1'>Active</option>
                                        <option value='2'>Disabled</option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <table id="dataTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Subscription</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data will be loaded dynamically using JavaScript -->
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

<script>

    $(document).ready(function() {
    var i = 1;

    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

    $("#clientTree").addClass('menu-open');
    $("#clientMenu").addClass('active');
    $("#clientSubMenuActive").addClass('active');

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
            url: "/admin/clients/ajaxCallAllClientsActive",
            type: "post",
            data: function(data) {
                var type = $('#searchByStatus').val();
                data.status = type;
            }
        },
        columns: [
            { data: "client_id" },
            { data: "name" },
            { data: "mobile_number" },
            { data: "email" },
            {
                mRender: function(data, type, row) {
                    return row.subscription > 0 ? '<span class="badge bg-success">YES</span>' : '<span class="badge bg-warning">NO</span>';
                }
            },
            {
                mRender: function(data, type, row) {
                    return row.status == 1 ? '<span class="badge bg-success">ACTIVE</span>' : '<span class="badge bg-warning">DISABLED</span>';
                }
            },
        ],
        columnDefs: [
            { orderable: false, targets: [0, 1, 2, 3] },
            { className: 'text-center', targets: [1, 2, 3, 4, 5] },
            {
                "targets": [1, 2, 3, 4, 5],
                "render": function(data) {
                    return data.toUpperCase();
                },
            },
        ],
        bFilter: true,
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

