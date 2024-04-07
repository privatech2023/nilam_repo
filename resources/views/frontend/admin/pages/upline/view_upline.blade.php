@extends('layouts.adminFrontend')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Upline</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Upline</a></li>
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
                    <div class="card-body">
                        <table class="table table-dark" style="border-radius: 5px;">
                            <thead>
                            <tr>
                                <th scope="col">Upline name</th>
                                <th scope="col">Downline</th>
                                <th scope="col">Commission amount</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($is_role == true)
                            @foreach($downline_role as $d)
                            <tr>
                                <td>{{ $d['upline'] }}</td>
                                <td>{{ $d['data'] }}    <p class="lead text-sm">(ROLE)</p></td>
                                <td>&#8377; {{ $d['amount']}}</td>
                                <td><button class="btn-outline btn-danger btn-sm" data-value={{ $d['group_id']}} id="del-role-btn">DEL</button></td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($downline_users as $d)
                            <tr>
                                <td>{{ $d['upline'] }}</td>
                                <td>{{ $d['user'] }} <p class="lead text-sm">(USER)</p></td>
                                <td>&#8377; {{ $d['amount']}}</td>
                                <td><button class="btn-outline btn-danger btn-sm" data-value={{ $d['user_id']}} data-group={{ $d['group_id']}} id="del-user-btn">DEL</button></td>
                            </tr>
                            @endforeach
                            @endif
                            
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


{{-- delete user modal --}}
<div class="modal fade" id="modal-delete-user">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Downline User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> this downline user <strong><span id="delName"></span></strong>
                    ?</p>
                <form action="{{url('/admin/upline/delete-user')}}" method="post" style="margin-top: 4px;">
                    @csrf
                    <input type="hidden" name="user_id" id="user_del_id" value="">
                    <input type="hidden" name="group_id" id="group_del_id" value="">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-outline-success">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- delete role modal --}}
<div class="modal fade" id="modal-delete-role">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Downline Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> this downline role <strong><span id="delName"></span></strong>
                    ?</p>
                <form action="{{url('/admin/upline/delete-role')}}" method="post" style="margin-top: 4px;">
                    @csrf
                    <input type="hidden" name="group_id" id="del_id" value="">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-outline-success">Confirm</button>
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
    $(document).ready(function () {

        // delete user
        $(document).on('click','#del-user-btn', function () {
            var user_id = $(this).data('value');
            var group_id = $(this).data('group');
            $('#user_del_id').val(user_id);
            $('#group_del_id').val(group_id)
            console.log("User ID: " + user_id);
            console.log("Group ID: " + group_id);
            $('#modal-delete-user').modal('show');
        });

        // delete role
        $(document).on('click','#del-role-btn', function () {
            var group_id = $(this).data('value');
            $('#del_id').val(group_id);
            $('#modal-delete-role').modal('show');
        });
    });
</script>


@endsection