@extends('layouts.adminFrontend')
@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create roles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-12">
            
            <!-- /.card -->

            <div class="card card-outline card-info">
              <div class="card-header">
                <span>
                    <a href="{{ url('/admin')}}" class="btn btn-outline-info btn-sm">
                      <i class="fas fa-long-arrow-alt-left mr-1">
                      </i>
                      Back
                    </a>
                  </span>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ url('/admin/create-roles')}}">
                    @csrf
                
                <div class="form-group">
                    <label for="group_name">Role name</label>
                    <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Enter role name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label for="permission">Permission</label>
                    <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Create</th>
                            <th>Update</th>
                            <th >View</th>
                            <th >Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $role)
                            <tr>
                                <td>
                                    <input type="hidden" value="{{ $role->id }}" name="role_id" />
                                    {{ $role->name }}
                                </td>
                                <td>
                                    <input type="checkbox" name="permission[]" id="permission" value="createClient_{{ $role->id }}" />
                                </td>
                                <td>
                                    <input type="checkbox" name="permission[]" id="permission" value="updateClient_{{ $role->id }}" />
                                </td>
                                <td>
                                    <input type="checkbox" name="permission[]" id="permission" value="viewClient_{{ $role->id }}" />
                                </td>
                                <td>
                                    <input type="checkbox" name="permission[]" id="permission" value="deleteClient_{{ $role->id }}" />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/admin/roles')}}" class="btn btn-warning btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
            </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
        </div>
        <!-- /.row -->
        
        <!-- /.row -->
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection