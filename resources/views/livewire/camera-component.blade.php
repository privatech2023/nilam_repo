@if(session('user_name'))
<div class="row mt-3 welcome">
    <div class="col-9 ">
        <h2 class="welcome-text">Welcome, {{session('user_name')}}</h2>
    </div>
    <div>
        @livewire('dropdown')
    </div>
</div>

@endif

<div class="content-wrapper remove-background">
    <div id="frame">
        <nav class="navbar navbar-light bg-light">
              <button class="btn btn-outline-success" type="button">Capture image</button>
              
        </nav>
        <div style=" margin-top: 20px; margin-left: 10px;">
            <img src="https://picsum.photos/100/100" alt="Placeholder Image 1" style="width: 160px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
            <img src="https://picsum.photos/100/101" alt="Placeholder Image 2" style="width: 160px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
            <img src="https://picsum.photos/100/102" alt="Placeholder Image 3" style="width: 160px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
            <!-- Add more images as needed -->
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
    
    

