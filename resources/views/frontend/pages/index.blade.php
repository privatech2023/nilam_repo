@extends('layouts.frontend')

@section('main-container')
@if(session('user_name'))
<div class="row mt-3 welcome">
    <div class="col-9">
        <h2  class="welcome-text">Welcome, {{session('user_name')}} </h2>
    </div>
    
    <div>
        <span class="text-md breadcrumb-text" ><a href="{{ url('/')}}">Home </a>/ Dashboard</span>
    </div>
    @if(session('store_more') == false)
    <div class="container">
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">STORAGE FULL</span>
    </div>
    @elseif(session('plan_expired') == true)
    <div class="container">
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">STORAGE PLAN EXPIRED</span>
    </div>
    @else 
    <div class="container">
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">STORAGE LEFT: {{session('storage_left')}}MB</span>
    </div>
    <div class="container">
        @if(session('remaining_days') == 'DEFAULT PACK')
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">{{session('remaining_days')}}</span>
        @else
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">{{session('remaining_days')}} DAYS</span>
        @endif
    </div>
    @endif

    

</div>
@endif
    <div class="content-wrapper remove-background">
        @php
    $validity = session('validity');
    $currentDate = date('Y-m-d');
    @endphp
        <!-- Main content -->
        <div class="content">
            <div class="container ">

                <div id="myModalconf" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">			
                                <h4 class="modal-title">Failed to connect</h4>	
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Please sync device from app to register your device</p>
                                <img src="{{ asset('assets/frontend/images/app1.jpeg') }}" alt="Mobile Screenshot" class="img-fluid smaller-image">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <button class="btn btn-primary btn-load" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Connecting...
                    </button>
                    <div class="col-lg-12">
                        <section class="content" style="margin-top:2rem">
                            <div class="container-fluid">
                                <!-- Info boxes -->
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="row">

                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt"  >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-sms.svg') }}"
                                                    title="SMS" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)                                           
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/message'.'/'.session('user_id'))}}"> <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-sms.svg') }}"
                                                    title="SMS" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs"  >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-sms.svg') }}"
                                                    title="SMS" />
                                            </div>                                        
                                            @endif
                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalLoginPrompt">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-contact.svg') }}"
                                                    title="CONTACTS" />
                                            </div> 
                                            @elseif($validity != null && $currentDate < $validity)   
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/contacts'.'/'.session('user_id'))}}"> <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-contact.svg') }}"
                                                    title="CONTACTS" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalSubs">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-contact.svg') }}"
                                                    title="CONTACTS" />
                                            </div> 
                                            @endif
                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalLoginPrompt">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-camera.svg') }}"
                                                    title="CAMERA" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity) 
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/camera'.'/'.session('user_id'))}}"> <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-camera.svg')  }}"
                                                    title="CAMERA" /></a>
                                            </div>  
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalSubs">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-camera.svg') }}"
                                                    title="CAMERA" />
                                            </div>
                                            @endif
                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-location.svg') }}"
                                                    title="LOCATION" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  >
                                                <a href="{{ url('/locate-phone'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-location.svg') }}"
                                                    title="LOCATION" /></a>
                                            </div> 
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-location.svg') }}"
                                                    title="LOCATION" />
                                            </div>
                                            @endif
                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-call-logs.svg') }}"
                                                    title="CALL LOG" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" >
                                                <a href="{{ url('/call-log'.'/'.session('user_id'))}}"> <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-call-logs.svg') }}"
                                                    title="CALL LOG" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-call-logs.svg') }}"
                                                    title="CALL LOG" />
                                            </div>
                                            @endif
                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2 disabled-div"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <div class="upcoming-banner">Upcoming</div>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-filemanager.svg') }}"
                                                    title="FILE MANAGER" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2 disabled-div"  >
                                                <div class="upcoming-banner">Upcoming</div>
                                                <a href="{{ url('/filemanager'.'/'.session('user_id'))}}"> <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-filemanager.svg') }}"
                                                    title="FILE MANAGER" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2 disabled-div"  data-toggle="modal" data-target="#modalSubs" >
                                                <div class="upcoming-banner">Upcoming</div>
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-filemanager.svg') }}"
                                                    title="FILE MANAGER" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}"
                                                    title="VIBRATE" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  >
                                                <a href="{{ url('/vibrate-device'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}"
                                                    title="VIBRATE" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}"
                                                    title="VIBRATE" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}"
                                                    title="LOST MESSAGE" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" >
                                                <a href="{{ url('/lost-messages'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}"
                                                    title="LOST MESSAGE" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}"
                                                    title="LOST MESSAGE" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-audio-record.svg') }}"
                                                    title="AUDIO RECORD" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" >
                                                <a href="{{ url('/audio-record'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-audio-record.svg') }}"
                                                    title="AUDIO RECORD" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs">
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-audio-record.svg') }}"
                                                    title="AUDIO RECORD" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-alert.svg') }}"
                                                    title="ALERT" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  >
                                                <a href="{{ url('/alert-device'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-alert.svg') }}"
                                                    title="ALERT" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-alert.svg') }}"
                                                    title="ALERT" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-screen-record.svg') }}"
                                                    title="SCREEN RECORD" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" >
                                                <a href="{{ url('/screen-record'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-screen-record.svg') }}"
                                                    title="SCREEN RECORD" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2" data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-screen-record.svg') }}"
                                                    title="SCREEN RECORD" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-video-record.svg') }}"
                                                    title="VIDEO RECORD" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"data-toggle="modal" >
                                                <a href="{{ url('/video-record'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-video-record.svg') }}"
                                                    title="VIDEO RECORD" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-video-record.svg') }}"
                                                    title="VIDEO RECORD" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-gallery.svg') }}"
                                                    title="GALLERY" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/gallery'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-gallery.svg') }}"
                                                    title="GALLERY" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/android-gallery.svg') }}"
                                                    title="GALLERY" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/text-speech.png') }}"
                                                    title="TEXT TO SPEECH" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/text-to-speech'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/text-speech.png') }}"
                                                    title="TEXT TO SPEECH" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/text-speech.png') }}"
                                                    title="TEXT TO SPEECH" />
                                            </div>
                                            @endif


                                            @if(!session('user_name'))
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalLoginPrompt" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/devices.png') }}"
                                                    title="MY DEVICES" />
                                            </div>
                                            @elseif($validity != null && $currentDate < $validity)
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                                <a href="{{ url('/my-devices'.'/'.session('user_id'))}}"><x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/devices.png') }}"
                                                    title="MY DEVICES" /></a>
                                            </div>
                                            @else
                                            <div class="col-4 col-sm-3 col-md-3 col-lg-2"  data-toggle="modal" data-target="#modalSubs" >
                                                <x-frontend.icons
                                                    imageIcon="{{ asset('assets/frontend/images/icons/devices.png') }}"
                                                    title="MY DEVICES" />
                                            </div>
                                            @endif
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


    <div id="resizeDiv"></div>



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
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- modal subs --}}
    <div class="modal fade" role="dialog" id="modalSubs">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-gray-light">

                <div class="modal-header">
                    <h4 class="modal-title text-center">Purchase a subscription</h4>
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


                            <span id="user_error" class="text-danger"></span>

                            <div class="row">
                                <div class="col-8"></div>
                                <!-- /.col -->
                                <div class="col-4">
                                   <a href="{{url('/subscription')}}"><button type="button" 
                                        class="btn btn-success btn-block btn-sm">Buy subscription</button></a> 
                                </div>
                                <!-- /.col -->
                            </div>
                    </div><!-- User Form End -->

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
   
    <!-- Modal HTML -->


    <script>
        var errors = @json($errors->all());
    </script>
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
        $(document).ready(function() {
        var userId = "{{ session('user_id') }}"; 
        if(userId == ''){
            var button = document.querySelector('.btn-load');
        button.disabled = false;
        var spinner = button.querySelector('.spinner-border');
        if (spinner) {
            spinner.remove();
        }
        var buttonTextSpan = button.querySelector('.sr-only');
        if (buttonTextSpan) {
            buttonTextSpan.textContent = 'Connect';
        }
        button.style.display = 'none';
            button.disabled = true;
        }
        else{
            $.ajax({
    type: "get",
    url: "/get/device/" + userId,
    data: "data",
    dataType: "json",
    success: function (response) {
        if(response == 0){
            $('#myModalconf').modal('show');
        }else {
        $(".btn-load").html("Connected");       
    }
    setTimeout(function () {
            var button = document.querySelector('.btn-load');
        button.disabled = false;
        var spinner = button.querySelector('.spinner-border');
        if (spinner) {
            spinner.remove();
        }
        var buttonTextSpan = button.querySelector('.sr-only');
        if (buttonTextSpan) {
            buttonTextSpan.textContent = 'Connect';
        }
        button.style.display = 'none';
            button.disabled = true;
        }, 4000);
        }
    });
        }
            if (errors.length > 0) {
                $('#modal-password').modal('show');
        }
            $('#resizeDiv')
	    .draggable()
	    .resizable();
            $('#resizeDiv')
	.resizable({
		start: function(e, ui) {
			alert('resizing started');
		},
		resize: function(e, ui) {
		
		},
		stop: function(e, ui) {
			alert('resizing stopped');
		}
	});



            window.addEventListener('beforeunload', function (event) {
            $('.loader_bg').hide();
            $('#modalLoginPrompt').modal('hide');
            $('#user').val('');
            });

            
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
