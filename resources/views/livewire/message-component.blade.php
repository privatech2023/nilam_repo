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
                <div class="wrap">
                    <p>MESSAGES (2)</p>
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
                        <hr>
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
                    <input class="dropdown"  type="checkbox"  id="dropdown" name="dropdown"/>
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
                    <button  type="button" class="btn btn-sm btn-primary hide-btn" wire:click="syncInbox">Sync outbox</button>
                    <button  type="button" class="btn btn-sm btn-outline-primary hide-btn">New message</button>
                </div>                
            </div>
            <div class="messages">
                @if($selectedKey)
                    @livewire('message-populate', ['key' => $selectedKey], key($selectedKey))
                    <ul>
                    <li class="replies">
                        <img src="#" alt="" />
                        <p>HI asdkj jkwq kjx as jksa</p>
                    </li>
                </ul>
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
    <script>
        document.addEventListener('livewire:load', function () {
            var screenWidth = window.innerWidth;
            var screenHeight = window.innerHeight;

            console.log('Screen Width: ' + screenWidth + 'px');
            console.log('Screen Height: ' + screenHeight + 'px');

                $('#contacts').on('click', 'li.contact', function () {
                    $('#frame .content').attr('id', 'content');
                    $('#frame .sidepanel').attr('class','sidepanel');
                });
            
        });
    </script>
    
</div>
    
    
