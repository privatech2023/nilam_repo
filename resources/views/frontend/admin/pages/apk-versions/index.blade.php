@extends('layouts.adminFrontend')

@section('main-container')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span>
                        <a href="{{url('/admin')}}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-long-arrow-alt-left mr-1"></i>Back
                        </a>
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Apk-versions</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
    
            <div class="row">
    
                <div class="col-sm-7 col-md-7">
                    <!-- Horizontal Form -->
                    <div class="card card-primary">
                        <div class="card-header bg-lightblue">
                            <h3 class="card-title">Apk Version</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ url('/admin/apk-versions')}}">
                            @csrf
    
                            <div class="card-body">
                                <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Apk version</label>
                                    <input type="number" class="form-control" name="apkVersion" value="{{ $apk['version'] }}">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-default float-right">Save</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>    
            </div>
        </div>
    </section>
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

@endsection