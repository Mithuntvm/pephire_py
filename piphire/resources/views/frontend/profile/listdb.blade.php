@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link href="{{url('/')}}/assets/css/jquery-ui.css" rel="stylesheet">
</link>
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
  .modal-profilelist>div .modal-profileblock>div:nth-child(2) p:last-child {
    color: #8798AD;
    font-size: 11px;
    font-weight: 600;
  }

  .modal-profilelist.i-profilelist>div .modal-profileblock>div:nth-child(4) {
    width: 120px;
    display: none;
  }
</style>
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
<script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{url('/')}}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
@if(empty($filter))
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    var slider = document.getElementById('slider-range');
    noUiSlider.create(slider, {
      start: [0, 50],
      connect: true,
      tooltips: true,
      step: 1,
      range: {
        'min': 0,
        'max': 50
      },
      format: wNumb({
        decimals: 0
      })
    });
    slider.noUiSlider.on('change', getsortedcandidates);
  });
</script>
@else
<script>
  // console.log('jjjjjjjjjjjjjjjjjjjjj')
  document.addEventListener("DOMContentLoaded", function(event) {
    var slider = document.getElementById('slider-range');
    noUiSlider.create(slider, {
      start:  ["<?php echo $filter->exp_1; ?>", "<?php echo $filter->exp_2; ?>"],
      connect: true,
      tooltips: true,
      step: 1,
      range: {
        'min': 0,
        'max': 50
      },
      format: wNumb({
        decimals: 0
      })
    });
    slider.noUiSlider.on('change', getsortedcandidates);
  });
</script>
@endif

<!-- <script type="text/javascript">
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
</script> -->


<script type="text/javascript">
  function gotoback() {
    history.back();
  }
</script>
<script>
  var uploaded = "{{$totalcount}}";
  var remaining = "{{$remaining}}";
  var ctx = document.getElementById('count-doughnut').getContext('2d');
  var myDoughnutChart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
      labels: ['Remaining', 'Uploaded'],
      datasets: [{
        label: 'Test',
        backgroundColor: [' #00C1D4', '#2E5BFF'],
        hoverBackgroundColor: [' #00C1D4', '#2E5BFF'],
        borderColor: 'rgba(255, 99, 132,0)',
        data: [remaining, uploaded]
      }]
    },

    // Configuration options go here
    options: {
      cutoutPercentage: 70,
      legend: {
        display: false,
        // position: 'left',
        // fontSize: 14,
      },
    }
  });

  function checkdemo(remaining, totalcount) {
    var uploaded = totalcount;
    var remaining = remaining;
    var ctx = document.getElementById('count-doughnut').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'doughnut',

      // The data for our dataset
      data: {
        labels: ['Remaining', 'Uploaded'],
        datasets: [{
          label: 'Test',
          backgroundColor: [' #00C1D4', '#2E5BFF'],
          hoverBackgroundColor: [' #00C1D4', '#2E5BFF'],
          borderColor: 'rgba(255, 99, 132,0)',
          data: [remaining, uploaded]
        }]
      },

      // Configuration options go here
      options: {
        cutoutPercentage: 70,
        legend: {
          display: false,
          // position: 'left',
          // fontSize: 14,
        },
      }
    });
  }
</script>
<script>
  $(document).ready(function() {
    $('.knob').trigger('configure', {
      max: 100,
      thickness: 0.1,
      fgColor: '#2CC2A5',
      width: 50,
      height: 50
    });

    $(document).on('click', '.filter-icon-show', function() {
      $(".filter-icon + .common-section").addClass('show-block');
      $(".filter-icon").removeClass('filter-icon-show').addClass('filter-icon-close');
    });
    $(document).on('click', '.filter-icon-close', function() {
      $(".filter-icon + .common-section").removeClass('show-block');
      $(".filter-icon").removeClass('filter-icon-close').addClass('filter-icon-show');
    });

    $(function() {
      var output = document.querySelectorAll('output')[0];

      $(document).on('input', 'input[type="range"]', function(e) {

        document.querySelector('output.' + this.id).innerHTML = e.target.value;
      });

      $('input[type=range]').rangeslider({
        polyfill: false
      });
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

  });
</script>

<script type="text/javascript">
  $("#profile_list").on("click", ".add-resource", function(e) {
    e.preventDefault();
    let href = $(this).attr("data");
    let id = $(this).attr("data-id");

    $.ajax({
      url: href,
      type: 'post',
      success: function(data) {
        if (data.success) {
          $("#revert_" + id).removeClass('add-resource');
          $("#revert_" + id).removeAttr('data');
          $("#revert_" + id).addClass('remove-resource');
          $("#revert_" + id).attr('data', "{{url('/profile/removefromjob')}}/" + id);
          $(".resumeli_" + id).addClass('organization-hold');
          //swal("Alert", 'The profile has been added to selection', "success");
          $(".totresume").html(data.totalcount + '/' + "{{$organization->max_resume_count}}");
          $(".resumecount").html(data.resumecount);
          checkdemo(data.remaining, data.totalcount);
        } else {
          swal("Alert", 'Maximum resume count exceed', "error");
        }
      },
      statusCode: {
        401: function() {
          window.location.href = '/'; //or what ever is your login URI
        },
        419: function() {
          window.location.href = '/'; //or what ever is your login URI
        }
      },
      error: function(res) {
        swal("Alert", 'Some error occured! Please try after some time', "error");
      }
    });

  });
</script>
<style>
  #app {
    background: #2e5bff !important;
    color: #fff !important;
    padding: 6px 30px;
    border-radius: 4px;
    text-transform: capitalize;
    font-size: 13px;
    letter-spacing: 0.5px;
    font-weight: 600;
    min-width: 150px;
    width: auto;
    margin: 10px auto;
  }
</style>
<script type="text/javascript">
  $("#profile_list").on("click", ".remove-resource", function(e) {
    e.preventDefault();
    let href = $(this).attr("data");
    let id = $(this).attr("data-id");

    $.ajax({
      url: href,
      type: 'post',
      success: function(data) {

        $("#revert_" + id).removeClass('remove-resource');
        $("#revert_" + id).removeAttr('data');
        $("#revert_" + id).addClass('add-resource');
        $("#revert_" + id).attr('data', "{{url('/profile/addtojob')}}/" + id);
        $(".resumeli_" + id).removeClass('organization-hold');
        //swal("Alert", 'The profile has been removed from selection', "success");
        $(".totresume").html(data.totalcount + '/' + "{{$organization->max_resume_count}}");
        $(".resumecount").html(data.resumecount);
        checkdemo(data.remaining, data.totalcount);
      },
      statusCode: {
        401: function() {
          window.location.href = '/'; //or what ever is your login URI
        },
        419: function() {
          window.location.href = '/'; //or what ever is your login URI
        }
      },
      error: function(res) {
        swal("Alert", 'Some error occured! Please try after some time', "error");
      }
    });

  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $(".leaveclass").change(function() {
      getsortedcandidates();
    });


    //autocomplete

    var split = function(val) {
      return val.split(",");
    };

    var extractLast = function(term) {
      return split(term).pop();
    };

    $("#skillset").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "{{url('/skill/autocomplete')}}",
          data: {
            term: extractLast(request.term)
          },
          dataType: "json",
          success: function(data) {
            var resp = $.map(data, function(obj) {
              //alert(obj.name);
              return obj.name;
            });

            response(resp);
          }
        });
      },
      select: function(event, ui) {
        var terms = split(this.value);
        terms.pop();
        terms.push(ui.item.value);
        terms.push("");
        this.value = terms.join(",");
        getsortedcandidates();
        return false;
      },
      minLength: 2
    });

    $("#companylist").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "{{url('/company/autocomplete')}}",
          data: {
            term: extractLast(request.term)
          },
          dataType: "json",
          success: function(data) {
            var resp = $.map(data, function(obj) {
              //alert(obj.name);
              return obj.name;
            });

            response(resp);
          }
        });
      },
      select: function(event, ui) {
        var terms = split(this.value);
        terms.pop();
        terms.push(ui.item.value);
        terms.push("");
        this.value = terms.join(",");
        getsortedcandidates();
        return false;
      },
      minLength: 2
    });

    //autocomplete

  });

  function resetmyform() {
    //$("#searchcandidates")[0].reset();
    window.location.href = "{{url('/jobs/create')}}";
  }

  function resetform() {
        //$("#searchcandidates")[0].reset();
        window.location.href = "{{ url('/resetform/pickprofile') }}"
    }

  // function pickprofile() {

  //   var slider = document.getElementById('slider-range');
  //   var expminmax = slider.noUiSlider.get();
  //    daterange = $("#searchdate").val();

  //   $(".pagination").hide();
  //   $("#profile_list").html('Loading...');
  //   $("#mypreload").show();
  //   $.ajax({
  //     url: "{{url('/pickprofile')}}",
  //     type: 'post',
  //     data: {
  //       'frm': $("#searchcandidates").serialize(),
  //       'exp': expminmax,
  //       'daterange': daterange
  //     },
  //     success: function(data) {
  //       $("#mypreload").hide();
  //       $("#profile_list").html(data.resumelist);
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
  //       //window.location.reload();
  //     }
  //   });
  // }


  function getsortedcandidates() {

    var slider = document.getElementById('slider-range');
    var expminmax = slider.noUiSlider.get();
    daterange = $("#searchdate").val();

    $(".pagination").hide();
    $("#profile_list").html('Loading...');
    $("#mypreload").show();
    $.ajax({
      url: "{{url('/candidatesearch')}}",
      type: 'post',
      data: {
        'frm': $("#searchcandidates").serialize(),
        'exp': expminmax,
        // 'daterange': daterange
      },
      success: function(data) {
        $("#mypreload").hide();
        $("#profile_list").html(data.resumelist);
      },
      statusCode: {
        401: function() {
          window.location.href = '/'; //or what ever is your login URI
        },
        419: function() {
          window.location.href = '/'; //or what ever is your login URI
        }
      },
      error: function(res) {
        swal("Alert", 'Some error occured! Please try after some time', "error");
        //window.location.reload();
      }
    });
  }
</script>

@endpush


<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <!-- Revenue, Hit Rate & Deals -->
      <div class="row resp-view">
        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
          <div class="common-section">
            <div class="modal-profilelist i-profilelist">
              <div id="profile_list">

                @if(!$candidates->isEmpty())
                @foreach($candidates as $ck)
                <a href="{{ url('profile/' . $ck->cuid) }}">
                  <div class=" @if($ck->holdstat) organization-hold @endif modal-profileblock filecount resumeli resumeli_{{$ck->id}}">
                    <div>
                      <div class="avatar-image">
                        <span>
                          @if($ck->photo == '' && ($ck->sex =='' || $ck->sex =='None'))
                          <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                          @elseif($ck->photo == '' && $ck->sex =='Male')
                          <img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
                          @elseif($ck->photo == '' && $ck->sex =='Female')
                          <img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">
                          @else
                          <img class="rounded-circle" src="{{ asset('storage/' . $ck->photo) }}">
                          @endif
                        </span>
                      </div>
                    </div>
                    <div>
                      <p>{{$ck->name}}</p>
                      <p></p>
                      <p><span>Experience:</span> <span>{{$ck->experience}} yrs</span></p>
                      <p>{{ \Carbon\Carbon::parse($ck->created_at)->format('d-M-Y') }}</p>
                    </div>
                    @php
								$skill = App\Candidate_Skill::where('candidate_id', $ck->id)

								->pluck('skillname')->toArray();
								@endphp
                                    <div>
                                    @if (!empty($skills))
                                        <?php $maxc = 1; ?>
                                        @foreach ($skill as $mk)
                                        <?php if ($maxc < 6) { ?>
                                            <span>{{ ucwords($mk) }}</span>
                                        <?php } ?>
                                        <?php $maxc++; ?>
                                        @endforeach
                                        @else
                                        <span>No skills</span>
                                        @endif

                                    </div>
                    <div>
                      <p></p>
                    </div>
                    <div>
                      <p></p>
                      <p></p>
                    </div>
                    <div id="revert_{{$ck->id}}" @if(!$ck->holdstat) class="add-resource" data="{{url('/profile/addtojob/'.$ck->id)}}" @else class="remove-resource" data="{{url('/profile/removefromjob/'.$ck->id)}}" @endif data-id="{{$ck->id}}">
                      <img data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to job" src="assets/images/icons/p-add-icon.png">
                    </div>
                  </div>
                </a>
                @endforeach

                @else

                <p class="alert alert-warning text-center">No matching profile</p>

                @endif



              </div>
              {{ $candidates->links() }}
            </div>
          </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
          <p class="filter-icon filter-icon-show"><i class="ft-filter"></i> Filter</p>
          <div class="common-section">
            <button type="button" class="btn btn-primary btn-float btn-newprev" data-toggle="tooltip" title="Go to Fitment Analysis"><a class="fitment-link" href="{{url('/jobs/create')}}"><i class="ft-arrow-left" aria-hidden="true"></i></a></button>
            <div class="filter-countblock">
              <div>
                <div>
                  <div class="filter-chart">
                    <canvas id="count-doughnut"></canvas>
                    <p class="totresume">{{$totalcount}}/{{$organization->max_resume_count}}</p>
                  </div>
                  <p>Total Resumes Selected</p>
                </div>
                <div>
                  <span class=".resumecount">{{$resumecount}}</span>
                  <p>Total Resumes Uploaded</p>
                </div>
              </div>
            </div>
            <form method="post" id="searchcandidates" class="filter-form">
              <div class="card  filter-section ">
                <div class="card-content">
                  <div class="section">
                    <label class="control-label">Experience (Years)</label>

                    <div id="slider-range"></div>
                    <div class="row slider-labels">
                      <div class="col-md-6 caption">
                        <span id="expfirst" name="expfirst">0</span>
                      </div>
                      <div class="col-md-6 text-right caption">
                        <span id="expsecond" name="expsecond">0</span>
                      </div>
                    </div>
                  </div>
                  <div class="section">
                    <label class="control-label">Skill</label>
                    <input type="text" id="skillset"<?php if($filter){?> value="{{$filter->skills}}"<?php }?>  name="skill" class="form-control">
                  </div>
                  <div class="section">
                    <label class="control-label">Company</label>
                    <input type="text" name="company"  id="companylist" class="form-control" <?php if($filter){?> value="{{$filter->company}}"<?php }?> >
                  </div>
                
                  <div class="section">
                    <button type="button" onclick="getsortedcandidates()" class="btn btn-primary btnapply" id="app">Apply</button>
                  </div>
            </form>
            <div class="section">
										<!-- <button type="submit" class="btn btn-primary btn-color">Apply</button> -->
										<button type="button" onclick="resetform()" class="btn btn-primary"><img src="{{url('/')}}/assets/images/icons/reset.png"> Reset</button>
									</div>
            <div class="section">
              <button type="button" onclick="resetmyform()" class="btn btn-primary btn-color">Add</button>
            </div>

          </div>
        </div>




      </div>
    </div>
  </div>
  <!--/ Revenue, Hit Rate & Deals -->

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