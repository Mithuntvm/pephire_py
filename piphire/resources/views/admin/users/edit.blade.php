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
                email: {
                  required : true,
                  email : true,
                  remote: {
                    url: "{{url('/backend/checkemailexist')}}",
                    type: "post",
                    data: {
                      email: function(){ return $("#projectinput3").val(); },
                      userid: "{{$user->id}}"
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
                        <h4 class="form-section"><i class="ft-user"></i> User Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Name</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name" name="name" value="{{$user->name}}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput3">Email</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput3" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput4">Phone</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone" value="{{$user->phone}}">
                          </div>
                        </div>

                      </div>
                      <div class="form-actions">
                        <a href="{{url('/backend/organization/users/'.$orgdets->ouid)}}" class="btn btn-warning mr-1">
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