<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="slotselection.css">
	
	 <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='./dist/index.global.js'></script>
    <style>
        /* The side navigation menu */
        body {
            background-color: gray;
        }

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
            background: #dcdcdc40;
        }

        #sidebar-section {
            padding-top: 10px;
            padding-bottom: 10px;
        }
		
		.text-left
		{
			text-align:left;
			color:#9b9b9bc7;
		}
    </style>
	
	<style>
	
	</style>
</head>

<body>
    <div class="container-fluid">
        <!-- The sidebar -->
        <div class="row">
            <div class="col-lg-2" id="sidebar-section">
                <div class="sidebar">
                    <a class="navbar-brand" href="">
                        <img class="brand-logo" alt="modern admin logo"
                            src="http://pepdemo.westindia.cloudapp.azure.com/assets/images/logo/logo.png">
                        <h3 class="brand-text"></h3>
                    </a>
                    <!-- <a href="#dashboard"><span class="fa fa-dashboard"></span>&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a> -->
                    <a href="#sourcing"><span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;&nbsp;Sourcing</a>
                    <a href="#calander"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;calander</a>
                    <!-- <a href="#calander"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;Calander</a>
			  <a href="#settings"><span class="fa fa-cog"></span>&nbsp;&nbsp;&nbsp;&nbsp;Settings</a> -->
                </div>
            </div>

            <div class="col-lg-10">
	
                <div class="container mt-5">


                    <div class="col-lg-12" style="display:flex;">

                        <div class="col-lg-3" id="userlist-container">
							
							<div style="padding:3px 10px;">
                                    <div class="input-group" style="margin-top: 5px;">
                                        <input class="form-control" type="search" id="example-search-input" placeholder="search Candidate" onkeyup="mysearchFunction()">
                                        <span class="input-group-append">

                                        </span>
                                    </div>
                            </div>
							
							<div id="requesterslot">
								<div class="row slotheader" id="requestedslotheader">
									<div class="col-md-1">
										<i class="fa fa-chevron-right"></i>
									</div>
									<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Requested Slots</big></div>
								</div>
								<div id="requestedusers-container">
									<div class="row requested-users" id="user_1" onclick="showdetail('Loga Ragul','PHP Developer','5 years','91 8475734874','logaragul37@gmail.com','Msc,MCA,BE','Test','Ahmedabad','1','As per market Standard','test2')" slots="Loga Ragul - 11am ,Php Developer**2023-01-28**#80dac842**white**1**2023012811**3~Loga Ragul 16pm ,Php Developer**2023-01-29**#80dac842**white**1**2023012911**4~Loga Ragul - 18pm ,Php Developer**2023-01-29**#80dac842**white**1**2023012911**5~Loga Ragul - 10pm ,Php Developer**2023-01-29**#80dac842**white**1**2023012911**6" userid="1" calltype="Requested"> 
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Loga Ragul</span><br><small class="jd">Php Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users"  id="user_2" onclick="showdetail('Rahul Sha','iOs Developer','3 years','91 9358385938','Rahulsha23@gmail.com','Bsc,BCA,ME','Test2','Kolkata','5','As per market Standards','test3')" slots="Rahul Sha - 10pm ,iOs Developer**2023-01-28**#80dac842**white**2**2023012810**7~Rahul Sha - 15pm ,iOs Developer**2023-01-29**#80dac842**white**2**2023012915**8~Rahul Sha - 16pm ,iOs Developer**2023-02-02**#80dac842**white**2**2023020216**9"  userid="2" calltype="Requested">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Karthick</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Nisa</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Raju</span><br><small class="jd">Java Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
								</div>
							</div>
                            <hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">
							
							<div id="requesterslot">
								<div class="row slotheader" id="requestedslotheader">
									<div class="col-md-1">
										<i class="fa fa-chevron-right"></i>
									</div>
									<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Scheduled Slots</big></div>
								</div>
								<div id="Schedulededusers-container">
									<div class="row requested-users"  id="user_3" onclick="showdetail('Balaji','iOs Developer','3 years','91 9358385938','Rahulsha23@gmail.com','Bsc,BCA,ME','Test2','Kolkata','5','As per market Standards','test3')"  userid="3" calltype="Scheduled" slots="Balaji - 11am ,C# Developer**2023-01-28**#9747ff42**white**3**2023012811**10">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Balaji</span><br><small class="jd">C# Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-clock-o" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-clock-o" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-clock-o" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-clock-o" style="margin-top: 6px;"></i></div>
									</div>
								</div>
							</div>
                            <hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">
							
							<div id="requesterslot">
								<div class="row slotheader" id="requestedslotheader">
									<div class="col-md-1">
										<i class="fa fa-chevron-right"></i>
									</div>
									<div class="col-md-10" style="padding-left: 5px;"><big class="userlistheadertext text-grey">Finalized Candidates</big></div>
								</div>
								<div id="completedusers-container">
									<div class="row requested-users" onclick="showdetail('Rahul Sha','iOs Developer','3 years','91 9358385938','Rahulsha23@gmail.com','Bsc,BCA,ME','Test2','Kolkata','5','As per market Standards','test3')" slots="" userid="7" calltype="Completed">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
									<div class="row requested-users">
										<div class="col-lg-1"><!--<input type="checkbox" name="requested_slots" style="margin-top: 6px;">--></div>
										<div class="col-lg-9"><span class="uname">Rahul Sha</span><br><small class="jd">Senior iOs Developer</small></div>
										<div class="col-lg-1"><i class="fa fa-bell" style="margin-top: 6px;"></i></div>
									</div>
								</div>
							</div>
                            <hr style="margin: 1rem 0px;width: 75%;margin-left: auto;margin-right: auto;">
							
                        </div>
						
					  <div class="col-lg-4" id="details-container" style="display:none;">
						<div class="row" style="margin-left:0px;margin-right:0px;">
							<div class="col-lg-10" id="detail-titlediv"><span class="details-usertitle">Loga Ragul</span></div>
							<div class="col-lg-2"><i class="fa fa-times pull-right" onclick="closedetail();"></i></div>
						</div>
						<div id="jobdescription">
						
							<pre style="color:grey;" class="dynamicjobtitle">Senior IOs Developer</pre>
							<div style="margin-top: 10px;border-bottom: 1px solid #8080808a;padding-bottom: 2px;"><span>Job Description</span><span class="pull-right"><i class="fa fa-download"></i></span></div><br>
							<small class="text-primary">Job-Description-</small><small class="text-primary dynamicjobtitle" class="dynamicjobtitle">Senior iOs Developer</small><br>
							<table class="table table-bordered" style="font-size:13px;" id="jdtable">
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
							
							<hr>
						</div>
						
						<div id="Candidate_details">
							<big class="details-usertitle">Loga Ragul</big>
							<small class="userexperience"><span>Exp:</span><span class="candidateexperience">5 years</span></small>
							<small class="usermobile"><span>Ph:</span><span class="candidatephone">91 8475734874</span></small>
							<small  class="useremail"><span>Email:</span><span class="candidateemail">logaragul37@gmail.com</span></small>
							<button class="downloadresume">Download Resume</button><br>
							<hr>
						</div>
						
						<div id="detailsdynamicsection">
							<P class="text-grey" id="detailsdynamictitle">Selected Slots</p>
							<div id="slotslist">
							</div>
							<div class="text-grey" id="detailsdynamiccontent"></div>
						</div>
						
					  </div>
                      
						<div class="col-lg-9" id="calander-container">
						
                            <div class="scrollable-content">
                                <div class="row">
                                    <div id='calendar'></div>
									<!--<input type="hidden" name="presentevents" id="presentevents" value="{ title: 'All Day Event',start: '2023-01-01',userid:2}~{title: 'Long Event',start: '2023-01-07',  end: '2023-01-10',userid:4}~{groupId: 999,title: 'Repeating Event',start: '2023-01-09T16:00:00',userid:5,color: 'orange',textColor: 'white'}~{groupId: 999,title: 'Repeating Event',start: '2023-01-16T16:00:00',userid:3}~{title: 'Conference',start: '2023-01-11',end: '2023-01-13',userid:6}~{title: 'Meeting',start: '2023-01-12T10:30:00',end: '2023-01-12T12:30:00',userid:7}~{title: 'Lunch',start: '2023-01-12T12:00:00',userid:8,textColor: '#257e4a'}~{title: 'Meeting',start: '2023-01-12T14:30:00',userid:9}~{title: 'Happy Hour',start: '2023-01-12T17:30:00',userid:10 }~{title: 'Dinner',start: '2023-01-12T20:00:00'}~{title: 'Birthday Party',start: '2023-01-13T07:00:00'}~{title: 'Click for Google, 4pm',url: '',start: '2023-01-28',color: 'blue',textColor: 'white' ,userid: 11}">-->
									<input type="hidden" name="presentevents" id="presentevents" value="Mark W - 11am ,Java Developer**2023-01-28**#9747ff42**white**11**2023012811**1~Peter - 15pm, iOs Developer**2023-01-29**#9747ff42**white**11**2023012915**2">
                                </div>
                            </div>

						</div>
						
                    </div>
					
					<!-- Modal -->
					 <div class="modal fade" id="jdModal" role="dialog">
						<div class="modal-dialog">
						
						  <!-- Modal content-->
   					    <div class="modal-content">
							<div class="modal-body">
							  <center><b><span>Senior Java Developer</span><span>Job Description</span></b></center><br>
							  <b><u>Job Description</u></b>
							  <p id="modaldescription">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>
							  <b><u>Duties & Responsibilities</u></b>
							  <p id="modalduties">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>
							  <b><u>Requirement & Skills</u></b>
							  <p id="modalskills">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>

							</div>
						</div>
						
						  <!--Selected Info Modal Content-->
   					    <div class="modal-content">
							<div class="modal-body">
							  <center><b><span>Senior Java Developer</span><span>Job Description</span></b></center><br>
							  <b><u>Job Description</u></b>
							  <p id="modaldescription">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>
							  <b><u>Duties & Responsibilities</u></b>
							  <p id="modalduties">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>
							  <b><u>Requirement & Skills</u></b>
							  <p id="modalskills">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p><br>

							</div>
						</div>
						  
						</div>
					</div>
					
                </div>
            </div>

        </div>
    </div> 

<script>

$(document).ready(function(){
	//foreach($(".fc-event") as vall)
	function addtitle()
	{
		$(".fc-event").each(function() 
		{
			$(this).attr("title",$(this).text());
		});
	}
	addtitle();
	
	$(".requested-users").click(function(){
		var slots=$(this).attr("slots");
		var userid=$(this).attr("userid");
		var type=$(this).attr("calltype");
		rendercalander(slots,userid,type);
		addtitle();
	});
	
	$("#jdtable").click(function(){
		$("#jdModal").removeClass("fade");
		$("#jdModal").show();
	});
	
});

		document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');
		//alert(23234);
		var presentevents=document.getElementById('presentevents').value;
		var eventsplit=presentevents.split("~");
		const presenteventsarr=[];
		for(var j=0;j<eventsplit.length;j++)
		{
			var eventdetails=eventsplit[j].split("**");
			presenteventsarr[j]={ title: eventdetails[0], start: eventdetails[1], color: eventdetails[2], textColor: eventdetails[3], userid: eventdetails[4], slotid: eventdetails[6] };
		}
		//alert(presenteventsarr);
		events=presenteventsarr;

		var calendar = new FullCalendar.Calendar(calendarEl, {
		  headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: ''
		  },
		  initialDate: '2023-01-12',
		  navLinks: true, // can click day/week names to navigate views
		  selectMirror: true,
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
		  },
		  editable: true,
		  dayMaxEvents: true, // allow "more" link when too many events
		  events: events
		});

		calendar.render();
	  });
	

function rendercalander(slots,userid,type)
  {
	var calendarEl = document.getElementById('calendar');
	var presentevents=document.getElementById('presentevents').value;
	var presenteventsplit=presentevents.split("~");
	const eventdatetimelist = [];
	for(var j=0;j<presenteventsplit.length;j++)
	{
		var eventdetails=presenteventsplit[j].split("**");
		eventdatetimelist.push(eventdetails[5]);
	}
	//alert(eventdatetimelist);
	var slotlistbuttons="";                     //To create slot buttons
	
	if(type=="Scheduled")
	{
		var slotsplit=slots.split("~");
		//alert(slotsplit);
		for(var lr=0;lr<slotsplit.length;lr++)
		{
			//alert(slotsplit[lr]);
			var sloteventdetails=slotsplit[lr].split("**");
			slotlistbuttons+="<button class='slotscheduledbtn' disabled title='Slot already selected'>Time Requested : "+sloteventdetails[5]+"</button><br>";  //To create scheduled slot buttons
		}
	}
	
	allevents=presentevents+"~"+slots;
	var eventsplit=allevents.split("~");
	const presenteventsarr=[];
	for(var j=0;j<eventsplit.length;j++)
	{
		var eventdetails=eventsplit[j].split("**");
	
		if(eventdetails[2]=="#80dac842" && eventdatetimelist.includes(eventdetails[5]))
		{
			eventdetails[2]="#ff000052";
			presenteventsarr[j]={ title: eventdetails[0], start: eventdetails[1], color: eventdetails[2], textColor: eventdetails[3], userid: eventdetails[4], slotid: eventdetails[6] };
			slotlistbuttons+="<button class='conflictbtn' disabled title='Slot already selected'>Time Requested : "+eventdetails[5]+"</button><br>";                     //To create slot buttons
		}
		else
		{
			presenteventsarr[j]={ title: eventdetails[0], start: eventdetails[1], color: eventdetails[2], textColor: eventdetails[3], userid: eventdetails[4], slotid: eventdetails[6] };
		}
		
		if(eventdetails[2]=="#80dac842" && !eventdatetimelist.includes(eventdetails[5]))
		{
			slotlistbuttons+="<button class='slotconformbtn'>Time Requested : "+eventdetails[5]+"</button><br>";                     //To create slot buttons
		}
	}
	//alert(presenteventsarr);
	events=presenteventsarr;
	
	$("#slotslist").html(slotlistbuttons);
	if(type=="Requested")
	{
		$("#detailsdynamictitle").html('Requested Slots');
		$("#detailsdynamiccontent").html('<button class="declinebtn" onclick="decline('+userid+')">Decline</button>');
	}
	else if(type=="Scheduled")
	{
		$("#detailsdynamictitle").html('Scheduled Slots');
		$("#detailsdynamiccontent").html('<button class="declinebtn" onclick="reshecule('+userid+')">Re-Schedule</button><button class="declinebtn" style="float:right;" onclick="decline('+userid+')">Decline</button>');
	}
	else if(type=="Completed")
	{
		$("#detailsdynamictitle").html('Feedback for the Candidate');
		$('#slotslist').html('<textarea class="feedbacktextarea" rows="3"></textarea>');
		$("#detailsdynamiccontent").html('<p>Candidate is</p><button class="acceptbtn" onclick="accept('+userid+')">Accept</button><button class="declinebtn" style="float:right;" onclick="decline('+userid+')">Decline</button>');
	}

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      initialDate: '2023-01-12',
      navLinks: true, // can click day/week names to navigate views
      selectMirror: true,
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
		var color=JSON.stringify(arg.event.backgroundColor).replace(/[^a-zA-Z0-9 ]/g, "");
		var slotid=JSON.stringify(arg.event.extendedProps.slotid.replace(/[^a-zA-Z0-9 ]/g, ""));
		//alert(color);
		if(color=="ff000052")
		{
			alert("Slot already booked,please select another slot");
		}
		else if(color=="80dac842")
		{
			if(confirm("Are you sure to conform the slot for the user"))
			{
				conformslot(userid,JSON.stringify(arg.event.extendedProps.slotid).replace(/[^a-zA-Z0-9 ]/g, ""));
			}
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
  
  function conformslot(userid,slotid)
  {
	//alert(userid+" "+slotid);
	var allslotsarray=$("#user_"+userid).attr("slots").split("~");
	var selectedslot="";
	for(var pr=0;pr<allslotsarray.length;pr++)
	{
		//alert(allslotsarray[pr]);
		var slotdet=allslotsarray[pr].split("**");
		if(Number(slotid)==Number(slotdet[6]))
		{
			selectedslot+=allslotsarray[pr].replace("#80dac842","#9747ff42");
		}
	}
	//alert(selectedslot);
	var presenteventsval=$("#presentevents").val();
	presenteventsvalfinal=presenteventsval+"~"+selectedslot;
	$("#presentevents").val(presenteventsvalfinal);
	$("#Schedulededusers-container").prepend($("#user_"+userid).clone());
	$("#user_"+userid).remove();
	loadcalander();	  
  }
  
  function loadcalander()
  {
	var calendarEl = document.getElementById('calendar');
		var presentevents=document.getElementById('presentevents').value;
		var eventsplit=presentevents.split("~");
		const presenteventsarr=[];
		for(var j=0;j<eventsplit.length;j++)
		{
			var eventdetails=eventsplit[j].split("**");
			presenteventsarr[j]={ title: eventdetails[0], start: eventdetails[1], color: eventdetails[2], textColor: eventdetails[3], userid: eventdetails[4], slotid: eventdetails[6] };
		}
		//alert(presenteventsarr);
		events=presenteventsarr;

		var calendar = new FullCalendar.Calendar(calendarEl, {
		  headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: ''
		  },
		  initialDate: '2023-01-12',
		  navLinks: true, // can click day/week names to navigate views
		  selectMirror: true,
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
		  },
		  editable: true,
		  dayMaxEvents: true, // allow "more" link when too many events
		  events: events
		});

		calendar.render();
  }
  
  function closedetail()
	{
		$("#details-container").hide();
	}
	
	function showdetail(username,jobtitle,experience,phone,email,Qualification,skills,location,position,cost,experience)
	{
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
		$(".jobexperience").html(experience);
	}
</script>	
</body>

</html>