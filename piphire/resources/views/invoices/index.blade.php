@extends('layouts.app')

@section('header')
    @include('partials.frontend.header')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#invoicesTable').DataTable({
        ajax: {
            url: "{{ route('invoices.list') }}",
            type: "GET",
            data: {
                _token:  $('meta[name="csrf-token"]').attr('content')
            }
        },
        processing: true,
        columns: [
            { data: "plan_name" },
            { data: "amount" },
            { data: "razorpay_payment_id" },
            { data: "razorpay_order_id" },
            { data: "created_at" },
            {
                data: "actions",
                orderable: false,
                render: function (data, type, row ) {
                    return '<a href="' + data.view_link + '" class="btn btn-warning">View</a>';
                }
            },
        ]
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
            <table id="invoicesTable" class="table table-bordered">
                <thead>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Payment Id</th>
                    <th>Order Id</th>
                    <th>Payment Made On</th>
                    <th>Actions</th>
                </thead>
                <tbody></tbody>
            </table>
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