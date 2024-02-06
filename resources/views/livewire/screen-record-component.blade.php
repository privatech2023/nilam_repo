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
        </nav>
        <nav class="navbar navbar-light bg-light">
              <button class="btn btn-outline-success" type="button" wire:click="recordScreen">Record Screen</button>
        </nav>
        <div style=" margin-top: 20px; margin-left: 20px;" id="screen">
            <div>
                <div class="border-2 p-1 rounded-md">
                    
                    {{-- <video controls="" class="w-full">
                        <source src="https://rts-storage.s3.ap-south-1.amazonaws.com/screen-recordings/uid-65771-53a025df-d475-4831-ac63-c4a1156ca0cf.mp4?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIA2O722WGNNE6YMVNK%2F20240124%2Fap-south-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20240124T070735Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=300&amp;X-Amz-Signature=3cb5a7a84a111c906cfb9f7f5e71e397de77f6538627ea62d9c6af7c7bb5cfd0" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    <p class="text-center text-sm pt-2">
                        Jan 24, 2024 12:37 PM
                    </p> --}}
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
    




