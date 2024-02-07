@extends('frontend.template.main')

@section('main-container')

    <div class="content-wrapper remove-background">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-light"> Welcome, <small>{{ session('name') }}</small></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                        {{ $razorPay['id'] }}

                        <button id="rzp-button1" class="btn btn-secondary">Pay Now</button>
                        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                        <script>
                            var options = {
                                "key": "{{ getenv('RAZORPAY_KEY_ID')}}",
                                "amount": "{{ $razorPay['amount'] }}",
                                "currency": "INR",
                                "name": "PRIVATECH",
                                "description": "Test Transaction",
                                "image": "{{ asset('assets/frontend/images/web-logo.png') }}",
                                "order_id": "{{ $razorPay['id'] }}",
                                "callback_url": "{{ url('/razorpay/success') }}",
                                "prefill": {
                                    "name": "{{ session('name') }}",
                                    "email": "{{ session('email') }}",
                                    "contact": "{{ session('contact') }}"
                                },
                                "notes": {
                                    "address": "Privatech Garden LLP"
                                },
                                "theme": {
                                    "color": "#3399cc"
                                }
                            };
                            var rzp1 = new Razorpay(options);
                            document.getElementById('rzp-button1').onclick = function(e) {
                                rzp1.open();
                                e.preventDefault();
                            }
                        </script>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>



@endsection