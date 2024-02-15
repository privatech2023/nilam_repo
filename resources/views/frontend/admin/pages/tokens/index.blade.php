@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ISSUE TOKENS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tokens</a></li>
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
                            <h3 class="card-title">All tokens</h3>
                            <div class="card-tools">
                                
                            <a href="{{ url('/admin/add-token')}}" class="btn btn-block btn-success btn-sm">Create new</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Custom Filter -->
                            <table class="float-right">
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm" id='searchByStatus'>
                                            <option value=''>-- Status--</option>
                                            <option value='0'>Pending</option>
                                            <option value='1'>Success</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table id="dataTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr><th>ID</th>
                                    <th>Name</th>
                                    <th>Device ID</th>
                                    <th>Client</th>
                                    <th>Description</th>
                                    <th>Start date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

    


    {{-- delete modal --}}
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> the token<strong><span id="delName"></span></strong>
                    ?</p>
                <form action="{{url('/admin/delete/token')}}" method="post" style="margin-top: 4px;">
                    @csrf
                    <input type="hidden" name="row_id" id="del_id" value="">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-outline-success">Confirm</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{{-- tech modal --}}
<div class="modal fade" id="modal-technical">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to assign this token to technical team</strong>
                    ?</p>
                <form action="{{url('/admin/assign/technical')}}" method="post" style="margin-top: 4px;">
                    @csrf
                    <input type="hidden" class="form-control" name="token2_id" id="token2_id" value="">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-outline-success">Confirm</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


    {{-- view modal --}}
    <div class="modal fade" id="modal-view">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Token</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/admin/token/update')}}" method="post" style="margin-top: 4px;">
                        @csrf
                        <div class="container view-token-detail">
                            <input class="form-control" type="hidden" name="token_id" id="token_id" value="">
    
                            <div class="form-group row">
                                <label for="type">Type</label>
                                <input class="form-control" id="type" name="type" type="text" value="" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="mobile_number">Contact number</label>
                                <input class="form-control" id="mobile_number" name="mobile_number" type="text" value="">
                            </div>
                            <div class="form-group row">
                                <label for="device_id">Device</label>
                                <input class="form-control" id="device_id" name="device_id" type="text" value="" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="start_date">Start date</label>
                                <input class="form-control" id="start_date" name="start_date" type="date" value="" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="end_date">End date</label>
                                <input class="form-control" id="end_date" name="end_date" type="date" value="">
                            </div>
                            <div class="form-group row">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" >
                                    <option value="" selected>Select</option>
                                    <option value="1">Success</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit"  class="btn btn-outline-success">Update</button>
                        </div>
                    </form>
                </div>
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

            
            var techTokens = {!! json_encode($tech->pluck('token_id')) !!};


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
                    url: "/admin/token/ajaxCallAllTokens", 
                    type: "post",
                    data: function(data) {  
                        var type = $('#searchByStatus').val();
                        data.status = type;
                    }
                },
                
                columns: [
                    {
                        data: "id"
                    },
                    {
                        data: "issue_type_name"
                    },
                    {
                        data: "device_id",
                    },
                    {
                        data: "client_name",
                    },
                    {
                        data: "detail"
                    },
                    {
                        data: "start_date"
                    },
                    {
                        data: "end_date",
                        render: function(data, type, row) {
                        if (data === null || data === "") {
                        return '<span class="badge badge-warning">Not allotted</span>';
                        } else {
                        return data;
                        }
                    }
                    },
                    {
                        mRender: function(data, type, row) {
                            if (row.status == 1) {
                                return '<span class="badge bg-success">SUCCESS</span>';
                            } else {
        
                                return '<span class="badge bg-warning">PENDING</span>';
                            }                                       
                        }
                    },
                    {
                        mRender: function(data, type, row) {
        var disabled = techTokens.includes(row.id) ? 'disabled' : '';
        return '<button class="btn btn-outline-info btn-xs view-btn" data-value="' + row.id + '">VIEW</button>' +
            '<button class="btn btn-outline-danger btn-xs del-button" data-value="' + row.id + '">Del</button>' +
            '<button style="margin-left:2px; color: grey;" class="btn btn-outline-warning btn-xs technical-button" data-value="' + row.id + '" ' + disabled + '>TECHNICAL</button>';
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
        
        
            $(document).on('click','.del-button', function(){
            var data = $(this).data('value');
                $('#del_id').val(data);
                $('#modal-delete').modal('show');
        });
        
        $(document).on('click','.view-btn', function(){
            var data = $(this).data('value');
            

                $('#view_id').val(data);
                $.ajax({
                    type: "post",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/token/get/"+data,
                    dataType: "json",
                    success: function (response) {
                        
                        $('#token_id').val(response.data.id);
                        $('#type').val(response.type.name);
                        $('#mobile_number').val(response.data.mobile_number);
                        $('#device_id').val(response.device_name.device_name);
                        $('#start_date').val(response.data.start_date);
                        $('#end_date').val(response.data.end_date);
                        $('select[name="status"]').val(response.data.status);
                        $('#modal-view').modal('show');
                    }
                });
        });

        $(document).on('click','.technical-button',function(){
            $('#modal-technical').modal('show');
            var data = $(this).data('value');
            $('#token2_id').val(data);
        });

        });
        </script>
@endsection
