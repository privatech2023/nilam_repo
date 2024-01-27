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
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
                <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5"/>
                <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3"/>
              </svg>  AUDIO RECORD</span>
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
        <div style="display: flex; margin-top: 20px; margin-left: 10px;" class="audio">
            <div>
                <div class="border-2 p-1 rounded-md">
                    
                    <div class="flex justify-end">
                        {{-- <button wire:click="$emit('openModal', 'confirm-delete-modal', {&quot;route&quot;:&quot;client.voice-recorder.destroy&quot;,&quot;model_id&quot;:50875,&quot;model_name&quot;:&quot;Recording&quot;,&quot;action&quot;:&quot;delete&quot;})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button> --}}
                    </div>
                    <audio controls="" class="w-full">
                        <source src="https://rts-storage.s3.ap-south-1.amazonaws.com/recordings/uid-65771-909754e2-69ce-49bb-bed7-92d74f349e13.aac?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIA2O722WGNNE6YMVNK%2F20240124%2Fap-south-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20240124T061328Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=300&amp;X-Amz-Signature=f33296197a237e829fce766e6227ae2f289002f2c632ca8ee92cdad6e01792e9" class="bg-blue-500" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <p class="text-center text-sm pt-2">
                        Jan 24, 2024 11:35 AM
                    </p>
                </div>

                <div class="border-2 p-1 rounded-md">
                    
                    <div class="flex justify-end">
                        {{-- <button wire:click="$emit('openModal', 'confirm-delete-modal', {&quot;route&quot;:&quot;client.voice-recorder.destroy&quot;,&quot;model_id&quot;:50875,&quot;model_name&quot;:&quot;Recording&quot;,&quot;action&quot;:&quot;delete&quot;})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button> --}}
                    </div>
                    <audio controls="" class="w-full">
                        <source src="https://rts-storage.s3.ap-south-1.amazonaws.com/recordings/uid-65771-909754e2-69ce-49bb-bed7-92d74f349e13.aac?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIA2O722WGNNE6YMVNK%2F20240124%2Fap-south-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20240124T061328Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=300&amp;X-Amz-Signature=f33296197a237e829fce766e6227ae2f289002f2c632ca8ee92cdad6e01792e9" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <p class="text-center text-sm pt-2">
                        Jan 24, 2024 11:35 AM
                    </p>
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
    
    

