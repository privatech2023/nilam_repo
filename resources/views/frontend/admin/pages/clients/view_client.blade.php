@extends('layouts.adminFrontend')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        <a href="{{url('/admin')}}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-long-arrow-alt-left mr-1"></i>Back
                        </a>
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Clients</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{url('assets/common/img/default_user.png')}}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ empty($client_data['name']) ? "" : $client_data['name'] }}</h3>


                <p class="text-muted text-center"></p>
                <p class="text-muted text-center"></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b><i class="fa-solid fa-mobile-screen-button"></i></b> <span class="float-right">{{ empty($client_data['mobile_number']) ? "" : $client_data['mobile_number'] }}</span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fa-solid fa-envelope"></i></b> <span class="float-right">{{ empty($client_data['email']) ? "" : $client_data['email'] }}</span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fa-solid fa-receipt"></i></b> <span class="float-right"></span>
                    </li>
                    <li class="list-group-item">
                        <b><i class="fa-regular fa-hard-drive"></i></b> <span class="float-right">Free Plan</span>
                    </li>
                </ul>                

                <a href="#" class="btn btn-primary btn-block btn-sm"><b>Instant Subscription</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

 
          </div>
          <!-- /.col -->



          <div class="col-md-9">
            <div class="card">

              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#transactions" data-toggle="tab">Transactions</a></li>
                  <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#subscription" data-toggle="tab">Subscription</a></li>
                  <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                </ul>
              </div><!-- /.card-header -->

              <div class="card-body">

                <div class="tab-content">


                <div class="active tab-pane" id="transactions">


                  <table id="example1"  class="table table-sm table-striped">
                  <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 20%">Txn ID</th>
                        <th style="width: 15%">Date</th>                                     
                        <th style="width: 15%">Amount</th>
                        <th style="width: 10%">Mode</th>
                        <th style="width: 00%">Type</th>
                        <th style="width: 10%">Validity</th>
                        <th style="width: 10%">Status</th>
                    </tr>
                  </thead>
                  <tbody>          
                      
                      
                
                  </tbody>
                 </table>

   
                </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="profile">

                    <form action="{{ url('/admin/client/update')}}" method="post" class="form-horizontal" autocomplete="off">
                      @csrf
                      <input type="hidden" name="row_id" value="{{ $client_id }}">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ empty($client_data['name']) ? "" : $client_data['name']}}" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" value="{{ empty($client_data['email']) ? "" : $client_data['email']}}" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" name="mobile" value="{{ empty($client_data['mobile_number']) ? "" : $client_data['mobile_number']}}" placeholder="10 digit mobile no">
                        </div>
                    </div>              

            
                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="" selected>Select</option>
                            <option value="1" {{ $client_data['status']=='1'?'selected':'' }} >Active</option>
                            <option value="2" {{ $client_data['status']=='2'?'selected':'' }}  >Disabled</option>
                        </select>                                      
                        </div>
                      </div> 

                     <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                      </div>
                    </form>


                  </div>

                  <div class="tab-pane" id="subscription">


                    <form action="#" method="post" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="row_id" value="{{ $client_id }}">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Started At</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="started_at" value="#" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Ends On</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="ends_on" value="#" />
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="inputName2" class="col-sm-2 col-form-label">Validity (in days)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="validity_days" value="#" />
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">
                                    <option value="" selected>Select</option>
                                    <option value="1" >Active</option>
                                    <option value="2" >Disabled</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </div>
                    </form>
                    


                  </div>


                  <div class="tab-pane" id="password">


                    <form action="{{ url('admin/clients/updatePassword') }}" method="post" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="row_id" value="{{ $client_id }}">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="confirm_password" />
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </div>
                    </form>                    


                  </div>


                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->






</div><!-- .content wraper -->

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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
        "aaSorting": [],
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script> 


@endsection