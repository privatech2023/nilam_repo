<div>
  <span class="text-md breadcrumb-text">
    @if($devices->isEmpty())
    <div  class="btn-group dropdown ">
      <button type="button" style="color:white; margin-left: 100%;" class="btn btn-sm btn-outline dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        No device 
      </button>
  </div>
    @else
    <div class="btn-group dropdown" id="bt" >
      <button type="button" style="color:white; " class="btn btn-sm btn-outline dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @php
            $deviceName = ''; 
        @endphp
        @foreach ($devices as $device)
            @if($device->device_id == $defaultDevice->device_id && $device->device_name != '')
                @php
                    $deviceName = $device->device_name;
                @endphp
            @elseif($device->device_id != $defaultDevice->device_id)
            @php
            continue
            @endphp
            @else
            @php
            continue
            @endphp
            @endif
      @endforeach
        {{ $deviceName }}
      </button>
      <div class="dropdown-menu">
          @foreach ($devices as $device)
              <a class="dropdown-item" href="{{ url('/default-device'.'/'.$device->device_id) }}">{{ $device->device_name == '' ? 'Device' : $device->device_name }}</a>
          @endforeach
      </div>
  </div>
  
  
    
    @endif   
</span>
</div>