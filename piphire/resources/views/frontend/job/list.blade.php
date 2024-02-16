@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/vendors/css/tables/datatable/datatables.min.css">
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
<script src="{{url('/')}}/assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/tables/datatables/datatable-advanced.js"
  type="text/javascript"></script>
<script type="text/javascript">

        $(document).ready(function(){

            $('#jobs').DataTable({
                ajax: {
                    url: "{{ action('JobController@dataTable') }}",
                    type: "POST",
                    data: {
                        _token:  $('meta[name="csrf-token"]').attr('content')
                    }
                },
                pageLength: 20,
                processing: true,
                columns: [
                    { data: "name", width: '30%' },
                    { data: "description", width: '40%' },
                    {
                        data: "actions",
                        orderable: false,
                        width: '30%',
                        render: function (data, type, row ) {
                          return '<a href="' + data.view_link + '" class="btn btn-flat btn-warning">' +
                      '<span class="fa fa-pencil"></span>&nbsp;<span>View</span></a>&nbsp;';
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

                swal({
                title: 'Are you sure?',
                text: "",
                buttons: true,
                dangerMode: true,
                }).then(function(isdelete) {

                  if(isdelete){
                    $.ajax({
                        url: href,
                        type: 'post',
                        success: function (data) {
                            location.reload();
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
                            alert('Some error occured! Please try after some time');
                        }
                    });
                  }

                });

            });

            $(".table").on("click", ".act-resource", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");

                swal({
                title: 'Are you sure?',
                text: "",
                buttons: true,
                dangerMode: true,
                }).then(function(isdelete) {

                  if(isdelete){
                    $.ajax({
                        url: href,
                        type: 'POST',
                        success: function (data) {
                            location.reload();
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
                            alert('Some error occured! Please try after some time');
                        }
                    });
                  }

                });

            });


        });

  setTimeout(function(){ $(".alert-success").hide(); }, 2500);
  setTimeout(function(){ $(".alert-warning").hide(); }, 2500);

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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">My Jobs</h3>
          <div class="row breadcrumbs-top d-inline-block">
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="float-md-right">
            <div class="form-group">
              <!-- basic buttons -->
              <a href="{{url('jobs/create')}}" class="btn btn-success">Create</a>
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
                    <table id="jobs" class="table table-striped table-bordered file-export">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Description</th>
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