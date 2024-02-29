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

<div class="content-wrapper remove-background">
    <div id="frame">

        <div class="loader_bg" style="display:none;">
            <div id="loader"></div>
        </div>
        <nav class="navbar navbar-light bg-light">
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
                <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5"/>
                <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3"/>
              </svg>  AUDIO RECORD</span>
              <button class="btn btn-outline-success" type="button" wire:click="recordVoice" onclick="load()">Record Audio</button>
              <button class="btn btn-outline-success btn-sm"  wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
        </nav>

        <div style="display: flex; margin-top: 20px; margin-left: 10px;" class="audio">
            <div>
                @foreach ($recordings as $recording)
                <div class="border-2 p-1 rounded-md">
                    
                    <div class="flex justify-end">
                    </div>
                    <audio controls="" class="w-full">
                        <source src="{{ $recording->s3Url() }}" class="bg-blue-500" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <p class="text-center text-sm pt-2">
                        {{ $recording->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    </div>
    <script>
        function load() {
            $('.loader_bg').show();
        }
    </script>
    <script>
        document.addEventListener('livewire:load', function () {
            $('.loader_bg').hide();
        });
    </script>
</div>

