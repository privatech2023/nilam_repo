<div>

    <div class="bread" >
        <div >
            <a href="{{url('/')}}" style="text-decoration: none;">
                <button type="button" class="btn btn-md" style="margin-top: 7px; background-color: #60377b; border-radius: 30px; color: white; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                    </svg>
                </button>
            </a>
        </div>
        
            @livewire('dropdown')
    </div>
    {{-- <hr style="width: 100%; border-top: 1px solid #311c39;"> --}}
    {{-- <div class="row" style="display:inline-block; text-align: center; margin-top: 1rem; width:100%;">
    <button  type="button" class="btn btn-sm " style=" background-color: #60377b; border-radius: 10px; color: white; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" wire:click="syncInbox">Sync inbox</button>
    <button  type="button" class="btn btn-sm  " style="margin-left:2rem; margin-right:2rem;  background-color: #60377b; border-radius: 10px; color: white; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" wire:click="syncOutbox">Sync outbox</button>
    <button class="btn btn-sm " style=" background-color: #60377b; border-radius: 10px; color: white; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</button>
    </div> --}}
    {{-- <hr style="width: 100%; border-top: 1px solid #311c39;"> --}}
<div class="content-wrapper remove-background">
    
    @if($msgCount == 0)
    
    <div class="container">
        <span class="message-text">No messages found<br><br>
        <button type="button" class="btn btn-sm btn-primary " wire:click="syncInbox">Sync inbox</button>
        <button type="button" class="btn btn-sm btn-primary" wire:click="syncOutbox">Sync outbox</button>
        <button class="btn btn-outline-success btn-sm" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
    </span>
    </div>
    @else
    <div id="frame">        
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <p class="lead text-sm">MESSAGES ({{$msgCount}})</p>
                    <button  type="button" class="btn btn-sm btn-outline btn-primary" style="width:5rem; margin-left: 6px; font-size: 0.8em;"  wire:click="syncInbox">Sync inbox</button>
    <button  type="button" class="btn btn-sm btn-outline btn-primary" style="width: 5rem; font-size: 0.75em;" wire:click="syncOutbox">Sync outbox</button>
    <button class="btn btn-sm btn-outline btn-primary" style="width:4rem; font-size: 0.8em;"  wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</button>
                </div>
                
            </div>
            <div id="contacts">
                <ul>
                    @foreach($messageList as $key => $value)
                        <li class="contact" wire:click="populateMessage('{{ $key }}')" onclick="handleClick(this)">
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
                <div class="bttns">
                    <button id="backButton" type="button" class="btn btn-outline-secondary" wire:click="backButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </button>
                    <div class="to text-sm">
                    <p class="text-secondary" style="margin-left: 5px;">To:</p> 
                    <p style="margin-left: 5px;">{{ $selectedKey}}</p>
                    </div>
                </div> 
                {{-- <div class="sec-center" style="align-items:right;"> 	
                    <input class="dropdown"  type="checkbox"  id="dropdown" name="dropdown"/>
                    <label class="for-dropdown" for="dropdown">Menu <i class="uil uil-arrow-down"></i></label>
                    <div class="section-dropdown"> 
                        <div class="a" style="cursor: pointer;" wire:click="syncInbox">Sync inbox <i class="uil uil-arrow-right"></i></div>
                        <div class="a" style="cursor: pointer;" wire:click="syncOutbox">Sync outbox<i class="uil uil-arrow-right"></i></div>
                        <div class="a" style="cursor: pointer;" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</div>
                    </div>
                </div>                --}}
            </div>
            <div class="messages">
                @if($selectedKey)
                    @livewire('message-populate', ['key' => $selectedKey], key($selectedKey))
                @else
                <span class="text-sm " style="margin-left:5px;">NO MESSAGES</span>
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
    @endif
    </div>
    <script>
        let isLivewireEventInProgress = false;

        function handleClick(element) {
    // Disable further clicks for 2 seconds
    element.disabled = true;
    setTimeout(function () {
        element.disabled = false;
    }, 3000);
}
    document.addEventListener("livewire:load", function () {
    var screenWidth = window.innerWidth;
    var isContentOpen = false;
    var isProcessing = false;
    
    Livewire.on('toggleSidepanel', function () {
        if (!isProcessing) {
            isProcessing = true;

            if (screenWidth <= 760 && !isContentOpen) {
            $('#frame #sidepanel').css('width', '0px');
            isContentOpen = true;
            console.log('hey');
        }
        $('#frame .content').attr('id', 'content');

            isProcessing = false;
        }
    });


    Livewire.on('back', () => {
        if (isContentOpen) {
            $('#frame #sidepanel').css('width', '100%');
            $('#frame .content').removeAttr('id');
            isContentOpen = false;
        }
    });
});

document.addEventListener('livewire:load', function () {
        Livewire.on('refreshComponent', function () {
            Livewire.emit('refresh'); 
            location.reload();
        });
    });
</script>
    
</div>
    
    
