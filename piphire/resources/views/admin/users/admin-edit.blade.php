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
        $("#useredit").validate({
              rules: {
                name: {
                  required : true
                },
                password : {
                  minlength : 6
                },                
                confirmpassword : {
                  minlength : 6,
                  equalTo : "#newpassword"
                }
              },
              messages: {
                name: {
                  required : "Please enter a name"
                },
                password : {
                  minlength : "The password should be minimum 6 characters"
                },                
                confirmpassword : {
                  minlength : "The password should be minimum 6 characters",
                  equalTo : "The password do not match"
                }                              
              },
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });   


        function setpassword(){
          $(".pass_show").toggle();
        }


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
                    <form id="useredit" method="post" class="form form-horizontal form-bordered">
                      @csrf
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Admin Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Name</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name" name="name" value="{{auth()->user()->name}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput4">Phone</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone" value="{{auth()->user()->phone}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <button class="btn btn-danger" type="button" onclick="setpassword()">Change Password</button>
                        </div>

                        <div class="form-group row last pass_show" style="display: none;">
                          <label class="col-md-3 label-control" for="newpassword">Password</label>
                          <div class="col-md-9">
                            <input type="password" id="newpassword" class="form-control" name="password" value="">
                          </div>
                        </div>

                        <div class="form-group row last pass_show" style="display: none;">
                          <label class="col-md-3 label-control" for="confirmpassword">Confirm Password</label>
                          <div class="col-md-9">
                            <input type="password" id="confirmpassword" class="form-control" name="confirmpassword" value="">
                          </div>
                        </div>


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