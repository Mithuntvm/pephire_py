@extends('layouts.backend')

@section('header')
  @include('partials.backend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.backend.sidebar')
@endsection

@push('scripts')

@endpush


<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">

      </div>
      <div class="content-body">
        <!-- Borders -->
        <section id="borders" class="card">
          <div class="card-header">
          <div class="float-md-left">
            <h4 class="card-title">{{$organization->name}} : Event Log</h4>
          </div>  
          <div class="float-md-right">
            <div class="form-group">
              <!-- basic buttons -->
              <a href="javascript:void(0);" onclick="window.history.back()" class="btn btn-primary">Back</a>
            </div>
          </div>

          </div>

          <div class="card-content collapse show" style="">
            <!--Add borders-->

            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>

                  @if($history)
                    @foreach($history as $ck => $cv)
                      <tr>
                        <td>{{$cv->event_details}}</td>
                      </tr>
                    @endforeach
                  @endif  

                </tbody>
              </table>
            </div>
            <!--/Add borders-->

          </div>
        </section>
        <!--/ Borders-->


      </div>
    </div>
  </div>


@endsection

@section('footer')
  @include('partials.backend.footer')
@endsection  