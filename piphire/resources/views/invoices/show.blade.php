@extends('layouts.app')

@section('header')
    @include('partials.frontend.header')
@endsection

@push('styles')
<style>
@media screen {
    #logoContainer {
        display: none;
    }
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
<script>
$(document).ready(function() {
    $("#printBtn").on('click', function (e) {
        e.preventDefault();
        var printContents = document.getElementById('invoiceDetails').outerHTML;
        var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding:0.5em;' +
        '}table{width: 100%;border-collapse: collapse;}' +
        '</style>';

        w=window.open();
        w.document.write(htmlToPrint);
        w.document.write(printContents);
        w.document.close();
        w.focus();
        w.print();
        w.close();
    });
});
</script>
@endpush

@section('content')
    @section('sidebar')
        @include('partials.frontend.sidebar')
    @endsection

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <table class="table table-bordered" id="invoiceDetails">
                    <thead>
                        <tr id="logoContainer">
                            <th colspan="2">
                                <img class="brand-logo" alt="modern admin logo" src="{{ asset('assets/images/logo/logo.png') }}">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Payment Id</td>
                            <td>{{ $invoice->razorpay_payment_id }}</td>
                        </tr>
                        <tr>
                            <td>Plan Type</td>
                            <td>{{ $invoice->plantype->name }}</td>
                        </tr>
                        <tr>
                            <td>Plan</td>
                            <td>{{ $invoice->plan->name }}</td>
                        </tr>                                                
                        <tr>
                            <td>Status</td>
                            <td>
                                @if($invoice->status == 'captured')
                                    Successful
                                @else
                                    Failed
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{ $invoice->payment_method }}</td>
                        </tr>
                        <tr>
                            <td>Payment Description</td>
                            <td>{{ $invoice->payment_description }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $invoice->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Customer Email</td>
                            <td>{{ $invoice->email }}</td>
                        </tr>
                        <tr>
                            <td>Customer Contact</td>
                            <td>{{ $invoice->contact }}</td>
                        </tr>
                        {{--
                        <tr>
                            <td>Fee</td>
                            <td>{{ $invoice->fee }}</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>{{ $invoice->tax }}</td>
                        </tr>
                        --}}
                        <tr>
                            <td>Amount</td>
                            <td>&#8377;{{ $invoice->amount }}</td>
                        </tr>
                        <tr>
                            <td>Order ID</td>
                            <td>{{ $invoice->razorpay_order_id }}</td>
                        </tr>
                    </tbody>
                </table>

                      <div class="form-actions">
                        <a href="javascript:void(0);" onclick="window.history.back()" type="button" class="btn btn-warning mr-1">
                          <i class="ft-x"></i> Cancel
                        </a>
                        <a href="javascript:void(0);" id="printBtn" type="button" class="btn btn-success mr-1">
                          <i class="ft-x"></i> Print
                        </a>                        
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