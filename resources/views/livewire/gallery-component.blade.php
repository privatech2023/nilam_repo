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
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap-1">
                    <p>Albums(2)</p>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="Search " />
            </div>
            <div id="contacts">
                <ul>
                    <li class="contact" >
                        <div class="wrap" style="height: 5rem; width: 100%; display: flex; align-items: center; margin-left: 20px;">
                            <img src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000089383?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" style="border-radius: 0; height: 5rem; width: 5rem;" alt="" />
                            <div class="meta" style="margin-left: 10px;">
                                <p class="name">Camera</p>
                                <p class="preview">(172)</p>
                            </div>
                        </div>
                        
                        
                    </li>
                    <li class="contact" >
                        <div class="wrap" style="height: 5rem; width: 100%; display: flex; align-items: center; margin-left: 10px;  margin-left: 20px;">
                            <img src="https://jp-1-bd.airdroid.com:9980/sdctl/media/image/thumb/1000082312?max=62&amp;7bb=814fda0cb50fb3c91070cb8c80ae052f&amp;des=1&amp;token=814fda0cb50fb3c91070cb8c80ae052ftoken_end&amp;matchid=b17820fdb584966341dfe6bd80171b54mid_end&amp;dfurl=https%3A%2F%2Fjp-4-data.airdroid.com%3A9088dfurl_end&amp;dsurl=jp-1-bd.airdroid.comdsurl_end&amp;dsport=9991dsport_end&amp;bitdata=1" style="border-radius: 0; height: 5rem; width: 5rem;" alt="" />
                            <div class="meta" style="margin-left: 10px;">
                                <p class="name">Snaps</p>
                                <p class="preview">(172)</p>
                            </div>
                        </div>
                        
                        
                    </li>

                    
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="contact-profile">
                <div style="margin-left: 10px;">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                  </svg></p> 
                </div>                
                <div class="text-right" style="margin-right: 8px;">
                    <button type="button" class="btn btn-outline-primary btn-sm" wire:click="syncGallery">Sync gallery</button>
                </div>
                
            </div>
            <div class="messages">
                <nav class="navbar navbar-light bg-light">
            
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          select all
                        </label>
                      </div>
                </nav>
                <ul>
                   
                    
                </ul>
            </div>
        </div>
    </div>
    </div>
    
</div>
    
