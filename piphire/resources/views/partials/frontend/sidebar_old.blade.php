  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- <li class=" nav-item @if($header_class == 'dashboard') active @endif"><a href="{{url('/dashboard')}}"><i class="dashboard-img"></i><span class="menu-title" data-i18n="">Dashboard</span><span class="float-right"></span></a>
        </li> --}}

        <li class=" nav-item @if($header_class == 'profile') active @endif"><a href="{{url('/profiledatabase')}}"><i class="profileminer-img" ></i><span class="menu-title" data-i18n="">Profile Database</span></a>
        </li>
        <li class=" nav-item @if($header_class == 'source') active @endif"><a href="{{url('/interview/sourcing')}}"><i class="profileminer-img" ></i><span class="menu-title" data-i18n="">Sourcing</span></a>
        </li>

        <li class=" nav-item @if($header_class == 'jobs') active @endif"><a href="{{url('jobs/create')}}"><i class="profilematrix-img" ></i><span class="menu-title" data-i18n="">Fitment Analysis</span><span class="float-right"></span></a>

        </li>

        @if(auth()->user()->organization->plan->id != 1)
        <li class=" nav-item @if($header_class == 'bulkJobs') active @endif"><a href="{{url('/bulkJobs')}}"><i class="profileminer-img" ></i><span class="menu-title" data-i18n="">Bulk Jobs </span></a>
        </li>
      @endif

        <li class=" nav-item @if($header_class == 'history') active @endif"><a href="{{url('/jobs/history')}}"><i class="history-img" ></i><span class="menu-title" data-i18n="">History</span></a>
        </li>

        <li class=" nav-item @if($header_class == 'candidates.list') active @endif"><a href="{{url('/jobs/candidates/list')}}"><i class="history-img" ></i><span class="menu-title" data-i18n="">Candidates List</span></a>
        </li>

        @if(auth()->user()->is_manager == '1' && auth()->user()->organization->max_users > 1)

        <li class=" nav-item @if($header_class == 'users') active @endif"><a href="{{url('/users')}}"><i class="team-insights-img" ></i><span class="menu-title" datax-i18n="">Users</span></a></li>

        @endif

        @if( auth()->user()->is_manager == '1' )
        <li class=" nav-item @if($header_class == 'invoice') active @endif"><a href="{{url('/invoices')}}"><i class="invoices-img" ></i><span class="menu-title" data-i18n="">Invoices</span></a>
        </li>
            {{--
            @if( auth()->user()->organization->max_users > 1 )
                <li class=" nav-item @if($header_class == 'teaminsight') active @endif"><a href="{{url('/teaminsight')}}"><i class="team-insights-img" ></i><span class="menu-title" data-i18n="">Team Insights</span></a></li>

                <li class=" nav-item @if($header_class == 'businessinsight') active @endif"><a href="{{url('/businessinsight')}}"><i class="business-insight-img" ></i><span class="menu-title" data-i18n="">Business Insights</span></a></li>

                <li class=" nav-item @if($header_class == 'sourcing') active @endif"><a href="{{url('/sourcing')}}"><i class="strategic-sourcing-img" ></i><span class="menu-title" data-i18n="">Strategic Sourcing Engine</span></a>
                </li>
            @endif
            --}}

        @endif


        <li class=" nav-item @if($header_class == 'contactus') active @endif"><a href="{{url('/contactus')}}"><i class="contactus-img" ></i><span class="menu-title" data-i18n="">Contact Us</span></a>
        </li>

      </ul>
    </div>
  </div>
  