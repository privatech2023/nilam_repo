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
        <div class="image-container">
            @foreach($images as $image)
            <div style="position: relative; display: inline-block;">
                <a href="{{ $image->s3Url() }}" data-lightbox="photo"
                    data-title="{{ $image->created_at->format('M d, Y h:i A') }}">
                <img src="{{ $image->s3Url() }}" alt="Random Image" style="width: 165px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
                </a>
                <button id="delete" data-id="{{ $image->id }}" style="position: absolute; top: 3px; right: 2px; padding: 4px; background-color: rgb(141, 60, 228); color: white; border: none; border-radius: 10%; cursor: pointer; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);">
                    <i class="fas fa-times"></i>
                </button>
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
            setInterval(function() {
        $('#myModalconf').modal('hide');
        $('#deleteModal').modal('hide');
            document.getElementById('cont-refresh-component-specific').click();
        }, 8000);
        $(document).on('click','#delete', function () {
            var id = this.getAttribute('data-id');
                document.getElementById('deleteItemId').value = id;
                $('#deleteModal').modal('show');
        });
    });
</script>
</div>
    
    
    