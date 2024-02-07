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
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-record" viewBox="0 0 16 16">
                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10"/>
              </svg>SCREEN RECORD</span>
              <button class="btn btn-outline-success" type="button" wire:click="recordScreen">Record Screen</button>
        </nav>
        {{-- <nav class="navbar navbar-light bg-light">
              
        </nav> --}}
        <div style=" margin-top: 20px; margin-left: 20px;" id="screen">
            <div>
                @foreach($screenRecordings as $recording)
                <div class="border-2 p-1 rounded-md">
                    <video controls="" class="w-full">
                        <source src="{{ $recording->s3Url() }}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    
                </div>
                @endforeach
            </div>
        </div>
    </div>

    </div>
</div>
    




