@extends('frontend.template.main')

@section('main-container')

<div class="content-wrapper remove-background">

    <!-- Main content -->
    <div class="content">
        <div class="d-flex align-items-start justify-content-center vh-100">
            <div style="width: 550px; ">
                <div class="bg-gray-light">
        
                    <div class="d-flex justify-content-center">
                        <h4 class="text-secondary text-md" style="margin-top: 1.5rem;">Login</h4>
                    </div>
                    <div class="modal-body">
                        <div class="loader_bg" style="display:none;">
                            <div id="loader"></div>
                        </div>
        
                        <!-- Check User Form -->
                        <div id="step-user">
                            <span id="message"></span>
        
                            <form method="post" action="{{url('login/client')}}">
                                @csrf
                                @if ($errors->has('error'))
                                    <span class="text-danger">{{ $errors->first('error')  }}</span>
                                @endif
                                @if ($errors->has('mobile-email'))
                                    <span class="text-danger">{{ $errors->first('mobile-email')  }}</span>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="text" name="mobile-email" id="user" class="form-control" placeholder="Email/Mobile No">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password')  }}</span>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="text" name="password" id="password" class="form-control" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <span id="user_error" class="text-danger"></span>
        
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <button type="submit"
                                            class="btn btn-success btn-block btn-sm">Log In</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ url('register/client')}}" class="btn btn-warning btn-block btn-sm mr-2 col-2">Register</a>
                                    <button type="button" class="btn btn-secondary btn-block btn-sm col-2" style="margin-bottom: 7px;">Cancel</button>
                                </div>
    
                            </form>
                        </div><!-- User Form End -->
                    </div>
        
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        
    </div>



</div>

<script>
$(document).ready(function() {

    //defaule hide email login btn 
    //hide mobile-part

    $('#mobile-part').hide();
    $('#emailBtn').hide();

    $(".info-box").click(function() {

        $("#modal-default").modal({
            backdrop: 'static',
            keyboard: false
        });

    });

    $("#modal-default").on("hidden.bs.modal", function() {
        $('#user_error').html('');
        $('#userForm')[0].reset();
    });

});

function submitUserForm() {

    $('#userForm').on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ url('')}}check/client",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {

                $('.loader_bg').show();
                $('#userFormBtn').attr('disabled', 'disabled');
            },
            success: function(data) {
                $('.loader_bg').hide();
                if (data.error) {

                    if (data.user_error != '') {
                        $('#user_error').html(data.user_error);
                    } else {
                        $('#user_error').html('');
                    }

                }
                if (data.success) {

                    $('#message').html(data.message);
                    setTimeout(function() {
                        $('.loader_bg').show();
                        window.location.href =
                            "{{ url('login')}}";
                    }, 1000);

                }

                if (data.info) {

                    $('#message').html(data.message);
                    setTimeout(function() {
                        $('.loader_bg').show();
                        window.location.href =
                            "{{ url('register')}}";
                    }, 1000);

                }

                $('#userFormBtn').attr('disabled', false);
            },
            error: function() {

                $('.loader_bg').hide();
                $('#userForm')[0].reset();
                alert("Server Error !");
                $('#userFormBtn').attr('disabled', false);

            }

        })

    });
}
</script>



















@endsection