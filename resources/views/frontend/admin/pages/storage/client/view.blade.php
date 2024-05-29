@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>STORAGE CLIENTS VIEW</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Storage</a></li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <span><a href="{{ url('/admin/storage_usage') }}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>
                    </div>
                    <div class="card-body">
                        
                        <div class="container-fluid">
                            <h2 class="lead mb-2">Clients</h2>
                            <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                @php
                                    $type='gallery';
                                @endphp
                                <a href="{{ url('/admin/storage_view/'.$type) }}">
                                <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Gallery</span>
                                    <span class="info-box-number">
                                        <p>{{count($gallery)}}</p>
                                    <small>
                                        <p>{{$gall_size}}MB</p>
                                    </small>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                                </div>
                            </a>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                @php
                                    $type='photos';
                                @endphp
                                <a href="{{ url('/admin/storage_view/'.$type) }}">
                                <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Photos</span>
                                    <span class="info-box-number">
                                        <p>{{count($images)}}</p>
                                    </span>
                                    <small>
                                        <p>{{$photo_size}}MB</p>
                                    </small>
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
                                @php
                                    $type='videos';
                                @endphp
                                <a href="{{ url('/admin/storage_view/'.$type) }}">
                                <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Videos</span>
                                    <span class="info-box-number">
                                        <p>{{count($videos)}}</p>
                                    </span>
                                    <small>
                                        <p>{{$video_size}}MB</p>
                                    </small>
                                </div>
                                <!-- /.info-box-content -->
                                </div>
                            </a>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                @php
                                    $type='screen_record';
                                @endphp
                                <a href="{{ url('/admin/storage_view/'.$type) }}">
                                <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Screen record</span>
                                    <span class="info-box-number">
                                        <p>{{count($screen_record)}}</p>
                                    </span>
                                    <small>
                                        <p>{{$screenRecord_size}}MB</p>
                                    </small>
                                </div>
                                <!-- /.infobox-content -->
                                </div>
                            </a>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                @php
                                    $type='voice_record';
                                @endphp
                                <a href="{{ url('/admin/storage_view/'.$type) }}">
                                <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Voice record</span>
                                    <span class="info-box-number">
                                        <p>{{count($voice_record)}}</p>
                                    </span>
                                    <small>
                                        <p>{{$voiceRecord_size}}MB</p>
                                    </small>
                                </div>
                                </div>
                                </a>
                            </div>
                            </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- /.content -->
</div>



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
        $("#clientTree").addClass('menu-open');
        $("#clientMenu").addClass('active');
        $("#clientSubMenuStorageClient").addClass('active');
    });
</script>
@endsection
