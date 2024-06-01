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
          <a href="{{ url('/admin')}}" class="nav-link">Home</a>
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
            {{ strtoupper(session('admin_name')) }}
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
            @if(in_array('viewSetting', session('user_permissions')) || session('admin_name') == 'admin')
            <a href="{{ url('/admin/settings')}}" class="dropdown-item">
              <!-- Message Start -->
              <i class="fas fa-users mr-2"></i>
              Settings
              <!-- Message End -->
            </a>
            @endif
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
            @if(in_array('viewClient', session('user_permissions')) || session('admin_name') == 'admin')
            <li class="nav-item has-treeview" id="clientTree">
              <a href="#" class="nav-link" id="clientMenu">
                <i class="nav-icon fab fa-product-hunt"></i>
                <p>
                  Clients
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('/admin/subscription/active')}}" class="nav-link" id="clientSubMenuActive">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Active</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/admin/subscription/pending')}}" class="nav-link" id="clientSubMenuPending">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pending</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/admin/subscription/expired')}}" class="nav-link" id="clientSubMenuExpired">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Expired</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/admin/subscription/index')}}" class="nav-link" id="clientSubMenuAll">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View all</p>
                  </a>
                </li>   
                <li class="nav-item">
                  <a href="{{ url('/admin/earnings/view')}}" class="nav-link" id="clientSubMenuEarning">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Earnings</p>
                  </a>
                </li>  
                @if(session('admin_name') == 'admin')
                <li class="nav-item">
                  <a href="{{ url('/admin/storage_usage')}}" class="nav-link" id="clientSubMenuStorageClient">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Storage usage</p>
                  </a>
                </li>
                @endif
                
              </ul>
            </li>
            @endif
            
            <li class="nav-item has-treeview" id="packageTree">
              <a href="#" class="nav-link" id="packageMenu">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Packages
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              
              <ul class="nav nav-treeview">
                @if(in_array('viewPackage', session('user_permissions')) || session('admin_name') == 'admin')
                <li class="nav-item">
                  <a href="{{ url('/admin/managePackages')}}" class="nav-link" id="packageSubMenuManage">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage packages</p>
                  </a>
                </li>
                @endif
                @if(in_array('viewCode', session('user_permissions')) || session('admin_name') == 'admin')
                <li class="nav-item">
                  <a href="{{ url('/admin/activationCodes')}}" class="nav-link" id="packageSubMenuCodes">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Activation codes</p>
                  </a>
                </li>
                
                <li class="nav-item">
                  <a href="{{ url('/admin/manageCoupons')}}" class="nav-link" id="packageSubMenuCoupons">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Coupons</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @if(in_array('viewUser', session('user_permissions')) || session('admin_name') == 'admin')
            <li class="nav-item has-treeview" id="employeeTree">
              <a href="#" class="nav-link" id="employeeMenu">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Manage employees
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              
                <li class="nav-item">
                  <a href="{{ url('/admin/users')}}" class="nav-link" id="employeeSubMenuManage">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage employees</p>
                  </a>
                </li>                  
                @if(in_array('viewRole', session('user_permissions')) || session('admin_name') == 'admin')
                <li class="nav-item">
                  <a href="{{ url('/admin/roles')}}" class="nav-link" id="employeeSubMenuRoles">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User roles</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/admin/commission')}}" class="nav-link" id="employeeSubMenuCommissions">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Commission</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ url('/admin/upline')}}" class="nav-link" id="employeeSubMenuUpline">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Upline</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            @endif
            <li class="nav-item has-treeview" id="tokenTree">
              <a href="#" class="nav-link" id="tokenMenu">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Tokens
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('/admin/tokens')}}" class="nav-link" id="SubMenuToken">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Issue tokens</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/admin/token-type')}}" class="nav-link" id="SubMenuTokenType">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Token types</p>
                  </a>
                </li>
              </ul>
            </li>
            @if(in_array('viewTransaction', session('user_permissions')) || session('admin_name') == 'admin')
            <li class="nav-item">
              <a href="{{ url('/admin/transactions')}}" class="nav-link" id="transactionsMenu">
                <i class="far fa-circle nav-icon"></i>
                <p>Transactions</p>
              </a>
            </li>
            @endif
            <li class="nav-item has-treeview">
              <a href="{{ url('/admin/apk-versions')}}" class="nav-link" id="apkMenu">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Apk versions
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/admin/earnings/view')}}" class="nav-link" id="clientSubMenuEarning">
                <i class="far fa-circle nav-icon"></i>
                <p>My earnings</p>
              </a>
            </li> 

            <li class="nav-item has-treeview">
              <a href="{{ url('/admin/manageStorage')}}" class="nav-link" id="storageMenu">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Storage
                </p>
              </a>
            </li>
            @if(in_array('viewSetting', session('user_permissions')) || session('admin_name') == 'admin')
            <li class="nav-item has-treeview">
              <a href="{{ url('/admin/settings')}}" class="nav-link" id="settingsMenu">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Settings
                </p>
              </a>
            </li>
            @endif

            @if(session('admin_name') == 'admin' || in_array('itAll', session('user_permissions')) )
            <li class="nav-item has-treeview">
              <a href="{{ url('/admin/technical/token')}}" class="nav-link" id="techTokensMenu">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Technical issue tokens
                </p>
              </a>
            </li>
            @endif
            @if(session('admin_name') == 'admin' )
            <li class="nav-item has-treeview">
              <a href="{{ url('/admin/test-api')}}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Test Api
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="{{ url('/log')}}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Logs
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="{{ url('/devices/view')}}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Devices
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="{{ url('/features/control')}}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gear"></i>
                <p>
                  Features control
                </p>
              </a>
            </li>
            @endif
            
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
