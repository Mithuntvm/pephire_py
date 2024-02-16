@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')

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
<script src="{{ url('/') }}/assets/js/interview.js">
    // var dataTable1Items = null;
</script>

<script>
    var completed = '<?php echo $job_total; ?>';
    var remaining = '<?php echo $organization->left_search; ?>';
    var ctx = document.getElementById('doughnutChart')
    var myDoughnutChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: ['Remaining Analysis', 'Completed Analysis'],
            datasets: [{
                label: 'Test',
                backgroundColor: ['#2E5BFF', ' #00C1D4'],
                hoverBackgroundColor: ['#2E5BFF', ' #00C1D4'],
                borderColor: 'rgba(255, 99, 132,0)',
                data: [remaining, completed]
            }]
        },

        // Configuration options go here
        options: {
            cutoutPercentage: 80,
            responsive: false,
            legend: {
                display: false,
                // position: 'left',
                // fontSize: 14,
            },
        }
    });
</script>

@if(empty($filter))
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var slider = document.getElementById('slider-range');
        noUiSlider.create(slider, {
            start: [0, 50],
            connect: true,
            tooltips: true,
            step: 1,
            range: {
                'min': 0,
                'max': 50
            },
            format: wNumb({
                decimals: 0
            })
        });
        slider.noUiSlider.on('change', getsortedcandidates);
    });
</script>
@else
<script>
    // console.log('jjjjjjjjjjjjjjjjjjjjj')
    document.addEventListener("DOMContentLoaded", function(event) {
        var slider = document.getElementById('slider-range');
        noUiSlider.create(slider, {
            start: ["<?php echo $filter->exp_1; ?>", "<?php echo $filter->exp_2; ?>"],
            connect: true,
            tooltips: true,
            step: 1,
            range: {
                'min': 0,
                'max': 50
            },
            format: wNumb({
                decimals: 0
            })
        });
        slider.noUiSlider.on('change', getsortedcandidates);
    });
</script>
@endif

<!-- <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var slider = document.getElementById('slider-range');
        noUiSlider.create(slider, {
            start: [0, 50],
            connect: true,
            tooltips: true,
            step: 1,
            range: {
                'min': 0,
                'max': 50
            },
            format: wNumb({
                decimals: 0
            })
        });

        slider.noUiSlider.on('change', () => getsortedcandidates(true));

    });
</script> -->

<script type="text/javascript">
    $(function() {
        var d = new Date();
        today = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
        $("#month-slider").slider({
            range: true,
            min: new Date('2020.01.01').getTime() / 1000,
            max: new Date(today).getTime() / 1000,
            step: 86400,
            values: [new Date('2020.01.01').getTime() / 1000, new Date(today).getTime() / 1000],
            slide: function(event, ui) {
                $("#searchdate").val((new Date(ui.values[0] * 1000).toLocaleDateString()) + " - " +
                    (new Date(ui.values[1] * 1000)).toLocaleDateString());
                //getsortedcandidates();
            }
        });
        $("#searchdate").val((new Date($("#month-slider").slider("values", 0) * 1000).toLocaleDateString()) +
            " - " + (new Date($("#month-slider").slider("values", 1) * 1000)).toLocaleDateString());
    });
</script>


<script>
    $(document).ready(function() {
        $('.knob').trigger('configure', {
            max: 100,
            thickness: 0.1,
            fgColor: '#2CC2A5',
            width: 50,
            height: 50
        });

        $(function() {
            var output = document.querySelectorAll('output')[0];

            $(document).on('input', 'input[type="range"]', function(e) {

                document.querySelector('output.' + this.id).innerHTML = e.target.value;
            });

            $('input[type=range]').rangeslider({
                polyfill: false
            });
        });
        $(".checkindates").flatpickr({
            altFormat: 'd-M-Y',
            dateFormat: 'd-M-Y'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //autocomplete

        var split = function(val) {
            return val.split(",");
        };

        var extractLast = function(term) {
            return split(term).pop();
        };

        $("#candidateName").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ url('/name/autocomplete') }}",
                    data: {
                        term: extractLast(request.term)
                    },
                    dataType: "json",
                    success: function(data) {
                        var resp = $.map(data, function(obj) {

                            return obj.name;
                        });

                        response(resp);
                    }
                });
            },
            select: function(event, ui) {
                var terms = split(this.value);
                terms.pop();
                terms.push(ui.item.value);
                terms.push("");
                this.value = terms.join(",");
                getsortedcandidates(true);
                return false;
            },
            minLength: 2
        });


        $("#skillset").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ url('/skill/autocomplete') }}",
                    data: {
                        term: extractLast(request.term)
                    },
                    dataType: "json",
                    success: function(data) {
                        var resp = $.map(data, function(obj) {

                            return obj.name;
                        });

                        response(resp);
                    }
                });
            },
            select: function(event, ui) {
                var terms = split(this.value);
                terms.pop();
                terms.push(ui.item.value);
                terms.push("");
                this.value = terms.join(",");
                getsortedcandidates(true);
                return false;
            },
            minLength: 2
        });

        $("#companylist").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ url('/company/autocomplete') }}",
                    data: {
                        term: extractLast(request.term)
                    },
                    dataType: "json",
                    success: function(data) {
                        var resp = $.map(data, function(obj) {
                            //alert(obj.name);
                            return obj.name;
                        });

                        response(resp);
                    }
                });
            },
            select: function(event, ui) {
                var terms = split(this.value);
                terms.pop();
                terms.push(ui.item.value);
                terms.push("");
                this.value = terms.join(",");
                getsortedcandidates(true);
                return false;
            },
            minLength: 2
        });

        //autocomplete


    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".leaveclass").change(function() {
            getsortedcandidates(true);
        });
        $(document).on('click', '.filter-icon-show', function() {
            $(".filter-icon + .common-section").addClass('show-block');
            $(".filter-icon").removeClass('filter-icon-show').addClass('filter-icon-close');
        });
        $(document).on('click', '.filter-icon-close', function() {
            $(".filter-icon + .common-section").removeClass('show-block');
            $(".filter-icon").removeClass('filter-icon-close').addClass('filter-icon-show');
        });

        let drop_height = $('#dropbox-height').height();
        $(".drop-count").css({
            'height': drop_height + 'px'
        });

    });
</script>


<script type="text/javascript">
    // The Browser API key obtained from the Google API Console.
    //var developerKey = 'AIzaSyDePFjv1BrKkBARQCYeCE9Ir-aOiIIpm4I';
    // sreejith's
    // var developerKey = 'AIzaSyBBH9vv0DTyD0yfVTQSsKikF9yLh_PQ_u4';

    var developerKey = 'AIzaSyAIwgZQ9RPHhyQGsYpADhyRXPYTmNyEEnI';

    // The Client ID obtained from the Google API Console. Replace with your own Client ID.
    //var clientId = '213288234854-cj2ujuh027remgdfp9gsum2ei48k60e2.apps.googleusercontent.com';
    // sreejith's
    // var clientId = '685244304462-s0jm7glc89gs18rh3q9l2h26t72dm46j.apps.googleusercontent.com';

    var clientId = '903983667524-c2tsl45ju6peahcjvecqgi8qghhjidp5.apps.googleusercontent.com';

    // Scope to use to access user's drive.
    var scope = 'https://www.googleapis.com/auth/drive';

    var pickerApiLoaded = false;
    var oauthToken;

    // Use the API Loader script to load google.picker and gapi.auth.
    function onApiLoad() {
        gapi.load('auth2', onAuthApiLoad);
        gapi.load('picker', onPickerApiLoad);
    }

    function onAuthApiLoad() {
        var authBtn = document.getElementById('g_drive_wrapper');
        authBtn.disabled = false;
        authBtn.addEventListener('click', function() {
            gapi.auth2.init({
                client_id: clientId
            }).then(function(googleAuth) {
                googleAuth.signIn({
                    scope: scope
                }).then(function(result) {
                    handleAuthResult(result.getAuthResponse());
                })
            })
        });
    }

    function onPickerApiLoad() {
        pickerApiLoaded = true;
        createPicker();
    }

    function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
            oauthToken = authResult.access_token;
            createPicker();
        }
    }

    // Create and render a Picker object for picking user Documents.
    function createPicker() {

        if (pickerApiLoaded && oauthToken) {
            var view = new google.picker.DocsView()
                .setParent('root')
                .setMimeTypes(
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/msword,application/vnd.google-apps.document,text/plain"
                )
                .setIncludeFolders(true);

            var picker = new google.picker.PickerBuilder().
            addView(view).
            enableFeature(google.picker.Feature.MULTISELECT_ENABLED).
            setOAuthToken(oauthToken).
            setDeveloperKey(developerKey).
            setCallback(pickerCallback).
            build();
            picker.setVisible(true);
        }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
        //alert(oauthToken);
        var url = '';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
            //console.log(data[google.picker.Response.DOCUMENTS]);
            //data[google.picker.Response.DOCUMENTS].forEach(loopdocfiles);
            // $("#mypreload").show();
            $("#process-div").show();
            $(".hide-up").hide();
            $("#progress").html('<p class="success" style="background-position: 100% 100px;"></p>');

            $.ajax({
                url: "{{ url('/driveupload') }}",
                type: "post",
                data: {
                    'data': data[google.picker.Response.DOCUMENTS],
                    'token': oauthToken
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#mypreload").hide();
                        //window.location.reload();
                        window.location.href = "{{ url('/attributiondocs') }}";
                    } else if (data.error == 1) {
                        swal("Alert", data.errormsg, "error");
                    }
                }
            });

        }

    }

    /*      function loopdocfiles(key, value){
            console.log(key);
            var message = '<br/>You picked: ' + key.url;
            //document.getElementById('result').innerHTML += message;
          }*/
</script>
<script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>


<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="33ndb1i1aw6o37l"></script>

<script type="text/javascript">
    options = {
        // Required. Called when a user selects an item in the Chooser.
        success: function(files) {
            //files.forEach(loopdocfilesdropbox);
            // $("#mypreload").show();
            $("#process-div").show();
            $(".hide-up").hide();
            $("#progress").html('<p class="success" style="background-position: 100% 100px;"></p>');

            $.ajax({
                url: "{{ url('/dropboxupload') }}",
                type: "post",
                data: {
                    'data': files
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#mypreload").hide();
                        //window.location.reload();
                        window.location.href = "{{ url('/attributiondocs') }}";
                    } else if (data.error == 1) {
                        swal("Alert", data.errormsg, "error");
                    }
                }
            });

        },
        cancel: function() {

        },
        linkType: "direct", // or "direct"
        multiselect: true, // or true
        extensions: ['.pdf', '.doc', '.docx'],
        folderselect: false, // or true
        sizeLimit: 5000000, // or any positive number
    };

    /*    function loopdocfilesdropbox(key, value){
          var message = '<br/>You picked: ' + key.link;
          //document.getElementById('result').innerHTML += message;
        }*/

    document.getElementById("dropbox-height").onclick = function() {
        Dropbox.choose(options);
    };
</script>

<script type="text/javascript">
    $(document).ready(function() {
        uploadpcdoc();
    });

    function uploadpcdoc() {
        /*      $('#pc_files').change(function(e){
                  $("#mypreload").show();
                  $.ajax({
                    url: "{{ url('/docpcupload') }}",
                    type: "post",
                    processData : false,
                    contentType : false,
                    data: new FormData($('#jobcreate')[0]),
                    success: function(data){
                      if(data.success==1){
                        $("#mypreload").hide();
                        //window.location.reload();
                        window.location.href="{{ url('/attributiondocs') }}";
                      }else if(data.error==1){
                        swal("Alert", data.errormsg, "error");
                      }
                    }
                  });
              }); */
    }
</script>

<script type="text/javascript">
    function gotoplans() {
        window.location.href = "{{ url('/plans') }}";
    }

    function gotohistory() {
        window.location.href = "{{ url('jobs/history') }}"
    }


    function resetmyform() {
        //$("#searchcandidates")[0].reset();
        window.location.href = "{{ url('/resetform/profile') }}"
    }

    var page = 0;

    function resetPageCounter() {
        de
        page = 0;
    }




    var apiLock = false;


    var filtered = false;
    var page = 0;

    function whatsapp() {
        var selectElement1 = document.getElementById("whatsapp");
        console.log(selectElement1.value, 'kkkkkkkkkkkkkkkkkkkkkk')

        $.ajax({
            url: "{{ URL::route('whatsapp.update') }}",
            dataType: 'json',
            type: 'POST',
            data: {
                whatsapp: selectElement1.value,
                // whatsapp: $("input[name=whatsapp]").val(),

            },

            success: function(response) {
                console.log(response)
                if (response.status) {
                    //   window.location.href = response.redirect_url;
                    location.reload();
                }
            },
            error: function(response) {

                console.log('inside ajax errorr');
            }
        });

    }

    function getsortedcandidates(resetPage = false) {
        if (resetPage) {
            page = 0;
        }
        filtered = true
        var slider = document.getElementById('slider-range');
        var expminmax = slider.noUiSlider.get();
        daterange = $("#searchdate").val();
        console.log("Here")
        $(".pagination").hide();
        if (page == 0) {
            $("#profile_list").html('Loading...');
        }
        $("#mypreload").show();
        // console.log($("#searchcandidates").serialize())
        $.ajax({
            url: "{{ url('/candidatesearch_new') }}",
            type: 'post',
            data: {
                'frm': $("#searchcandidates").serialize(),
                'exp': expminmax,
                'daterange': daterange,
                'page': page
            },

            success: function(data) {
                console.log("Successfully fetched filtered candidates")
                $("#mypreload").hide();
                if (page == 0) {
                    console.log("qqqqqq");

                    $("#profile_list").html(data.resumelist);
                } else {
                    console.log("appending");
                    $("#profile_list").html(data.resumelist);

                }
                $(".mycount").html('Result : ' + data.totalcount);
                page += 1;
                console.log(data.page)
            },
            statusCode: {
                401: function() {

                    window.location.href = '/'; //or what ever is your login URI
                },
                419: function() {
                    window.location.href = '/'; //or what ever is your login URI
                },
                500: function(err) {
                    console.log(err)
                }
            },
            error: function(res) {
                console.log("ERROR")
                swal("Alert", 'Some error occured! Please try after some time', "error");
                //window.location.reload();
            }
        });
    }
</script>

<script type="text/javascript">
    $("#profile_list").on("click", ".remove-resource", function(e) {
        e.preventDefault();
        let href = $(this).attr("data");
        let id = $(this).attr("data-id");

        swal({
            title: 'Are you sure?',
            text: "",
            buttons: true,
            dangerMode: true,
        }).then(function(isdelete) {

            if (isdelete) {

                $.ajax({
                    url: href,
                    type: 'post',
                    success: function(data) {
                        $("#revert_" + id).remove();
                    },
                    statusCode: {
                        401: function() {
                            window.location.href = '/'; //or what ever is your login URI
                        },
                        419: function() {
                            window.location.href = '/'; //or what ever is your login URI
                        }
                    },
                    error: function(res) {
                        swal("Alert", 'Some error occured! Please try after some time',
                            "error");
                    }
                });

            }
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#selectallblock").on('change', function() {
            if ($(this).is(":checked")) {
                $(".profile_check").prop('checked', true);
            } else {
                $(".profile_check").prop('checked', false);
            }
        });
    });

    function deleteselected() {
        var tot = $('input[name="deleteprofile[]"]:checked').length;
        var i = 0;
        if (tot) {
            $("#mydelete").show();
            $('input[name="deleteprofile[]"]:checked').each(function() {
                i++;

                $.ajax({
                    url: $(this).attr('data'),
                    type: 'post',
                    success: function(data) {

                        if (tot == i) {
                            window.location.reload();
                        }

                    },
                    statusCode: {
                        401: function() {
                            window.location.href = '/'; //or what ever is your login URI
                        },
                        419: function() {
                            window.location.href = '/'; //or what ever is your login URI
                        }
                    },
                    error: function(res) {
                        swal("Alert", 'Some error occured! Please try after some time', "error");
                    }
                });

            });


        } else {
            swal("Alert", 'No resume selected', "error");
        }
    }
</script>

@endpush

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div style="display: none;" id="process-div">
                <p>
                    <b>Do not refresh or click back button as profile upload is in progress.</b><b> (Attributing <span id="currentnumresumes"></span>/<span id="totnumresumes"></span>)</b>
                </p>
                <div id="progress"></div>
            </div>
            <!-- Revenue, Hit Rate & Deals -->
            <div class="row resp-view hide-up">
                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                    <div class="common-section">
                        <div class="drop-section-new">
                            <div>
                                <div class="pc-drop">
                                    <form method="post" enctype="multipart/form-data" id="jobcreate">
                                        @csrf
                                        <input multiple="multiple" accept=".doc,.docx,.pdf" type="file" name="pc[]" id="pc_files">
                                    </form>
                                    <img src="{{ url('/') }}/assets/images/icons/pc-icon.png" id="pc-upload-icon">
                                    <p>Upload from <br /> Desktop</p>
                                </div>
                                <div class="drive-drop" id="g_drive_wrapper">
                                    <img id="g_drive" src="{{ url('/') }}/assets/images/icons/drive-icon.png">
                                    <p>Upload from <br /> Drive</p>
                                </div>
                                <div class="dropbox-drop" id="dropbox-height">
                                    <img id="d_drive" src="{{ url('/') }}/assets/images/icons/dropbox-icon.png">
                                    <p>Upload from <br /> Dropbox</p>
                                </div>
                                {{-- <div class="drop-count">
                    <span>{{$totalcount}}</span>
                                <p>Active Profiles</p>
                            </div> --}}
                            <div class="drive-drop update_plan" s onclick="gotoplans()">
                                <img id="d_drive" style="width:20px; fill:rgba(255,255,255,0.95)" src="{{ url('/') }}/assets/images/icons/planning.svg">
                                <p>Upgrade <br /> Plan</p>
                            </div>
                            {{-- <div class="" style="height: 115px; width:200px;" onclick="gotoplans()">
            <div class="card text-white f-block">
              <div class="card-content">
                <img class="card-img img-fluid" src="assets/images/d-image.png" alt="Card image">
                <div class="card-img-overlay d-detailblock">

                  <p class="card-text">Upgrade<br/>Plan</p>
                  <a href="javascript:void(0);">Read More</a>
                </div>
              </div>
            </div>
          </div> --}}
                        </div>
                    </div>
                    <div class="modal-profilelist i-profilelist">
                        <div class="title-section">
                            <h4 class="titlehead">
                                @if (!$candidates->isEmpty())
                                <span>
                                    <input id="selectallblock" type="checkbox" name="selectall">
                                    <label for="selectallblock"><span>Select All</span></label>
                                </span>
                                <span><a href="javascript:void(0);" onclick="deleteselected()">Delete</a></span>
                                @endif
                                <span class="mycount">Result : {{ $totalcount }}</span>
                            </h4>
                        </div>
                        <div id="profile_list">

                            @if (!$candidates->isEmpty())
                            @foreach ($candidates as $ck)
                            <a id="revert_{{ $ck->id }}" href="{{ url('profile/' . $ck->cuid) }}">
                                <div class="profile-list-db modal-profileblock filecount resumeli resumeli_{{ $ck->id }}">
                                    <div>
                                        <div class="avatar-image">
                                            <span>
                                                @if ($ck->photo == '' && ($ck->sex == '' || $ck->sex == 'None'))
                                                <img class="rounded-circle" src="{{ url('/') }}/assets/images/candiate-img.png">
                                                @elseif($ck->photo == '' && $ck->sex =='Male')
                                                <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                @elseif($ck->photo == '' && $ck->sex =='Female')
                                                <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                @else
                                                <img class="rounded-circle" src="{{ asset('storage/' . $ck->photo) }}">
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($ck->name)
                                        <p>{{ ucwords($ck->name) }}</p>
                                        @else
                                        <p>{{ ucwords($ck->resume->name) }}</p>
                                        @endif
                                        <p></p>
                                        <p><span>Experience:</span> <span>{{ $ck->experience }}
                                                yrs</span>
                                        </p>
                                        <p style="color:black;font-size:10px">{{ \Carbon\Carbon::parse($ck->created_at)->format('d-M-Y') }}
                                        </p>
                                        <p style="color:black;font-size:10px">ID :: {{$ck->id}}
                                        </p>
                                        @if($ck->status == 1)
                                        <p style="font-size:10px">Status :: <span style="color:blue;font-size:10px">CONTACTED</span>
                                        </p>
                                        @endif
                                        @if($ck->status == 2)
                                        <p style="font-size:10px">Status :: <span style="color:green;font-size:10px">INTERESTED</span>
                                        </p>
                                        @endif
                                        @if($ck->status == 3)
                                        <p style="font-size:10px">Status :: <span style="color:red;font-size:10px"> NOT INTERESTED</span>
                                        </p>
                                        @endif
                                        @if($ck->status == 4)
                                        <p style="color:black;font-size:10px">Status :: NOT CONTACTED
                                        </p>
                                        @endif
                                    </div>
                                   
@php
								$skill = App\Candidate_Skill::where('candidate_id', $ck->id)

								->pluck('skillname')->toArray();
								@endphp
                                    <div>
                                    @if (!empty($skills))
                                        <?php $maxc = 1; ?>
                                        @foreach ($skill as $mk)
                                        <?php if ($maxc < 6) { ?>
                                            <span>{{ ucwords($mk) }}</span>
                                        <?php } ?>
                                        <?php $maxc++; ?>
                                        @endforeach
                                        @else
                                        <span>No skills</span>
                                        @endif

                                    </div>
                                    <div>
                                        <p></p>
                                    </div>
                                    <div>
                                        <p></p>
                                        <p></p>
                                    </div>


                                    <div class="checkbox-block">
                                        <input class="profile_check" data="{{ url('/resume/delete/' . $ck->resume->id) }}" id="checkblock_{{ $ck->id }}" type="checkbox" name="deleteprofile[]" value="{{ $ck->id }}">
                                        <label for="checkblock_{{ $ck->id }}"></label>
                                    </div>

                                </div>
                            </a>
                            @endforeach

                            @else

                            <p class="alert alert-warning text-center">No matching profile</p>

                            @endif



                        </div>
                        {{ $candidates->links() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                <p class="filter-icon filter-icon-show"><i class="ft-filter"></i> Filter</p>
                <div class="common-section">
                    <div class="d-flex flex-row flex-wrap justify-content-between">

                      


        <!-- <div class="w-100 d-flex flex-row chart-card card d-chart">
            <div style="min-width: 100px;" class="card-info-section d-flex flex-column d-chartblock">
                <div class="prepaid">
                    <h4 class="card-title">Pre Paid</h4>
                </div>

                <div>
                    <p style="font-size: 14px;color: grey;" class="total-search"><span style="color: black;">{{ $organization->total_search }}</span> <span></span>Jobs 
                    </p>
                </div>

                <div class="pos-abs" style="margin-top:26px;display:flex">
                    <span class="card-completed">Completed</span>
                    <span class="card-remaining">Remaining</span>
                </div>

            </div> -->
            <!-- <div class="chart-section">
                <div class="chart_container">
                    <div class="the-crazy-chart ">
                        <canvas id="doughnutChart" width="180" height="100" class="absolute"></canvas>
                        <div class="analysis_remaining">
                            <p style="align-items: center;">{{ $organization->left_search }}</p>
                           
                        </div>
                    </div>




                </div>
            </div> -->

        <!-- </div> -->

        
        <div class="w-100">
        <div class="card  d-counters ">
                <div class="card-content p-1" style="background-color: #80808052;">
                    <div class="d-countblock">
                         <i class="tick-icon"><img src="assets/images/icons/total_jobs.png"></i> 
                        <h4 class="card-title " style="color: #0000009c;">{{ $organization->total_search }}</h4>
                        <p class="card-text" style="margin-top: 8px;">Total Jobs</p>
                    </div>
                </div>
            </div>
            <div class="card  d-counters ">
                <div class="card-content p-1" style="background-color: #80808052;">
                    <div class="d-countblock">
                         <i class="tick-icon"><img src="assets/images/icons/remaining_jobs.png"></i> 
                        <h4 class="card-title " style="color: #0000009c;">{{ $organization->left_search }}</h4>
                        <p class="card-text" style="margin-top: 8px;">Remaining Jobs</p>
                    </div>
                </div>
            </div>
            <div class="card  d-counters ">
                <div class="card-content p-1" style="background-color: #80808052;">
                    <div class="d-countblock">
                         <i class="tick-icon"><img src="assets/images/icons/total.png"></i> 
                        <h4 class="card-title " style="color: #0000009c;">{{ $resume_trashed }}</h4>
                        <p class="card-text" style="margin-top: 8px;">Total Profiles Uploaded</p>
                    </div>
                </div>
            </div>
            <div class="card  d-counters " style="cursor: pointer;" onclick="gotohistory()">
                <div class="card-content p-1" style="background-color: #80808052;">
                    <div class="d-countblock">
                         <i class="tick-icon"><img src="assets/images/icons/fitment.png"></i> 
                        <h4 class="card-title " style="color: #0000009c;">{{ $job_total }}</h4>
                        <p class="card-text" style="margin-top: 8px;">Fitment Analysis Completed</p>
                    </div>
                </div>
            </div>


            <div class="card  d-counters ">
                <div class="card-content p-1" style="background-color: #80808052;">
                    <div class="d-countblock">
                        <i class="tick-icon"><img src="assets/images/icons/active.png"></i>
                        <h4 class="card-title " style="color: #0000009c;">{{ $resume_total }}</h4>
                        <p class="card-text" style="margin-top: 8px;">Active Profiles</p>
                    </div>
                </div>
            </div>
            <div class="card  d-counters ">
                <div class="card-content p-1">
                    <div class="d-countblock">
                        <!-- <i class="tick-icon"><img src="assets/images/icons/active-profiles.png"></i> -->
                        <h6 class="card-title" style="font-size: 13px;font-family:Arial">Whatsapp Flow</h6>
                        <p class="card-text"><select name="whatsapp" class="form-control status" onchange="whatsapp()" id="whatsapp" style="font-family:Arial">

                                <option value="auto" <?php echo ($user->whatsapp_flow == 'auto') ? 'selected' : ''; ?>>Autonomous</option>
                                <option value="semi_auto" <?php echo ($user->whatsapp_flow == 'semi_auto') ? 'selected' : ''; ?>>Semi Autonomous</option>
                                <option value="manual" <?php echo ($user->whatsapp_flow == 'manual') ? 'selected' : ''; ?>>Manual</option>
                            </select></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="card  filter-section ">
        <div class="card-content">
            <form method="post" id="searchcandidates" class="filter-form">

                <div class="section">
                    <label class="control-label">Experience(years)</label>

                    <div id="slider-range"></div>
                    <div class="row slider-labels">
                        <div class="col-md-6 caption">
                            <span id="expfirst"></span>
                        </div>
                        <div class="col-md-6 text-right caption">
                            <span id="expsecond"></span>
                        </div>
                    </div>
                </div>
                <div class="section">
                    <label class="control-label">Name</label>
                    <input onchange="resetPageCounter()" type="text" <?php if ($filter) { ?> value="{{$filter->name}}" <?php } ?> id="candidateName" name="name" class="form-control ">
                </div>
                <div class="section">
                    <label class="control-label">Skill</label>
                    <input onchange="resetPageCounter()" type="text" <?php if ($filter) { ?> value="{{$filter->skills}}" <?php } ?> id="skillset" name="skill" class="form-control ">
                </div>
                <div class="section">
                    <label class="control-label">Company</label>
                    <input onchange="resetPageCounter()" type="text" <?php if ($filter) { ?> value="{{$filter->company}}" <?php } ?> name="company" id="companylist" class="form-control">
                </div>
                <div class="section">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <label class="control-label">Resume Upload Date</label>
                            <input onchange="resetPageCounter()" type="text" id="searchdate" style="border: 0; color: #f6931f; font-weight: bold;" size="100" />
                            <div id="month-slider" class="slider month-slider"></div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <button type="button" onclick="getsortedcandidates()" class="btn btn-primary btnapply">Apply</button>
                    <button type="button" onclick="resetmyform()" class="btn btn-primary"><img src="{{ url('/') }}/assets/images/icons/reset.png"> Reset</button>
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

<div id="mypreload" style="display: none;">
    <span style="">Uploading Profiles</span>
    <div class="nb-spinner"></div>
</div>

<div id="mydelete" style="display: none;">
    <span style="">Deleting resumes</span>
    <div class="nb-spinner"></div>
</div>

@section('footer')
@include('partials.frontend.interview')
@endsection

@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection