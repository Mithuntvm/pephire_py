  <!-- ////////////////////////////////////////////////////////////////////////////-->

  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

        <li class="nav-item @if($page == 'dashboard') active @endif">
            <a href="{{url('/backend/dashboard')}}">
                <i class="la la-home"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item @if($page == 'organization') active @endif">
            <a href="{{url('/backend/organization/list')}}">
                <i class="la la-building"></i>
                <span class="menu-title">Organizations</span>
            </a>
        </li>

        <li class="nav-item @if($page == 'plantype') active @endif">
            <a href="{{url('/backend/plantype/list')}}">
                <i class="la la-money"></i>
                <span class="menu-title">Plans Types</span>
            </a>
        </li>        

        <li class="nav-item @if($page == 'plans') active @endif">
            <a href="{{url('/backend/plan/list')}}">
                <i class="la la-money"></i>
                <span class="menu-title">Plans</span>
            </a>
        </li>


      </ul>
    </div>
  </div>