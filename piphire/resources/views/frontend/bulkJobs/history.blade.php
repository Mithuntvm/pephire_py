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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
    $(document).ready(function(){
      setTimeout(function(){ $(".alert_hide").hide(); }, 2500);

      $("#jobname").on('keypress',function(e) {
          if(e.which == 13) {

            var srval = $("#jobname").val();
              if(srval){
                window.location.href = "{{url('/jobs/history?')}}"+srval;
              }
          }
      });
      $(".checkindates").flatpickr({
        altFormat: 'd-M-Y',
        dateFormat: 'd-M-Y'
      });

      $(document).on('click','.filter-icon-show',function() {
        $(".filter-icon + .common-section").addClass('show-block');
        $(".filter-icon").removeClass('filter-icon-show').addClass('filter-icon-close');
      });
      $(document).on('click','.filter-icon-close',function() {
        $(".filter-icon + .common-section").removeClass('show-block');
        $(".filter-icon").removeClass('filter-icon-close').addClass('filter-icon-show');
      });

    });


    function sortwithorder(ths){

      var newurl = $(ths).val();
      var cururl = document.location.toString();
      var arr    = cururl.split('?');
      if(window.location.href.indexOf("page") > -1) {

        var page   = arr[1].toString().split('&');

          window.location.href = arr[0]+'?'+page[0]+'&sort='+newurl;
      } else {
          window.location.href = arr[0]+'?sort='+newurl;
      }

    }

    function submitfrm(){
      $("#searchjob").submit();
    }

    function resetmyform(){
      window.location.href = window.location.href;
    }

	function gotoback() {
        history.back();
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
		<div class="col-3 float-right">
                    <button onclick="gotoback()" type="button" class="btn btn-primary btn-float"><i
                            class="ft-arrow-left" aria-hidden="true"></i></button>
        </div>
		</div>
		<div class="content-body">	
			<div class="row resp-view">
				<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
					<div class="common-section">
						<div class="history-block">
							<div>
								@if(!$jobs->isEmpty())
									@foreach($jobs as $single_job)
										<a href="{{url('/job/details/'.$single_job->juid."?section=bulkJobs")}}">
											<div class="i-historyblock">
												<div>
													<h4>{{$single_job->name}}</h4>
													<p>{{ \Carbon\Carbon::parse($single_job->created_at)->format('M d Y') }}</p>
												</div>
												<div>
													<p>{{ str_limit($single_job->description, 120) }}...</p>
													<div class="resume-count">
														<p>
															<span>{{ $single_job->shortlisted_candidates()->count() }}</span>
															<span>Shortlisted</span>
														</p>
														<p>
															<span>{{ $single_job->shortlisted_candidates()->where('hasFinalized', 1)->count() }}</span>
															<span>Selected</span>
														</p>
														<p>
															<span>{{ $single_job->candidates->count() }}</span>
															<span>Resumes</span>
														</p>
														<p>
															<span> <?php if ($single_job->vacant_positions){ echo $single_job->vacant_positions;} else{ echo 0;} # ?>  </span>
															<span>Positions</span>
														</p>
													</div>
												</div>
											</div>
										</a>
									@endforeach
								@else
								<p class="alert alert-warning">No records found</p>
								@endif
								{{ $jobs->links() }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
					<div class="common-section">
						<form name="searchjob" id="searchjob" method="post" class="filter-form">
							<div class="card  filter-section ">
								<div class="card-content">
									<h4>Filter</h4>
									@csrf
									<div class="section">
										<label class="control-label">Job Title</label>
										<input class="form-control" type="text" value="@if($jobname){{$jobname}}@endif" id="jobname" name="jobname" placeholder="">
									</div>
									<div class="section">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<input type="hidden" name="from" id="startdate">
												<input type="hidden" name="to" id="enddate">

												<label class="control-label">Job created Date</label>
												<input type="text" id="searchdate" style="border: 0; color: #f6931f; font-weight: bold;" size="100"/>
												<div id="month-slider" class="slider month-slider"></div>
											</div>
										</div>
									</div>
									<div class="section">
										<label class="control-label">Sort By</label>
										<select name="sort" onchange="submitfrm()" class="form-control">
											<option @if($sortval == 'date') selected="selected" @endif value="date">Sort by Resume upload Date</option>
											<option @if($sortval == 'resume') selected="selected" @endif value="resume">Sort by Resume Count</option>
										</select>
									</div>
									<div class="section">
										<button class="btn btn-primary btn-color">Apply</button>
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