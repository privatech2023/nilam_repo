@extends('frontend.template.main')

@section('main-container')

<div class="content-wrapper remove-background">
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-light"> Welcome, <small>{{ session('user_name') }}</small></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('subscription') }}">Storages</a></li>
                    <li class="breadcrumb-item active">Storages</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Storages</h5>
                    </div>
                    <div class="card-body">
                        <div class="card card-solid">
                            <div class="card-body pb-0">
                                <div class="row">

                                    @foreach($storages as $list)
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header elevation-2 lead border-bottom-0">
                                                    <b>{{ $list['name'] }}</b>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="bg-info py-2 px-3 mt-4">
                                                                <h2 class="mb-0">
                                                                    {{ $list['storage'] }} GB
                                                                </h2>
                                                                <h2 class="mb-0">
                                                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                                                    {{ $list['price'] }} /-
                                                                </h2>
                                                                <h4 class="mt-1">
                                                                    <small>
                                                                        <i class="fa-regular fa-calendar"></i>:
                                                                        {{ $list['plan_validity'] }}
                                                                    </small>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-center">
                                                        <a href="{{ url('storage-plan/purchase/'.$list['id']) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-cart-shopping"></i> Buy
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- activation modal --}}



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