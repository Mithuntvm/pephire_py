@extends('layouts.app')



@section('header')

@include('partials.frontend.header')

@endsection



@section('content')



@section('sidebar')

@include('partials.frontend.sidebar')

@endsection
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src=https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js></script>

<script src=https://code.jquery.com/jquery-3.6.0.min.js></script>
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

    /* float: right; */

    margin-left: 25px;



  }
</style>

<script type="text/javascript">



</script>


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







    <div class="content-header row">

    </div>

    <div class="content-body">

      <!-- Revenue, Hit Rate & Deals -->

      <div class="row">

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

          <div class="common-section">

            <h4 class="titlehead"><span>Google Drive</span></h4>





            @csrf

            <div style="box-shadow: 0 4px 6px -3px rgba(0, 0, 0, 0.1), 0 -4px 6px -3px rgba(0, 0, 0, 0.1);margin-top:40px;height:120px;width:700px">



              <div class="mb-3" style="margin-top:35px;display:flex">

                <input class="form-control" type="file" id="formFile" style="width: 500px;margin-top:40px;margin-left:20px" accept=".xlsx,.xls"><br>

                <!-- <button id="uploadButton" class="btn" style="margin-left: 30px;margin-top:40px;" onclick="upload()">Upload File</button> -->

                <button id="uploadButton" class="btn" style="margin-left: 30px; margin-top: 40px;" onclick="openUploadModal()">Upload File</button>

                <!-- Upload Confirmation Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:50%;margin-left:30%">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#ff0000c9">Gdrive Upload Cofirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" onclick="closeUploadModal()">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure to Upload the file?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeUploadModal()" style="margin-top:10px;">Close</button>
                        <button type="button" class="btn btn-primary" onclick="uploadFile()" style="background-color: #2e5bffad;padding:5px 10px;width:20%">Upload</button>
                      </div>
                    </div>
                  </div>
                </div>

                <button class="btn" style="margin-left: 30px;margin-top:40px;background:#535be2;color:white;margin-right:20px" onclick="openStartModal()">Start Autonomous Flow</button>
                <!-- Upload Confirmation Modal -->
                <div class="modal fade" id="startModal" tabindex="-1" role="dialog" aria-labelledby="startModalLabel" aria-hidden="true" style="width:50%;margin-left:30%">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="startModalLabel" style="color: #ff0000c9;">Start Autonomous Flow Cofirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" onclick="closeStartModal()">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure to Start Autonomous Flow?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeStartModal()" style="margin-top:10px;">Close</button>
                        <button type="button" class="btn btn-primary" onclick="start()" style="background-color: #2e5bffad;padding:5px 10px;width:20%">Start</button>
                      </div>
                    </div>
                  </div>
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

        <div class="spinner"></div> <!-- Loader content -->

      </div>
      <div id="excelPreview" style="display: block;"></div>

    </div>

  </div>



</div>

</div>





<!-- JavaScript for handling file change and preview -->

<script>
  document.getElementById('formFile').onchange = function(e) {
    document.getElementById('existPreview').innerHTML = '';
    var file = e.target.files[0];

    if (file) {

      var reader = new FileReader();

      reader.onload = function(e) {

        var data = new Uint8Array(e.target.result);

        var workbook = XLSX.read(data, {
          type: 'array'
        });



        var sheetName = workbook.SheetNames[0];

        var sheet = workbook.Sheets[sheetName];



        // Create HTML table structure to display Excel content

        var html = '<table border="1">';

        var range = XLSX.utils.decode_range(sheet['!ref']);



        for (var R = range.s.r; R <= range.e.r; ++R) {

          html += '<tr>';

          for (var C = range.s.c; C <= range.e.c; ++C) {

            var cellAddress = {
              c: C,
              r: R
            };

            var cellRef = XLSX.utils.encode_cell(cellAddress);

            var cell = sheet[cellRef];

            var cellValue = cell ? cell.v : '';

            html += '<td>' + cellValue + '</td>';

          }

          html += '</tr>';

        }

        html += '</table>';



        document.getElementById('excelPreview').innerHTML = html;



        // Enable the upload button after reviewing the file

        document.getElementById('uploadButton').disabled = false;

      };

      reader.readAsArrayBuffer(file);

    }

  };
  // document.getElementById('formFile').onchange = function(e) {

  //   var file = e.target.files[0];

  //   if (file) {

  //     var reader = new FileReader();

  //     reader.onload = function(e) {

  //       var data = new Uint8Array(e.target.result);

  //       var workbook = XLSX.read(data, {
  //         type: 'array'
  //       });



  //       /* Here, you can parse the workbook and display the content */

  //       /* For instance, display the first sheet's data */

  //       var sheetName = workbook.SheetNames[0];

  //       var sheet = workbook.Sheets[sheetName];

  //       var html = XLSX.utils.sheet_to_html(sheet);

  //       document.getElementById('excelPreview').innerHTML = html;

  //     };

  //     reader.readAsArrayBuffer(file);

  //   }

  // };
</script>
<script>
  function openUploadModal() {
    $('#exampleModal').modal('show');
  }

  function closeUploadModal() {
    $('#exampleModal').modal('hide');
  }

  function closeStartModal() {
    $('#startModal').modal('hide');
  }

  function openStartModal() {
    $('#startModal').modal('show');
  }

  function uploadFile() {

    // if (confirm("Are you sure to Upload this file")) {
    $('#exampleModal').modal('hide');
    var file = $('input[type=file]')[0].files[0];

    var formData = new FormData();

    formData.append('file', file);


    $(".loader").show();

    $.ajax({

      url: '/upload-file',

      type: 'POST',

      processData: false,

      contentType: false,

      data: formData,

      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

      },

      success: function(response) {
        document.getElementById('existPreview').innerHTML = '';

        // document.getElementById('excelPreview').innerHTML = '';
        $(".loader").hide();

        $('.success').fadeIn(300).delay(1500).fadeOut(400);

      },

      error: function(xhr, status, error) {

        console.log('Error:', error);
        document.getElementById('existPreview').innerHTML = '';

        document.getElementById('excelPreview').innerHTML = '';

        $(".loader").hide();

        $('.failure').fadeIn(300).delay(1500).fadeOut(400);

      }

    });



  }


  $(document).ready(function() {

    var fileLink = 'http://pepdemo.westindia.cloudapp.azure.com/gdrive_files/JD_Input.xlsx'; // Replace with the actual file path

    var xhr = new XMLHttpRequest();
    xhr.open('GET', fileLink, true);
    xhr.responseType = 'blob';

    xhr.onload = function() {
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = new Uint8Array(e.target.result);
        var workbook = XLSX.read(data, {
          type: 'array'
        });

        var sheetName = workbook.SheetNames[0];
        var sheet = workbook.Sheets[sheetName];

        // Create HTML table structure to display Excel content
        var html = '<table border="1">';
        var range = XLSX.utils.decode_range(sheet['!ref']);

        for (var R = range.s.r; R <= range.e.r; ++R) {
          var isEmptyRow = true; // Flag to check if the row is empty
          html += '<tr>';
          for (var C = range.s.c; C <= range.e.c; ++C) {
            var cellAddress = {
              c: C,
              r: R
            };
            var cellRef = XLSX.utils.encode_cell(cellAddress);
            var cell = sheet[cellRef];
            var cellValue = cell ? cell.v : '';

            html += '<td>' + cellValue + '</td>';

            // Check for non-empty cell
            if (cellValue !== null && cellValue !== undefined && cellValue.toString().trim() !== '') {
              isEmptyRow = false;
            }
          }
          html += '</tr>';

          // Skip adding the empty row
          if (isEmptyRow) {
            html = html.substring(0, html.lastIndexOf('<tr'));
          }
        }

        html += '</table>';

        document.getElementById('excelPreview').innerHTML = html;
      };
      reader.readAsArrayBuffer(this.response);
    };

    xhr.send();
  });

  function start() {

    // if (confirm("Are you sure to Start the flow")) {
    $('#startModal').modal('hide');

    $(".loader").show();

    $.ajax({

      url: '/start-job',

      type: 'get',



      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

      },

      success: function(data) {
        $(".loader").hide();

        if (data.success) {

          $('.success').fadeIn(300).delay(1500).fadeOut(400);
        } else {
          $('.failure').fadeIn(300).delay(1500).fadeOut(400);

        }

      },

      error: function(xhr, status, error) {

        console.log('Error:', error);

        $('.failure').fadeIn(300).delay(1500).fadeOut(400);

      }

    });

  }
</script>



@section('footer')

@include('partials.frontend.interview')

@endsection



@section('footer')

@include('partials.frontend.footer')

@endsection

@endsection