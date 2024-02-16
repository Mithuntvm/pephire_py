@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
	$.ajaxSetup({
	  headers: {
		  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});

	function getscore(){
		var pendingresumes_url = '{{ $retry != null ? url("/pendingresumes/retry") : url("/pendingresumes") }}';

		$.ajax({
			url: "{{url('/profileattributionscore')}}",
			type: "post",
			data: {
				is_retry : '{{ $retry != null ? 1 : 0 }}',
				total_count: $("#total_count").val()
			},
			success: function(data){
				if(data.success==1){
					$('#mypreload').hide();
					if(data.yet_to_attribute_count == 0){

						$("#myprogress").attr('aria-valuenow',100);
						$("#myprogress").attr('style','width:100%');
						$("#myprogress").html('100%');
						$(".myhead").show();

						setTimeout(function(){
							//window.location.href= "{{url('/profiledatabase')}}";
							window.location.href= pendingresumes_url;
						}, 3000);

					}else{

						$("#myprogress").attr('aria-valuenow',data.totalpercent);
						$("#myprogress").attr('style','width:'+data.totalpercent+'%');
						$("#myprogress").html(data.totalpercent+'%');

						getscore();
					}

				}else if(data.error==1){

					if(data.yet_to_attribute_count == 0){

						$("#myprogress").attr('aria-valuenow',100);
						$("#myprogress").attr('style','width:100%');
						$("#myprogress").html('100%');
						$(".myhead").show();

						swal("Alert", data.errorMsg, "error");

						setTimeout(function(){
							//window.location.href= "{{url('/profiledatabase')}}";
							window.location.href= pendingresumes_url;
						}, 3000);

					} else {

						$("#myprogress").attr('aria-valuenow',data.totalpercent);
						$("#myprogress").attr('style','width:'+data.totalpercent+'%');
						$("#myprogress").html(data.totalpercent+'%');

						swal("Alert", data.errorMsg, "error");

						setTimeout(function(){
							getscore();
						}, 1000);

					}
				}
			},
			statusCode: {
				401: function() {
					window.location.href = pendingresumes_url; //or what ever is your login URI
				},
				419: function() {
					window.location.href = pendingresumes_url; //or what ever is your login URI
				}
			},
			error: function (res) {
				swal("Alert", 'Some error occured! Please try after some time', "error");
			}
		});

	}

	$(document).ready(function(){
		getscore();
	});

</script>
@endpush

@push('styles')

@endpush

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
		</div>
		<div class="content-body">


			<section id="labeled-progress">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Understanding the Candidate in detail...</h4>
							</div>
							<div class="card-content">
								<div class="card-body text-center">
									<div class="progress">
										<div class="progress-bar progress-bar-striped active" id="myprogress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
									</div>
									<div class="heading-elements">
										<p class="myhead" style="display: none; font-size: 18px;"><b>The process has been completed, you will be redirected to listing page</b></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

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
					background: rgba(255,255,255,0.55)
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
				#mypreload  span{
					position:relative;
					top:-20px;
					color:#000;
					font-size: 24px;
					z-index: 99;
				}
			</style>

			<div id="mypreload" style="display: none;">
				<span style="">Fetching Profiles</span>
				<div class="nb-spinner"></div>
			</div>

			<input type="hidden" name="total_count" id="total_count" value="{{ $total_count }}">

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