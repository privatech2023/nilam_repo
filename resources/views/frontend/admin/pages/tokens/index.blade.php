@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Issue tokens</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Tokens</a></li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card">

            <div class="card-header">
                <span><a href="{{ url('/admin')}}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>

                    <div class="card-tools">
               
                            <a href="{{ url('/admin/add-token')}}" class="btn btn-block btn-success btn-sm">Add Token</a>
                    </div>
                </div>
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Device Id</th>
                <th scope="col">Client</th>
                <th scope="col">Description</th>
                <th scope="col">Start date</th>
                <th scope="col">End date</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
                @php $count = 1 @endphp
                @foreach($data as $d)
            <tr>
                <th scope="row">{{$count}}</th>
                <td>
                    @foreach($type as $t)
                    {{ $d->issue_type == $t->id ? $t->name : ''}}
                    @endforeach
                </td>
                <td>{{ $d->device_id }}</td>
                <td>
                    @foreach($client as $cl)
                    {{ $d->client_id == $cl->client_id ? $cl->name : ''}}
                    @endforeach
                </td>
                <td>{{ $d->detail }}</td>
                <td>{{ $d->start_date }}</td>
                <td>
                    @if($d->end_date == null)
                    <span class="badge badge-warning">Not allotted</span>
                    @else
                    {{ $d->end_ }}
                    {{ $d->end_date }}
                    @endif
                </td>
                <td> @if($d->status == 0)
                    <span class="badge badge-warning">Pending</span>
                    @else
                    <span class="badge badge-success">Solved</span>
                    @endif
                    <button class="btn btn-outline-info btn-xs view-btn" data-value="{{ $d->id }}">VIEW</button>
                    <button class="btn btn-outline-danger btn-xs del-button" data-value="{{ $d->id }}" >Del</button>
                </td>
                @php $count++ @endphp
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </section>
</div>

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
                <p>Are You sure to <strong>Delete</strong> the token<strong><span id="delName"></span></strong>
                    ?</p>
                <form action="{{url('/admin/delete/token')}}" method="post" style="margin-top: 4px;">
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


{{-- view modal --}}
<div class="modal fade" id="modal-view">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Token</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/admin/token/update')}}" method="post" style="margin-top: 4px;">
                    @csrf
                    <div class="container view-token-detail">
                        <input type="hidden" name="token_id" id="token_id" value="">

                        <div class="form-group row">
                            <label for="type">Type</label>
                            <input class="form-control" id="type" name="type" type="text" value="" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="mobile_number">Contact number</label>
                            <input class="form-control" id="mobile_number" name="mobile_number" type="text" value="">
                        </div>
                        <div class="form-group row">
                            <label for="device_id">Device</label>
                            <input class="form-control" id="device_id" name="device_id" type="text" value="" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="start_date">Start date</label>
                            <input class="form-control" id="start_date" name="start_date" type="date" value="" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="end_date">End date</label>
                            <input class="form-control" id="end_date" name="end_date" type="date" value="">
                        </div>
                        <div class="form-group row">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" >
                                <option value="" selected>Select</option>
                                <option value="1">Success</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-outline-success">Update</button>
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
        $('.view-btn').on('click', function(){
            var data = $(this).data('value');
                $('#view_id').val(data);
                $.ajax({
                    type: "post",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/token/get/"+data,
                    dataType: "json",
                    success: function (response) {
   
                        $('#token_id').val(data);
                        $('#type').val(response.type.name);
                        $('#mobile_number').val(response.data.mobile_number);
                        $('#device_id').val(response.device_name.device_name);
                        $('#start_date').val(response.data.start_date);
                        $('#end_date').val(response.data.end_date);
                        $('select[name="status"]').val(response.data.status);
                        $('#modal-view').modal('show');
                    }
                });
        });

        $('.del-button').on('click', function(){
            var data = $(this).data('value');
            console.log(data)
                $('#del_id').val(data);
                $('#modal-delete').modal('show');
        });
    });
</script>
@endsection