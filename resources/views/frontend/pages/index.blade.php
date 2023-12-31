@extends('layouts.frontend')

@section('main-container')
@if(session('user_name'))
<div class="row mt-3">
    <div class="col-9">
        <h2 style="margin-left: 12.5rem; color:beige; font-size: 2rem;">Welcome, {{session('user_name')}}</h2>
    </div>
    <div>
        <span class="text-md" style="color:dimgrey"><a href="{{ url('/')}}">Home </a>/ Dashboard</span>
    </div>
</div>
@endif
    <div class="content-wrapper remove-background">

        <!-- Main content -->
        <div class="content">
            <div class="container ">
                <div class="row">

                    <div class="col-lg-12">
                        <section class="content" style="margin-top:2rem">
                            <div class="container-fluid">
                                <!-- Info boxes -->
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="row">


                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-sms.svg') }}"
                                                    title="SMS" />

                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-contact.svg') }}"
                                                    title="CONTACTS" />
                                            </div>       

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-camera.svg') }}"
                                                    title="CAMERA" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-location.svg') }}"
                                                    title="LOCATION" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-call-logs.svg') }}"
                                                    title="CALL LOG" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-filemanager.svg') }}"
                                                    title="FILE MANAGER" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}"
                                                    title="VIBRATE" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}"
                                                    title="LOST MESSAGE" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-audio-record.svg') }}"
                                                    title="AUDIO RECORD" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-alert.svg') }}"
                                                    title="ALERT" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-screen-record.svg') }}"
                                                    title="SCREEN RECORD" />
                                            </div>

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(!session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-video-record.svg') }}"
                                                    title="VIDEO RECORD" />
                                            </div>    

                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" @if(session('user_name')) data-toggle="modal" data-target="#modalLoginPrompt" @endif>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-gallery.svg') }}"
                                                    title="GALLERY" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>



    {{-- Modal --}}
    <div class="modal fade" role="dialog" id="modalLoginPrompt">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-gray-light">

                <div class="modal-header">
                    <h4 class="modal-title text-center">Sign in to start your session</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="loader_bg" style="display:none;">
                        <div id="loader"></div>
                    </div>

                    <!-- Check User Form -->
                    <div id="step-user">

                            <span id="message"></span>

                        <form method="post" id="userForm">

                            <div class="input-group mb-1">

                                <input type="text" name="user_id" id="user" class="form-control"
                                    placeholder="Email/Mobile No">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <span id="user_error" class="text-danger"></span>

                            <div class="row">
                                <div class="col-8"></div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" onClick="submitUserForm()" id="userFormBtn"
                                        class="btn btn-success btn-block btn-sm">Log In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div><!-- User Form End -->

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <script>
        $(document).ready(function() {
            window.addEventListener('beforeunload', function (event) {
            $('.loader_bg').hide();
            $('#modalLoginPrompt').modal('hide');
            $('#user').val('');
            });
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
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
                $.ajax({
                    url: "{{ url('check/client')}}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                    'X-CSRF-TOKEN': csrfToken
                    },
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

                                var redirectUrl = "{{ url('/login_options/client') }}";
                                var postData = {
                                    user: data.data,
                                    _token: csrfToken,
                                    redirectUrl: redirectUrl,
                                    };
                                $.post(redirectUrl, postData, function(response) {
                                    console.log(response.redirectUrl)
                                    window.location.href = response.redirectUrl;
                                });
                            }, 1000);
                            $('.loader_bg').hide();
        
                        }
        
                        if (data.info) {
        
                            $('#message').html(data.message);
                            setTimeout(function() {
                                $('.loader_bg').show();
                                window.location.href =
                                    "{{ url('register/client')}}";
                            }, 1000);
                            $('.loader_bg').hide();
        
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
