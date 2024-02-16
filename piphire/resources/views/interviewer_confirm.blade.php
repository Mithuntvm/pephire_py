<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{url('/')}}/css/slotselection.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="{{url('/')}}/assets/dist/index.global.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
	<style>
		/* The side navigation menu */
		.sidebar {
			margin: 15px;
			padding: 0;
			width: 100%;
			background-color: #ffffff;
			height: 100vh;
			overflow: auto;
			border-radius: 4%;
		}

		/* Sidebar links */
		.sidebar a {
			display: block;
			color: #9b9b9bc7;
			padding: 10px;
			text-decoration: none;
			font-size: 17px;
			font-weight: 600;
		}

		.sidebar span {
			font-size: 28px;
		}

		.scrollable-content {
			max-height: calc(100vh - 60px);
			/* Adjust as needed */
			/* overflow-y: auto; */
		}

		/* Active/current link */
		/*.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}*/

		/* Links on mouse-over */
		.sidebar a:hover:not(.active) {
			/* background-color: #555; */
			color: black;
		}

		/* Page content. The value of the margin-left property should match the value of the sidebar's width property */
		div.content {
			margin-left: 200px;
			padding: 1px 16px;
			height: 1000px;
		}

		/* On screens that are less than 700px wide, make the sidebar into a topbar */
		@media screen and (max-width: 700px) {
			.sidebar {
				width: 100%;
				height: auto;
				position: relative;
			}

			.sidebar a {
				float: left;
			}

		}

		/* On screens that are less than 400px, display the bar vertically, instead of horizontally */
		@media screen and (max-width: 400px) {
			.sidebar a {
				text-align: center;
				float: none;
			}
		}

		body {
			background: #ebebfa;
		}

		#sidebar-section {
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.text-left {
			text-align: left;
			color: #9b9b9bc7;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<!-- The sidebar -->
		<div class="row">
			<!--<div class="col-lg-2" id="sidebar-section">   ***
                <div class="sidebar">
                    <a class="navbar-brand" href="">
                        <img class="brand-logo" alt="modern admin logo"
                            src="http://pepdemo.westindia.cloudapp.azure.com/assets/images/logo/logo.png">
                        <h3 class="brand-text"></h3>
                    </a> ***-->
			<!-- <a href="#dashboard"><span class="fa fa-dashboard"></span>&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a> -->
			<!--<a href="#sourcing"><span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;&nbsp;Sourcing</a>
                    <a href="#calander"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;calander</a>-->
			<!-- <a href="#calander"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;Calander</a>
			  <a href="#settings"><span class="fa fa-cog"></span>&nbsp;&nbsp;&nbsp;&nbsp;Settings</a> -->
			<!-- </div>
            </div>-->

			<!--<div class="col-lg-10">
	
                <div class="container mt-5">-->

			<div class="headerbar">
				<a class="navbar-brand" href="">
					<img class="brand-logo" alt="modern admin logo" src="http://pepdemo.westindia.cloudapp.azure.com/assets/images/logo/logo.png">
					<h3 class="brand-text"></h3>
				</a>
			</div>

			<div class="col-lg-12" style="display:flex;position: absolute;top: 72px;">

				<div class="col-lg-2" id="userlist-container">

					<div>
						<div class="input-group">
							<input class="form-control" type="search" id="example-search-input" placeholder="Search candidate/JD" onkeyup="mysearchFunction()">
							<span class="input-group-append">

							</span>
						</div>
					</div>

					<div id="requesterslot">
						<div class="row slotheader" id="requestedslotheader">
							<div class="col-md-1">
								<i class="fa fa-square"></i>
							</div>
							<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Requested Slots</big></div>
						</div>
						<div id="requestedusers-container">






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
							<div class="row requested-users  " id="user_{{$cid}}" onclick="showdetail('{{$name}}','<?php echo $pending_job['jname']; ?>','<?php echo $pending_job['experience']; ?> years','<?php echo $pending_job['phone']; ?>','<?php echo $pending_job['email']; ?>','Msc,MCA,BE','<?php echo $pending_job['mandatory_skills']; ?>','<?php echo $pending_job['location']; ?>','<?php echo $pending_job['vacant_positions']; ?>','<?php echo $pending_job['offered_ctc']; ?>','<?php echo $pending_job['min_experience']; ?> - <?php echo $pending_job['max_experience']; ?>','{{$cid}}')" slots="<?php echo $result1; ?>" userid="{{$cid}}" calltype="Requested" jd="<?php echo $pending_job['description']; ?>">
								<div class="col-lg-1"></div>
								<div class="col-lg-9"><span class="uname">{{$pending_job['name']}}</span><br><small class="jd">{{$pending_job['jname']}}</small></div>
								<div class="col-lg-1"></div>
							</div>
							@endforeach
							@endif
						</div>
					</div>

					<hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">

					<div id="requesterslot">
						<div class="row slotheader" id="requestedslotheader">
							<div class="col-md-1">
								<i class="fa fa-square"></i>
							</div>
							<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Scheduled Slots</big></div>
						</div>
						<div id="Schedulededusers-container">
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

							// The provided interview start time

							// Convert the interview start time to a Unix timestamp
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

							// Output the result
							?>



							<div class="row requested-users" id="user_<?php echo $scheduled_job['cid']; ?>" onclick="showdetail('<?php echo $scheduled_job['name']; ?>','<?php echo $scheduled_job['jname']; ?>','<?php echo $scheduled_job['experience']; ?> years','<?php echo $scheduled_job['phone']; ?>','<?php echo $scheduled_job['email']; ?>','Msc,MCA,BE','<?php echo $scheduled_job['mandatory_skills']; ?>','<?php echo $scheduled_job['location']; ?>','<?php echo $scheduled_job['vacant_positions']; ?>','<?php echo $scheduled_job['offered_ctc']; ?>','<?php echo $scheduled_job['min_experience']; ?> - <?php echo $scheduled_job['max_experience']; ?>','<?php echo $scheduled_job['cid']; ?>')" userid="<?php echo $scheduled_job['cid']; ?>" calltype="Scheduled" slots="<?php echo $result2;  ?>" jd="<?php echo $scheduled_job['description']; ?>">
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
						</div>
					</div>
					<hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">

					<div id="requesterslot">
						<div class="row slotheader" id="requestedslotheader">
							<div class="col-md-1">
								<i class="fa fa-square"></i>
							</div>
							<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Finalized Candidates</big></div>
						</div>
						<div id="completedusers-container">
							@if(is_iterable($completed_slots) && !empty($completed_slots))
							@foreach($completed_slots as $completed_job)


							<div class="row requested-users <?php
															if ($completed_job['stc'] === 'rejected') {
																echo 'rejecteduser';
															} elseif ($completed_job['stc'] === 'accepted') {
																echo 'accepteduser';
															}
															?>" id="user_<?php echo $completed_job['cid']; ?>" onclick="showdetail('<?php echo $completed_job['name']; ?>','<?php echo $completed_job['jname']; ?>','<?php echo $completed_job['experience']; ?> years','<?php echo $completed_job['phone']; ?>','<?php echo $completed_job['email']; ?>','Msc,MCA,BE','<?php echo $completed_job['mandatory_skills']; ?>','<?php echo $completed_job['location']; ?>','<?php echo $completed_job['vacant_positions']; ?>','<?php echo $completed_job['offered_ctc']; ?>','<?php echo $completed_job['min_experience']; ?> - <?php echo $completed_job['max_experience']; ?>','<?php echo $completed_job['cid']; ?>')" userid="<?php echo $completed_job['cid']; ?>" calltype="Completed" status="<?php echo $completed_job['stc']; ?>" feedback="<?php echo $completed_job['feedback']; ?>">

								<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
								<div class="col-lg-9"><span class="uname">{{$completed_job['name']}}</span><br><small class="jd">{{$completed_job['jname']}}</small></div>
								<div class="col-lg-1">
									<div class="tooltipcus"><i class="fa fa-bell" style="margin-top: 6px;"></i>
										<span class="tooltiptextcus"><small style="line-height: 10px;">Decision Pending</small></span>
									</div>
								</div>
							</div>
							@endforeach
							@endif


						</div>
					</div>
					<hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">

				</div>

				<div class="col-lg-3" id="details-container" style="display:none;">
					<div class="row" style="margin-left:0px;margin-right:0px;">
						<div class="col-lg-10" id="detail-titlediv"><span class="details-usertitle">Loga Ragul</span></div>
						<div class="col-lg-2"><i class="fa fa-times pull-right" onclick="closedetail();"></i></div>
					</div>
					<div id="jobdescription">

						<pre style="color:grey;font-family: var(--bs-body-font-family);font-size: 9px;margin-bottom: 4px;margin-top: 3px;font-weight: 600;" class="dynamicjobtitle">Senior IOs Developer</pre>
						<div style="margin-top: 0px;border-bottom: 1px solid gainsboro;padding-bottom: 0px;"><span style="font-size:8px;">Job Description</span><span class="pull-right"><i class="fa fa-download" onclick="CreateTextFile();"></i></span></div>
						<table class="table table-bordered" style="font-size:13px;margin-top:9px;" id="jdtable">
							<colgroup>
								<col style="width:35%">
								<col style="width:65%">
							</colgroup>
							<tr>
								<td><b><small class="text-grey">Designation</small></b></td>
								<td><small class="text-grey dynamicjobtitle">Senior iOs Developer</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Qualification</small></b></td>
								<td><small class="text-grey jobqualification">Msc,MCA,BE</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Critical Skills</small></b></td>
								<td><small class="text-grey jobskills">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Location</small></b></td>
								<td><small class="text-grey joblocation">Ahmedabad</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Position</small></b></td>
								<td><small class="text-grey jobposition">1</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Cost to company</small></b></td>
								<td><small class="text-grey jobcost">As per market Standard</small></td>
							</tr>
							<tr>
								<td><b><small class="text-grey">Experiance</small></b></td>
								<td><small class="text-grey jobexperience">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</small></td>
							</tr>
						</table>

						<hr style="margin-top: 2rem;margin-bottom: 7px;">
					</div>

					<div id="Candidate_details">
						<big class="details-usertitle">Loga Ragul</big>
						<small class="userexperience"><span>Exp:&nbsp;</span><span class="candidateexperience">5 years</span></small>
						<small class="usermobile"><span>Ph:&nbsp;</span><span class="candidatephone">91 8475734874</span></small>
						<small class="useremail"><span>Email:&nbsp;</span><span class="candidateemail">logaragul37@gmail.com</span></small>
						<a href="{{ url('/downloadResume/fff6f576-5de5-11ee-8e57-000d3af17cb8') }}" target="_blank"><button class="downloadresume">Download Resume</button></a><br>
					</div>
					<hr style="width: 91%;margin-left: auto;margin-right: auto;color: #6a6666;">

					<div id="detailsdynamicsection">
						<P class="text-grey" id="detailsdynamictitle">Selected Slots</p>
						<div id="slotslist">
						</div>
						<div class="text-grey" id="detailsdynamiccontent"></div>
					</div>

				</div>
				<?php
				$formattedStrings = [];

				foreach ($selected_slots as $item) {
					$indianTime = date('h:i a', strtotime($item['interview_start_time']));
					$interviewTime = date('H:i:s', strtotime($item['interview_start_time']));
					$interviewerDate = date('Ymd', strtotime($item['interview_date']));
					$railwayTime = date('H:i', strtotime($item['interview_start_time']));
					$formattedString = "{$item['name']} - {$indianTime},{$item['jname']}**{$item['interview_date']}T{$interviewTime}**#9747ff82**white**{$railwayTime}**{$interviewerDate}**{$item['sid']}";
					$formattedStrings[] = $formattedString;
				}

				$result = implode("~", $formattedStrings);
				?>
				<div class="col-lg-10" id="calander-container">

					<div class="scrollable-content">
						<div class="">
							<div id='calendar'></div>
							<input type="hidden" name="presentevents" id="presentevents" value="<?php echo $result ?>">
						</div>
					</div>

				</div>

			</div>


			<!-- Modal -->
			<div class="modal fade" id="jdModal" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div><button class="pull-right modalclsbtn">X</button></div>
						<div class="modal-body">
							<center><b><span id="modaljobtitle">Senior Java Developer</span></b></center><br>
							<b><u>Job Description</u></b>
							<p id="modaldescription" class="download-content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="scheduleslotModal" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content" style="width: 325px;margin-left: auto;">
						<div><button class="pull-right scheduleslotclsbtn">X</button></div>
						<div class="modal-body">
							<big><b id="sdname">Jay R</b></big><br>
							<small id="sdjd">IOS Deveoloper</small><br>
							<small id="sdround">Round 1:Technical Interview</small><br>
							<small id="sdslot">3 september 2023 11.30-12.30</small><br>
							<div class="row" style="padding: 10px 0px;">
								<div class="col-lg-8"><button class="joinbtn">Join</button></div>
								<div class="col-lg-1"></div>
								<div class="col-lg-3"></div>
							</div>
							<span class="fa fa-map-marker"></span>&nbsp;&nbsp;<small>Zoom Meeting</small><br>
							<span class="fa fa-link" style="font-size: 12px;" ></span>&nbsp;&nbsp;<small><a href="https://meet.google.com/" id="sdmeetlink">https://meet.google.com</a>/</small><br>
							<span class="fa fa-user" style="font-size: 12px;"></span>&nbsp;&nbsp;<small>Organizer</small>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			//foreach($(".fc-event") as vall)
			function addtitle() {
				$(".fc-event").each(function() {
					$(this).attr("title", $(this).text());
				});
			}
			addtitle();

			$(".requested-users").click(function() {
				var slots = $(this).attr("slots");
				var userid = $(this).attr("userid");
				var type = $(this).attr("calltype");

				rendercalander(slots, userid, type);
				addtitle();
				$(".requested-users").removeClass("active");
				$(this).addClass("active");
			});

			$("#jdtable").click(function() {
				$("#jdModal").removeClass("fade");
				$("#jdModal").show();
				$("#modaljobtitle").text($("#jdtable").attr("jobtitle"));
				$("#modaldescription").text($("#jdtable").attr("jd"));
			});

			$(".modalclsbtn").click(function() {
				$("#jdModal").addClass("fade");
				$("#jdModal").hide();
			});

			$(".scheduleslotclsbtn").click(function() {
				$("#scheduleslotModal").addClass("fade");
				$("#scheduleslotModal").hide();
			});
		});

		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			//alert(23234);
			var presentevents = document.getElementById('presentevents').value;
			var eventsplit = presentevents.split("~");
			const presenteventsarr = [];
			for (var j = 0; j < eventsplit.length; j++) {
				var eventdetails = eventsplit[j].split("**");
				presenteventsarr[j] = {
					title: eventdetails[0],
					start: eventdetails[1],
					color: eventdetails[2],
					textColor: eventdetails[3],
					userid: eventdetails[4],
					slotid: eventdetails[6]
				};
			}
			//alert(presenteventsarr);
			events = presenteventsarr;
			var today = new Date();

			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'today,prev,next',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				eventTimeFormat: { // like '14:30:00'
					hour: '2-digit',
					minute: '2-digit',
					meridiem: true
				},
				initialDate: today,
				navLinks: true, // can click day/week names to navigate views
				selectMirror: true,
				height: 715,
				select: function(arg) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.addEvent({
							title: title,
							start: arg.start,
							end: arg.end,
							allDay: arg.allDay,
							userid: arg.userid
						})
					}
					calendar.unselect()
				},
				eventClick: function(arg) {
					console.log(JSON.stringify(arg.event));
					var userid = JSON.stringify(arg.event.extendedProps.userid.replace(/[^a-zA-Z0-9 ]/g, ""));
					userid = userid.replace(/['"]+/g, '');
					alert(userid)
				
					$.ajax({

						url: '/meeting_link/' + userid,
						dataType: 'json',

						type: 'POST',

						data: {

						
							_token: "{{ csrf_token() }}",

						},

						success: function(response) {

							console.log(response);

							alert(response);

							$("#sdname").html("Loga Ragul");

							$("#sdjd").html("PHP Developer");

							$("#sdround").html("Round 1:Technical Interview");

							$("#sdslot").html("3 september 2023 11.30-12.30");

							$("#sdmeetlink").html("https://meet.google.com");

							$("#sdmeetlink").attr("href", "https://meet.google.com");

						},

						error: function(response) {

							console.log('inside ajax error handler');

						}

					});


					$("#scheduleslotModal").removeClass("fade");
					$("#scheduleslotModal").show();

				},
				editable: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: events
			});

			calendar.render();
		});


		function rendercalander(slots, userid, type) {

			console.log(slots, userid, type, 'hgsdUDfygcsGfouhsGEIfgi')
			var calendarEl = document.getElementById('calendar');
			var presentevents = document.getElementById('presentevents').value;
			var presenteventsplit = presentevents.split("~");
			const eventdatetimelist = [];
			for (var j = 0; j < presenteventsplit.length; j++) {
				var eventdetails = presenteventsplit[j].split("**");
				eventdatetimelist.push(eventdetails[5]);
			}
			//alert(eventdatetimelist);
			var slotlistbuttons = ""; //To create slot buttons

			if (type == "Scheduled") {
				var slotsplit = slots.split("~");
				//alert(slotsplit);
				for (var lr = 0; lr < slotsplit.length; lr++) {
					//alert(slotsplit[lr]);
					var sloteventdetails = slotsplit[lr].split("**");
					slotlistbuttons += "<button class='slotscheduledbtn' disabled title='Slot already selected'>Time Scheduled : " + sloteventdetails[7] + "</button><br>"; //To create scheduled slot buttons
				}
			}

			allevents = (type == "Scheduled") ? slots : presentevents + "~" + slots;
			var eventsplit = allevents.split("~");
			const presenteventsarr = [];
			for (var j = 0; j < eventsplit.length; j++) {
				var eventdetails = eventsplit[j].split("**");

				if (eventdetails[2] == "#80dbc9" && eventdatetimelist.includes(eventdetails[5])) {
					eventdetails[2] = "#f97070";
					presenteventsarr[j] = {
						title: eventdetails[0],
						start: eventdetails[1],
						color: eventdetails[2],
						textColor: eventdetails[3],
						userid: eventdetails[4],
						slotid: eventdetails[6]
					};
					slotlistbuttons += "<button class='conflictbtn' disabled title='Slot already selected'>Time Scheduled : " + eventdetails[7] + "</button><br>"; //To create slot buttons
				} else {
					presenteventsarr[j] = {
						title: eventdetails[0],
						start: eventdetails[1],
						color: eventdetails[2],
						textColor: eventdetails[3],
						userid: eventdetails[4],
						slotid: eventdetails[6]
					};
				}

				if (eventdetails[2] == "#80dbc9" && !eventdatetimelist.includes(eventdetails[5])) {
					slotlistbuttons += "<button class='slotconformbtn' onclick='conformslot(" + userid + "," + eventdetails[6] + ")'>Time Requested : " + eventdetails[7] + "</button><br>"; //To create slot buttons
				}
			}
			//alert(presenteventsarr);
			events = presenteventsarr;

			$("#slotslist").html(slotlistbuttons);
			if (type == "Requested") {
				$("#detailsdynamictitle").html('Slots Requested');
				$("#detailsdynamiccontent").html('<button class="declinebtn" onclick="decline(' + userid + ')">Decline</button>');
			} else if (type == "Scheduled") {
				$("#detailsdynamictitle").html('Scheduled Slots');
				$("#detailsdynamiccontent").html('<button class="declinebtn" onclick="reshedule(' + userid + ')">Re-Schedule</button><button class="declinebtn" style="float:right;" onclick="decline(' + userid + ')">Decline</button>');
			} else if (type == "Completed") {
				var status = $("#user_" + userid).attr("status");
				var feedback = $("#user_" + userid).attr("feedback");
				if (status != "" && feedback != "") {
					$("#detailsdynamictitle").html('<big style="font-size: 12px;color: #1e0c0cbf;font-weight:600;">Result</big><br><h2>' + status + '</h2>');
					$('#slotslist').html('<big style="font-size: 12px;color: #1e0c0cbf;font-weight:600;">Feedback</big><textarea class="feedbacktextarea" name="feedback" rows="4" placeholder="Type Here..." disabled="disabled">' + feedback + '</textarea>');
					$("#detailsdynamiccontent").html('');
				} else {
					$("#detailsdynamictitle").html('Feedback for the Candidate');
					$('#slotslist').html('<textarea class="feedbacktextarea" name="feedback" rows="4" placeholder="Type Here..."></textarea>');
					$("#detailsdynamiccontent").html('<h6 style="font-size: 10px;font-weight: 600;">Candidate is</h6><button class="acceptbtn" onclick="accept(' + userid + ')">Accepted</button><button class="declinebtn" style="float:right;" onclick="reject(' + userid + ')">Rejected</button>');
				}
			}

			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'today,prev,next',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				eventTimeFormat: { // like '14:30:00'
					hour: '2-digit',
					minute: '2-digit',
					meridiem: true
				},
				initialDate: '2023-01-12',
				navLinks: true, // can click day/week names to navigate views
				selectMirror: true,
				height: 715,
				select: function(arg) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.addEvent({
							title: title,
							start: arg.start,
							end: arg.end,
							allDay: arg.allDay,
							userid: arg.userid,
							slotid: arg.slotid,
						})
					}
					calendar.unselect()
				},
				eventClick: function(arg) {
					/*if (confirm('Are you sure you want to delete this event?')) {
					  arg.event.remove()
					}*/
					console.log(JSON.stringify(arg.event));
					var color = JSON.stringify(arg.event.backgroundColor).replace(/[^a-zA-Z0-9 ]/g, "");
					var slotid = JSON.stringify(arg.event.extendedProps.slotid.replace(/[^a-zA-Z0-9 ]/g, ""));
					//alert(color);
					if (color == "f97070") {
						alert("Slot already booked,please select another slot");
					} else if (color == "80dbc9") {
						conformslot(userid, JSON.stringify(arg.event.extendedProps.slotid).replace(/[^a-zA-Z0-9 ]/g, ""));
					} else if (color == "9747ff82") {
						$("#scheduleslotModal").removeClass("fade");
						$("#scheduleslotModal").show();
					}

					//alert(JSON.stringify(arg.event.extendedProps.userid).replace(/[^a-zA-Z0-9 ]/g, ""));
					//alert(JSON.stringify(arg.event.extendedProps.slotid).replace(/[^a-zA-Z0-9 ]/g, ""));
				},
				editable: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: events
			});

			calendar.render();
		}

		function conformslot(userid, slotid) {
			if (confirm("Are you sure to conform the slot for the user")) {
				$.ajax({
					url: '/select_slot/' + userid,
					type: 'post',
					dataType: 'json',
					data: {
						slotid: slotid,

						_token: "{{ csrf_token() }}",
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(data) {
						console.log("Successfully fetched filtered candidates")
						if (data) {
							// Remove the deleted candidate from the list
							var allslotsarray = $("#user_" + userid).attr("slots").split("~");
							var selectedslot = "";
							for (var pr = 0; pr < allslotsarray.length; pr++) {
								//alert(allslotsarray[pr]);
								var slotdet = allslotsarray[pr].split("**");
								if (Number(slotid) == Number(slotdet[6])) {
									selectedslot += allslotsarray[pr].replace("#80dbc9", "#9747ff82");
								}
							}
							//alert(selectedslot);
							var presenteventsval = $("#presentevents").val();
							presenteventsvalfinal = presenteventsval + "~" + selectedslot;
							// console.log(userid, slotid,selectedslot, 'jkjhjjh jhgasjdg hjasg')

							$("#presentevents").val(presenteventsvalfinal);

							$("#user_" + userid).remove();
							$("#Schedulededusers-container").html(data.scheduled_slots);
							$("#details-container").hide();

							$("#details-container").html(data.detail);


							loadcalander();
						}
					},
					error: function(xhr, status, error) {
						console.log('Error:', error);
					}
				});
				//alert(userid+" "+slotid);

			}

		}

		function loadcalander() {
			var calendarEl = document.getElementById('calendar');
			var presentevents = document.getElementById('presentevents').value;
			var eventsplit = presentevents.split("~");
			const presenteventsarr = [];
			for (var j = 0; j < eventsplit.length; j++) {
				var eventdetails = eventsplit[j].split("**");
				presenteventsarr[j] = {
					title: eventdetails[0],
					start: eventdetails[1],
					color: eventdetails[2],
					textColor: eventdetails[3],
					userid: eventdetails[4],
					slotid: eventdetails[6]
				};
			}
			//alert(presenteventsarr);
			events = presenteventsarr;

			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'today,prev,next',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				eventTimeFormat: { // like '14:30:00'
					hour: '2-digit',
					minute: '2-digit',
					meridiem: true
				},
				initialDate: '2023-01-12',
				navLinks: true, // can click day/week names to navigate views
				selectMirror: true,
				height: 715,
				select: function(arg) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.addEvent({
							title: title,
							start: arg.start,
							end: arg.end,
							allDay: arg.allDay,
							userid: arg.userid
						})
					}
					calendar.unselect()
				},
				eventClick: function(arg) {
					/*if (confirm('Are you sure you want to delete this event?')) {
					  arg.event.remove()
					}*/
					console.log(JSON.stringify(arg.event));
					//alert(JSON.stringify(arg.event.extendedProps.userid));

					$("#scheduleslotModal").removeClass("fade");
					$("#scheduleslotModal").show();

				},
				editable: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: events
			});

			calendar.render();
		}

		function closedetail() {
			$("#details-container").hide();
			$(".requested-users").removeClass("active");
			loadcalander();
		}

		function showdetail(username, jobtitle, experience, phone, email, Qualification, skills, location, position, cost, experience1, cid, jd) {
			$("#details-container").show();
			//alert(experience+" "+phone+" "+email);
			$(".details-usertitle").html(username);
			$(".dynamicjobtitle").html(jobtitle);
			$(".candidateexperience").html(experience);
			$(".candidatephone").html(phone);
			$(".candidateemail").html(email);
			$(".jobqualification").html(Qualification);
			$(".jobskills").html(skills);
			$(".joblocation").html(location);
			$(".jobposition").html(position);
			$(".jobcost").html(cost);
			$(".jobexperience").html(experience1);
			$("#jdtable").attr("jd", $("#user_" + cid).attr("jd"));
			$("#jdtable").attr("jobtitle", jobtitle);
		}

		function mysearchFunction() {
			var input, filter, ul, li, a, i, txtValue, txtValue1, sm;
			input = document.getElementById("example-search-input");
			filter = input.value.toUpperCase();
			ul = document.getElementById("userlist-container");
			//li = ul.getElementsByTagName("li");
			li = ul.getElementsByClassName("requested-users");
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("span")[0];
				sm = li[i].getElementsByTagName("small")[0];
				txtValue = a.textContent || a.innerText;
				txtValue1 = sm.textContent || sm.innerText;
				if ((txtValue.toUpperCase().indexOf(filter) > -1) || (txtValue1.toUpperCase().indexOf(filter) > -1)) {
					li[i].style.display = "";
				} else {
					li[i].style.display = "none";
				}

				/*if (txtValue1.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				} else {
					li[i].style.display = "none";
				}*/
			}
		}

		function accept(uid) {
			if (confirm("Are you sure to Accept?")) {
				var feedbackContent = $(".feedbacktextarea").val();
				$.ajax({
					url: '/accept_candidate/' + uid,
					type: 'post',
					data: {
						feedback: feedbackContent
					}, // Pass feedback as data

					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response) {
						if (response.message) {

							$("#detailsdynamictitle").html("<big style='font-size: 12px;color: #1e0c0cbf;font-weight:600;'>Result</big><br><h2>ACCEPTED</h2>");
							$("#slotslist").prepend("<big style='font-size: 12px;color: #1e0c0cbf;font-weight:600;'>Feedback</big>");
							$("#detailsdynamiccontent").html("");
							$(".feedbacktextarea").attr("disabled", "disabled");
						}
					},
					error: function(xhr, status, error) {
						console.log('Error:', error);
					}
				});
			}
		}

		function decline(uid) {
			console.log(uid, 'hjhjhhghhthhgru')
			if (confirm("Are you sure to Decline?")) {

				$.ajax({
					url: '/delete_candidate/' + uid,
					type: 'get',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response) {
						if (response.message) {
							console.log(response.message, 'hjghj', uid)

							// Remove the deleted candidate from the list
							$("#user_" + uid).remove();
							$("#details-container").hide();

						}
					},
					error: function(xhr, status, error) {
						console.log('Error:', error);
					}
				});
			}
		}

		function reject(uid) {
			if (confirm("Are you sure to Reject?")) {
				var feedbackContent = $(".feedbacktextarea").val();
				$.ajax({
					url: '/reject_candidate/' + uid,
					type: 'post',
					data: {
						feedback: feedbackContent
					}, // Pass feedback as data

					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response) {
						if (response.message) {
							$("#detailsdynamictitle").html("<big style='font-size: 12px;color: #1e0c0cbf;'>Result</big><br><h2>REJECTED</h2>");
							$("#slotslist").prepend("<big style='font-size: 12px;color: #1e0c0cbf;'>Feedback</big>");
							$("#detailsdynamiccontent").html("");
							$(".feedbacktextarea").attr("disabled", "disabled");

							$("#user_" + uid).addClass("rejecteduser");
						}
					},
					error: function(xhr, status, error) {
						console.log('Error:', error);
					}
				});

			}
		}

		function reshedule(uid) {
			if (confirm("Are you sure to Re-Schedule?")) {
				$.ajax({
					url: '/rechedule_slot/' + uid,
					type: 'post',
					dataType: 'json',
					data: {


						_token: "{{ csrf_token() }}",
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(data) {
						if (data) {
							console.log(data, 'dataaa');
							// Remove the deleted candidate from the list
							$("#user_" + uid).remove();
							//alert(selectedslot);
							$("#requestedusers-container").html(data.requested_slots);
							$("#details-container").hide();
							$("#details-container").html(data.detail);
							var slots = $(this).attr("slots");
							var userid = $(this).attr("userid");
							var type = $(this).attr("calltype");
							rendercalander(slots, userid, type);
							loadcalander();
						}
					},
					error: function(xhr, status, error) {
						console.log('Error:', error);
					}
				});

			}

		}

		function CreateTextFile() {
			var descriptions = document.getElementsByClassName("download-content");
			var content = "";
			var titlecontent = $(".dynamicjobtitle").first().text();
			// alert(titlecontent);
			content += "\n";
			var headerarray = ['Job Description', 'Duties & Responsibilities', 'Requirement & Skills'];
			for (var i = 0; i < descriptions.length; i++) {
				content += "\n" + headerarray[i] + "\n";
				content += descriptions[i].innerHTML + "\n";
				//titlecontent=$(".dynamicjobtitle").text();
			}
			content = titlecontent + content;
			var blob = new Blob([content], {
				type: "text/plain;charset=utf-8",
			});
			saveAs(blob, "Job_Description.txt");
		}
	</script>
</body>

</html>