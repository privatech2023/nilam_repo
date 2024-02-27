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
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('subscription') }}">Subscription</a></li>
                    <li class="breadcrumb-item active">Packages</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Packages</h5>
                    </div>
                    <div class="card-body">
                        <div class="card card-solid">
                            <div class="card-body pb-0">
                                <div class="row">

                                    @foreach($packages as $list)
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header elevation-2 lead border-bottom-0">
                                                    <b>{{ $list['name'] }}</b>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row" onclick="runScript({{$list['id']}}, {{ session('user_id')}}, {{$list['price']}} )">
                                                        <div class="col-12">
                                                            <div class="bg-info py-2 px-3 mt-4">
                                                                <h2 class="mb-0">
                                                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                                                    {{ $list['price'] }} /-
                                                                </h2>
                                                                <h4 class="mt-1">
                                                                    <small>
                                                                        <i class="fa-regular fa-calendar"></i>:
                                                                        {{ $list['duration_in_days'] }} days
                                                                    </small>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-center">
                                                        <button 
                                                            class="btn btn-sm btn-primary" data-id="{{$list['id']}}" onclick="runScript({{$list['id']}}, {{ session('user_id')}}, {{$list['price']}} )">
                                                            <i class="fa-solid fa-cart-shopping"></i> Buy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" id="activation_btn" class="btn btn-primary" style="width:100%;">I have an ctivation code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
    .modal-dialog {
   position:fixed;
   top:auto;
   right:40%;
   left:40%;
   bottom:0;
}  

@media (max-width: 480px) {
    .modal-dialog {
    right: auto;
    left: auto;
}
}
</style>
{{-- activation modal --}}
<div class="modal fade" id="activation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-sm" role="document">
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
            <input type="hidden" name="package_id" value=""  />

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
            </div>
          
        </div>
        <input type="hidden" class="form-control" name="total_amount" value="">
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function runScript(package_id ,user_id, pay_amount){
        var url = "{{ route('razorpay.payment.success')}}"
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

        var data = {
        package_id: package_id,
        user_id: user_id,
        pay_amount: pay_amount
        };
        $.ajax({
            type: "post",
            url: '/subscription/checkout',
            data: data,
            dataType: "json",
            success: function (response) {
                var options = {
                                "key": response.key,
                                "amount": response.amount,
                                "currency": "INR",
                                "name": "PRIVATECH",
                                "description": "Test Transaction",
                                "image": "{{ asset('assets/frontend/images/web-logo.png') }}",
                                "order_id": response.id,
                                "handler": function (response) {
                                    window.location.href = url + 
                                    '?razorpay_payment_id=' + response.razorpay_payment_id + 
                                    '&razorpay_order_id=' + response.razorpay_order_id +
                                    '&razorpay_signature=' + response.razorpay_signature;
                                },
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
                            rzp1.open();
            }
        });
        }

        
</script>
<script>
    $(document).ready(function () {
        $(document).on('click','#activation_btn', function () {
            $('#activation-modal').modal('show');
        });
    });
</script>
@endsection
