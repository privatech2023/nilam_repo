@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>UPLINE EARNINGS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">UPLINE</a></li>
                            <li class="breadcrumb-item active">Earnings</li>
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
                            <h3 class="card-title">All upline earnings</h3>
                        </div>
                        <div class="card-body">
                            <!-- Custom Filter -->
                            <table class="float-right">
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm" id='searchByStatus'>
                                            <option value=''>-- Status--</option>
                                            <option value='0'>Pending</option>
                                            <option value='1'>Success</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table id="dataTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr><th>ID</th>
                                    <th>Downline name</th>
                                    <th>Commission</th>
                                    <th>Date</th>
                                    <th>status</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    @if(session()->get('success'))
    <script type="text/javascript">
        toastr.success('{{session('success')}}');
    </script>
@endif
@if(session()->get('error'))
    <script type="text/javascript">
        toastr.warning('{{session('error')}}');
    </script>
@endif

    <script>
        
        $(document).ready(function() {


            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        
            $("#clientTree").addClass('menu-open');
    $("#clientMenu").addClass('active');
    $("#clientSubMenuEarning").addClass('active');
            
            var dataTable = $('#dataTable').DataTable({
                lengthMenu: [
                    [10, 30, -1],
                    [10, 30, 'All']
                ], 
                bProcessing: true,
                serverSide: true,
                scrollY: "400px",
                scrollCollapse: true,
                ajax: {
                    url: "/admin/earnings/ajaxAllUplineEarnings", 
                    type: "post",
                    data: function(data) {  
                        var type = $('#searchByStatus').val();
                        data.status = type;
                    }
                },
                
                columns: [
                    {
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "amount",
                        "render": function(data, type, row, meta) {
                        return '₹' + data; 
                    }
                    },
                    {
                        data: "formatted_created_at",
                    },   
                    {
                        data: "updated_at",
                    },                 
                ],
                columnDefs: [
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3]
                    },
                    {
                        className: 'text-center',
                        targets: [1, 2, 3, 4]
                    },
                    {
                        "targets": [1, 2, 3, 4],
                        "render": function(data) {
                            return data;
                        },
                    },
        
                ],
                bFilter: true, 
            });
        
        
            $('#searchByStatus').change(function() {
                dataTable.draw();
            });
        
        
            $(document).on('click','.del-button', function(){
            var data = $(this).data('value');
                $('#del_id').val(data);
                $('#modal-delete').modal('show');
        });

        });
        </script>
@endsection
