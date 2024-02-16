<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <!--Start of Tawk.to Script-->

    <!--End of Tawk.to Script-->

    <style>
        .btn-dual .btn {
            margin: 0 12px 0 0;
        }
    </style>
</head>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

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
                        OTP is send to the Email ID Successfully
                    </div>
                    <br>
                    <div class="card-body">
                        <h6 class="card-title"></h6>


                        <form id="session_otp" method="post" action="">
                            @csrf
                            <div class="section">
                                <label class="control-label">Enter valid OTP</label>
                                <br>
                                <input type="hidden" value="<?php echo $otp;  ?>" name="otp">
                                <input type="hidden" value="<?php echo $email;  ?>" name="email">
                                <input type="text" name="otp_new" value="" class="form-control" placeholder="">
                            </div><br>
                            <?php
                            // if($error)
                            // {
                            ?>
                            <p class="alert alert-danger text-center" style="display: none;" id="logerror">Invalid otp</p>

                            <?php
                            // }
                            ?>
                            <br>
                            <div class="section">
                                <button type="button" onclick="verifyotp()" class="btn btn-primary" style="margin-top: 100px;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <script>
        function verifyotp() {
            $.ajax({
                url: "{{url('/verify_otp')}}",
                type: 'post',
                data: {
                    'frm': $("#session_otp").serialize(),
                    "_token": "{{ csrf_token() }}",

                },
                success: function(data) {

                    if (data.success == 1) {
                        console.log("ppppppppppppppppppppppp")
                        window.location.href = "{{url('/')}}";
                        

                    } else if (data.error == 1) {
                        // $("#reg_preloader_one").hide();
                        $("#logerror").show();
                        setTimeout(function() {
                            $("#logerror").hide();
                        }, 2500);
                    }
                    
                }
               
            });

        }

    </script>
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