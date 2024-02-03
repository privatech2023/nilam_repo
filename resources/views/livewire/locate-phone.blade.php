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
        <nav class="navbar navbar-light bg-light">           
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
              </svg>LOCATE PHONE</span>
        </nav>
        <nav class="navbar navbar-light bg-light">
              <button class="btn btn-outline-primary" wire:click="locatePhone" type="button">Locate phone</button>
              <button class="btn btn-outline-success hidden" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
        </nav>
        <div style=" margin-top: 20px; margin-left: 20px;" >
            <div class="row">
                
                <div class="mt-3">
                    @php
                        $api_key = config('services.google_maps.key');
                    @endphp
                    <iframe 
                        width="1065px" class="iframe" height="430px" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?key={{ $api_key }}&q={{ $lat }},+{{ $lng }}"
                        allowfullscreen
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
    </div>

    </div>
    <script>
        // Refresh device status every 3 seconds
        setInterval(function() {
            document.getElementById('cont-refresh-component-specific').click();
        }, 3000);
    </script>
</div>
    
    



