@if(is_iterable($scheduled_slots) && !empty($scheduled_slots))
@foreach($scheduled_slots as $scheduled_job)


<?php

$slots_scheduled = DB::table('shortlisted_candidates')
	->select(
		'candidates.name',
		'jobs.name as jname',
		'jobs.id',
		'candidate_timeslots.hasAllotted',
		'candidate_timeslots.id as sid',
		'candidates.id as ciid',
		'candidate_timeslots.interview_date',
		'candidate_timeslots.interview_start_time'
	)
	->join('candidates', 'shortlisted_candidates.candidate_id', '=', 'candidates.id')
	->join('candidate__jobs', 'candidate__jobs.candidate_id', '=', 'candidates.id')
	->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
	->join('candidate_timeslots', 'candidate_timeslots.job_id', '=', 'jobs.id')
	->where('candidates.organization_id', 1)
	->where('candidate__jobs.slot_request', '1')
	->where('candidates.id', $scheduled_job['cid'])
	->where('candidate_timeslots.candidate_id', $scheduled_job['cid'])
	->where('candidate_timeslots.email', $scheduled_job['int_email'])
	->where('hasAllotted', 1)
	->groupBy('ciid')
	// Specify the column for distinct
	->get();

$slots_scheduled = json_decode($slots_scheduled, true);


$formattedStrings2 = [];

foreach ($slots_scheduled as $itemss) {
	// Format the interview start time as "hha" (e.g., "11am")
	$interviewTime1 = date('ha', strtotime($itemss['interview_start_time']));

	// Format the interview_date as "YYYY-MM-DDTHH:MM:SS"
	$interviewDate1 = date('Y-m-d\TH:i:s', strtotime($itemss['interview_start_time']));

	// Additional information
	$additionalInfo1 = "#80dbc9**white**1**" . date('YmdH', strtotime($itemss['interview_start_time'])) . "**" . $itemss['sid'];

	// Day and time format
	$dayAndTime1 = date('l, M j H:i', strtotime($itemss['interview_start_time']));

	$formattedString2 = "{$itemss['name']} - $interviewTime1 ,{$itemss['jname']}**$interviewDate1**$additionalInfo1**$dayAndTime1";
	$formattedStrings2[] = $formattedString2;
}

$result2 = implode("~", $formattedStrings2);
$interviewTimestamp = strtotime($interviewDate1);

							// Get the current timestamp
							$currentTimestamp = time();

							// Calculate the time difference in seconds
							$timeDifference = $interviewTimestamp - $currentTimestamp;

							// Initialize variables for the result
							$results = '';

							// Calculate the time remaining in days, hours, or minutes
							$days = floor($timeDifference / (60 * 60 * 24));
							$hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
							$minutes = floor(($timeDifference % (60 * 60)) / 60);

							if ($days > 0) {
								$results = "$days days";
							} elseif ($hours > 0) {
								$results = "$hours hours";
							} else {
								$results = "$minutes minutes";
							}

?>

<div class="row requested-users" id="user_<?php echo $scheduled_job['cid']; ?>" onclick="showdetail('<?php echo $scheduled_job['name']; ?>','<?php echo $scheduled_job['jname']; ?>','<?php echo $scheduled_job['experience']; ?> years','<?php echo $scheduled_job['phone']; ?>','<?php echo $scheduled_job['email']; ?>','Msc,MCA,BE','<?php echo $scheduled_job['mandatory_skills']; ?>','<?php echo $scheduled_job['location']; ?>','<?php echo $scheduled_job['vacant_positions']; ?>','<?php echo $scheduled_job['offered_ctc']; ?>','<?php echo $scheduled_job['min_experience']; ?> - <?php echo $scheduled_job['max_experience']; ?>','<?php echo $scheduled_job['cid']; ?>','<?php echo $scheduled_job['description']; ?>')" userid="<?php echo $scheduled_job['cid']; ?>" calltype="Scheduled" slots="<?php echo $result2  ?>">
	<div class="col-lg-1"></div>
	<div class="col-lg-9"><span class="uname">{{$scheduled_job['name']}}</span><br><small class="jd">{{$scheduled_job['jname']}}</small></div>
	<div class="col-lg-1">
		<div class="tooltipcus"><i class="fa fa-clock-o" style="margin-top: 6px;"></i>
			<span class="tooltiptextcus"><small style="line-height: 10px;">{{$results}}</small></span>
		</div>
	</div>
</div>


@endforeach
@endif