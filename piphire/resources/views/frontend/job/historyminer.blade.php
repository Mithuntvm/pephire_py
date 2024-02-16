@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
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
<script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
  $(function() {
    var d = new Date();
    today = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
    $("#month-slider").slider({
      range: true,
      min: new Date('2020.01.01').getTime() / 1000,
      max: new Date(today).getTime() / 1000,
      step: 86400,
      values: [new Date('2020.01.01').getTime() / 1000, new Date(today).getTime() / 1000],
      slide: function(event, ui) {
        $("#searchdate").val((new Date(ui.values[0] * 1000).toLocaleDateString()) + " - " + (new Date(ui.values[1] * 1000)).toLocaleDateString());
        //getsortedcandidates();
      }
    });
    $("#searchdate").val((new Date($("#month-slider").slider("values", 0) * 1000).toLocaleDateString()) +
      " - " + (new Date($("#month-slider").slider("values", 1) * 1000)).toLocaleDateString());
  });
</script>

<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript">
  function gotoback() {
    history.back();
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert-success").hide();
    }, 2500);
    setTimeout(function() {
      $(".alert-warning").hide();
    }, 2500);

    $("#jobname").on('keypress', function(e) {
      if (e.which == 13) {

        var srval = $("#jobname").val();
        if (srval) {
          window.location.href = "{{url('/jobs/history?')}}" + srval;
        }
      }
    });
    $(".checkindates").flatpickr({
      altFormat: 'd-M-Y',
      dateFormat: 'd-M-Y'
    });


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).on('click', '.filter-icon-show', function() {
      $(".filter-icon + .common-section").addClass('show-block');
      $(".filter-icon").removeClass('filter-icon-show').addClass('filter-icon-close');
    });
    $(document).on('click', '.filter-icon-close', function() {
      $(".filter-icon + .common-section").removeClass('show-block');
      $(".filter-icon").removeClass('filter-icon-close').addClass('filter-icon-show');
    });

  });


  function sortwithorder(ths) {

    var newurl = $(ths).val();
    var cururl = document.location.toString();
    var arr = cururl.split('?');
    if (window.location.href.indexOf("page") > -1) {

      var page = arr[1].toString().split('&');

      window.location.href = arr[0] + '?' + page[0] + '&sort=' + newurl;
    } else {
      window.location.href = arr[0] + '?sort=' + newurl;
    }

  }

  function submitfrm() {
    $("#searchjob").submit();
  }


  // function getprofiles(juid) {
  //   $.ajax({
  //     url: "{{url('/profilepopup/popupgetbyjob')}}",
  //     type: 'post',
  //     data: {
  //       'juid': juid
  //     },
  //     success: function(data) {
  //       $("#list_profiles").html(data.resumelist);
  //       $("#profile-miner").modal('show');
  //     },
  //     statusCode: {
  //       401: function() {
  //         window.location.href = '/'; //or what ever is your login URI 
  //       },
  //       419: function() {
  //         window.location.href = '/'; //or what ever is your login URI 
  //       }
  //     },
  //     error: function(res) {
  //       swal("Alert", 'Some error occured! Please try after some time', "error");
  //     }
  //   });

  // }

  /*    function resetmyform(){
        //$("#searchcandidates")[0].reset();
        alert(1);
        window.location.href = "{{url('/jobs/history')}}";
      }  */
</script>

@endpush


<div class="app-content content">
  <div class="content-wrapper">

    @if(session()->has('success'))
    <div class="col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>
    @endif

    @if(session()->has('warning'))
    <div class="col-12 alert alert-warning text-center mt-1" id="alert_message">{{ session()->get('warning') }}</div>
    @endif

    <div class="content-header row">
    </div>
    <div class="content-body">
      <!-- Revenue, Hit Rate & Deals -->
      <div class="row resp-view">
        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
          <div class="common-section">

            <div class="history-block">
              <div>

                @if(!$jobs->isEmpty())
                @foreach($jobs as $ck)
                <!-- onclick="getprofiles('{{$ck->juid}}')" -->
                <a href="{{ url('/jobs/reusehistory/'.$ck->juid) }}">
                  <div class="i-historyblock">
                    <div>
                      <h4>{{$ck->name}}</h4>
                      <p>{{ \Carbon\Carbon::parse($ck->created_at)->format('M d Y') }}</p>
                    </div>
                    <!-- <div>
                        <a href="javascript:void(0);" >Candidates</a>
                      </div> -->
                    <div>
                      <p>{{ str_limit($ck->description, 50) }}...</p>
                      <p class="resume-count candiate-pop">
                        <!-- <span><i class="ft-file-text"></i></span> -->
                        <!-- <span>View Candidates</span> -->
                      </p>
                    </div>
                  </div>

                  @endforeach
                  @else

                  <p class="alert alert-warning">No records found</p>

                  @endif

                  {{ $jobs->links() }}

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
          <p class="filter-icon filter-icon-show"><i class="ft-filter"></i> Filter</p>
          <div class="common-section">
            <button type="button" class="btn btn-primary btn-float btn-newprev" data-toggle="tooltip" title="Go to Fitment Analysis"><a class="fitment-link" href="{{url('/jobs/create')}}"><i class="ft-arrow-left" aria-hidden="true"></i></a></button>
            <form name="searchjob" id="searchjob" method="get" class="filter-form">
              <div class="card  filter-section ">
                <div class="card-content">


                  <div class="section">
                    <label class="control-label">Job Title</label>
                    <input class="form-control" type="text" value="@if($jobname){{$jobname}}@endif" id="jobname" name="jobname" placeholder="">
                  </div>
                  <div class="section">
                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                        <label class="control-label">Resume Upload Date</label>
                        <input type="text" id="searchdate" style="border: 0; color: #f6931f; font-weight: bold;" size="100" />
                        <div id="month-slider" class="slider month-slider"></div>
                      </div>
                    </div>
                  </div>
                  <div class="section">
                    <label class="control-label">Sort By</label>
                    <select name="sort" onchange="submitfrm()" class="form-control">
                      <option @if($sortval=='date' ) selected="selected" @endif value="date">Sort by Resume upload Date</option>
                      <option @if($sortval=='resume' ) selected="selected" @endif value="resume">Sort by Resume Count</option>
                    </select>
                  </div>

                </div>
              </div>
              <div class="section">
                <button class="btn btn-primary btn-color">Submit</button>
                <!-- {{-- <button type="button" onclick="resetmyform()" class="btn btn-primary"><img src="{{url('/')}}/assets/images/icons/reset.png"> Reset</button> --}} -->
              </div>
            </form>
          </div>
        </div>

        <!-- {{--
          <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
            <div class="common-section">
              <div class="title-section">
                <h4>Popular tags</h4>
              </div>
              <div class="historytag-section ">
                <a href="#">ARTIST</a>
                <a href="#">ANIMATION</a>
                <a href="#">Illustrator</a>
                <a href="#">Photoshop</a>
                <a href="#">DESIGNER</a>
                <a href="#">ANALYST</a>
                <a href="#">ANDROID DEVELOPER</a>
                <a href="#">iOS DEVELOPER</a>
              </div>
            </div>
          </div>
          --}} -->

      </div>
      <!--/ Revenue, Hit Rate & Deals -->


      <!-- Profile modal -->
      <!-- <div class="modal fade text-left" id="profile-miner" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <div class="modal-profilelist">
                <div id="list_profiles">


                </div>
              </div>
              <div class="submit-btn submit-btn1">
                <a href="javascript:void(0);" class="btn btn-primary btn-default" data-dismiss="modal">Cancel</a>
                {{--
                                    <a href="javascript:void(0);" class="btn btn-primary">Add</a>
                                    --}}
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- end Profile modal -->

    </div>
  </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection