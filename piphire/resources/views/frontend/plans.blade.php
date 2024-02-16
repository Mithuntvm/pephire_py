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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
  .tabbable-panel {
    border: 1px solid #eee;
    padding: 10px;
  }

  .tabbable-line>.nav-tabs {
    border: none;
    margin: 0px;
  }

  .tabbable-line>.nav-tabs>li {
    margin-right: 2px;
  }

  .tabbable-line>.nav-tabs>li>a {
    border: 0;
    margin-right: 0;
    color: #737373;
  }

  .tabbable-line>.nav-tabs>li>a>i {
    color: #a6a6a6;
  }

  .tabbable-line>.nav-tabs>li.open,
  .tabbable-line>.nav-tabs>li:hover {
    border-bottom: 4px solid rgb(80, 144, 247);
  }

  .tabbable-line>.nav-tabs>li.open>a,
  .tabbable-line>.nav-tabs>li:hover>a {
    border: 0;
    background: none !important;
    color: #333333;
  }

  .tabbable-line>.nav-tabs>li.open>a>i,
  .tabbable-line>.nav-tabs>li:hover>a>i {
    color: #a6a6a6;
  }

  .tabbable-line>.nav-tabs>li.open .dropdown-menu,
  .tabbable-line>.nav-tabs>li:hover .dropdown-menu {
    margin-top: 0px;
  }

  .tabbable-line>.nav-tabs>li.active {
    border-bottom: 4px solid #32465B;
    position: relative;
  }

  .tabbable-line>.nav-tabs>li.active>a {
    border: 0;
    color: #333333;
  }

  .tabbable-line>.nav-tabs>li.active>a>i {
    color: #404040;
  }

  .tabbable-line>.tab-content {
    margin-top: -3px;
    background-color: #fff;
    border: 0;
    border-top: 1px solid #eee;
    padding: 15px 0;
  }

  .portlet .tabbable-line>.tab-content {
    padding-bottom: 0;
  }
</style>

<script type="text/javascript">
  function getpayment(puid, type, currentuser, adminuser) {

    var plandetails = "End date : {{date('m/d/Y',strtotime(auth()->user()->organization->plan_end_date))}} | Fitment left : {{auth()->user()->organization->left_search}}";

    if (currentuser == adminuser) {

      swal({
        html: true,
        title: 'You currently have an active plan with the below details. Please review and confirm if you require additional license.',
        text: plandetails,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then(function(isdelete) {

        if (isdelete) {
          if (type == 'old') {
            window.location.href = "{{url('/payment')}}/" + puid;
          } else {
            window.location.href = "{{url('/organization/edit')}}/" + puid;
          }
        }

      });

    } else {
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      $("#notadmin").show();
      setTimeout(function() {
        $("#notadmin").hide();
      }, 8000);

    }

  }

  //setTimeout(function(){ $(".alert-success").hide(); }, 2500);

  function handleCheck(event) {

    var checked = event.target.checked
    var elements = document.getElementsByClassName('upgrade_plan')
    // var element = document.getElementById('upgrade_plan')
    console.log(checked)
    // var element1 = document.getElementById('upgrade_plan_1')
    // var label = document.getElementById('checkboxLabel')
    for (element of elements) {
      if (checked) {
        // label.classList.remove('text-danger')
        // console.log("elelment", element)
        // element1.classList.remove('disabled')
        element.classList.remove('disabled')
      } else {
        // label.classList.add('text-danger')
        // element1.classList.add('disabled')
        element.classList.add('disabled')
      }
    }

  }
</script>

@endpush


<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">

      <div class="alert alert-warning" id="notadmin" style="display: none;">
        <p class="">
          Dear User,<br />
          Please reach out to your Enterprise Plan Admin {{$adminuser->name}} for assistance in upgrading plans if required.
        </p>
      </div>

      @if (session('status'))
      <div class="alert alert-success text-center" role="alert">
        {{ session('status') }}
      </div>
      @endif

      <div style="margin-bottom: 20px; font-size: 17px;">
        <input onchange="handleCheck(event)" type="checkbox" class="form-check-input" name="tc" id="tc" value="agreed"> <label id="checkboxLabel" class="form-check-label text-primary " for="tc"> &nbsp I
          agree to the following as part of the purchasing plan from pephire: <span class=" d-block d-md-inline-block"><a target="_blank" class="text-bold-800 grey darken-2" href="{{ url('/') }}/privacy-policy"> Privacy Policy</a> , <a target="_blank" class="text-bold-800 grey darken-2" href="{{ url('/') }}/terms-and-conditions"> Terms &
              Conditions </a> <span class="text-primary">&</span> <a target="_blank" class="text-bold-800 grey darken-2" href="{{ url('/') }}/return-and-refund">Return and
              Refund</a> </span>
        </label>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-12">


            <div class="tabbable-panel">
              <div class="tabbable-line">
                <?php $cnts = 1; ?>
                <ul class="nav nav-tabs" id="myDIV">
                  @if (!empty($plans))
                  @foreach ($plans as $ck)
                 
                  <li class="btn  @if($cnts == 1) active @endif ">
                  <a  data-toggle="collapse" data-parent="#bs-collapse" href="#plans-tab_{{$ck->id}}">
                      <span>
                        <h3>{{$ck->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                      </span>
                      </a>

                  </li>
                 
                  <?php $cnts++; ?>
                  @endforeach
                  @endif
                </ul>



              </div>

            </div>
          </div>
        </div>
        <script>
          // Add active class to the current button (highlight it)
          // var header = document.getElementById("myDIV");
          // var btns = header.getElementsByClassName("btn");
          // for (var i = 0; i < btns.length; i++) {
          //   btns[i].addEventListener("click", function(e) {
          //     var current = document.getElementsByClassName("active");
          //     // var show = document.getElementsByClassName("show");

          //     current[0].className = current[0].className.replace(" active", "");
             
          //     this.className += " active";
          //     // e.stopPropagation();
          //     // show[0].className = show[0].className.replace(" show", "");
          //     // this.className += " show";

          //   });
          // }
        </script>
        <script>
    let listItems = document.querySelectorAll("li");

    listItems.forEach((item) => {
        item.addEventListener("click", () => {
            listItems.forEach((listItem) => {
                listItem.classList.remove("active");
            });
            item.classList.add("active");
        });
    });
</script>
             
        <div class="panel-group wrap" id="bs-collapse" aria-multiselectable="true">
          <?php $cnts =1 ?>
          @if (!empty($plans))
          @foreach ($plans as $ck)

          <div class="upgrade-plans panel">

            <div id="plans-tab_{{$ck->id}}" class="panel-collapse collapse @if($cnts == 1) show @endif">
              <div class="panel-body">
                <div class="row">

                  @if (!empty($ck->plans))
                  @foreach ($ck->plans as $mk)
                  <div class="col-xl-3 col-12  show " >
                    <div class="card text-white plans-block" style="border-radius: 30px !important;margin-top:19px">
                      <div class="card-content">
                        <h4>{{$mk->name}}</h4>
                        <p class="searches"><span>{{$mk->no_of_searches}}</span><span>Searches</span></p>
                        <p class="price">&#8377;{{number_format($mk->amount)}}</p>
                        <p class="searches"><span>{{$mk->max_users}}</span><span>Users</span></p>
                        <p class="p-details">{{$mk->description}}</p>
                        <!-- <p>Please accept terms and condition to continue </p>  -->
                        @if ($mk->id == 1)
                        <button disabled class="btn btn-primary" id="upgrade_plan_1">Upgrade</button>
                        @else

                        @if (auth()->user()->organization->is_verified)
                        <a href="javascript:void(0);" onclick="getpayment('{{$mk->puid}}','old','{{auth()->user()->id}}','{{$adminuser->id}}')" class="btn btn-primary disabled upgrade_plan" style="border-radius: 30px !important;">Upgrade</a>
                        @else
                        <a href="javascript:void(0);" onclick="getpayment('{{$mk->puid}}','new','{{auth()->user()->id}}','{{$adminuser->id}}')" class="btn btn-primary disabled upgrade_plan" style="border-radius: 30px !important;">Upgrade</a>
                        @endif

                        @endif
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
            </div>
          </div>
          <?php $cnts++ ?>
          @endforeach
          @endif
        </div>

      </div>
    </div>
  </div>
  @section('footer')
@include('partials.frontend.interview')
@endsection
  @endsection



  @section('footer')
  @include('partials.frontend.footer')
  @endsection