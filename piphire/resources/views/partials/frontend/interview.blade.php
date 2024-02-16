<style>
    .modal-profilelist>div .modal-profileblock>div:nth-child(2) p:last-child {
        color: #8798AD;
        font-size: 11px;
        font-weight: 600;
    }

    .modal-profilelist.i-profilelist>div .modal-profileblock>div:nth-child(4) {
        /*width: 120px;*/
        display: none;
    }

    #progress {
        display: flex;
        flex-wrap: wrap;
    }

    #progress p {
        display: inline-block;
        width: 450px !important;
        padding: 15px;
        margin: 10px 5px;
        background: #fff;
        overflow-wrap: break-word;
        word-wrap: break-word;
        box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }

    #progress p.success {
        background: #0bb01e !important;
        border: none !important;
        color: #fff !important;
        box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }

    #progress p.failure {
        background: #f22929 !important;
        border: none !important;
        color: #fff !important;
        box-shadow: 0px 11.4245px 22.849px rgba(46, 91, 255, 0.07);
    }

    #process-div>p {
        font-weight: 500 !important;
        letter-spacing: 0.05rem !important;
        font-size: 1.12rem !important;
    }

    @media only screen and (max-width: 1250px) {
        .the-crazy-chart {
            margin-right: 100px;
        }
    }

    @media only screen and (max-width: 1200px) {
        .the-crazy-chart {
            margin-right: 0px;
        }
    }

    .analysis_remaining {
        position: absolute;
        top: 20px;
        left: 62px;
    }

    .analysis_remaining p {
        font-size: 15px;
        padding: 0px;
        font-weight: bolder;
        padding-bottom: 5px;
        margin: 0px;
        text-align: center;
    }

    .analysis_remaining h6 {
        padding: 0px;
        margin: 0px;
        text-align: center;
        font-size: 11px;
    }

    .the-crazy-chart {
        position: relative;
    }

    .chart_container {
        position: relative;
    }

    #doughnutChart {
        width: 100px;
        height: 180px;
    }

    .chart-card {}

    .chart-card-title {
        font-weight: 500;
        letter-spacing: 0.05rem;
    }

    .card-info-section {}

    .chart-section {
        display: flex;
        max-width: 200px;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-start;
    }


    .chart_container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    #mypreload,
    #mydelete {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        opacity: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.95)
    }

    #mypreload .nb-spinner {
        width: 75px;
        height: 75px;
        margin: 0;
        background: transparent;
        border-top: 4px solid #2E5BFF;
        border-right: 4px solid transparent;
        border-radius: 50%;
        -webkit-animation: 1s spin linear infinite;
        animation: 1s spin linear infinite;
        position: relative;
        z-index: 999;
    }

    #mydelete .nb-spinner {
        width: 75px;
        height: 75px;
        margin: 0;
        background: transparent;
        border-top: 4px solid #2E5BFF;
        border-right: 4px solid transparent;
        border-radius: 50%;
        -webkit-animation: 1s spin linear infinite;
        animation: 1s spin linear infinite;
        position: relative;
        z-index: 999;
    }

    #mypreload,
    #mydelete span {
        position: relative;
        top: -20px;
        color: #000;
        font-size: 24px;
        z-index: 99;
    }



    .tableDescription {
        width: 500px;
    }

    .file-upload-btn {
        background-color: #EB5757;
        cursor: pointer;
        color: white;


    }

    .table-button {
        background-color: rgba(0, 0, 0, 0);
        border: none;
        padding: 5px;
        border-radius: 5px;
    }

    .table-button:focus {
        outline: none;
        box-shadow: none;
    }

    .table-button:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }


    .bulk-job-stat {
        background-color: white;
        color: black;

    }

    #dataTable1 tr td {
        vertical-align: top;
    }


    .card-section {}

    .card-section * {
        width: 100%;
        max-width: 270px;
        height: 110px;
        /* color: #ffffff; */
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        border-radius: 4px;
        font-weight: 600;
        /* margin-right: 10px; */

    }

    .card-section * * {
        box-shadow: none;
    }

    .bulkJobTable {
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);

    }



    .bulkJobTable th {
        color: white;
        background-color: #7a7a7a;

    }

    .bulkJobTable tr {
        height: 45px;
    }


    #fileReadButton1 {
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
        /* float: right; */
        margin-left: 85px;
    }

    #backButton1 {
        background: #6B6F82 !important;
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
        /* float: right; */
        margin-left: 85px;
    }

    #spin {
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
        /* float: right; */
        margin-left: 85px;
    }

    #jobsSendButton1 {
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
        /* float: right; */
        margin-left: 85px;
    }


    .file-upload-btn .bulkupload-img {
        position: absolute;
        width: 36px;
        height: 36px;
        left: 20px;
        top: 14px;
        filter: grayscale(0%);
    }

    .bulk-job-stat .files-uploaded-img {
        position: absolute;
        width: 36px;
        height: 36px;
        left: 20px;
        top: 14px;
        filter: grayscale(100);
    }

    .card-header span {
        /* position: absolute;
                                                                                                                                               right: 10px;
                                                                                                                                               top: 5px; */

        left: 150px;
        font-size: 27;
        font-weight: 600;
        /* right: 20px; */
        top: 3px;
    }


    .card-section * {
        position: relative;
    }

    .upload-area {
        border: 2px dashed #BDBDBD;
    }

    .stat-num-blue {
        color: #2e5bff;

    }

    .stat-num-green {}

    .stat-num-red {
        color: #EB5757;
    }

    .modalSize {
        margin: auto;
        width: 80%;
    }

    .btn-style-modal {
        width: 40%;
        padding: 15px 30px;
        margin-left: 10px;
        box-shadow: 0px 12px 20px rgba(46, 91, 255, 0.09);
        border-radius: 2px;
        font-size: 16px;
        line-height: 26px;
        font-weight: 600;
        font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, "Helvetica Neue", Arial, sans-serif;
        margin-top: 10px;
        box-shadow: 0px 10px 13px rgba(12, 116, 241, 0.148);
    }

    @media only screen and (max-width: 900px) {
        .modalSize {
            width: 80%;
        }
    }
</style>
<link rel="stylesheet" href=https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css>

<script src=https://code.jquery.com/jquery-3.6.0.min.js></script>

<script src=https://code.jquery.com/ui/1.12.1/jquery-ui.js></script>
<link rel="stylesheet" href=https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css>

<link rel="stylesheet" href=https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css>

<script src=https://code.jquery.com/jquery-3.6.0.min.js></script>

<script src=https://code.jquery.com/ui/1.12.1/jquery-ui.js></script>

<script src=https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js></script>



<div class="modal fade modalSize" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Interview File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div id="upload-section1">
                    <div class="d-flex flex-column justify-content-center align-items-start p-1 w-100">

                        <form>
                            <div class="form-group d-flex flex-row  pt-1 pb-1" style="text-align: right;">

                                <a href="{{ url('/export_excel') }}" >
                                    Download Template

                                </a>
                            </div>
                        </form>

                        <div class="upload-area w-100 d-flex flex-row justify-content-center align-items-center dropzone needsclick" id="demo-upload">

                            <input class="btn" type="file" name="excel-file" id="excel-file">


                        </div>

                    </div>
                </div>
                <div id="review-section" class="overflow-auto" style="max-height: 500px;">
                    <table id="dataTable1" class="table">
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer d-flex flex-row justify-content-center">

                <div class="d-flex flex-row w-100 h-100 justify-content-center aligh-items-between ">
                    <button id="fileReadButton1" type="button" onclick="onFileSubmit1(event)" class="btn btn-primary mx-2 w-25">Next</button>

                    <button class="btn  btn-style-modal d-none" style="background-color: #6B6F82;color: #fff;" id="backButton1" onclick="onMoveBack1()">Back</button>
                    <button id="spin" type="button" class="btn btn-primary mx-2 w-25" style="display: none;">Processing...</button>
                    <button class="btn  btn-style-modal d-none" style="background: #2e5bff; color: white;" id="jobsSendButton1" onclick="onJobsSubmit1()">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        // $("#datepicker").flatpickr({

        //     dateFormat: ' M - d',

        //     changeYear: false,

        //     beforeShow: function(input, inst) {

        //         inst.dpDiv.addClass("custom-datepicker");

        //     }

        // });



        $("#timepicker").flatpickr({
            enableTime: true,

            noCalendar: true,

            dateFormat: "H:i",

            time_24hr: true,

            minuteIncrement: 15




        });

    });
</script>


<style>
    .custom-datepicker .ui-datepicker-year {

        display: none;

    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="{{ url('/') }}/assets/css/jquery-ui.css" rel="stylesheet">

<!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css" rel="stylesheet"></link> -->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/range-slider.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div id="scheduleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="scheduleModalLabel">Schedule Autonomous Job</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>

            </div>
            <div class="modal-body">
                <?php
                if ($auto_job) {
                ?>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">

                            <label class="control-label">Location</label>
                            <select class="form-control status" name="location" id="location" data-parsley-required-message="Please enter atleast one Skill" disabled>
                                <!-- style="text-align:CENTER ;" -->

                                <option value="ftp" <?php echo ($auto_job->location == 'ftp') ? 'selected' : ''; ?>>FTP</option>

                                <option value="adls" <?php echo ($auto_job->location == 'adls') ? 'selected' : ''; ?>>ADLS</option>
                                <option value="gdrive" <?php echo ($auto_job->location == 'gdrive') ? 'selected' : ''; ?>>Google Drive</option>

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

                        } else if ($auto_job->location == 'adls') {
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

                        <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                            <label class="control-label">Path</label>

                            <input type="tel" name="path" class="form-control" value="{{$auto_job->Path}}" readonly>
                        </div>
                        <?php
                        if ($auto_job->filename) {

                        ?>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <label class="control-label">Filename</label>

                                <input type="tel" name="filename" class="form-control" value="{{$auto_job->filename}}" readonly>
                            </div><?php

                                } ?>
                        <br>
                        <br>
                        <br><br><br>
                        <!-- <br>
                                        <br>
                                        <h4 class="titlehead" style="display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        flex-direction: row-reverse;"><span>Job Schedule</span></h4> -->
                        <div class="modal-header col-md-12">

                            <h5 class="modal-title" id="scheduleModalLabel">Schedule Job</h5>


                        </div>
                       <!-- whatsapp flow view -->
                        <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                            <br><br>
                            <label class="control-label">Frequency</label>
                            <select class="form-control status" name="frequency" id="frequency" data-parsley-required-message="Please enter atleast one Skill" disabled>
                                <!-- style="text-align:CENTER ;" -->

                                <option value="Hourly" <?php echo ($schedule->frequency == 'Hourly') ? 'selected' : ''; ?> readonly>Hourly</option>
                                <option value="Weekly" <?php echo ($schedule->frequency == 'Weekly') ? 'selected' : ''; ?> readonly>Weekly</option>
                                <option value="Daily" <?php echo ($schedule->frequency == 'Daily') ? 'selected' : ''; ?> readonly>Daily</option>
                                <option value="Monthly" <?php echo ($schedule->frequency == 'Monthly') ? 'selected' : ''; ?> readonly>Monthly</option>

                                <option value="Once" <?php echo ($schedule->frequency == 'Once') ? 'selected' : ''; ?> readonly>Once</option>
                            </select>
                        </div>
                        <?php
                        if ($schedule->hour) {
                        ?>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <br><br>
                                <label class="control-label">Hour:</label>

                                <input type="text" name="hour" id="month" class="form-control" value="{{$schedule->hour}}" readonly>
                            </div>
                        <?php
                        }
                        if ($schedule->weekday) {
                        ?>


                            <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <br><br>
                                <label class="control-label">Weekday:</label>

                                <input type="text" name="week" id="month" class="form-control" value="{{$schedule->weekday}}" readonly>
                            </div>
                        <?php
                        }
                        if ($schedule->date) {
                        ?>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <br><br>
                                <label class="control-label">Date</label>

                                <input type="text" name="month" id="month" class="form-control" value="{{$schedule->date}}" readonly>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <br><br>
                    <div class="form-group" style="float: right;margin-right:50px">
                        <!-- basic buttons -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editscheduleModal"> <button class="btn btn-success" style="background-color: #2e5bff;">Edit</button></a>
                    </div><br><br>
                    </button>
                <?php
                } else {
                ?>
                    <form name="create" id="usercreate" enctype="multipart/form-data" method="post" action="{{ url('/Autonomous/job') }}" class="common-form edit-profile">

                        @csrf <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">

                                <label class="control-label">Location</label>
                                <select class="form-control status" name="location" id="location" data-parsley-required-message="Please enter atleast one Skill" required>
                                    <!-- style="text-align:CENTER ;" -->
                                    <option>Select</option>
                                    <option value="ftp">FTP</option>
                                    <option value="adls">ADLS</option>
                                    <option value="gdrive">Google Drive</option>
                                </select>

                            </div>

                            <div class=" adls-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">Ftp Hostname:</label>

                                <input type="text" name="ftp_name" class="form-control" value="">

                            </div>

                            <div class=" adls-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">Ftp Username:</label>

                                <input type="text" name="ftp_username" class="form-control" value="">
                            </div>


                            <div class=" adls-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">Ftp Password:</label>

                                <input type="tel" name="ftp_password" class="form-control" value="">
                            </div>



                            <div class=" ftp-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">ADLS_StorageAccountKey:</label>

                                <input type="text" name="adls_key" class="form-control" value="">

                            </div>

                            <div class=" ftp-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">ADLS_ContainerName:</label>

                                <input type="text" name="adls_contname" class="form-control" value="">
                            </div>

                            <div class="ftp-details form col-md-6 col-sm-6 col-xs-6" style="display: none;">
                                <label class="control-label">ADLS_StorageAccountName:</label>

                                <input type="tel" name="adls_accname" class="form-control" value="">
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">

                                <label class="control-label">Path</label>

                                <input type="tel" name="path" class="form-control" value="">

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">

                                <label class="control-label">Filename</label>

                                <input type="tel" name="filename" class="form-control" value="">

                            </div>
                            <br>
                            <br>
                            <br><br><br>
                            <div class="modal-header col-md-12">
                                <h5 class="modal-title" id="scheduleModalLabel">Schedule Job</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <br><br>
                                <label class="control-label">Frequency</label>
                                <select class="form-control status" name="frequency" id="frequency" data-parsley-required-message="Please enter atleast one Skill" required>
                                    <!-- style="text-align:CENTER ;" -->
                                    <option>Select</option>
                                    <option value="Hourly">Hourly</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Once">Once</option>
                                </select>

                            </div>



                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;;" id="week1">
                                <br><br>

                                <label class="control-label">Weekday:</label>

                                <select class="form-control status" name="week" id="week" data-parsley-required-message="Please enter atleast one Skill" required>
                                    <!-- style="text-align:CENTER ;" -->
                                    <option>Select</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wendesday">Wendesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>

                                </select>
                            </div>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;" id="month1">
                                <br><br>

                                <label class="control-label">Select Date</label>
                                <input class="form-control " type="text" id="datepicker" name="month" />
                            </div>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;" id="hour1">


                                <label class="control-label">Time:</label>

                                <input type="text" name="hour" id="timepicker" class="form-control" value="">
                            </div>
                            <!-- <div class="form col-md-6 col-sm-6 col-xs-6">
                                <br><br>
                                <label class="control-label">Whatsapp Flow:</label>
                                <select class="form-control status" name="whatsapp" id="" data-parsley-required-message="" required>
                                    <option value="auto">Autonomous</option>
                                    <option value="semi-auto">Semi Autonomous</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div> -->


                        </div>
                        <button type="submit" class="w3-btn" style="height: 30px;width:80px;margin-left:3%;background-color:#2e5bff;color:white;margin-top:20px">
                            <p style="margin-top:2px">Submit</p>
                        </button>
                    </form>


                <?php
                }
                ?>
            </div>
            <!-- <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary">Save</button>

      </div> -->

        </div>

    </div>

</div>

<?php
if ($auto_job) {

?>


    <div id="editscheduleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Autonomous Job</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>

                </div>
                <div class="modal-body">
                    <form name="create" id="usercreate" enctype="multipart/form-data" method="post" action="{{ url('/Update/Autonomous/job') }}" class="common-form edit-profile">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">

                                <label class="control-label">Location</label>
                                <select class="form-control status" name="location" id="location1" data-parsley-required-message="Please enter atleast one Skill">
                                    <!-- style="text-align:CENTER ;" -->

                                    <option value="ftp" <?php echo ($auto_job->location == 'ftp') ? 'selected' : ''; ?>>FTP</option>
                                    <option value="gdrive" <?php echo ($auto_job->location == 'gdrive') ? 'selected' : ''; ?>>Google Drive</option>
                                    <option value="adls" <?php echo ($auto_job->location == 'adls') ? 'selected' : ''; ?>>ADLS</option>
                                </select>
                            </div>
                            <div class=" adls-details1 form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;">
                                <label class="control-label">Ftp Hostname:</label>

                                <input type="text" name="ftp_name" class="form-control" value="{{$auto_job->FTP_Hostname}}">

                            </div>

                            <div class=" adls-details1 form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;" style="display: none;">
                                <label class="control-label">Ftp Username:</label>

                                <input type="text" name="ftp_username" class="form-control" value="{{$auto_job->FTP_Username}}">
                            </div>


                            <div class=" adls-details1 form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;" style="display: none;">
                                <label class="control-label">Ftp Password:</label>

                                <input type="tel" name="ftp_password" class="form-control" value="{{$auto_job->FTP_Password}}">
                            </div>



                            <div class=" ftp-details1 form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;">
                                <label class="control-label">ADLS_StorageAccountKey:</label>

                                <input type="text" name="adls_key" class="form-control" value="{{$auto_job->ADLS_StorageAccountKey}}">

                            </div>

                            <div class=" ftp-details1 form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;" style="display: none;">
                                <label class="control-label">ADLS_ContainerName:</label>

                                <input type="text" name="adls_contname" class="form-control" value="{{$auto_job->ADLS_ContainerName}}">
                            </div>

                            <div class="ftp-details1 form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;" style="display: none;">
                                <label class="control-label">ADLS_StorageAccountName:</label>

                                <input type="tel" name="adls_accname" class="form-control" value="{{$auto_job->ADLS_StorageAccountName}}">
                            </div>



                            <div class="form col-md-6 col-sm-6 col-xs-6" id="path1" style="display: block;margin-top:15px ;">
                                <label class="control-label">Path</label>

                                <input type="text" name="path" id="paths" class="form-control" value="{{$auto_job->Path}}">
                            </div>

                            <div class="form col-md-6 col-sm-6 col-xs-6" id="file1" style="display: block;margin-top:15px ;">
                                <label class="control-label">Filename</label>

                                <input type="tel" name="filename" class="form-control" value="{{$auto_job->filename}}">
                            </div>
                            <br>
                            <br>
                            <br><br><br>

                            <div class="modal-header col-md-12">

                                <h5 class="modal-title" id="scheduleModalLabel">Schedule Job</h5>


                            </div>

                            <div class="form col-md-6 col-sm-6 col-xs-6" style="margin-top:15px ;">
                                <br><br>
                                <label class="control-label">Frequency</label>
                                <select class="form-control status" name="frequency" id="frequency1" data-parsley-required-message="Please enter atleast one Skill">
                                    <!-- style="text-align:CENTER ;" -->

                                    <option value="Hourly" <?php echo ($schedule->frequency == 'Hourly') ? 'selected' : ''; ?> readonly>Hourly</option>
                                    <option value="Weekly" <?php echo ($schedule->frequency == 'Weekly') ? 'selected' : ''; ?> readonly>Weekly</option>
                                    <option value="Daily" <?php echo ($schedule->frequency == 'Daily') ? 'selected' : ''; ?> readonly>Daily</option>
                                    <option value="Monthly" <?php echo ($schedule->frequency == 'Monthly') ? 'selected' : ''; ?> readonly>Monthly</option>
                                    <option value="Once" <?php echo ($schedule->frequency == 'Once') ? 'selected' : ''; ?>>Once</option>
                                </select>
                            </div>





                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;" id="week2">
                                <br><br>
                                <label class="control-label">Weekday:</label>

                                <!-- <input type="text" name="week" id="month" class="form-control" value="{{$schedule->weekday}}"> -->
                                <select class="form-control status" name="week" id="week" data-parsley-required-message="Please enter atleast one Skill" required>
                                    <!-- style="text-align:CENTER ;" -->

                                    <option value="Sunday" <?php echo ($schedule->weekday == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                                    <option value="Monday" <?php echo ($schedule->weekday == 'Monday') ? 'selected' : ''; ?>>Monday</option>
                                    <option value="Tuesday" <?php echo ($schedule->weekday == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                                    <option value="Wendesday" <?php echo ($schedule->weekday == 'Wendesday') ? 'selected' : ''; ?>>Wendesday</option>
                                    <option value="Thursday" <?php echo ($schedule->weekday == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                                    <option value="Friday" <?php echo ($schedule->weekday == 'Friday') ? 'selected' : ''; ?>>Friday</option>
                                    <option value="Saturday" <?php echo ($schedule->weekday == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>

                                </select>
                            </div>

                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;" id="month2">
                                <br><br>
                                <label class="control-label">Date</label>

                                <!-- <input type="text" name="month" id="month" class="form-control" value="{{$schedule->month}}"> -->
                                <input class="form-control " type="number" id="datepicker" name="month" value="{{$schedule->date}}" max="31" />

                            </div>
                            <div class="form col-md-6 col-sm-6 col-xs-6" style="display: none;margin-top:15px ;" id="hour2">
                                <br><br>
                                <label class="control-label">Hour:</label>

                                <!-- <input type="text" name="hour" id="month" class="form-control" value="{{$schedule->hour}}"> -->
                                <input class="form-control " type="text" id="timepicker" name="hour" value="{{$schedule->hour}}" />

                            </div>
                       <!-- whatsapp flow edit -->

                            
                        </div>
                        <br><br>
                        <div class="form-group" style="float: right;margin-right:50px">
                            <!-- basic buttons -->
                            <button type="submit" class="w3-btn" style="height: 30px;width:80px;margin-left:3%;background-color:#2e5bff;color:white;margin-top:20px">
                                <p style="margin-top:2px">Submit</p>

                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>




<!-- modal for interview file upload -->






<!-- Include Bootstrap JavaScript -->

<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js></script>


<script>
    window.onload = function() {
        var select = document.getElementById('location');
        console.log(select, 'dghfjyjyufweft')

        var ftpDetails = document.getElementsByClassName('ftp-details');
        var adlsDetails = document.getElementsByClassName('adls-details');
        console.log(ftpDetails)
        if (select.value === 'adls') {
            console.log('yyyyyyyyyyyyyyyyyyyyyyyy')
            showElements(ftpDetails);

            hideElements(adlsDetails);
        } else if (select.value === 'ftp') {
            showElements(adlsDetails);

            hideElements(ftpDetails);
        }


        select.addEventListener('change', function() {

            var ftpDetails = document.getElementsByClassName('ftp-details');
            var adlsDetails = document.getElementsByClassName('adls-details');
            console.log('ftpDqqqqqqqqqqqqqqqqqqqqqqqqetails')
            if (select.value === 'adls') {
                showElements(ftpDetails);

                hideElements(adlsDetails);
            } else if (select.value === 'ftp') {
                showElements(adlsDetails);

                hideElements(ftpDetails);
            }
        });




        var selectElement = document.getElementById("frequency");
        var hour = document.getElementById("hour1");

        var month = document.getElementById("month1");
        var week = document.getElementById("week1");
        if (selectElement.value === "Hourly") {

            hour.style.display = "none";
            week.style.display = "none";
            month.style.display = "none";
        }
        if (selectElement.value === "Daily") {

            hour.style.display = "block";
            week.style.display = "none";
            month.style.display = "none";
        }
        if (selectElement.value === "Weekly") {

            hour.style.display = "block";
            week.style.display = "block";
            month.style.display = "none";
        }
        if (selectElement.value === "Monthly") {

            hour.style.display = "block";
            week.style.display = "none";
            month.style.display = "block";
        }
        if (selectElement.value === "Once") {

            hour.style.display = "none";
            week.style.display = "none";
            month.style.display = "none";
        }

        selectElement.addEventListener("change", function() {
            console.log(selectElement.value, 'jjjjjjj66666666666666666666')

            if (selectElement.value === "Hourly") {

                hour.style.display = "none";
                week.style.display = "none";
                month.style.display = "none";
            }
            if (selectElement.value === "Daily") {

                hour.style.display = "block";
                week.style.display = "none";
                month.style.display = "none";
            }
            if (selectElement.value === "Weekly") {

                hour.style.display = "block";
                week.style.display = "block";
                month.style.display = "none";
            }
            if (selectElement.value === "Monthly") {

                hour.style.display = "block";
                week.style.display = "none";
                month.style.display = "block";
            }
            if (selectElement.value === "Once") {

                hour.style.display = "none";
                week.style.display = "none";
                month.style.display = "none";
            }

        });

    }

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

    //   edit schedule
    var select1 = document.getElementById('location1');

    var ftpDetails1 = document.getElementsByClassName('ftp-details1');
    var adlsDetails1 = document.getElementsByClassName('adls-details1');
    if (select1.value === 'adls') {
        var file1 = document.getElementById("file1");
        var path1 = document.getElementById("paths");
        path1.removeAttribute("readonly");

        file1.style.display = "block";
        showElements1(ftpDetails1);

        hideElements1(adlsDetails1);
    } else if (select1.value === 'ftp') {
        var file1 = document.getElementById("file1");
        var path1 = document.getElementById("paths");
        path1.removeAttribute("readonly");
        file1.style.display = "block";
        showElements1(adlsDetails1);

        hideElements1(ftpDetails1);
    } else if (select1.value === 'gdrive') {
        var file1 = document.getElementById("file1");
        var path1 = document.getElementById("paths");
        path1.setAttribute("readonly", "readonly");
        file1.style.display = "none";
        hideElements1(adlsDetails1);

        hideElements1(ftpDetails1);
    }




    select1.addEventListener('change', function() {

        var ftpDetails1 = document.getElementsByClassName('ftp-details1');
        var adlsDetails1 = document.getElementsByClassName('adls-details1');
        if (select1.value === 'adls') {
            var file1 = document.getElementById("file1");
            var path1 = document.getElementById("paths");
            path1.removeAttribute("readonly");
            var pathh = document.getElementById("path1");
            file1.style.display = "block";
            pathh.style.display = "block";
            showElements1(ftpDetails1);
            hideElements1(adlsDetails1);
        } else if (select1.value === 'ftp') {
            var path1 = document.getElementById("paths");
            path1.removeAttribute("readonly");
            var file1 = document.getElementById("file1");
            var pathh = document.getElementById("path1");
            file1.style.display = "block";
            pathh.style.display = "block";
            showElements1(adlsDetails1);
            hideElements1(ftpDetails1);
        } else if (select1.value === 'gdrive') {

            var file1 = document.getElementById("file1");
            var path1 = document.getElementById("path1");
            path1.style.display = "none";
            file1.style.display = "none";

            hideElements1(adlsDetails1);

            hideElements1(ftpDetails1);
        }
    });




    var selectElement1 = document.getElementById("frequency1");

    var hour1 = document.getElementById("hour2");

    var month1 = document.getElementById("month2");
    var week1 = document.getElementById("week2");
    if (selectElement1.value === "Hourly") {

        hour1.style.display = "none";
        week1.style.display = "none";
        month1.style.display = "none";
    }
    if (selectElement1.value === "Daily") {
        hour1.style.display = "block";
        week1.style.display = "none";
        month1.style.display = "none";
    }
    if (selectElement1.value === "Weekly") {

        hour1.style.display = "block";
        week1.style.display = "block";
        month1.style.display = "none";
    }
    if (selectElement1.value === "Monthly") {

        hour1.style.display = "block";
        week1.style.display = "none";
        month1.style.display = "block";
    }
    if (selectElement1.value === "Once") {

        hour1.style.display = "none";
        week1.style.display = "none";
        month1.style.display = "none";
    }

    selectElement1.addEventListener("change", function() {

        if (selectElement1.value === "Hourly") {

            hour1.style.display = "none";
            week1.style.display = "none";
            month1.style.display = "none";
        }
        if (selectElement1.value === "Daily") {

            hour1.style.display = "block";
            week1.style.display = "none";
            month1.style.display = "none";
        }
        if (selectElement1.value === "Weekly") {

            hour1.style.display = "block";
            week1.style.display = "block";
            month1.style.display = "none";
        }
        if (selectElement1.value === "Monthly") {

            hour1.style.display = "block";
            week1.style.display = "none";
            month1.style.display = "block";
        }
        if (selectElement1.value === "Once") {

            hour1.style.display = "none";
            week1.style.display = "none";
            month1.style.display = "none";
        }

    });



    function showElements1(elements) {

        for (var i = 0; i < elements.length; i++) {

            elements[i].style.display = 'block';

        }

    }



    function hideElements1(elements) {

        for (var i = 0; i < elements.length; i++) {

            elements[i].style.display = 'none';

        }

    }

    function reloadPage() {
        location.reload();
    }
</script>
<script>
    function handleDropdownChange() {

        var selectedValue = document.getElementById('location1').value;

        if (selectedValue === 'gdrive') {
            var value = 'sandraaa';
            var parameter = {

                FolderName: value

            };

            callAPI(parameter);

        }

    }

    function callAPI(parameter) {

        // var value = 'sandraaa';
        // Construct the API URL with the necessary parameters

        var apiUrl = 'http://127.0.0.1:1234/';



        var queryString = '?params=' + encodeURIComponent(JSON.stringify(parameter));

        console.log(queryString, 'queryStringqueryStringqueryString')

        fetch(apiUrl + queryString)

            .then(function(response) {

                if (response.ok) {

                    return response.json();
                    console.log(response, 'this is the response')

                } else {

                    throw new Error('API request failed. Status code: ' + response.status);

                }

            })

            .then(function(data) {

                console.log(data);

                alert(data);

            })

            .catch(function(error) {

                console.error(error);

            });

    }
</script>