@extends('layouts.adminFrontend')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Token types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Types</a></li>
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



                        <form action="{{ url('/admin/create/token-type')}}" method="post" class="form-horizontal">
                            @csrf
                            
                            <div class="form-group row">
                                
                                <label for="inputName" class="col-sm-1 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                    <input type="text" class="form-control" name="name" value=""
                                        placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-1 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
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
<<<<<<< HEAD
                            <tr>
=======
                              <tr>
>>>>>>> main
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $count = 1 @endphp
                                @foreach($data as $d)
                            <tr>
                                <th scope="row">{{$count}}</th>
                                <td>{{ $d->name }}</td>
                                <td>
                                    <button class="btn btn-outline-danger btn-xs del-button" data-value="{{ $d->id }}" >Delete</button>
                                </td>
                                @php $count++ @endphp
                            </tr>
                            @endforeach
                            </tbody>
<<<<<<< HEAD
                        </table>
=======
                          </table>
>>>>>>> main
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


    $("#tokenTree").addClass('menu-open');
    $("#tokenMenu").addClass('active');
    $("#SubMenuTokenType").addClass('active');


    $('#del_id').val('');
            $('.del-button').on('click',function(){
                
                var data = $(this).data('value');
                console.log(data);
                $('#del_id').val(data);
                $('#modal-delete').modal('show');
            });


});
</script>

@endsection