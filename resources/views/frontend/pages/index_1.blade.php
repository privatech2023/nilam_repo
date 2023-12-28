@extends('frontend.template.main')

@section('main-container')


<div class="content-wrapper remove-background">

    <!-- Main content -->
    <div class="content">
        <div class="container ">
            <div class="row">

                <div class="col-lg-12">

                    <section class="content" style="margin-top:2rem">

                        <div class="container-fluid">

                            <!-- Info boxes -->
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="row">

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">

                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-sms.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">SMS</span>
                                                </div>
                            
                                            </div>

                                            <!-- /.info-box -->
                                        </div>

                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-contact.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Contacts</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-camera.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Camera</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-location.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Location</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-call-logs.svg')}}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Call Logs</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-filemanager.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">File Manager</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-vibrate.svg')}}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Vibrate</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-lostmessage.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Lost Message</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->


                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-audio-record.svg')}}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Audio Record</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-alert.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Alert Device</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-screen-record.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Screen Record</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-video-record.svg') }}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Video Record</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                        <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                            <div class="info-box" id="app-icon">
                                                <div class="widget-user widget-user-image">
                                                    <img class="android-icon"
                                                        src="{{ url('assets/frontend/images/icons/android-gallery.svg')}}"
                                                        class="info-box-icon img-circle elevation-2" alt="User Image">
                                                </div>

                                                <div class="info-box-content text-center" id="app-icon-title">
                                                    <span class="info-box-text text-white">Gallery</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->

                                    </div> <!-- /.col-lg-6 -->

                                </div>
                                <!-- /.row -->




                            </div>

                        </div>
                        <!--/. container-fluid -->
                    </section>




                </div>

            </div>




        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="modal fade" role="dialog" id="modal-default">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-gray-light">

                <div class="modal-header">
                    <h4 class="modal-title text-center">Sign in to start your session</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="loader_bg" style="display:none;">
                        <div id="loader"></div>
                    </div>

                    <!-- Check User Form -->
                    <div id="step-user">

                        <span id="message"></span>

                        <form method="post" id="userForm">

                            <div class="input-group mb-1">

                                <input type="text" name="user_id" id="user" class="form-control"
                                    placeholder="Email/Mobile No">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <span id="user_error" class="text-danger"></span>

                            <div class="row">
                                <div class="col-8"></div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" onClick="submitUserForm()" id="userFormBtn"
                                        class="btn btn-success btn-block btn-sm">Log In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div><!-- User Form End -->

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->









</div>

<script>
$(document).ready(function() {

    //defaule hide email login btn 
    //hide mobile-part

    $('#mobile-part').hide();
    $('#emailBtn').hide();

    $(".info-box").click(function() {

        $("#modal-default").modal({
            backdrop: 'static',
            keyboard: false
        });

    });

    $("#modal-default").on("hidden.bs.modal", function() {
        $('#user_error').html('');
        $('#userForm')[0].reset();
    });

});

function submitUserForm() {

    $('#userForm').on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ url('')}}check/client",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {

                $('.loader_bg').show();
                $('#userFormBtn').attr('disabled', 'disabled');
            },
            success: function(data) {
                $('.loader_bg').hide();
                if (data.error) {

                    if (data.user_error != '') {
                        $('#user_error').html(data.user_error);
                    } else {
                        $('#user_error').html('');
                    }

                }
                if (data.success) {

                    $('#message').html(data.message);
                    setTimeout(function() {
                        $('.loader_bg').show();
                        window.location.href =
                            "{{ url('login')}}";
                    }, 1000);

                }

                if (data.info) {

                    $('#message').html(data.message);
                    setTimeout(function() {
                        $('.loader_bg').show();
                        window.location.href =
                            "{{ url('register')}}";
                    }, 1000);

                }

                $('#userFormBtn').attr('disabled', false);
            },
            error: function() {

                $('.loader_bg').hide();
                $('#userForm')[0].reset();
                alert("Server Error !");
                $('#userFormBtn').attr('disabled', false);

            }

        })

    });
}
</script>



















@endsection