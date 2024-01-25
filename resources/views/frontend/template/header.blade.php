<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TITLE</title>
     <link rel="icon" type="image/x-icon" href="{{url('assets/frontend/images/favicon-32x32.png')}}"> 
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{url('assets/frontend/images/favicon/apple-touch-icon.png')}}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/frontend/images/favicon/favicon-32x32.png')}}">



    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/frontend/images/favicon/favicon-16x16.png') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link href="{{url('assets/common/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link href="{{url('assets/common/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">

    <!-- Theme style -->
    <link href="{{url('assets/common/dist/css/adminlte.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{url('assets/frontend/mycustom.css') }}" rel="stylesheet">
    
    <!-- Toastr -->
    <link href="{{url('assets/common/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    
    
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="{{url('assets/common/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{url('assets/common/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    
    
    <!-- DataTable Button-->
    <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
    <!-- overlayScrollbars -->
    <link href="{{url('assets/common/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    
    <!-- Daterange picker -->
    <link href="{{url('assets/common/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    
    <!-- summernote -->
    <link href="{{url('assets/common/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

    
    <!-- JQUERY -->
   <script type="text/javascript" src="{{ url('assets/common/plugins/jquery/jquery.min.js') }}"> </script> 
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollpanel/1.1.1/jquery-scrollpanel.min.js"></script>

   {{-- <script src="/path/to/js/modalbox.min.js"></script> --}}
   <!-- jQuery UI 1.11.4 -->
   <script type="text/javascript" src="{{ url('assets/common/plugins/jquery-ui/jquery-ui.min.js') }}"> </script> 
   
    <!-- Sweet Alert  -->
   <script type="text/javascript" src="{{ url('assets/common/plugins/sweetalert2/sweetalert2.min.js') }}"> </script> 
   <!-- Toastr -->
   <script type="text/javascript" src="{{ url('assets/common/plugins/toastr/toastr.min.js') }}"> </script> 
   <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />
   <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>

    <style>
        body {
    margin: 0;
    font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
}
    /* Center the loader */
    .loader_bg {
        position: fixed;
        left: 0px;
        top: 0px;
        z-index: 9999999;
        background: #fff;
        width: 100%;
        height: 100%;
        background: rgb(159, 136, 136, .4);
    }

    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 999999;
        width: 120px;
        height: 120px;
        margin: -76px 0 0 -76px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid blue;
        border-right: 16px solid green;
        border-bottom: 16px solid red;
        border-left: 16px solid yellow;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Add animation to "page content" */
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0px;
            opacity: 1
        }
    }

    @keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0;
            opacity: 1
        }
    }

    #draggableResizableDiv {
            width: 200px;
            height: 200px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>

</head>