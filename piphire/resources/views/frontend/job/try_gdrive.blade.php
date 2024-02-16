@extends('layouts.app')

@section('header')
    @include('partials.frontend.header')
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

    <style>
        #send {
            background: #2e5bff !important;
            color: #fff !important;
            padding: 6px 30px;
            border-radius: 4px;
            text-transform: capitalize;
            font-size: 13px;
            letter-spacing: 0.5px;
            font-weight: 600;
            min-width: 150px;
            width: auto;
            margin: 10px auto;
            margin-left: 25px;
        }
    </style>

    <style>
        .alert-box {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
            display: none;
        }

        .failure {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            display: none;
        }

        .loader {
            position: fixed;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.5);
            width: 100%;
            height: 100%;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -25px 0 0 -25px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @if(Session::has("warningAlert"))
    <script type="text/javascript">
        jQuery(document).ready(function() {
            swal("Alert", '{{ Session::get("warningAlert") }}', "error");
        });
    </script>
    @endif

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="common-section">
                            <h4 class="titlehead"><span>Google Drive</span></h4>
                            @csrf
                            <div style="box-shadow: 0 4px 6px -3px rgba(0, 0, 0, 0.1), 0 -4px 6px -3px rgba(0, 0, 0, 0.1); margin-top:40px; height:120px; width:700px">
                                <div class="mb-3" style="margin-top:35px; display:flex">
                                    <input class="form-control" type="file" id="formFile" style="width: 500px; margin-top:40px; margin-left:20px" accept=".xlsx,.xls">
                                    <br>
                                    <button id="uploadButton" class="btn" style="margin-left: 30px; margin-top: 40px;" onclick="openUploadModal()">Upload File</button>

                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:50%;margin-left:30%">
                                        <!-- ... Modal content ... -->
                                    </div>

                                    <button class="btn" style="margin-left: 30px; margin-top:40px;background:#535be2;color:white;margin-right:20px" onclick="openStartModal()">Start Autonomous Flow</button>

                                    <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="startModalLabel" aria-hidden="true" style="width:50%;margin-left:30%">
                                        <!-- ... Modal content ... -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert-box success">Successful !!!</div>
                <div class="alert-box failure">Failure !!!</div>
                <div id="existPreview" style="display: block;"></div>
                <div class="loader" style="display: none;margin: -200px 0 0 -200px;z-index: 0;">
                    <div class="spinner"></div>
                </div>
                <div id="excelPreview" style="display: block;"></div>
            </div>
        </div>
    </div>

    <script>
        // ... Your existing JavaScript code ...
    </script>

    <script>
        // ... Your existing script for modals and other actions ...
    </script>

    <script>
        // ... Your existing script for handling file change and preview ...
    </script>
@endsection

@section('footer')
    @include('partials.frontend.interview')
@endsection

@section('footer')
    @include('partials.frontend.footer')
@endsection
