@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper" style="min-height: 502.4px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Commission</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">Commission</li>
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
                            <span>
                                <a href="{{ url('/admin')}}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a>
                            </span>
                            <div class="card-tools">
                                @if(session('admin_name') == 'admin')
                                <a href="{{ url('/admin/distributeClients')}}"><button class="btn-danger btn-sm" style="margin-bottom:1px;">Distribute client</button></a>
                                <a href="{{ url('/admin/users-earnings')}}"><button class="btn-primary btn-sm" style="margin-bottom:1px;">User earnings</button></a>
                                <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal"
                                data-target="#modal-add">Create commission</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">                                  
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="dataTable_length">
                                            <label>Show
                                                <select name="dataTable_length" aria-controls="dataTable"
                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> 
                                                entries
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 text-right">
                                        <div id="dataTable_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" class="form-control form-control-sm" placeholder=""
                                                    aria-controls="dataTable">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="dataTable"
                                            class="table table-sm table-bordered table-striped table-hover dataTable no-footer"
                                            role="grid" aria-describedby="dataTable_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="text-center sorting_asc" rowspan="1" colspan="1"
                                                        aria-label="#" style="width: 171.25px;">#</th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Role Name: activate to sort column ascending"
                                                        style="width: 559.888px;">Role Name</th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Role Name: activate to sort column ascending"
                                                        style="width: 559.888px;">Commission</th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Role Name: activate to sort column ascending"
                                                        style="width: 559.888px;">Created at</th>
                                                    <th class="text-center sorting" tabindex="0" aria-controls="dataTable"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending"
                                                        style="width: 404.462px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ( $commissions as $com)
                                                <tr style="text-align:center;" role="row">
                                                <td class="text-center sorting_1">{{ $i  }}</td>
                                                <td class="text-center">{{ $com->group_name }}</td>
                                                <td class="text-center">{{ $com->commission != 0  ? $com->commission : 'NOT SET' }}</td>
                                                <td class="text-center">{{ $com->created_at  }}</td>
                                                <td style="text-align:center;">
                                                @if(session('admin_name') == 'admin')
                                                <button type="button" data-value="{{ $com->group_id }}" class="btn btn-danger btn-sm delete-btn" >
                                                <i class="fa fa-trash"></i>
                                                </button>
                                                @else
                                                <button type="button" data-value="{{ $com->group_id }}" class="btn btn-danger btn-sm delete-btn" disabled>
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                                </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="dataTable_info" role="status"
                                            aria-live="polite">Showing 1 to 1 of 1 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers float-right"
                                            id="dataTable_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                            id="dataTable_previous"><a href="#" aria-controls="dataTable"
                                                        data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                                <li class="paginate_button page-item active"><a href="#"
                                                        aria-controls="dataTable" data-dt-idx="1" tabindex="0"
                                                        class="page-link">1</a></li>
                                                <li class="paginate_button page-item next disabled"
                                                    id="dataTable_next"><a href="#" aria-controls="dataTable"
                                                        data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- Delete Modal -->
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <p>Are You sure to <strong>Delete</strong> the Role <strong><span id="delName"></span></strong>
                            ?</p>
                        <form action="{{url('/admin/delete-roles')}}" method="post">
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
    </div>
   


    {{-- add modal --}}
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create commission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form start -->
                    <form role="form" action="{{ url('/admin/createCommission')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <div class="form-group input-group-sm">
                                            <label>Role</label>
                                            <select class="form-control" name="role" required>
                                                @foreach($groups as $c)
                                                <option value={{$c->id}}>{{$c->group_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <label for="exampleInputPassword1">Commission amount</label>
                                        <input type="number" class="form-control" name="amount"
                                            placeholder="Amount" min="0" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm swalDefaultSuccess">CREATE</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
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
            $("#employeeTree").addClass('menu-open');
            $("#employeeMenu").addClass('active');
            $("#employeeSubMenuCommissions").addClass('active');

            $('#del_id').val('');
            $('.delete-btn').on('click',function(){
                $data = $(this).data('value');
                $('#del_id').val($data);
                $('#modal-delete').modal('show');
                console.log($data);
            });
        });
    </script>
    

@endsection
