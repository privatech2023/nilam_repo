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
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap-1">
                    <p>Files(10)</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="search" />
            </div>
            <div id="contacts">
                <ul>
                    
                    
                    
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="contact-profile">
                {{-- <div style="margin-left: 10px;">
                    <p class="text-secondary">To:</p> 
                    <p style="margin-left: 5px;">ABC</p>
                </div>                --}}
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
                
            </div>
            <div class="messages">
                
            </div>
            <div class="message-input">
                <div class="wrap">
                <input type="text" placeholder="Write your message..." />
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
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
    
    
