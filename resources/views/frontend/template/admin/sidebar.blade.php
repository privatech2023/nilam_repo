<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
    
        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
    
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              ADMIN 
              <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item doropdown-header">Manage User</span>
              <a href="{{ url('/admin/profile/'.session('admin_id'))}}" class="dropdown-item">
                <!-- Message Start -->
                <i class="fas fa-envelope mr-2"></i>
                Profile
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ url('/admin/settings')}}" class="dropdown-item">
                <!-- Message Start -->
                <i class="fas fa-users mr-2"></i>
                Settings
                <!-- Message End -->
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{url('/admin/logout')}}" class="dropdown-item dropdown-footer">
                Logout
              </a>
            </div>
          </li>
          <!-- Notifications Dropdown Menu -->
        </ul>
      </nav>
      <!-- /.navbar -->
    
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="{{ asset('assets/common/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">ADMIN PANEL</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('assets/common/img/default_user.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">Admin</a>
            </div>
          </div>
    
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
              <li class="nav-item has-treeview menu-open">
                <a href="{{ url('/admin')}}" class="nav-link ">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fab fa-product-hunt"></i>
                  <p>
                    Clients
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/admin/subscription/active')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Active</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/subscription/pending')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pending</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/subscription/expired')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Expired</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/subscription/index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>View all</p>
                    </a>
                  </li>
                
                </ul>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tree"></i>
                  <p>
                    Packages
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/admin/managePackages')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage packages</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/activationCodes')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Activation codes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/manageCoupons')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Coupons</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/transactions')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transactions</p>
                </a>
              </li>
              @if(session('admin_name') === 'admin')
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Manage employees
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/admin/users')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage employees</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/admin/roles')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>User roles</p>
                    </a>
                  </li>
                </ul>
              </li>
              @endif
              <li class="nav-item has-treeview">
                <a href="{{ url('/admin/apk-versions')}}" class="nav-link">
                  <i class="nav-icon fas fa-solid fa-gear"></i>
                  <p>
                    Apk versions
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="{{ url('/admin/settings')}}" class="nav-link">
                  <i class="nav-icon fas fa-solid fa-gear"></i>
                  <p>
                    Settings
                  </p>
                </a>
              </li>
              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>