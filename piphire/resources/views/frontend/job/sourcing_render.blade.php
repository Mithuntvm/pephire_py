
<div class="row">
                                <div class="col-sm-12" id="scroll" style="display: flex;padding-left: 8px;overflow-x: scroll;">
                                    <div id="optionbuttonsdiv" style="margin-top: -36px;">

                                        <i class="fa fa-minus faicon status-minimize" onclick="collapsecards(this)" title="status minimize"></i>


                                        <br><i class="fa fa-calendar faicon" class="btn btn-info btn-lg" onclick="openModal();" title="Assign Interviewer"></i>
                                        <br><i class="fa fa-list faicon" onclick="downloadCSV();" title="Report Download"></i>
                                        <br><i class="fa fa-download faicon" onclick="downloadresume();" title="Resume Download"></i>
                                        <!--<br><i class="fa fa-edit faicon" onclick="openstatusbulkupdatemodal();"></i>-->
                                    </div>

                                    <div class="col-sm-3 status-column" id="sourced" style="margin-left: 35px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 10px;background:rgb(46 91 255);padding-left: 20px;
    padding-right: 20px;
    padding-top: 7px;
    padding-bottom: 7px;
    color: white;
    border-radius: 5px;"></small>&nbsp;&nbsp;Sourced</p>
                                        @if(!$sourced_job->isEmpty())
                                        @foreach($sourced_job as $skj)
                                        <?php
                                        $resume = App\Resume::where('id', $skj->resume_id)->first();
                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $skj->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" onclick="candidateselect(event,this);" jobid="<?php echo $skj->id ?>" id="usercard_{{$skj->cid}}" log="{{$candidatehistory}}" resumename="<?php echo $resume->name; ?>" resumelink="<?php echo $resume->resume; ?>" stage="<?php echo $skj->stage ?>" exp="<?php echo $skj->experience ?>" curr_ctc="<?php echo $skj->current_ctc ?>" exp_ctc="<?php echo $skj->ctc ?>" notice="<?php echo $skj->notice_period ?>" curr_loc="<?php echo $skj->location ?>" pref_loc="<?php echo $skj->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($skj->photo == '' && ($skj->sex == '' || $skj->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($skj->photo == '' && $skj->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($skj->photo == '' && $skj->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $skj->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$skj->cid}}" user_id="{{$skj->id}}" stage="sourced">{{$skj->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" id="plus_{{$skj->id}}" onclick="openstatusupdateModal(event,this,'{{$skj->jname}}','{{$skj->id}}','{{$skj->cid}}','{{$skj->name}}','sourced','<?php echo $skj->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname" style="color: #2cc2a5;">{{$skj->jname}}</small><br>
                                                    <small class="candidatejobemail" >{{$skj->email}}</small><br>
                                                    <small class="candidatejobphone">{{$skj->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        <div class="card no" id="no_record" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 status-column" id="interested" style="margin-left: 10px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 10px;background:#81689d;padding-left: 20px;
    padding-right: 20px;
    padding-top: 7px;
    padding-bottom: 7px;
    color: white;
    border-radius: 5px;">112</small>&nbsp;&nbsp;Interested </p>
                                        @if(!$accepted_job->isEmpty())
                                        @foreach($accepted_job as $ack)

                                        <?php
                                        $resume = App\Resume::where('id', $ack->resume_id)->first();

                                        $timeslots = DB::connection('pephire')
                                            ->table('candidate_timeslots')
                                            ->select('interview_start_time', 'id')
                                            ->where('candidate_id', $ack->cid)
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatetimeslot = $candidatetimeslotoptions = "";
                                        foreach ($timeslots as $slots) {

                                            $dateTime = new DateTime($slots->interview_start_time);

                                            $candidatetimeslotoptions .= "<option value='" . $dateTime->format('d M y h:i a') . "'>" . $dateTime->format('d M y h:i a') . "</option>";
                                            $candidatetimeslot .= ($candidatetimeslot == "") ? $dateTime->format('d M y h:i a') : "," . $dateTime->format('d M y h:i a');
                                        }

                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $ack->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>

                                        <div class="card record" jobid="{{$ack->id}}" id="usercard_{{$ack->cid}}" onclick="candidateselect(event,this);" log="{{$candidatehistory}}" slots="{{$candidatetimeslot}}" slotsoptions="{{$candidatetimeslotoptions}}" stage="<?php echo $ack->stage ?>" exp="<?php echo $ack->experience ?>" curr_ctc="<?php echo $ack->current_ctc ?>" exp_ctc="<?php echo $ack->ctc ?>" notice="<?php echo $ack->notice_period ?>" curr_loc="<?php echo $ack->location ?>" pref_loc="<?php echo $ack->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($ack->photo == '' && ($ack->sex == '' || $ack->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($ack->photo == '' && $ack->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($ack->photo == '' && $ack->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $ack->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$ack->cid}}" user_id="{{$ack->id}}" stage="interested">{{$ack->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" onclick="openstatusupdateModal(event,this,'{{$ack->jname}}','{{$ack->id}}','{{$ack->cid}}','{{$ack->name}}','interested','<?php echo $ack->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$ack->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$ack->email}}</small><br>
                                                    <small class="candidatejobphone">{{$ack->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 status-column" id="slot_pending" style="margin-left: 10px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 12px;background:#e1e613;padding-left: 20px;
    padding-right: 20px;
    padding-top: 7px;
    padding-bottom: 7px;
    color: white;
    border-radius: 5px;">89</small>&nbsp;&nbsp; Slot Request Pending </p>
                                        @if(is_iterable($slot_pending) && !empty($slot_pending))
                                        @foreach($slot_pending as $pending_job)
                                        <?php
                                        $resume = App\Resume::where('id', $pending_job->resume_id)->first();

                                        $timeslots = DB::connection('pephire')
                                            ->table('candidate_timeslots')
                                            ->select('interview_start_time', 'id')
                                            ->where('candidate_id', $pending_job->cid)
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatetimeslot = $candidatetimeslotoptions = "";
                                        foreach ($timeslots as $slots) {
                                            $dateTime = new DateTime($slots->interview_start_time);

                                            $candidatetimeslotoptions .= "<option value='" . $dateTime->format('d M y h:i a') . "'>" . $dateTime->format('d M y h:i a') . "</option>";
                                            $candidatetimeslot .= ($candidatetimeslot == "") ? $dateTime->format('d M y h:i a') : "," . $dateTime->format('d M y h:i a');
                                        }

                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $pending_job->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" jobid="{{$pending_job->id}}" id="usercard_{{$pending_job->cid}}" onclick="candidateselect(event,this);" slots="{{$candidatetimeslot}}" slotsoptions="{{$candidatetimeslotoptions}}" log="{{$candidatehistory}}" stage="<?php echo $pending_job->stage ?>" exp="<?php echo $pending_job->experience ?>" curr_ctc="<?php echo $pending_job->current_ctc ?>" exp_ctc="<?php echo $pending_job->ctc ?>" notice="<?php echo $pending_job->notice_period ?>" curr_loc="<?php echo $pending_job->location ?>" pref_loc="<?php echo $pending_job->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($pending_job->photo == '' && ($pending_job->sex == '' || $pending_job->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($pending_job->photo == '' && $pending_job->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($pending_job->photo == '' && $pending_job->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $pending_job->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$pending_job->cid}}" user_id="{{$pending_job->id}}" stage="slot_pending">{{$pending_job->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" onclick="openstatusupdateModal(event,this,'{{$pending_job->jname}}','{{$pending_job->id}}','{{$pending_job->cid}}','{{$pending_job->name}}','slot_pending','<?php echo $pending_job->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$pending_job->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$pending_job->email}}</small><br>
                                                    <small class="candidatejobphone">{{$pending_job->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 status-column" id="scheduled" style="margin-left: 10px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 10px;background:#ec9229;padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
    padding-bottom: 5px;
    color: white;
    border-radius: 5px;">12</small> &nbsp;&nbsp;Interview Scheduled</p>
                                        @if(!$scheduled->isEmpty())
                                        @foreach($scheduled as $scheduled_job)

                                        <?php
                                        $resume = App\Resume::where('id', $scheduled_job->resume_id)->first();
                                        $timeslots = DB::connection('pephire')
                                            ->table('candidate_timeslots')
                                            ->select('interview_start_time', 'id')
                                            ->where('candidate_id', $scheduled_job->cid)
                                            ->get();
                                        //print_r($timeslots);

                                        $candidatetimeslot = $candidatetimeslotoptions = "";
                                        foreach ($timeslots as $slots) {
                                            $dateTime = new DateTime($slots->interview_start_time);
                                            $candidatetimeslotoptions .= "<option value='" . $dateTime->format('d M y h:i a') . "'>" . $dateTime->format('d M y h:i a') . "</option>";
                                            $candidatetimeslot .= ($candidatetimeslot == "") ? $dateTime->format('d M y h:i a') : "," . $dateTime->format('d M y h:i a');
                                        }

                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $scheduled_job->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        $candidateIds = App\CandidateTimeslots::where('user_id', auth()->user()->id)->where('hasAllotted', 1)->where('candidate_id', $scheduled_job->cid)->first();
                                        if ($candidateIds) {
                                            $interviewStart_Time = Carbon\Carbon::parse($candidateIds->interview_start_time);

                                            // Format date as "d F y" (e.g., "11 May 23")
                                            $scheduled_Date = $interviewStart_Time->format('d F y');
                                            $interviewrName = $candidateIds->interviewer_name;

                                            // Format time as "h:i A" (e.g., "12:00 PM")
                                            $scheduled_Time = $interviewStart_Time->format('h:i A');
                                        } else {
                                            $scheduled_Date = '';
                                            $scheduled_Time = '';
                                            $interviewrName = '';
                                        }

                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" jobid="{{$scheduled_job->id}}" id="usercard_{{$scheduled_job->cid}}" onclick="candidateselect(event,this);" log="{{$candidatehistory}}" interviewername="<?php echo $interviewrName ?>" round="Technical Interview" link="Teams meeting" scheduleddate="<?php echo $scheduled_Date; ?>" scheduledtime="<?php echo $scheduled_Time; ?>" slots="{{$candidatetimeslot}}" slotoptions="{{$candidatetimeslotoptions}}" stage="<?php echo $scheduled_job->stage ?>" exp="<?php echo $scheduled_job->experience ?>" curr_ctc="<?php echo $scheduled_job->current_ctc ?>" exp_ctc="<?php echo $scheduled_job->ctc ?>" notice="<?php echo $scheduled_job->notice_period ?>" curr_loc="<?php echo $scheduled_job->location ?>" pref_loc="<?php echo $scheduled_job->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($scheduled_job->photo == '' && ($scheduled_job->sex == '' || $scheduled_job->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($scheduled_job->photo == '' && $scheduled_job->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($scheduled_job->photo == '' && $scheduled_job->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $scheduled_job->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename" candidateid="{{$scheduled_job->cid}}" user_id="{{$scheduled_job->id}}" stage="scheduled">{{$scheduled_job->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" onclick="openstatusupdateModal(event,this,'{{$scheduled_job->jname}}','{{$scheduled_job->id}}','{{$scheduled_job->cid}}','{{$scheduled_job->name}}','scheduled','<?php echo $scheduled_job->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$scheduled_job->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$scheduled_job->email}}</small><br>
                                                    <small class="candidatejobphone">{{$scheduled_job->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 status-column" id="missed" style="margin-left: 10px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 10px;background:#1ec9c9;padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
    padding-bottom: 5px;
    color: white;
    border-radius: 5px;">1</small>&nbsp;&nbsp;Missed Interview </p>
                                        @if(!$missed_jobs->isEmpty())
                                        @foreach($missed_jobs as $msj)

                                        <?php
                                        $resume = App\Resume::where('id', $msj->resume_id)->first();
                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $msj->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" jobid="{{$msj->id}}" id="usercard_{{$msj->cid}}" onclick="candidateselect(event,this);" log="{{$candidatehistory}}" stage="<?php echo $msj->stage ?>" exp="<?php echo $msj->experience ?>" curr_ctc="<?php echo $msj->current_ctc ?>" exp_ctc="<?php echo $msj->ctc ?>" notice="<?php echo $msj->notice_period ?>" curr_loc="<?php echo $msj->location ?>" pref_loc="<?php echo $msj->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($msj->photo == '' && ($msj->sex == '' || $msj->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($msj->photo == '' && $msj->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($msj->photo == '' && $msj->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $msj->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$msj->cid}}" user_id="{{$msj->id}}" stage="missed">{{$msj->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" onclick="openstatusupdateModal(event,this,'{{$msj->jname}}','{{$msj->id}}','{{$msj->cid}}','{{$msj->name}}','missed','<?php echo $msj->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$msj->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$msj->email}}</small><br>
                                                    <small class="candidatejobphone">{{$msj->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 status-column" id="completed" style="margin-left: 10px;">
                                        <p class="text-left"><small class="cardcount" style="font-size: 10px;background:#6d2932d1;padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
    padding-bottom: 5px;
    color: white;
    border-radius: 5px;">1</small>&nbsp;&nbsp; Interview Completed </p>
                                        @if(!$completed_jobs->isEmpty())
                                        @foreach($completed_jobs as $cjs)
                                        <?php
                                        $resume = App\Resume::where('id', $cjs->resume_id)->first();

                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $cjs->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" jobid="{{$cjs->id}}" id="usercard_{{$cjs->cid}}" onclick="candidateselect(event,this);" log="{{$candidatehistory}}" stage="<?php echo $cjs->stage ?>" exp="<?php echo $cjs->experience ?>" curr_ctc="<?php echo $cjs->current_ctc ?>" exp_ctc="<?php echo $cjs->ctc ?>" notice="<?php echo $cjs->notice_period ?>" curr_loc="<?php echo $cjs->location ?>" pref_loc="<?php echo $cjs->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($cjs->photo == '' && ($cjs->sex == '' || $cjs->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($cjs->photo == '' && $cjs->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($cjs->photo == '' && $cjs->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $cjs->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$cjs->cid}}" user_id="{{$cjs->id}}" stage="completed">{{$cjs->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" onclick="openstatusupdateModal(event,this,'{{$cjs->jname}}','{{$cjs->id}}','{{$cjs->cid}}','{{$cjs->name}}','completed','<?php echo $skj->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$cjs->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$cjs->email}}</small><br>
                                                    <small class="candidatejobphone">{{$cjs->phone}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 status-column" id="selected" style="margin-left: 10px;">
                                        <p class="text-left"> <small class="cardcount" style="font-size: 10px;background:#2cc2a5;padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
    padding-bottom: 5px;
    color: white;
    border-radius: 5px;">122</small>&nbsp;&nbsp;Selected</p>
                                        @if(!$selected_job->isEmpty())
                                        @foreach($selected_job as $cks)
                                        <?php
                                        $resume = App\Resume::where('id', $cks->resume_id)->first();

                                        $logs = DB::connection('pephire')
                                            ->table('candidate_history')
                                            ->select('stage', 'comment', 'created_at')
                                            ->where('candidate_id', $cks->cid)
                                            ->orderBy('id', 'desc')
                                            ->get();
                                        //print_r($timeslots);
                                        $candidatehistory = "";
                                        foreach ($logs as $log) {
                                            $dateTime = new DateTime($log->created_at);
                                            $candidatehistory .= "<p><small><b>" . $log->stage . " : </b></small>" . $log->comment . "<small style='float:right;color: white;'>" . $dateTime->format('d M y h:i a') . "</small></p>";
                                        }
                                        ?>
                                        <div class="card record" onclick="candidateselect(event,this);" jobid="{{$cks->id}}" id="usercard_{{$cks->cid}}" log="{{$candidatehistory}}" stage="<?php echo $cks->stage ?>" exp="<?php echo $cks->experience ?>" curr_ctc="<?php echo $cks->current_ctc ?>" exp_ctc="<?php echo $cks->ctc ?>" notice="<?php echo $cks->notice_period ?>" curr_loc="<?php echo $cks->location ?>" pref_loc="<?php echo $cks->preffered_location ?>">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    @if ($cks->photo == '' && ($cks->sex == '' || $cks->sex == 'None'))
                                                    <img src="{{ url('/') }}/assets/images/candiate-img.png" height="auto" width="80px">
                                                    @elseif($cks->photo == '' && $cks->sex =='Male')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/male-user.png">
                                                    @elseif($cks->photo == '' && $cks->sex =='Female')
                                                    <img class="rounded-circle" src="{{ url('/') }}/assets/images/woman.png">
                                                    @else
                                                    <img class="rounded-circle" src="{{ asset('storage/' . $cks->photo) }}">
                                                    @endif
                                                </div>
                                                <div class="col-lg-7 text-left candidatename " candidateid="{{$cks->cid}}" stage="contacted" user_id="{{$cks->id}}">{{$cks->name}}</div>
                                                <div class="col-lg-1"><i class="fa fa-plus" id="plus_{{$cks->id}}" onclick="openstatusupdateModal(event,this,'{{$cks->jname}}','{{$cks->id}}','{{$cks->cid}}','{{$cks->name}}','selected','<?php echo $cks->status; ?>');"></i></div>
                                                <div class="col-lg-12 text-left" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$cks->jname}}</small><br>
                                                    <small class="candidatejobemail">{{$cks->email}}</small><br>
                                                    <small class="candidatejobphone">{{$cks->phone}}</small>
                                                </div>
                                            </div>
                                            <!--<div style="display:none;" id="hiddenbtndiv_{{$cks->id}}" class="hidebuttonsdivision">
                                                <button class="ivsubutton" onclick="openselectinterviewerModal(event,'{{$cks->jname}}','{{$cks->id}}','{{$cks->cid}}','{{$cks->name}}');">Interviewer Details</button>
                                                <br><button class="ivsubutton" onclick="openstatusupdateModal(event,'{{$cks->jname}}','{{$cks->id}}','{{$cks->cid}}','{{$cks->name}}');">Status Update</button>
                                            </div>-->
                                        </div>
                                        @endforeach


                                        @endif
                                        <div class="card no" style="position: absolute;top:-9999px;left:-9999px;">
                                            <div class="row">
                                                <p>No records</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>