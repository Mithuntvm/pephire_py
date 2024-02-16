  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- <li class=" nav-item @if($header_class == 'dashboard') active @endif"><a href="{{url('/dashboard')}}"><i class="dashboard-img"></i><span class="menu-title" data-i18n="" >Dashboard</span><span class="float-right"></span></a>
        </li> --}}

        <li class=" nav-item @if($header_class == 'profile') active @endif"><a href="{{url('/profiledatabase')}}"><i class="profileminer-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">Profile Database</span></a>
        </li>
        <li class=" nav-item @if($header_class == 'source') active @endif"><a href="{{url('/interview/sourcing')}}"><img src=" http://pepdemo.westindia.cloudapp.azure.com/assets/images/icons/sourcing.png"  style="height: 18px;width:18px;margin-left:4px;"><span class="menu-title" data-i18n="" >Sourcing</span></a>
        </li>

        <li class=" nav-item @if($header_class == 'jobs') active @endif"><a href="{{url('jobs/create')}}"><i class="profilematrix-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">Fitment Analysis</span><span class="float-right"></span></a>
        </li>
        <li class=" nav-item @if($header_class == 'app_jobs') active @endif"><a href="{{url('app/jobs')}}"><i class="profilematrix-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">App Jobs</span><span class="float-right"></span></a>

</li>

        @if(auth()->user()->organization->plan->id != 1)
        <li class=" nav-item @if($header_class == 'bulkJobs') active @endif"><a href="{{url('/bulkJobs')}}"><i class="profileminer-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">Bulk Jobs </span></a>
        </li>
      @endif

        <li class=" nav-item @if($header_class == 'history') active @endif"><a href="{{url('/jobs/history')}}"><i class="history-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">History</span></a>
        </li>
        <li class=" nav-item @if($header_class == 'candidates.list') active @endif"><a href="{{url('/jobs/candidates/list')}}"><img src=" http://pepdemo.westindia.cloudapp.azure.com/assets/images/icons/candidate_list.png"  style="height: 16px;width:14px;margin-left:2px;"><span class="menu-title" data-i18n="" >Candidates List</span></a>
        </li>

        @if(auth()->user()->is_manager == '1' && auth()->user()->organization->max_users > 1)

        <li class=" nav-item @if($header_class == 'users') active @endif"><a href="{{url('/users')}}"><i class="team-insights-img" ></i><span class="menu-title" datax-i18n="" style="margin-left: 5px;">Users</span></a></li>

        @endif

        @if( auth()->user()->is_manager == '1' )
        <li class=" nav-item @if($header_class == 'invoice') active @endif"><a href="{{url('/invoices')}}"><i class="invoices-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">Invoices</span></a>
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


        <li class=" nav-item @if($header_class == 'contactus') active @endif"><a href="{{url('/contactus')}}"><i class="contactus-img" ></i><span class="menu-title" data-i18n="" style="margin-left: 5px;">Contact Us</span></a>
        </li>
        <li class=" nav-item @if($header_class == 'gdrive') active @endif"><a href="{{url('/upload-file')}}"><img src=" http://pepdemo.westindia.cloudapp.azure.com/assets/images/icons/google_drive.png"  style="height: 15px;width:15px;margin-left:4px;"><span class="menu-title" data-i18n="">Google Drive</span></a>
        </li>
      </ul>
    </div>
  </div>
  