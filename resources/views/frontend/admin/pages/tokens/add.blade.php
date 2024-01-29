@extends('layouts.adminFrontend')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Token</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Tokens</a></li>
                        <li class="breadcrumb-item active">New</li>
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
                        <span><a href="" class="btn btn-outline-info btn-sm"><i
                                    class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>

                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                        <form action="{{ url('/admin/token/create')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="form-group row">
                               
                                <label for="input" class="col-sm-2 col-form-label">Select Type</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="type" required>
                                        <option value="" selected>Select</option>
                                        @foreach($type as $t)
                                        <option value="{{$t->id}}">{{ $t->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="input" class="col-sm-2 col-form-label">Select client</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="client" id="clientSelect" required>
                                        <option value="" selected>Select</option>
                                        @foreach($client as $cl)
                                        <option value="{{$cl->client_id}}">{{ $cl->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <label for="inputName2" class="col-sm-2 col-form-label">Device</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="device" id="select_device" required>
                                        <option value="" selected>Select</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Contact number</label>
                                <div class="col-sm-10">
                                    <input type="text" name="mobile_number" class="form-control" placeholder="Contact number" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Start date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">End date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="end_date" class="form-control" placeholder="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" placeholder="Issue description" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Add</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script>
var site_url = "";

$(document).ready(function() {


    $("#employeeTree").addClass('menu-open');
    $("#employeeMenu").addClass('active');
    $("#employeeSubMenuManage").addClass('active');

    $('#clientSelect').on('change', function(){
        
        var selectedClient = $(this).val();
        $.ajax({
            type: "post",
            url: "/admin/token/device",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                    client_id: selectedClient
                },
            dataType: "json",
            success: function (response) {
                $('#select_device').empty();
                $('#select_device').append('<option value="" selected>Select</option>');
                $.each(response, function(index, device) {
                $('#select_device').append('<option value="' + device.device_id + '">' + device.device_name + '</option>');
            });
            }
        });
    });



});
</script>

@endsection