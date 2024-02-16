@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/range-slider.css">
<link rel="stylesheet" href=https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')

<script src=https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js></script>
<script src=https://unpkg.com/sweetalert/dist/sweetalert.min.js></script>
<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src=https://cdn.jsdelivr.net/npm/flatpickr></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src=https://cdn.jsdelivr.net/npm/chart.js@2.8.0></script>
<script src="{{url('/')}}/assets/js/jquery-ui.min.js"></script>
<style>
    .button-container {
        display: flex;
        justify-content: space-evenly;
        /* Adjust as needed for your layout */
        margin-top: 15px;
        /* Adjust as needed for your layout */
    }

    /* Additional styles for buttons or adjust existing styles as needed */
    .btn {
        margin: 10px auto;
        border: none;

    }
</style>

@if(empty($input))
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

        slider.noUiSlider.on('change', function() {
            var expminmax = slider.noUiSlider.get();
            $("#experience").val(expminmax);
        });

    });
</script>
@else
<?php $experce = explode(',', $input['experience']);  ?>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var slider = document.getElementById('slider-range');
        noUiSlider.create(slider, {
            start: ["<?php echo $experce['0']; ?>", "<?php echo $experce['1']; ?>"],
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

        slider.noUiSlider.on('change', function() {
            var expminmax = slider.noUiSlider.get();
            $("#experience").val(expminmax);
        });

    });
</script>
@endif
<script>
    $(document).ready(function() {
        setinitial();
    });

    function setinitial() {
        $('.knob').trigger('configure', {
            max: 100,
            thickness: 0.1,
            fgColor: '#2CC2A5',
            width: 50,
            height: 50
        });

        $('.knob.knob1').trigger('configure', {
            max: 100,
            thickness: 0.2,
            fgColor: '#2CC2A5',
            width: 40,
            height: 40
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

        var split = function(val) {
            return val.split(",");
        };

        var extractLast = function(term) {
            return split(term).pop();
        };

        $("#skillset").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{url('/skill/autocomplete')}}",
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
                return false;
            },
            minLength: 2
        });

    }
</script>

<script type="text/javascript">
    function searchlist() {

        $("#profile_list").html('Loading...');

        $.ajax({
            url: "{{url('/job/details/search')}}",
            type: "post",
            data: {
                'frm': $("#candidatelist").serialize()
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#profile_list").html(data.view);
                    //$("#mytot").html(data.totalcount);
                    //setinitial();
                } else if (data.error == 1) {
                    swal("Alert", data.errormsg, "error");
                }
            }
        });

    }

    setTimeout(function() {
        $(".alert_hide").hide();
    }, 2500);

    function showfulldec() {
        $(".short").hide();
        $(".full").show();
    }

    function shoshort() {
        $(".full").hide();
        $(".short").show();
    }
</script>

<script type="text/javascript">
    function gotoback() {
        history.back();
    }

    function resetmyform() {
        //$("#searchcandidates")[0].reset();
        window.location.href = "<?php echo url('/job/details/' . $job->juid); ?>";
    }
</script>

<style>
    #csv {
        background: #6162658a !important;
        color: #fff !important;
        padding: 6px 30px;
        border-radius: 4px;
        text-transform: capitalize;
        font-size: 13px;
        letter-spacing: 0.5px;
        font-weight: 600;
        min-width: 80px;
        width: auto;
        margin: 10px auto;
        border-color: transparent;
        /* float: right; */
        margin-left: 95px;
    }

    #res {
        background: #6162658a !important;
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
        border-color: transparent;

        /* float: right; */
        margin-left: 85px;
    }
</style>
<script type="text/javascript">
    $(function() {
        $("#selectallblock").on('change', function() {
            if ($(this).is(":checked")) {
                $(".profile_check").prop('checked', true).change();
            } else {
                $(".profile_check").prop('checked', false).change();
            }
        });

        $(".profile_check").change(function() {
            var selectedCount = $('input[name="selectprofile[]"]:checked').length;
            if (selectedCount == 0) {
                $(".shortlisted-section").removeClass('active');
            } else {
                $(".shortlisted-section").addClass('active');
            }
        });
    });

    function deleteSelected() {
        var selectedCount = $('input[name="selectprofile[]"]:checked').length;
        if (selectedCount == 0) {
            swal("Alert", 'Please select atleast one profile', "error");
            return false;
        }

        // $('input[name="finalizeprofile[]"]:checked').each(function() {
        //  $(this).parents('.i-profilematrix').remove();
        // });

        // $("#selectallblock").prop('checked', false).change();
        var candidatesArr = $('input[name="selectprofile[]"]:checked').map(function(_, el) {
            return $(el).val();
        }).get();

        $.ajax({
            url: "{{ URL::route('notIntetersted.update', $job->juid) }}",
            dataType: 'json',
            type: 'POST',
            data: {
                candidatesArr,
            },
            success: function(response) {
                if (response.status) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function(response) {
                console.log('inside ajax error handler');
            }
        });
    }

    function submitShortlisted() {

        var candidatesArr = $('input[name="selectprofile[]"]:checked').map(function(_, el) {
            return $(el).val();
        }).get();
        console.log(candidatesArr, 'hloooooooooooooooooooooo')
        $.ajax({
            url: "{{ URL::route('shortlistedCandidates.store', $job->juid) }}",
            dataType: 'json',
            type: 'POST',
            data: {
                candidatesArr,
            },
            success: function(response) {
                if (response.status) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function(response) {
                console.log('inside ajax error handler');
            }
        });
    }

    function gotoback() {
        history.back();
    }
</script>

@endpush

<style type="text/css">
    .newtab-section li:not(.active) a {
        pointer-events: none;
    }
</style>

<div class="app-content content">
    <div class="content-wrapper">

        @if(session()->has('success'))
        <div class="col-12 alert alert_hide alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>
        @endif

        <div class="content-header row">
            <div class="col-3 float-right">
                <button onclick="gotoback()" type="button" class="btn btn-primary btn-float"><i class="ft-arrow-left" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="content-body">

            <!-- Revenue, Hit Rate & Deals -->
            <div class="row resp-view">
                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                    <div class="common-section">
                        <div class="title-section">
                            <h4>{{$job->name}}</h4>
                            <p class="short">{{substr($job->description,0,300)}} @if(strlen($job->description) > 300)<a href="javascript:void(0);" onclick="showfulldec()">... More</a> @endif</p>
                            <div class="full" style="display: none;">
                                <p>{{$job->description}}</p>
                                <a href="javascript:void(0);" onclick="shoshort()">Show Less</a>
                            </div>
                        </div>
                        <div class="modal-profilelist i-profilelist i-pmatrix noscroll">
                            <div class="title-section">
                                <ul class="newtab-section">
                                    <li class="result-section active">
                                        <a href="{{ route('job.show', $job->juid) }}">
                                            <div class="first-child">
                                                <div class="icon-box">
                                                    <img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
                                                    <img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
                                                </div>
                                                <p>Result : {{$job->candidates->count()}}</p>
                                            </div>
                                            <div class="second-child">
                                                <i class="ft-chevron-right"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="shortlisted-section @if($isEdit['shortlisted']) active @endif">
                                        @if($isEdit['shortlisted'])
                                        <a href="javascript:void(0);" onclick="submitShortlisted();">
                                            @else
                                            <a href="javascript:void(0);" onclick="submitShortlisted();">
                                                @endif
                                                <div class="first-child">
                                                    <div class="icon-box">
                                                        <img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
                                                        <img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
                                                    </div>
                                                    <p>Shortlisted Candidates</p>
                                                </div>
                                                <div class="second-child">
                                                    <i class="ft-chevron-right"></i>
                                                </div>
                                            </a>
                                    </li>
                                    <li class="slot-section @if($isEdit['timeslot']) active @endif">
                                        @if($isEdit['timeslot'])
                                        <a href="{{ route('interviewTimeSlot.view', $job->juid) }}">
                                            @else
                                            <a href="javascript:void(0);">
                                                @endif
                                                <div class="first-child">
                                                    <div class="icon-box">
                                                        <img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
                                                        <img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
                                                    </div>
                                                    <p>Time Slot</p>
                                                </div>
                                                <div class="second-child">
                                                    <i class="ft-chevron-right"></i>
                                                </div>
                                            </a>
                                    </li>
                                    <li class="scheduled-section @if($isEdit['scheduled']) active @endif">
                                        @if($isEdit['scheduled'])
                                        <a href="{{ route('scheduledCandidates.show', $job->juid) }}">
                                            @else
                                            <a href="javascript:void(0);">
                                                @endif
                                                <div class="first-child">
                                                    <div class="icon-box">
                                                        <img class="disabled" src="{{url('/')}}/assets/images/img-new/icon1.png">
                                                        <img class="color" src="{{url('/')}}/assets/images/img-new/icon1-color.png">
                                                    </div>
                                                    <p>Scheduled List</p>
                                                </div>
                                                <div class="second-child">
                                                    <i class="ft-chevron-right"></i>
                                                </div>
                                            </a>
                                    </li>
                                </ul>

                                @if( ! $isEdit['shortlisted'])
                                <h4 class="titlehead">
                                    <span>
                                        <input id="selectallblock" type="checkbox" name="selectall">
                                        <label for="selectallblock"><span>Select All</span></label>
                                    </span>
                                    <span><a href="" onclick="deleteSelected()">Not Interested</a></span>
                                </h4>

                                @endif

                            </div>

                            <div>
                                @if(!$job->candidates->isEmpty())
                                @foreach($job->candidates as $ck)
                                <a href="{{ url('profile/' . $ck->cuid) }}">
                                    <div class="modal-profileblock i-profilematrix">
                                        <div>
                                            <div class="avatar-image">
                                                <span>
                                                    @if($ck->photo == '' && ($ck->sex =='' || $ck->sex =='None'))
                                                    <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                                                    @elseif($ck->photo == '' && $ck->sex =='Male')
                                                    <img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
                                                    @elseif($ck->photo == '' && $ck->sex =='Female')
                                                    <img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $ck->photo) }}">
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <p>{{ucwords($ck->name)}} - {{$ck->id}}</p>
                                            <p></p>
                                            <p><span>Experience:</span> <span>{{$ck->experience}} yrs</span></p>
                                            <p><span>{{$ck->email}}</span><span>{{$ck->phone}}</span></p>
                                        </div>
                                        <div>

                                            <?php $maxc = 1; ?>
                                            @php
                                            $cand = App\Job::where('id', $job->id)->first();
                                            $skills = explode(',', $cand->mandatory_skills);
                                            $man_skills = App\Candidate_Skill::whereIn('skillname', $skills)->where('candidate_id', $ck->id);
                                            $skillsI = $man_skills->pluck('skillname')->toArray();

                                            $skill_common = App\Candidate_Skill::where('candidate_id', $ck->id)->pluck('skillname')->toArray();
                                            $commonSkills = array_diff($skill_common, $skills);
                                            $mergedSkills = array_merge($skillsI, $commonSkills);
                                            @endphp

                                            @if($mergedSkills)
                                            @foreach($mergedSkills as $mk)
                                            <span style="background-color: {{ in_array($mk, $skillsI) ? '#90ee9045' : 'white' }}; color: #45474a;">{{ucwords($mk)}}</span>
                                            <?php if ($maxc >= 15) break; ?>
                                            <?php $maxc++; ?>
                                            @endforeach
                                            @else
                                            <span>No skills</span>
                                            @endif
                                        </div>
                                        <div>

                                            <p><input type="text" value="{{$ck->pivot->score}}" class="knob basic-dial" readonly></p>
                                            <p>Score</p>
                                        </div>

                                        <div class="checkbox-block">

                                            @php
                                            $isSelected = App\ShortlistedCandidate::where('job_id', $job->id)->where('candidate_id', $ck->id)->count();
                                            @endphp

                                            @if($isEdit['shortlisted'])
                                            <input class="profile_check" id="checkblock_{{ $ck->id }}" type="checkbox" name="selectprofile[]" value="{{ $ck->id }}" @if($isSelected> 0) checked="" @endif >
                                            @else
                                            <input class="profile_check" id="checkblock_{{ $ck->id }}" type="checkbox" name="selectprofile[]" value="{{ $ck->id }}" @if($isSelected> 0) checked="" @endif>

                                            @endif

                                            <label for="checkblock_{{ $ck->id }}"></label>
                                        </div>

                                    </div>
                                </a>
                                @endforeach
                                @else

                                <p class="alert alert-warning">No records found</p>

                                @endif
                                <?php
                                // $scr=$ck->pivot->score;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="common-section">
                        <form id="candidatelist" method="post" class="filter-form">
                            <input type="hidden" name="juid" value="{{ $job->juid }}">
                            @csrf
                            <div class="card filter-section ">
                                <div class="card-content">
                                    <h4>Filter</h4>
                                    <div class="section">
                                        <label class="control-label">Score</label>
                                        <output class="score" data-output>@if(isset($input['score'])) {{$input['score']}} @else 0 @endif</output>
                                        <input id="score" type="range" @if(isset($input['score'])) value="{{$input['score']}}" @else value="{{0}}" @endif min="0" max="100" value="0" name="score" />
                                    </div>

                                    <script type="text/javascript">
                                        function rangeSlide(value) {
                                            document.getElementById('rangeValue').innerHTML = value;
                                        }
                                    </script>
                                    <div class="section">
                                        <label class="control-label">Experience(years)</label>
                                        <input id="experience" value="0,50" name="experience" type="hidden">
                                        <div id="slider-range"></div>
                                        <div class="row slider-labels">
                                            <div class="col-md-6 caption">
                                                <span>0</span>
                                            </div>
                                            <div class="col-md-6 text-right caption">
                                                <span>50</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section">
                                        <label class="control-label">Skill</label>
                                        <input type="text" name="skill" id="skillset" value="@if(isset($input['skill'])){{$input['skill']}}@endif" class="form-control">
                                    </div>
                                    <div class="section">
                                        <button type="submit" class="btn btn-primary btn-color">Apply</button>
                                        <button type="button" onclick="resetmyform()" class="btn btn-primary"><img src="{{url('/')}}/assets/images/icons/reset.png"> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card filter-section " style="margin-top: 10px;">
                                <div class="card-content">
                                    <h4>Download</h4>
                                    <div class="section">
                                    
                                    <div class="button-container" style="display: flex; justify-content: space-around; margin-top: 15px;">
                                        <form name="resume" id="" method="post" action="{{ route('download.resume') }}">
                                            @csrf
                                            <input type="hidden" name="juid" value="{{ $job->id }}">
                                            <button type="submit" class="btn btn-primary" id="res" style="border: none; background: none; cursor: pointer; margin: 0 -5px;">Resumes</button>
                                        </form>

                                        <form name="resume" id="" method="post" action="{{ route('download.csv') }}">
                                            @csrf
                                            <input type="hidden" name="jid" value="{{ $job->id }}">
                                            <button type="submit" class="btn btn-primary" id="csv" style="border: none; background: none; cursor: pointer; margin: 0 -5px;">CSV</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Revenue, Hit Rate & Deals -->

            <!-- <div class="row">

              @if(!$jobs->isEmpty())
                @foreach($jobs as $kk)

                  <div class="col-xl-4 col-xs-12 mt-2">
                    <a href="{{url('/job/details/'.$kk->juid)}}">
                    <div class="previous-title">
                      <p>{{$kk->name}}</p>
                      <p>{{ \Carbon\Carbon::parse($kk->created_at)->format('M d Y') }}</p>
                    </div>
                  </a>
                    <div class="top-candidate">
                      <div>
                        <p>Top candidate</p>
                        <span></span>
                      </div>
                      <div class="candidate-detail">

                    @if(!$kk->candidates->isEmpty())
                      <?php $cnt = 1; ?>
                      @foreach($kk->candidates as $rk)
                        <div>
                          <a href="{{ url('profile/' . $rk->cuid) }}">
                          <span>
                            @if($rk->photo == '')
                            <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                            @else
                            <img class="rounded-circle" src="{{ asset('storage/' . $rk->photo) }}">
                            @endif
                            <i>{{$cnt}}</i></span>
                          <span><p>{{$rk->name}}</p> <p></p></span>
                          <span><p></p> <input type="text" value="{{$rk->pivot->score}}" class="knob knob1 basic-dial" readonly></span>
                        </a>
                        </div>
                        <?php $cnt++; ?>
                        @endforeach
                    @else

                      <p class="alert alert-warning">No records found</p>

                    @endif

                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <p class="alert alert-warning text-center">No records found</p>
              @endif
        </div> -->
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection