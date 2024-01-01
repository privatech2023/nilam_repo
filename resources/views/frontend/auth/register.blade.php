@extends('frontend.template.main')

@section('main-container')

<div class="content-wrapper remove-background">
    <!-- Main content -->
    <div class="content">
        <div class="d-flex align-items-start justify-content-center vh-100">

            <div style="width: 550px; ">
                <div class="bg-gray-light">

                    <div class="d-flex justify-content-center">
                        <h4 class="text-secondary text-md" style="margin-top: 1.5rem;">Register a new membership</h4>
                    </div>

                    <div class="modal-body">
                        <div class="loader_bg" style="display:none;">
                            <div id="loader"></div>
                        </div>

                        <!-- Check User Form -->
                        <div id="step-user">
                            <span id="message"></span>

                            <form method="post" id="userForm" action="{{ url('register/client')}}">
                                @csrf

                                <!-- Username Field -->
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="text" name="name" id="user" class="form-control" placeholder="Full name">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Field -->
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                <div class="input-group mb-3">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Mobile Number Field -->
                                @if ($errors->has('mobile_number'))
                                    <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                    @endif
                                <div class="input-group mb-3">
                                    <input type="number" name="mobile_number" id="mobile_number" class="form-control" placeholder="Mobile number">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-mobile-alt"></span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Password Field -->
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Confirm Password Field -->
                                @if ($errors->has('confirm_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                <div class="input-group mb-3">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-10">
                                        <p class="mt-2">I agree to the <a href="#">terms</a></p>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-block btn-sm" style="height: 32px;">Register</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <a href="{{url('login/client')}}" class="btn btn-primary btn-block btn-sm mr-2 col-6">I already have a membership</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>

@endsection
