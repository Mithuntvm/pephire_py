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
                },
                amount: {
                  required : true,
                  money : true
                },
                no_of_searches: {
                  required : true
                },
                plantype_id: {
                  required : true
                }                
              },
              messages: {
                name: {
                  required : "Please enter plan name"
                },
                amount: {
                  required : "Please enter plan amount",
                  money : "Please enter a valid amount"
                },
                no_of_searches: {
                  required : "Please enter number of searches"
                },
                plantype_id: {
                  required : "Please select a plan type"
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
                        <h4 class="form-section"><i class="ft-user"></i> Plan Info</h4>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput1">Name</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput1" class="form-control" placeholder="Name" name="name" value="{{$plan->name}}">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput6">Plan Type</label>
                          <div class="col-md-9">
                            <select id="projectinput6" name="plantype_id" class="form-control">
                              <option value="none" selected="" disabled="">Select a Plan Type</option>

                              @foreach($palntypes as $ck =>$cv)
                                <option @if($plan->plantype_id == $cv->id) selected=selected @endif value="{{$cv->id}}">{{$cv->name}}</option>
                              @endforeach

                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput3">Amount</label>
                          <div class="col-md-9">
                            <input type="text" id="projectinput3" class="form-control" placeholder="Amount" name="amount" value="{{$plan->amount}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput4">No.of Searches </label>
                          <div class="col-md-9">
                            <input type="number" id="projectinput4" class="form-control" placeholder="No.of Searches" name="no_of_searches" value="{{$plan->no_of_searches}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput14">No.of Resumes </label>
                          <div class="col-md-9">
                            <input type="number" id="projectinput14" class="form-control" placeholder="No.of Resumes" name="max_resume_count" value="{{$plan->max_resume_count}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput5">No.of Users </label>
                          <div class="col-md-9">
                            <input type="number" id="projectinput5" class="form-control" placeholder="No.of Users" name="max_users" value="{{$plan->max_users}}">
                          </div>
                        </div>

                        <div class="form-group row last">
                          <label class="col-md-3 label-control" for="projectinput7">Description</label>
                          <div class="col-md-9">
                            <textarea id="projectinput7" placeholder="Description" name="description" class="form-control">{{$plan->description}}</textarea>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput9">No of Months</label>
                          <div class="col-md-9">
                            <select name="month_count" class="form-control">
                              @for($i=0; $i<=12; $i++)
                              <option @if($plan->month_count == $i) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                              @endfor
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput13">No of Years</label>
                          <div class="col-md-9">
                            <select name="year_count" class="form-control">
                              @for($j=0; $j<=5; $j++)
                              <option @if($plan->year_count == $j) selected="selected" @endif value="{{$j}}">{{$j}}</option>
                              @endfor
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="projectinput14">Show in Frontend</label>
                          <div class="col-md-9">
                            <input id="projectinput14" @if($plan->frontend_show == 1) checked="checked" @endif name="frontend_show" type="checkbox">
                          </div>
                        </div>

                      </div>
                      <div class="form-actions">
                        <a href="{{url('/backend/plan/list')}}" class="btn btn-warning mr-1">
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