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
        $("#planedit").validate({
              rules: {
                name: {
                  required : true
                }
              },
              messages: {
                name: {
                  required : "Please enter plan name"
                }               
              },
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
                    <form id="planedit" method="post" class="form form-horizontal form-bordered">
                      @csrf
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Plan Type Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Name</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name" name="name" value="{{$plantype->name}}">
                          </div>
                        </div>


                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput2">Start Date</label>
                          <div class="col-md-9">
                            <input type="date" id="projectinput2" name="start_date" class="form-control" id="date" value="{{$plantype->start_date}}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput3">End Date</label>
                          <div class="col-md-9">
                            <input type="date" id="projectinput3" name="end_date" class="form-control" id="date" value="{{$plantype->end_date}}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput4">Show in Frontend</label>
                          <div class="col-md-9">
                            <input id="projectinput4" @if($plantype->frontend_show == 1) checked="checked" @endif name="frontend_show" type="checkbox">
                          </div>
                        </div>

                      </div>
                      <div class="form-actions">
                        <a href="{{url('/backend/plantype/list')}}" class="btn btn-warning mr-1">
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