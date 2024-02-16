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

  <script type="text/javascript">
    
      $(document).ready(function(){
        $("#usercreate").validate({
              rules: {
                name: {
                  required : true
                },
                email: {
                  required : true,
                  email : true,
                  remote: {
                    url: "{{url('/checkemailexist')}}",
                    type: "post",
                    data: {
                      email: function(){ return $("#projectinput3").val(); }
                    }
                  }
                }
              },
              messages: {
                name: {
                  required : "Please enter a name"
                },
                email: {
                  required : "Please enter an email",
                  email : "Please enter a valid email",
                  remote : "This email is already in use with another account"
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
      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="common-section">
              <h4 class="titlehead"><span>Create</span></h4>
              <form name="create" id="usercreate" enctype="multipart/form-data" method="post" class="common-form edit-profile">
                @csrf
                <div class="form-section">
                  <label class="control-label">Name</label>
                  <input class="form-control" type="text" name="name" placeholder="Name" value="">
                </div>
                <div class="form-section">
                  <label class="control-label">Email</label>
                  <input class="form-control" id="projectinput3" type="email" name="email" placeholder="Email" value="">
                </div>
                <div class="form-section">
                  <label class="control-label">Phone</label>
                  <input class="form-control" type="text" name="phone" placeholder="Phone" value="">
                </div>
                <div class="form-section">
                  <button class="btn btn-primary" type="submit">Save</button>
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