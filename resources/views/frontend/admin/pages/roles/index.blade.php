@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper" style="min-height: 502.4px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Roles</h1>
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
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <span>
                                <a href="{{ url('/admin')}}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a>
                            </span>

                            <div class="card-tools">
                                @if(in_array('createRole', session('user_permissions')) || session('admin_name') == 'admin')
                                <a href="{{ url('/admin/create-roles')}}" class="btn btn-block btn-success btn-sm">Create Roles</a>
                                @else
                                <a href="{{ url('/admin/create-roles')}}" class="btn btn-block btn-success btn-sm disabled" >Create Roles</a>
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
                                                        aria-label="Action: activate to sort column ascending"
                                                        style="width: 404.462px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $role)
                                                @if($role->id != 1)
                                                <tr style="text-align:center;" role="row">
                                                <td class="text-center sorting_1">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $role->group_name }}</td>
                                                <td style="text-align:center;">
                                                    @if(in_array('editRole', session('user_permissions'))  || session('admin_name') == 'admin')
                                                <a href="{{ url('/admin/roles/update/' . $role->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                                </a>
                                                @else
                                                <a href="{{ url('/admin/roles/update/' . $role->id) }}" class="btn btn-warning btn-sm disabled">
                                                    <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif

                                                @if(in_array('deleteRole', session('user_permissions')) || session('admin_name') == 'admin')
                                                <button type="button" data-value="{{ $role->id }}" class="btn btn-danger btn-sm delete-btn" >
                                                <i class="fa fa-trash"></i>
                                                </button>
                                                @else
                                                <button type="button" data-value="{{ $role->id }}" class="btn btn-danger btn-sm delete-btn" disabled>
                                                    <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                                </td>
                                                </tr>
                                                @endif
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



{{-- @php
    $session = session();
@endphp

<script type="text/javascript">
    @if($session->get('success'))
        toastr.success('{{ $session->get('success') }}')
    @elseif($session->get('error'))
        toastr.warning('{!! implode("<br>", $session->get('error')) !!}');
    @endif
</script> --}}


    <script>
        $(document).ready(function () {
            $("#employeeTree").addClass('menu-open');
            $("#employeeMenu").addClass('active');
            $("#employeeSubMenuRoles").addClass('active');

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
