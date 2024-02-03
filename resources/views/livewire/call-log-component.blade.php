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
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
            </svg>   CALL LOGS</span>
        </nav>
        <nav class="navbar navbar-light bg-light">
            {{-- <div class="btns" style="margin-right: 0;">
              <button class="btn btn-outline-success btn-sm" type="button">All</button>
              <button class="btn btn-outline-success btn-sm" type="button">Incoming</button>
              <button class="btn btn-outline-success btn-sm" type="button">Outgoing</button>
              <button class="btn btn-outline-success btn-sm" type="button">Missed</button>
            </div> --}}
            <div class="text-right" style="margin-right: 3px;">
              <button class="btn btn-primary btn-sm" type="button"  wire:click="SyncCallLog">Sync call logs</button>
            </div>
        </nav>
        <div style="display: flex; margin-top: 20px; margin-left: 10px;">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Number</th>
                    <th scope="col">Date</th>
                    <th scope="col">Duration</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($callList as $c)
                  <tr>
                    <th scope="row">{{$c['name']}}</th>
                    <td>{{$c['number']}}</td>
                    <td>{{$c['date']}}</td>
                    <td>{{$c['duration']}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            <!-- Add more images as needed -->
            {{-- <div class="mt-4">
              {{ $callList->links() }}
          </div> --}}
        </div>
    </div>

    {{-- <div id="frame">     
        <div class="content">
            <div class="contact-profile">
                <img src="#" alt="" />
                <p>ABC</p>               
                <div class="text-right" style="margin-right: 8px;">
                    <div class="btn-group dropright" >
                        <button type="button" class="btn btn-secondary dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Device
                        </button>
                        <div class="dropdown-menu">
                        @foreach ($devices as $device)
                            <a class="dropdown-item" href="#">{{ $device->device_name }}</a>
                        @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="messages">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{url('assets/common/img/default_user.png')}}"
                            alt="User profile picture">
                      </div>
      
                      <h3 class="profile-username text-center">abc</h3>
      
      
                      <p class="text-muted text-center"></p>
                      <p class="text-muted text-center"></p>
      
                      <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-mobile-screen-button"></i></b><span class="text-md">Mobile number</span> <span class="float-right">7364836283</span>
                          </li>
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-envelope"></i></b><span class="text-md">Email</span> <span class="float-right">abc@abc.com</span>
                          </li>
                          <li class="list-group-item">
                              <b><i class="fa-solid fa-receipt"></i></b><span class="text-md">Address</span> <span class="float-right">Address</span>
                          </li>
                      </ul>                
                    </div>                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
    </div> --}}
    </div>
</div>
    


