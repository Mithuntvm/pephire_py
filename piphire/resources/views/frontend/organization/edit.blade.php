@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

@push('scripts')
  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    
      $(document).ready(function(){
        $("#editorg").validate({
              rules: {
                name: {
                  required : true
                },                
                // email: {
                //   required : true,
                //   email : true,
                //   remote: {
                //     url: "{{url('/checkemailexistorg')}}",
                //     type: "post",
                //     data: {
                //       email: function(){ return $("#projectinput3").val(); },
                //       orgid: "{{$organization->id}}"
                //     }
                //   }                   
                // },
                plan_id: {
                  required : true
                }
              },
              messages: {
                name: {
                  required : "Please enter organization name"
                },
                email: {
                  required : "Please enter email",
                  email : "Please enter valid email",
                  remote : "This email is already in use with another organization"
                },
                plan_id: {
                  required : "Please select a plan"
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
              <h4 class="titlehead"><span>Organization Info</span></h4>
              <form name="editorg" id="editorg" enctype="multipart/form-data" method="post" class="common-form edit-profile">
                @csrf
                <div class="form-section">
                  <label class="control-label">Name</label>
                  <input class="form-control" type="text" name="name" placeholder="Name" value="{{$organization->name}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Organization Email</label>
                  <input class="form-control" type="email" id="projectinput3" name="email" placeholder="Email" value="{{$organization->email}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Organization Phone</label>
                  <input class="form-control" type="text" name="phone" placeholder="Phone" value="{{$organization->phone}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Address</label>
                  <textarea class="form-control" name="address" placeholder="Address">{{$organization->address}}</textarea>
                </div>
                <div class="form-section">
                  <label class="control-label">City</label>
                  <input class="form-control" type="text" name="city" placeholder="City" value="{{$organization->city}}">
                </div>
                <div class="form-section">
                  <label class="control-label">State</label>
                  <input class="form-control" type="text" name="state" placeholder="State" value="{{$organization->state}}">
                </div>
                <div class="form-section">
                  <label class="control-label">Zip</label>
                  <input class="form-control" type="text" name="zip" placeholder="Zip" value="{{$organization->zip}}">
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