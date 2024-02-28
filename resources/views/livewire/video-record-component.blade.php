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
        
        
         {{-- modal delete --}}
 <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-md">Are you sure you want to delete this item ?</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('/delete/video')}}" method="post">
            @csrf
        <div class="modal-footer">
            <input type="hidden" name="id" id="deleteItemId" value=""/>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-primary">Yes</button>
        </div>
    </form>
      </div>
    </div>
</div>

        <nav class="navbar navbar-light bg-light">
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-record" viewBox="0 0 16 16">
                <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0 1A5 5 0 1 0 8 3a5 5 0 0 0 0 10"/>
            </svg>VIDEO RECORD</span>
            <button class="btn btn-outline-success" type="button" wire:click="recordVideo" onclick="load()">Record Video</button>
            <button class="btn btn-outline-success btn-sm" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
        </nav>

        <div class="border-2 p-1 rounded-md" style="display: flex; flex-wrap: wrap; gap: 10px; overflow-x: auto; height:83%;" >
            @foreach($videos as $video)
            <div class="video-container" >
                <video controls class="w-full h-full">
                    <source src="{{$video->s3Url()}}" type="video/mp4">
                    Your browser does not support the video element.
                </video>
                <p>
                    {{ $video->created_at->format('M d, Y h:i A') }}
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{$video->id}}">Delete</button>
                </p> 
            </div>
            @endforeach


            {{-- <div class="video-container" >
                <video controls class="w-full h-full">
                    <source src="https://storage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                    Your browser does not support the video element.
                </video>
                <p >
                    january 24, 2024
                    <button type="button" class="btn btn-sm btn-danger delete-btn"   onclick="deleteVideo(this)">Delete</button>
                </p>            
            </div> --}}





        </div>
        
        <style>
.delete-btn{
    margin-left: 60%;
    border-radius: 15px;
}
            .video-container {
    position: relative; /* Set position to relative */
    width: 46%; 
    height: auto; 
    overflow: hidden; 
}

.video-container p {
    /* position: absolute;  */
    bottom: 0;
    width: 100%;
    text-align: left;
    background-color: rgba(255, 255, 255, 0.7);
    margin: 0;
    padding: 5px 10px; 
    border-radius: 10px;
}

.video-container video {
    width: 100%; /* Set video width to 100% */
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(61, 34, 79, 0.5);
}

@media screen and (max-width: 1228px) {
    .video-container {
        width: 100%; 
    }

    .delete-btn{
    margin-left: 40%;
    border-radius: 15px;
}
}

        </style>
        
        
        
        
        
        
        
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
            $(document).on('click','.delete-btn', function () {
            var id = this.getAttribute('data-id');
                document.getElementById('deleteItemId').value = id;
                $('#deleteModal').modal('show');
        });
        });
    </script>
</div>
    
    





