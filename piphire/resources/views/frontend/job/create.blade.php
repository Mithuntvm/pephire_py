@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
@endpush

@push('scripts')

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
<script src="{{ url('/') }}/assets/js/interview.js">
	// var dataTable1Items = null;
</script>
<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>

<script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<style>
	#rcorners2 {

		float: right;
		margin: 5px;
		padding: 2px 8px;
		color: #8097b1;
		border: 1px solid #8097b1;
		border-radius: 100px;
		font-size: 10px;

	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script>
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
							id: skill.name,
							text: skill.name
						};
					})
				};
			},
			cache: true,
		}
	});



	$(document).ready(function() {
		$('.knob').trigger('configure', {
			max: 100,
			thickness: 0.1,
			fgColor: '#2CC2A5',
			width: 50,
			height: 50
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		setTimeout(function() {
			$("#alert_message").hide();
		}, 10000);
	});

	$(document).on('click', ".active-color", function() {
		//if(!$(this).children('.icon-box').children('.color-icon').hasClass('rec_color')){
		$(this).children('.icon-box').children('.color-icon').click();
		//}
	});

	function function_alert(event) {
		// Display the alert box 
		//   alert('hiii');
		console.log('jjjjjjj')

		$("#ext_skills").show();
		// event.stopPropagation();
		var maxcount = "{{$organization->max_resume_count}}";
		$.ajax({
			url: "{{url('/mandatorySkills')}}",
			type: 'post',
			data: {
				'frm': $("#jobcreate").serialize()

			},

			success: function(data) {
				if (data.error != 1) {
					console.log('hiiiiiiiiiiiiiiiiii')
					// alert(data.skills)
					window.location.reload();


				}
				if (data.error == 1) {
					swal("Alert", data.errorMsg, "error");
				}
				console.log('hlooooo')


			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});

	}
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.fitment-form .form-control').on('keyup', function() {
			if ($(this).val().trim() != '') {
				$(this).attr('data-valid', 'valid');
			} else {
				$(this).removeAttr('data-valid');
			}
		});
		$("#updatejobdetails").validate({
			rules: {
				jobtitle: {
					required: true
				},
				jobdescription: {
					required: true
				},
				joining_date: {
					required: true
				},
				max_experience: {
					required: true,
					// min: 0
				},
				min_experience: {
					required: true,

				},
				location: {
					required: true
				},
				job_role: {
					required: true
				},
				// job_role_category: {
				// 	required : true
				// },
				offered_ctc: {
					required: true,
					min: 0
				}
			},
			messages: {
				jobtitle: {
					required: "Please enter job title"
				},
				jobdescription: {
					required: "Please enter description of your job"
				},
				joining_date: {
					required: "Please enter Joining Date"
				},
				max_experience: {
					required: "Please enter Max Experience",
					min: "Please enter a number greater than or equal to 0"
				},
				min_experience: {
					required: "Please enter Min Experience",
					// min: "Please enter a number greater than or equal to 0"
				},
				location: {
					required: "Please enter Location"
				},
				job_role: {
					required: "Please enter Job Role"
				},
				// job_role_category: {
				// 	required : "Please enter Role Category"
				// },
				offered_ctc: {
					required: "Please enter Offered CTC",
					min: "Please enter a number greater than or equal to 0"
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

<script type="text/javascript">
	$("#profile_lists").on("click", ".del-resource", function(e) {
		e.preventDefault();
		let href = $(this).attr("data");
		let id = $(this).attr("data-id");
		$.ajax({
			url: href,
			type: 'post',
			success: function(data) {
				getallresumes();
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});

	});

	function getallresumes() {
		var maxcount = "{{$organization->max_resume_count}}";
		$.ajax({
			url: "{{url('/getallresumes')}}",
			type: 'get',
			success: function(data) {
				$(".mytot").html(data.popcount + '/' + maxcount);
				$("#profile_lists").html(data.resumelist);
				$(".all_black").hide();
				$(".all_color").show();
				if ($(".filecount").length < 1) {
					//window.location.reload();
				}
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}
</script>

<!-- <script type="text/javascript">
	function getfilteredprofiles() {
		$("#list_profiles").html('Loading...');
		$("#mypreload").show();
		$.ajax({
			url: "{{url('/profilepopup/popupgetsearch')}}",
			type: 'get',
			data: $("#searchby").serialize(),
			success: function(data) {
				$("#mypreload").hide();
				if (data.noload == 1) {
					$("#loadbutton").hide();
				}
				$("#popcount").val(data.popcount);
				$("#current_count").val(data.popcount - 1);
				$("#list_profiles").html(data.resumelist);
				$("#profile-miner").modal('show');
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}
</script> -->

<!-- <script type="text/javascript">
	function prefillprofile() {
		$("#searchby")[0].reset();
		$.ajax({
			url: "{{url('/profilepopup/popupget')}}",
			type: 'get',
			success: function(data) {
				if (data.noload == 1) {
					$("#loadbutton").hide();
				}
				$("#popcount").val(data.popcount);
				$("#current_count").val(data.popcount - 1);
				$("#list_profiles").html(data.resumelist);
				$("#profile-miner").modal('show');
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}
</script> -->

<!-- <script type="text/javascript">
	function getnextpage() {
		var nextpage = $("#popcount").val();
		$.ajax({
			url: "{{url('/profilepopup/popupget?page=')}}" + nextpage,
			type: 'get',
			data: $("#searchby").serialize(),
			success: function(data) {
				$("#loadbuttonprev").show();
				if (data.noload == 1) {
					$("#loadbutton").hide();
				}
				$("#popcount").val(data.popcount);
				$("#current_count").val(data.popcount - 1);
				$("#list_profiles").html(data.resumelist);
				$("#profile-miner").modal('show');
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}
</script> -->

<!-- <script type="text/javascript">
	function getlastpage() {
		var nextpage = parseInt($("#current_count").val());
		nextpage = nextpage - 1;
		$.ajax({
			url: "{{url('/profilepopup/popupget?page=')}}" + nextpage,
			type: 'get',
			data: $("#searchby").serialize(),
			success: function(data) {
				if (data.noload == 1) {
					$("#loadbutton").hide();
				} else {
					$("#loadbutton").show();
				}
				if (data.noloadprev == 1) {
					$("#loadbuttonprev").hide();
				}
				$("#popcount").val(data.popcount);
				$("#current_count").val(data.popcount - 1);
				$("#list_profiles").html(data.resumelist);
				$("#profile-miner").modal('show');
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}
</script> -->

<script type="text/javascript">
	function submitjob(event) {
		event.stopPropagation();
		var maxcount = "{{$organization->max_resume_count}}";
		//var doccount = $("#docmax").val();
		var doccount = $(".filecount").length;
		if (doccount < 1) {
			swal("Alert", 'Please select/upload a resume', "error");
		} else if (maxcount < doccount) {
			swal("Alert", 'Maximum file reached. Please remove some resumes', "error");
		} else {
			$("#jobcreate").submit();
		}

	}
</script>

<script type="text/javascript">
	$(document).ready(function() {

		$("#job_role").select2({
			placeholder: 'Select Job Role',
			allowClear: true,
		});

		$("#job_role_category").select2({
			placeholder: 'Select Job Role Category',
			allowClear: true,
		});


		$("#joining_date").flatpickr({
			// minDate: new Date(),
			minDate: "today",
		});

		$(" #jobtitle, #joining_date, #max_experience,#min_experience, #job_role, #job_role_category, #location, #offered_ctc").on('change keyup focusout', function() {
			saveupdateform();
		});
		$("#skills").on('change keyup focusout', function() {
			saveupdateform();
		});
		// saveupdateform();

	});


	function saveupdateform() {

		if ($("#jobcreate").validate().checkForm()) {
			$(".rec_black").hide();
			$(".rec_color").show();
			$(".rec_color").parent().parent().addClass('active-color');
		} else {
			$(".rec_color").hide();
			$(".rec_black").show();
			$(".rec_color").parent().parent().removeClass('active-color');
		}

		$.ajax({
			url: "{{url('/updatejobdetails')}}",
			type: 'post',
			data: {
				'frm': $("#jobcreate").serialize()
			},
			success: function(data) {

			}
		});
	}



	function getrecomentedresumes(event) {
		$("#mypreload").show();
		event.stopPropagation();
		var maxcount = "{{$organization->max_resume_count}}";
		$.ajax({
			url: "{{url('/getallmatchcandidates')}}",
			type: 'post',
			data: {
				'frm': $("#jobcreate").serialize()
			},
			success: function(data) {
				$(".mytot").html(data.popcount + '/' + maxcount);
				$("#profile_lists").html(data.resumelist);
				$(".all_black").hide();
				$(".all_color").show();
				$('.candidate-block').removeClass('active-color');
				$('.candidate-block').addClass('active-color');
				$("#mypreload").hide();
				if (data.popcount < 1) {
					$("#submit_color").hide();
					$("#subanalyze").removeClass('active-color');
				}
				if (data.error == 1) {
					swal("Alert", data.errorMsg, "error");
				}
			},
			statusCode: {
				401: function() {
					window.location.href = '/'; //or what ever is your login URI
				},
				419: function() {
					window.location.href = '/'; //or what ever is your login URI
				}
			},
			error: function(res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});
	}

	function gotominer(event) {
		event.stopPropagation();
		window.location.href = "{{url('/profileminer')}}";

	}

	function gotohistory(event) {
		event.stopPropagation();
		window.location.href = "{{url('/jobs/historyminer')}}";

	}
</script>

@if(Session::has("warningAlert"))
<script type="text/javascript">
	jQuery(document).ready(function() {
		swal("Alert", '{{ Session::get("warningAlert") }}', "error");
	});
</script>
@endif

@endpush

<div class="app-content content">
	<div class="content-wrapper">

		<!-- @if(session()->has('warning'))
			<div class="col-12 alert alert-danger text-center mt-1" id="alert_message">{{ session()->get('warning') }}</div>
		@endif -->

		<div class="content-header row">
		</div>
		<div class="content-body">
			<!-- Revenue, Hit Rate & Deals -->
			<form method="post" enctype="multipart/form-data" id="jobcreate">
				@csrf
				<div class="row">
					<div class="col-md-12 col-xs-12 analyze-candidateblock">
						<div>
							<div class="candidate-block @if(!$resumes->isEmpty()) active-color @endif">
								<div class="icon-box">
									<img class="color-icon rec_color" src="{{url('/')}}/assets/images/icons/recommend-color.png" onclick="getrecomentedresumes(event)" @if(!$resumes->isEmpty()) style="display:block !important;" @endif>
									@if($resumes->isEmpty())
									<img class="dark-icon rec_black" src="{{url('/')}}/assets/images/icons/recommend.png">
									@endif
								</div>
								<p>Recommend <br /> Profiles</p>
								<span><i class="ft-chevron-right"></i></span>
							</div>


							<div class="candidate-block @if($existjob) @if($existjob->is_recoment) active-color @endif @endif">
								<div class="icon-box">


									<img class="color-icon all_color" src="{{url('/')}}/assets/images/icons/pick-color.png" onclick="gotominer(event)" @if(!$resumes->isEmpty()) style="display:block !important;" @endif>


									@if($resumes->isEmpty())
									<img class="dark-icon all_black" src="{{url('/')}}/assets/images/icons/pick.png">
									@endif


								</div>
								<p>Pick <br /> Profiles</p>
								<span><i class="ft-chevron-right"></i></span>
							</div>

							<!-- @if($existjob) @if($existjob->is_recoment)@endif @endif -->
							<!-- <form method="post" enctype="multipart/form-data" id="jobcreate">
								@csrf -->
							<div class="candidate-block active-color ">
								<div class="icon-box">
									<img class="color-icon all_color" src="{{url('/')}}/assets/images/icons/reuse-color.png" onclick="gotohistory(event)" @if(!$resumes->isEmpty()) style="display:block !important;" @endif>
									@if($resumes->isEmpty())
									<img class="dark-icon all_black" src="{{url('/')}}/assets/images/icons/reuse.png">
									@endif
								</div>
								<p>Reuse <br /> from History</p>
								<span><i class="ft-chevron-right"></i></span>
							</div>
							<!-- </form> -->
							<div id="subanalyze" class="candidate-block @if(!$resumes->isEmpty()) active-color @endif">
								<div class="icon-box">
									<img class="color-icon all_color submit_color" src="{{url('/')}}/assets/images/icons/analyze.png" onclick="submitjob(event)" @if(!$resumes->isEmpty()) style="display:block !important;" @endif>
									@if($resumes->isEmpty())
									<img class="dark-icon all_black submit_black" src="{{url('/')}}/assets/images/icons/analyze.png">
									@endif
								</div>
								<p>Analyze <br /> Candidates</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
						<div class="common-section">
							<div class="common-form fitment-form">
								<div class="form-section">
									<label class="control-label">Job title</label>
									<input class="form-control @if($existjob) @if($existjob->name) valid  @endif @endif" type="text" id="jobtitle" name="jobtitle" placeholder="Add Job Title here" @if($existjob) value="{{$existjob->name}}" @endif>
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>
								<div class="form-section">
									<label class="control-label">Job description</label>
									<textarea class="form-control @if($existjob) @if($existjob->description) valid  @endif @endif" type="text" placeholder="Add Job Description here" id="jobdescription" name="jobdescription" rows="15" onchange="function_alert(event)">@if($existjob){{$existjob->description}}@endif</textarea>
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>
								<div class="form-section">

									<div id="mand_skills">
										<label class="control-label man">Mandatory Skills</label>

										<!-- <div id="data"></div> -->
										<select multiple class="form-control skills" id="skills" name="skills[]" data-parsley-required-message="Please enter atleast one Skill">



											<?php


											if ($existjob) {
												$skills = explode(",", $existjob->mandatory_skills);

												// $skills = str_replace("'", "", $skills)

												foreach ($skills as $sk) {





													$cand = App\SkillMaster::where('name', $sk)->first();
													if ($cand) {
											?>
														<option value="{{$sk}}" selected="selected"> {{ $sk }} </option>


											<?php
													}
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-section">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Joining Date</label>
											<?php
											// Calculate default date (60 days from now)
											$defaultDate = date('Y-m-d', strtotime('+60 days'));
											?>
											<input class="form-control @if($existjob) @if($existjob->joining_date) valid  @endif @endif" type="text" id="joining_date" name="joining_date" placeholder="Joining Date" value="{{ $existjob ? $existjob->joining_date : $defaultDate }}" required>
											<!-- <img src="{{url('/')}}/assets/images/icons/tick.png"> -->
										</div>

										<div class="col-md-6">
											<label class="control-label">Location</label>
											<input class="form-control @if($existjob) @if($existjob->location) valid  @endif @endif" type="text" id="location" name="location" placeholder="Location" @if($existjob) value="{{$existjob->location}}" @endif>
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
									</div>
								</div>
								<div class="form-section">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Min Experience</label>
											<input class="form-control @if($existjob) @if($existjob->min_experience) valid  @endif @endif" type="number" id="min_experience" name="min_experience" placeholder="Min Experience" @if($existjob) value="{{$existjob->min_experience}}" @endif oninput="this.value = Math.abs(this.value)" required>
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
										<div class="col-md-6">
											<label class="control-label">Max Experience</label>
											<input class="form-control @if($existjob) @if($existjob->max_experience) valid  @endif @endif" type="number" id="max_experience" name="max_experience" placeholder="Max Experience" @if($existjob) value="{{$existjob->max_experience}}" @endif oninput="this.value = Math.abs(this.value)">
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>

									</div>
								</div>
								<div class="form-section">
									<div class="row">

										<div class="col-md-6">
											<label class="control-label">Offered CTC</label>
											<input class="form-control @if($existjob) @if($existjob->offered_ctc) valid  @endif @endif" type="number" id="offered_ctc" name="offered_ctc" placeholder="Offered CTC" @if($existjob) value="{{$existjob->offered_ctc}}" @endif oninput="this.value = Math.abs(this.value)">
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
									</div>
								</div>

								<div class="form-section">
									<label class="control-label">Job Role</label>
									<select class="form-control" name="job_role" id="job_role">
										<option value=""> -- Select Job Role -- </option>
										@foreach($job_roles as $job_role)
										<option value="{{ $job_role }}" @if($existjob) @if($existjob->job_role == $job_role) selected="" @endif @endif>
											{{ ucfirst($job_role) }}
										</option>
										@endforeach
									</select>
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>



								<input type="hidden" id="docmax" value="<?php echo $resume_client; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
						<div class="common-section">
							<h4 class="sub-titlehead">
								<span>Profiles</span>
								<span class="mytot">{{$totalcount}}/{{$organization->max_resume_count}}</span>
							</h4>
							<ul class="profile-list" id="profile_lists">

								@if(!$resumes->isEmpty())
								<?php $cnt = 1; ?>
								@foreach($resumes as $val)

								<?php if (isset($val->candidate) || isset($val->resume)) { ?>

									<li class="resumeli_{{$val->id}} filecount">
										<?php
										$skills = explode(',', $val->skills);
										?>
										<span>{{$cnt}}</span>

										<?php

										if (isset($val->candidate)) {

											$username = ($val->candidate->name != '') ? $val->candidate->name : $val->resume->name;
										} else {

											$username = $val->resume->name;
										}
										?>

										<?php $string = (strlen($username) > 20) ? substr($username, 0, 15) . '...' : $username; ?>
										<span>{{$string}}</span>

										<?php



										foreach ($skills as $sk) {


										?>

											<span id="rcorners2">{{$sk}}</span> <?php

																			}

																				?>

										<span><img data-id="{{$val->id}}" data="{{url('/hold/delete/'.$val->id)}}" class="del-resource" src="{{url('/')}}/assets/images/icons/delete-icon.png"></span>
									</li>
									<?php $cnt++; ?>

								<?php } ?>


								@endforeach
								@else

								<p class="alert alert-warning text-center">No document selected</p>
								@endif

							</ul>
						</div>
					</div>
				</div>
			</form>
			<!--/ Revenue, Hit Rate & Deals -->

			<!-- Profile modal -->
			<!-- <div class="modal fade text-left" id="profile-miner" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<form method="post" class="profile-filter-form" id="searchby">
								<div class="filter-section">
									<input class="form-control" type="text" name="name" required="required" placeholder="Name">
								</div>
								<div class="filter-section">
									<input class="form-control" type="text" name="experience" required="required" placeholder="Experience">
								</div>
								<div class="filter-section">
									<input class="form-control" type="text" name="skill" required="required" placeholder="Skill">
								</div>
								<div class="filter-section">
									<button onclick="getfilteredprofiles()" class="btn btn-primary" type="button"><i class="ft-search"></i></button>
								</div>
								<div class="filter-section">
									<button onclick="prefillprofile()" class="btn btn-primary" type="button"><i class="ft-refresh-ccw"></i></button>
								</div>
							</form>
							<form>
								<div class="modal-profilelist">
									<div id="list_profiles">


									</div>
								</div>
								<div class="submit-btn">
									<input type="hidden" name="popcount" id="popcount" value="1">
									<input type="hidden" name="current_count" id="current_count" value="1">

									<button style="display: none;" type="button" id="loadbuttonprev" onclick="getlastpage()" class="btn btn-primary rounded-corner">Prev</button>

									<button type="button" id="loadbutton" onclick="getnextpage()" class="btn btn-primary rounded-corner">Next</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div> -->
			<!-- end Profile modal -->


		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<style type="text/css">
	#mypreload {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		/*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
		opacity: .8;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background: rgba(255, 255, 255, 0.55)
	}

	#mypreload .nb-spinner {
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

	#mypreload span {
		position: relative;
		top: -20px;
		color: #000;
		font-size: 24px;
		z-index: 99;
	}

	#ext_skills {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		/*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
		opacity: .8;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background: rgba(255, 255, 255, 0.55)
	}

	#ext_skills .nb-spinner {
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

	#ext_skills span {
		position: relative;
		top: -20px;
		color: #000;
		font-size: 24px;
		z-index: 99;
	}
</style>

<div id="mypreload" style="display: none;">
	<span style="">Getting matching profiles</span>
	<div class="nb-spinner"></div>
</div>
<div id="ext_skills" style="display: none;">
	<span style="">Extracting Skills</span>
	<div class="nb-spinner"></div>
</div>



@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection