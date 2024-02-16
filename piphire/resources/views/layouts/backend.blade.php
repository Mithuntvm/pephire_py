<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'PepHire') }}</title>

  <link rel="icon" href="{{url('/')}}/favicon.png" type="image/png">
  <link rel="apple-touch-icon" href="{{url('/')}}/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/favicon.png">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/vendors/css/tables/datatable/datatables.min.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/app.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/core/colors/palette-gradient.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/app-assets/css/plugins/forms/checkboxes-radios.css">
  <!-- END Custom CSS-->
  @stack('styles')
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

      <div class="pip_admin">
      {{-- <main> --}}
        @yield('header')

        @yield('sidebar')

        @yield('content')

        @yield('footer')
      {{-- </main> --}}
      </div>

  <!-- BEGIN VENDOR JS-->
  <script src="{{url('/')}}/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{url('/')}}/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"
  type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/buttons.flash.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/jszip.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/pdfmake.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/vfs_fonts.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/buttons.html5.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/vendors/js/tables/buttons.print.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{url('/')}}/app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/js/core/app.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{url('/')}}/app-assets/js/scripts/tables/datatables/datatable-advanced.js"
  type="text/javascript"></script>

  <script src="{{url('/')}}/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/app-assets/js/scripts/forms/checkbox-radio.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  @stack('scripts')
</body>
</html>