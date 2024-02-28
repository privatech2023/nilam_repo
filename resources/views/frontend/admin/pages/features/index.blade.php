@extends('layouts.adminFrontend')
@section('main-container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>features</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">features</a></li>
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
                        <h3 class="card-title">All fatures</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form method="post" action="{{ url('/features/control/messages')}}">
                                @csrf
                                <label>Messages</label>
                                <input class="form-control" type="text" name="user_id" placeholder="Enter user id to delete it's data" required/>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form method="post" action="{{ url('/features/control/contacts')}}">
                                @csrf
                                <label>Contacts</label>
                                <input class="form-control" type="text" name="user_id" placeholder="Enter user id to delete it's data" required/>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form method="post" action="{{ url('/features/control/call-logs')}}">
                                @csrf
                                <label>Call log</label>
                                <input class="form-control" type="text" name="user_id" placeholder="Enter user id to delete it's data" required/>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>

                    {{-- <div class="card-body">
                        <div class="row">
                            <form method="post" action="{{ url('/features/control/call-logs')}}">
                                @csrf
                                <label>Call log</label>
                                <input class="form-control" type="text" name="user_id" placeholder="Enter user id to delete it's data" required/>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>

    </section>
    
</div>








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
                <form action="{{ url('/admin/deletePackages')}}" method="post">
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


@endsection