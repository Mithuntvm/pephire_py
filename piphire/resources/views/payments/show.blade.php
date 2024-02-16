@extends('layouts.app')

@section('header')
    @include('partials.frontend.header')
    <script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
@endsection

@section('content')
    @section('sidebar')
        @include('partials.frontend.sidebar')
    @endsection

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <form id="mypayment" action="{{ url('/payment/success') }}" method="POST">
            <script
                src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ config('payment.key') }}"
                data-amount="{{ $amount }}"
                data-currency="{{ config('payment.currency') }}"
                data-order_id="{{ $order->id }}"
                data-buttontext="Make Payment"
                data-description="Make Payment"
                data-prefill.name="{{ auth()->user()->name }}"
                data-prefill.email="{{ auth()->user()->email }}"
                data-theme.color="#F37254"
            >                
            </script>
            <input type="hidden" custom="Hidden Element" name="hidden">
            <input type="hidden" name="plan" value="{{ $plan->puid }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            @csrf
            </form>
        </div>
    </div>
</div>

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
<script type="text/javascript">
    $(document).ready(function(){
        $( ".razorpay-payment-button" ).trigger( "click" );
        if($('.razorpay-container:visible').length == 1)
            {   

            }
    });
</script>
@endpush


<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-body">

        <div class="alert alert-warning text-color text-center">Please wait... if you face an error please go to &nbsp;<a href="{{url('/plans')}}">Plans</a> </div>

      </div>
  </div>
</div>

@section('footer')
    @include('partials.frontend.footer')
@endsection 