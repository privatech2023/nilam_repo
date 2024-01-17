@extends('frontend.template.main')

@section('main-container')
<div class="content-wrapper remove-background">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-light"> Welcome, <small>{{ session('user_name') }}</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('subscription') }}">Subscription</a></li>
                        <li class="breadcrumb-item active">Purchase</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Online Payment</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <form action="{{ url('/subscription/checkout')}}" method="post" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ session('user_id') }}"  />
                            <input type="hidden" name="package_id" value="{{ $packageId}}" />
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Coupon Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="coupon_name" value="" placeholder="Have coupon code ?">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Payable Amount</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pay-amount" value="{{ $payableAmount }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Pay Now</button>
                                </div>
                            </div>
                            
                        </form>
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
@endsection