@extends('layouts.adminFrontend')

@section('main-container')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expired Subscriptions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Clients</a></li>
                            <li class="breadcrumb-item active">Expired Subscriptions</li>
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
                            <h3 class="card-title">All Clients</h3>
                            <div class="card-tools">
                                <span><a href="{{ url('admin/dashboard') }}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Custom Filter -->
                            <table class="float-right">
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm" id="searchByStatus">
                                            <option value="">-- Status--</option>
                                            <option value="1">Active</option>
                                            <option value="2">Disabled</option>
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
                                        <th>Registration date</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Package</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are You sure to <strong>delete</strong><strong> <span id="delName"></span></strong> ?</p>
                    <form action="{{ url('/admin/clientsDelete')}}" method="post">
                        @csrf
                        <input type="hidden" name="client_id" id="del_id" value="">
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- DataTable Script -->
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });


            $("#clientTree").addClass('menu-open');
    $("#clientMenu").addClass('active');
    $("#clientSubMenuExpired").addClass('active');


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
            url:"/admin/clients/ajaxCallAllClientsExpired",
            type: "post",
            data: function(data) {    
                var type = $('#searchByStatus').val();
                // Append to data
                data.status = type;
            }
        },
        columns: [{
                 data: "client_id"
            },
            {
                data: "name"
            },
            {
                data: "mobile_number"
            },
            {
                data: "email"
            },
            {
                    mRender: function(data, type, row) {
                        return row.subscriptions == 1 ? '<span class="badge bg-success">YES</span>' : '<span class="badge bg-warning">NO</span>';
                    }
            },
            {
                data: "created_at"
            },
            {
                mRender: function(data, type, row) {
                    if (row.status == 1) {
                        return '<span class="badge bg-success">ACTIVE</span>';
                    } else {
                        return '<span class="badge bg-warning">DISABLED</span>';
                    }
                }
            },
            {
               
               mRender: function(data, type, row) {
   var viewLink = '{{ url('admin/view-client') }}' + '/' + row.client_id;
   var viewButton = '';
   var deleteButton = '';

   // Checking adminName and user permissions
   var adminName = {!! json_encode(session('admin_name')) !!}; // Convert PHP session data to JavaScript variable
   var userPermissions = {!! json_encode(session('user_permissions')) !!}; // Convert PHP session data to JavaScript variable

   // Checking if the user is admin or has 'updateCode' permission
   if (adminName === 'admin' || (userPermissions !== null && userPermissions.includes('viewClient'))) {
       // If user is admin or has 'updateCode' permission, enable view button
       viewButton = '<a href="' + viewLink + '" class="btn btn-outline-info btn-xs">VIEW</a>';
   }
   else{
       viewButton = '<a href="' + viewLink + '" class="btn btn-outline-info btn-xs disabled">VIEW</a>';
   }

   // Checking if the user has 'deleteClient' permission
   if (adminName === 'admin' || (userPermissions !== null && userPermissions.includes('deleteClient'))) {
       deleteButton = '<button class="btn btn-outline-danger btn-xs btn-delete" data-name="'+row.name+'" data-id="' + row.client_id + '">DEL</button>';
   }
   else{
       deleteButton = '<button class="btn btn-outline-danger btn-xs btn-delete disabled" data-name="'+row.name+'" data-id="' + row.client_id + '">DEL</button>';
   }

   return viewButton + ' ' + deleteButton;
}


           }

        ],
        columnDefs: [     

            {
                orderable: false,
                searchable: false,
                targets: 0
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

    $(document).on('click','.btn-delete', function(event) {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#del_id').val(id);
        $('#delName').text(name);
        $('#modal-delete').modal('show');
    });

    $('#searchByStatus').change(function() {

        dataTable.draw();
    });
        });
    </script>

@endsection
