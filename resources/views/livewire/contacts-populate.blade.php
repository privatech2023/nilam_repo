<div>
    @foreach($contactsL as $key => $value)
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{url('assets/common/img/default_user.png')}}"
                alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $value}}</h3>


          <p class="text-muted text-center"></p>
          <p class="text-muted text-center"></p>

          <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                  <b><i class="fa-solid fa-mobile-screen-button"></i></b><span class="text-md">Mobile number</span> <span class="float-right">{{ $key}}</span>
              </li>
          </ul>                
        </div>                    <!-- /.card-body -->
      </div>
      @endforeach
</div>
