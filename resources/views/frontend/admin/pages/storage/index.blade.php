@extends('layouts.adminFrontend')

@section('main-container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>STORAGE</h1>
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
                            <h3 class="card-title">All storage</h3>
                            <div class="card-tools">
                            <button data-toggle="modal" data-target="#modal-view2" class="btn btn-block btn-success btn-sm">Default storage</button>
                            <button data-toggle="modal" data-target="#modal-view" class="btn btn-block btn-success btn-sm">Create new</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="float-right">
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm" id='searchByStatus'>
                                            <option value=''>-- Status--</option>
                                            <option value='0'>Pending</option>
                                            <option value='1'>Active</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table id="dataTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr><th>#</th>
                                    <th>Name</th>
                                    <th>Storage</th>
                                    <th>Validity</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
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


    {{-- delete modal --}}
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Package</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are You sure to <strong>Delete</strong> the storage <strong><span id="delName"></span></strong> ?</p>
                    <form action="{{ url('/admin/storage/delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="row_id" id="del_id">
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Confirm</button>
                        </div>
                    </form>   
                </div>
    
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    {{-- default storage --}}
    <div class="modal fade" id="modal-view2">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Storage</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/admin/storage/default')}}" method="post" style="margin-top: 4px;">
                        @csrf
                        <div class="container view-token-detail">
                            <div class="form-group row">
                                <label for="storage">Set default storage in MB</label>
                                <input class="form-control" id="storage" name="storage" type="number" value="{{ $default_storage}}" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit"  class="btn btn-outline-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- view modal --}}
    <div class="modal fade" id="modal-view">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Storage</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/admin/storage/create')}}" method="post" style="margin-top: 4px;">
                        @csrf
                        <div class="container view-token-detail">
    
                            <div class="form-group row">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" name="name" type="text" required>
                            </div>
                            <div class="form-group row">
                                <label for="storage">Storage in GB</label>
                                <input class="form-control" id="storage" name="storage" type="number" required>
                            </div>
                            <div class="form-group row">
                                <label for="status">Validity</label>
                                <select class="form-control" name="validity" required>
                                    <option value="" selected>Select</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="amount">Amount</label>
                                <input class="form-control" id="amount" name="amount" type="text" value="" required>
                            </div>
                            <div class="form-group row">
                                <label for="tax">Tax</label>
                                <input class="form-control" id="tax" name="tax" type="text" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="price">Price</label>
                                <input class="form-control" id="price" name="price" type="text" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="" selected>Select</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="submit"  class="btn btn-outline-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

            $("#storageMenu").addClass('active');

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var i = 1;
            
            var dataTable = $('#dataTable').DataTable({
                lengthMenu: [
                    [10, 30, -1],
                    [10, 30, "All"]
                ], 
                bProcessing: true,
                serverSide: true,
                scrollY: "400px",
                scrollCollapse: true,
                ajax: {
                    url: "/admin/storage/ajaxCallAllCodes", 
                    type: "post",
                    data: function(data) {  
                        var type = $('#searchByStatus').val();
                        data.status = type;
                    }
                },
                
                columns: [
                    {
                        mRender: function(data, type, full, meta) {
                        return i++;
                    }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "storage",
                    },
                    {
                        data: "plan_validity",
                    },
                    {
                        data: "amount"
                    },
                    {
                        data: "tax"
                    },
                    {
                        data: "price"
                    },
                    {
                        mRender: function(data, type, row) {
                            if (row.status == 1) {
                                return '<span class="badge bg-success">ACTIVE</span>';
                            } else {
        
                                return '<span class="badge bg-warning">USED</span>';
                            }                                       
                        }
                    },
                    {
                        mRender: function(data, type, row) {
                            return '<button class="btn btn-outline-danger btn-xs del-button" data-toggle="modal" data-target="#modal-delete" data-id="' + row.id + '" data-name="' + row.name + '" >Del</button>'
                        }
                    },
                ],
                columnDefs: [
        
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3]
                    },
                    {
                        className: 'text-center',
                        targets: [1, 2, 3, 4, 5]
                    },
                    {
                        "targets": [1, 2, 3, 4, 5],
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
        
            $('#modal-delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var todo_id = button.data('id')
            var todo_name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #del_id').val(todo_id)
            modal.find('.modal-body #delName').text(todo_name)

            });
        

        
        $(document).on('keyup', '#amount', function(){
        updatePrice();
        });


        function updatePrice(){
    var tmp_amt =  $('#amount').val();
    var gst = {{ $gst_rate}};
    var tax_amt = parseFloat(tmp_amt*gst)/100;
    var new_price = parseFloat(tmp_amt)+parseFloat(tax_amt);
    new_price = new_price.toFixed(2);
    $('#tax').val(tax_amt);
    $('#price').val(new_price);
    }

        });
        </script>
@endsection
