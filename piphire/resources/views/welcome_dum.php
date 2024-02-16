<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
  <meta name="google-site-verification" content="SYo0kK-8O3y1Sg2dfLFQLsk97B9Dx0FnKRt-qawZ-2Y" />
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
  <link rel="stylesheet" href="{{url('/')}}/build/css/intlTelInput.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
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
    .btn-dual .btn {
      margin: 0 12px 0 0;
    }

    .swal2-popup {
      width: 450px !important;
    }
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
            <a href="#home" class="inner-link"><img alt="" src="{{url('/')}}/home-assets/landing-page/images/logo-white.png" data-img-size="(W)163px X (H)40px"></a>
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
            <!-- <div class="social float-right pull-right">
                                <a href="#"><i class="fa fa-facebook tz-icon-color"></i></a>
                                <a href="#"><i class="fa fa-twitter tz-icon-color"></i></a>
                                <a href="#"><i class="fa fa-linkedin tz-icon-color"></i></a>
                                <a href="#"><i class="fa fa-google-plus tz-icon-color"></i></a>
                            </div> -->
            <!-- end social elements -->
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse pull-right">
              <ul class="nav navbar-nav">
                <li class="propClone"><a class="inner-link" href="#hero-section20">HOW IT WORK</a></li>
                <li class="propClone"><a class="inner-link" href="#pricing-table4">PRICING</a></li>
                <li class="propClone"><a class="inner-link" href="#content-section32">ABOUT</a></li>
                <li class="propClone"><a class="inner-link" href="#contact-section5">CONTACTUS</a></li>
                <li class="propClone"><a class="inner-link" href="#feature-section27" data-toggle="modal" data-target="#demo-1">LOGIN / SIGNUP</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- end nav -->
  </header>
  <section class="position-relative hero-style19 cover-background tz-builder-bg-image hero-style19 hero-style2 border-none bg-img-one" id="home" data-img-size="(W)1920px X (H)800px" style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)) repeat scroll 0% 0%, transparent url('{{url('/')}}/home-assets/landing-page/images/bg-image/hero-bg12.jpg') repeat scroll 0% 0%">
    <div class="container-fluid one-fifth-screen one-sixth-screen xs-height-auto position-relative">
      <div class="row">
        <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hero-bottom-img">
          <img src="{{url('/')}}/home-assets/landing-page/images/banner.png" class="width-100" data-img-size="(W)1700px X (H)981px" alt="">
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 hero-right-content">
          <!-- title -->
          <h1 class="title-extra-large-3 md-title-extra-large-2 xs-title-extra-large-3 letter-spacing-minus-1 text-white alt-font margin-one-bottom sm-margin-three-bottom tz-text center-col">Find the Best Candidate for the Job in Seconds</h1>
          <div class="text-white text-extra-large font-weight-600 center-col xs-text-extra-large tz-text margin-eight-bottom sm-margin-six-bottom xs-margin-eleven-bottom sm-margin-nine-bottom">
            <p class="sm-width-80 center-col">AI Engine to match profiles to Job needs in seconds.</p>
          </div>
          <div class="d-flex justify-content-between">
            <div>1. Define your Need</div>
            <span class="dot"></span>
            <div>2.Upload your Profiles</div>
            <span class="dot"></span>
            <div>3.Find your Right Candidate</div>
          </div>
          <div class="text-white text-extra-large font-weight-600 center-col xs-text-extra-large tz-text margin-eight-bottom sm-margin-six-bottom xs-margin-eleven-bottom sm-margin-nine-bottom">
            <p class="sm-width-80 center-col">It’s as simple as that !</p>
          </div>
          <div class="btn-block">
            <a href="#pricing-table4" class="btn btn-borderonly">Purchase Plan</a>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#demo-1">Sign In</a>
          </div>
          <!-- end title -->
        </div>
      </div>
    </div>
  </section>
  <!--  <section class="padding-60px-tb builder-bg no-padding-bottom xs-padding-60px-tb" id="feature-section27">
            <div class="container">
                <div class="row equalize">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="btn-dual">
                            <a class="btn btn-large propClone bg-golden-yellow text-black btn-circle xs-margin-ten-bottom xs-width-100" href="#feature-section27" data-toggle="modal" data-target="#demo-1"><span class="tz-text">Try for Free</span></a>
                            <a id="signin_button" class="btn btn-large propClone bg-white text-black btn-circle xs-margin-ten-bottom xs-width-100" href="#feature-section27" data-toggle="modal" data-target="#demo-1"><span class="tz-text">Sign In</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
  <section class="padding-60px-tb xs-padding-60px-tb no-padding-top" id="hero-section20">
    <div class="d-flex reverse video-block row">
      <div class="col-md-6 col-col-lg-6 col-sm-12 col-xs-12">
        <div class="content">
          <h4>Get empowered with AI driven Autonomous Cognitive Hiring</h4>
          <p>Understanding the unstated hiring needs <br />
            Minimizing Human Intervention <br />
            Making Hiring frictionless, and painless for candidates and recruiters <br />
            Corporate Sourcing Analytics to Uncover your enterprise competitive advantage
          </p>
          <a href="#contact-section5" class="btn btn-borderonly">Contact Us</a>
        </div>
      </div>
      <div class="col-md-6 col-col-lg-6 col-sm-12 col-xs-12">
        <video loop autoplay muted>
          <source src="{{url('/')}}/home-assets/landing-page/images/videoblocks-technology-of-ai-artificial-intelligence-big-data-machine-deep-learning_b_bbxxog2__D.mp4" type="video/mp4">
        </video>
      </div>
    </div>
  </section>
  <section class="bg-white builder-bg padding-60px-tb xs-padding-60px-tb no-padding-top" id="pricing-table4">
    <div class="container">
      <div class="row">
        <!-- section title -->
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
          <h2 class="title-extra-large-2 letter-spacing-minus-1 text-dark-gray alt-font margin-three-bottom xs-margin-fifteen-bottom tz-text">Choose your best plan</h2>
        </div>
        <!-- end section title -->
      </div>
      <div class="row">
        <?php $cnt = 1; ?>
        <ul class="nav nav-pills">
          @foreach($plans as $ck)
          <li @if($cnt==1) class="active" @endif>
            <a href="#{{$ck->id}}a" data-toggle="tab">{{$ck->name}}</a>
          </li>
          <?php $cnt++; ?>
          @endforeach
        </ul>
        <div class="tab-content clearfix">
          <?php $cnts = 1; ?>
          @foreach($plans as $mk)
          <div class="tab-pane fade in @if($cnts == 1) active @endif" id="{{$mk->id}}a">
            <div class="pricing-box-style4 display-inline-block width-100">

              @foreach($mk->plans as $pk)
              <!-- pricing item -->
              <div class="col-md-4 col-sm-4 col-xs-12 text-center xs-margin-nine-bottom">
                <div class="pricing-box builder-bg tz-border border-2-fast-blue2">
                  <!-- pricing title -->
                  <div class="pricing-title text-center">
                    <h3 class="alt-font text-large text-dark-gray tz-text">{{$pk->name}}</h3>
                  </div>
                  <!-- end pricing title -->
                  <!-- pricing price -->
                  <div class="pricing-price bg-white builder-bg">
                    <h4 class="title-extra-large-2 sm-title-extra-large-2 alt-font font-weight-400 text-fast-blue2 tz-text">{{$pk->no_of_searches}}</h4>
                    <div class="text-small2 alt-font tz-text no-margin-bottom">
                      <p>Searches</p>
                    </div>
                  </div>
                  <!-- end pricing price -->
                  <!-- pricing features -->
                  <div class="pack-searches">
                    <p>&#8377;
                      <?php
                      echo number_format($pk->amount); ?>
                    </p>
                  </div>
                  <div class="pricing-price bg-white builder-bg">
                    <h4 class="title-extra-large-2 sm-title-extra-large-2 alt-font font-weight-400 text-fast-blue2 tz-text">{{$pk->max_users}}</h4>
                    <div class="text-small2 alt-font tz-text no-margin-bottom">
                      <p>Users</p>
                    </div>
                  </div>

                  <div class="pack-details">
                    <p>{{$pk->description}}</p>
                  </div>
                  <div class="pricing-action">
                    <a class="btn-medium btn btn-circle bg-fast-blue2 text-white no-letter-spacing" href="javascript:void(0);" onclick="showpopup()"><span class="tz-text">Get started!</span></a>
                  </div>
                  <!-- end pricing features -->
                </div>
              </div>
              <!-- end pricing item -->
              <?php $cnts++; ?>
              @endforeach

            </div>
          </div>
          @endforeach


        </div>
      </div>
    </div>
  </section>
  <!-- <section class="padding-60px-tb xs-padding-60px-tb bg-white builder-bg border-none " id="title-section13">
            <div class="container">
                
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12 title-small sm-title-small text-center center-col">
                        <span class="text-large text-fast-blue2 alt-font tz-text xs-margin-seven-bottom">LAUNCH YOUR STARTUP NOW!</span>
                        <h2 class="title-extra-large-2 letter-spacing-minus-1 text-dark-gray alt-font display-block tz-text xs-margin-seven-bottom">Get the most amazing builder!</h2>
                        <div class="text-medium display-block margin-three-top margin-six-bottom tz-text xs-margin-nine-bottom"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the an unknown printer took a galley of type scrambled it to make a type specimen book.</p></div>
                        <a href="#subscribe-section6" class="btn-medium btn-circle btn border-2-fast-blue2 btn-border text-fast-blue2"><span class="tz-text">BUILD WEBSITE</span><i class="fa fa-long-arrow-right text-extra-medium tz-icon-color"></i></a>
                    </div>
                </div>
               
            </div>
        </section> -->
  <!-- <section  class="no-padding cover-background tz-builder-bg-image border-none header-style25 bg-img-two" id="hero-section20" data-img-size="(W)1920px X (H)900px" style="background:linear-gradient(rgba(0,0,0,0.01), rgba(0,0,0,0.01)), url('{{url('/')}}/home-assets/landing-page/images/bg-image/header-25.jpg')">
            <div class="container one-fourth-screen sm-height-auto position-relative">
                <div class="slider-typography text-center sm-position-relative">
                    <div class="slider-text-middle-main">
                        <div class="slider-text-middle text-left sm-padding-nineteen sm-no-padding-lr xs-text-center">
                            
                            <div class="col-md-6 col-sm-12 col-xs-12 sm-text-center xs-no-padding-lr">
                                <h1 class="title-extra-large-4 md-title-extra-large-3 line-height-65 sm-title-extra-large alt-font letter-spacing-minus-1 xs-title-extra-large text-white margin-eight-bottom sm-margin-four-bottom tz-text">Discover our awesome video presentation.</h1>
                                <div class="text-white title-small line-height-34 font-weight-100 width-100 xs-text-extra-large tz-text margin-thirteen-bottom sm-margin-six-bottom xs-margin-eleven-bottom sm-margin-nine-bottom"><p>Lorem Ipsum is simply dummy text of the printing & typesetting industry. Lorem Ipsum has been the industry's standard dummy. Lorem Ipsum is simply dummy text.</p></div>
                                <div class="btn-dual">
                                    <a class="btn btn-large btn-circle propClone bg-white text-dark-gray xs-margin-lr-auto xs-float-none xs-display-block" href="#"><span class="tz-text">WATCH VIDEO</span><i class="fa fa-play-circle text-extra-medium tz-icon-color"></i></a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 col-xs-12 text-center outside-image sm-position-relative xs-no-padding-lr">
                                <div class="outside-image-sub height-80 margin-twenty-three-top">
                                    <img src="{{url('/')}}/home-assets/landing-page/images/infographic-4.png" data-img-size="(W)1420px X (H)793px" alt="" class="sm-width-100"/>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
  <section class="padding-60px-tb xs-padding-60px-tb no-padding-top" id="content-section32">
    <div class="d-flex video-block row">
      <div class="col-md-6 col-col-lg-6 col-sm-12 col-xs-12">
        <div class="content">
          <h4>Looking for a Job?</h4>
          <p>GET HIRED<br />
            GET CAREER INSIGHTS</p>
          <a href="#" class="btn btn-borderonly" data-toggle="modal" data-target="#demo-upload">Upload your Profile</a>
        </div>
      </div>
      <div class="col-md-6 col-col-lg-6 col-sm-12 col-xs-12">
        <video loop autoplay muted style="height: calc(100vh - 122px);">
          <source src="{{url('/')}}/home-assets/landing-page/images/videoblocks-young-professional-meets-a-senior-executive-and-shakes-hands-in-slow-motion_rc2j-brgf_1080__D.mp4" type="video/mp4">
          <source src="{{url('/')}}/home-assets/landing-page/images/videoblocks-young-professional-meets-a-senior-executive-and-shakes-hands-in-slow-motion_rc2j-brgf_1080__D.ogg" type="video/ogg">
        </video>
        <p class="no-margin-bottom padding-top-15px">DON'T STOP REACHING</p>
      </div>
    </div>
  </section>
  <!-- <section id="testimonials-section10" class="bg-white builder-bg padding-60px-tb testimonial-style10 xs-padding-60px-tb">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-7 col-sm-9 col-xs-12 xs-text-center center-col">
                        <div class="col-md-3 col-sm-3 col-xs-12 sm-no-padding xs-margin-eleven-bottom">
                            <img class="border-radius-100 width-95 xs-width-40" src="{{url('/')}}/home-assets/landing-page/images/avtar.jpg" data-img-size="(W)149px X (H)149px" alt=""/>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12 feature-box-details">
                            <div class="text-medium float-left width-100 tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p></div>
                            <span class="tz-text font-weight-500 alt-font text-dark-gray sm-text-medium display-inline-block">ALEXANDER HARVARD</span>
                            <span class="tz-text alt-font text-extra-small display-block">GOOGLE INC</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section> -->
  <!-- <section class="padding-60px-tb xs-padding-60px-tb bg-light-gray builder-bg" id="content-section32">
            <div class="container">
                <div class="row equalize xs-equalize-auto equalize-display-inherit">
                    <div class="col-lg-5 col-md-6 col-sm-6 xs-12 xs-text-center xs-margin-nineteen-bottom display-table">
                        <div class="display-table-cell-vertical-middle">
                            <div class="sm-margin-five-bottom alt-font text-fast-blue2 font-weight-400 text-extra-large tz-text">Discover our awesomeness.</div>
                            <h2 class="alt-font title-extra-large sm-title-large xs-title-large text-dark-gray margin-eight-bottom tz-text sm-margin-ten-bottom letter-spacing-minus-1">Create high converting landing page in minutes.</h2>
                            <div class="text-medium tz-text width-90 sm-width-100 margin-seven-bottom sm-margin-ten-bottom"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p></div>
                            <div class="text-medium tz-text width-90 sm-width-100 margin-fifteen-bottom sm-margin-ten-bottom"><p>Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer.</p></div>
                            <a class="btn btn-medium propClone btn-circle bg-fast-blue2 text-white" href="#subscribe-section6"><span class="tz-text">CREATE YOUR ACCOUNT</span><i class="fa fa-angle-right text-extra-medium tz-icon-color"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 xs-12 xs-text-center display-table">
                        <div class="display-table-cell-vertical-middle">
                            <img alt="" src="{{url('/')}}/home-assets/landing-page/images/infographic1.png" data-img-size="(W)800px X (H)785px">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
  <!-- <section id="clients-section2" class="padding-60px-tb bg-white builder-bg clients-section2 xs-padding-top-60px">
            <div class="container">
                <div class="row">
                    <div class="owl-slider-style4 owl-carousel owl-theme owl-no-pagination owl-dark-pagination outside-arrow-simple black-pagination sm-no-owl-buttons sm-show-pagination owl-pagination-bottom">
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="{{url('/')}}/home-assets/landing-page/images/clients-1.jpg" id="tz-bg-149" data-img-size="(W)800px X (H)500px" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="{{url('/')}}/home-assets/landing-page/images/clients-2.jpg" id="tz-bg-150" data-img-size="(W)800px X (H)500px" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="{{url('/')}}/home-assets/landing-page/images/clients-3.jpg" id="tz-bg-151" data-img-size="(W)800px X (H)500px" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="{{url('/')}}/home-assets/landing-page/images/clients-4.jpg" id="tz-bg-152" data-img-size="(W)800px X (H)500px" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="{{url('/')}}/home-assets/landing-page/images/clients-5.jpg" id="tz-bg-153" data-img-size="(W)800px X (H)500px" alt=""/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
  <section class="padding-60px-tb xs-padding-60px-tb bg-light-gray builder-bg" id="contact-section5">
    <div class="container">
      <div class="row">
        <div class="col-md-8 center-col col-sm-12 text-center">
          <h2 class="title-extra-large-2 letter-spacing-minus-1 text-dark-gray alt-font margin-four-bottom tz-text">Contact Us</h2>
        </div>
        <p class="alert alert-danger text-center" style="display: none;" id="contacterror">Some error occured please try after some time</p>
        <p class="alert alert-success text-center" style="display: none;" id="contactsuccess">Thank you for reaching us. We will contact you shortly.</p>
        <div class="col-md-6 center-col col-sm-12 text-center">
          <form id="contactus" name="contactus" action="javascript:void(0)" method="post">
            <input type="text" name="name" id="name" data-email="required" placeholder="Your Name" class="big-input bg-white alt-font border-radius-4">
            <input type="text" name="email" id="email" data-email="required" placeholder="Your Email" class="big-input bg-white alt-font border-radius-4">
            <input type="number" name="phone" id="phoneno" data-email="required" placeholder="Your Phone Number" class="big-input bg-white alt-font border-radius-4">
            <textarea class="big-input bg-white alt-font border-radius-4" placeholder="Your Message" rows="3" name="message"></textarea>

            <div class="section text-center" id="cont_preload" style="display: none;">
              <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
            </div>

            <button type="button" id="contactus_button" onclick="sendcontactus()" class="btn btn-primary">SEND</button>
          </form>

          <div class="margin-seven-top text-small2 sm-width-100 center-col tz-text xs-line-height-20">* We don't share your personal info with anyone.</div>
        </div>
      </div>
    </div>
  </section>
  <!-- <section class="padding-60px-tb bg-white builder-bg xs-padding-60px-tb" id="contact-section5">
            <div class="container">
                <div class="row four-column">
                    <div class="col-md-3 col-sm-6 col-xs-12 sm-margin-nine-bottom xs-margin-fifteen-bottom text-center sm-clear-both">
                        <div class="feature-box xs-margin-thirteen xs-no-margin-tb">
                            <i class="fa ti-location-pin text-fast-blue2 icon-large tz-icon-color margin-ten-bottom xs-margin-seven-bottom"></i>
                            <h3 class="feature-title text-dark-gray text-medium alt-font display-block margin-three-bottom xs-margin-five-bottom tz-text font-weight-500">Contact Address</h3>
                            <div class="feature-text text-medium center-col tz-text">301 The Greenhouse, Custard,<br>Factory, London, E2 8DY.</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 sm-margin-nine-bottom xs-margin-fifteen-bottom text-center">
                        <div class="feature-box xs-margin-thirteen xs-no-margin-tb">
                            <i class="fa ti-mobile text-fast-blue2 icon-large tz-icon-color margin-ten-bottom xs-margin-seven-bottom"></i>
                            <h3 class="feature-title text-dark-gray text-medium alt-font display-block margin-three-bottom xs-margin-five-bottom tz-text font-weight-500">Call Us Today!</h3>
                            <div class="feature-text text-medium center-col tz-text">(M) +44 (0) 123 456 7890<br>(O) +44 (0) 123 456 7890</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 text-center xs-margin-fifteen-bottom sm-clear-both">
                        <div class="feature-box xs-margin-thirteen xs-no-margin-tb">
                            <i class="fa ti-email text-fast-blue2 icon-large tz-icon-color margin-ten-bottom xs-margin-seven-bottom"></i>
                            <h3 class="feature-title text-dark-gray text-medium alt-font display-block margin-three-bottom xs-margin-five-bottom tz-text font-weight-500">Email</h3>
                            <div class="feature-text text-medium center-col"><a class="tz-text" href="mailto:no-reply@domain.com">no-reply@domain.com</a><br><a class="tz-text" href="mailto:help@domain.com">help@domain.com</a></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                        <div class="feature-box xs-margin-thirteen xs-no-margin-tb">
                            <i class="fa ti-time text-fast-blue2 icon-large tz-icon-color margin-ten-bottom xs-margin-seven-bottom"></i>
                            <h3 class="feature-title text-dark-gray text-medium alt-font display-block margin-three-bottom xs-margin-five-bottom tz-text font-weight-500">Working Hours</h3>
                            <div class="feature-text text-medium center-col tz-text">Mon to Sat - 9 AM to 11 PM<br>Sunday - 10 AM to 6 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
  <footer id="footer-section4" class="bg-white builder-bg padding-top-15px padding-bottom-15px footer-style4">
    <div class="container">
      <div class="row equalize sm-equalize-auto">
        <!-- logo -->
        <!-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sm-text-center sm-margin-five-bottom xs-margin-nine-bottom display-table">
                        <div class="display-table-cell-vertical-middle">
                            <a href="#home" class="inner-link"><img src="{{url('/')}}/home-assets/landing-page/images/logo.png" alt="" data-img-size="(W)163px X (H)39px"></a>
                        </div>
                    </div> -->
        <!-- end logo -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sm-margin-three-bottom text-center xs-text-center display-table">
          <div class="display-table-cell-vertical-middle">

            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
              <span class="float-md-left d-block d-md-inline-block">Copyright &copy; {{date('Y')}} <a class="text-bold-800 grey darken-2" href="https://www.sentientscripts.com/" target="_blank">Sentient Scripts </a>, All rights reserved. </span>
              <span class="float-md-left d-block d-md-inline-block">Various trademarks held by their respective owners </span>
              <span class="float-md-left d-block d-md-inline-block"><a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/privacy-policy">. Privacy Policy</a> | <a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/terms-and-conditions"> Terms & Conditions</a> | <a target="_blank" class="text-bold-800 grey darken-2" href="{{url('/')}}/return-and-refund">Return and Refund</a> </span>
              <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"></span>
            </p>

          </div>
        </div>
        <!-- social elements -->
        <!-- <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 text-right sm-text-center display-table">
                        <div class="social icon-extra-small display-table-cell-vertical-middle">
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-facebook tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-twitter tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-google-plus tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-pinterest tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-linkedin tz-icon-color"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-youtube tz-icon-color"></i>
                            </a>
                        </div>
                    </div> -->
        <!-- end social elements -->
      </div>
    </div>
  </footer>


  <!-- Modals -->
  <!-- [ Modal #1 ] -->
  <div class="login-modal modal fade" id="demo-1" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <div class="text-center" style="flex-direction: column;">
              <h4>Sign in to Pep Hire</h4>
              <p></p>
            </div>
            <form method="POST" id="formlogin" action="{{ route('login') }}">
              @csrf
              <div class="section">
                <label class="control-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="">
              </div>
              <div class="section">
                <label class="control-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="">
              </div>
              <p class="alert alert-danger text-center" style="display: none;" id="logerror">Invalid Email/Password</p>

              <p class="alert alert-danger text-center" style="display: none;" id="logmultyerror">This credential is already logged in from another device!</p>

              <div class="section text-center" id="reg_preloader_one" style="display: none;">
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>

              <div class="section">
                <button type="button" onclick="signin()" class="btn btn-primary">Sign In</button>
              </div>
            </form>
            <div class="text-center" style="margin: 0;">
              <p style="margin: 0;">Don't have an account? <a href="#" data-dismiss="modal" data-target="#demo-2" data-toggle="modal">Sign Up</a></p>
              <p style="margin: 5px 0 0 0;"><a href="#" data-dismiss="modal" data-target="#demo-3" data-toggle="modal">Forgot password</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Modal #2 ] -->
  <div class="login-modal modal fade" id="demo-2" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <form id="orgcreate" method="POST" action="{{ url('/organization/register') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Full Name</label>
                  <input type="text" name="name" class="form-control" placeholder="">
                </div>
                <div class="col-md-12">
                  <label class="control-label">Email address</label>
                  <input type="email" id="createemail" name="email" class="form-control" placeholder="">
                </div>
                <div class="col-md-12">
                  <label class="control-label">Phone</label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="tel" id="userphone" name="userphone" class="form-control" placeholder="" rew>
                    </div>
                    <div class="col-md-8">
                      <input type="number" id="reg_phone" name="reg_phone" class="form-control" placeholder="" rew>
                    </div>
                  </div>
                </div>
              </div>
              <div class="section">
                I Accept the <a href="{{url('/')}}/terms-and-conditions" target="_blank">Terms & Conditions</a> <input type="checkbox" name="termscon" value="">
              </div>

              <div class="section text-center" id="reg_preloader" style="display: none;">
                <label class="control-label">Registering your details</label>
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>

              <div class="section">
                <button type="button" onclick="submitsignup()" class="btn btn-primary">Sign Up</button>
              </div>

            </form>
            <div class="text-center" style="margin: 0;">
              <p style="margin: 0;">Already have an account? <a href="#" data-dismiss="modal" data-target="#demo-1" data-toggle="modal">Sign In</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Modal #3 ] -->
  <div class="login-modal modal fade" id="demo-3" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <div class="text-center" style="flex-direction: column;">
              <h4>Forgot Password</h4>
              <p></p>
            </div>
            <form id="pwdResetForm" method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="text-center msg-div" style="flex-direction: column; color: green; display:none;">
                Password Reset Link will be sent to the Email ID shortly, if the Email ID is a registered one
              </div>
              <div class="section">
                <label class="control-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="" required="">
              </div>

              <div class="section text-center" id="reg_preloader_one" style="display: none;">
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>

              <div class="section">
                <button type="button" id="pwdResetBtn" class="btn btn-primary">Send</button>
              </div>
            </form>
            <div class="text-center" style="margin: 0;">
              <p style="margin: 0;">Already have an account? <a href="#" data-dismiss="modal" data-target="#demo-1" data-toggle="modal">Sign In</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Modal #4 ] -->
  <div class="login-modal modal fade" id="demo-upload" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <form method="POST" action="" id="createuser">
              @csrf
              <div class="section">
                <label class="control-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="">
              </div>
              <div class="section">
                <label class="control-label">Prefered Job Location</label>
                <input type="text" name="job_location" class="form-control" placeholder="">
              </div>
              <div class="section">
                <label class="control-label">Email address</label>
                <input type="email" id="createemail" name="email" class="form-control" placeholder="">
              </div>
              <div class="section">
                <label class="control-label">Phone</label>
                <input type="phone" id="userphone" name="phone" class="form-control" placeholder="">
              </div>

              <div class="section text-center" id="save_preload" style="display: none;">
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>


              <div class="section">
                <button type="button" class="btn btn-primary" onclick="saveuser()">Send</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Modal #5 ] -->
  <div class="login-modal modal fade" id="demo-otp" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <!-- <div class="text-center" style="flex-direction: column;">
                          <h4>Enter OTP</h4>
                          <p></p>
                        </div> -->
            <form method="POST" action="" id="otp_form">
              @csrf
              <div class="section">
                <label class="control-label">Enter OTP</label>
                <input type="text" name="otp_code" class="form-control" placeholder="">
              </div>
              <input type="hidden" name="pendingid" id="pendingid" value="">
              <div class="section text-center" id="otp_preload" style="display: none;">
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>

              <div id="timer_id"></div>

              <div class="section">
                <button type="button" class="btn btn-primary" onclick="submitotp()">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- [ Modal #5 ] -->
  <div class="login-modal modal fade" id="demo-profile" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-block">
            <a class="close" data-dismiss="modal">x</a>
            <div class="text-center">
              <img src="assets/images/logo/logo.png">
            </div>
            <!-- <div class="text-center" style="flex-direction: column;">
                          <h4>Upload Resume</h4>
                          <p></p>
                        </div> -->
            <form method="POST" enctype="multipart/form-data" id="uploadresumeid" action="">
              @csrf
              <div class="section">
                <label class="control-label">Upload Resume</label>
                <div class="dropzone">
                  <input type="file" name="resume" class="form-control" placeholder="" id="pop_res_upload">
                  <span class="border-only" id="up_res_name"></span>
                </div>
                <input type="hidden" name="userid" id="profile_user">
              </div>

              <div class="section text-center" id="resume_preload" style="display: none;">
                <img src="{{url('/assets/images/Ripple-1s-75px.gif')}}" alt="preloader-signup">
              </div>

              <div class="section">
                <button type="button" class="btn btn-primary" onclick="submitcv()">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modals -->

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <script type="text/javascript">
    function showpopup() {
      $("#demo-1").modal('show');
    }

    $(document).ready(function() {

      $("#pwdResetForm").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email: {
            required: "Please enter email",
            email: "Please enter valid email"
          }
        },
      });

      $("#pwdResetBtn").click(function() {
        if ($("#pwdResetForm").valid()) {
          $(this).prop('disabled', true);
          $(".msg-div").show();
          setTimeout(function() {
            $("#pwdResetForm").submit();
            // $(".msg-div").hide();
            // $(this).prop('disabled', false);
          }, 3000);
        }
      });

      $("#formlogin").keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
          signin();
        }
      });

      $("#orgcreate").keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
          submitsignup();
        }
      });

      $("#orgcreate").validate({
        rules: {
          name: {
            required: true
          },
          termscon: {
            required: true
          },
          userphone: {
            required: true
          },
          email: {
            required: true,
            email: true,
            remote: {
              url: "{{url('/checkemailexist')}}",
              type: "post",
              data: {
                email: function() {
                  return $("#createemail").val();
                }
              }
            }
          }
        },
        messages: {
          name: {
            required: "Please enter your name"
          },
          termscon: {
            required: "Please accept the terms and conditions"
          },
          userphone: {
            required: "Please enter a phone number"
          },
          email: {
            required: "Please enter email",
            email: "Please enter valid email",
            remote: "This email is already in use with another user"
          }
        },
      });


      $("#formlogin").validate({
        rules: {
          password: {
            required: true
          },
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          password: {
            required: "Please enter your password"
          },
          email: {
            required: "Please enter email",
            email: "Please enter valid email"
          }
        },
      });


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

      });

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    });


    function signin() {
      if ($("#formlogin").valid()) {
        $("#reg_preloader_one").show();
        $.ajax({
          url: "{{url('/loginajax')}}",
          type: "post",
          data: $("#formlogin").serialize(),
          success: function(data) {

            if (data.success == 1) {
              window.location.href = "{{url('/profiledatabase')}}";
              // $("#reg_preloader_one").show();

            } else if (data.error == 1) {
              $("#reg_preloader_one").hide();
              $("#logerror").show();
              setTimeout(function() {
                $("#logerror").hide();
              }, 2500);
            } else if (data.multyerror == 1) {
              $("#reg_preloader_one").hide();
              $("#logmultyerror").show();
              //setTimeout(function(){ $("#logmultyerror").hide(); }, 2500);
            }
          }
        });
      }
    }

    function submitsignup() {
      if ($("#orgcreate").valid()) {
        // $("#reg_preloader").show();
        $("#orgcreate").submit();
      }
    }

    function sendcontactus() {
      if ($("#contactus").valid()) {
        $("#cont_preload").show();
        $('#contactus_button').prop('disabled', true);

        $.ajax({
          url: "{{url('/homecontactus')}}",
          type: "post",
          data: $("#contactus").serialize(),
          success: function(data) {
            if (data.success == 1) {
              $("#contactsuccess").show();
              $("#contactus")[0].reset();
              $("#cont_preload").hide();
              $('#contactus_button').prop('disabled', false);
              setTimeout(function() {
                $("#contactsuccess").hide();
              }, 4000);
            } else if (data.error == 1) {
              $("#contacterror").show();
              $("#contactus")[0].reset();
              $("#cont_preload").hide();
              $('#contactus_button').prop('disabled', false);
              setTimeout(function() {
                $("#contacterror").hide();
              }, 4000);
            }
          }
        });

      }
    }

    $(document).ready(function() {
      $('#createuser').validate({
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
          job_location: {
            required: true
          }
        },
        messages: {
          name: {
            required: "Please enter yor name"
          },
          email: {
            required: "Please enter your email address",
            email: "Please enter a valid email id"
          },
          phone: {
            required: "Please ener your phone number"
          },
          job_location: {
            required: "Please enter your preference"
          }
        },
        errorPlacement: function(error, element) {
          error.appendTo(element.parent());
        }
      });


      $('#otp_form').validate({
        rules: {
          name: {
            otp_code: true
          }
        },
        messages: {
          name: {
            otp_code: "Please enter OTP"
          }
        },
        errorPlacement: function(error, element) {
          error.appendTo(element.parent());
        }
      });

    });


    var timeLeft = 30;
    var timerID = "";

    function saveuser() {
      if ($("#createuser").valid()) {
        $("#save_preload").show();
        $("#createuser").ajaxSubmit({
          url: "{{url('/createnewcandidate')}}",
          type: 'post',
          success: function(data) {
            if (data.success) {
              $("#save_preload").hide();
              $("#demo-upload").modal('hide');
              $("#createuser")[0].reset();
              $("#pendingid").val(data.userid);
              $("#profile_user").val(data.userid);
              $("#demo-otp").modal('show');
              timeLeft = 30;
              timerID = setInterval(countdown, 1000);
            } else {
              $("#save_preload").hide();
              $("#demo-upload").modal('hide');
              $("#createuser")[0].reset();
              Swal.fire(
                'Warning',
                'Request cannot complete now, please try after some time.',
                'warning'
              )
            }
          }
        });
      }
    }

    function submitotp() {
      if ($("#otp_form").valid()) {
        $("#otp_preload").show();
        $("#otp_form").ajaxSubmit({
          url: "{{url('/verifyotp')}}",
          type: 'post',
          success: function(data) {
            if (data.success) {
              $("#demo-otp").modal('hide');
              $("#otp_form")[0].reset();
              $("#demo-profile").modal('show');
            } else if (data.otperrror) {
              $("#otp_preload").hide();
              $("#demo-otp").modal('hide');
              //$("#otp_form")[0].reset();
              Swal.fire(
                'Warning',
                'Please enter a valid OTP',
                'warning'
              ).then((result) => {
                $("#demo-otp").modal('show');
              })
            } else {
              $("#otp_preload").hide();
              $("#demo-otp").modal('hide');
              $("#otp_form")[0].reset();
              Swal.fire(
                'Warning',
                'Request cannot complete now, please try after some time.',
                'warning'
              )
            }
          }
        });
      }
    }

    function countdown() {
      var elem = document.getElementById('timer_id');
      if (timeLeft == 0) {
        clearTimeout(timerID);
        elem.innerHTML = "<a onclick='resentotp()'>Resent OTP</a>";
      } else {
        elem.innerHTML = timeLeft + ' Resent OTP';
        timeLeft--;
      }
    }

    function resentotp() {
      $("#timer_id").hide();
      $("#otp_preload").show();
      var userid = $("#pendingid").val();
      $.ajax({
        url: "{{url('/resentotp')}}",
        type: "post",
        data: {
          'userid': userid
        },
        success: function(data) {
          if (data.success == 1) {
            $("#otp_preload").hide();
            $("#timer_id").show();
            timeLeft = 30;
            timerID = setInterval(countdown, 1000);
          } else {
            $("#otp_preload").hide();
            $("#timer_id").show();
            timeLeft = 30;
            timerID = setInterval(countdown, 1000);
            Swal.fire(
              'Warning',
              'Request cannot complete now, please try after some time.',
              'warning'
            )
          }
        }
      });
    }


    function submitcv() {
      $("#resume_preload").show();
      $("#uploadresumeid").ajaxSubmit({
        url: "{{url('/submitresume')}}",
        type: 'post',
        success: function(data) {
          if (data.success) {
            $("#resume_preload").hide();
            $("#demo-profile").modal('hide');
            $("#uploadresumeid")[0].reset();
            Swal.fire(
              'Success',
              'Your profile has been registered successfully',
              'success'
            )
          } else {
            $("#resume_preload").hide();
            $("#demo-upload").modal('hide');
            $("#uploadresumeid")[0].reset();
            Swal.fire(
              'Warning',
              'Request cannot complete now, please try after some time.',
              'warning'
            )
          }
        }
      });
    }

    $(document).ready(function() {
      $('#pop_res_upload').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#up_res_name").html(fileName);
      });
    });
  </script>

  <?php if (isset($_GET['type']) && $_GET['type'] == 'loginpop') {  ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#signin_button").trigger("click");
      });
    </script>
  <?php } ?>
  <script src="{{url('/')}}/build/js/intlTelInput.js"></script>
  <script>
    // Vanilla Javascript
    var input = document.querySelector("#userphone");
    window.intlTelInput(input, ({
      // options here
    }));

    $(document).ready(function() {
      $('.iti__flag-container').click(function() {
        var countryCode = $('.iti__selected-flag').attr('title');
        var countryCode = countryCode.replace(/[^0-9]/g, '')
        $('#userphone').val("");
        $('#userphone').val(" " + " " + " " + " " + " " + " " + " " + " " + " " + countryCode);
      });
    });
  </script>
</body>

</html>w