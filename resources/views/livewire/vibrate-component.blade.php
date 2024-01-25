@if(session('user_name'))
<div class="row mt-3 welcome">
    <div class="col-9 ">
        <h2 class="welcome-text">Welcome, {{session('user_name')}}</h2>
    </div>
    <div>
        <span class="text-md breadcrumb-text"><a href="{{ url('/')}}">Home </a>/ Dashboard</span>
    </div>
</div>

@endif

<div class="content-wrapper remove-background">
    <div id="frame">
        <nav class="navbar navbar-light bg-light">
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
              </svg>  VIBRATE</span>
        </nav>
        <nav class="navbar navbar-light bg-light">
              <button class="btn btn-outline-success" type="button">Record Audio</button>
              <div class="text-right" style="margin-right: 8px;">
                <div class="btn-group dropdown" >
                    <button type="button" class="btn btn-secondary dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Device
                    </button>
                    <div class="dropdown-menu">
                      @foreach ($devices as $device)
                        <a class="dropdown-item" href="#">{{ $device->device_name }}</a>
                      @endforeach
                    </div>
                  </div>
            </div>
        </nav>
        <div style=" margin-top: 20px; margin-left: 20px;" >
            <div class="row">
                <div class="">
                    <button class="button-29" role="button"><svg style="margin-right:6px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                        <path d="M8.997 1.665a1.13 1.13 0 0 0-1.994 0l-6.26 11.186a1.13 1.13 0 0 0 .997 1.664h12.52a1.13 1.13 0 0 0 .997-1.664L8.997 1.665zM8.28 12.856a1.1 1.1 0 0 0 1.438-.002l5.45-9.75a1.1 1.1 0 0 0-.718-1.844H3.55a1.1 1.1 0 0 0-.718 1.844l5.448 9.75zM8.997 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>  Start vibration</button>
                </div>
            </div>
            <div class="row" style="margin-top: 16px;">
                <div class="">
                    <button class="button-30" role="button"><svg style="margin-right:6px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                        <path d="M8.997 1.665a1.13 1.13 0 0 0-1.994 0l-6.26 11.186a1.13 1.13 0 0 0 .997 1.664h12.52a1.13 1.13 0 0 0 .997-1.664L8.997 1.665zM8.28 12.856a1.1 1.1 0 0 0 1.438-.002l5.45-9.75a1.1 1.1 0 0 0-.718-1.844H3.55a1.1 1.1 0 0 0-.718 1.844l5.448 9.75zM8.997 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>  Stop vibration</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="frame">     
        <div class="content">
            <div class="contact-profile">
                <img src="#" alt="" />
                <p>ABC</p>               
                <div class="text-right" style="margin-right: 8px;">
                    <div class="btn-group dropright" >
                        <button type="button" class="btn btn-secondary dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Device
                        </button>
                        <div class="dropdown-menu">
                        @foreach ($devices as $device)
                            <a class="dropdown-item" href="#">{{ $device->device_name }}</a>
                        @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="messages">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{url('assets/common/img/default_user.png')}}"
                            alt="User profile picture">
                      </div>
      
                      <h3 class="profile-username text-center">abc</h3>
      
      
                      <p class="text-muted text-center"></p>
                      <p class="text-muted text-center"></p>
      
                      <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-mobile-screen-button"></i></b><span class="text-md">Mobile number</span> <span class="float-right">7364836283</span>
                          </li>
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-envelope"></i></b><span class="text-md">Email</span> <span class="float-right">abc@abc.com</span>
                          </li>
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-receipt"></i></b><span class="text-md">Address</span> <span class="float-right">Address</span>
                          </li>
                      </ul>                
                    </div>                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
    </div> --}}
    </div>
    <script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");

        $("#profile-img").click(function() {
            $("#status-options").toggleClass("active");
        });
        
        $(".expand-button").click(function() {
          $("#profile").toggleClass("expanded");
            $("#contacts").toggleClass("expanded");
        });
        
        $("#status-options ul li").click(function() {
            $("#profile-img").removeClass();
            $("#status-online").removeClass("active");
            $("#status-away").removeClass("active");
            $("#status-busy").removeClass("active");
            $("#status-offline").removeClass("active");
            $(this).addClass("active");
            
            if($("#status-online").hasClass("active")) {
                $("#profile-img").addClass("online");
            } else if ($("#status-away").hasClass("active")) {
                $("#profile-img").addClass("away");
            } else if ($("#status-busy").hasClass("active")) {
                $("#profile-img").addClass("busy");
            } else if ($("#status-offline").hasClass("active")) {
                $("#profile-img").addClass("offline");
            } else {
                $("#profile-img").removeClass();
            };
            
            $("#status-options").removeClass("active");
        });
        
        function newMessage() {
            message = $(".message-input input").val();
            if($.trim(message) == '') {
                return false;
            }
            $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
            $('.message-input input').val(null);
            $('.contact.active .preview').html('<span>You: </span>' + message);
            $(".messages").animate({ scrollTop: $(document).height() }, "fast");
        };
        
        $('.submit').click(function() {
          newMessage();
        });
        
        $(window).on('keydown', function(e) {
          if (e.which == 13) {
            newMessage();
            return false;
          }
        });
        //# sourceURL=pen.js
        </script>
    
    



