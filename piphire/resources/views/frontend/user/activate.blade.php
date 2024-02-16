<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!-- title -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'PepHire') }}</title>
        <meta name="author" content="lgauthor">
        <!-- favicon -->
        <link rel="apple-touch-icon" href="{{url('/')}}/assets/images/logo/icons/apple-icon.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/assets/images/logo/icons/favicon-96x96.png">
        <!-- animation -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/animate.css" />
        <!-- bootstrap -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/bootstrap.min.css" />
        <!-- font-awesome icon -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/font-awesome.min.css" />
        <!-- themify-icons -->
        <!-- <link rel="stylesheet" href="assets/landing-page/css/themify-icons.css" /> -->
        <!-- owl carousel -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/owl.transitions.css" />
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/owl.carousel.css" />
        <!-- magnific popup -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/magnific-popup.css" />
        <!-- base -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/base.css" />
        <!-- elements -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/elements.css" />
        <!-- responsive -->
        <link rel="stylesheet" href="{{url('/')}}/home-assets/landing-page/css/responsive.css" />
        <!--[if IE 9]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" />
        <![endif]-->
        <!--[if IE]>
            <script src="js/html5shiv.min.js"></script>
        <![endif]-->

        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
          /*
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5d89bb719f6b7a4457e34386/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })(); */
        </script>
        <!--End of Tawk.to Script-->

        <style>
            .btn-dual .btn { margin: 0 12px 0 0;}
        </style>
    </head>
    <body>
        <header class="header-style5" id="header-section12">
            <!-- nav -->
            <nav class="navbar tz-header-bg black-header alt-font no-margin shrink-transparent-header-dark dark-header header-border-light">
                <div class="container navigation-menu">
                    <div class="row">
                        <!-- logo -->
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <a href="{{url('/')}}#home" class="inner-link"><img alt="" src="{{url('/')}}/home-assets/landing-page/images/logo-white.png" data-img-size="(W)163px X (H)40px"></a>
                        </div>
                        <!-- end logo -->
                        <div class="col-md-9 col-sm-8 col-xs-6 position-inherit xs-no-padding-left">
                            <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!-- social elements -->
                            <div class="social float-right pull-right">
                                <a href="javascript:void(0);"><i class="fa fa-facebook tz-icon-color"></i></a>
                                <a href="javascript:void(0);"><i class="fa fa-twitter tz-icon-color"></i></a>
                                <a href="javascript:void(0);"><i class="fa fa-linkedin tz-icon-color"></i></a>
                                <a href="javascript:void(0);"><i class="fa fa-google-plus tz-icon-color"></i></a>
                            </div>
                            <!-- end social elements -->
                            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse pull-right">
                                <ul class="nav navbar-nav">
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#pricing-table4">PRICING</a></li>
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#title-section13">FEATURES</a></li>
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#hero-section20">HOW IT WORK</a></li>
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#content-section32">ABOUT</a></li>
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#contact-section5">CONTACT</a></li>
                                    <li class="propClone"><a class="inner-link" href="{{url('/')}}#feature-section27">LOGIN / SIGNUP</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- end nav -->
        </header>

<section class="padding-60px-tb builder-bg activebg-image" id="feature-section27">
<div class="container">
    <div class="row equalize">
            <div class="card col-md-6 col-xs-12">
              <div class="text-center">
                <img src="../../assets/images/logo/logo.png">
              </div>

                <div class="card-header active-header">Complete Registration & Activate <br /> your Account</div>

                <div class="card-body">


            @if(session()->has('success'))
                <div class="form-group row">
                  <div class="col-md-10">
                    <div class="col-12 alert alert-success text-center mt-1" id="alert_message">You have successfully Registered & Activated your Account. You may now log in and avail the benefits of PepHire</div>
                  </div>
                </div>

                <a href="{{url('/?type=loginpop')}}" class="btn btn-primary">Login</a>

            @else

            @if($user)

              <form id="activate_user" method="POST" action="{{ url('/validate/user/'.$user->verification_link) }}">
              @csrf

              <div class="form-group row">

                  <div class="col-md-10">
                      <label for="password" class="col-md-4 col-form-label text-md-right">Enter Password*</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">


                  <div class="col-md-10">
                      <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
              </div>

              <div class="form-group row">
                  <div class="col-md-10">
                      <button type="submit" class="btn btn-primary">
                          {{ __('Register') }}
                      </button>
                  </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-10"><p class="rules"><span>*</span> Password must be 8 character length with a lower case letter and at least a digit.</p></div>
            </div>
            </form>


            @else

            <div class="col-12 alert alert-danger text-center mt-1" id="alert_message">The link is not available anymore. Please reach out to your Admin.</div>

            @endif

            @endif

                </div>
            </div>
    </div>
</div>
</section>

        <!-- javascript libraries -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.min.js"></script>
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.appear.js"></script>
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/smooth-scroll.js"></script>
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/wow.min.js"></script>
        <!-- owl carousel -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/owl.carousel.min.js"></script>
        <!-- images loaded -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/imagesloaded.pkgd.min.js"></script>
        <!-- isotope -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.isotope.min.js"></script>
        <!-- magnific popup -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.magnific-popup.min.js"></script>
        <!-- navigation -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.nav.js"></script>
        <!-- equalize -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/equalize.min.js"></script>
        <!-- fit videos -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.fitvids.js"></script>
        <!-- number counter -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/jquery.countTo.js"></script>
        <!-- time counter  -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/counter.js"></script>
        <!-- twitter Fetcher  -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/twitterFetcher_min.js"></script>
        <!-- main -->
        <script type="text/javascript" src="{{url('/')}}/home-assets/landing-page/js/main.js"></script>



  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

  <script type="text/javascript">

      $(document).ready(function(){
        $("#activate_user").validate({
              rules: {
                password: {
                  required : true,
                  pwcheck: true
                },
                password_confirmation: {
                  required : true,
                  equalTo: "#password"
                }
              },
              messages: {
                password: {
                  required : "Please enter password",
                  pwcheck : "Please enter a password as mentioned"
                },
                password_confirmation: {
                  required : "Please enter confirm password",
                  equalTo: "Please enter the same password"
                }
              },
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.validator.addMethod("pwcheck", function(value) {
               return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                   && /[a-z]/.test(value) // has a lowercase letter
                   && /\d/.test(value) // has a digit
                   && value.length >= 8 // has 8 digit
            });

        });

  </script>

    </body>
</html>