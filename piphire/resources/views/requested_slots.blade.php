
							@if(is_iterable($slot_pending) && !empty($slot_pending))
							@foreach($slot_pending as $pending_job)
							<?php

							$slots_requested = DB::table('shortlisted_candidates')
								->select(
									'candidates.name',
									'jobs.name as jname',
									'jobs.id',
									'candidate_timeslots.hasAllotted',
									'candidate_timeslots.id as sid',
									'candidate_timeslots.interview_date',
									'candidate_timeslots.interview_start_time'
								)
								->join('candidates', 'shortlisted_candidates.candidate_id', '=', 'candidates.id')
								->join('candidate__jobs', 'candidate__jobs.candidate_id', '=', 'candidates.id')
								->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
								->join('candidate_timeslots', 'candidate_timeslots.job_id', '=', 'jobs.id')
								->where('candidates.organization_id', 1)
								->where('candidate__jobs.slot_request', '0')
								->where('candidates.id', $pending_job['cid'])
								->where('candidate_timeslots.candidate_id', $pending_job['cid'])
								
								// Specify the column for distinct
								->get();

							$slots_requested = json_decode($slots_requested, true);










							$formattedStrings1 = [];

							foreach ($slots_requested as $items) {
								// Format the interview start time as "hha" (e.g., "11am")
								$interviewTime = date('ha', strtotime($items['interview_start_time']));

								// Format the interview_date as "YYYY-MM-DDTHH:MM:SS"
								$interviewDate = date('Y-m-d\TH:i:s', strtotime($items['interview_start_time']));

								// Additional information
								$additionalInfo = "#80dbc9**white**1**" . date('YmdH', strtotime($items['interview_start_time'])) . "**" . $items['sid'];

								// Day and time format
								$dayAndTime = date('l, M j H:i', strtotime($items['interview_start_time']));

								$formattedString1 = "{$items['name']} - $interviewTime ,{$items['jname']}**$interviewDate**$additionalInfo**$dayAndTime";
								$formattedStrings1[] = $formattedString1;
							}

							$result1 = implode("~", $formattedStrings1);


							$name = $pending_job['name'];
							$cid = $pending_job['cid'];
							?>
							<div class="row requested-users" id="user_{{$cid}}" onclick="showdetail('{{$name}}','<?php echo $pending_job['jname']; ?>','<?php echo $pending_job['experience']; ?> years','<?php echo $pending_job['phone']; ?>','<?php echo $pending_job['email']; ?>','Msc,MCA,BE','<?php echo $pending_job['mandatory_skills']; ?>','<?php echo $pending_job['location']; ?>','<?php echo $pending_job['vacant_positions']; ?>','<?php echo $pending_job['offered_ctc']; ?>','<?php echo $pending_job['min_experience']; ?> - <?php echo $pending_job['max_experience']; ?>','{{$cid}}','<?php echo $pending_job['description']; ?>')" slots="<?php echo $result1; ?>" userid="{{$cid}}" calltype="Requested">
								<div class="col-lg-1"></div>
								<div class="col-lg-9"><span class="uname">{{$pending_job['name']}}</span><br><small class="jd">{{$pending_job['jname']}}</small></div>
								<div class="col-lg-1"></div>
							</div>
							@endforeach
							@endif