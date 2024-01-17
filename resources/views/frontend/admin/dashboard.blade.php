@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
      <h2 class="lead mb-2">Clients</h2>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/subscription/active')}}">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Active</span>
              <span class="info-box-number">
                
                <small></small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/subscription/pending')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pending</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/subscription/expired')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Expired</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/subscription/index')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">All clients</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <h2 class="lead mb-2 mt-2">Dealers</h2>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-sitemap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">New requests</span>
              <span class="info-box-number">
                XX
                <small></small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-sitemap"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">All dealers</span>
              <span class="info-box-number">XX</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-sitemap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Messages</span>
              <span class="info-box-number">XX</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-sitemap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Settings</span>
              <span class="info-box-number">XX</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <h2 class="lead mb-2 mt-2">Subscriptions</h2>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/transactions')}}">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-receipt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Transactions</span>
              <span class="info-box-number">
                {{ $transactions }}
                <small></small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/managePackages')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-layer-group"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Packages</span>
              <span class="info-box-number">
                {{ $packages }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/activationCodes')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-ticket-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Activation codes</span>
              <span class="info-box-number">
                {{ $activation_codes }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('/admin/manageCoupons')}}">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-tag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Discount coupons</span>
              <span class="info-box-number">
                {{ $coupons }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
{{-- @endsection
@section('main-container') --}}

@endsection