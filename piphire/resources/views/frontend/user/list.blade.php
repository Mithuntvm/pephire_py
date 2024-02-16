@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection


<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/font-awesome.css">
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

<script src="{{ url('/') }}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">

        $(document).ready(function(){

            $('#plans').DataTable({
                ajax: {
                    url: "{{ action('UserController@dataTable') }}",
                    type: "POST",
                    data: {
                        _token:  $('meta[name="csrf-token"]').attr('content')
                    }
                },
                pageLength: 20,
                processing: true,
                columns: [
                    { data: "name", width: '25%' },
                    { data: "email", width: '20%' },
                    { data: "phone", width: '20%' },
                    {
                        data: "actions",
                        orderable: false,
                        width: '35%',
                        render: function (data, type, row ) {

                           var myvar = '';
                           var myadmin = '';
                          if(data.activationlink){
                            myvar = '<a data-toggle="tooltip" data-placement="top" title="Invite" href="' + data.activationlink + '" class="btn btn-flat btn-warning notify-resource">' +
                      '<span class="fa fa-paper-plane"></span>&nbsp;</a>&nbsp;'
                          }
                          if(data.adminlink){
                            myadmin = '<a data-toggle="tooltip" data-placement="top" title="Make Admin" href="' + data.adminlink + '" class="btn btn-flat btn-warning make-admin">' +
                      '<span class="fa fa-user-o"></span>&nbsp;</a>&nbsp;'
                          }                          

                          return '<a data-toggle="tooltip" data-placement="top" title="Edit" href="' + data.edit_link + '" class="btn btn-flat btn-warning">' +
                      '<span class="fa fa-pencil"></span>&nbsp;</a>&nbsp;' +myvar+myadmin+
                      '<a data-toggle="tooltip" data-placement="top" title="'+data.custom_title+'" href="' + data.custom_link + '" class="btn btn-flat '+data.custom_class+'">' +
                      '<span class="fa '+data.custom_icon+'"></span>&nbsp;</a>';
                        }
                    },
                ],
                "bDestroy": true
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".table").on("click", ".del-resource", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");
                $.ajax({
                    url: href,
                    type: 'post',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (res) {
                        alert('Some error occured! Please try after some time');
                    }
                });

/*                let response = confirm("Are you sure?");
                if (response) {
                    $.ajax({
                        url: href,
                        type: 'post',
                        success: function (data) {
                            location.reload();
                        },
                        error: function (res) {
                            alert('Some error occured! Please try after some time');
                        }
                    });
                }*/
            });

            $(".table").on("click", ".act-resource", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");
                $.ajax({
                    url: href,
                    type: 'POST',
                    success: function (data) {
                        if(data.error){
                          $("#myerror").show();
                          setTimeout(function(){ $("#myerror").hide(); }, 5000);
                        }else{
                          location.reload();
                        }
                        
                    },
                    error: function (res) {
                        alert('Some error occured! Please try after some time.');
                    }
                });                
/*                let response = confirm("Are you sure?");
                if (response) {
                    $.ajax({
                        url: href,
                        type: 'POST',
                        success: function (data) {
                            location.reload();
                        },
                        error: function (res) {
                            alert('Some error occured! Please try after some time. Check the maximum user count');
                        }
                    });
                }*/
            });


            $(".table").on("click", ".notify-resource", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");
                $.ajax({
                    url: href,
                    type: 'post',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (res) {
                        alert('Some error occured! Please try after some time');
                    }
                });                
/*                let response = confirm("Are you sure?");
                if (response) {
                    $.ajax({
                        url: href,
                        type: 'post',
                        success: function (data) {
                            location.reload();
                        },
                        error: function (res) {
                            alert('Some error occured! Please try after some time');
                        }
                    });
                }*/
            });


            $(".table").on("click", ".make-admin", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");
                let response = confirm("Are you sure? After success you will be redirected to dashboard.");
                if (response) {
                    $.ajax({
                        url: href,
                        type: 'post',
                        success: function (data) {
                            window.location.href = "{{url('/dashboard')}}";
                        },
                        error: function (res) {
                            alert('Some error occured! Please try after some time');
                        }
                    });
                }
            });


        });

  setTimeout(function(){ $("#alert_message").hide(); }, 2500);

</script>

@endpush

  <div class="app-content content">
    <div class="content-wrapper">

    @if(session()->has('success'))  
      <div class="col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>   
    @endif

    @if(session()->has('warning'))  
      <div class="col-12 alert alert-danger text-center mt-1" id="alert_message">{{ session()->get('warning') }}</div>   
    @endif
  
      <div class="col-12 alert alert-info text-center mt-1" style="display: none;" id="myerror">
        Maximum user count exceeded
      </div>   

      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Users</h3>
          <div class="row breadcrumbs-top d-inline-block">
            Max No of users : {{auth()->user()->organization->max_users}}
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="float-md-right">
            <div class="form-group">
              <!-- basic buttons -->
              <a href="{{url('/user/create')}}" class="btn btn-success">Create</a>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">

        <!-- File export table -->
        <section id="file-export">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                    <p class="card-text"></p>
                    <table id="plans" class="table table-striped table-bordered file-export">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Options</th>
                        </tr>
                      </thead>

                      <tbody></tbody>

                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Options</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- File export table -->
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

<style type="text/css">
  .alert-warning {
    display: table-row !important;
  }
</style> 


