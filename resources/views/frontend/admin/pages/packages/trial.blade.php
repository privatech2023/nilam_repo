@extends('layouts.adminFrontend')
@section('main-container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Trial Packages</h1>
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
                            @if(in_array('createPackage', session('user_permissions')) || session('admin_name') == 'admin')
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                data-target="#modal-add">Add Trial Package</button>
                            @else
                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                            data-target="#modal-add" disabled>Add Package</button>
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
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Devices</th>
                                    <th>Tax</th>
                                    <th>Price</th>
                                    <th>Features</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  --}}
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
                <form role="form" action="{{ url('/admin/createTrialPackages')}}" method="post">
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group input-group">
                                        <label for="devices">Number of devices</label>
                                        <select class="form-control" name="devices" required>
                                            @for ($i = 1; $i <= config('devices.max_devices'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="features">Features</label><br>
                                    <input type="checkbox" name="features[]" id="features" value="alertDevice"> Alert device <br>  
                                    <input type="checkbox" name="features[]" id="features" value="textToSpeech"> Text to speech <br>
                                    <input type="checkbox" name="features[]" id="features" value="vibratePhone"> Vibrate phone  <br>
                                    <input type="checkbox" name="features[]" id="features" value="lostMessage"> Lost message <br>
                                    <input type="checkbox" name="features[]" id="features" value="deviceStatus"> Device status <br>
                                    <input type="checkbox" name="features[]" id="features" value="location"> Location <br>
                                    <input type="checkbox" name="features[]" id="features" value="simDetails"> Sim details <br>
                                    <input type="checkbox" name="features[]" id="features" value="message"> Message <br>
                                    <input type="checkbox" name="features[]" id="features" value="callLog"> Call log <br>
                                    <input type="checkbox" name="features[]" id="features" value="contact"> Contact <br>
                                    <input type="checkbox" name="features[]" id="features" value="facebook"> Facebook <br>
                                    <input type="checkbox" name="features[]" id="features" value="whatsapp"> Whatsapp <br>
                                    <input type="checkbox" name="features[]" id="features" value="instagram"> Instagram <br>
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





<!-- Update Modal-->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update package</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form role="form" action="{{ url('/admin/updateTrialPackages')}}" method="post">
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
                                    <input type="number" class="form-control net-amt2" name="amount" id="idAmount" placeholder="Amount"
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
                                    <label for="devices">Number of devices</label>
                                    <select class="form-control" id="idDevices" name="devices" required>
                                            @for ($i = 1; $i <= config('devices.max_devices'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
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
                            <div class="row">
                                <div class="col-12">
                                    <label for="features">Features</label><br>
                                    <input type="checkbox" name="features[]" id="featuresAlert" value="alertDevice"> Alert device <br>  
                                    <input type="checkbox" name="features[]" id="featuresSpeech" value="textToSpeech"> Text to speech <br>
                                    <input type="checkbox" name="features[]" id="featuresVibrate" value="vibratePhone"> Vibrate phone  <br>
                                    <input type="checkbox" name="features[]" id="featuresLost" value="lostMessage"> Lost message <br>
                                    <input type="checkbox" name="features[]" id="featuresDevice" value="deviceStatus"> Device status <br>
                                    <input type="checkbox" name="features[]" id="featuresLocation" value="location"> Location <br>
                                    <input type="checkbox" name="features[]" id="featuresSim" value="simDetails"> Sim details <br>
                                    <input type="checkbox" name="features[]" id="featuresMessage" value="message"> Message <br>
                                    <input type="checkbox" name="features[]" id="featuresCall" value="callLog"> Call log <br>
                                    <input type="checkbox" name="features[]" id="featuresContact" value="contact"> Contact <br>
                                    <input type="checkbox" name="features[]" id="featuresFacebook" value="facebook"> Facebook <br>
                                    <input type="checkbox" name="features[]" id="featuresWhatsapp" value="whatsapp"> Whatsapp <br>
                                    <input type="checkbox" name="features[]" id="featuresInstagram" value="instagram"> Instagram <br>
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
                <form action="{{ url('/admin/deleteTrialPackages')}}" method="post">
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
        console.log(window.PHPUnserialize); 
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
        ], 
        bProcessing: true,
        serverSide: true,
        scrollY: "400px",
        scrollCollapse: true,
        ajax: {
            url: "/admin/packages/ajaxCallAllTrialPackages", 
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
                data: "name"
            },
            {
                data: "duration_in_days"
            },
            {
                data: "net_amount"
            },
            {
                data: "devices"
            },
            {
                data: "tax"
            },
            {
                data: "price"
            },
            {
                data: "features"
            },
            {
                mRender: function(data, type, row) {
                    console.log(row)
                    if (row.is_active == 1) {
                        return '<span class="badge bg-success">ACTIVE</span>';
                    } else {
                        return '<span class="badge bg-warning">DISABLED</span>';
                    }
                }
            },
            {
                mRender: function(data, type, row) {
    var editButton = '';
    var deleteButton = '';

    // Check if the user has permission to updatePackage or is admin
    if ({{ in_array('updatePackage', session('user_permissions')) ? 'true' : 'false' }} || '{{ session('admin_name') }}' == 'admin') {
        editButton = '<button class="btn btn-outline-warning btn-xs edit-button" data-toggle="modal" data-target="#modal-update" data-id="' +
            row.id + '" data-name="' + row.name + '" data-duration="' + row.duration_in_days + '" data-amount="' + row.net_amount + '" data-tax="' + row.tax + '" data-price="' + row.price + '" data-status="' + row.is_active + '">Edit</button> ';
    } else {
        editButton = '<button class="btn btn-outline-warning btn-xs edit-button" disabled>Edit</button> ';
    }

    if ({{ in_array('deletePackage', session('user_permissions')) ? 'true' : 'false' }} || '{{ session('admin_name') }}' == 'admin') {
        deleteButton = '<button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' + row.id + '" data-name="' + row.name + '">Del</button>';
    } else {
        deleteButton = '<button class="btn btn-outline-danger btn-xs del-button" disabled>Del</button>';
    }

    return editButton + deleteButton;
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
                targets: [1, 2, 3, 4, 5, 6]
            },
            {
                "targets": [1, 2, 3, 4, 5, 6],
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
    var edit_devices = rowData.devices;
    var features = rowData.features;

    $('#update_id').val(edit_id);
    $('#idPackageName').val(edit_name);
    $('#idDuration').val(edit_duration);
    $('#idAmount').val(edit_amount);
    $('#idTax').val(edit_tax);
    $('#idPrice').val(edit_price);
    $('#idStatus').val(edit_status);
    $('#idDevices').val(edit_devices);

    $('#idDevices').find('option').removeAttr('selected');
    $('#idDevices option[value="' + edit_devices + '"]').attr('selected', 'selected');

    if(features.includes('alertDevice')){
        document.getElementById('featuresAlert').checked = true;
    }
    if(features.includes('textToSpeech')){
        document.getElementById('featuresSpeech').checked = true;
    }
    if(features.includes('vibratePhone')){
        document.getElementById('featuresVibrate').checked = true;
    }
    if(features.includes('lostMessage')){
        document.getElementById('featuresLost').checked = true;
    }
    if(features.includes('deviceStatus')){
        document.getElementById('featuresDevice').checked = true;
    }
    if(features.includes('location')){
        document.getElementById('featuresLocation').checked = true;
    }
    if(features.includes('simDetails')){
        document.getElementById('featuresSim').checked = true;
    }
    if(features.includes('message')){
        document.getElementById('featuresMessage').checked = true;
    }
    if(features.includes('callLog')){
        document.getElementById('featuresCall').checked = true;
    }
    if(features.includes('contact')){
        document.getElementById('featuresContact').checked = true;
    }
    if(features.includes('facebook')){
        document.getElementById('featuresFacebook').checked = true;
    }
    if(features.includes('whatsapp')){
        document.getElementById('featuresWhatsapp').checked = true;
    }
    if(features.includes('instagram')){
        document.getElementById('featuresInstagram').checked = true;
    }

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

        $(document).on('keyup', '.net-amt2', function(){
        updatePrice2();
        });

    function updatePrice(){
    var tmp_amt =  $('.net-amt').val();
    console.log(tmp_amt)
    var gst = {{ $gst_rate}};
    var tax_amt = parseFloat(tmp_amt*gst)/100;
    var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
    new_price = new_price.toFixed(2);
    $('.tax-amt').val(tax_amt);
    $('.price-amt').val(new_price);
    }

    function updatePrice2(){
    var tmp_amt =  $('.net-amt2').val();
    console.log(tmp_amt)
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
