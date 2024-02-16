<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!-- title -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'PepHire') }}</title>
        <meta name="author" content="">
        <!-- favicon -->
        <link rel="icon" href="{{url('/')}}/favicon.png" type="image/png">
        <link rel="apple-touch-icon" href="{{url('/')}}/favicon.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/favicon.png">

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
                                    <li class="propClone"><a class="inner-link" href="{{url('/?type=loginpop')}}">LOGIN / SIGNUP</a></li>
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
                  <div class="card-header">
                    Success
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">You have registered successfully</h5>
                    <p class="card-text">To activate your Account, please verify your email address using the link emailed to you</p>
                    <a href="{{url('/')}}" class="btn btn-primary">Close</a>
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

    </body>
</html>
