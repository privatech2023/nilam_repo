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

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Image View</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="modalImage" src="" class="img-fluid" alt="Image">
        </div>
      </div>
    </div>
  </div>
  
  



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
            <input type="hidden" name="id" id="deleteItemId" value=""/>
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
    /* background-color: rgba(255, 255, 255, 0.5); */
    border: none;
    padding: 5px;
    /* border-radius: 50%; */
    margin: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, margin 0.3s ease; /* Add margin to transition */
}

.view-button {
    color: white; 
}

.delete-btn {
    color: white;
}

.image-wrapper:hover .button-container {
    opacity: 1; 
}
.image-wrapper:hover .button-container {
    display: block; /* Show buttons on hover */
}


/* .modal-dialog {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    margin: 0;
} */
.modal-body {
    text-align: center;
}

#modalImage {
    max-width: 100%;
    max-height: 100%;
    display: inline-block;
}

            </style>
            @foreach($images as $image)
            <div class="image-wrapper">
                <img src="{{ $image->s3Url() }}" alt="tools" class="image-item" >
                <div class="button-container">
                    <button class="btn btn-info btn-sm view-button " style="width: 65px; padding: 0;" type="button" data-toggle="modal" data-target="#imageModal" data-src="{{ $image->s3Url() }}" >View</button>
                    <button class="btn-sm  overlay-button delete-btn delete" data-id="{{ $image->id }}" style="padding: 0; color:white; background-color: rgb(223, 83, 67); width: 55px; margin-top: 16px; margin-bottom: 0;" >Delete</button>
                </div>
                <p>{{ $image->created_at->format('M d, Y h:i A') }}</p>
            </div>
            @endforeach

            {{-- <div class="image-wrapper">
                <img src="https://picsum.photos/200" alt="tools" class="image-item" >
                <div class="button-container">
                    <button class="btn btn-info btn-sm view-button " style="width: 65px; padding: 0;" type="button" data-toggle="modal" data-target="#imageModal" data-src="https://picsum.photos/200" >View</button>
                    <button class="btn-sm  overlay-button delete-btn delete " data-id="1" style="padding: 0; color:white; background-color: rgb(223, 83, 67); width: 55px; margin-top: 16px; margin-bottom: 0;" >Delete</button>
                </div>
                <p>January 29, 2023</p>
            </div> --}}

            
            

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

        $('.view-button').click(function() {
            var imageUrl = $(this).data('src');
            $('#modalImage').attr('src', imageUrl);
        });
    });
</script>
</div>
    
    
    
