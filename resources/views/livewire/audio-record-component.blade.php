<div>
@if(session('user_name'))
<div class="row mt-3 welcome">
    <div class="col-9 ">
        <h2 class="welcome-text">Welcome, {{session('user_name')}}</h2>
    </div>
    <div>
        <span class="text-md breadcrumb-text"><a href="{{ url('/')}}">Home </a>/ Dashboard</span>
    </div>
</div>

@endif

<div class="content-wrapper remove-background">
    <div id="frame">
        <nav class="navbar navbar-light bg-light">
            
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
                <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5"/>
                <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3"/>
              </svg>  AUDIO RECORD</span>
              <button class="btn btn-outline-success" type="button" wire:click="recordVoice">Record Audio</button>
        </nav>
        {{-- <nav class="navbar navbar-light bg-light">
              
              
        </nav> --}}
        <div style="display: flex; margin-top: 20px; margin-left: 10px;" class="audio">
            <div>
                <div class="border-2 p-1 rounded-md">
                    
                    {{-- <div class="flex justify-end">
                    </div>
                    <audio controls="" class="w-full">
                        <source src="https://rts-storage.s3.ap-south-1.amazonaws.com/recordings/uid-65771-909754e2-69ce-49bb-bed7-92d74f349e13.aac?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIA2O722WGNNE6YMVNK%2F20240124%2Fap-south-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20240124T061328Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=300&amp;X-Amz-Signature=f33296197a237e829fce766e6227ae2f289002f2c632ca8ee92cdad6e01792e9" class="bg-blue-500" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <p class="text-center text-sm pt-2">
                        Jan 24, 2024 11:35 AM
                    </p> --}}
                </div>
            </div>
        </div>
    </div>

    </div>
    
</div>
    


