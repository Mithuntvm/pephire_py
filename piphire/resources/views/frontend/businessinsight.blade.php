@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row">
         
          <iframe width="1200" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiZGE3NmEyOWEtMzEwMC00NTAxLTllYzMtYTFlMzc2NzI4NzI2IiwidCI6ImYzZWFiZmFlLTYxZjYtNDdiMS1iZTNkLTZjYzU1MjhlODEyOCIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>

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