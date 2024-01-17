@extends('frontend.template.main')

@section('main-container')
<div class="content-wrapper remove-background">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-light"> Welcome, <small>{{ session('user_name') }}</small></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('subscription') }}">Subscription</a></li>
                    <li class="breadcrumb-item active">Purchase</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Purchase Validity package</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>{{ $package['name'] }}</strong>
                                </p>
                                <div class="row m-auto">
                                    <div class="col-sm-6 col-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-success">
                                                <h5 class="description-header">{{ $package['price'] }}</h5>
                                                <span class="description-text">Package Amount</span>
                                            </span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6 col-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-warning">
                                                <h5 class="description-header">{{ $package['duration_in_days'] . ' days' }}</h5>
                                                <span class="description-text">Validity</span>
                                            </span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col -->

                            <div class="form-horizontal col-7">
                                <div class="form-group row">
                                    <form action="{{ url('/onlinePayment')}}" class="offset-sm-2 form-horizontal col-10" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $package['id']}}" name="package-id"/>
                                        <input type="hidden" value="{{ $package['price'] }}" name="payable-amount"/>
                                        <button type="submit" class="btn btn-danger" style="width:100%;">Online payment</button>                                
                                    </form>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-10">
                                        <button type="button" id="activation_btn" class="btn btn-primary" style="width:100%;">Activation code</button>
                                    </div>
                                </div>
                            </div>
                            
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->

                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
</div>



{{-- activation modal --}}
<div class="modal fade" id="activation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Activation Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('subscription/pay') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ session('user_id') }}"  />
            <input type="hidden" name="package_id" value="{{ $package['id']}}"  />

            <div class="card-body">
                <div class="row">  
                    <div class="col-10">
                        <div class="form-group">
                            <label for="name">Code Name *</label>
                            <input type="text" class="form-control" name="code_name"
                                placeholder="Activation Code" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-10">
                        <div class="form-group ">
                            <label for="exampleInputPassword1">Total amount</label>
                            <input type="number" class="form-control" name="total_amount" value="{{ $package['price']}}"
                            min="0" autocomplete="off" readonly>
                        </div>
                    </div>
                </div> --}}
            </div>
          
        </div>
        <input type="hidden" class="form-control" name="total_amount" value="{{ $package['price']}}">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
      </div>
    </div>
  </div>



  @if(session()->has('success'))
  <script type="text/javascript">
      toastr.success('{{session('success')}}');
  </script>
  @php
      session()->forget('success');
  @endphp
@endif

@if(session()->has('error'))
  <script type="text/javascript">
      toastr.warning('{{session('error')}}');
  </script>
  @php
      session()->forget('error');
  @endphp
@endif

<script>
    $(document).ready(function () {
        $(document).on('click','#activation_btn', function () {
            $('#activation-modal').modal('show');
        });
    });
</script>
@endsection