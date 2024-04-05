@extends('layouts.adminFrontend')
@section('main-container')
<div class="content-wrapper">
<<<<<<< HEAD
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
                <form method="post" action="{{ url('/admin/roles/update') }}">
                @csrf
                <input type="hidden" name="row_id" value="{{ $data['group_id'] }}">
                <div class="card-body">
=======
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
                <form method="post" action="{{ url('/admin/roles/update') }}">
                    @csrf
                    <input type="hidden" name="row_id" value="{{ $data['group_id'] }}">
                    <div class="card-body">
>>>>>>> main
                        <span class="text-danger mb-1">{{ $errors->first('role_name') }}</span>
                        <div class="form-group">
                        <label for="group_name">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name"
                                placeholder="Enter Role Name" value="{{ $data['group_data']['group_name'] }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">

                        <label for="permission">Permission</label>

                        <?php $serialize_permission = unserialize($data['group_data']['permissions']); ?>

                        <table class="table table-sm">
                                <thead>
                                <tr>
                                        <th>#</th>
                                        <th>Create</th>
                                        <th>Update</th>
                                        <th>View</th>
                                        <th>Delete</th>
<<<<<<< HEAD
                                </tr>
=======
                                    </tr>
>>>>>>> main
                                </thead>
                                <tbody>


<<<<<<< HEAD
                                <tr>
=======
                                    <tr>
>>>>>>> main
                                        <td>Clients</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createClient"
                                                {{ in_array('createClient', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateClient"
                                                {{ in_array('updateClient', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewClient"
                                                {{ in_array('viewClient', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteClient"
                                                {{ in_array('deleteClient', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
<<<<<<< HEAD
                                </tr>
                                <tr>
=======
                                    </tr>
                                    <tr>
>>>>>>> main
                                        <td>Activation codes</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createCode"
                                                {{ in_array('createCode', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateCode"
                                                {{ in_array('updateCode', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewCode"
                                                {{ in_array('viewCode', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteCode"
                                                {{ in_array('deleteCode', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Dealers</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createDealer"
                                                {{ in_array('createDealer', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateDealer"
                                                {{ in_array('updateDealer', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewD"
                                                {{ in_array('viewDealer', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteDealer"
                                                {{ in_array('deleteDealer', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Packages</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createPackage"
                                                {{ in_array('createPackage', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updatePackage"
                                                {{ in_array('updatePackage', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewPackage"
                                                {{ in_array('viewPackage', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deletePackage"
                                                {{ in_array('deletePackage', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Transactions</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createTransaction"
                                                {{ in_array('createTransaction', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateTransaction"
                                                {{ in_array('updateTransaction', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewTransaction"
                                                {{ in_array('viewTransaction', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteTransaction"
                                                {{ in_array('deleteTransaction', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Reports</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createReport"
                                                {{ in_array('createReport', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateReport"
                                                {{ in_array('updateReport', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewReport"
                                                {{ in_array('viewReport', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteReport"
                                                {{ in_array('deleteReport', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Users</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createUser"
                                                {{ in_array('createUser', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateUser"
                                                {{ in_array('updateUser', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewUser"
                                                {{ in_array('viewUsers', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteUser"
                                                {{ in_array('deleteUser', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Roles</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createRole"
                                                {{ in_array('createRole', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateRole"
                                                {{ in_array('updateRole', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewRole"
                                                {{ in_array('viewRole', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteRole"
                                                {{ in_array('deleteRole', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Settings</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createSetting"
                                                {{ in_array('createSetting', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateSetting"
                                                {{ in_array('updateSetting', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewSetting"
                                                {{ in_array('viewSetting', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteSetting"
                                                {{ in_array('deleteSetting', $serialize_permission) ? 'checked' : '' }}>
                                        </td>

<<<<<<< HEAD
                                </tr>

                                <tr>
=======
                                    </tr>

                                    <tr>
>>>>>>> main
                                        <td>Token</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="createToken"
                                                {{ in_array('createToken', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="updateToken"
                                                {{ in_array('updateToken', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="viewToken"
                                                {{ in_array('viewToken', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="deleteToken"
                                                {{ in_array('deleteToken', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                </tr>
                                <tr>
                                        <td>Token to IT</td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="itAll"
                                                {{ in_array('itAll', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="itAll"
                                                {{ in_array('itAll', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="itAll"
                                                {{ in_array('itAll', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                        <td> <input type="checkbox" name="permission[]" id="permission"
                                                value="itAll"
                                                {{ in_array('itAll', $serialize_permission) ? 'checked' : '' }}>
                                        </td>
                                </tr>
<<<<<<< HEAD
                                <tr>
                                        <td>Earn commission</td>
                                        <td><input class="permission-checkbox" type="checkbox" name="permission[]" id="permission"
                                                value="commissionYes"
                                                {{ in_array('commissionYes', $serialize_permission) ? 'checked' : '' }} onclick="toggleCheckbox(this)"> Yes</td>
                                        <td><input class="permission-checkbox" type="checkbox" name="permission[]" id="permission"
                                                        value="commissionNo"
                                                        {{ in_array('commissionNo', $serialize_permission) ? 'checked' : '' }} onclick="toggleCheckbox(this)"> No</td>
                                </tr> 
                                </tbody>
                        </table>
=======

                                </tbody>
                            </table>

>>>>>>> main
                        </div>


                        <div class="card-footer">
<<<<<<< HEAD
                        <a href="{{ url('/admin/roles') }}"
                        class="btn btn-warning btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>

                </div>
                </form>
        </div>
        </div>
        </div>
        </div>
</div>
</section>
</div>
<script>
        function toggleCheckbox(checkbox) {
        if (checkbox.checked) {
                document.querySelectorAll('.permission-checkbox').forEach(function (element) {
                if (element !== checkbox) {
                        element.checked = false;
                }
                });
        }
        }
</script>

=======
                            <a href="{{ url('/admin/roles') }}"
                                class="btn btn-warning btn-sm">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>

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
>>>>>>> main
@endsection