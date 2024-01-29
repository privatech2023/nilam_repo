<div>
  <span class="text-md breadcrumb-text">
    @if($devices->isEmpty())
    <div  class="btn-group dropdown ">
      <button type="button" style="color:white; margin-left: 100%;" class="btn btn-sm btn-outline dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        No device 
      </button>
  </div>
    @else
    @foreach ($devices as $device)
    <div  class="btn-group dropdown ">
        <button type="button" style="color:white; margin-left: 100%;" class="btn btn-sm btn-outline dropdown-toggle custom-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ $device->device_id == $defaultDevice->device_id ? $device->device_name : 'Select device' }}
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item"  href="{{ url('/default-device'.'/'.$device->device_id.'/'.$device->device_token)}}">{{ $device->device_name }}</a>
        </div>
    </div>
    @endforeach 
    @endif   
</span>
</div>
