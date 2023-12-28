<!-- Logout Modal -->
<div class="modal fade" id="modal-logout">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Logout</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>

                <a href="<?php echo url('client/logout') ?>" class="btn btn-outline-light">Logout</a>
                <!--              <button type="button" class="btn btn-outline-light">Logout</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- Password Modal -->
<div class="modal fade" role="dialog" id="modal-password">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-gray-light">

            <div class="modal-header">
                <h4 class="modal-title text-center">Reset password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="loader_bg" style="display:none;">
                    <div id="loader"></div>
                </div>

                <span id="message"></span>

                <form method="post" id="passwordForm">


                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span id="password_error" class="text-danger"></span>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="passconf" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span id="passconf_error" class="text-danger"></span>

                    <div class="row">
                        <div class="col-8"></div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" onClick="resetPasswordForm()" id="passwordFormBtn"
                                class="btn btn-success btn-block btn-sm">Reset</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




</div><!-- Wrapper -->



@livewireScripts

    

    
    <script type="text/javascript" src="{{ url('assets/common/dist/js/adminlte.min.js')}}" ></script>   
 
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/bootstrap/js/bootstrap.bundle.min.js')}}" ></script>   
    
    <!-- ChartJS -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/chart.js/Chart.min.js')}}" ></script>   
    
    <!-- Sparkline -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/sparklines/sparkline.js')}}" ></script>   
    
    <!-- JQVMap -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/jqvmap/jquery.vmap.min.js')}}" ></script>   
    <script type="text/javascript" src="{{ url('assets/common/plugins/jqvmap/maps/jquery.vmap.usa.js')}}" ></script>   
    
    <!-- jQuery Knob Chart -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/jquery-knob/jquery.knob.min.js')}}" ></script>   
    
    <!-- daterangepicker -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/moment/moment.min.js')}}" ></script>   
    <script type="text/javascript" src="{{ url('assets/common/plugins/daterangepicker/daterangepicker.js')}}" ></script>   
    
    <!-- Tempusdominus Bootstrap 4 -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}" ></script>   
    
    <!-- Summernote -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/summernote/summernote-bs4.min.js')}}" ></script>   
    
    <!-- overlayScrollbars -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}" ></script>   
    
    <!-- AdminLTE App -->
    <script type="text/javascript" src="{{ url('assets/common/dist/js/adminlte.js')}}" ></script>   
    

    
    <!-- Nanobar -->
    <script type="text/javascript" src="{{ url('assets/common/dist/js/nanobar.js')}}" ></script>   

    <script>
    var simplebar = new Nanobar();
    simplebar.go(100);
    </script>


    <!-- DataTables -->
    <script type="text/javascript" src="{{ url('assets/common/plugins/datatables/jquery.dataTables.min.js')}}" ></script>   

    <script type="text/javascript" src="{{ url('assets/common/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" ></script>   
    
    <script type="text/javascript" src="{{ url('assets/common/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" ></script>   
    
    <script type="text/javascript" src="{{ url('assets/common/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" ></script>   

    <!--Datatable Button-->

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>



    </body>

    </html>