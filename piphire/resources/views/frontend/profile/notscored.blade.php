@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

@push('styles')
  <link href="{{url('/')}}/assets/css/jquery-ui.css" rel="stylesheet"></link>
<!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css" rel="stylesheet"></link> -->
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    .modal-profilelist > div .modal-profileblock > div:nth-child(2) p:last-child {
        color: #8798AD;
        font-size: 11px;
        font-weight: 600;
    }
    .modal-profilelist.i-profilelist > div .modal-profileblock > div:nth-child(4) {
        /*width: 120px;*/
        display: none;
    }
    #progress{
      display: flex;
      flex-wrap: wrap;
    }

    #progress p
    {
      display: inline-block;
      width: 450px !important;
      padding: 15px;
      margin: 10px 5px;
      background: #fff;
      overflow-wrap: break-word;
      word-wrap: break-word;
      box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }

    #progress p.success
    {
      background: #1E9FF2 !important;
      border: none !important;
      color: #fff !important;
       box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }

    #progress p.failed
    {
      background: #fff none 0 0 no-repeat;
      border: none !important;
      color: #324C6C !important;
       box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }
    #process-div > p{
          font-weight: 500 !important;
          letter-spacing: 0.05rem !important;
          font-size: 1.12rem !important;
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{url('/')}}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script>
  <script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#selectallblock").on('change',function(){
        if($(this).is(":checked")){
          $(".profile_check").prop('checked', true);
        }else{
          $(".profile_check").prop('checked', false);
        }
      });

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });


      if($(".filecount").length < 1){
        setTimeout(function(){
          window.location.href = "{{url('/profiledatabase')}}";
        }, 4000);
      }

    });

    function deleteselected(){
      var tot = $('input[name="deleteprofile[]"]:checked').length;
      var i = 0;
      if(tot){
        $("#mydelete").show();
        $('input[name="deleteprofile[]"]:checked').each(function(){
          i++;

          $.ajax({
              url: $(this).attr('data'),
              type: 'post',
              success: function (data) {

              if(tot == i){
                window.location.reload();
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
              error: function (res) {
                  swal("Alert", 'Some error occured! Please try after some time', "error");
              }
          });

        });


      }else{
        swal("Alert", 'No resume selected', "error");
      }
    }

  </script>

@endpush

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row resp-view hide-up">
          <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
            @if(!$candidates->isEmpty())
              <h4> Pending Resumes </h4>
            @endif
            <div class="common-section">
              <div class="modal-profilelist i-profilelist">

                @if(!$candidates->isEmpty())
                  <div class="title-section">
                    <!-- <h4 class="titlehead">
                      <span>
                        <input id="selectallblock" type="checkbox" name="selectall">
                        <label for="selectallblock"><span>Select All</span></label>
                      </span>
                      <span><a href="javascript:void(0);" onclick="deleteselected()">Delete</a></span>
                    </h4> -->
                  </div>
                @endif

                <div id="profile_list">

            @if(!$candidates->isEmpty())
              @foreach($candidates as $ck)
                  <a id="revert_{{$ck->id}}" href="{{ url('profile/' . $ck->cuid) }}">
                  <div class="profile-list-db modal-profileblock filecount resumeli resumeli_{{$ck->id}}">
                    <div>
                      <div class="avatar-image">
                        <span>
                          <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                        </span>
                      </div>
                    </div>
                    <div>
                      <p>{{$ck->delresume->name}}</p>
                      <p></p>
                      <p></p>
                      <p>{{ \Carbon\Carbon::parse($ck->created_at)->format('d-M-Y') }}</p>
                    </div>
                    <div>
                    <span>No skills</span>
                    </div>
                    <div>
                      <p></p>
                    </div>
                    <div>
                      <p></p>
                      <p></p>
                    </div>

                    <!-- <div class="checkbox-block">
                      <input class="profile_check" data="{{url('/resume/delete/'.$ck->delresume->id)}}" id="checkblock_{{$ck->id}}" type="checkbox" name="deleteprofile[]" value="{{$ck->id}}">
                      <label for="checkblock_{{$ck->id}}"></label>
                    </div> -->

                  </div>
                </a>
                @endforeach

                <div class="text-left">
                    <!-- Hide Attribute again button after 2nd attempt -->
                    @if(! $retry)
                      <a href="{{url('/attributiondocs/retry')}}" class="btn btn-primary btn-atrribute">Attribute again</a>
                    @endif

                </div>

              @endif

              @if($candidates->isEmpty() && $deletecandidates->isEmpty())
                <p class="alert alert-warning text-center">Attribution was successfull and no resumes to take action. We will redirect you to profile database.</p>
              @endif

            @if(!$deletecandidates->isEmpty())

            <p class="alert alert-warning text-center">
              Basic data could not be collected from the profiles below which has been deleted
            </p>

              @foreach($deletecandidates as $mk)
                  <!-- <a id="revert_{{$mk->id}}" href="javascript:void(0);"> -->
                  <div class="profile-list-db modal-profileblock filecount resumeli resumeli_{{$mk->id}}">
                    <div>
                      <div class="avatar-image">
                        <span>
                          <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                        </span>
                      </div>
                    </div>
                    <div>
                      <p>{{$mk->delresume->name}}</p>
                      <p></p>
                      <p></p>
                      <p>{{ \Carbon\Carbon::parse($mk->created_at)->format('d-M-Y') }}</p>
                    </div>
                    <div>
                    <span>No skills</span>
                    </div>
                    <div>
                      <p></p>
                    </div>
                    <div>
                      <p></p>
                      <p></p>
                    </div>
                  </div>
                <!-- </a> -->
                @endforeach
              @endif

              <div class="text-left">
                <a href="{{url('/profiledatabase')}}" class="btn btn-primary btn-atrribute">Back to Profile Database</a>
              </div>

                </div>
              </div>
            </div>
          </div>

      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->


    <style type="text/css">
    #mydelete {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        /*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
        opacity: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.95)
    }
    #mydelete .nb-spinner {
      width: 75px;
      height: 75px;
      margin: 0;
      background: transparent;
      border-top: 4px solid #2E5BFF;
      border-right: 4px solid transparent;
      border-radius: 50%;
      -webkit-animation: 1s spin linear infinite;
      animation: 1s spin linear infinite;
      position: relative;
      z-index: 999;
    }
    #mydelete  span{
      position:relative;
      top:-20px;
      color:#000;
      font-size: 24px;
      z-index: 99;
    }
    </style>

    <div id="mydelete" style="display: none;">
      <span style="">Deleting resumes</span>
      <div class="nb-spinner"></div>
    </div>
    @section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
  @include('partials.frontend.footer')
@endsection
