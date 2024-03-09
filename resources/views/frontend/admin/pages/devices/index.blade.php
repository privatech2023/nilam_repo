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
                        <li class="breadcrumb-item"><a href="#">Devices</a></li>
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
                            <button type="button" class="btn-sm btn-danger"><a href="{{url('/log/clear')}}">Clear logs</a></button>
                            @if(in_array('createPackage', session('user_permissions')) || session('admin_name') == 'admin')
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                data-target="#modal-add">Add device</button>
                            @else
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                            data-target="#modal-add" disabled>Add device</button>
                            @endif
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
                                    <th>device id</th>
                                    <th>device token</th>
                                    <th>client id</th>
                                    <th>host</th>
                                    <th>manufacturer</th>
                                    <th>android version</th>
                                    <th>updated at</th>
                                    <th>action</th>
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

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create device</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form role="form" action="{{ url('/admin/devices/create')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="name">device Name *</label>
                                    <input type="text" class="form-control" name="device_name" 
                                        placeholder="Name of device" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">device id</label>
                                    <input type="text" class="form-control" name="device_id" 
                                        placeholder="device id" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">Device token</label>
                                    <input type="text" class="form-control" name="device_token"  placeholder="token"
                                        required autocomplete="off" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="client_id">client_id </label>
                                    <input type="number" class="form-control " name="client_id" placeholder="client id"
                                        required >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="host">host </label>
                                    <input type="text" class="form-control " name="host"  placeholder="host"
                                        >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">manufacturer</label>
                                    <input type="text" class="form-control " name="manufacturer" placeholder="manufacturer"
                                        >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">android version</label>
                                    <input type="text" class="form-control " name="android_version"  placeholder="android_version"
                                        >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">product</label>
                                    <input type="text" class="form-control " name="product"  placeholder="product" 
                                        >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">brand</label>
                                    <input type="text" class="form-control " name="brand"  placeholder="brand" 
                                        >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">model</label>
                                    <input type="text" class="form-control " name="model"  placeholder="model" 
                                        >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group input-group-sm">
                                    <label for="amount">battery</label>
                                    <input type="text" class="form-control " name="battery"  placeholder="battery" 
                                        >
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



<!-- Update Modal-->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update device</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form role="form" action="{{ url('/admin/devices/update')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="row_id" id="update_id">

                        <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="name">device Name *</label>
                                    <input type="text" class="form-control" name="device_name" id="idDeviceName"
                                        placeholder="Name of device" autocomplete="off" required>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="exampleInputPassword1">device id</label>
                                    <input type="text" class="form-control" name="device_id" id="device_id"
                                        placeholder="device id" required autocomplete="off">
                                </div>

                            </div>


                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">Device token</label>
                                    <input type="text" class="form-control" name="device_token" id="device_token" placeholder="token"
                                        required autocomplete="off" value="">

                                </div>


                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="client_id">client_id </label>
                                    <input type="number" class="form-control " name="client_id" id="client_id" placeholder="client id"
                                        required readonly>
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">
                                    <label for="host">host </label>
                                    <input type="text" class="form-control " name="host" id="host" placeholder="host"
                                        >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">manufacturer</label>
                                    <input type="text" class="form-control " name="manufacturer" id="manufacturer" placeholder="manufacturer"
                                        >

                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">android version</label>
                                    <input type="text" class="form-control " name="android_version" id="android_version" placeholder="android_version"
                                        >

                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group input-group-sm">

                                    <label for="amount">updated at</label>
                                    <input type="text" class="form-control " name="updated_at" id="updated_at" placeholder="updated at" required
                                        >

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
                <form action="{{ url('/admin/devices/delete')}}" method="post">
                    @csrf
                    <input type="hidden" name="row_id" id="del_id" >
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
            url: "/admin/devices/ajaxCallAllDevices", 
            type: "post",
            data: function(data) {
                var type = $('#searchByStatus').val();
                data.status = type;
            }
        },
        columns: [{
                mRender: function(data, type, full, meta) {
                    return i++;
                }
            },
            {
                data: "device_name"
            },
            {
                data: "device_id"
            },
            {
                data: "device_token"
            },
            {
                data: "client_id"
            },
            {
                data: "host",
                render: function(data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return "<span>NULL</span>";
                    }
                }
            },
            {
                data: "manufacturer",
                render: function(data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return "<span>NULL</span>";
                    }
                }
            },
            {
                data: "android_version",
                render: function(data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return "<span>NULL</span>";
                    }
                }
            },
            {
                data: "updated_at",
                render: function(data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return "<span>NULL</span>";
                    }
                }
            },
            {
                mRender: function(data, type, row) {
                        return '<button class="btn btn-outline-warning btn-xs edit-button" data-toggle="modal" data-target="#modal-update" data-id="' +
                            row.id + '" data-devicename="' + row.device_name + '" data-deviceid="' + row
                            .device_id + '" data-devicetoken="' + row.device_token +
                            '" data-clientid="' + row.client_id +
                            '" data-devicehost="' + row.host + '"  data-devicemanufacturer="' + row.manufacturer + '" data-androidversion="' + row.android_version + '" data-updatedat="' + row.updated_at + '">Edit</button> <button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' +
                            row.id + '" data-name="' + row.device_id + '" >Del</button>'
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



    // Handle the "Edit" button click event
    $('#dataTable tbody').on('click', '.edit-button', function() {
        var data = dataTable.row($(this).parents('tr')).data();
            var edit_id = $(this).data('id');
            var edit_name = $(this).data('devicename');
            var edit_deviceid = $(this).data('deviceid');
            var edit_devicetoken = $(this).data('devicetoken');
            var edit_clientid = $(this).data('clientid');
            var edit_devicehost = $(this).data('devicehost');
            var edit_devicemanufacturer = $(this).data('devicemanufacturer');
            var edit_androidversion = $(this).data('androidversion');
            var edit_updatedat = $(this).data('updatedat');

    $('#update_id').val(edit_id);
    $('#idDeviceName').val(edit_name);
    $('#device_id').val(edit_deviceid);
    $('#device_token').val(edit_devicetoken);
    $('#client_id').val(edit_clientid);
    $('#host').val(edit_devicehost);
    $('#manufacturer').val(edit_devicemanufacturer);
    $('#android_version').val(edit_androidversion);
    $('#updated_at').val(edit_updatedat);

    });



    $('#modal-delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var todo_id = button.data('id')
        var todo_name = button.data('name')

        var modal = $(this)
        modal.find('.modal-body #del_id').val(todo_id)
        modal.find('.modal-body #delName').text(todo_name)

    });

        $(document).on('keyup', '.net-amt', function(){
        updatePrice();
        });

    
    });
</script>

@endsection
