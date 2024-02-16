@extends('layouts.app')

@section('content')

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
        $("#orgcreate").validate({
              rules: {
                name: {
                  required : true
                }
              },
              messages: {
                name: {
                  required : "Please enter job title"
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
                    <form id="orgcreate" method="post" enctype="multipart/form-data" class="form form-horizontal form-bordered">
                     @csrf
                      <div class="form-body">
                        <h4 class="form-section"><i class="ft-user"></i> Job Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Title</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name"
                            name="name" value="{{$job->name}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput9">Description</label>
                          <div class="col-md-9">
                            <textarea id="projectinput9" rows="5" class="form-control" name="description" placeholder="Description">{{$job->description}}</textarea>
                          </div>
                        </div>
                        {{--
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput4">Experience Minimum</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput4" class="form-control" placeholder="Experience Minimum" name="experience_min" value="{{$job->experience_min}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput5">Experience Maximum</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput5" class="form-control" placeholder="Experience Maximum" name="experience_max" value="{{$job->experience_max}}">
                          </div>
                        </div>
                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput6">Qualification</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput6" class="form-control" placeholder="Qualification"
                            name="qualification" value="{{$job->qualification}}">
                          </div>
                        </div>
                        --}}                       
                      </div>
                      <div class="form-actions">
                        <a href="{{url('/jobs')}}" type="button" class="btn btn-warning mr-1">
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
@section('footer')
@include('partials.frontend.interview')
@endsection

@endsection

@section('footer')
  @include('partials.backend.footer')
@endsection  