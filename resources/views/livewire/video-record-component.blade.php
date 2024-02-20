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
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-record" viewBox="0 0 16 16">
                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10"/>
            </svg>VIDEO RECORD</span>
            <button class="btn btn-outline-success" type="button" wire:click="recordVideo" onclick="load()">Record Video</button>
            <button class="btn btn-outline-success btn-sm" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
        </nav>


        {{-- <div style="margin-top: 20px; margin-left: 20px;" id="screen">
            <div>
                <div class="border-2 p-1 rounded-md" style="position: relative; padding-bottom: 56.25%; /* 16:9 aspect ratio */">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; " src="https://www.youtube.com/embed/jNQXAC9IVRw" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div> --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-2 sm:p-0 mt-6" style="overflow-x: auto; height:83%;">
        {{-- <div style="margin-top: 20px; margin-left: 20px; overflow-x: auto; height:83%;" id="screen"> --}}
            {{-- <div> --}}
                <div class="border-2 p-1 rounded-md">
                    <style>
                        .video-container {
                            position: relative;
                            padding-bottom: 56.25%; 
                            padding-top: 30px;
                            height: 0;
                            overflow: hidden;
                        }
        
                        .video-container video {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                        }

                        @media screen and (max-width: 768px) {
                    .video-container {
                        padding-bottom: 75%; 
                        width: 22rem;
                    }
                }
                    </style>

                    @foreach($videos as $video)
                    <div class="video-container" style="margin-top:1rem;">
                    <video controls class="w-full">
                        <source src="{{$video->s3Url()}}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    </div>
                    {{-- <div class="video-container" style="margin-top:1rem;">
                        <video controls class="w-full">
                            <source src="https://samplelib.com/lib/preview/mp4/sample-10s.mp4" type="video/mp4">
                            Your browser does not support the video element.
                        </video>
                    </div> --}}
                    @endforeach
                </div>
            {{-- </div> --}}
        {{-- </div> --}}
    </div>
        
    </div>

    </div>
    <script>
        function load() {
            $('.loader_bg').show();
        }
    </script>
    <script>
        document.addEventListener("livewire:load", function () {
            $('.loader-bg').hide();
            setInterval(function() {
        $('#myModalconf').modal('hide');
        console.log('hey')
            document.getElementById('cont-refresh-component-specific').click();
        }, 10000);
        });
    </script>
</div>
    
    





