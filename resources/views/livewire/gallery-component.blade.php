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
                    <p>Albums(2)</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="Search " />
            </div>
            <div id="contacts">
                <ul>
                    <li class="contact" >
                        <div class="wrap" style="height: 5rem; width: 100%; display: flex; align-items: center; margin-left: 20px;">
                            <img src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000089383?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" style="border-radius: 0; height: 5rem; width: 5rem;" alt="" />
                            <div class="meta" style="margin-left: 10px;">
                                <p class="name">Camera</p>
                                <p class="preview">(172)</p>
                            </div>
                        </div>
                        
                        
                    </li>
                    <li class="contact" >
                        <div class="wrap" style="height: 5rem; width: 100%; display: flex; align-items: center; margin-left: 10px;  margin-left: 20px;">
                            <img src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000082312?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" style="border-radius: 0; height: 5rem; width: 5rem;" alt="" />
                            <div class="meta" style="margin-left: 10px;">
                                <p class="name">Snaps</p>
                                <p class="preview">(172)</p>
                            </div>
                        </div>
                        
                        
                    </li>

                    {{-- <div tabindex="0" role="button" class="i-width100p vh-item vh-item-selected" title="Folder:WallCandy
Photos:1" bucketid="123002075" bucketname="WallCandy">
    <div class="vh-item-thumb-wrapper i-float-left">
        <img aria-hidden="true" imgsrc="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000082312?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" width="62" height="62" src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000082312?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1">
    </div>
    <div style="padding-top: 15px;">
        <div class="name over-ellipsis">WallCandy</div>
        <div><div class="mod-photo-folderNum">1</div>item(s)</div>
        <div></div>
    </div>
</div> --}}

                    {{-- <div tabindex="0" role="button" class="i-width100p vh-item" title="Folder:Facebook
                    Photos:68" bucketid="-532863272" bucketname="Facebook">
                    <div class="vh-item-thumb-wrapper i-float-left">
                    <img aria-hidden="true" imgsrc="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000089383?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" width="62" height="62" src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000089383?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1">
                    </div>
                    <div style="padding-top: 15px;">
                        <div class="name over-ellipsis">Facebook</div>
                    <div><div class="mod-photo-folderNum">68</div>item(s)</div>
                    <div></div>
                    </div>
                    </div> --}}
                </ul>
            </div>
            {{-- <div id="bottom-bar">
                <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
                <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
            </div> --}}
        </div>
        <div class="content">
            <div class="contact-profile">
                <div style="margin-left: 10px;">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                  </svg></p> 
                </div>                
                <div class="text-right" style="margin-right: 8px;">
                    <button type="button" class="btn btn-outline-primary">Download</button>
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
                <nav class="navbar navbar-light bg-light">
            
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          select all
                        </label>
                      </div>
                </nav>
                <ul>
                   
                    
                </ul>
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
    
    
