@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$type}}</h1>
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
                        <div class="row">
                            @if($type != 'screen_record' && $type != 'voice_record' && $type != 'videos')
                            @foreach($data as $d)
                            <div class="col-12 col-sm-3 col-md-1">
                                <div class="card card-primary" >
                                    <form action="{{url('/admin/storage_view/client/'.$d->user_id. '/'. $type)}}" method="get" id="myForm">
                                    <div class="card-body" id="submitDiv">
                                        <img src="{{$d->s3Url2($d->id)}}" class="img-fluid" alt="data">
                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @elseif($type == 'screen_record' || $type == 'videos') 
                            @foreach($data as $video)
                            <div class="video-container" >
                                <form action="{{url('/admin/storage_view/client/'.$video->user_id. '/'. $type)}}" method="get" id="myForm">
                                <div class="video-container" id="submitDiv">
                                    <video controls  style="height: 20rem; width: 13rem; margin-left: 10px;">
                                        <source src="{{$video->s3Url2($video->id)}}" type="video/mp4">
                                        Your browser does not support the video element.
                                    </video>        
                                </div>
                            </form>
                            </div>
                            @endforeach
                            @else

                        @foreach($data as $recording)
                    <div class="col-12 voice-record">
                        <div class="container-fluid" style="padding: 0 5px; position: relative;">
                            <div class="row pt-1">
                                <div class="col-12">
                                    <p class="text-dark m-0 mt-2" style="font-size: 10px;">
                                    {{ $recording->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="col-12 p-0">
                                    <audio class="w-100" id="plyr-audio-player" controls>
                                        <source src="{{$recording->s3Url2($recording->id)}}" type="audio/mp3" />
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                            @endif
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
        document.getElementById('submitDiv').addEventListener('click', function() {
        document.getElementById('myForm').submit();
    });
    });
</script>
@endsection
