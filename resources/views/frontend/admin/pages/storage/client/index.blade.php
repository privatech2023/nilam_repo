@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>STORAGE CLIENTS</h1>
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
                        <span><a href="{{ url('/') }}" class="btn btn-outline-info btn-sm"><i class="fas fa-long-arrow-alt-left mr-1"></i>Back</a></span>
                    </div>
                    <div class="card-body">
                        <!-- Custom Filter --> 
                        <table class="float-right">
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm" id='searchByStatus'>
                                        <option value=''>-- Status--</option>
                                        <option value='1'>Paid</option>
                                        <option value='2'>Pending</option>
                                    </select>
                                </td>
                                <td>
                                    <button id="printButton" class="btn btn-outline-primary btn-sm">Print</button>
                                </td>
                            </tr>
                        </table>
                        <table class="float-right">
                            <tr>
                                <td>
                                    <input id="registration_date"  type="date" />
                                </td>
                            </tr>
                        </table>
                        <table id="dataTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Storage</th>
                                    <th>Storage plan</th>
                                    <th>Date</th>
                                    <th>Plan type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        $("#clientTree").addClass('menu-open');
        $("#clientMenu").addClass('active');
        $("#clientSubMenuStorageClient").addClass('active');
        var dataTable = $('#dataTable').DataTable({
            lengthMenu: [
                [10, 30, 50, 100],
                [10, 30, 50, 100]
            ],
            bProcessing: true,
            serverSide: true,
            scrollY: "400px",
            scrollCollapse: true,
            ajax: {
                url: "/admin/clients/ajaxCallAllClientsStorages",
                type: "post",
                data: function(data) {
                    console.log(data)
                    var type = $('#searchByStatus').val();
                    data.status = type;
                    var reg = $('#registration_date').val();
                data.registration = reg;
                }
            },
            columns: [
                {
                    data: "client_id" 
                },
                { data: "name" },
                { data: "mobile_number" },
                { 
                    data: "storage",
                render: function(data, type, row) {
                    return data + " GB";
                }
                },
                { data: "storage_name" },
                { data: "created_at" },
                { data: "validity" },
                {
                    mRender: function(data, type, row) {
                        return row.status == 1 ? '<span class="badge bg-success">YES</span>' : '<span class="badge bg-warning">NO</span>';
                    }
                },
                {
                    mRender: function(data, type, row) {
                    var url = '{{ url('/admin/storage_usage') }}/' + row.client_id;
                    return '<a href="' + url + '"><button class="btn btn-warning">View</button></a>';
                    }
                },
            ],
            columnDefs: [
                { orderable: false, searchable: false, targets: 0 },
                { className: 'text-center', targets: [1, 2, 3, 4, 5, 6] },
                {
                    "targets": [1, 2, 3, 4, 5, 6],
                    "render": function(data) {
                        return data;
                    }
                }
            ],
            "order": [[1, 'asc']],
            bFilter: true,
            "drawCallback": function(settings) {
                var api = this.api();
                var startIndex = api.context[0]._iDisplayStart;
                api.column(0).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1;
                });
            }
        });

        $(document).on('click','.btn-delete', function(event) {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#del_id').val(id);
        $('#delName').text(name);
        $('#modal-delete').modal('show');
    });

    $('#searchByStatus, #registration_date').change(function() {
    dataTable.draw();
});

function printData() {
        var table = dataTable.rows().data();
        var tableData = table.rows().data().toArray();
        $.ajax({
        url: '/admin/client/print',
        type: 'POST',
        data: { tableData: tableData },
        success: function(response) {
            // console.log(response)
            // var url = '/admin/client/print-view?tableData=' + encodeURIComponent(JSON.stringify(response));
            // window.location.href = url; 

            var form = document.createElement('form');
        form.method = 'POST'; 
        form.action = '/admin/client/print-view'; 

        var csrfToken = document.createElement('input');
csrfToken.type = 'hidden';
csrfToken.name = '_token'; 
csrfToken.value = '{{ csrf_token() }}';
        var tableDataInput = document.createElement('input');
        tableDataInput.type = 'hidden';
        tableDataInput.name = 'tableData'; 
        tableDataInput.value = JSON.stringify(response); 
        form.appendChild(tableDataInput);
        form.appendChild(csrfToken);
        document.body.appendChild(form);
            console.log(csrfToken);
        form.submit();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
    }


    $('#printButton').on('click', function() {
        printData();
    });
    });
</script>
@endsection
