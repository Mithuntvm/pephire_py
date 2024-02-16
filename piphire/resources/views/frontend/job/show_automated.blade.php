@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('scripts')
<script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#usercreate").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{url('/checkemailexist')}}",
                        type: "post",
                        data: {
                            email: function() {
                                return $("#projectinput3").val();
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    required: "Please enter a name"
                },
                email: {
                    required: "Please enter an email",
                    email: "Please enter a valid email",
                    remote: "This email is already in use with another account"
                }
            },
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
</script>
@endpush

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="common-section">
                    <div class="form-group" style="float: right;margin-right:50px">
                                    <!-- basic buttons -->
                                    <a href="{{url('Edit/Autonomous/job')}}" class="btn btn-success" style="background-color: #2e5bff;">Edit</a>
                                </div><br><br>
                        <h4 class="titlehead"><span>Autonomous Job</span></h4>
                        <div class="content-header-right col-md-11 col-12">
                            <div class="float-md-right">
                                
                            </div>
                        </div>
                        <div class="row" style="width: 100%;">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="candidate-formblock" data-parsley-validate="">

                                    <div class="form col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label">Location</label>
                                        <select class="form-control status" name="location" id="location" data-parsley-required-message="Please enter atleast one Skill" disabled>
                                            <!-- style="text-align:CENTER ;" -->

                                            <option value="ftp" <?php echo ($auto_job->location == 'ftp') ? 'selected' : ''; ?>>FTP</option>

                                            <option value="adls" <?php echo ($auto_job->location == 'adls') ? 'selected' : ''; ?>>ADLS</option>
                                        </select>
                                    </div>
                                    <?php
                                    if ($auto_job->location == 'ftp') {

                                    ?>
                                        <div class=" adls-details form col-md-6 col-sm-6 col-xs-6">
                                            <label class="control-label">Ftp Hostname:</label>

                                            <input type="text" name="ftp_name" class="form-control" value="{{$auto_job->FTP_Hostname}}" readonly>

                                        </div>

                                        <div class=" adls-details form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                            <label class="control-label">Ftp Username:</label>

                                            <input type="text" name="ftp_username" class="form-control" value="{{$auto_job->FTP_Username}}" readonly>
                                        </div>


                                        <div class=" adls-details form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                            <label class="control-label">Ftp Password:</label>

                                            <input type="tel" name="ftp_password" class="form-control" value="{{$auto_job->FTP_Password}}" readonly>
                                        </div>

                                    <?php

                                    } else {
                                    ?>

                                        <div class=" ftp-details form col-md-6 col-sm-6 col-xs-6">
                                            <label class="control-label">ADLS_StorageAccountKey:</label>

                                            <input type="text" name="adls_key" class="form-control" value="{{$auto_job->ADLS_StorageAccountKey}}" readonly>

                                        </div>

                                        <div class=" ftp-details form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                            <label class="control-label">ADLS_ContainerName:</label>

                                            <input type="text" name="adls_contname" class="form-control" value="{{$auto_job->ADLS_ContainerName}}" readonly>
                                        </div>

                                        <div class="ftp-details form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                            <label class="control-label">ADLS_StorageAccountName:</label>

                                            <input type="tel" name="adls_accname" class="form-control" value="{{$auto_job->ADLS_StorageAccountName}}" readonly>
                                        </div>

                                    <?php

                                    }
                                    ?>
                                    <div class=" form col-md-12 col-sm-12 col-xs-12">
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="form col-md-6 col-sm-6 col-xs-6">
                                                <label class="control-label">Path</label>

                                                <input type="tel" name="path" class="form-control" value="{{$auto_job->Path}}" readonly>
                                            </div>
                                            <div class="form col-md-6 col-sm-6 col-xs-6">
                                                <label class="control-label">Filename</label>

                                                <input type="tel" name="filename" class="form-control" value="{{$auto_job->filename}}" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <h4 class="titlehead" style="display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        flex-direction: row-reverse;"><span>Job Schedule</span></h4>
                                        <div class="row" style="margin-top: 45px;">
                                            <div class="  col-md-6 col-sm-6 col-xs-6">
                                                <label class="control-label">Frequency</label>
                                                <select class="form-control status" name="frequency" id="frequency" data-parsley-required-message="Please enter atleast one Skill" disabled>
                                                    <!-- style="text-align:CENTER ;" -->

                                                    <option value="Hourly" <?php echo ($schedule->frequency == 'Hourly') ? 'selected' : ''; ?> readonly>Hourly</option>
                                                    <option value="Weekly" <?php echo ($schedule->frequency == 'Weekly') ? 'selected' : ''; ?> readonly>Weekly</option>
                                                    <option value="Monthly" <?php echo ($schedule->frequency == 'Monthly') ? 'selected' : ''; ?> readonly>Monthly</option>
                                                    <option value="Once" <?php echo ($schedule->frequency == 'Once') ? 'selected' : ''; ?> readonly>Once</option>
                                                </select>
                                            </div>
                                            <?php
                                            if ($schedule->hour) {
                                            ?>
                                                <div class="form col-md-6 col-sm-6 col-xs-6">
                                                    <label class="control-label">Hour:</label>

                                                    <input type="text" name="hour" id="month"  class="form-control" value="{{$schedule->hour}}" readonly>
                                                </div>
                                            <?php
                                            }
                                            if ($schedule->weekday) {
                                            ?>


                                                <div class="form col-md-6 col-sm-6 col-xs-6">
                                                    <label class="control-label">Weekday:</label>

                                                    <input type="text" name="week" id="month"  class="form-control" value="{{$schedule->weekday}}" readonly>
                                                </div>
                                            <?php
                                            }
                                            if ($schedule->month) {
                                            ?>
                                                <div class="form col-md-6 col-sm-6 col-xs-6">
                                                    <label class="control-label">Month</label>

                                                    <input type="text" name="month" id="month"  class="form-control" value="{{$schedule->month}}" readonly>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/ Revenue, Hit Rate & Deals -->

            </div>
        </div>
    </div>
    <script>
        document.getElementById('location').addEventListener('change', function() {
            var ftpDetails = document.getElementsByClassName('ftp-details');
            var adlsDetails = document.getElementsByClassName('adls-details');
            console.log(ftpDetails)
            if (this.value === 'adls') {
                showElements(ftpDetails);

                hideElements(adlsDetails);
            } else if (this.value === 'ftp') {
                showElements(adlsDetails);

                hideElements(ftpDetails);
            }
        });

        function showElements(elements) {

            for (var i = 0; i < elements.length; i++) {

                elements[i].style.display = 'block';

            }

        }



        function hideElements(elements) {

            for (var i = 0; i < elements.length; i++) {

                elements[i].style.display = 'none';

            }

        }
    </script>
    @endsection

    @section('footer')
    @include('partials.frontend.footer')
    @endsection