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

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Discount Coupons</strong>
                                </p>
                                <form action="#" method="post" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ session('user_id') }}"  />
                                    <input type="hidden" name="package_id" value="{{ $package['id']}}"  />
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Coupon Code</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="coupon_name" value="" placeholder="Have coupon code ?">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Payable Amount</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="pay-amount" value="{{ $package['price'] }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Pay Now</button>
                                        </div>
                                    </div>
                                    
                                </form>
                                <div class="row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="button" id="activation_btn" class="btn btn-primary">Activation code</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                                    <h5 class="description-header">$35,210.43</h5>
                                    <span class="description-text">TOTAL REVENUE</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                    <h5 class="description-header">$10,390.90</h5>
                                    <span class="description-text">TOTAL COST</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                    <h5 class="description-header">$24,813.53</h5>
                                    <span class="description-text">TOTAL PROFIT</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                    <h5 class="description-header">1200</h5>
                                    <span class="description-text">GOAL COMPLETIONS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
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
                    <div class="col-sm-6">
                        <div class="form-group input-group-sm">
                            <label for="name">Code Name *</label>
                            <input type="text" class="form-control" name="code_name"
                                placeholder="Activation Code" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group input-group-sm">
                            <label for="exampleInputPassword1">Total amount</label>
                            <input type="number" class="form-control" name="total_amount" value="{{ $package['price']}}"
                            min="0" autocomplete="off" readonly>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">SUBMIT</button>
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
        $(document).on('click','#activation_btn', function () {
            $('#activation-modal').modal('show');
        });
    });
</script>
@endsection