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


    .highlight-on-click {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5); /* Bootstrap primary color */
    transition: box-shadow 0.5s ease 0s;
}

.logo-col:hover {
    cursor: pointer;
}

.logo-col:hover .highlight-on-click {
    box-shadow: none; 
    transition: box-shadow 0.5s ease 0.5s; 
}



    </style>
</head>

@if($isGall == 1)
<body class="dashboard-body body-bg-img" style="background-image: url('{{ $bg->url }}')">
@elseif($isGall == 2)
<body style="background-image: url('{{ $image->s3Url()}}');  background-size: cover;">
@else
<body class="dashboard-body body-bg-img">
@endif

    <div class="mobile-container">
        @php
    $validity = session('validity');
    $currentDate = date('Y-m-d');
    $user_id = session('user_id')
    @endphp
    <!-- Header Section -->
<nav class="navbar main-navbar fixed-top" id="main-navbar">
    <div class="container">
        <div class="left-div text-light">
                <h4 class="mr-3"><a href="{{ url('/')}}" style="text-decoration: none; color:white">PRIVATECH</a></h4>
        </div>  
        
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
                    <a href="https://privatech.in/wp-content/uploads/2023/privatech_apk/app-release.apk" class="dropdown-item">
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

    

</div>



{{-- content --}}

    <div class="container text-center" style="margin-top:3rem;">
        <h2>Download the premium version app below</h2>
        <a href="https://privatech.in/wp-content/uploads/2023/privatech_apk/app-release.apk"><button class="btn-sm btn-primary" style="margin-left:auto; margin-right:auto; color:white; background-color:rgb(50, 50, 131); height:50px; width: 200px; font-size: 1.2rem;">DOWNLOAD</button></a>
        <p style="color:rgb(50, 49, 49)">Ignore if downloaded already</p>
        <a href="{{ url('/')}}" style="color:rgb(105, 159, 253); text-decoration: none;"><img src="{{ asset('assets_2/img/home.png')}}" style="height:18px; width:18px;"/> GO TO DASHBOARD</a>
    </div>
    <hr>
    <div class="container text-center" style="margin-top:1rem; display:flex;">
        <div class="row" style="margin:auto">
            <h5><strong>GUIDE</strong></h5>
            <strong>Step 1:</strong>
            <p style="color: rgb(239, 240, 242)">Install the app and open it</p>
            <img src="{{ asset('assets_2/img/screenshots/1.jpeg')}}" style="width:18rem;"/>
            <strong>Step 2:</strong>
            <p style="color: rgb(239, 240, 242)">Open device permissions</p>
            <img src="{{ asset('assets_2/img/screenshots/5.jpeg')}}" style="width:18rem;"/>
            <strong>Step 3:</strong>
            <p style="color: rgb(239, 240, 242)">Enable all the necessary permissions</p>
            <img src="{{ asset('assets_2/img/screenshots/3.jpeg')}}" style="width:18rem;"/>
            <strong>Step 4:</strong>
            <p style="color: rgb(239, 240, 242)">Click on sync device</p>
            <img src="{{ asset('assets_2/img/screenshots/6.jpeg')}}" style="width:18rem; "/>
        </div>
    </div>

</main>
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
    function highlightOnClick(element) {
    element.classList.add('highlight-on-click');
    setTimeout(function(){
        element.classList.remove('highlight-on-click');
    }, 1500);
}

    // Get the navbar
    var navbar = document.getElementById("main-navbar");
    
    // Initialize variable to keep track of the last scroll position
    var lastScrollTop = 0;

    // Function to handle scroll events
    window.addEventListener("scroll", function() {
        // Get the current scroll position
        var currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        // If the current scroll position is greater than the last scroll position, hide the navbar
        if (currentScroll > lastScrollTop){
            navbar.style.transform = "translateY(-100%)";
        } else {
            // Otherwise, show the navbar
            navbar.style.transform = "translateY(0)";
        }

        // Update last scroll position
        lastScrollTop = currentScroll;
    });    
</script>

    
</body>
</html>
