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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

  <script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
  <script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha256-2Pjr1OlpZMY6qesJM68t2v39t+lMLvxwpa8QlRjJroA=" crossorigin="anonymous"></script>
  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
  <script type="text/javascript">

    function readURL(input) {
        if (input.files && input.files[0]) {

          if( input.files[0].size > '2000000'){
            alert('Maximum supported image size is 2mb');
            $("#id_image").val("");
          }else{

            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile_image').attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            submitfrm();
            
          }
        }
    }   

    function submitfrm(){
      if($("#editprofile").valid()){
        $("#editprofile").ajaxSubmit({
          url: "{{url('/myprofile')}}", 
          type: 'post',
          success: function(data){
              if(data.success==1){
                  
              }
          }
        });
      }
    }

      $(document).ready(function(){
        $("#editprofile").validate({
              rules: {
                name: {
                  required : true
                },
                phone : {
                  required : true,
                  phonevalidation : true
                }
              },
              messages: {
                name: {
                  required : "Please enter your name"
                },
                phone : {
                  required : 'Please enter phone number',
                  phonevalidation : 'Please enter a valid phone number'
                }                
              },
            });

            jQuery.validator.addMethod("phonevalidation", function (phone_number, element) {
              phone_number = phone_number.replace(/\s+/g, "");
              return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
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
              <h4 class="titlehead"><span>Edit Profile</span></h4>
              <form name="editprofile" id="editprofile" enctype="multipart/form-data" method="post" class="common-form edit-profile">
                @csrf
                <div class="form-section">
                  <div class="pimg-section">

                    @if($userObj->profileimage)
                    <img class="rounded-circle profile_image" width="100px;" src="{{url('/storage/'.$userObj->profileimage)}}">
                    @endif
                    <span class="pedit-icon"><input id="id_image" type="file" onchange="readURL(this)" name="profileimg"></span>
                  </div>
                </div>
                <div class="form-section">
                  <label class="control-label">Name</label>
                  <input class="form-control" type="text" name="name" placeholder="Name" value="{{$userObj->name}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Designation</label>
                  <input class="form-control" type="text" name="designation" placeholder="Designation" value="{{$userObj->designation}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Phone</label>
                  <input class="form-control" type="text" name="phone" placeholder="Phone" value="{{$userObj->phone}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Twitter</label>
                  <input class="form-control" type="text" name="twitter" placeholder="Twitter" value="{{$userObj->twitter}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Location</label>
                  <input class="form-control" type="text" name="location" placeholder="Location" value="{{$userObj->location}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Bio</label>
                  <textarea class="form-control" type="text" name="bio" placeholder="Bio" rows="10">{{$userObj->bio}}</textarea>
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