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

   
</script>