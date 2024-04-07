@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper" style="min-height: 502.4px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users earnings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">earnings</li>
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
                            <span>
                                <a href="{{ url('/admin')}}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a>
                            </span>
                            <div class="card-tools">
                                @if(session('admin_name') == 'admin')
                                {{--  --}}
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group input-group-sm">
                                    <label>Direct earnings</label>
                                    <select class="form-control" name="user" id="user" required>
                                        <option value="" selected>Select</option>
                                        @foreach($directs as $d)
                                        <option value={{$d['user_id']}}>{{$d['user_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group input-group-sm" style="margin-left: 5rem;">
                                    <label>Upline earnings</label>
                                    <select class="form-control" name="upline" id="upline" required>
                                        <option value="" selected>Select</option>
                                        @foreach($upline as $c)
                                        <option value={{$c['user_id']}}>{{$c['user_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="container">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User name</th>
                                    <th scope="col">Client name</th>
                                    <th scope="col">Mobile number</th>
                                    <th scope="col">Earning</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
        
    </div>
   


    <script>
        $(document).ready(function () {
            $("#employeeTree").addClass('menu-open');
            $("#employeeMenu").addClass('active');
            $("#employeeSubMenuCommissions").addClass('active');

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $('#user').on('change', function () {
    $('#upline').val('');
    var user_id = $(this).val();
    $.ajax({
        type: "get",
        url: "/admin/get_direct_earnings/"+user_id,
        dataType: "json",
        success: function (response) {
            $('#container').empty();
            if (response.status === 200 && response.data.length > 0) {
                var table = $('<table>').addClass('table');
                var thead = $('<thead>').addClass('thead-dark');
                var tbody = $('<tbody>');

                var headerRow = $('<tr>');
                headerRow.append($('<th>').attr('scope', 'col').text('#'));
                headerRow.append($('<th>').attr('scope', 'col').text('User name'));
                headerRow.append($('<th>').attr('scope', 'col').text('Client name'));
                headerRow.append($('<th>').attr('scope', 'col').text('Mobile number'));
                headerRow.append($('<th>').attr('scope', 'col').text('Earning'));
                headerRow.append($('<th>').attr('scope', 'col').text('Created at'));

                thead.append(headerRow);

                response.data.forEach(function(item, index) {
                    var row = '<tr>' +
                        '<th scope="row">' + (index + 1) + '</th>' +
                        '<td>' + response.user.name + '</td>' + 
                        '<td>' + item.name + '</td>' + 
                        '<td>' + item.mobile_number + '</td>' +
                        '<td>' + item.commission + '</td>' + 
                        '<td>' + item.created_at + '</td>' + 
                    '</tr>';
                    tbody.append(row);
                });

                table.append(thead);
                table.append(tbody);
                $('#container').append(table);
            } else {
                $('#container').append('<tr><td colspan="5">No data available</td></tr>');
            }
        }
    });
});



            $('#upline').on('change', function () {
                $('#user').val('');
                var user_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "/admin/get_upline_earnings/"+user_id,
                    data: "data",
                    dataType: "json",
                    success: function (response) {
                        $('#container').empty();
            if (response.status === 200 && response.data.length > 0) {
                var table = $('<table>').addClass('table');
                var thead = $('<thead>').addClass('thead-dark');
                var tbody = $('<tbody>');

                var headerRow = $('<tr>');
                headerRow.append($('<th>').attr('scope', 'col').text('#'));
                headerRow.append($('<th>').attr('scope', 'col').text('User name'));
                headerRow.append($('<th>').attr('scope', 'col').text('Downline name'));
                headerRow.append($('<th>').attr('scope', 'col').text('Earning'));
                    headerRow.append($('<th>').attr('scope', 'col').text('Created at'));

                thead.append(headerRow);

                response.data.forEach(function(item, index) {
                    var row = '<tr>' +
                        '<th scope="row">' + (index + 1) + '</th>' +
                        '<td>' + response.user_name + '</td>' + 
                        '<td>' + item.name + '</td>' + 
                        '<td>' + item.amount + '</td>' + 
                        '<td>' + item.created_at + '</td>' + 
                    '</tr>';
                    tbody.append(row);
                });

                table.append(thead);
                table.append(tbody);
                $('#container').append(table);
            } else {
                $('#container').append('<tr><td colspan="5">No data available</td></tr>');
            }
                    }
                });
            });
        });
    </script>
    

@endsection
