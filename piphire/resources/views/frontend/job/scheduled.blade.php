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

  <style type="text/css">
  	div#time-slider {
  	    margin-top: 10px;
  	    background: #ececec !important;
  	    border: none !important;
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
  <script type="text/javascript">
  	$(function() {
  		var d = new Date();
  		startday = "{{$startdate}}";
  		today = "{{$enddate}}";
  		$( "#month-slider" ).slider({
  			range: true,
  			min: new Date(startday).getTime() / 1000,
  			max: new Date(today).getTime() / 1000,
  			step: 86400,
  			values: [ new Date('{{$sel_startdate}}').getTime() / 1000, new Date('{{$sel_enddate}}').getTime() / 1000 ],
  			slide: function( event, ui ) {
  				$( "#searchdate" ).val( (new Date(ui.values[ 0 ] *1000).toLocaleDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toLocaleDateString() );

  				$("#startdate").val(new Date(ui.values[ 0 ] *1000).toLocaleDateString());
  				$("#enddate").val(new Date(ui.values[ 1 ] *1000).toLocaleDateString());

  			}
  		});
  		$( "#searchdate" ).val( (new Date($( "#month-slider" ).slider( "values", 0 )*1000).toLocaleDateString()) +
  			" - " + (new Date($( "#month-slider" ).slider( "values", 1 )*1000)).toLocaleDateString());

  		$("#startdate").val(new Date($( "#month-slider" ).slider( "values", 0 )*1000).toLocaleDateString());
  		$("#enddate").val(new Date($( "#month-slider" ).slider( "values", 1 )*1000).toLocaleDateString());

  	});
  </script>


  <script type="text/javascript">
  	$(function() {

  		$( "#time-slider" ).slider({
  			range: true,
  			min: 0,
  			max: 1440,
  			step: 30,
  			values: [ '{{$sel_starttime}}', '{{$sel_endtime}}' ],
  			slide: function(e, ui) {

  				var s_hours = Math.floor(ui.values[ 0 ] / 60);
  				var s_minutes = ui.values[ 0 ] - (s_hours * 60);

  				if(s_hours.toString().length == 1) s_hours = '0' + s_hours;
  				if(s_minutes.toString().length == 1) s_minutes = '0' + s_minutes;

  				var e_hours = Math.floor(ui.values[ 1 ] / 60);
  				var e_minutes = ui.values[ 1 ] - (e_hours * 60);

  				if(e_hours.toString().length == 1) e_hours = '0' + e_hours;
  				if(e_minutes.toString().length == 1) e_minutes = '0' + e_minutes;

  				$( "#searchtime" ).val( s_hours + ':' + s_minutes + ' - ' + e_hours + ':' + e_minutes);

  				$("#starttime").val( ui.values[ 0 ] );
  				$("#endtime").val( ui.values[ 1 ] );
  			}
  		});

  		var initial_s_hours = Math.floor( $( "#time-slider" ).slider( "values", 0 ) / 60);
  		var initial_s_minutes = $( "#time-slider" ).slider( "values", 0 ) - (initial_s_hours * 60);
  		if(initial_s_hours.toString().length == 1) initial_s_hours = '0' + initial_s_hours;
  		if(initial_s_minutes.toString().length == 1) initial_s_minutes = '0' + initial_s_minutes;

  		var initial_e_hours = Math.floor( $( "#time-slider" ).slider( "values", 1 ) / 60);
  		var initial_e_minutes = $( "#time-slider" ).slider( "values", 1 ) - (initial_e_hours * 60);
  		if(initial_e_hours.toString().length == 1) initial_e_hours = '0' + initial_e_hours;
  		if(initial_e_minutes.toString().length == 1) initial_e_minutes = '0' + initial_e_minutes;

  		$( "#searchtime" ).val( initial_s_hours + ':' + initial_s_minutes + ' - ' + initial_e_hours + ':' + initial_e_minutes);

  		$("#starttime").val( $( "#time-slider" ).slider( "values", 0 ) );
  		$("#endtime").val( $( "#time-slider" ).slider( "values", 1 ) );

  	});
  </script>

  <script>

	$(document).ready(function(){
	  setinitial();
	});

	function setinitial(){
	  $('.knob').trigger('configure', {
		  max: 100,
		  thickness:0.1,
		  fgColor:'#2CC2A5',
		  width: 50,
		  height: 50
	  });

	  $('.knob.knob1').trigger('configure', {
		  max: 100,
		  thickness:0.2,
		  fgColor:'#2CC2A5',
		  width: 40,
		  height: 40
	  });

	  $(function() {
		var output = document.querySelectorAll('output')[0];

		$(document).on('input', 'input[type="range"]', function(e) {

			  document.querySelector('output.'+this.id).innerHTML = e.target.value;
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


		var split = function( val ) {
			return val.split( "," );
		};

		var extractLast = function( term ) {
			return split( term ).pop();
		};

	  $( "#skillset" ).autocomplete({
			source: function(request, response) {
				$.ajax({
				url: "{{url('/skill/autocomplete')}}",
				data: {
						term : extractLast( request.term )
				 },
				dataType: "json",
				  success: function(data){
					 var resp = $.map(data,function(obj){
						  //alert(obj.name);
						  return obj.name;
					 });

					 response(resp);
				  }
				});
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				terms.pop();
				terms.push( ui.item.value );
				terms.push( "" );
				this.value = terms.join( "," );
				return false;
			},
		  minLength: 2
		});

	}
  </script>

  <script type="text/javascript">
	function searchlist(){

	  $("#profile_list").html('Loading...');

	  $.ajax({
		url: "{{url('/job/details/search')}}",
		type: "post",
		data: {'frm': $("#candidatelist").serialize() },
		success: function(data){
		  if(data.success==1){
			$("#profile_list").html(data.view);
			//$("#mytot").html(data.totalcount);
			//setinitial();
		  }else if(data.error==1){
			swal("Alert", data.errormsg, "error");
		  }
		}
	  });

	}

  setTimeout(function(){ $(".alert_hide").hide(); }, 2500);

  function showfulldec(){
	$(".short").hide();
	$(".full").show();
  }

  function shoshort(){
	$(".full").hide();
	$(".short").show();
  }
  </script>

  <script type="text/javascript">
		function gotoback(){
			history.back();
		}
		function resetmyform(){
		//$("#searchcandidates")[0].reset();
		window.location.href = "<?php echo url('/interview/scheduled/view/'.$job->juid); ?>";
	  }
  </script>


<script type="text/javascript">
	$(function(){
		$("#selectallblock").on('change',function(){
			if($(this).is(":checked")){
				$(".profile_check").prop('checked', true).change();
			}else{
				$(".profile_check").prop('checked', false).change();
			}
		});

		$(".profile_check").change(function(){
			var selectedCount = $('input[name="finalizeprofile[]"]:checked').length;
			if(selectedCount == 0){
				$(".slot-section").removeClass('active');
			} else{
				$(".slot-section").addClass('active');
			}
		});
	});

	function deleteSelected(){
		var selectedCount = $('input[name="finalizeprofile[]"]:checked').length;
		if(selectedCount == 0){
			swal("Alert", 'Please select atleast one profile', "error");
			return false;
		}

		$('input[name="finalizeprofile[]"]:checked').each(function () {
			$(this).parents('.i-profilematrix').remove();
		});

		$("#selectallblock").prop('checked', false).change();
	}

	function finalizeShortlisted(){

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
			success:function(response){
				if (response.status) {
					window.location.href = response.redirect_url;
				}
			},
			error:function(response) {
				console.log('inside ajax error handler');
			}
		});
	}

</script>

@endpush

<style type="text/css">
	.newtab-section li:not(.active) a{
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
								<li class="scheduled-section active">
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
											@php
												$selectedSlot = App\InterviewTimeslot::where('job_id', $job->id)
															->where('hasAllotted', 1)
															->where('allotted_candidate_id', $ck->id)
															->first();
											@endphp

											@if($selectedSlot)
											<p><span>Interviewer -  {{ $selectedSlot->interviewer_name}}</span></p>
												<p><span> {{ $selectedSlot->interview_date }}</span></p>
												<p><span> {{ date("g:i A", $selectedSlot->interview_start_time) }}</span></p>
											@else
												<p><span>-</span></p>
												<p><span>-</span></p>
											@endif
										</div>
										<div class="checkbox-block">
										  <input class="profile_check"  id="checkblock_0" type="checkbox" checked="" disabled="">
										  <label for="checkblock_0"></label>
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

			<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				<div class="common-section">
					<form id="candidatelist" method="post" class="filter-form">
						<input type="hidden" name="juid" value="{{ $job->juid }}">
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
									  <input type="text" id="searchdate" style="border: 0; color: #f6931f; font-weight: bold;" size="100"/>
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
									  <input type="text" id="searchtime" style="border: 0; color: #f6931f; font-weight: bold;" size="100"/>
									  <div id="time-slider" class="slider time-slider"></div>
									</div>
								  </div>
								</div>

								<div class="section">
									<label class="control-label"> Interviewer Name</label>
									<select class="form-control" name="interviewer">
										<option value=""> -- Select Interviewer -- </option>
										@foreach($interviewersArr as $interviewer)
											<option value="{{ $interviewer }}" @if(isset($sel_interviewer_name) && $sel_interviewer_name == $interviewer) selected="" @endif>
												{{ $interviewer }}
											</option>
										@endforeach
									</select>
								</div>
								<div class="section">
									<button type="submit" class="btn btn-primary btn-color">Apply</button>
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
