<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PepHire') }}</title>

  <link rel="icon" href="{{url('/')}}/favicon.png" type="image/png">
  <link rel="apple-touch-icon" href="{{url('/')}}/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/favicon.png">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/vendors.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/app.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/tables/datatable/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/core/menu/menu-types/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/fonts/simple-line-icons/style.css">
  <!-- END Page Level CSS-->
  @stack('styles')

  <!--Start of Tawk.to Script-->
  <!--End of Tawk.to Script-->
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

  <main>
      @yield('header')

      @yield('sidebar')

      @yield('content')

      @yield('footer')
  </main>

  <!-- BEGIN VENDOR JS-->
  <script src="{{url('/')}}/assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{url('/')}}/assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
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