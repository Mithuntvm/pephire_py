@extends('layouts.backend')

@section('header')
  @include('partials.backend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.backend.sidebar')
@endsection

<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/font-awesome.css">
@push('scripts')
<script type="text/javascript">

        $(document).ready(function(){

            $('#organizations').DataTable({
                ajax: {
                    url: "{{ action('Admin\AdminJobController@dataTable',['uuid'=>$userdets->uuid]) }}",
                    type: "POST",
                    data: {
                        _token:  $('meta[name="csrf-token"]').attr('content')
                    }
                },
                pageLength: 20,
                processing: true,
                columns: [
                    { data: "name", width: '25%' },
                    { data: "short_desc", width: '50%' },
                    {
                        data: "actions",
                        orderable: false,
                        width: '25%',
                        render: function (data, type, row ) {
                          return '<a data-toggle="tooltip" data-placement="top" title="Edit" href="' + data.edit_link + '" class="btn btn-flat btn-warning">' +
                      '<span class="fa fa-pencil"></span>&nbsp;</a>&nbsp;'+
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
                let response = confirm("Are you sure?");
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
                }
            });

            $(".table").on("click", ".act-resource", function (e) {
                e.preventDefault();
                let href = $(this).attr("href");
                let response = confirm("Are you sure?");
                if (response) {
                    $.ajax({
                        url: href,
                        type: 'POST',
                        success: function (data) {
                            location.reload();
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

      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Organizations</h3>
          <div class="row breadcrumbs-top d-inline-block">
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="float-md-right">
            <div class="form-group">
              <!-- basic buttons -->
              <a href="{{url('/backend/organization/jobs/'.$userdets->uuid.'/create')}}" class="btn btn-success">Create</a>
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
                    <table id="organizations" class="table table-striped table-bordered file-export">
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

@endsection

@section('footer')
  @include('partials.backend.footer')
@endsection