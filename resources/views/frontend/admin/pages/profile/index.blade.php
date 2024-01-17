@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper" style="min-height: 502.4px;">
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
                            <li class="breadcrumb-item"><a href="#">Profile</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                    src="{{url('assets/common/img/default_user.png')}}"
                    alt="User profile picture">
            </div>
        <form action="{{ url('/admin/profile/update')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id']}}" />
            <div class="form-group">
                @if(isset($error))
                    <div class="alert alert-danger">
                    <ul>
                    @foreach($error->all() as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name"  name="name" value="{{ $data['name']}}" readonly>           
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile number</label>
                <input type="number" class="form-control" id="mobile_number"  name="mobile_number" value="{{ $data->mobile }}" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" readonly>
            </div>
            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ $data->password }}">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="{{ $data->password }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        </div>
    </div>

@if(session()->get('success'))
    <script type="text/javascript">
        toastr.success('{{session('success')}}')
    </script>
@endif
@if(session()->get('error'))
    <script type="text/javascript">
        @foreach(session('error')->all() as $error)
            toastr.warning('{{ $error }}');
        @endforeach
    </script>
@endif
@endsection