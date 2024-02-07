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
    
    
    