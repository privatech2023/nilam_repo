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
                    <div class="card-header">
                        <span><a href="" class="btn btn-outline-info btn-sm"><i
                            class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">                       
                            <div class="form-group row">                                
                                <label for="inputName" class="col-sm-1 col-form-label">Upline</label>
                                <select class="form-control col-6" name="role" required value="" id="upline_role">
                                    <option value="" selected>Select</option>
                                    @foreach($data as $group)
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-1 col-form-label">Downline</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Role
                                    </label>
                                </div>
                                <div class="form-check" style="margin-left: 10px;">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Users
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-1 col-form-label">Commission amount</label>
                                    <input class="form-control col-6" type="text" name="amount" id="amount" placeholder="Commission amount">
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-1 col-sm-10">
                                    <button type="button" id="add" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Upline name</th>
                                <th scope="col">Commission amount</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Downline</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $count = 1 @endphp
                                @foreach($upline as $d)
                            <tr>
                                <th scope="row">{{$count}}</th>
                                <td>{{ $d->upline_group_name }}</td>
                                <td>&#8377; {{ $d->amount }}</td>
                                <td>{{ $d->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($d->role == null)
                                        {{ count(unserialize($d->users)) }} Users
                                    @else
                                        1 role
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/view-upline/' . $d->id) }}"><button class="btn btn-outline-primary btn-xs" data-value="{{ $d->id }}" >VIEW</button></a>
                                    {{-- <a href="#"><button class="btn btn-outline-danger btn-xs del-button" data-value="{{ $d->id }}" >DEL</button></a> --}}
                                </td>
                                @php $count++ @endphp
                            </tr>
                            @endforeach
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

{{-- delete modal --}}
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Delete Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are You sure to <strong>Delete</strong> the type <strong><span id="delName"></span></strong>
                    ?</p>
                    <span class="text-sm text-danger">All related tokens of this type will be deleted</span>
                <form action="{{url('/admin/delete/token-type')}}" method="post" style="margin-top: 4px;">
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

{{-- role modal --}}
<div class="modal" id="roleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Downline role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body role">
            <label for="inputName" class="col-form-label">Select role</label>
            <select class="form-control col-6" name="role" required id="role">
                <option value="" selected>Select</option>
                @foreach($data as $group)
                <option value="{{$group->id}}">{{$group->group_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Save </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

{{-- users modal --}}
<div class="modal" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Select user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body user">
        <p class="lead">USER LIST</p><br><hr>
        @foreach($user as $u)
        <label>{{$u->name}} </label>
        <input type="checkbox" name="user[]" id="user" value="{{$u->id}}"><br><hr>  
        @endforeach
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
$(document).ready(function() {
    $("#employeeTree").addClass('menu-open');
    $("#employeeMenu").addClass('active');
    $("#employeeSubMenuUpline").addClass('active');

    $('#del_id').val('');
            $('.del-button').on('click',function(){
                var data = $(this).data('value');
                console.log(data);
                $('#del_id').val(data);
                $('#modal-delete').modal('show');
            });


    ////////////////////////////////////
    $(document).on('click','#flexRadioDefault1', function () {
        $('#roleModal').modal('show');
        uncheckAllCheckboxes('.user');
    });

    $(document).on('click','#flexRadioDefault2', function () {
        $('#userModal').modal('show');
        $('#role').val('');
    });

    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add').on('click', function () {
        var checkedValues = [];
        $('.user input[type=checkbox]').each(function(){
            if($(this).is(':checked')){
                checkedValues.push($(this).val());
            }
        });

        var amount = $('#amount').val();
        var downline_role = $('#role').val();

        var upline = $('#upline_role').val();
        if(upline == ''){
            alert('please select upline')
        }
        else if(checkedValues.length == 0 && downline_role == ''){
            alert('please select downline')
        }
        else if(downline_role == upline){
            alert('upline and downline role cannot be same')
        }
        else if(amount == ''){
            alert('Please set the commission amount')
        }
        else{
        $.ajax({
        type: "post",
        url: "/admin/upline/create",
        data: {
        'upline_role': upline,
        'role': downline_role,
        'users': checkedValues.length == 0 ? null : checkedValues,
        'amount': amount
        },
        dataType: "json",
        success: function (response) {
            $('#role').val('');
            uncheckAllCheckboxes('.user');
            $('#upline_role').val('');
            alert('Done');
            window.location.reload();
        }
    });
        }
    });


    // uncheck
    function uncheckAllCheckboxes(containerId) {
    $(containerId + ' input[type=checkbox]').prop('checked', false);
    }

});
</script>

@endsection