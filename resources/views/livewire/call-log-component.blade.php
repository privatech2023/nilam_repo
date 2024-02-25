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

    <div id="myModalconf" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">			
                  <h4 class="modal-title">Failed to fetch call logs</h4>	
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body text-center">
                  <p>Please allow device permissions to access call logs</p>
                  <img src="{{ asset('assets/frontend/images/app1.jpeg') }}" alt="Mobile Screenshot" class="img-fluid smaller-image">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>


        <nav class="navbar navbar-light bg-light">
            <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
            </svg>   CALL LOGS</span>

            <div class="text-right" style="margin-right: 3px;">
              
              <button class="btn btn-primary btn-sm" type="button"  wire:click="SyncCallLog" onclick="load()">Sync call logs</button>
              <button class="btn btn-outline-success btn-sm" wire:click="contRefreshComponentSpecific" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
            </div>
        </nav>
        {{-- <nav class="navbar navbar-light bg-light">
            
        </nav> --}}
        <div class="scrollable-content_call_log">
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
          </div>
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
      var callList = @json($callList); 
    if(callList.length == 0){
        $('#myModalconf').modal('show');
    }
      // setInterval(function() {
      //   $('#myModalconf').modal('hide');
      //       document.getElementById('cont-refresh-component-specific').click();
      //   }, 10000);
     });
  </script>
</div>
    


