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
        <nav class="navbar navbar-light bg-light">
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-record" viewBox="0 0 16 16">
                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10"/>
              </svg>VIDEO RECORD</span>
              <button class="btn btn-outline-success" type="button" wire:click="recordVideo">Record Video</button>
        </nav>
        {{-- <nav class="navbar navbar-light bg-light">
              
             
        </nav> --}}
        <div style=" margin-top: 20px; margin-left: 20px;" id="screen">
            <div>
                <div class="border-2 p-1 rounded-md">
                    
                    @foreach($videos as $video)
                    <video controls="" class="w-full">
                        <source src="{{ $video->s3Url() }}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    </div>
    
</div>
    
    





