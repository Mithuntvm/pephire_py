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
  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<style>
  #send {
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
		margin-left: 25px;

	}
</style>
  <script type="text/javascript">
    
      $(document).ready(function(){
        $("#contactus").validate({
              rules: {
                name: {
                  required : true
                },                
                email: {
                  required : true,
                  email : true                   
                },
                phone: {
                  required : true
                },
                message: {
                  required : true
                }                
              },
              messages: {
                name: {
                  required : "Please enter organization name"
                },
                email: {
                  required : "Please enter your email address",
                  email : "Please enter a valid email address"
                },
                phone: {
                  required : "Please enter your phone number"
                },
                message : {
                  required : "Please enter your messages"
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
@endpush


 <div class="app-content content">
    <div class="content-wrapper">


    @if(session()->has('success'))

    <script type="text/javascript">
      setTimeout(function(){ 
        $(".alert-success").hide();
        window.location.href = "{{url('/profiledatabase')}}";
      }, 3000);      
    </script>

      <div class="col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>   
    @endif

      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="common-section">
              <h4 class="titlehead"><span>CONTACT US</span></h4>
              <form name="contactus" id="contactus" enctype="multipart/form-data" method="post" class="common-form edit-profile">
                @csrf
                <div class="form-section">
                  <label class="control-label">Name</label>
                  <input class="form-control" type="text" name="name" placeholder="Name" value="{{auth()->user()->name}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Email</label>
                  <input class="form-control" type="email" id="projectinput3" name="email" placeholder="Email" value="{{auth()->user()->email}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Phone</label>
                  <input class="form-control" type="text" name="phone" placeholder="Phone" value="{{auth()->user()->phone}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Message</label>
                  <textarea class="form-control" name="message"></textarea>
                </div>                                           
                <div class="form-section">
                  <button class="btn btn-primary" id="send"type="submit">Send</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!--/ Revenue, Hit Rate & Deals -->
        
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