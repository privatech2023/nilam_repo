@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Test Api</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Test</a></li>
                        <li class="breadcrumb-item active">Api</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <form method="post" action="{{ url('/test-fcm-notification')}}">
            @csrf
            <div class="mb-3">
              <input type="text" name="device_token" class="form-control" id="device_token" placeholder="device token">
            </div>
            <div class="mb-3">
              <input type="text" name="title" class="form-control" id="title" placeholder="title">
            </div>
            <div class="mb-3">
              <textarea name="body" class="form-control" id="body"></textarea>
            </div>
            <div class="mb-3">
                <input type="text" name="action_to" class="form-control" id="action_to" placeholder="action to">
            </div>
            <div class="mb-3">
                <select class="form-select form-control" aria-label="Default select example">
                    <option selected>Direct book ok</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                  </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </section>
</div>  
@endsection