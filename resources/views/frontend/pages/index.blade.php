<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PTG</title>

    <!-- Favicons -->
    <link href="{{url('assets/frontend/images/favicon-32x32.png')}}" rel="icon">
    <link href="{{ asset('assets_2/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- bootstrap CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Poppins CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('assets_2/css/style.css')}}">

    <!-- JQuery Script -->

    <script type="text/javascript" src="{{ url('assets/common/plugins/jquery/jquery.min.js') }}"> </script> 


        <script type="text/javascript" src="{{ url('assets/common/plugins/jquery-ui/jquery-ui.min.js') }}"> </script> 
    
     <!-- Sweet Alert  -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/sweetalert2/sweetalert2.min.js') }}"> </script> 
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="{{ url('assets/common/plugins/toastr/toastr.min.js') }}"> </script> 

    <style>
        /*dynamically generated from backend-code*/

        @if($bg)
        .body-bg-img {
            background-image: url("{{ $bg->url }}")!important;
        }
        @else
        .body-bg-img {
            background-image: url("assets_2/img/billy-huynh-W8KTS-mhFUE-unsplash.jpg")!important;
        }
        @endif

        .timer {
            font-size: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .logo-col.disabled {
            opacity: 0.5; /* Adjust opacity to make it faded */
            pointer-events: none; /* Disable pointer events to make it unclickable */
        }

        /* Dropdown menu positioning */
        .dropdown-menu {
        position: absolute; /* Change to absolute positioning */
        z-index: 1000; /* Ensure it's above everything */
        right: 0;
        transform: translate(0, 0); /* Move it above the navbar */
    }

    </style>

</head>

<body class="dashboard-body body-bg-img">

    <div class="mobile-container">

        <!--  Header Section -->
<nav class="navbar main-navbar fixed-top">
    <div class="container">
        <div class="left-div text-light">
            <h4 >PRIVATECH</h4>
        </div>
        @php
    $validity = session('validity');
    $currentDate = date('Y-m-d');
    $user_id = session('user_id')
    @endphp
        <ul style="margin-top:2px;">

            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-bs-toggle="dropdown" href="#">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="dropdown-divider"></div>
                    @if(session('user_name'))
                    <a href="{{url('/subscription')}}" class="dropdown-item">
                        <i class="fas fa-inr mr-2" aria-hidden="true"></i> Subscription
                    </a>
                    {{-- <div class="dropdown-divider"></div>
                    <a href="{{url('/storage-plan')}}" class="dropdown-item">
                        <i class="fas fa-inr mr-2" aria-hidden="true"></i> Storage
                    </a> --}}
                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cloud-download mr-2" aria-hidden="true"></i> Download APK
                        <span class="float-right text-muted text-sm">7 MB</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="{{url('/profile')}}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile

                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-password">
                        <i class="fa-solid fa-key"></i> Change Password
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="{{ url('/issue-token')}}" class="dropdown-item" >
                        <i class="fa-solid fa-tags"></i> Issue token
                    </a>
                    
                    @endif

                    <div class="dropdown-divider"></div>

                    <a href="https://privatechgarden.online/privacy-policy" class="dropdown-item">
                        <i class="fa-regular fa-file mr-2" aria-hidden="true"></i> Privacy Policy
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="https://privatechgarden.online/terms-of-service" class="dropdown-item">
                        <i class="fa-regular fa-file mr-2" aria-hidden="true"></i> Terms of service
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="https://privatechgarden.online/refund-policy" class="dropdown-item">
                        <i class="fa-regular fa-file mr-2" aria-hidden="true"></i>Return &amp; Refund
                    </a>
                    @if(!session('user_name'))
                    <div class="dropdown-divider"></div>
                    <a href="<?= url('login/client') ?>" class="dropdown-item dropdown-footer">Login</a>
                    @endif
                    @if(session('user_name'))
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('client/logout')}}" class="dropdown-item dropdown-footer" 
                        >Logout</a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</nav>
<!--  Header Section Ends -->


        <!-- Main Section -->
        <main class="main" style="margin: 40px 1px;">
            @if(session('user_name'))
<div class="row mt-3 welcome" style="margin-top: 20px; margin-left:8px;">
    <div class="col-9" style="margin-top:5px;">
        <p  class="welcome-text text-white " style="text-transform: uppercase; font-size: 1.3em;">{{session('user_name')}} </p>
    </div>
    @if(session('store_more') == false)
    <div class="container">
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">STORAGE FULL</span>
        <a href="{{ url('/storage-plan')}}" style="margin-left: 5px;"><button class="btn-sm btn-primary">Buy storage</button></a>
    </div>
    @elseif(session('plan_expired') == true)
    <div class="container">
        <span class="text-md breadcrumb-text " style="color: #6e668d; margin-left: 3px;">STORAGE PLAN EXPIRED</span>
        <a href="{{ url('/storage-plan')}}" style="margin-left: 5px;"><button class="btn-sm btn-primary">Buy storage</button></a>
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
<div class="timer" style="z-index: 1000;">
                <strong>Upcoming features, May 21, 2024: </strong><span id="countdown" class="text-sm"></span>
            </div>


            

            <section class="main-section">

                

                
                <div class="container-fluid">
                    <div class="row">
                        <div class=" col-12">
                            <div class="container-fluid">
                                <div class="row">
                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col" data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/picture.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Gallery</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)   
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/gallery')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/picture.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Gallery</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/picture.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Gallery</p>
                                            </div>
                                        
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/microphone.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Voice Recording</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity) 
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/voice-record')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/microphone.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Voice Recording</p>
                                            </div>
                                        </a>
                                    </div> 
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/microphone.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Voice Recording</p>
                                            </div>
                                        
                                    </div> 
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/photo-camera.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Camera</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity) 
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/camera')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/photo-camera.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Camera</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/photo-camera.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Camera</p>
                                            </div>
                                        
                                    </div>
                                    @endif



                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/mail.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Message</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity) 
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/messages')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/mail.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Message</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/mail.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Message</p>
                                            </div>
                                        
                                    </div>
                                    @endif
                                    
                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/phone-call.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Call Logs</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity) 
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/call-logs')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/phone-call.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Call Logs</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/phone-call.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Call Logs</p>
                                            </div>
                                        
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/contact-book.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Contacts</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity) 
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/contacts')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/contact-book.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Contacts</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col"  data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/contact-book.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Contacts</p>
                                            </div>
                                        
                                    </div>
                                    @endif



                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/battery.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Device Status</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/device-status')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/battery.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Device Status</p>
                                            </div>
                                        </a>
                                    </div> 
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/battery.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Device Status</p>
                                            </div>
                                        
                                    </div>
                                    @endif

                                    

                                    

                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt"  >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/image.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Screen Record</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/screen-record')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/image.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Screen Record</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/image.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Screen Record</p>
                                            </div>
                                        
                                    </div>
                                    @endif
                                    
                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/map.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Location</p>
                                            </div>
                                        
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/location')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/map.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Location</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col "  data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/map.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Location</p>
                                            </div>
                                        
                                    </div>
                                    @endif

                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/settings.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Settings</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col ">
                                        <!-- buttons -->
                                        <a href="{{ url('/settings/' . $user_id)}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/settings.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Settings</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs" >
                                        <!-- buttons -->
                                        
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/settings.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Settings</p>
                                            </div>
                                        
                                    </div>
                                    @endif

                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-alert.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Alert device</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="{{ url('/alert-device')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-alert.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Alert device</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-alert.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Alert device</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/text-speech.png') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Text to speech</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="{{ url('/text-to-speech')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/text-speech.png') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Text to speech</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/text-speech.png') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Text to speech</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Lost message</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="{{ url('/lost-message')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Lost message</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-lostmessage.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Lost message</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Vibrate</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="{{ url('/vibrate-device')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Vibrate</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/frontend/images/icons/android-vibrate.svg') }}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Vibrate</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/whatsapp.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Whatsapp</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="https://web.whatsapp.com/">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/whatsapp.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Whatsapp</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/whatsapp.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Whatsapp</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/facebook.svg.webp')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Facebook</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="https://www.facebook.com/">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/facebook.svg.webp')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Facebook</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/facebook.svg.webp')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Facebook</p>
                                            </div>
                                    </div>
                                    @endif


                                    @if(!session('user_name'))
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalLoginPrompt" >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/instagram.avif')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Instagram</p>
                                            </div>
                                    </div>
                                    @elseif($validity != null && $currentDate < $validity)
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " >
                                        <!-- buttons -->
                                        <a href="https://www.facebook.com/">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/instagram.avif')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Instagram</p>
                                            </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-1 col-md-2 col-3 logo-col " data-bs-toggle="modal" data-bs-target="#modalSubs"  >
                                        <!-- buttons -->
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/instagram.avif')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Instagram</p>
                                            </div>
                                    </div>
                                    @endif




                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="assets/pages/apps.html">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/user-interface.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Apps</p>
                                            </div>
                                        </a>
                                    </div>

                                    

                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled ">
                                        <!-- buttons -->
                                        <a href="{{ asset('assets_2/pages/sim-details.html')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/dual.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Sim Details</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="index.html">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/smart-tv.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Screen Mirroring</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="{{ asset('assets_2/pages/gmail.html')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/gmail.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Gmail</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled ">
                                        <!-- buttons -->
                                        <a href="index.html">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/remote-control.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Remote Control</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="{{ url('/call-recording')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/call-record.png')}}" alt="logos">
                                            </div>
                                            <div class="logo-title">
                                                <p>Call Recording</p>
                                            </div>
                                        </a>
                                    </div>

                                    
                                    <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="{{ asset('assets_2/pages/files.html')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/folder.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>Files</p>
                                            </div>
                                        </a>
                                    </div>

                                    /* <div class="col-lg-1 col-md-2 col-3 logo-col disabled">
                                        <!-- buttons -->
                                        <a href="{{ asset('assets_2/pages/whatsapp.html')}}">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets_2/img/icons/whatsapp.png')}}" alt="icon">
                                            </div>
                                            <div class="logo-title">
                                                <p>WhatsApp</p>
                                            </div>
                                        </a>
                                    </div> */
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>
        <!-- Main Section Ends -->

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



    {{-- Modal --}}
    <div class="modal fade" role="dialog" id="modalLoginPrompt">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-gray-light">

                <div class="modal-header">
                    <h4 class="modal-title text-center">Sign in to start your session</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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


    <!-- Password Modal -->
<div class="modal fade" role="dialog" id="modal-password">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-gray-light">

            <div class="modal-header">
                <h4 class="modal-title text-center">Reset password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="loader_bg" style="display:none;">
                    <div id="loader"></div>
                </div>

                <span id="message"></span>

                <form method="post" id="passwordForm" action="{{ url('/profile-update')}}">
                    @csrf
                    @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span id="password_error" class="text-danger"></span>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span id="passconf_error" class="text-danger"></span>

                    <div class="row">
                        <div class="col-8"></div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" 
                                class="btn btn-success btn-block btn-sm">Reset</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <!-- Fontawesome Script -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    

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
        $(document).ready(function () {
            
            $('#modalLoginPrompt').modal('hide');
            // Set the end date for the countdown
            var endDate = new Date("May 21, 2024 00:00:00").getTime();

            // Update the countdown every second
            var x = setInterval(function () {
                // Get the current date and time
                var now = new Date().getTime();

                // Calculate the time remaining
                var distance = endDate - now;

                // Calculate days, hours, minutes, and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the countdown
                document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

                // If the countdown is finished, display a message
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "EXPIRED";
                }
            }, 1000);


            var userId = "{{ session('user_id') }}"; 
        /* if(userId == ''){
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
        } */
            if (errors.length > 0) {
                $('#modal-password').modal('show');
        }
            /* $('#resizeDiv')
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
	}); */



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
</body>
</html>
