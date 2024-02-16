@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
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
<!-- <style>
    .active{background-color:red;}
    </style> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
{{-- <script src="{{ url('/') }}/assets/js/dropzone/dist/dropzone.js"></script> --}}

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
<script>
    // var dataTable1Items = null;
    var interviewData = null;



    function uploadProcess1() {

        var fileUpload = document.getElementById("excel-file")
        // validate proper file type
        var file = fileUpload.files[0]

        var regex = /^([a-zA-Z0-9\s_\(\)\\.\-:])+(.xls|.xlsx)$/

        if (regex.test(file.name)) {
            var reader = new FileReader();
            if (reader.readAsBinaryString) {
                reader.onload = function(e) {
                    var data = getResult1(e.target.result)
                    try {

                        //match header
                        var header = [];
                        for (var headers in data[0]) {
                            header.push(headers)
                        }

                        var a = header;
                        var b = [
                            "#",
                            "Request ID",
                            "Interviewer Name",
                            "Duration",
                            "Date",
                            "Start Time",
                            "End Time",

                            "Email Address",
                            "Contact Number",
                            "Meeting Details"

                        ];

                        if (data.length == 0) {
                            alert("No entries were found in excel file")
                        } else if (Object.keys(data[0]).length == 10 && (JSON.stringify(a) == JSON.stringify(b))) {
                            // console.log(data[0,1],'jiiii')
                            var columnTitles = ["Request ID",
                                "Interviewer Name",
                                "Duration",
                                "Date",
                                "Start Time",
                                "End Time",

                                "Email Address",
                                "Contact Number"
                            ];
                            var count = 1
                            Object.keys(data[0]).map(item => {
                                if (columnTitles.includes(item)) {
                                    count += 1
                                }
                            })
                            if (count < 3) {
                                alert("Wrong file")
                                return
                            }

                            var totalJobs = 0
                            //  var id= data.header;
                            //  console.log( __rowNum__[0],'headerrrrrrrrrrrrrrrrrrrrr')
                            interviewDatata = data.map(d => {
                                // if (d["Job Title"]) {

                                //     totalJobs += parseInt(d["Vacant Positions"] ? d["Vacant Positions"] : 1)
                                //     console.log('hiiii')

                                // }


                                return {
                                    "reqid": d["Request ID"],
                                    "int_name": d["Interviewer Name"],
                                    "duration": d["Duration"],
                                    "date": d["Date"],
                                    "start_time": d["Start Time"],
                                    "end_time": d["End Time"],
                                    "email": d["Email Address"],
                                    "contact": d["Contact Number"],
                                    "details": d["Meeting Details"],

                                }


                            }).filter(d => d["reqid"])


                            createTable1(data);
                            presentTableScreen1();


                        } else {
                            interviewDatata = null;
                            alert("Please download and use the Template File provided")
                        }




                    } catch (err) {
                        alert("There was an error in reading the data")
                        interviewDatata = null;

                    }

                }
                reader.readAsBinaryString(file)

            }

        } else {
            alert("Please download and use the Template File provided");
            console.log("failed");
        }

    }


    function getResult1(data) {
        var workbook = XLSX.read(data, {
            type: 'binary'
        })
        var sheet = workbook.SheetNames[0]
        var rows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
        return rows
    }

    function createTable1(data) {
        if (interviewDatata) {
console.log(interviewDatata,'llllllllllllllllllllll')
            document.getElementById('jobsSendButton1').disabled = false;
            var table = document.getElementById('dataTable1')
            // var row = table.insertRow(-1);
            var tableBody = document.createElement('tbody');
            tableBody.id = "tableBody"
            var oldTableBody = document.getElementById('tableBody');

            for (var i = 0; i < data.length; i++) {
                if (i == 0) {
                    var row = tableBody.insertRow(-1);
                    for (const header in data[0]) {
                        var headerCell = document.createElement("TH")

                        if (header == "Request ID") {
                            // headerCell.style.width = "500px";
                            // console.log(headerCell.style.width)
                            var span = document.createElement("SPAN");
                            span.innerHTML = header;
                            var span2 = document.createElement("SPAN");
                            span2.innerHTML = "..........................................................................................";
                            span2.style.opacity = 0.001;
                            span.appendChild(span2);
                            headerCell.appendChild(span);
                        } else {
                            headerCell.innerHTML = header
                        }
                        row.appendChild(headerCell);
                    }
                    // console.log(header[0],'yesss')
                }

                var row = tableBody.insertRow(-1)
                for (key in data[i]) {
                    if (data[i]["Request ID"]) {
                        var cell = row.insertCell(-1)
                        if (key == "Request ID") {
                            // cell.classList.add("tableDescription");

                        }
                        cell.innerHTML = data[i][key]

                    }
                }
            }

            // table.appendChild(tableBody);
            table.replaceChild(tableBody, oldTableBody);

        } else {
            document.getElementById('jobsSendButton1').disabled = true;
        }
    }


    function presentTableScreen1() {

        document.getElementById('dataTable1').classList.remove('d-none');
        document.getElementById('jobsSendButton1').classList.remove('d-none');
        document.getElementById('backButton1').classList.remove('d-none');
        document.getElementById('fileReadButton1').classList.add('d-none')
        document.getElementById('upload-section1').classList.add('d-none')
        // document.getElementById('spin').classList.add('d-none');

    }

    function onFileSubmit1() {
        // $(this).toggleClass('active');
        // $('#spin').show();
        // $('#fileReadButton1').hide();


        uploadProcess1();

        // presentTableScreen1()



    }

    
function onJobsSubmit1() {
        $('#spin').show();
        $('#jobsSendButton1').hide();
        postBulkJobs1().then(data => {
            // console.log(data)
        })
    }

async function postBulkJobs1() {
    // fetch()
    // var title = document.getElementById("job-title").value

    console.log(interviewDatata,'pppppppppppppppp')
    var csrf = $('meta[name="csrf-token"]').attr('content')

    document.getElementById('jobsSendButton1').disabled = true;
    try {
        var response = await fetch(window.location.origin + "/Update/Interview/job", {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                
                "payload": interviewDatata
            })

        })

        var res = await response.json()
        console.log(res)

        if (res.status) {
            $('#spin').show();
            location.reload();
            // location.href = "bulkJobs/" + res.data;
            // document.getElementById('jobsSendButton1').disabled = false;
        } else {
            // alert(res.message);
            $('#spin').show();
            location.reload();
            // document.getElementById('jobsSendButton1').disabled = true;
        }
    } catch (err) {
        console.log(err);
        document.getElementById('jobsSendButton1').disabled = true;
        alert("There was some issue with the server");
        location.reload();

    }



    return res
    
}
</script>
<script>
    // var dataTableItems = null;
    var bulkJobData = null;
    // Dropzone.options.myAwesomeDropzone = {
    //     init: function() {
    //         this.on("addedfile", function(file) {
    //             alert("Added file.");
    //         });
    //     }
    // };




    function uploadProcess() {

        var fileUpload = document.getElementById("excel-file-target")
        // validate proper file type
        var file = fileUpload.files[0]

        // old regex before adding ()
        // var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/
        var regex = /^([a-zA-Z0-9\s_\(\)\\.\-:])+(.xls|.xlsx)$/

        if (regex.test(file.name)) {
            var reader = new FileReader();
            if (reader.readAsBinaryString) {
                reader.onload = function(e) {
                    var data = getResult(e.target.result)
                    try {

                        //match header
                        var header = [];
                            for (var headers in data[0]) {
                                header.push(headers)
                                // console.log(headers, 'this is not a  header')
                            }

                            var a=header;
                                var b=[
                                    "#",
                                    "Job Title",
                                    "Job Description",
                                    "Joining Date (yyyy-mm-dd)",
                                    "Max Experience",
                                    "Location",
                                    "Job Role",
                                    "Offered CTC",
                                    "Min Experience",
                                    "Vacant Positions",
                                    "Mandatory Skills"
                                ];

                            //     if(JSON.stringify(a)==JSON.stringify(b))
                            // {
                            //     console.log(header, 'this header')
                            // }
                            // else{
                            //     alert("Please upload a excel file (xlsx) using the template's format")
                            // }

                        if (data.length == 0 ) {
                            alert("No entries were found in excel file")
                        } else if (Object.keys(data[0]).length == 11  && (JSON.stringify(a)==JSON.stringify(b))) {
                            // console.log(data[0,1],'jiiii')
                            var columnTitles = ["Job Title", "Job Description", "Joining Date (yyyy-mm-dd)", "Min Experience", "Max Experience"];
                            var count = 1
                            Object.keys(data[0]).map(item => {
                                if (columnTitles.includes(item)) {
                                    count += 1
                                }
                            })
                            if (count < 3) {
                                alert("Wrong file")
                                return
                            }
                           
                            var totalJobs = 0
                            //  var id= data.header;
                            //  console.log( __rowNum__[0],'headerrrrrrrrrrrrrrrrrrrrr')
                            bulkJobData = data.map(d => {
                                if (d["Job Title"]) {

                                    totalJobs += parseInt(d["Vacant Positions"] ? d["Vacant Positions"] : 1)
                                    console.log('hiiii')

                                }
                                return {
                                    "jobtitle": d["Job Title"],
                                    "jobdescription": d["Job Description"],
                                    "mandatory_skills": d["Mandatory Skills"],
                                    "joining_date": d["Joining Date (yyyy-mm-dd)"],
                                    "min_experience": d["Min Experience"],
                                    "max_experience": d["Max Experience"],
                                    "location": d["Location"],
                                    "job_role": d["Job Role"],
                                    "offered_ctc": d["Offered CTC"],
                                    "vacant_positions": d["Vacant Positions"] ? d["Vacant Positions"] : 1
                                }


                            }).filter(d => d["jobtitle"])

                            if (totalJobs > parseInt("{{ $fitments_left }}")) {
                                alert("You have exceeded your quota! Please purchase more fitments")

                            } else {
                                createTable(data);
                                presentTableScreen();
                            }

                        }
                       
                        
                        else {
                            bulkJobData = null;
                            alert("Please download and use the Template File provided")
                        }
                        

                        

                    } catch (err) {
                        alert("There was an error in reading the data")
                        bulkJobData = null;

                    }

                }
                reader.readAsBinaryString(file)

            }

        } else {
            alert("Please download and use the Template File provided");
            console.log("failed");
        }

    }


    function getResult(data) {
        var workbook = XLSX.read(data, {
            type: 'binary'
        })
        var sheet = workbook.SheetNames[0]
        var rows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
        return rows
    }



    function createTable(data) {
        if (bulkJobData) {

            document.getElementById('jobsSendButton').disabled = false;
            var table = document.getElementById('dataTable')
            // var row = table.insertRow(-1);
            var tableBody = document.createElement('tbody');
            tableBody.id = "tableBody"
            var oldTableBody = document.getElementById('tableBody');

            for (var i = 0; i < data.length; i++) {
                if (i == 0) {
                    var row = tableBody.insertRow(-1);
                    for (const header in data[0]) {
                        var headerCell = document.createElement("TH")

                        if (header == "Job Description") {
                            // headerCell.style.width = "500px";
                            // console.log(headerCell.style.width)
                            var span = document.createElement("SPAN");
                            span.innerHTML = header;
                            var span2 = document.createElement("SPAN");
                            span2.innerHTML = "..........................................................................................";
                            span2.style.opacity = 0.001;
                            span.appendChild(span2);
                            headerCell.appendChild(span);
                        } else {
                            headerCell.innerHTML = header
                        }
                        row.appendChild(headerCell);
                    }
                    // console.log(header[0],'yesss')
                }

                var row = tableBody.insertRow(-1)
                for (key in data[i]) {
                    if (data[i]["Job Description"]) {
                        var cell = row.insertCell(-1)
                        if (key == "Job Description") {
                            // cell.classList.add("tableDescription");

                        }
                        cell.innerHTML = data[i][key]

                    }
                }
            }

            // table.appendChild(tableBody);
            table.replaceChild(tableBody, oldTableBody);

        } else {
            document.getElementById('jobsSendButton').disabled = true;
        }
    }
</script>
<script>
    function bulkJobItemClick(id) {
        window.location.href = "{{ url('/bulkJobs') }}" + "/" + id;

    }

    function presentTableScreen() {

        document.getElementById('dataTable').classList.remove('d-none');
        document.getElementById('jobsSendButton').classList.remove('d-none');
        document.getElementById('backButton').classList.remove('d-none');
        document.getElementById('fileReadButton').classList.add('d-none')
        document.getElementById('upload-section').classList.add('d-none')
        // document.getElementById('spin').classList.add('d-none');

    }

    function presentUploadScreen() {
        document.getElementById('dataTable').classList.add('d-none');
        document.getElementById('jobsSendButton').classList.add('d-none');
        document.getElementById('backButton').classList.add('d-none');
        document.getElementById('spin').classList.add('d-none');

        document.getElementById('fileReadButton').classList.remove('d-none');
        document.getElementById('upload-section').classList.remove('d-none');
        // document.getElementById('spin').classList.remove('d-none');

    }


    function onFileSubmit() {
        // $(this).toggleClass('active');
        // $('#spin').show();
        // $('#fileReadButton').hide();

        var title = document.getElementById("job-title")
        if (title.value) {
            uploadProcess();

            // presentTableScreen()
        } else {
            alert("Enter bulk job name")
        }



    }

    function onJobsSubmit() {
        $('#spin').show();
        $('#jobsSendButton').hide();
        postBulkJobs().then(data => {
            // console.log(data)
        })
    }

    function reloadPage() {
        location.href = "{{url('/')}}/bulkJobs";
    }



    async function postBulkJobs() {
        // fetch()
        var title = document.getElementById("job-title").value
        var csrf = $('meta[name="csrf-token"]').attr('content')

        document.getElementById('jobsSendButton').disabled = true;
        try {
            var response = await fetch(window.location.origin + "/uploadBulkJob", {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "email": "<?php echo $user_email; ?>",
                    title: title,
                    "payload": bulkJobData
                })

            })

            var res = await response.json()
            // console.log(res)

            if (res.status) {

                location.reload();
                location.href = "bulkJobs/" + res.data;
                document.getElementById('jobsSendButton').disabled = false;
            } else {
                alert(res.message);
                location.reload();
                document.getElementById('jobsSendButton').disabled = true;
            }
        } catch (err) {
            console.log(err);
            document.getElementById('jobsSendButton').disabled = true;
            alert("There was some issue with the server");
            location.reload();
            // window.location.href = "{{url('/bulkJobs')}}";
        }



        return res
        
    }

    function onMoveBack() {
        presentUploadScreen();
    }
</script>
@endpush
@push('styles')
<link href="{{ url('/') }}/assets/css/jquery-ui.css" rel="stylesheet">
<link href="{{ url('/') }}/assets/js/dropzone/dist/dropzone.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/font-awesome.css">

<style>
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

    #dataTable tr td {
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


    #fileReadButton {
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

    #backButton {
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

    #jobsSendButton {
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
    

        left: 150px;
        font-size: 27;
        font-weight: 600;
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
@endpush



<div class="modal fade modalSize" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Bulk Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="upload-section">
                    <div class="d-flex flex-column justify-content-center align-items-start p-1 w-100">

                        <form>
                            <div class="form-group d-flex flex-row align-items-center pt-1 pb-1">
                                <label style="font-size: 13px; color: grey;" class="mr-2" for="recipient-name" class="col-form-label">Bulk Job Title:</label>
                                <input autocomplete="false" class="pl-1 pr-1 mr-4 w-75" style="display: block;cursor: text; width: 500px;" type="text" class="form-control" id="job-title">
                                <a href="{{ url('/') }}/assets/files/BulkJobs.xlsx" download="bulkJobs">
                                    Download Template

                                </a>
                            </div>
                        </form>

                        <div class="upload-area w-100 d-flex flex-row justify-content-center align-items-center dropzone needsclick" id="demo-upload">

                            <input class="btn" type="file" name="excel-file" id="excel-file-target">


                        </div>
                    </div>
                </div>
                <div id="review-section" class="overflow-auto" style="max-height: 500px;">
                    <table id="dataTable" class="table">
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer d-flex flex-row justify-content-center">

                <div class="d-flex flex-row w-100 h-100 justify-content-center aligh-items-between ">
                    <button id="fileReadButton" type="button" onclick="onFileSubmit(event)" class="btn btn-primary mx-2 w-25">Next</button>

                    <button class="btn  btn-style-modal d-none" style="background-color: #6B6F82;color: #fff;" id="backButton" onclick="onMoveBack()">Back</button>
                    <button id="spin" type="button" class="btn btn-primary mx-2 w-25" style="display: none;">Processing...</button>
                    <button class="btn  btn-style-modal d-none" style="background: #2e5bff; color: white;" id="jobsSendButton" onclick="onJobsSubmit()">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">

            <div class="row resp-view hide-up">
                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                    <div class="common-section">
                        <div class="drop-section-new">
                            <div>
                                <div data-toggle="modal" data-target="#myModal" class="update_plan">

                                    <img src="{{ url('/') }}/assets/images/icons/pc-icon.png" id="pc-upload-icon">
                                    <p><br>Upload from <br /> Desktop</p>
                                </div>

                                <div class="total_uploads" >
                                    <img id="d_drive" style="width:50px; fill:rgba(255,255,255,0.95);" src="{{ url('/') }}/assets/images/icons/upload.png">
                                    <span class="stat-num-blue" style="text-align:right;color:white;font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ count($bulkJobs) }}</b></span>
                                    <p>Total <br>Uploads</p>
                                </div>
                                <div class="total_jobs">
                                    <img id="d_drive" style="width:50px; fill:rgba(255,255,255,0.95);" src="{{ url('/') }}/assets/images/icons/jobs.png">
                                    <span class="stat-num-red" style="text-align:right;color:white;font-size:20px"><?php
                                                                                                                    $count = 0;
                                                                                                                    foreach ($bulkJobs as $job) {
                                                                                                                        $count += $job['count'];
                                                                                                                    } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>
                                            <?php
                                            echo $count;
                                            ?></b></span>
                                    <p>Total <br>Jobs</p>
                                </div>
                                <div class="total_candidates">
                                    <img id="d_drive" style="width:50px; fill:rgba(255,255,255,0.95);" src="{{ url('/') }}/assets/images/icons/candidates.png">
                                    <span class="stat-num-green" style="text-align:right;color:white;font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $bjid; ?></b></span>
                                    <p>Total<br> Candidates</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <table class="table bulkJobTable">
                            <tr>
                                <th style="width: 60%;">Description</th>
                                <th style="width: 15%;">Upload Date</th>
                                <th style="width: 15%;">Number of Jobs</th>
                                <th></th>
                            </tr>

                            @foreach ($bulkJobs as $bulkJob)
                            <tr style="cursor: pointer" onclick='bulkJobItemClick(@json($bulkJob["bjuid"]))'>

                                <td>{{ $bulkJob['title'] }}</td>
                                <td>{{ $bulkJob['created_at'] }}</td>
                                <td>{{ $bulkJob['count'] }}</td>
                                <td><button class="fa fa-chevron-right table-button "></button></td>
                            </tr>
                            @endforeach


                        </table>
                    </div>

                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="card  filter-section ">
                        <div class="card-content">
                            <form method="post" id="searchcandidates" action="{{url('/bulkJobs')}}" class="filter-form">
                                @csrf
                               
                                <div class="section">
                                    <label class="control-label">Name</label>
                                    <input type="text" id="candidateName" name="jobName" class="form-control ">
                                </div>
                              
                                <div class="section">
                                    <button type="submit" class="btn btn-primary btnapply">Apply</button>
                                    <button type="button" onclick="reloadPage()" class=" btn btn-primary"><img src="{{ url('/') }}/assets/images/icons/reset.png"> Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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