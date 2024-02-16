@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{url('/')}}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
  $(document).ready(function() {
    $('.knob').trigger('configure', {
      max: 100,
      thickness: 0.1,
      fgColor: '#2CC2A5',
      width: 50,
      height: 50
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
  $("#profile_list").on("click", ".del-resource", function(e) {
    e.preventDefault();
    let href = $(this).attr("data");
    let id = $(this).attr("data-id");

    swal({
      title: 'Are you sure?',
      text: "",
      buttons: true,
      dangerMode: true,
    }).then(function(isdelete) {

      if (isdelete) {
        $.ajax({
          url: href,
          type: 'post',
          success: function(data) {
            $(".resumeli_" + id).remove();
            if ($(".filecount").length < 1) {
              $("#profile_list").html('<p class="alert alert-warning text-center">No document selected</p>');
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
        $("#revert_" + id).removeClass('add-resource');
        $("#revert_" + id).removeAttr('data');
        $("#revert_" + id).addClass('remove-resource');
        $("#revert_" + id).attr('data', "{{url('/profile/removefromjob')}}/" + id);
        $(".resumeli_" + id).addClass('organization-hold');
        swal("Alert", 'The profile has been added to selection', "success");
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

    /*          swal({
              title: 'Are you sure?',
              text: "",
              buttons: true,
              dangerMode: true,
            }).then(function(isdelete) {

              if(isdelete){

              }

            });*/

  });
</script>

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
        swal("Alert", 'The profile has been removed from selection', "success");
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

    /*          swal({
              title: 'Are you sure?',
              text: "",
              buttons: true,
              dangerMode: true,
            }).then(function(isdelete) {

              if(isdelete){

              }

            });*/

  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".leaveclass").change(function() {
      alert(1);
    });
  });
</script>

@endpush


<!-- <div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
      <div class="row">
        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
          <div class="common-section">
            <div class="modal-profilelist i-profilelist"> -->
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
                    </div>
                    <div>

                      @if(!$ck->newskills->isEmpty())
                      <?php $maxc = 1; ?>
                      @foreach($ck->newskills as $mk)
                      <?php if ($maxc < 6) { ?>
                        <span>{{$mk->name}}</span>
                      <?php } ?>
                      <?php $maxc++; ?>
                      @endforeach
                      @else
                      <span>No skills</span>
                      @endif

                    </div>
                    <div>
                      <p>{{ \Carbon\Carbon::parse($ck->created_at)->format('d-M-Y') }}</p>
                    </div>
                    <div>
                      <p></p>
                      <p></p>
                    </div>

                    <!--
                    <div class="del-resource" data="{{url('/profile/delete/'.$ck->id)}}" data-id="{{$ck->id}}">
                      <img data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" src="assets/images/icons/p-delete-icon.png">
                    </div>
                  -->
                    <div id="revert_{{$ck->id}}" @if(!$ck->holdstat) class="add-resource" data="{{url('/profile/addtojob/'.$ck->id)}}" @else class="remove-resource" data="{{url('/profile/removefromjob/'.$ck->id)}}" @endif data-id="{{$ck->id}}">
                      <img data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to job" src="assets/images/icons/p-add-icon.png">
                    </div>
                  </div>
                </a>
                @endforeach

                @else

                <p class="alert alert-warning text-center">No matching profile</p>

                @endif

                {{ $candidates->links() }}

              </div>
            <!-- </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div> -->
<!-- ////////////////////////////////////////////////////////////////////////////-->