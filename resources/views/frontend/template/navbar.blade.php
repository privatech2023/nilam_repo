</head>
<body class="hold-transition layout-top-nav">

    <div class="wrapper wrapper-background">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand remove-background navbar-light">
            <div class="container">
                <ul class="navbar-nav">
                    <a href="{{url('/')}}" class="navbar-brand">
                        <img src="{{ url('assets/frontend/images/web-logo.png')}}" alt="AdminLTE Logo"
                            class="brand-image img-rectangle elevation-1 my-logo" style="opacity: .8">
                        <span class="brand-text font-weight-dark text-white">PRIVATECH</span>
                    </a>
                </ul>

                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link text-white" data-toggle="dropdown" href="#">
                            <i class="fas fa-bars"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                            <div class="dropdown-divider"></div>
                            @if(session('user_name'))
                            <a href="{{url('/subscription')}}" class="dropdown-item">
                                <i class="fas fa-inr mr-2" aria-hidden="true"></i> Subscription
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{url('/storage-plan')}}" class="dropdown-item">
                                <i class="fas fa-inr mr-2" aria-hidden="true"></i> Storage
                            </a>
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

                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-password">
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
                            <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal"
                                data-target="#modal-logout">Logout</a>
                            @endif
                      


                        </div>
                    </li>


                </ul>
            </div>
        </nav>