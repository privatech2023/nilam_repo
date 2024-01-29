@extends('frontend.template.main')

@section('main-container')
<div class="content-wrapper remove-background">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-light"> Welcome, <small>{{ session('user_name') }}</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Subscription</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    
    <div class="content" style="margin-top:2rem;">
        <div class="container">

            @if($data->isEmpty())
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0">Issues</h5>

                            <div class="card-tools">
                                <button id="raise_issue" class="btn btn-block btn-info btn-sm">Raise issue token</button>
                            </div>

                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted"> No issues found</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- Row -->

                        </div>
                    </div>
                </div>

            </div>
            @else

            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0">Issues</h5>

                            <div class="card-tools">
                                <button id="raise_issue"  class="btn btn-block btn-info btn-sm">Raise issue token</button>
                            </div>

                        </div>
                        <div class="card-body" >
                            <div class="row" >
                                <div  class="table-responsive">
                                        <table class="table table-striped table-light" style="font-size: 16px; ">
                                            <thead>
                                            <tr>
                                                <th scope="col">Type</th>
                                                <th scope="col">Contact number</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Start date</th>
                                                <th scope="col">End date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $issue)
                                            <tr>
                                                <th scope="row">
                                                    @foreach($type as $t)
                                                    {{ $issue->issue_type == $t->id ? $t->name : ''}}
                                                    @endforeach
                                                </th>
                                                <td>{{ $issue->mobile_number}}</td>
                                                <td>{{ $issue->detail}}</td>
                                                <td>
                                                    @if($issue->status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                    @else
                                                    <span class="badge badge-success">Solved</span>
                                                    @endif
                                                </td>
                                                <td>{{$issue->start_date}}</td>
                                                <td>
                                                    @if($issue->end_date == null)
                                                    <span class="badge badge-warning">Not allotted</span>
                                                    @else
                                                    <span class="badge badge-success">{{$issue->end_date}}</span>
                                                    @endif
                                                </td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>


{{-- modal --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Raise issue token</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ url('raise-issue')}}">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Issue type</label>
                  <select name="type" class="form-control" id="exampleFormControlSelect1" required>
                    <option selected>Select issue</option>
                    @foreach($type as $t)
                    <option value="{{ $t->id}}">{{$t->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="contact">Contact number</label>
                    <input type="number" name="mobile_number" class="form-control"  required />
                  </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Description</label>
                  <textarea name="detail" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
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
        $('#raise_issue').on('click', function(){
            $('#exampleModalCenter').modal('show');
        })
    });
</script>
@endsection