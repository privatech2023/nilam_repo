@extends('layouts.adminFrontend')

@section('main-container')
<div class="content-wrapper" style="min-height: 502.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Active subscriptions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Clients</a></li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <script type="text/javascript">
    </script>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <span>
                            <a href="https://ptg.privatech.in/admin/dashboard" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-long-arrow-alt-left mr-1"></i>Back
                            </a>
                        </span>

                        <div class="card-tools">
                            <a href="https://ptg.privatech.in/admin/clients/add" class="btn btn-block btn-success btn-sm">Add Client</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Custom Filter -->
                        

                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="dataTable_length">
                                        <label>Show
                                            <select name="dataTable_length" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="10">10</option>
                                                <option value="30">30</option>
                                                <option value="-1">All</option>
                                            </select> 
                                            entries
                                        </label>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <div id="dataTable_filter" class="dataTables_filter">
                                        <label>Search:
                                            <input type="search" class="form-control form-control-sm" placeholder=""
                                                aria-controls="dataTable">
                                        </label>
                                    </div>
                                </div>
                                <table class="float-right">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control form-control-sm" id="searchByStatus">
                                                    <option value="">-- Status--</option>
                                                    <option value="1">Active</option>
                                                    <option value="2">Disabled</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dataTables_scroll">
                                        <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                            <div class="dataTables_scrollHeadInner" >
                                                <table class="table table-bordered table-striped table-hover dataTable no-footer" role="grid">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 8.45px;" aria-label="#">#</th>
                                                            <th class="text-center sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 41.075px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                                                            <th class="text-center sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 61.525px;" aria-label="Mobile: activate to sort column ascending">Mobile</th>
                                                            <th class="text-center sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 192.163px;" aria-label="Email: activate to sort column ascending">Email</th>
                                                            <th class="text-center sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 89.75px;" aria-label="Subscription: activate to sort column ascending">Subscription</th>
                                                            <th class="text-center sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 44.7125px;" aria-label="Status: activate to sort column ascending">Status</th>
                                                            <th class="text-center sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45.0625px;" aria-label="Action: activate to sort column ascending">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 400px; width: 100%;">
                                            <table id="dataTable" class="table table-bordered table-striped table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row" style="height: 0px;">
                                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 8.45px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="#">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">#</div>
                                                        </th>
                                                        <th class="text-center sorting_asc" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 41.075px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Name</div>
                                                        </th>
                                                        <th class="text-center sorting" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 61.525px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Mobile: activate to sort column ascending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Mobile</div>
                                                        </th>
                                                        <th class="text-center sorting" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 192.163px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Email: activate to sort column ascending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Email</div>
                                                        </th>
                                                        <th class="text-center sorting" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 89.75px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Subscription: activate to sort column ascending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Subscription</div>
                                                        </th>
                                                        <th class="text-center sorting" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 44.7125px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Status: activate to sort column ascending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Status</div>
                                                        </th>
                                                        <th class="text-center sorting" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45.0625px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Action: activate to sort column ascending">
                                                            <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Action</div>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <!-- Your existing code for table rows -->
                                                    {{-- <tr role="row" class="odd">
                                                        <td>1</td>
                                                        <td class="text-center sorting_1">AMLAN BHUYAN</td>
                                                        <td class=" text-center">9127022438</td>
                                                        <td class=" text-center">AMLAN17BHUYAN@GMAIL.COM</td>
                                                        <td class=" text-center"><span class="badge bg-warning">NO</span></td>
                                                        <td class=" text-center"><span class="badge bg-success">ACTIVE</span></td>
                                                        <td class=" text-center"><a href="https://ptg.privatech.in/admin/clients/view/1" class="btn btn-outline-info btn-xs">VIEW</a></td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="dataTable_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="dataTable_info" role="status"
                                        aria-live="polite">Showing 1 to 1 of 1 entries</div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers float-right"
                                        id="dataTable_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous disabled"
                                id="dataTable_previous"><a href="#" aria-controls="dataTable"
                                                    data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                            <li class="paginate_button page-item active"><a href="#"
                                                    aria-controls="dataTable" data-dt-idx="1" tabindex="0"
                                                    class="page-link">1</a></li>
                                            <li class="paginate_button page-item next disabled"
                                                id="dataTable_next"><a href="#" aria-controls="dataTable"
                                                    data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
