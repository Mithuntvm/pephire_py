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

  <script>
    var completed = '<?php echo $job_total; ?>';
    var remaining  = '<?php echo $organization->left_search; ?>';
    var ctx = document.getElementById('doughnut').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: ['Remaining Analysis','Completed Analysis'],
            datasets: [{
                label: 'Test',
                backgroundColor: ['#2E5BFF',' #00C1D4'],
                hoverBackgroundColor:['#2E5BFF',' #00C1D4'],
                borderColor: 'rgba(255, 99, 132,0)',
                data: [remaining,completed]
            }]
        },

        // Configuration options go here
        options: {
          cutoutPercentage: 80,
          legend: {
            display: false,
            // position: 'left',
            // fontSize: 14,
          },  
        }
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.knob').trigger('configure', {
          max: 100,
          thickness:0.2,
          fgColor:'#2CC2A5',
          width: 40,
          height: 40
      });

      let dash_height = $('#dashboard-height').height();
      $(".w-20").css({ 'height' : 'calc(' + dash_height +  'px - 30px)'});
      $(".col-xl-2.col-12.w-30").css({ 'height' : 'calc(' + dash_height +  'px - 30px)'});

    });

    function gotoplans(){
      window.location.href = "{{url('/plans')}}";
    }

    function gotocreate(){
      window.location.href = "{{url('jobs/create')}}";
    }
  </script>

@endpush
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body dashboard-row">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row block-row">
          <div class="col-xl-3 col-12 w-20" onclick="gotocreate()">
            <div class="card text-white first-block">
              <div class="card-content">
                <div class="card-img-overlay first-detailblock">
                  <a href="{{url('jobs/create')}}"><img class=" img-fluid" src="assets/images/icons/plus-icon.png" alt="Card image"></a>
                  <p class="card-title text-white">New Profile Matrix</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-12 w-20" onclick="gotoplans()">
            <div class="card text-white f-block">
              <div class="card-content">
                <img class="card-img img-fluid" src="assets/images/d-image.png" alt="Card image">
                <div class="card-img-overlay d-detailblock">
                  {{--
                  <h4 class="card-title text-white">JUN 15 2019</h4>
                  --}}
                  <p class="card-text">Upgrade<br/>Plan</p>
                  <a href="javascript:void(0);">Read More</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-12 w-30" id="dashboard-height">
            <div class="card  d-chart">
              <div class="card-content">
                <div class="d-chartblock">
                  <h4 class="card-title ">Pre Paid</h4>
                  <p class="total-search"><span>{{$organization->total_search}}</span> <br> Analysis Package</p>
                  <div class="chartjs">
                    <canvas id="doughnut"></canvas>
                    <div class="pos-abs1">
                      <p>
                        <span>{{ $organization->left_search }}</span>
                        <span>Analysis</span>
                        <span>Remaining</span>
                      </p>
                    </div>
                  </div>
                  <div class="pos-abs">
                    <span><i class="box"></i> Completed Analysis</span>
                    <span><i class="box"></i> Remaining Analysis</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-12 w-30">
            <div class="card  d-counters ">
              <div class="card-content">
                <div class="d-countblock">
                  <i class="tick-icon"><img src="assets/images/icons/download-icon.png"></i>
                  <h4 class="card-title ">{{$resume_trashed}}</h4>
                  <p class="card-text">Total Profiles Uploaded</p>
                </div>
              </div>
            </div>
            <div class="card  d-counters ">
              <div class="card-content">
                <div class="d-countblock">
                  <i class="tick-icon"><img src="assets/images/icons/active-profiles.png"></i>
                  <h4 class="card-title ">{{$resume_total}}</h4>
                  <p class="card-text">Active Profiles</p>
                </div>
              </div>
            </div>
            <div class="card  d-counters ">
              <div class="card-content">
                <div class="d-countblock">
                  <i class="tick-icon"><img src="assets/images/icons/tick-icon.png"></i>
                  <h4 class="card-title ">{{$job_total}}</h4>
                  <p class="card-text">Fitment Analysis Completed</p>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
        <!--/ Revenue, Hit Rate & Deals -->
        <!-- <div class="free-space"></div> -->
        <!-- Previous profile matrix -->
        <h4 class="titlehead"><span>Previous profile matrix results</span></h4>
        <div class="row">

          @if(!empty($jobs))
          @foreach($jobs as $jk)

          <div class="col-xl-4 col-xs-12">
            <a href="{{url('/job/details/'.$jk->juid)}}">
            <div class="previous-title">
              <p>{{$jk->name}}</p>
              <p>{{ \Carbon\Carbon::parse($jk->created_at)->format('M d Y') }}</p>
            </div>
          </a>
            <div class="top-candidate">
              <div>
                <p>Top candidate</p>
                <span></span>
              </div>
              <div class="candidate-detail">

                @if(!empty($jk->candidates))
                <?php $cnt = 1; ?>
                @foreach($jk->candidates as $dk)
                <div>
                  <a href="{{ url('profile/' . $dk->cuid) }}">
                  <span>

                  @if($dk->photo == '' && ($dk->sex =='' || $dk->sex =='None'))
                  <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                  @elseif($dk->photo == '' && $dk->sex =='Male')
                  <img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
                  @elseif($dk->photo == '' && $dk->sex =='Female')
                  <img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">                  
                  @else
                  <img class="rounded-circle" src="{{ asset('storage/' . $dk->photo) }}">
                  @endif

                  <i>{{$cnt}}</i></span>
                  <span><p>{{$dk->name}}</p> <p></p></span>
                  <span><p></p> <input type="text" value="{{$dk->pivot->score}}" class="knob basic-dial" readonly></span>
                  </a>
                </div>
                <?php $cnt++; ?>
                @endforeach
                @endif

              </div>
            </div>
          </div>
          @endforeach
          @endif

        </div>
        <div class="free-space"></div>
        
        
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