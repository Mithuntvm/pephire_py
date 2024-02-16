@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
<script  src="{{ url('/') }}/assets/js/interview.js">
    // var dataTable1Items = null;
    
</script>
<script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
@if(empty($input))
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		var slider = document.getElementById('slider-range');
		noUiSlider.create(slider, {
			start: [0, 50],
			connect: true,
			tooltips: true,
			step: 1,
			range: {
				'min': 0,
				'max': 50
			},
			format: wNumb({
				decimals: 0
			})
		});

		slider.noUiSlider.on('change', function() {
			var expminmax = slider.noUiSlider.get();
			$("#experience").val(expminmax);
		});


	});
</script>
@else
<?php $experce = explode(',', $input['experience']);  ?>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		var slider = document.getElementById('slider-range');
		noUiSlider.create(slider, {
			start: ["<?php echo $experce['0']; ?>", "<?php echo $experce['1']; ?>"],
			connect: true,
			tooltips: true,
			step: 1,
			range: {
				'min': 0,
				'max': 50
			},
			format: wNumb({
				decimals: 0
			})
		});

		slider.noUiSlider.on('change', function() {
			var expminmax = slider.noUiSlider.get();
			$("#experience").val(expminmax);
		});


	});
</script>
@endif
<script>
	$(document).ready(function() {
		setinitial();
	});

	function setinitial() {
		$('.knob').trigger('configure', {
			max: 100,
			thickness: 0.1,
			fgColor: '#2CC2A5',
			width: 50,
			height: 50
		});

		$('.knob.knob1').trigger('configure', {
			max: 100,
			thickness: 0.2,
			fgColor: '#2CC2A5',
			width: 40,
			height: 40
		});

		$(function() {
			var output = document.querySelectorAll('output')[0];

			$(document).on('input', 'input[type="range"]', function(e) {

				document.querySelector('output.' + this.id).innerHTML = e.target.value;
			});

			$('input[type=range]').rangeslider({
				polyfill: false
			});
		});

		$(".checkindates").flatpickr({
			altFormat: 'd-M-Y',
			dateFormat: 'd-M-Y'
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});


		var split = function(val) {
			return val.split(",");
		};

		var extractLast = function(term) {
			return split(term).pop();
		};

		$("#skillset").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: "{{url('/skill/autocomplete')}}",
					data: {
						term: extractLast(request.term)
					},
					dataType: "json",
					success: function(data) {
						var resp = $.map(data, function(obj) {
							//alert(obj.name);
							return obj.name;
						});

						response(resp);
					}
				});
			},
			select: function(event, ui) {
				var terms = split(this.value);
				terms.pop();
				terms.push(ui.item.value);
				terms.push("");
				this.value = terms.join(",");
				return false;
			},
			minLength: 2
		});

	}
</script>
<style>
	.hovertext {
  position: relative;
  /* border-bottom: 1px dotted black; */
}

.hovertext:before {
  content: attr(data-hover);
  visibility: hidden;
  opacity: 0;
  width: 140px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 5px 0;
  transition: opacity 1s ease-in-out;

  position: absolute;
  z-index: 1;
  left: 0;
  top: 110%;
}

.hovertext:hover:before {
  opacity: 1;
  visibility: visible;
}
	.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}

	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color:#ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked+.slider {
		background-color: #40AE49;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked+.slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

	#res {
		background: #2e5bff !important;
		color: #fff !important;
		padding: 6px 30px;
		border-radius: 4px;
		text-transform: capitalize;
		font-size: 13px;
		letter-spacing: 0.5px;
		font-weight: 600;
		min-width: 150px;
		width: auto;
		margin: 10px auto;
		/* float: right; */
		margin-left: 55px;
	}

	#csv {
		background: #2e5bff !important;
		color: #fff !important;
		padding: 6px 30px;
		border-radius: 4px;
		text-transform: capitalize;
		font-size: 13px;
		letter-spacing: 0.5px;
		font-weight: 600;
		min-width: 150px;
		width: auto;
		margin: 10px auto;
		/* float: right; */
		margin-left: 75px;

	}
</style>
<script type="text/javascript">
	function searchlist() {

		$("#profile_list").html('Loading...');

		$.ajax({
			url: "{{url('/job/details/search')}}",
			type: "post",
			data: {
				'frm': $("#candidatelist").serialize()
			},
			success: function(data) {
				if (data.success == 1) {
					$("#profile_list").html(data.view);
					//$("#mytot").html(data.totalcount);
					//setinitial();
				} else if (data.error == 1) {
					swal("Alert", data.errormsg, "error");
				}
			}
		});

	}

	setTimeout(function() {
		$(".alert_hide").hide();
	}, 2500);

	function showfulldec() {
		$(".short").hide();
		$(".full").show();
	}

	function shoshort() {
		$(".full").hide();
		$(".short").show();
	}
</script>

<script type="text/javascript">
	function gotoback() {
		history.back();
	}

	function resetmyform() {
		//$("#searchcandidates")[0].reset();
		window.location.href = "<?php echo url('/job/details/' . $job->juid); ?>";
	}
</script>


<script type="text/javascript">
	$(function() {
		$("#selectallblock").on('change', function() {
			if ($(this).is(":checked")) {
				$(".profile_check").prop('checked', true).change();
			} else {
				$(".profile_check").prop('checked', false).change();
			}
		});

		$(".profile_check").change(function() {
			var selectedCount = $('input[name="finalizeprofile[]"]:checked').length;
			if (selectedCount == 0) {
				$(".slot-section").removeClass('active');
			} else {
				$(".slot-section").addClass('active');
			}
		});
	});

	function deleteSelected() {
		var selectedCount = $('input[name="finalizeprofile[]"]:checked').length;
		if (selectedCount == 0) {
			swal("Alert", 'Please select atleast one profile', "error");
			return false;
		}

		$('input[name="finalizeprofile[]"]:checked').each(function() {
			$(this).parents('.i-profilematrix').remove();
		});

		$("#selectallblock").prop('checked', false).change();
	}

	function finalizeShortlisted() {

		var candidatesArr = $('input[name="finalizeprofile[]"]:checked').map(function(_, el) {
			return $(el).val();
		}).get();

		$.ajax({
			url: "{{ URL::route('shortlistedCandidates.update', $job->juid) }}",
			dataType: 'json',
			type: 'POST',
			data: {
				candidatesArr,
			},
			success: function(response) {
				if (response.status) {
					window.location.href = response.redirect_url;
				}
			},
			error: function(response) {
				console.log('inside ajax error handler');
			}
		});
	}
</script>

@endpush

<style type="text/css">
	.newtab-section li:not(.active) a {
		pointer-events: none;
	}
</style>


<div class="app-content content">
	<div class="content-wrapper">

		@if(session()->has('success'))
		<div class="col-12 alert alert_hide alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>
		@endif

		<div class="content-header row">
		</div>
		<div class="content-body">
			<!-- Revenue, Hit Rate & Deals -->
			<div class="row resp-view">
				<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
					<div class="common-section">
						<div class="title-section">
							<h4>{{$job->name}}</h4>
							<p class="short">{{substr($job->description,0,300)}} @if(strlen($job->description) > 300)<a href="javascript:void(0);" onclick="showfulldec()">... More</a> @endif</p>
							<div class="full" style="display: none;">
								<p>{{$job->description}}</p>
								<a href="javascript:void(0);" onclick="shoshort()">Show Less</a>
							</div>
						</div>
						<div class="modal-profilelist i-profilelist i-pmatrix noscroll">
							<div class="title-section">
								<ul class="newtab-section">
									<li class="result-section active">
										<a href="{{ route('job.show', $job->juid) }}">
											<div class="first-child">
												<div class="icon-box">
													<img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
													<img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
												</div>
												<p>Result : {{$job->candidates->count()}}</p>
											</div>
											<div class="second-child">
												<i class="ft-chevron-right"></i>
											</div>
										</a>
									</li>
									<li class="shortlisted-section active">
										<a href="{{ route('shortlistedCandidates.show', $job->juid) }}">
											<div class="first-child">
												<div class="icon-box">
													<img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
													<img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
												</div>
												<p>Shortlisted Candidates</p>
											</div>
											<div class="second-child">
												<i class="ft-chevron-right"></i>
											</div>
										</a>
									</li>
									<li class="slot-section active">
										@if($isEdit['timeslot'])
										<a href="{{ route('interviewTimeSlot.view', $job->juid) }}">
											@else
											<a href="javascript:void(0);" onclick="finalizeShortlisted();">
												@endif
												<div class="first-child">
													<div class="icon-box">
														<img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
														<img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
													</div>
													<p>Time Slot</p>
												</div>
												<div class="second-child">
													<i class="ft-chevron-right"></i>
												</div>
											</a>
									</li>
									<li class="scheduled-section @if($isEdit['scheduled']) active @endif">
										@if($isEdit['scheduled'])
										<a href="{{ route('scheduledCandidates.show', $job->juid) }}">
											@else
											<a href="javascript:void(0);">
												@endif
												<div class="first-child">
													<div class="icon-box">
														<img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
														<img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
													</div>
													<p>Scheduled List</p>
												</div>
												<div class="second-child">
													<i class="ft-chevron-right"></i>
												</div>
											</a>
									</li>
								</ul>

								@if( ! $isEdit['timeslot'])
								<h4 class="titlehead">
									<span>
										<input id="selectallblock" type="checkbox" name="selectall" checked="">
										<label for="selectallblock"><span>Select All</span></label>
									</span>
									<!-- <span><a href="javascript:void(0);" onclick="deleteSelected()">Delete</a></span> -->
								</h4>
								@endif

							</div>
							<div>
								
								@if(!$job->candidates->isEmpty())
								@foreach($job->candidates as $ck)
								<div class="modal-profileblock i-profilematrix">
									<div>
										<div class="avatar-image">
											<span>
												@if($ck->photo == '' && ($ck->sex =='' || $ck->sex =='None'))
												<img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
												@elseif($ck->photo == '' && $ck->sex =='Male')
												<img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
												@elseif($ck->photo == '' && $ck->sex =='Female')
												<img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">
												@else
												<img class="rounded-circle" src="{{ asset('storage/' . $ck->photo) }}">
												@endif
											</span>
										</div>
									</div>
									<div>
										<p>{{$ck->name}}</p>
										<p></p>
										<p><span>Experience:</span> <span>{{$ck->experience}} yrs</span></p>
										<p><span>{{$ck->email}}</span><span>{{$ck->phone}}</span></p>
									</div>
									<div>
											@if(!$ck->newskills->isEmpty())
											<?php $maxc = 1; ?>
											@php
											$cand = App\Job::where('id', $job->id)

											->first();
											$skills=explode(',',$cand->mandatory_skills);
											@endphp

											
											@foreach($skills as $mk)
											<?php if ($maxc < 16) { ?>
												<span>{{$mk}}</span>
											<?php } ?>
											<?php $maxc++; ?>
											@endforeach
											@else
											<span>No skills</span>
											@endif
										</div>
									<div>
										<p><input type="text" value="{{$ck->pivot->score}}" class="knob basic-dial" readonly></p>
										<p>Score</p>
									</div>
									<div class="checkbox-block">

										@php
										$hasFinalized = App\ShortlistedCandidate::where('job_id', $job->id)->where('candidate_id', $ck->id)->where('hasFinalized', 1)->count();
										@endphp
										@if($isEdit['timeslot'])
										<input class="profile_check" id="checkblock_{{ $ck->id }}" type="checkbox" name="finalizeprofile[]" value="{{ $ck->id }}" @if($hasFinalized> 0) checked="" @endif disabled="">
										@else
										<input class="profile_check" id="checkblock_{{ $ck->id }}" type="checkbox" name="finalizeprofile[]" value="{{ $ck->id }}" @if($hasFinalized> 0) checked="" @endif>

										@endif

										<label for="checkblock_{{ $ck->id }}"></label>
									</div>
								</div>
								@endforeach
								@else

								<p class="alert alert-warning">No records found</p>

								@endif
							</div>
						</div>
					</div>
				</div>

				<!-- Right Side Filter Here -->
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">


					<div class="common-section" style="margin-top: 80%;">
			
						<form name="resume" id="" method="post" action="{{ route('download.shortlistedresume') }}">
							@csrf

							<div class="section">

								<input type="hidden" name="juid" value="{{ $job->id }}">
								<button type="submit" class="btn btn-primary" id="res">Download Resumes</button>
							</div>
						</form>

						<form name="resume" id="" method="post" action="{{ route('download.shortlistedcsv') }}">
							@csrf

							<div class="section">

								<input type="hidden" name="jid" value="{{ $job->id }}">

								<button type="submit" class="btn btn-primary" id="csv">CSV</button>
							</div>
						</form>
				
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('footer')
@include('partials.frontend.interview')
@endsection

@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection