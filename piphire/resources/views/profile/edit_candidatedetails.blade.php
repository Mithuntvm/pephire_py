<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="aux86pGht2xQ9eMeAUJHF5YZnb5uHO3DdkZSNd4r">
  <title>PepHire</title>

  <link rel="icon" href="/favicon.png" type="image/png">
  <link rel="apple-touch-icon" href="/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/css/vendors.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/css/app.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/vendors/css/tables/datatable/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/core/menu/menu-types/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="/assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
  <link rel="stylesheet" type="text/css" href="/assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="/assets/fonts/simple-line-icons/style.css">
  <!-- END Page Level CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="/assets/css/jquery-ui.css" rel="stylesheet">
  </link>
  <!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css" rel="stylesheet"></link> -->
  <!-- <link rel="stylesheet" type="text/css" href="/assets/css/range-slider.css"> -->

  <style type="text/css">
    div#time-slider {
      margin-top: 10px;
      background: #ececec !important;
      border: none !important;
    }

    input#searchtime {
      width: 100%;
      display: flex;
      color: #2E384D !important;
      font-size: 11px;
      font-weight: 700 !important;
      pointer-events: none;
    }
  </style>

  <!--Start of Tawk.to Script-->
  <!--End of Tawk.to Script-->
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

  <main>
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item mr-auto">
              <a class="navbar-brand" href="">
                <img class="brand-logo" alt="modern admin logo" src="/assets/images/logo/logo.png">
                <h3 class="brand-text"></h3>
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
                <div class="edit">
                  <a href="{{url('/myprofile')}}" class="btn btn-primary">Edit profile</a>
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
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


          <li class=" nav-item active"><a href="/profiledatabase"><i class="profileminer-img"></i><span class="menu-title" data-i18n="">Profile Database</span></a>
          </li>

          <li class=" nav-item "><a href="/jobs/create"><i class="profilematrix-img"></i><span class="menu-title" data-i18n="">Fitment Analysis</span><span class="float-right"></span></a>

          </li>


          <li class=" nav-item "><a href="/bulkJobs"><i class="profileminer-img"></i><span class="menu-title" data-i18n="">Bulk Jobs </span></a>
          </li>
          <li class=" nav-item "><a href="/report"><i class="history-img"></i><span class="menu-title" data-i18n="">Bulkjob Report</span></a>
          </li>


          <li class=" nav-item "><a href="/jobs/history"><i class="history-img"></i><span class="menu-title" data-i18n="">History</span></a>
          </li>

          <li class=" nav-item   "><a href="/jobs/candidates/list"><i class="history-img"></i><span class="menu-title" data-i18n="">Candidates List</span></a>
          </li>




          <li class=" nav-item "><a href="/invoices"><i class="invoices-img"></i><span class="menu-title" data-i18n="">Invoices</span></a>
          </li>




          <li class=" nav-item "><a href="/contactus"><i class="contactus-img"></i><span class="menu-title" data-i18n="">Contact Us</span></a>
          </li>

        </ul>
      </div>
    </div>






    <style>
      input:not([type=radio]).parsley-success,
      textarea.parsley-success,
      select.parsley-success {
        color: #468847;
        background-color: #DFF0D8;
        border: 1px solid #D6E9C6;
      }

      input:not([type=radio]).parsley-error,
      textarea.parsley-error,
      select.parsley-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border: 1px solid #EED3D7;
      }

      .parsley-errors-list {
        color: red;
        margin: 2px 0 3px;
        padding: 0;
        list-style-type: none;
        font-size: 0.9em;
        line-height: 0.9em;
        opacity: 0;

        transition: all .3s ease-in;
        -o-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        -webkit-transition: all .3s ease-in;
      }

      .parsley-errors-list.filled {
        opacity: 1;
      }
    </style>
    <link rel="icon" href="{{url('/')}}/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="{{url('/')}}/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/vendors.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/app.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/core/colors/palette-gradient.css">
    <!-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/charts/jquery-jvectormap-2.0.3.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/charts/morris.css"> -->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
    <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{ url('/') }}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
{{-- <script src="{{ url('/') }}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script src="{{ url('/') }}/assets/js/jquery-ui.min.js"></script>
<script src="{{ url('/') }}/assets/js/filedrag.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script  src="{{ url('/') }}/assets/js/interview.js">
    // var dataTable1Items = null;
    
</script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#contactus").validate({
          rules: {
            name: {
              required: true
            },
            email: {
              required: true,
              email: true
            },
            phone: {
              required: true
            },
            message: {
              required: true
            }
          },
          messages: {
            name: {
              required: "Please enter organization name"
            },
            email: {
              required: "Please enter your email address",
              email: "Please enter a valid email address"
            },
            phone: {
              required: "Please enter your phone number"
            },
            message: {
              required: "Please enter your messages"
            }
          },
        });

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

      });
    </script>


    <div class="app-content content">
      <div class="content-wrapper">


        @if(session()->has('success'))

        <script type="text/javascript">
          setTimeout(function() {
            $(".alert-success").hide();
            window.location.href = "{{url('/profiledatabase')}}";
          }, 3000);
        </script>

        <div class="col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>
        @endif

        <div class="content-header row">
        </div>
        <div class="content-body">
          <div class="col-3 float-right">
            <a href="/profiledatabase"><button onclick="" type="button" class="btn btn-primary btn-float"><i class="ft-arrow-left" aria-hidden="true"></i></button></a>
          </div>
          <!-- Revenue, Hit Rate & Deals -->
          <!-- <form enctype="multipart/form-data" method="post" action="{{ url('/update_candidatedetails/'.$cuid=$candidate->cuid) }}">
            @csrf -->
            <div class="row" style="width: 100%;">

              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="common-section">
                  <h4 class="titlehead"><span>Edit Candidate Profile</span></h4>
                  <div class="" style="margin-top:22px;">

                    <a href="javascript:void(0);" onclick="submitProfile();"><button class="w3-btn" style="height: 30px;width:80px;margin-left:83%;background-color:#2e5bff;color:white">
                        <p style="margin-top:2px">Submit</p>
                      </button></a>
                    <!-- <button class="btn btn-primary btn-color">Apply</button> -->
                  </div>
                  <!-- <div style="width: 100%; display: flex; justify-content: center; margin-top: 0px;margin-left:40%">
                    <div style="width: fit-content; height: fit-content">
                      <a href="javascript:void(0);" onclick="submitProfile();"><button class="btn btn-primary" style="height: 30px;">
                        <p style="margin-top:2px">Submit</p>
                        </button></a>
                    </div>
                  </div> -->
                </div>
              </div>

              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="candidate-formblock" data-parsley-validate="">
                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:0px;">

                    <input type="text" name="name" class="form-control" value="{{ $candidate->name }}" required data-parsley-required-message="Please enter Name">

                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:0px;">

                    <input type="email" name="email" class="form-control" value="{{ $candidate->email }}" required data-parsley-required-message="Please enter Email">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:0px;">

                    <input type="tel" name="phone" class="form-control" value="{{ $candidate->phone }}" required data-parsley-required-message="Please enter Mobile Number">
                  </div>

                  @php

                  $age = "";
                  $dob = $candidate->dob;

                  $d = DateTime::createFromFormat('Y-m-d', $dob);
                  if( $d && $d->format('Y-m-d') === $dob ){
                  $age = '- <span id="show-dob">' .Carbon\Carbon::parse($dob)->age . '</span> Years';
                  }

                  @endphp

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">
                    <!-- <label class="control-label">Age {!! $age !!}</label> -->

                    <input type="date" name="dob" class="form-control datepicker" value="{{ $candidate->dob }}" required data-parsley-required-message="Please enter Date of Birth">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sex" id="male" value="Male" required data-parsley-required-message="Please select Gender" @if($candidate->sex == 'Male') checked @endif>
                      <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sex" id="female" value="Female" @if($candidate->sex == 'Female') checked @endif>
                      <label class="form-check-label" for="female">Female</label>
                    </div>
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <select class="form-control" name="married" required="" data-parsley-required-message="Please select Marital Status">
                      <option value=""> -- Select Marital Status --</option>
                      <option value="single" @if($candidate->married == 'single') selected="selected" @endif>
                        Single
                      </option>
                      <option value="married" @if($candidate->married == 'married') selected="selected" @endif>
                        Married
                      </option>
                    </select>
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="education" class="form-control" value="{{ $candidate->education }}" placeholder="Please enter Education">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="experience" id="experience" class="form-control" value="{{ $candidate->experience }}" placeholder="Please enter Experience" onchange="hi()">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="passport_no" class="form-control" value="{{ $candidate->passport_no }}" placeholder="Please enter Passport Number">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="visatype" class="form-control" value="{{ $candidate->visatype }}" placeholder="Please enter Visa Type">
                  </div>
                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="linkedin_id" class="form-control" value="{{ $candidate->linkedin_id }}">
                  </div>

                  <div class="form col-md-4 col-sm-6 col-xs-12" style="margin-top:30px;">

                    <input type="text" name="location" class="form-control" value="{{ $candidate->location }}" placeholder="Please enter Location" />
                  </div>



                  <!-- <div id="grey" style="display:none;width:100%;margin-left:5px;"> -->

                  <div class="form col-md-4 col-sm-6 col-xs-12" id="grey" style="display:none;" style="margin-top:30px;">

                    <input type="text" name="role" id="role" class="form-control" value="{{ $candidate->role }}" placeholder="Please enter Role">
                  </div>



                  <?php
                  $exp =  $candidate->experience;
                  ?>




                  <!-- <div class="form col-md-4 col-sm-6 col-xs-6" id="grey2" style="display:none;" style="margin-top:30px;">

                    <small>Enter company name seperated by comma (,)</small>
                    <textarea name="companies" id="companies" class="form-control">{{ implode(',', $candidate->companies()->pluck('name')->toArray()) }}</textarea>
                  </div> -->

                  <!-- </div> -->
                  <div class="form col-md-8 col-sm-8 col-xs-8" style="margin-top:30px;">

                    <select multiple class="form-control skills" name="skills[]" data-parsley-required-message="Please enter atleast one Skill">
                      @foreach($candidate->newskills as $skill)
                      <option value="{{ $skill->id }}" selected="selected"> {{ $skill->name }} </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form col-md-4 col-sm-4 col-xs-4" style="margin-top:30px;">

                    <select class="form-control status" name="status" id="status" data-parsley-required-message="Please enter atleast one Skill" required >
                      <!-- style="text-align:CENTER ;" -->
                      <option value="1" selected="selected">CONTACTED</option>
                      <option value="2" >INTERESTED</option>
                      <option value="3">NOT INTERESTED</option>
                    </select>
                  </div>



                </div>
              </div>



            </div>

        

        <!-- </form> -->
      </div>
    </div>
    </div>
    </div>

    <!-- </div>
	</div> -->
    <script>
      function hi() {

        var inputVal = document.getElementById("experience").value;

        //   if (inputVal == 0.00) {
        //     $("#role").prop('disabled', true);  
        //        }     // if disabled, enable
        //         }
        if (inputVal == 0.00) {

          $('#grey').hide();
          $('#grey1').hide();
          $('#grey2').hide();
          $('#grey3').show();


        } else {
          $('#grey').show();
          $('#grey1').show();
          $('#grey2').show();
          $('#grey3').hide();
        }


      }

      function myFunction() {
        var exp = <?php echo $exp;  ?>

        console.log(exp);
        if (exp > 0.00) {

          $('#grey').show();
          $('#grey1').show();
          $('#grey2').show();
          $('#grey3').hide();


        }
      }
      // else {
      // $('#grey').hide();
      // }
    </script>
    <script src="{{url('/')}}/assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- BEGIN MODERN JS-->
    <script src="{{url('/')}}/assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/core/app.js" type="text/javascript"></script>
    <!-- <script src="{{url('/')}}/assets/js/scripts/customizer.js" type="text/javascript"></script> -->
    <!-- <script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script> -->
    <!-- <script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script> -->
    <!-- END MODERN JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="{{url('/')}}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
    <!-- END PAGE LEVEL JS-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Parsley -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function() {

        $(".datepicker").flatpickr({
          // altInput: true,
          // altFormat: 'd-M-Y',
          // dateFormat: "Y-m-d",
          onChange: function(selectedDates, dateStr, instance) {

            var today = new Date();
            var newDate = new Date(dateStr);
            var age = today.getFullYear() - newDate.getFullYear();
            var m = today.getMonth() - newDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < newDate.getDate())) {
              age--;
            }

            $("#show-dob").html(age);
          }
        });

        $(".skills").select2({
          placeholder: 'Enter Skills',
          minimumInputLength: 2,
          allowClear: true,
          ajax: {
            url: "/skill/autocomplete",
            dataType: 'json',
            delay: 500,
            data: function(params) {
              return {
                term: params.term, // search term
              };
            },
            processResults: function(data, params) {
              return {
                results: $.map(data, function(skill) {
                  return {
                    id: skill.id,
                    text: skill.name
                  };
                })
              };
            },
            cache: true,
          }
        });

      });


      function submitProfile() {

        var sluid = "<?php echo (isset($sluid) ? $sluid : ''); ?>";

        // if ($('.candidate-formblock').parsley().validate()) {
        $.ajax({
          url: "{{ URL::route('candidatedetails.update', $candidate->cuid) }}",
          dataType: 'json',
          type: 'POST',
          data: {
            name: $("input[name=name]").val(),
            email: $("input[name=email]").val(),
            phone: $("input[name=phone]").val(),
            dob: $("input[name=dob]").val(),
            sex: $("input[name='sex']:checked").val(),
            married: $("select[name=married]").val(),
            education: $("input[name=education]").val(),
            experience: $("input[name=experience]").val(),
            passport_no: $("input[name=passport_no]").val(),
            visatype: $("input[name=visatype]").val(),
            linkedin_id: $("input[name=linkedin_id]").val(),
            skills: $(".skills option:selected").map(function() {
              return this.value
            }).get().join(","),
            status:$(".status option:selected").val(),
            location: $("input[name=location]").val(),

            sluid,
            _token: "{{ csrf_token() }}",
            
          },

          success: function(response) {
            console.log(response)
            if (response.status) {
              window.location.href = response.redirect_url;
              // swal("Success", "Your profile has been updated successfully", "success");
              // setTimeout(function() {
              // 	window.location.href = response.redirect_url;
              // }, 2000);
            }
          },
          error: function(response) {

            console.log('inside ajax errorr');
          }
        });

      }
    </script>
  <footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} <a class="text-bold-800 grey darken-2" href="https://www.sentientscripts.com/"
        target="_blank">Sentient Scripts </a>, All rights reserved. </span>
        <span class="float-md-left d-block d-md-inline-block">Various trademarks held by their respective owners </span>
        <span class="float-md-left d-block d-md-inline-block"><a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/privacy-policy">.  Privacy Policy</a> | <a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/terms-and-conditions"> Terms & Conditions</a> | <a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/return-and-refund">Return and Refund</a> </span>
      <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"></span>
    </p>
  </footer>

</main>
<script src="{{url('/')}}/assets/vendors/js/tables/datatable/dataTables.buttons.min.js"
type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/tables/datatables/datatable-advanced.js"
type="text/javascript"></script>
<!-- BEGIN MODERN JS-->
<script src="{{url('/')}}/assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/core/app.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/customizer.js" type="text/javascript"></script>
<!-- END MODERN JS-->
@stack('scripts')

</body>
</html>