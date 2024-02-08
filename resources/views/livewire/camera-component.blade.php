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
        <nav class="navbar navbar-light bg-light">
              <button class="btn btn-outline-success" type="button" wire:click="takePicture">Take picture</button>
        </nav>
        <div class="image-container">
            @foreach($images as $image)
            <a href="{{ $image->s3Url() }}" data-lightbox="photo"
                data-title="{{ $image->created_at->format('M d, Y h:i A') }}">
            <img src="{{ $image->s3Url() }}" alt="tools" style="width: 160px; height: 160px; object-fit: cover; margin-right: 10px; border-radius: 6px;">
            </a>
            @endforeach
        </div>
    </div>
</div>
</div>
    
    
    