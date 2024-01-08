@extends('frontend.template.main')

@section('main-container')

<div class="content-wrapper remove-background">

    <!-- Main content -->
    <div class="content">
        <div class="d-flex align-items-start justify-content-center vh-100">
            
            <div style="width: 550px;">
                <div class="bg-gray-light">
                    <div class="d-flex justify-content-center">
                        <h4 class="text-secondary text-md" style="margin-top: 1.5rem;">Login at</h4>
                    </div>
                    <div class="modal-body">
                        <div class="loader_bg" style="display:none;">
                            <div id="loader"></div>
                        </div>
            
                        <!-- Check User Form -->
                        <div id="step-user">
                            <span id="message"></span>
                            <form action="{{ url('login_otp/client')}}" method="post" autocomplete="off">
                                @csrf
                            <div class="container text-center">
                                @if (session()->has('user_data'))
                                    <span class="text-primary">{{ session('user_data') }}</span>
                                @endif
                                <div class="input-group mb-3 mt-3">
                                    <input type="text" name="user_data" id="user" class="form-control" value="{{ session('user_data')}}" disabled>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('error'))
                                    <span class="text-danger">{{ $errors->first('error')  }}</span>
                                @endif
                                <div class="input-group mb-3 mt-3">
                                    <input type="number" name="otp" class="form-control" placeholder="OTP">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 d-flex justify-content-start">
                                        <span id="timerContainer">
                                            <span class="lead text-md">Resend OTP after </span><span id="timer" class="lead text-md">60</span> <span class="lead text-md">seconds...</span>
                                        </span>
                                        <a href="{{ url('get_otp/client')}}" id="resendLink" style="display: none;">Resend OTP</a>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-block btn-sm" style="height: 32px;">Login</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-block btn-sm col-3">Cancel</a>
                                </div>

                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            
            

        </div>
        
    </div>



</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        startTimer();
    });

    function startTimer() {
        let timerElement = document.getElementById('timer');
        let resendLink = document.getElementById('resendLink');
        let time = 60; 

        let countdown = setInterval(function () {
            time--;
            timerElement.innerText = time;

            if (time <= 0) {
                clearInterval(countdown);
                document.getElementById('timerContainer').style.display = 'none';
                resendLink.style.display = 'inline'; // Show resend link after timer reaches zero
            }
        }, 1000);
    }
</script>


@endsection