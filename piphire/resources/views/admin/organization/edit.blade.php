@extends('layouts.backend')

@section('header')
  @include('partials.backend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.backend.sidebar')
@endsection

@push('scripts')
  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    
      $(document).ready(function(){
        $("#orgedit").validate({
              rules: {
                name: {
                  required : true
                },                
                email: {
                  required : true,
                  email : true,
                  remote: {
                    url: "{{url('/backend/checkemailexist')}}",
                    type: "post",
                    data: {
                      email: function(){ return $("#projectinput3").val(); },
                      orgid: "{{$organization->id}}"
                    }
                  }                   
                },
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
      <div class="content-body">
        <!-- Basic form layout section start -->
        <section id="basic-form-layouts">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-content collpase show">
                  <div class="card-body">
                    <div class="card-text">
                      <p></p>
                    </div>
                    <form id="orgedit" method="post" enctype="multipart/form-data" class="form form-horizontal form-bordered">
                      @csrf
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Organization Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Company Name</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name"
                            name="name" value="{{$organization->name}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput3">E-mail</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput3" class="form-control" placeholder="E-mail" name="email" value="{{$organization->email}}">
                          </div>
                        </div>

                        {{--
                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput4">Contact Number</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone" value="{{$organization->phone}}">
                          </div>
                        </div>
                        <h4 class="form-section"><i class="ft-clipboard"></i>Address Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput9">Address</label>
                          <div class="col-md-9">
                            <textarea id="projectinput9" rows="5" class="form-control" name="address" placeholder="Address">{{$organization->address}}</textarea>
                          </div>
                        </div>                        
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput5">City</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput5" class="form-control" placeholder="City"
                            name="city" value="{{$organization->city}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput10">State</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput10" class="form-control" placeholder="State"
                            name="state" value="{{$organization->state}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput11">Zip</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput11" class="form-control" placeholder="Zip"
                            name="zip" value="{{$organization->zip}}">
                          </div>
                        </div>
                        --}}                                                
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput6">Select a Plan</label>
                          <div class="col-md-9">
                            <select id="projectinput6" name="plan_id" name="interested" class="form-control">
                              <option value="none" disabled="">Select a Plan</option>

                              @foreach($plans as $ck =>$cv)
                                <option @if($organization->plan_id == $cv->id) selected="selected" @endif value="{{$cv->id}}">{{$cv->name}}</option>
                              @endforeach

                            </select>
                          </div>
                        </div>
                        {{--
                        <div class="form-group row last">
                          <label class="col-md-3 label-control">Company Logo</label>
                          <div class="col-md-9">

                            <img height="100px;" src="{{asset('/storage/'.$organization->company_logo)}}">
                            <br/>
                            <label id="projectinput8" class="file center-block">
                              <input type="file" name="logo" id="file">
                              <span class="file-custom"></span>
                            </label>
                          </div>
                        </div>
                        --}}
                      </div>
                      <div class="form-actions">
                        <a href="javascript:void(0);" onclick="window.history.back()" class="btn btn-warning mr-1">
                          <i class="ft-x"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                          <i class="la la-check-square-o"></i> Save
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      	</section>
  	</div>
</div>
</div>

@endsection

@section('footer')
  @include('partials.backend.footer')
@endsection