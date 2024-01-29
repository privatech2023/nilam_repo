<div>
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
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap-1">
                    <p>Contacts with number(2)</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="search..." />
            </div>
            <div id="contacts">
                <ul>
                    <li class="contact" wire:click="populateProfile('{{ 23 }}')">
                        <div class="wrap">
                            <span class="contact-status"></span>
                            <img src="#" alt="" />
                            <div class="meta">
                                <p class="name">ABC</p>
                                <p class="preview">ABSAJ AJH ASJ</p>
                            </div>
                        </div>
                    </li>
                    <li class="contact" wire:click="populateProfile('{{ 23 }}')">
                        <div class="wrap">
                            <span class="contact-status busy"></span>
                            <img src="#" alt="" />
                            <div class="meta">
                                <p class="name">XXXX</p>
                                <p class="preview">Wrong. You take the gun, or you pull out a bigger one. </p>
                            </div>
                        </div>
                    </li>
                    
                    
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="contact-profile">
                <div style="margin-left: 10px;">
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                      </svg>abc</p>  
                </div>             
                
                
            </div>
            <div class="messages">
                @if($profile)
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
                  @endif
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

    </div>
    
    
