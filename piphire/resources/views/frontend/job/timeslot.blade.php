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

<link rel="stylesheet" href="{{url('/')}}/build/css/intlTelInput.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
<!-- Parsley -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {

		$(".datepicker").flatpickr({
			// minDate: new Date(),
			minDate: "today"
		});

		$(".timepicker").flatpickr({
			enableTime: true,
			noCalendar: true,
			dateFormat: "H:i",
		});
	});

	// window.ParsleyValidator
	//        .addValidator('minEndTime', function (value) {
	//            var duration = $("#duration").val();
	//            var start_time = $("#start_time").val();
	//            var end_time = value;

	//            return false;

	//        }, 32)
	//        .addMessage('en', 'minEndTime', 'End Time should be x minutes greater than Start time');

</script>

@endpush

<style type="text/css">
	.newtab-section li:not(.active) a {
		pointer-events: none;
	}

	.cust-disabled {
		background: #6B6F82 !important;
		pointer-events: none;
	}
</style>
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
										<a href="{{ route('interviewTimeSlot.view', $job->juid) }}">
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
									<li class="scheduled-section {{ $createdSlotsCount > 1 ? 'active' : ''}}">
										<a href="{{ route('scheduledCandidates.show', $job->juid) }}">
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
								<h4 class="titlehead newtitlehead">
									<span><a href="#" data-toggle="modal" data-target="#addslotModal" class="" >ADD</a></span>
									<span class="my-count">Time Slots - {{ $createdSlotsCount }}/{{ $maxSlotsCount }}</span>
								</h4>
							</div>

							<div class="new-heightblock">

								@foreach($timeslots as $date => $interviewers)
								@foreach($interviewers as $name => $timeslots)
								<div class="interview-timeslot">
									<h4 class="titlehead">Interviewer - {{ $name }} <span> {{ $date }}</span></h4>
									<div class="timeslot-block row">
										@foreach($timeslots as $timeslot)
										<div class="col-md-6 xol-sm-6 col-xs-12">
											<div>
												<p class="time">
													{{ date("g:i A", $timeslot->interview_start_time) }} to
													{{ date("g:i A", $timeslot->interview_end_time) }}
												</p>
												@if($timeslot->hasAllotted)
												<div class="timeslot-details">
													<div class="t-name">
														<p> {{ $timeslot->candidate->name }}</p>
														<p> {{ $timeslot->candidate->email }}</p>
													</div>
												</div>
												@endif
											</div>
										</div>
										@endforeach
									</div>
								</div>
								@endforeach
								@endforeach

							</div>

						</div>
					</div>
				</div>

				<!-- Right Side Filter Here -->
			</div>
			<!--/ Revenue, Hit Rate & Deals -->

		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- Modal -->
<div class="modal fade slot-modal" id="addslotModal" role="dialog" aria-hidden="true" >
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="timeslot-div" class="modal-body" data-parsley-validate="">
				<div class="formblock-new fullwidth-form">
					<div class="form-section">
						<label class="control-label">Interviewer Name</label>
						<input class="form-control" type="text" name="name" id="name" required data-parsley-required-message="Please enter Interviewer Name" />
					</div>
					<div class="form-section">
						<label class="control-label">Duration</label>
						<select class="form-control" name="duration" id="duration" required data-parsley-required-message="Please select Duration">
							<option value="">-- Select Duration --</option>
							<option value="30">30 mins</option>
							<option value="60">1 hour</option>
							<option value="90">1 hour 30 mins</option>
							<option value="120">2 hours</option>
						</select>
					</div>
					<div class="form-section">
						<label class="control-label">Select Date</label>
						<input class="form-control datepicker" type="text" name="interview_date" id="interview_date" required data-parsley-required-message="Please select Interview Date" />
					</div>
					<div class="form-section">
						<label class="control-label">Start Time</label>
						<input class="form-control timepicker" type="text" name="start_time" id="start_time" required data-parsley-required-message="Please select Start Time" />
					</div>
					<div class="form-section">
						<label class="control-label">End Time</label>
						<input class="form-control timepicker" type="text" name="end_time" id="end_time" required data-parsley-required-message="Please select End Time" data-parsley-min-end-time="" />
					</div>
					<div class="form-section">
						<label class="control-label">Email Address</label>
						<input class="form-control" type="email" name="email" id="email" required data-parsley-required-message="Please enter Email Address" />
					</div>

					<div class="form-section">
						<label class="control-label">Contact Number</label>

						<input type="tel" name="contact_number" id="contact_number" placeholder="" onkeypress="return onlyNumberKey(event)"
						 class="form-control" required data-parsley-required-message="" style="width:300px ">
					

					</div>





					<div class="form-section" style="flex: 0 0 66%;">
						<label class="control-label">Provide the meeting details to be appended into the Interview Invite</label>
						<textarea class="form-control" name="meeting_details" id="meeting_details" required data-parsley-required-message="Please enter Meeting Details"></textarea>
					</div>

					<div class="btnblock-new">
						<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary btn-cancel">Cancel</a>
						<a href="javascript:void(0);" onclick="submitTimeSlot(this);" class="btn btn-primary">Submit</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{url('/')}}/build/js/intlTelInput.js"></script>
<script>
	function getIp(callback) {
		fetch('https://ipinfo.io/202.88.240.95?token=50bd3dd0fb646c', {
				headers: {
					'Accept': 'application/json'
				}
			})
			.then((resp) => resp.json())
			.catch(() => {
				return {
					country: 'us',
				};
			})
			.then((resp) => callback(resp.country));
	}


		const phoneInputField = document.querySelector("#contact_number");
		console.log(phoneInputField,'hiiiii')

		const phoneInput = window.intlTelInput(phoneInputField, {
			initialCountry: "auto",
			geoIpLookup: getIp,
			separateDialCode: true,
			utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
		});
			const phoneNumber = phoneInput.getNumber();
	console.log(phoneInput,'ppppppppppppppppppppp')
	
	

	// function process(event) {
    //   event.preventDefault();

    //   const phoneNumber = phoneInput.getNumber();

    //   // document.getElementById("userphone").innerHTML = phoneNumber;

    //   console.log(phoneNumber,'kkiiii')

    
    // }

	function submitTimeSlot(elm) {
		// console.log(phoneNumber,'ppppppppppppppppppppp')
		const phoneNumber = phoneInput.getNumber();
		console.log(phoneNumber,'iiiiiiiii')


if ($('#timeslot-div').parsley().validate()) {

	$(elm).css('pointer-events', 'none');

	$.ajax({
		url: "{{ URL::route('interviewTimeSlot.store', $job->juid) }}",
		dataType: 'json',
		type: 'POST',
		data: {
			name: $("#name").val(),
			duration: $("#duration").val(),
			interview_date: $("#interview_date").val(),
			start_time: $("#start_time").val(),
			end_time: $("#end_time").val(),
			email: $("#email").val(),
			contact_number:phoneNumber,
			meeting_details: $("#meeting_details").val(),
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
}


        function onlyNumberKey(evt) {
              
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
@section('footer')
@include('partials.frontend.interview')
@endsection

@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection