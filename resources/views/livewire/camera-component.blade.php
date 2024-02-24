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
    <div id="frame">

 {{-- modal delete --}}
 <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Are you sure you want to delete this item ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('/delete/image')}}" method="post">
            @csrf
        <div class="modal-footer">
            <input type="text" name="id" id="deleteItemId" value=""/>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-primary">Yes</button>
        </div>
    </form>
      </div>
    </div>
</div>


        <nav class="navbar navbar-light bg-light">
            <button class="btn btn-outline-success" type="button" wire:click="takePicture" onclick="load()">Take picture</button>
            <button class="btn btn-sm btn-outline btn-primary" style="width:3.8rem; font-size: 0.8em;"  wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" type="button">Refresh</button>
        </nav>
        <div class="loader_bg" style="display:none;">
            <div id="loader"></div>
        </div>
        <div class="image-container" style="overflow: auto;">
            {{-- @foreach($images as $image)
            <a href="{{ $image->s3Url() }}" data-lightbox="photo"
                data-title="{{ $image->created_at->format('M d, Y h:i A') }}">
            <img src="{{ $image->s3Url() }}" alt="tools" style="width: 160px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
            </a>
            @endforeach --}}

            <style>
                .image-wrapper {
    position: relative;
    display: inline-block;
    margin-right: 10px;
    border-radius: 6px;
}

.image-item {
    width: 170px;
    height: 170px;
    object-fit: cover;
}

.button-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0; 
    transition: opacity 0.3s ease; 
}

.overlay-button {
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    padding: 5px;
    border-radius: 50%;
    margin: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Add transition effect */
}

.view-button {
    color: rgb(1, 136, 1); /* Color for "view" icon */
}

.delete-btn {
    color: rgb(197, 5, 5); /* Color for "delete" icon */
}

.image-wrapper:hover .button-container {
    opacity: 1; /* Show buttons on hover */
}
.image-wrapper:hover .button-container {
    display: block; /* Show buttons on hover */
}

            </style>
            @foreach($images as $image)
            <div class="image-wrapper">
                <img src="{{ $image->s3Url() }}" alt="tools" class="image-item" >
                <div class="button-container">
                    <a href="{{ $image->s3Url() }}" data-lightbox="photo" data-title="{{ $image->created_at->format('M d, Y h:i A') }}" class="overlay-button view-button"><i class="fas fa-eye"></i></a>
                    <i class="fas fa-trash-alt delete-btn"><button class="overlay-button delete" data-id="{{ $image->id }}"></button></i>
                </div>
            </div>
            @endforeach
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
            $('.loader_bg').hide();

        $(document).on('click','.delete', function () {
            var id = this.getAttribute('data-id');
                document.getElementById('deleteItemId').value = id;
                $('#deleteModal').modal('show');
        });
    });
</script>
</div>
    
    
    