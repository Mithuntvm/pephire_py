<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<title>PepHire</title>

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
	<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
	<!-- END Custom CSS-->

	<style type="text/css">
		/* Parsley CSS */
		/*input:not([type=radio]).parsley-success,
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
		}*/

		.btnblock-new {
			display: none;
		}

		.candidate-formblock .form-section {
			margin-top: 10px;
		}

		.candidate-formblock .form-section label.control-label {
			margin-top: .5rem;
		}
	</style>
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
	<!-- fixed-top-->
	<nav class="header-navbar candidate-header navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-header">
				<ul class="nav navbar-nav flex-row">
					<li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
					<li class="nav-item mr-auto">
						<a class="navbar-brand" href="index.html">
							<img class="brand-logo" alt="modern admin logo" src="{{url('/')}}/assets/images/logo/logo.png">
							<h3 class="brand-text"></h3>
						</a>
					</li>
					<li class="nav-item d-md-none">
						<a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
					</li>
				</ul>
			</div>
	</nav>
	<div class="app-content fullwidth-content content">
		<div class="content-wrapper">
			<div class="content-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<h4 class="titlehead"><span>Interview Details</span></h4>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="candidate-formblock" data-parsley-validate="">
								@php $interviewersArr = array(); @endphp

								@foreach($timeslots as $date => $interviewers)
								@foreach($interviewers as $name => $timeslots)
								@php
								if (false !== $key = array_search($name, $interviewersArr)) {
								$interviewerIndex = $key + 1;
								} else {
								$interviewersArr[] = $name;
								$interviewerIndex = key(array_slice($interviewersArr, -1, 1, true)) + 1;
								}
								@endphp
								<div class="form-section col-md-12 col-sm-12 col-xs-12">
									<h4>Interviewer {{ $interviewerIndex }} <span> - ({{ $date }})</span></h4>
									<label class="control-label">Select Time Slot</label>
									<ul class="row timeslots">
										@foreach($timeslots as $timeslot)
										<li class="col-md-2 col-sm-3 col-xs-6" data-id="{{ $timeslot->id }}">
											<div> {{ date("g:i A", $timeslot->interview_start_time) }}
												<!-- to
															{{ date("g:i A", $timeslot->interview_end_time) }} -->
											</div>
										</li>
										@endforeach
									</ul>
								</div>
								@endforeach
								@endforeach

								<div class="btnblock-new">
									<a href="javascript:void(0);" onclick="submitTimeSlot(this);" class="btn btn-primary">Submit</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style type="text/css">
		#loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			/*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
			opacity: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			background: rgba(255, 255, 255, 0.95)
		}

		#loader .nb-spinner {
			width: 75px;
			height: 75px;
			margin: 0;
			background: transparent;
			border-top: 4px solid #2E5BFF;
			border-right: 4px solid transparent;
			border-radius: 50%;
			-webkit-animation: 1s spin linear infinite;
			animation: 1s spin linear infinite;
			position: relative;
			z-index: 999;
		}

		#loader span {
			position: relative;
			top: -20px;
			color: #000;
			font-size: 24px;
			z-index: 99;
		}
	</style>

	<div id="loader" style="display: none;">
		<span style=""> Please wait while we schedule your Interview ...</span>
		<div class="nb-spinner"></div>
	</div>
	

	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<footer class="footer footer-static footer-light navbar-border navbar-shadow">
		<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
			<span class="float-md-left d-block d-md-inline-block">Copyright © 2023 <a class="text-bold-800 grey darken-2" href="https://www.sentientscripts.com/" target="_blank">Sentient Scripts </a>, All rights reserved.
			</span>
			<span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"></span>
		</p>
	</footer>
	<!-- BEGIN VENDOR JS-->
	<script src="{{url('/')}}/assets/vendors/js/vendors.min.js" type="text/javascript"></script>
	<!-- BEGIN VENDOR JS-->
	<!-- BEGIN PAGE VENDOR JS-->
	<!-- BEGIN MODERN JS-->
	<script src="{{url('/')}}/assets/js/core/app-menu.js" type="text/javascript"></script>
	<script src="{{url('/')}}/assets/js/core/app.js" type="text/javascript"></script>

	<!-- END MODERN JS-->
	

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- Parsley -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" type="text/javascript"></script> -->
	<script type="text/javascript">
		$(function() {

			$('body').on('click', '.timeslots li', function() {
				$(".timeslots li").removeClass('active');
				$(this).addClass('active');
				$(".btnblock-new").show();
			});


		});

		function submitTimeSlot(elm) {

			$("#loader").show();
			$(elm).css('pointer-events', 'none');

			$.ajax({
				url: "{{ URL::route('candidateTimeslot.update', $sluid) }}",
				dataType: 'json',
				type: 'POST',
				data: {
					timeslot: $(".timeslots li.active").attr('data-id'),
					_token: "{{ csrf_token() }}",
				},
				success: function(response) {
					console.log(response)
					if (response.status) {
						$("#loader").hide();
						window.location.href = response.redirect_url;

					} else {
						location.reload();
					}
				},
				error: function(response) {
					$("#loader").hide();
					console.log('inside ajax error handler');
				}
			});
		}
	</script>
</body>

</html>