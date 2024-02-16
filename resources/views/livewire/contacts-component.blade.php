<div>
    <div class="bread" style="display:flex;">
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
    <div class="content-wrapper remove-background">

        {{-- mod --}}
    <div id="myModalconf" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">			
                    <h4 class="modal-title">Failed to fetch contacts</h4>	
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p>Please allow device permissions to access messages</p>
                    <img src="{{ asset('assets/frontend/images/app1.jpeg') }}" alt="Mobile Screenshot" class="img-fluid smaller-image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

        <div class="loader_bg" style="display:none;">
            <div id="loader"></div>
        </div>
        @if($contactsCount == 0)
        <div class="container">
            <span class="message-text">No contacts found<br><br>
                <button  type="button" class="btn btn-sm btn-primary" wire:click="SyncContacts" onclick="load()">Sync contacts</button>
                <button class="btn btn-outline-success btn-sm" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
        </span>
        </div>
        @else
        <div id="frame">        
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap" style="margin-left: 0px;">
                        <p class="lead text-md" style="margin-left: 0px;">CONTACTS({{$contactsCount}})</p>
                        <button  type="button" class="btn btn-sm btn-outline btn-primary" style="width:6rem; margin-left: 0.5rem; font-size: 0.7em;" wire:click="SyncContacts" onclick="load()">Sync contacts</button>
                        <button class="btn btn-sm btn-outline btn-primary" style="width:3.8rem; font-size: 0.7em;"  wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</button>
                    </div>
                </div>
                <div id="contacts">
                    <ul>
                        @foreach($contactsList as $contact)
                        <li class="contact" wire:click="populateContacts('{{ $contact->number }}')" >
                            <div class="wrap">
                                <div class="meta">
                                    <p class="name">{{ $contact->name }}</p>
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
                        <p style="margin-left: 5px;">{{ $selectedKey}}</p>
                        </div>
                        {{-- <div class="text-right" >
                            <div class="butts">
                            <button  type="button" class="btn btn-sm btn-primary hide-btn" wire:click="SyncContacts">Sync contacts</button>
                            <button class="btn btn-outline-success btn-sm hide-btn" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
                            </div>
                            
                        </div>  --}}
                    </div> 
                    {{-- <div class="sec-center" style="align-items:right;"> 	
                        <input class="dropdown"  type="checkbox"  id="dropdown" name="dropdown"/>
                        <label class="for-dropdown" for="dropdown">Menu <i class="uil uil-arrow-down"></i></label>
                        <div class="section-dropdown"> 
                            <div class="a" style="cursor: pointer;" wire:click="SyncContacts">Sync contacts <i class="uil uil-arrow-right"></i></div>
                            <div class="a" style="cursor: pointer;" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</div>
                        </div>
                    </div>                --}}
                </div>
                <div class="messages">
                    @if($selectedKey)
                    @livewire('contacts-populate', ['key' => $selectedKey], key($selectedKey))
                    @else
                    <span class="text-sm" style="margin-left:5px;"></span>
                    @endif
                </div>
            </div>
        </div>
        @endif    
        </div>
        <script>
            function load() {
                $('.loader_bg').show();
            }
        </script>
        <script>
        document.addEventListener("livewire:load", function () {
            $('.loader_bg').hide();

            var contactsCount = '{{ $contactsCount}}'
    if(contactsCount == 0){
        $('#myModalconf').modal('show');
    }
        var screenWidth = window.innerWidth;
        var isContentOpen = false;
    
        Livewire.on('toggleSidepanel', () => {
            if (screenWidth <= 760 && !isContentOpen) {
                $('#frame #sidepanel').css('width', '1px');
                isContentOpen = true;
                console.log('hey');
            }
            $('#frame .content').attr('id', 'content');
            });
    
        Livewire.on('back', () => {
            if (isContentOpen) {
                $('#frame #sidepanel').css('width', '100%');
                $('#frame .content').removeAttr('id');
                isContentOpen = false;
            }
        });
        if(isContentOpen == false){
    setInterval(function() {
        $('#myModalconf').modal('hide');
            document.getElementById('cont-refresh-component-specific').click();
        }, 4000);
}
    });
    </script>
    
    </div>
        
        
    