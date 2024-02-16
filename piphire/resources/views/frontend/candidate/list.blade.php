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
<link href="{{url('/')}}/assets/css/jquery-ui.css" rel="stylesheet">
</link>
<!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css" rel="stylesheet"></link> -->
<!-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css"> -->

<style type="text/css">
	div#time-slider {
		margin-top: 10px;
		background: #ececec !important;
		border: none !important;
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
		float: right;
	}

	input#searchtime {
		width: 100%;
		display: flex;
		color: #2E384D !important;
		font-size: 11px;
		font-weight: 700 !important;
		pointer-events: none;
	}
</style>
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
<!-- <script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script> -->
<!-- <script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script> -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(function() {
		var d = new Date();
		startday = "{{$startdate}}";
		today = "{{$enddate}}";
		$("#month-slider").slider({
			range: true,
			min: new Date(startday).getTime() / 1000,
			max: new Date(today).getTime() / 1000,
			step: 86400,
			values: [new Date('{{$sel_startdate}}').getTime() / 1000, new Date('{{$sel_enddate}}').getTime() / 1000],
			slide: function(event, ui) {
				$("#searchdate").val((new Date(ui.values[0] * 1000).toLocaleDateString()) + " - " + (new Date(ui.values[1] * 1000)).toLocaleDateString());

				$("#startdate").val(new Date(ui.values[0] * 1000).toLocaleDateString());
				$("#enddate").val(new Date(ui.values[1] * 1000).toLocaleDateString());

			}
		});
		$("#searchdate").val((new Date($("#month-slider").slider("values", 0) * 1000).toLocaleDateString()) +
			" - " + (new Date($("#month-slider").slider("values", 1) * 1000)).toLocaleDateString());

		$("#startdate").val(new Date($("#month-slider").slider("values", 0) * 1000).toLocaleDateString());
		$("#enddate").val(new Date($("#month-slider").slider("values", 1) * 1000).toLocaleDateString());

	});
</script>


<script type="text/javascript">
	$(function() {

		$("#time-slider").slider({
			range: true,
			min: 0,
			max: 1440,
			step: 30,
			values: ['{{$sel_starttime}}', '{{$sel_endtime}}'],
			slide: function(e, ui) {

				var s_hours = Math.floor(ui.values[0] / 60);
				var s_minutes = ui.values[0] - (s_hours * 60);

				if (s_hours.toString().length == 1) s_hours = '0' + s_hours;
				if (s_minutes.toString().length == 1) s_minutes = '0' + s_minutes;

				var e_hours = Math.floor(ui.values[1] / 60);
				var e_minutes = ui.values[1] - (e_hours * 60);

				if (e_hours.toString().length == 1) e_hours = '0' + e_hours;
				if (e_minutes.toString().length == 1) e_minutes = '0' + e_minutes;

				$("#searchtime").val(s_hours + ':' + s_minutes + ' - ' + e_hours + ':' + e_minutes);

				$("#starttime").val(ui.values[0]);
				$("#endtime").val(ui.values[1]);
			}
		});

		var initial_s_hours = Math.floor($("#time-slider").slider("values", 0) / 60);
		var initial_s_minutes = $("#time-slider").slider("values", 0) - (initial_s_hours * 60);
		if (initial_s_hours.toString().length == 1) initial_s_hours = '0' + initial_s_hours;
		if (initial_s_minutes.toString().length == 1) initial_s_minutes = '0' + initial_s_minutes;

		var initial_e_hours = Math.floor($("#time-slider").slider("values", 1) / 60);
		var initial_e_minutes = $("#time-slider").slider("values", 1) - (initial_e_hours * 60);
		if (initial_e_hours.toString().length == 1) initial_e_hours = '0' + initial_e_hours;
		if (initial_e_minutes.toString().length == 1) initial_e_minutes = '0' + initial_e_minutes;

		$("#searchtime").val(initial_s_hours + ':' + initial_s_minutes + ' - ' + initial_e_hours + ':' + initial_e_minutes);

		$("#starttime").val($("#time-slider").slider("values", 0));
		$("#endtime").val($("#time-slider").slider("values", 1));

	});
</script>

<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function() {
			$(".alert_hide").hide();
		}, 2500);

		$(document).on('click', '.filter-icon-show', function() {
			$(".filter-icon + .common-section").addClass('show-block');
			$(".filter-icon").removeClass('filter-icon-show').addClass('filter-icon-close');
		});
		$(document).on('click', '.filter-icon-close', function() {
			$(".filter-icon + .common-section").removeClass('show-block');
			$(".filter-icon").removeClass('filter-icon-close').addClass('filter-icon-show');
		});

	});


	function sortwithorder(ths) {

		var newurl = $(ths).val();
		var cururl = document.location.toString();
		var arr = cururl.split('?');
		if (window.location.href.indexOf("page") > -1) {

			var page = arr[1].toString().split('&');

			window.location.href = arr[0] + '?' + page[0] + '&sort=' + newurl;
		} else {
			window.location.href = arr[0] + '?sort=' + newurl;
		}

	}

	function submitfrm() {
		$("#searchjob").submit();
	}

	function resetmyform() {
		//$("#searchcandidates")[0].reset();
		window.location.href = "{{url('/jobs/candidates/list')}}";
	}
</script>

@endpush


<div class="app-content content">
	<div class="content-wrapper">

		@if(session()->has('success'))
		<div class="alert_hide col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>
		@endif

		@if(session()->has('warning'))
		<div class="alert_hide col-12 alert alert-warning text-center mt-1" id="alert_message">{{ session()->get('warning') }}</div>
		@endif

		<div class="content-header row">
		</div>
		<div class="content-body">

			<!-- Revenue, Hit Rate & Deals -->
			<div class="row resp-view">

				<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
					@if(!$timeslots->isEmpty())
					<form name="csv" id="" method="post" action="{{ route('csv.download') }}">
						@csrf

						<button type="submit" class="btn btn-primary btn-color" id="csv"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;CSV</button>
					</form>
					@endif
					<div class="common-section">
						<div class="modal-profilelist i-profilelist candidate-list">
							<div>

								@if(!$timeslots->isEmpty())
								@foreach($timeslots as $timeslot)

								@php
								$cand = App\Candidate::where('id', $timeslot->allotted_candidate_id)

								->first();
								@endphp

								<div class="modal-profileblock">
									<div>
										<div class="avatar-image">

											<span>
												@if($cand)
												@if($cand->photo == '' && ($cand->sex =='' || $cand->sex =='None'))
												<img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
												@elseif($cand->photo == '' && $cand->sex =='Male')
												<img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
												@elseif($cand->photo == '' && $cand->sex =='Female')
												<img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">
												@else
												<img class="rounded-circle" src="{{ asset('storage/' . $timeslot->photo) }}">
												@endif
												@endif
											</span>
										</div>
									</div>
									<div>
										<?php
										$time = time();
										?>
										@if($cand)
										<p>{{$cand->name}}</p>
										<p> {{ucfirst($cand->role)}} </p>
										<p><span>Experience:</span> <span> {{$cand->experience}} yrs</span></p>
										<p style="font-size:10px"><span>JOB ID :: </span> <span><b> {{ $timeslot->job_id }}</b></span></p>
										<p style="font-size:10px"><span>Candidate ID :: </span> <span><b> {{ $cand->id }}</b></span></p>

										@if($time > $timeslot->interview_end_time)
										<p><span>Status:</span> <span style="color: green;"><b>COMPLTETED</b></span></p>
										@endif
										@if($time < $timeslot->interview_end_time)
											<p><span>Status:</span> <span style="color:red;"> Interview Pending</span></p>
											@endif


									</div>

									<div>
										<p> {{ $timeslot->interview_date }} </p>
										<p> {{ date("g:i A", $timeslot->interview_start_time) }} </p>
									</div>
									<div>
										<p>Interviewer :</p>
										<p> {{ $timeslot->interviewer_name }}</p>
									</div>
								</div>
								@endif
								@endforeach
								@else

								<p class="alert alert-warning">No records found</p>

								@endif

								{{ $timeslots->links() }}

							</div>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">

					<div class="common-section">
						<form id="candidatelist" method="post" class="filter-form">
							@csrf
							<div class="card  filter-section ">
								<div class="card-content">
									<h4>Filter</h4>

									<div class="section">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<input type="hidden" name="from" id="startdate">
												<input type="hidden" name="to" id="enddate">

												<label class="control-label">Interview Date</label>
												<input type="text" id="searchdate" style="border: 0; color: #f6931f; font-weight: bold;" size="100" />
												<div id="month-slider" class="slider month-slider"></div>
											</div>
										</div>
									</div>

									<div class="section">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<input type="hidden" name="from_time" id="starttime">
												<input type="hidden" name="to_time" id="endtime">

												<label class="control-label">Interview Time</label>
												<input type="text" id="searchtime" style="border: 0; color: #f6931f; font-weight: bold;" size="100" />
												<div id="time-slider" class="slider time-slider"></div>
											</div>
										</div>
									</div>

									<div class="section">
										<label class="control-label"> Interviewer Name</label>
										<select class="form-control" name="interviewer">
											<option value=""> -- Select Interviewer -- </option>
											@foreach($interviewersArr as $interviewer)
											<option value="{{ $interviewer }}" @if(isset($sel_interviewer_name) && $sel_interviewer_name==$interviewer) selected="" @endif>
												{{ $interviewer }}
											</option>
											@endforeach
										</select>
									</div>
									<div class="section">
										<button type="submit" class="btn btn-primary btn-color" @if($timeslots->isEmpty()) disabled="" @endif>Apply</button>
										<button type="button" onclick="resetmyform()" class="btn btn-primary"><img src="{{url('/')}}/assets/images/icons/reset.png"> Reset</button>
									</div>

								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<!--/ Revenue, Hit Rate & Deals -->

		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->



@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection