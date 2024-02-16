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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">

	<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/style.css">
	<!-- END Custom CSS-->

	<style type="text/css">
		/* Parsley CSS */
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
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" onload="myFunction()">
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
							<h4 class="titlehead"><span>Candidate Profile</span></h4>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="candidate-formblock" data-parsley-validate="">
								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Name *</label>
									<input type="text" name="name" class="form-control" value="{{ $candidate->name }}" required data-parsley-required-message="Please enter Name">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Email *</label>
									<input type="email" name="email" class="form-control" value="{{ $candidate->email }}" required data-parsley-required-message="Please enter Email">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Mobile Number *</label>
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

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<!-- <label class="control-label">Age {!! $age !!}</label> -->
									<label class="control-label">D.O.B *</label>
									<input type="text" name="dob" class="form-control datepicker" value="{{ $candidate->dob }}" required data-parsley-required-message="Please enter Date of Birth">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Gender *</label>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="sex" id="male" value="Male" required data-parsley-required-message="Please select Gender" @if($candidate->sex == 'Male') checked @endif>
										<label class="form-check-label" for="male">Male</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="sex" id="female" value="Female" @if($candidate->sex == 'Female') checked @endif>
										<label class="form-check-label" for="female">Female</label>
									</div>
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Marital Status *</label>
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

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Education *</label>
									<input type="text" name="education" class="form-control" value="{{ $candidate->education }}" placeholder="Please enter Education">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Experience *</label>
									<input type="text" name="experience" id="experience" class="form-control" value="{{ $candidate->experience }}" placeholder="Please enter Experience" onchange="hi()">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Passport Number *</label>
									<input type="text" name="passport_no" class="form-control" value="{{ $candidate->passport_no }}" placeholder="Please enter Passport Number">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Visa Type *</label>
									<input type="text" name="visatype" class="form-control" value="{{ $candidate->visatype }}" placeholder="Please enter Visa Type">
								</div>
								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Linkedin</label>
									<input type="text" name="linkedin_id" class="form-control" value="{{ $candidate->linkedin_id }}">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Location *</label>
									<input type="text" name="location" class="form-control" value="{{ $candidate->location }}" placeholder="Please enter Location" />
								</div>
								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Are you open to relocating(Y/N) *</label>
									<input type="text" name="relocate" id="relocate" class="form-control" value="{{ $candidate->relocate }}" placeholder="">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">

									<label class="control-label">Preffered Location</label>

									<input type="text" name="pre_loc" id="pre_loc" class="form-control" value="{{ $candidate->preffered_location }}">

								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">

									<label class="control-label">Current CTC</label>

									<input type="text" name="curr_ctc" id="curr_ctc" class="form-control" value="{{ $candidate->current_ctc }}">

								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Expected CTC</label>
									<input type="text" name="ctc" id="ctc" class="form-control" value="{{ $candidate->ctc }}">
								</div>

								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Are you open to gigs? *</label>
									<input type="text" name="gigs" id="gigs" class="form-control" value="{{ $candidate->gigs }}" />
								</div>
								<div class="form-section col-md-4 col-sm-6 col-xs-12" id="grey3" style="display:none;">
									<label class="control-label">Are you open to Internship? *</label>
									<input type="text" name="intern" id="intern" class="form-control" value="" placeholder="" />
								</div>

								<!-- <div id="grey" style="display:none;width:100%;margin-left:5px;"> -->

								<div class="form-section col-md-4 col-sm-6 col-xs-12" id="grey" style="display:none;">
									<label class="control-label">Role *</label>
									<input type="text" name="role" id="role" class="form-control" value="{{ $candidate->role }}" placeholder="Please enter Role">
								</div>

								<?php
								$exp =  $candidate->experience;
								?>



								<div class="form-section col-md-4 col-sm-6 col-xs-12" id="grey1" style="display:none;">
									<label class="control-label">Notice Period (in days) *</label>
									<input type="number" name="notice_period" min="0" step="1" max="150" class="form-control" value="{{ $candidate->notice_period }}" data-parsley-error-message="Notice Period value should be less than 150 days" data-parsley-type="number" oninput="this.value = Math.abs(this.value)" id="notice_period" />
								</div>
								<div class="form-section col-md-4 col-sm-6 col-xs-12" id="grey2" style="display:none;">
									<label class="control-label">Companies</label>
									<small>Enter company name seperated by comma (,)</small>
									<textarea name="companies" id="companies" class="form-control">{{ implode(',', $candidate->companies()->pluck('name')->toArray()) }}</textarea>
								</div>
								<!-- </div> -->
								<div class="form-section col-md-4 col-sm-6 col-xs-12">
									<label class="control-label">Skills *</label>
									<select class="form-control skills" name="skills" multiple data-parsley-required-message="Please enter atleast one Skill">
										@foreach($candidate->newskills as $skill)
										<option value="{{ $skill->id }}" selected="selected"> {{ $skill->name }} </option>
										@endforeach
									</select>
								</div>


							</div>



						</div>

					</div>
					<div style="width: 100%; height:fit-content; display: flex; justify-content: center; margin-top: 30px; margin-bottom: 50px">
						<div style="width: fit-content; height: fit-content">
							<a href="javascript:void(0);" onclick="submitProfile();" class="btn btn-primary">Submit</a>
						</div>
					</div>


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


	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<footer class="footer footer-static footer-light navbar-border navbar-shadow" style="margin-right: 400px;">
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


			var today = new Date();
			var day = '31';
			var month = '11';
			var year = today.getFullYear() - 22;
			var date =
				console.log(year, 'hiii')

			$(".datepicker").flatpickr({


				maxDate: new Date(year, month, day)

				// onChange: function(selectedDates, dateStr, instance) {

				// 	// 					var date = new Date();
				// 	// date.setDate( date.getDate() - 6 );
				// 	// date.setFullYear( date.getFullYear() - 1 );

				// 	var today = new Date();
				// 	var newDate = new Date(dateStr);
				// 	var age = today.getFullYear() - newDate.getFullYear();
				// 	var m = today.getMonth() - newDate.getMonth();
				// 	if (m < 0 || (m === 0 && today.getDate() < newDate.getDate())) {
				// 		age--;
				// 	}

				// 	$("#show-dob").html(age);
				// }
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

			if ($('.candidate-formblock').parsley().validate()) {
				$.ajax({
					url: "{{ URL::route('candidateProfile.update', $candidate->cuid) }}",
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
						role: $("input[name=role]").val(),
						// role_category: $("input[name=role_category]").val(),
						linkedin_id: $("input[name=linkedin_id]").val(),
						skills: $(".skills option:selected").map(function() {
							return this.value
						}).get().join(","),
						companies: $("textarea[name=companies]").val(),
						location: $("input[name=location]").val(),
						notice_period: $("input[name=notice_period]").val(),
						relocate: $("input[name=relocate]").val(),
						ctc: $("input[name=ctc]").val(),
						gigs: $("input[name=gigs]").val(),
						pre_loc: $("input[name=pre_loc]").val(),
                        curr_ctc: $("input[name=curr_ctc]").val(),
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

						console.log('inside ajax error handler');
					}
				});
			}
		}
	</script>
</body>

</html>