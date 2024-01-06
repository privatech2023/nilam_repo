@extends('layouts.adminFrontend')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Clients</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
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



                        <form action="{{ url('/admin/user/update/')}}" method="post" class="form-horizontal">
                            @csrf
                            @foreach($data as $user)

                            <input type="hidden" name="user_id" value="{{ $user->id}}">
                            <div class="form-group row">
                                
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name}}"
                                        placeholder="Name"/>
                                </div>
                            </div>

                           
                            <div class="form-group row">
                               
                                <label for="inputGender" class="col-sm-2 col-form-label">Gender</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="gender">
                                        <option value="" selected>Select</option>
                                        <option value="male" >Male </option>
                                        <option value="female">Female </option>
                                    </select>
                                </div>
                            </div>

                           
                            <div class="form-group row">
                                
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $user->email}}" placeholder="Email">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                
                                <label for="inputName2" class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="mobile"
                                        value="{{ $user->mobile}}" placeholder="10 digit mobile no">
                                </div>
                            </div>

                           
                            <div class="form-group row">
                                
                                <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="1" selected>Active </option>
                                        <option value="2">Disabled </option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                
                                <label for="inputName2" class="col-sm-2 col-form-label">Role</label>
                                
                                <div class="col-sm-10">
                                    <select class="form-control" name="role">
                                        <option value="" selected>Select</option>
                                        @foreach($groups as $group)
                                        <option value="{{$group->id}}" @if($group->group_name == $user->user_type) selected @endif>
                                            {{$group->group_name}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                               
                                <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                
                                <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="passconf" placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </div>
                            @endforeach
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

});
</script>

@endsection
