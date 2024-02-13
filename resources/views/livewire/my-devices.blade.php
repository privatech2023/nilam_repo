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
            <nav class="navbar navbar-light bg-light">
                
                <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                  </svg> MY DEVICES</span>
                  <button class="btn btn-outline-success btn-sm" wire:click="sendRefresh" id="cont-refresh-component-specific" style="margin-left:3px;" type="button">Refresh</button>
            </nav>
            <div style="margin-top: 20px; margin-left: 20px; height: 90%; overflow-x: auto;" id="cont" >
                @foreach($deviceList as $dev)
                <div class="row" >
                    <div style="width:80%;">
                        <table class="table">
                            <tbody>
                              <tr>
                                <th scope="row">BRAND :</th>
                                <td>{{ $dev['manufacturer']}}</td>
                              </tr>
                              <tr>
                                <th scope="row">MODEL :</th>
                                <td>{{  $dev['model'] }}</td>
                              </tr>
                              <tr>
                                <th scope="row">ANDROID VERSION :</th>
                                <td>{{  $dev['version'] }}</td>
                              </tr>
                              <tr>
                                <th scope="row">HOST ID :</th>
                                <td>{{ $dev['host'] }}</td>
                              </tr>
                              <tr>
                                <th scope="row">BATTERY STATUS :</th>
                                <td>{{ $dev['battery'] }}
                                    </td>
                              </tr>
                            </tbody>
                          </table>
    @if( $dev['updated_at'] )
    @php
        $updatedTime = \Carbon\Carbon::parse($dev['updated_at']);
        $currentTime = \Carbon\Carbon::now();
        $timeDifference = $updatedTime->diff($currentTime);

        $formattedTime = '';
        if ($timeDifference->y > 0) {
            $formattedTime = $timeDifference->y . ' years ago';
        } elseif ($timeDifference->m > 0) {
            $formattedTime = $timeDifference->m . ' months ago';
        } elseif ($timeDifference->d > 0) {
            $formattedTime = $timeDifference->d . ' days ago';
        } elseif ($timeDifference->h > 0) {
            $formattedTime = $timeDifference->h . ' hours ago';
        } elseif ($timeDifference->i > 0) {
            $formattedTime = $timeDifference->i . ' minutes ago';
        } else {
            $formattedTime = 'just now';
        }
        @endphp

        <div class="alert alert-success" style="width: 60%;">
        Last updated: {{ $formattedTime }}
        </div>
        <br>
        @endif                      
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    

        
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Livewire.on('banner-message', function (data) {
                    if (data.style === 'success') {
                        alert(data.message);
                        $('#message').val('');
                    } else {
                        alert(data.message);
                        $('#message').val('');
                    }
                });
            });
        </script>
    </div> 
        
    
    
    
    