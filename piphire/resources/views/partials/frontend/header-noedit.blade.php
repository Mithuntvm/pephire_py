<!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="{{ url('/') }}">
              <img class="brand-logo" alt="modern admin logo" src="{{url('/')}}/assets/images/logo/logo.png">
              <h3 class="brand-text">{{-- config('app.name', 'PepHire') --}}</h3>
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"></li>
            <li class="dropdown nav-item mega-dropdown">
            </li>
            <li class="nav-item nav-search">
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="avatar avatar-online">

                    @if(Auth::user()->profileimage)
                    <img class="profile_image" src="{{url('/storage/'.Auth::user()->profileimage)}}" alt="avatar">
                    @else
                     <img class="profile_image" src="{{url('/')}}/assets/images/candiate-img.png" alt="avatar">
                    @endif

                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


                <div class="profile-img">
                  <span>
                    @if(Auth::user()->profileimage)
                    <img class="rounded-circle" src="{{url('/storage/'.Auth::user()->profileimage)}}">
                    @else
                     <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                    @endif
                  </span>
                </div>
                <div class="user-name">
                  <h4>{{ Auth::user()->name }}</h4>
                  <p>{{ Auth::user()->designation }}</p>
                </div>
                <div class="dropdown-divider"></div>
                <div class="account-details">
                  <span>Role</span>
                  <?php if(auth()->user()->is_manager == '1'){ ?>
                    <p>Administrator</p>
                  <?php }else{ ?>
                    <p>HR Executive</p>
                  <?php } ?>
                  <span>Email</span>
                  <p>{{ Auth::user()->email }}</p>
                  <span>Phone</span>
                  <p>{{ Auth::user()->phone }}</p>
                  <span>Twitter</span>
                  <p>{{ Auth::user()->twitter }}</p>
                  <span>Location</span>
                  <p>{{ Auth::user()->location }}</p>
                  <span>Bio</span>
                  <p>{{ Auth::user()->bio }}</p>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ft-power"></i> Logout</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- ////////////////////////////////////////////////////////////////////////////-->