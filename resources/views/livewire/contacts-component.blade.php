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
        @if($contactsCount == 0)
            <div class="container">
                <span class="message-text">No contacts found</span>
            </div>
        @else

        <div id="frame">        
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap">
                        <p class="lead text-md">CONTACTS ({{$contactsCount}})</p>
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
                        <div class="text-right" >
                            <div class="butts">
                            <button  type="button" class="btn btn-sm btn-primary hide-btn" wire:click="SyncContacts">Sync contacts</button>
                            </div>
                            
                        </div> 
                    </div> 
                    <div class="sec-center" style="align-items:right;"> 	
                        <input class="dropdown"  type="checkbox"  id="dropdown" name="dropdown"/>
                        <label class="for-dropdown" for="dropdown">Menu <i class="uil uil-arrow-down"></i></label>
                        <div class="section-dropdown"> 
                            <div class="a" style="cursor: pointer;" wire:click="SyncContacts">Sync contacts <i class="uil uil-arrow-right"></i></div>
                            <input class="dropdown-sub" type="checkbox" id="dropdown-sub" name="dropdown-sub"/>
                        </div>
                    </div>               
                </div>
                <div class="messages">
                    @if($selectedKey)
                    @livewire('contacts-populate', ['key' => $selectedKey], key($selectedKey))
                    @endif
                </div>
            </div>
        </div>
        @endif    
        </div>
        <script>
        document.addEventListener("livewire:load", function () {
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
    });
    </script>
    
        
    </div>
        
        
    