@extends('frontend.template.main')

@section('main-container')

<div class="content-wrapper remove-background">

    <!-- Main content -->
    <div class="content">
        <div class="d-flex align-items-start justify-content-center vh-100">
            
            <div style="width: 550px;">
                <div class="bg-gray-light">
                    <div class="d-flex justify-content-center">
                        <h4 class="text-secondary text-md" style="margin-top: 1.5rem;">Login using</h4>
                    </div>
                    <div class="modal-body">
                        <div class="loader_bg" style="display:none;">
                            <div id="loader"></div>
                        </div>
            
                        <!-- Check User Form -->
                        <div id="step-user">
                            <span id="message"></span>
            
                            <div class="container text-center">
                                @if (session()->has('user_data'))
                                    <span class="text-primary">{{ session('user_data') }}</span>
                                @endif
                                <div class="border p-3 mt-3 d-flex justify-content-between align-items-stretch">
                                    <a href="{{ url('login_password/client') }}" class="btn btn-outline-primary btn-block btn-sm mr-2 col-5">Password</a>
                                    <div class="border-left mx-2"></div>
                                    <a href="{{ url('get_otp/client') }}" class="btn btn-outline-secondary btn-block btn-sm mr-2 col-5">OTP</a>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-block btn-sm col-3">Cancel</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            
            

        </div>
        
    </div>



</div>



















@endsection