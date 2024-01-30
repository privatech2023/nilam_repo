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
                    <p>Messages(2)</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="Search contacts..." />
            </div>
            <div id="contacts">
                <ul>
                    @foreach($messageList as $key => $value)
                        <li class="contact" wire:click="populateMessage('{{ $key }}')" >
                        <div class="wrap">
                        <div class="meta">
                        <p class="name">{{ $key }}</p>
                        <p class="preview">{{ $messageList[$key][0]['body'] }}</p>
                        </div>
                        </div>
                        </li>
                    @endforeach                    
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="contact-profile">
                <div style="margin-left: 10px;">
                    <p class="text-secondary">To:</p> 
                    <p style="margin-left: 5px;">ABC</p>
                </div> 
                <div class="sec-center"> 	
                    <input class="dropdown" type="checkbox" id="dropdown" name="dropdown"/>
                    <label class="for-dropdown" for="dropdown">Menu <i class="uil uil-arrow-down"></i></label>
                    <div class="section-dropdown"> 
                        <a class="a" href="#">Sync inbox <i class="uil uil-arrow-right"></i></a>
                        <a class="a" href="#">Sync outbox <i class="uil uil-arrow-right"></i></a>
                        <a class="a" href="#">New message <i class="uil uil-arrow-right"></i></a>
                        <input class="dropdown-sub" type="checkbox" id="dropdown-sub" name="dropdown-sub"/>
                        <label class="for-dropdown-sub" for="dropdown-sub">Device <i class="uil uil-plus"></i></label>
                        <div class="section-dropdown-sub"> 
                            @foreach ($devices as $device)
                            <a class="a" href="#">{{ $device->device_name }}<i class="uil uil-arrow-right"></i></a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="text-right" style="margin-right: 8px;">
                    <button  type="button" class="btn btn-sm btn-primary hide-btn" wire:click="syncInbox">Sync inbox</button>
                    <button  type="button" class="btn btn-sm btn-primary hide-btn" wire:click="syncOutbox">Sync outbox</button>
                    <button  type="button" class="btn btn-sm btn-outline-primary hide-btn">New message</button>
                    {{-- <div  class="btn-group dropdown hide-btn" >
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Device
                        </button>
                        <div class="dropdown-menu">
                          @foreach ($devices as $device)
                            <a class="dropdown-item" href="#">{{ $device->device_name }}</a>
                          @endforeach
                        </div>
                    </div> --}}
                </div>                
            </div>
            <div class="messages">
                {{-- @if ($message)
                <ul>
                    <li class="sent">
                        <img src="#" alt="" />
                        <p>HELLO asdjh asjdk kjasdn</p>
                    </li>
                    <li class="replies">
                        <img src="#" alt="" />
                        <p>HI asdkj jkwq kjx as jksa</p>
                    </li>
                    <li class="replies">
                        <img src="#" alt="" />
                        <p>Hka</p>
                    </li>
                    <li class="sent">
                        <img src="#" alt="" />
                        <p>okay !</p>
                    </li>
                    
                </ul>
                @endif --}}
                @if($selectedKey)
                    @livewire('message-populate', ['key' => $selectedKey], key($selectedKey))
                @endif
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

        var count = 1
setTimeout(demo, 500)
setTimeout(demo, 700)
setTimeout(demo, 900)
setTimeout(reset, 2000)

setTimeout(demo, 2500)
setTimeout(demo, 2750)
setTimeout(demo, 3050)


var mousein = false
function demo() {
   if(mousein) return
   document.getElementById('demo' + count++)
      .classList.toggle('hover')
   
}

function demo2() {
   if(mousein) return
   document.getElementById('demo2')
      .classList.toggle('hover')
}

function reset() {
   count = 1
   var hovers = document.querySelectorAll('.hover')
   for(var i = 0; i < hovers.length; i++ ) {
      hovers[i].classList.remove('hover')
   }
}

document.addEventListener('mouseover', function() {
   mousein = true
   reset()
})
        </script>
</div>
    
    
