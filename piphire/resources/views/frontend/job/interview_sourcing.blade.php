@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>

<style>
    /* The side navigation menu */
    /* body {
            background-color: gray;
        } */
    .custom-hidden {
        display: none;
    }

    .scroll-content {
        width: 300px;
        white-space: nowrap;
        overflow-x: scroll;
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
    }

    /* Hide the scrollbar for webkit-based browsers */
    .scroll-content::-webkit-scrollbar {
        display: none;
    }

    .scrollable-content {
        max-height: calc(100vh - 60px);

    }


    #scroll {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* Internet Explorer */
    }

    /* Page content. The value of the margin-left property should match the value of the sidebar's width property */
    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    .card img {
        border-radius: 50%;
        width: 38px;
        height: 38px;
        object-fit: cover;
    }

    .card {
        padding: 16px;
        margin-bottom: 10px;
        position: relative;
        border-radius: 12px;
    }

    .card small {
        /* color: #9b9b9bc7; */
        line-height: 19px;
    }

    .add-icon {
        position: absolute;
        top: 10px;
        /* Adjust the value to position the icon vertically */
        right: 10px;
        /* Adjust the value to position the icon horizontally */
        width: 30px;
        height: 30px;
        border-radius: 40%;
        border: 2px solid #ccc;
        /* Grey border color */
        background-color: transparent;
        /* No fill color */
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: none;
        /* Remove shadow */
    }

    .plus-icon {
        font-size: 20px;
        color: #777;
        /* Grey color for the plus icon */
        line-height: 0;
        /* Adjust to vertically center the plus icon */
    }


    /* On screens that are less than 400px, display the bar vertically, instead of horizontally */


    #status-container .card {
        padding: 16px;
        padding-top: 10px;
        font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;

    }

    .status-column .card small {
        text-align: left !important;
        /* color: #9b9b9bc7; */
        font-size: 11px !important;

        font-weight: 600 !important;
    }

    .percentage-span {
        background: #d9d9d9;
        height: 68px;
        font-size: 15px;
        display: inherit;
        text-align: center;
        padding: 19px 11px;
        font-weight: 500;
        border-radius: 10px;
        width: 90%;
    }

    .dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-blue {
        background: #6869fd;
    }

    .dot-green {
        background: #09ba1b;
    }

    .dot-yellow {
        background: #e1e613;
    }

    .dot-orange {
        background: #ec9229;
    }

    .dot-purple {
        background: #bb1ec9;
    }

    .dot-aqua {
        background: #1ec9c9;
    }

    .faicon {
        color: #707070c7;
        font-size: 21px;
        margin-bottom: 10px;
        margin-top: 6px;
    }

    .modal-content {
        background: #ebebfa;
        width: auto;
        border-radius: 8px
    }

    /* remove the original arrow */
    select.input-lg {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        /* no standardized syntax available, no ie-friendly solution available */
    }

    select+i.fa {
        float: right;
        margin-top: -28px;
        margin-right: 5px;
        pointer-events: none;
        background: transparent;
        font-size: 16px;
        padding-right: 5px;
        color: #7f7e86;
    }

    input::placeholder {
        color: #999;
        /* Set the color of the placeholder text */
        font-size: 12px;
        font-style: Arial;
        /* Set the font style of the placeholder text */
        /* Add any other styling properties you want */
    }

    select.input-lg {
        height: 46px;
        line-height: inherit;
    }

    #interviewer {
        background: transparent;
    }

    .modal-body .form-control {
        padding: 0.175rem 0.75rem
    }

    .modal {
        top: 100;
        left: 105;
    }

    .text-left {
        text-align: left;
        /* color: #9b9b9bc7; */
        font-size: 11px;
        color: #8097b1;
        font-weight: 600;
    }

    .candidate_details {
        text-align: left !important;
        /* color: #9b9b9bc7; */
        font-size: 11px !important;
        color: #8097b1 !important;
        font-weight: 600 !important;
    }

    .card .fa-plus {
        color: #9b9b9bc7;
        border: 1px solid #9b9b9bc7;
        font-weight: 400;
        border-radius: 20px;
        font-size: 11px;
        padding: 2px;
        height: 14px;
    }

    #roles-list {
        /* overflow-y: scroll; */
        /* overflow: scroll; */
    }

    #roles-list .card {
        margin-bottom: 10px;
    }

    hr {
        position: relative;
        border: none;
        border-bottom: 1px solid #aaa;
        overflow: visible;
        opacity: 1;
        margin-top: 0;
    }

    .bluemarkhr:before {
        position: absolute;
        left: 0px;
        width: 24%;
        content: '';
        height: 4px;
        line-height: 22px;
        background: rgb(46 91 255);
        top: -1px;
    }

    @media screen and (max-width: 1700px) {
        html body .content .content-wrapper {
            padding: 25px 0px;
        }
    }

    div#myUL {
        padding-left: 25px;
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    #example-search-input {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .job_title {
        font-size: 14px;
        color: #666666;
        font-weight: bold;
        margin: 0;
    }

    .card .col-lg-8 {
        padding-left: 20px;
        padding-top: 4px;
    }

    #myUL .card {
        padding: 5px 0px 5px 5px !important;
    }

    #myUL .card small {
        color: #666666;
        font-size: 9px;
        font-weight: bold;
        margin-top: -9px;
    }

    #myUL .card .col-lg-4 {
        margin-top: auto;
        margin-bottom: auto;
    }

    example-search-input:placeholder {
        color: red;
        font-size: 10px !important;
    }

    #example-search-input {
        background-image: url(https://www.w3schools.com/css/searchicon.png);
        background-position: 7px 8px;
        background-repeat: no-repeat;
        background-size: 15px;
        width: 100%;
        padding: 5px 20px 5px 40px;
    }

    .candidatename {
        color: #2e384d !important;
        font-size: 16px;
        text-transform: capitalize;
        font-weight: 500;
        padding-right: 0px;
    }

    .ivsubutton {
        background: #5d5de8;
        color: white;
        border: navajowhite;
        margin-bottom: 5px;
        width: 100%;
        border-radius: 6px;
        font-size: 9px;
        padding: 5px 15px;
    }

    .hidebuttonsdivision {
        position: absolute;
        top: 21px;
        right: -83px;
        z-index: 1;
    }

    .status-container .card small {
        color: #666666;
        line-height: 7px;
        font-size: 12px;
        font-weight: 500;
    }

    #idmodalclose {
        background: white;
        padding: 10px 30px 10px 10px;
        position: absolute;
        top: -20px;
        left: -16px;
        opacity: 1;
        border-radius: 8px;
        font-weight: 500;
        font-size: 20px;
        font-weight: 900;
        color: #7f7f7f;
    }

    #ivr_name,
    #ivr_email {
        background: white;
        border: none;
        height: 40px;
        width: 100%;
    }

    #candidatestatusupdatecomment {
        background: white;
        width: 100%;
        border: white;
        border-radius: 5px;
    }

    #historycontainer p {
        margin-bottom: 4px;
        background: #a9a9fb;
        font-size: 9px;
        padding: 5px 15px 5px 10px;
        border-radius: 12px;
        color: #3a3a56;
        font-weight: 500;
        width: 100%;
    }

    #historycontainer {
        margin-top: 30px;
        height: 82px;
        overflow-x: auto;
    }

    .time-line-box .timeline {
        list-style-type: none;
        display: flex;
        padding: 0;
        text-align: center;
    }

    /*.time-line-box .status.active span:before {
    background: #09ba1b;
    border: 2px solid #09ba1b;
}*/

    .time-line-box #Contacted .status.active span:before {
        background: #6869fd;
        border: 2px solid #6869fd;
    }

    .time-line-box #interested .status.active span:before {
        background: #09ba1b;
        border: 2px solid #09ba1b;
    }

    .time-line-box #slotrequestpending .status.active span:before {
        background: #e1e613;
        border: 2px solid #e1e613;
    }

    .time-line-box #inteviewscheduled .status.active span:before {
        background: #ec9229;
        border: 2px solid #ec9229;
    }

    .time-line-box #missedinterview .status.active span:before {
        background: #bb1ec9;
        border: 2px solid #bb1ec9;
    }

    .time-line-box #interviewcompleted .status.active span:before {
        background: #1ec9c9;
        border: 2px solid #1ec9c9;
    }

    .time-line-box .status.active span .timelinetitle {
        opacity: 1;
    }

    .time-line-box .status span .timelinetitle {
        opacity: 0;
    }

    .swiper-slide:hover .status span .timelinetitle {
        opacity: 1 !important;
    }

    .time-line-box .timestamp {
        margin: auto;
        margin-bottom: 5px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .time-line-box .status {
        padding: 0px 5px;
        display: flex;
        justify-content: center;
        border-top: 3px solid #a0a0a4;
        position: relative;
        transition: all 200ms ease-in;
    }

    .time-line-box .status span {
        padding-top: 8px;
    }

    .time-line-box .status span:before {
        content: '';
        width: 12px;
        height: 12px;
        background-color: #a0a0a4;
        border-radius: 12px;
        border: 2px solid #a0a0a4;
        position: absolute;
        left: 50%;
        top: 0%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        transition: all 200ms ease-in;
    }

    .swiper-container {
        width: 95%;
        margin: auto;
        overflow-y: auto;
    }

    .swiper-wrapper {
        display: inline-flex;
        flex-direction: row;
        overflow-y: auto;
        justify-content: center;
    }

    .swiper-slide {
        text-align: center;
        font-size: 12px;
        height: 100%;
        position: relative;
    }

    /*.time-line-box .swiper-slide:first-child .status
{
	border-image: linear-gradient(to left, #a0a0a4 50%, transparent 50%) 100% 1;
}
.time-line-box .swiper-slide:last-child .status
{
	border-image: linear-gradient(to right, #a0a0a4 50%, transparent 50%) 100% 1;
}*/
    .swiper-slide {
        cursor: no-drop;
    }

    .time-line-box .status span:before {
        cursor: pointer;
    }

    .time-line-box {
        margin-bottom: 0px;
    }

    #jobModal .form-control {
        background: white;
        height: 36px;
        margin-left: -3px;
        border-radius: 9px;
    }

    #jobModal small {
        color: #5e5e64;
        font-weight: 500;
        font-size: 10px;
    }

    #selectinterviewerModal .form-control {
        background: white;
        height: 36px;
        margin-left: -3px;
        border-radius: 9px;
    }

    #selectinterviewerModal small,
    #statusupdatecomments,
    #statusupdatehistory {
        color: #5e5e64;
        font-weight: 500;
        font-size: 10px;
        margin-bottom: 2px;
    }

    .modal.show .modal-dialog .modal-body {
        padding: 30px;
        background: #ebebfa;
        border-radius: 8px
    }

    .savebutton {
        float: right;
        margin-top: 15px;
        border-radius: 5px;
        background: #2e5bff;
        border: none;
        margin-right: 5px;
        font-size: 12px;
        color: white;
        font-weight: 500;
        padding: 4px 25px;
    }

    #selectedcadName {
        font-size: 20px;
        color: #5e5e64;
        text-transform: capitalize;
        font-weight: 500;
    }

    #selectedcadjobname,
    #suselectedcadjobname {
        font-size: 18px;
        color: #5e5e64;
        text-transform: capitalize;
        font-weight: 500;
    }

    #suselectedcadName {
        font-size: 20px;
        color: #616168;
        font-weight: 500;
        text-transform: capitalize;
    }

    .timelinetitle {
        background: #e0e0eb;
        padding: 3px 11px;
        color: #85858c;
        border-radius: 6px;
        font-size: 9px;
        display: inline-block;
        margin-top: 10px;
        font-weight: 700;
    }

    .timelinetitle:before {
        content: ' ';
        height: 0;
        position: absolute;
        width: 0;
        left: 41%;
        top: 6px;
        border: 7px solid transparent;
        border-right-color: #e0e0eb;
        transform: rotate(90deg);
    }

    #optionbuttonsdiv {
        position: fixed;
        z-index: 1;
        background: #f9faff;
        padding-left: 14px;
        margin-left: -8px;
        padding-right: 32px;
        height: -webkit-fill-available;
        width: 35px;
    }

    #bulkstatusupdateModalcontent {
        background: white;
        padding: 10px;
    }

    #bulkstatusupdateModalcontent #statusbulkupdatecomment {
        background: #ebebfa;
        width: 100%;
        border: white;
        border-radius: 5px;
    }

    #bulkupdatecandidatelist {
        background: #ebebfa;
        padding: 10px;
        height: 90px;
        overflow-y: scroll;
        word-wrap: break-word;
        border-radius: 5px;
    }

    .buscandidate {
        background: #d9d8dd;
        padding: 4px 20px;
        border-radius: 20px;
        font-size: 11px;
        color: #7f7f83;
        font-weight: 500;
        line-height: 27px;
        white-space: nowrap;
        margin: 1px;
    }

    .buscandidatedelete {
        position: relative;
        top: -9px;
        left: -9px;
        color: #88888c;
        font-weight: 800;
        font-size: 15px;
        cursor: pointer;
    }

    .statusbulkupdatetext {
        color: #88888c;
        font-size: 11px;
        font-weight: 500;
        margin-bottom: 0px;
    }

    .statusbulkupdatevalue {
        font-size: 11px;
        color: #a4a4af;
    }

    #bussubstatussection {
        padding: 4px 0px;
        background: #ebebfa;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    #bussubstatus {
        float: right;
    }

    #susubstatussection {
        /*background: white;*/
        padding: 6px 6px;
        border-radius: 13px;
        margin-top: 7px;
        margin-bottom: 7px;
    }

    #suinterviewersection {
        background: white;
        padding: 5px 10px 5px 5px;
        border-radius: 8px;
        line-height: 35px;
    }

    #suinterviewersection select,
    #suinterviewersection input {
        background: #ebebfa;
        border: 1px solid gainsboro;
    }

    .scheduleddate {
        background: #c5c5f5;
        width: 100%;
        display: block;
        border-radius: 5px;
        text-align: center;
        font-size: 12px;
        color: #82829b;
        font-weight: 500;
    }

    .scheduledtime {
        width: 100%;
        display: block;
        color: #a5a5ad;
        font-size: 12px;
        background: #e7e7f3;
        text-align: center;
        border-top: 1px solid gainsboro;
        margin-top: 5px;
    }

    #suscheduledsection table {
        background: #f5f5fd;
        width: 100%;
        border-radius: 8px;
    }

    #suscheduledsection table td {
        padding: 0px 10px;
    }

    .suscheduledsectionbtn {
        background: #285bff;
        color: white;
        font-size: 9px;
        height: 17px;
        border: navajowhite;
        border-radius: 5px;
        width: 115px;
        float: right;
    }

    #interviewreschedule {
        margin-top: 5px;
    }

    #interviewdelete {
        margin-bottom: 5px;
    }

    #commentssection {
        margin-top: 10px;
    }

    .delete-icon {
        position: absolute;
        top: -9px;
        right: 7px;
        background: #ff0000a3;
        color: white;
        border-radius: 50px;
        padding: 2px;
        font-size: 10px;
    }

    .popup {
        width: 470px;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-height: 300px;
        /* Set a fixed height for the chat container */
        position: relative;
        margin-left: 50px;
        overflow: scroll;


    }

    .popup-header {
        background-color: #128C7E;
        color: #fff;
        padding: 10px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .popup-body {
        padding: 10px;
        overflow-y: auto;
        max-height: 340px;
    }

    .message {
        margin: 5px;
        overflow-wrap: break-word;
    }

    .received,
    .sent {
        width: auto;
        /* Set the width to auto */
        display: block;
        /* Display messages as block elements */
        clear: both;
        /* Clear the float property */
    }

    .received {
        background-color: white;
        text-align: left;
        padding: 8px;
        border-radius: 5px;
        float: left;
    }

    .sent {
        background-color: #DCF8C6;
        text-align: right;
        padding: 8px;
        border-radius: 5px;
        float: right;
    }

    .message:not(:last-child) {
        margin-bottom: 10px;
    }

    .close-button {
        cursor: pointer;
        padding: 5px;
        background-color: #128C7E;
        color: #fff;
        border: none;
        border-radius: 5px;
        margin-right: 5px;
    }

    /* Add your existing styles here */

    .what-modal {
        display: none;
        position: fixed;
        top: 250px;
        left: 0;
        width: 90%;
        height: 100%;
        /* background: rgba(0, 0, 0, 0.5); */
    }

    .what-content {

        width: 470px;
        margin: 50px auto;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-height: 340px;
        position: relative;
    }

    .what-header {
        background-color: #128C7E;
        color: #fff;
        padding: 10px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .what-body {
        padding: 10px;
        overflow-y: auto;
        max-height: 280px;
    }

    .candidatejobname {
        color: #2cc2a5;
    }

    /* ... existing styles ... */
</style>


@endpush
<div class="app-content content" style="font-family: Arial;">
    <div class="content-wrapper" style="height:100vh;/*overflow-y:scroll;*/">
        <!--<h3 style="color: dimgrey;"> <b> Sourcing</b></h3><br>-->
        <!-- <div style="padding-left:25px;position: sticky;left: 0;">
            <h4 style="color: #6869fd;font-size: 25px;"><b style="color:rgb(46 91 255);">Status</b></h4>
            <hr class="bluemarkhr" style="color:#2e384d">
        </div> -->

        <div class="col-lg-12" style="padding-left: 0px;">

            <div class="container">


                <div class="row" id="roles-list">
                    <div style="display: flex;">
                        <i class="fa fa-minus faicon" onclick="collapsejobs(this)" title="jobs minimize"></i>

                    </div>
                    <div class="col-lg-1" style="background-color: rgb(225, 225, 233);display: none;width: 5.33333%;margin-left: 1%;text-align: center;" id="jobssmalltext">
                        <p class="text-left vertical-text" style="background: rgb(225, 225, 233);font-weight: 700;color: #666666;font-size: 17px;">&nbsp; Jobs&nbsp;</p>
                    </div>

                    <div class="col-lg-3" style="background-color: #e1e1e9;" id="myUL">
                        <div class="row mt-12" style="margin-bottom:12px;">
                            <div class="col-md-12 mx-auto" style="padding: 0px 11px;margin-left: -1px;">
                                <div class="input-group" style="margin-top: 10px;">
                                    <input class="form-control border-end-0 border" type="search" id="example-search-input" placeholder="Search job description" onkeyup="mysearchFunction()">
                                    <span class="input-group-append">

                                    </span>
                                </div>
                            </div>
                        </div>

                        @if(!$jobs->isEmpty())
                        @foreach($jobs as $single_job)
                        <?php

                        $count = App\Candidate_Jobs::where('job_id', $single_job->id)->where('shortlist', '1')->count();
                        $acc = DB::connection('pephire')
                            ->table('candidate__jobs')
                            ->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
                            ->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
                            ->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidates.id')
                            ->where('candidates.organization_id', auth()->user()->organization_id)
                            ->where('candidate__jobs.job_id', $single_job->id)
                            ->where(function ($query) {
                                $query->whereNotNull('configurable_candidatestages.stage')
                                    ->where('configurable_candidatestages.stage', '!=', 'sourced');
                            })
                            ->distinct()
                            ->count();
                        $not = $count - $acc;
                        if ($count > 0) {
                        ?>
                            <div class="card" style="padding: 5px;" onclick="jobselect(this);" id="jobcard_{{$single_job->id}}" jobid="<?php echo $single_job->id; ?>" jd="<?php echo $single_job->description; ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h6 class="job_title ">{{ucwords($single_job->job_role)}}</h6>
                                        <small>Experience : {{$single_job->min_experience}}-{{$single_job->max_experience}} years</small>
                                        <br>
                                        <small class="job_id" style="display: none;">{{$single_job->id}}</small>
                                        <small>
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <tr>

                                                        <td><span class="dot dot-orange"></span>&nbsp;{{$count}}</td>
                                                        <td><span class="dot dot-green"></span>&nbsp;{{$acc}}</td>

                                                        <td><span class="dot dot-blue"></span>&nbsp;{{$not}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </small>
                                    </div>
                                    <?php
                                    $contacted = $count;
                                    $accepted = $acc;
                                    $percentage = ($accepted / $contacted) * 100;
                                    $roundedPercentage = round($percentage, 0);
                                    ?>
                                    <div class="col-lg-4">
                                        <span class="percentage-span">{{$roundedPercentage}}%</span>
                                        <!-- <i class="fa fa-remove delete-icon" onclick="openDeleteConfirmationModal(
                                            <?php
                                            // echo $single_job->id;
                                            ?>
                                             )" 
                                             style="cursor: pointer;">
                                            </i> -->
                                    </div>


                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        @endforeach
                        @endif
                    </div>
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true" style="width: 50%;
    left: 30%;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this job?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" id="" onclick="deleteJob(event, jobIdToDelete)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9" id="status-container">
                        <!-- Modal -->
                        <div class="modal " id="jobModal" role="dialog" style="width: 50%;margin-left:16%;">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" id="idmodalclose">&times;&nbsp;<small style="color: #6869fd;font-size:16px;">Assign Interviewer</small></button>
                                        <span style="font-size: 16px;color: #5e5e64;letter-spacing: 0.5;"><b>JOB DESCRIPTION:</b>&nbsp;&nbsp;&nbsp;<span id="selectedJobName"> </span>
                                            <span id="selectedJobId" style="display: none;"> </span>
                                            <span id="selectedCandId" style="display: none;"> </span></span>
                                        <p style="color: #616168;font-size:10px;margin-bottom:0px;">Please enter interviewer details below</p>
                                        <div class="row">
                                            <div class="col-lg-12" style="color: #5e5e64;font-weight: 500;"><small style="font-weight: 500;">Select Interviewer</small><br></div>
                                            <div class="col-lg-11">
                                                <select class="form-control" name="interviewer" id="interviewer" onchange="interviewerchange();">
                                                    <option value=""></option>
                                                    <option value="option-1" details="sandra@sentientscripts.com~9072186232">Sandra</option>
                                                    <option value="option-2" details="loga@sentientscripts.com~9347387345">Loga</option>
                                                    <option value="option-3" details="sanjna@sentientscripts.com~7657387123">Sanjna</option>
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="col-lg-11" style="margin-top: 5px;">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <small>Email</small>
                                                        <input type="text" class="form-control" name="email" id="email" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Phone Number</small>
                                                        <input type="text" class="form-control" name="phonenumber" id="phonenumber" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-11">
                                                <button class="savebutton" onclick="interviewSave()" style="margin-top: 7px;">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <script>
                            function openDeleteConfirmationModal(jobId) {
                                jobIdToDelete = jobId;
                                $('#confirmDeleteModal').modal('show');
                                // $('#confirmDeleteBtn').click(function() {
                                //     deleteJob(jobId);
                                //     $('#confirmDeleteModal').modal('hide');
                                // });
                            }
                        </script>

                        <!-- Modal -->
                        <div class="modal " id="selectinterviewerModal" role="dialog" style="width: 50%;margin-left:16%;">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" id="idmodalclose">&times;&nbsp;<small style="color: #6869fd;font-size:16px;">Interviewer Details</small></button>
                                        <div style="line-height: 23px;"><span style="font-size: 16px;color: #5e5e64;">Candidate:&nbsp;</span><span id="selectedcadName"> </span></div>
                                        <div style="line-height: 23px;"><span style="font-size: 16px;color: #5e5e64;">Job Description:&nbsp;</span>
                                            <span id="selectedcadjobname"> </span>
                                        </div>
                                        <p style="color: #616168;font-size:10px;margin-bottom:0px;">Please enter interviewer details below</p>
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top: 15px;">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <small>Name</small>
                                                        <input type="text" class="form-control" name="ivr_name" id="ivr_name" readonly="readonly">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small>Email</small>
                                                        <input type="text" class="form-control" name="ivr_email" id="ivr_email" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button class="savebutton" style="float: right;margin-top: 8px;border-radius: 8px;" onclick="interviewSave()">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal " id="statusupdateModal" role="dialog" style="margin-left: auto;padding-right: 6px;margin-right: auto;">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content" style="width: 75%;margin-left: auto;margin-right: auto;">
                                    <div class="modal-body" style="top:15%;">
                                        <button type="button" class="close" data-dismiss="modal" id="idmodalclose">×&nbsp;<small style="color: #6869fd;font-size:16px">Candidate details</small></button>
                                        <div style="line-height: 23px;"><span id="suselectedcadName"> </span></div>
                                        <!--ll<div style="line-height: 23px;"><span style="font-size: 16px;color: #5e5e64;">Job Description:&nbsp;</span>
                                            <span id="suselectedcadjobname"> </span>
                                        </div>-->

                                        <section class="time-line-box">
                                            <div class="swiper-container text-center">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide" id="status_sourced" status_id="status_sourced">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="sourced"><span><small class="timelinetitle">Sourced</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_interested" status_id="status_interested">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="interested"><span><small class="timelinetitle">Interested</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_slot_pending" status_id="status_slot_pending">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="slot_pending"><span><small class="timelinetitle">Slot Request Pending</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_scheduled" status_id="status_scheduled">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="scheduled"><span><small class="timelinetitle">Interview Scheduled</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_missed" status_id="status_missed">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="missed"><span><small class="timelinetitle">Missed Interview</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_completed" status_id="status_completed">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="completed"><span><small class="timelinetitle">Interview Completed</small></span></div>
                                                    </div>
                                                    <div class="swiper-slide" id="status_selected" status_id="status_selected">
                                                        <div class="timestamp"><span class="date"></span></div>
                                                        <div class="status" stat_id="selected"><span><small class="timelinetitle">Selected</small></span></div>
                                                    </div>

                                                </div>
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        </section>

                                        <section id="susubstatussection">
                                            <label class="statusbulkupdatetext">Sub-status</label><br>
                                            <select name="susubstatus" id="susubstatus" style="width: 140px;border-radius: 5px;">
                                            </select>
                                            <input type="hidden" name="candidatecurrentstatus" id="candidatecurrentstatus">
                                            <input type="hidden" name="currentcandidateid" id="currentcandidateid">
                                            <input type="hidden" name="currentcandidatejobid" id="currentcandidatejobid">
                                            <input type="hidden" name="currentuserid" id="currentuserid" value="{{auth()->user()->id}}">
                                            <input type="hidden" name="currentsubstatus" id="currentsubstatus">
                                            <input type="hidden" name="currentcandidateorgid" id="currentcandidateorgid" value="{{auth()->user()->organization_id}}">
                                        </section>

                                        <section id="suslotselectionsection">
                                            <small class="statusbulkupdatetext">Select time slots</small>
                                            <div class="row" style="margin-top: 5px;">
                                                <div class="col-lg-5">
                                                    <input id="my-input" style="display: none;">
                                                    <div id="my-datepicker"></div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="time-picker">
                                                        <div class="tp-col tp-hr">
                                                            <img src="chevron-up-svgrepo-com.svg" class="tp-up-arrow" />
                                                            <span class="noselect" id="hour" tabindex="0*">00</span>
                                                            <img src="chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow" />
                                                        </div>
                                                        <div class="tp-col">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="tp-col tp-min">
                                                            <img src="chevron-up-svgrepo-com.svg" class="tp-up-arrow" />
                                                            <span tabindex="0" id="minute">00</span>
                                                            <img src="chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow" />
                                                        </div>
                                                        <div class="tp-col">
                                                            <img src="chevron-up-svgrepo-com.svg" class="tp-up-arrow" />
                                                            <span class="tp-am-pm" id="merdian">AM</span>
                                                            <img src="chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow" />
                                                        </div>
                                                        <div style="text-align: right;width: inherit;"><i class="fa fa-plus" id="addslottime"></i></div>
                                                        <input type="hidden" name="selecteddateslist" id="selecteddateslist" class="selecteddateslist">
                                                    </div>

                                                    <div class="container-scroll">
                                                        <div class="row">
                                                            <div style="display: flex;overflow: auto;" id="selectedslots-container">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="border-bottom: 1px solid #dcdcdc78;">
                                        </section><br>

                                        <!--<section id="suslotpendingsection">
											<small class="statusbulkupdatetext">Schedule Interview</small>
											<div class="row">
												<div style="display: flex;overflow: auto;" id="selectedslots-container-slotpending">
													
												</div>
											</div>
										</section>-->

                                        <section id="suinterviewersection">
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <tr>

                                                        <td><small class="statusbulkupdatetext">Interviewer</small></td>
                                                        <td><select class="" style="width: 100%;" name="suinterviewer" id="suinterviewer" onchange="suinterviewerchange()">
                                                                <option value="">Select Interviewer</option>
                                                                @if(!$interviewer->isEmpty())
                                                                @foreach($interviewer as $ivr)
                                                                <option value="{{$ivr->interviewer_name}}" details="<?php echo $ivr->email ?>~<?php echo $ivr->contact_number ?>">{{$ivr->interviewer_name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select></td>
                                                        <td></td>
                                                        <td>Select slot</td>
                                                        <td><select class="" style="width: 100%;" name="conform_slot" id="conform_slot">
                                                                <option value="">Select slot</option>
                                                            </select></td>
                                                    </tr>
                                                    <tr>
                                                        <td><small class="statusbulkupdatetext">E-mail</small></td>
                                                        <td><input type="text" name="suinterviewer_email" id="suinterviewer_email" style="width: 100%;height: 20px;"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                                        <td><small class="statusbulkupdatetext">Phone</small></td>
                                                        <td><input type="text" name="suinterviewer_phone" id="suinterviewer_phone" style="width: 100%;height: 20px;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--<br><hr style="border-bottom: 1px solid #dcdcdc78;">-->
                                        </section>

                                        <section id="suscheduledsection">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <small class="statusbulkupdatetext">Interview scheduled</small>
                                                    <span class="scheduleddate">10 sep 97</span>
                                                    <span class="scheduledtime">12:00 PM</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <table>
                                                        <tr>
                                                            <td><span class="statusbulkupdatetext">Interviewer : <span id="interviewername">Madhav R</span></span></td>
                                                            <td><button class="suscheduledsectionbtn" id="interviewreschedule" name="interviewreschedule" onclick="reschedule()">Re-Schedule</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="statusbulkupdatetext" id="interviewerround">Technical Interview</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="statusbulkupdatetext" id="interviewlink">Teams meeting</span></td>
                                                            <td><button class="suscheduledsectionbtn" id="interviewdelete" data-dismiss="modal" name="interviewdelete" onclick="delete_interview()">Delete</button></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <hr style="border-bottom: 1px solid #dcdcdc78;">
                                        </section>

                                        <!--<section id="interviewcompletedsection">
											<small class="statusbulkupdatetext">Interviewer Status</small><br>
											<select style="width: 140px;border-radius: 5px;">
												<option value=""></option>
												<option value="Passed">Passed</option>
												<option value="Failed">Failed</option>
											</select>
											<br><hr style="border-bottom: 1px solid #dcdcdc78;">
										</section>-->

                                        <section id="commentssection">
                                            <p id="statusupdatecomments">Comments</p>
                                            <textarea id="candidatestatusupdatecomment" name="candidatestatusupdatecomment" rows="3"></textarea>
                                        </section>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-1">
                                                        <small id="statusupdatehistory">History</small>
                                                        <img src="/assets/images/arrowimage.png" height="40px">
                                                    </div>
                                                    <div class="col-lg-11">
                                                        <div id="historycontainer">
                                                            <p>The candidate has been contacted and waiting for response</p>
                                                            <p>Response recieved, Candidate is not interrested in this position</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div id="whatsappChatIcon" style="float: left; margin-top: 8px;">
                                                    <img src="http://pepdemo.westindia.cloudapp.azure.com/images/whatsapp.png?0cff4fdebebb7ab691035a50ad85f7e9" height="40px" onclick="showWhatsappChat()">
                                                </div>
                                            </div>

                                            <div class="modal what-modal" id="whatsappChatContainer">
                                                <div class="modal-content what-content" style="">
                                                    <div class="modal-header what-header">
                                                        <div id="whatsappheadername">Name</div>
                                                        <button class="close-button" onclick="closePopup()">X</button>
                                                    </div>
                                                    <input type="hidden" id="whatsappchatcandidate">
                                                    <div class="modal-body what-body" id="whatsappChat" style=" background: #efe7dd url(https://cloud.githubusercontent.com/assets/398893/15136779/4e765036-1639-11e6-9201-67e728e86f39.jpg) repeat;background-color: rgb(231, 252, 227);">
                                                        <!-- Dummy messages go here -->
                                                        <div class="message received" style="width: 260px;">Hi, This is from PepHire. We would like to consider you for a job opening as Software Developer. Can you confirm your interest? (Reply Yes/Reply No)</div>
                                                        <div class="message sent">I'm interested </div>
                                                        <div class="message received" style="width: 260px;">Hi, This is from PepHire. We would like to consider you for a job opening as Software Developer. Can you confirm your interest? (Reply Yes/Reply No)</div>
                                                        <div class="message sent">I'm interested </div>
                                                        <div class="message received" style="width: 260px;">Hi, This is from PepHire. We would like to consider you for a job opening as Software Developer. Can you confirm your interest? (Reply Yes/Reply No)</div>
                                                        <div class="message sent">I'm interested </div>
                                                        <!-- Add more dummy messages as needed -->
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-lg-12">
                                                <button class="savebutton" data-dismiss="modal" style="float: right;margin-top: 8px;border-radius: 8px;" onclick="candidatestatussave()">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function showWhatsappChat() {

                                var modal = document.getElementById('whatsappChatContainer');
                                modal.style.display = 'block';
                                var cid = document.getElementById('whatsappchatcandidate').value;
                                var phone = $("#usercard_" + cid + " .candidatejobphone").html();


                                $.ajax({
                                    url: '/whatsappChat',
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        cid: cid,
                                        phone: phone,
                                        _token: "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
                                        console.log(response)
                                        if (response.status) {
                                            console.log('successfull');
                                        }
                                    },
                                    error: function(response) {
                                        console.log('inside ajax error handler');
                                    }
                                });
                            }

                            function closePopup() {
                                var modal = document.getElementById('whatsappChatContainer');
                                modal.style.display = 'none';
                            }
                        </script>
                        <div class="modal " id="bulkstatusupdateModal" role="dialog" style="width: 60%;margin-left: auto;padding-right: 6px;margin-right: auto;">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body" style="padding: 8px;">
                                        <button type="button" class="close" data-dismiss="modal" id="idmodalclose">×&nbsp;<small style="color: #6869fd;font-size:16px">Candidate Status</small></button>
                                        <br>
                                        <div style="line-height: 23px;"><span class="statusbulkupdatetext">category:&nbsp;</span>
                                            <span id="" class="statusbulkupdatevalue">Contacted</span><span style="float:right;"><span class="statusbulkupdatetext">Candidates:&nbsp;</span>
                                                <span id="bulkupdatecandidatecount" class="statusbulkupdatevalue">10</span></span>
                                        </div>

                                        <div id="bulkstatusupdateModalcontent">
                                            <section class="time-line-box" style="background:white;">
                                                <div class="swiper-container text-center">
                                                    <div class="swiper-wrapper">
                                                        @if(!$stage_list->isEmpty())
                                                        @foreach($stage_list as $stg)
                                                        <div class="swiper-slide" id="bulk_{{$stg->status}}">
                                                            <div class="timestamp"><span class="date"></span></div>
                                                            <div class="status" stat_id="{{$stg->status}}"><span><small class="timelinetitle">{{$stg->status}}</small></span></div>
                                                        </div>
                                                        @endforeach
                                                        @endif

                                                    </div>

                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </section>

                                            <section id="bussubstatussection">
                                                <label class="statusbulkupdatetext">Sub-status</label>
                                                <select name="bussubstatus" id="bussubstatus">
                                                    <option value="interrested">Interested</option>
                                                    <option value="not interrested">Not Interested</option>
                                                </select>
                                            </section>


                                            <p id="" class="statusbulkupdatetext">Candidate List</p>
                                            <div id="bulkupdatecandidatelist"></div><br>
                                            <p id="statusbulkupdatecomments" class="statusbulkupdatetext">Comments</p>
                                            <textarea id="statusbulkupdatecomment" name="statusupdatecomment" rows="3"></textarea>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="savebutton" style="float: right;margin-top: 8px;border-radius: 8px;" onclick="updatestatusbulkupdatemodal()">Save</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="scrollable-content">
                            <div class="row">
                                <div class="col-sm-12" id="scroll" style="display: flex;padding-left: 8px;overflow-x: scroll;">
                                    <div id="optionbuttonsdiv" style="margin-top: -36px;">

                                        <i class="fa fa-minus faicon status-minimize" onclick="collapsecards(this)" title="status minimize" style="font-weight:lighter !important;"></i>


                                        <br><i class="fa fa-calendar faicon" class="btn btn-info btn-lg" onclick="openModal();" title="Assign Interviewer"></i>
                                        <br><i class="fa fa-list faicon" onclick="downloadCSV();" title="Report Download"></i>
                                        <br><i class="fa fa-download faicon" onclick="downloadresume();" title="Resume Download"></i>
                                        <!--<br><i class="fa fa-edit faicon" onclick="openstatusbulkupdatemodal();"></i>-->
                                    </div>

                                    <div class="col-sm-3 status-column" id="sourced" style="margin-left: 50px;">
                                        <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#212940;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Sourced <br>Candidates</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#212940;"></small>&nbsp;&nbsp;Sourced Candidates</p>
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
                                                <div class="col-lg-12 text-left candidate_details" style="padding-top: 10px;line-height: 17px;">
                                                    <small class="candidatejobname">{{$skj->jname}}</small><br>
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$skj->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$skj->phone}}</small>
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
                                        <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#2E6FF2;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Interested <br> Candidates</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#2E6FF2;">112</small>&nbsp;&nbsp;Interested Candidates</p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$ack->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$ack->phone}}</small>
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
                                    <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#4EBF9F;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Slot <br> Pending</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#4EBF9F;">89</small>&nbsp;&nbsp; Slot Pending </p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$pending_job->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$pending_job->phone}}</small>
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
                                        <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#D95B5B;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Interview <br> Scheduled</></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#D95B5B;">12</small> &nbsp;&nbsp;Interview Scheduled</p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$scheduled_job->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$scheduled_job->phone}}</small>
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
                                    <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#B3B3ad;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Missed <br> Interview</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#B3B3ad;">1</small>&nbsp;&nbsp;Missed Interview </p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$msj->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$msj->phone}}</small>
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
                                    <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#7D818C;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Interview <br> Completed</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"><small class="cardcount" style="background:#7D818C;">1</small>&nbsp;&nbsp; Interview Completed </p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$cjs->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$cjs->phone}}</small>
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
                                    <table style="margin-bottom: 10px;" class="cardcountnotcollapsed">
                                            <tbody>
                                                <tr>
                                                    <td><small class="cardcount" style="background:#DB4EC4;">2</small></td>
                                                    <td style="padding: 0;/* text-align: left; */"><h6 style="text-align: start;color: #2e384d;font-size: 14px;font-weight: 600;padding-left: 10px;line-height: normal;margin-top: 10px;margin-bottom: 13px;">Selected <br> Candidates</h6></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-left cardcountcollapsed"> <small class="cardcount" style="background:#DB4EC4;">122</small>&nbsp;&nbsp;Selected Candidates</p>
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
                                                    <small class="candidatejobemail" style="color: #474343de;">{{$cks->email}}</small><br>
                                                    <small class="candidatejobphone" style="color: #000000d9;">{{$cks->phone}}</small>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteJob(event, jobId) {

        // Assuming you have included jQuery
        $.ajax({
            url: '/delete/job', // Replace with the actual URL for deleting a job
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_id: jobId
            },
            success: function(response) {
                // Handle success, e.g., remove the job card from the DOM
                $('#jobcard_' + jobId).remove();
                $('#confirmDeleteModal').modal('hide');
                const statusColumns = document.querySelectorAll('.status-column');
                statusColumns.forEach(column => {
                    const cards = column.querySelectorAll('.card.record');
                    cards.forEach(card => {
                        //if (card.style.display !== "none") {
                        //alert(card.getAttribute('jobid'));
                        if (card.getAttribute('jobid') == jobId) {
                            card.remove();
                            updatecount();
                        }
                    });
                });
            },
            error: function(error) {
                // Handle error
                console.error('Error deleting job:', error);
            }
        });
        event.stopPropagation();
    }
</script>

<script>
    // JavaScript code to handle card selection
    document.addEventListener('DOMContentLoaded', function() {
        const selectableCards = document.querySelectorAll('.selectable-card');

        selectableCards.forEach(card => {
            card.addEventListener('click', function() {
                this.classList.toggle('selected');
            });
        });
    });
</script>
<!--<script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
<script>
    const statusColumns = document.querySelectorAll('.status-column');
    statusColumns.forEach(column => {

        column.addEventListener('click', () => {

            // Toggle a class to adjust column size on click

            column.classList.toggle('small-column');



            // Get the status name element within the column

            const statusName = column.querySelector('p');

            const cardcount = column.querySelector('.cardcount');



            // Toggle vertical layout for the status name

            if (statusName) {

                if (column.classList.contains('small-column')) {

                    statusName.classList.add('vertical-text');

                } else {

                    statusName.classList.remove('vertical-text');

                }

            }



            // Get all the cards within the column

            const cards = column.querySelectorAll('.card');



            // Toggle visibility of the cards

            cards.forEach(card => {

                if (!card.classList.contains("no")) {

                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';

                }

                // var regExp = /\(([^)]+)\)/;

                var matches = cardcount.innerHTML;

                if (matches == 0) {

                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';



                }

            });

        });

    });
    document.addEventListener('DOMContentLoaded', function() {
        // Add your code here to handle card selection

        const jobModal = new bootstrap.Modal(document.getElementById('jobModal'));
        const statusupdateModal = new bootstrap.Modal(document.getElementById('statusupdateModal'));
        const selectinterviewerModal = new bootstrap.Modal(document.getElementById('selectinterviewerModal'));
        const selectedJobName = document.getElementById('selectedJobName');
        const selectedJobId = document.getElementById('selectedJobId');
        const selectedCandId = document.getElementById('selectedCandId');

        // Add your code here to show the modal and handle form submission
    });

    function collapsecards(element) {
        const statusColumns = document.querySelectorAll('.status-column');

        statusColumns.forEach(column => {
            const statusName = column.querySelector('p');
            const cardcount = column.querySelector('.cardcount');

            if (statusName) {
                if (column.classList.contains('small-column')) {
                    statusName.classList.add('vertical-text');
                } else {
                    column.classList.add('small-column');
                    statusName.classList.add('vertical-text');
                }
            }
            const cards = column.querySelectorAll('.card');
            cards.forEach(card => {
                if (!card.classList.contains("no")) {
                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';
                }
                // var regExp = /\(([^)]+)\)/;
                var matches = cardcount.innerHTML;
                if (matches == 0) {
                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';

                }
            });
        });
        element.classList.add('fa-plus');
        element.setAttribute("title", "Status Maximize");
        element.classList.remove('fa-minus');
        element.setAttribute("onclick", "opencards(this)");
    }

    function opencards(element) {
        const statusColumns = document.querySelectorAll('.status-column');

        statusColumns.forEach(column => {
            const statusName = column.querySelector('p');
            const cardcount = column.querySelector('.cardcount');

            if (statusName) {
                if (column.classList.contains('small-column')) {
                    statusName.classList.remove('vertical-text');
                    column.classList.remove('small-column');
                } else {
                    column.classList.remove('small-column');
                    statusName.classList.remove('vertical-text');
                }
            }
            const cards = column.querySelectorAll('.card');
            cards.forEach(card => {
                if (!card.classList.contains("no")) {
                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';
                }
                // var regExp = /\(([^)]+)\)/;
                var matches = cardcount.innerHTML;
                if (matches == 0) {
                    card.style.display = column.classList.contains('small-column') ? 'none' : 'block';

                }
            });
        });
        element.classList.remove('fa-plus');
        element.classList.add('fa-minus');
        element.setAttribute("title", "Status Minimize");
        element.setAttribute("onclick", "collapsecards(this)");
    }

    function collapsejobs(element) {
        document.getElementById('jobssmalltext').style.display = "block";
        document.getElementById('myUL').style.display = "none";
        document.getElementById('status-container').setAttribute("style", "width:93.666667%");
        element.classList.remove('fa-minus');
        element.classList.add('fa-plus');
        element.setAttribute("title", "Jobs Maximize");
        element.setAttribute("onclick", "openjobs(this)");
    }

    function openjobs(element) {
        document.getElementById('jobssmalltext').style.display = "none";
        document.getElementById('myUL').style.display = "block";
        document.getElementById('status-container').removeAttribute("style");
        element.classList.remove('fa-plus');
        element.classList.add('fa-minus');
        element.setAttribute("title", "Jobs Minimize");
        element.setAttribute("onclick", "collapsejobs(this)");
    }

    function openModal() {
        const jobModal = new bootstrap.Modal(document.getElementById('jobModal'));
        jobModal.show();

        var selectedjobs = "";
        var cards = document.querySelectorAll("#roles-list .card.active .job_title");
        for (var i = 0; i < cards.length; i++) {
            selectedjobs += (selectedjobs == "") ? cards[i].innerHTML : ", " + cards[i].innerHTML;
        }
        document.getElementById('selectedJobName').innerHTML = selectedjobs;

        var selectedjobid = "";
        var card = document.querySelectorAll("#roles-list .card.active .job_id");
        for (var i = 0; i < card.length; i++) {
            selectedjobid += (selectedjobid == "") ? card[i].innerHTML : "," + card[i].innerHTML;
        }
        document.getElementById('selectedJobId').innerHTML = selectedjobid;
    }


    function openstatusbulkupdatemodal() {

        const bulkstatusupdateModal = new bootstrap.Modal(document.getElementById('bulkstatusupdateModal'));

        document.getElementById("statusbulkupdatecomment").value = "";
        var selectedcandidates = "";

        var stage = "";
        var error = 0;

        var cards = document.querySelectorAll(".status-column .card.active .candidatename");
        if (cards.length > 0) {
            document.getElementById('bulkupdatecandidatecount').innerHTML = cards.length;

            for (var i = 0; i < cards.length; i++) {

                if (i == 0)

                {

                    stage = cards[i].getAttribute('stage');

                    //alert(stage);

                } else

                {
                    // var statusId = activeStatusElement.getAttribute('stat_id');


                    var currentstage = cards[i].getAttribute('stage');

                    //alert(stage+" "+currentstage);

                    if (stage != currentstage)

                    {

                        alert("select only one stage");

                        error = 1;

                    }

                }

                updateSubstatusOptionsbulk(stage);
                // selectedcandidates += (selectedcandidates == "") ? cards[i].innerHTML : ", " + cards[i].innerHTML;

                selectedcandidates += "<span id='buscandidate_" + cards[i].getAttribute('candidateid') + "'><span class='buscandidate'>" + cards[i].innerHTML + "</span><span class='buscandidatedelete' onclick='deletebuscandidate(" + cards[i].getAttribute('candidateid') + ")'>&times;</span></span>";

            }

            if (error == 0)

            {
                // alert(stage);
                bulkstatusupdateModal.show();

                document.getElementById('bulkupdatecandidatelist').innerHTML = selectedcandidates;
                $(".swiper-slide .status").removeClass("active");
                $('#bulk_' + stage + ' .status').addClass("active");



            }
        }
        //alert(selectedcandidates);

    }

    function updatestatusbulkupdatemodal() {
        const bulkstatusupdateModal = new bootstrap.Modal(document.getElementById('bulkstatusupdateModal'));

        var selectedcandidates = [];
        var cards = document.querySelectorAll(".status-column .card.active .candidatename");
        document.getElementById('bulkupdatecandidatecount').innerHTML = cards.length;
        for (var i = 0; i < cards.length; i++) {
            var job_id = cards[i].getAttribute('user_id'); // assuming you have a 'data-job-id' attribute in your HTML
            var candidate_id = cards[i].getAttribute('candidateid'); // assuming you have a 'data-candidate-id' attribute in your HTML

            selectedcandidates.push({
                job_id: job_id,
                candidate_id: candidate_id
            });
            // selectedcandidates += (selectedcandidates == "") ? cards[i].innerHTML : ", " + cards[i].innerHTML;
        }
        // document.getElementById('bulkupdatecandidatelist').innerHTML = selectedcandidates;
        var selectElement = document.getElementById("bussubstatus");

        // Get the selected value
        var substatus = selectElement.value;

        // Find the element with the "active" class within the swiper-wrapper
        var activeStatusElement = document.querySelector('.swiper-wrapper .swiper-slide .status.active');

        // Get the value of the "status_id" attribute
        var statusId = activeStatusElement.getAttribute('stat_id');

        // Use the statusId value in your JavaScript code
        console.log('activeStatusElement: ' + selectedcandidates);

        // You can now use the selectedValue in your JavaScript code
        console.log("Selected selectedcandidates: " + selectedcandidates);


        $.ajax({
            url: '/update/candidateStatus',
            dataType: 'json',
            type: 'POST',
            data: {
                stage: statusId,
                ids: selectedcandidates,
                sub_status: substatus,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                console.log(data.list)
                $(".scrollable-content").html(data.list);
                $("#myUL").html(data.view);
                updatecount();
                var modal = document.getElementById('bulkstatusupdateModal');
                modal.hide();
                // // Re-enable scrolling on the body
                document.body.style.overflow = 'auto';
                // var modal = document.getElementById('no_record');
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }

    function interviewSave() {
        var selectedjobid = document.getElementById("selectedJobId").innerHTML;
        var selectedcandid = document.getElementById("selectedCandId").innerHTML;
        var selectedOption = $("#interviewer option:selected");
        var interviewerName = selectedOption.text();
        $.ajax({
            url: "{{ URL::route('interviewer.update') }}",
            dataType: 'json',
            type: 'POST',
            data: {
                name: interviewerName,
                email: $("input[name=email]").val(),
                phone: $("input[name=phonenumber]").val(),
                job_id: selectedjobid,
                cand_id: selectedcandid,

                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log(response)
                if (response.status) {
                    //   window.location.href = response.redirect_url;
                    // Get a reference to the modal element by its ID
                    var modal = document.getElementById('jobModal');

                    // Close the modal by removing the "show" class
                    modal.classList.remove('show');

                    // Hide the modal backdrop
                    document.body.classList.remove('modal-open');
                    document.querySelector('.modal-backdrop').remove();

                    // Re-enable scrolling on the body
                    document.body.style.overflow = 'auto';

                    // Clear the input fields
                    //for comments we can add this
                    document.getElementById('interviewer').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('phonenumber').value = '';
                    var cards = document.querySelectorAll('.card.active');
                    cards.forEach(function(card) {
                        card.classList.remove('active');
                    });
                    // location.reload();
                    //   console.log('great');
                }
            },
            error: function(response) {

                console.log('inside ajax error handler');
            }
        });

    }

    function delete_interview() {
        if (confirm("Are you sure to delete?")) {
            var candidateid = document.getElementById('currentcandidateid').value;
            var candidatejobid = document.getElementById('currentcandidatejobid').value;
            $(".scrollable-content").css("opacity", "0.5");
            $.ajax({
                url: '/interview/delete/',
                dataType: 'json',
                type: 'POST',
                data: {
                    candidateid: candidateid,
                    candidatejobid: candidatejobid,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {

                    console.log('data', data.list);

                    $(".scrollable-content").html(data.list);
                    $("#myUL").html(data.view);

                    updatecount();
                    document.getElementById('candidatestatusupdatecomment').value = '';
                    document.getElementById('suinterviewer').value = '';
                    document.getElementById('conform_slot').value = '';
                    document.getElementById('suinterviewer_email').value = '';
                    document.getElementById('suinterviewer_phone').value = '';
                    $(".scrollable-content").css("opacity", "1");
                    // var su_modal = document.getElementById('statusupdateModal');
                    // su_modal.classList.remove('show');

                },

                error: function(xhr, status, error) {

                    console.log('Error:', error);
                    $(".scrollable-content").css("opacity", "1");
                }
            });
        }
    }

    function candidatestatussave() {

        var comment = document.getElementById('candidatestatusupdatecomment').value;

        var susubstatus = document.getElementById('susubstatus').value;

        var candidateid = document.getElementById('currentcandidateid').value;

        var candidatejobid = document.getElementById('currentcandidatejobid').value;

        var orguserid = document.getElementById('currentuserid').value;

        var orgid = document.getElementById('currentcandidateorgid').value;

        var status = document.getElementById('candidatecurrentstatus').value;

        var interviewer = document.getElementById('suinterviewer').value;

        var conform_slot = document.getElementById('conform_slot').value;

        var intervieweremail = document.getElementById('suinterviewer_email').value;

        var interviewerphone = document.getElementById('suinterviewer_phone').value;



        var activeStatusElement = document.querySelector('.swiper-wrapper .swiper-slide .status.active');

        var statusId = activeStatusElement.getAttribute('stat_id');


        $(".scrollable-content").css("opacity", "0.5");


        var oldslotslist = "";

        var colElements = document.querySelectorAll('.selection-times:not(.newslot)');

        colElements.forEach(function(colElement) {

            oldslotslist += (oldslotslist == "") ? colElement.getAttribute('datevalue') + " " + colElement.textContent : "," + colElement.getAttribute('datevalue') + " " + colElement.textContent;

        });

        //alert("oldslotslist " + oldslotslist);



        var selectedslotslist = "";

        var colElements = document.querySelectorAll('.selection-times');

        colElements.forEach(function(colElement) {

            selectedslotslist += (selectedslotslist == "") ? colElement.getAttribute('datevalue') + " " + colElement.textContent : "," + colElement.getAttribute('datevalue') + " " + colElement.textContent;

        });

        // alert("selectedslotslist " + selectedslotslist);



        if (susubstatus == "")

        {

            alert("please select Sub status");

            return false;

        }



        /*if (selectedslotslist == "" && statusId == "slot_pending" && oldslotslist == "")

        {

            alert("please add slots to proceed");

            return false;

        }*/



        /*if (interviewer == "" && statusId == "scheduled")

        {

            alert("please select Interviewer");

            return false;

        }*/



        /*if (conform_slot == "" && statusId == "scheduled")

        {

            alert("please select a Slot to conform");

            return false;

        }*/



        /*if (intervieweremail == "" && statusId == "scheduled")

        {

            alert("please add interviewer Email");

            return false;

        }



        if (interviewerphone == "" && statusId == "scheduled")

        {

            alert("please add interviewer Phone");

            return false;

        }*/



        /* if (comment == "")

         {

             alert("please enter Comments");

             return false;

         }*/



        /*if(conformedslot=="")

        {

                       alert("please conform a slot to proceed");

        }*/



        $.ajax({

            url: "/candidate/updatestatus",

            dataType: 'json',

            type: 'POST',

            data: {

                susubstatus: susubstatus,

                comment: comment,

                candidateid: candidateid,

                candidatejobid: candidatejobid,

                orguserid: orguserid,

                orgid: orgid,

                status: status,

                stage: statusId,

                conformedslot: conform_slot,

                selectedslotslist: selectedslotslist,

                interviewer: interviewer,

                intervieweremail: intervieweremail,

                interviewerphone: interviewerphone,

                _token: "{{ csrf_token() }}",

            },

            success: function(data) {

                console.log('data', data.list);

                $(".scrollable-content").html(data.list);
                $("#myUL").html(data.view);



                updatecount();
                document.getElementById('candidatestatusupdatecomment').value = '';
                document.getElementById('suinterviewer').value = '';
                document.getElementById('conform_slot').value = '';
                document.getElementById('suinterviewer_email').value = '';
                document.getElementById('suinterviewer_phone').value = '';

                $(".scrollable-content").css("opacity", "1");
                // var su_modal = document.getElementById('statusupdateModal');
                // su_modal.classList.remove('fade');

            },

            error: function(xhr, status, error) {

                console.log('Error:', error);
                $(".scrollable-content").css("opacity", "1");
            }



        });



    }

    function suinterviewerchange() {
        var interviewer = document.querySelector("#suinterviewer");
        var details = interviewer.options[interviewer.selectedIndex].getAttribute('details');
        splitdetail = details.split("~");
        document.getElementById('suinterviewer_email').value = splitdetail[0];
        document.getElementById('suinterviewer_phone').value = splitdetail[1];
    }

    function interviewerchange() {
        var interviewer = document.querySelector("#interviewer");
        var details = interviewer.options[interviewer.selectedIndex].getAttribute('details');
        splitdetail = details.split("~");
        document.getElementById('email').value = splitdetail[0];
        document.getElementById('phonenumber').value = splitdetail[1];
    }

    function mysearchFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("example-search-input");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        //li = ul.getElementsByTagName("li");
        li = ul.getElementsByClassName("card");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("h6")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    function jobselect(element) {
        element.classList.add("active");
        element.setAttribute("onclick", "jobunselect(this)");
        candidatefilter();
    }

    function jobunselect(element) {
        element.classList.remove("active");
        element.setAttribute("onclick", "jobselect(this)");
        candidatefilter();
    }

    function candidatefilter() {
        var cards = document.querySelectorAll("#roles-list .card.active");
        var filterjds = [];
        for (var i = 0; i < cards.length; i++) {
            filterjds.push(cards[i].getAttribute('jobid'));
        }
        //alert(filterjds);

        var cancards = document.querySelectorAll(".status-column .card:not(.no)");
        for (var i = 0; i < cancards.length; i++) {
            var curelemid = cancards[i].getAttribute('jobid');
            //alert(curelemid);

            if (cards.length > 0) {
                if (filterjds.includes(curelemid)) {
                    cancards[i].style.position = "unset";
                    cancards[i].style.top = "unset";
                    cancards[i].style.left = "unset";
                } else {
                    cancards[i].style.position = "absolute";
                    cancards[i].style.top = "-9999px";
                    cancards[i].style.left = "-9999px";
                }
            } else {
                cancards[i].style.position = "unset";
                cancards[i].style.top = "unset";
                cancards[i].style.left = "unset";
            }

        }
        updatecount();
    }

    function candidateselect(event, element) {
        element.classList.add("active");
        element.setAttribute("onclick", "candidateunselect(event,this)");
        event.stopPropagation();
    }

    function candidateunselect(event, element) {
        element.classList.remove("active");
        element.setAttribute("onclick", "candidateselect(event,this)");
        event.stopPropagation();
    }

    function timeselect(event, element) {
        element.classList.add("active");
        element.setAttribute("onclick", "timeunselect(event,this)");
        event.stopPropagation();
    }

    function timeunselect(event, element) {
        element.classList.remove("active");
        element.setAttribute("onclick", "timeselect(event,this)");
        event.stopPropagation();
    }

    function reschedule() {
        if (confirm("Are you sure to Reschedule?")) {
            $('#suscheduledsection').hide();
            $('#suslotselectionsection, #suinterviewersection').show();
            updateSubstatusOptions("slot_pending");
            updateslotdropdown();
        }
    }

    function dynamicelements(stage) {
        if (stage == "sourced" || stage == "contacted") {
            $('#suslotselectionsection, #suinterviewersection, #suscheduledsection').hide();
        }
        if (stage == "interested") {
            $('#suinterviewersection, #suscheduledsection').hide();
            $("#suslotselectionsection").show();
        }
        if (stage == "slot_pending") {
            $('#suinterviewersection, #suscheduledsection').hide();
            $("#suslotselectionsection").show();
        }
        if (stage == "scheduled") {
            //$('#suslotselectionsection, #suinterviewersection').hide(); 
            $("#suslotselectionsection, #suinterviewersection").show();
        }
        if (stage == "missed") {
            $('#suslotselectionsection, #suinterviewersection').hide();
            $("#suscheduledsection").show();
        }
        if (stage == "completed") {
            $('#suslotselectionsection, #suinterviewersection, #suscheduledsection').hide();
            //$("#interviewcompletedsection").show();
        }
    }

    function updateslotdropdown() {
        var slots = document.querySelectorAll(".selection-times");
        var slotoption = "";
        slots.forEach(function(slot) {
            var slotvalue = slot.getAttribute('datevalue') + " " + slot.textContent;
            slotoption += "<option value='" + slotvalue + "'>" + slotvalue + "</option>";
        });
        $("#conform_slot").html("<option value=''>select slot</option>" + slotoption);
        //alert(slotoption);
    }

    function openstatusupdateModal(event, element, title, jid, cid, candidatename, stage, status) {
        const su_modal = new bootstrap.Modal(document.getElementById('statusupdateModal'));
        su_modal.show();
        document.getElementById('suselectedcadName').innerHTML = candidatename;
        var wppmodal = document.getElementById('whatsappChatContainer');
        wppmodal.style.display = 'none';
        document.getElementById('whatsappchatcandidate').value = cid;
        document.getElementById('whatsappheadername').innerHTML = candidatename;
        //document.getElementById('suselectedcadjobname').innerHTML = title;
        document.getElementById('candidatecurrentstatus').value = stage;
        document.getElementById('currentcandidateid').value = cid;
        document.getElementById('currentcandidatejobid').value = jid;
        document.getElementById('currentsubstatus').value = status;

        //alert(element.parentElement.parentElement.parentElement.querySelector('.text-left').textContent);
        $(".swiper-slide .status").removeClass("active");
        $('#status_' + stage + ' .status').addClass("active");
        $("#historycontainer").html($("#usercard_" + cid).attr("log"));
        //alert(stage);
        updateSubstatusOptions(stage);
        if (stage == "sourced" || stage == "contacted") {
            $('#suslotselectionsection, #suinterviewersection, #suscheduledsection').hide();
        }
        if (stage == "interested") {
            $('#suinterviewersection, #suscheduledsection').hide();
            $("#suslotselectionsection").show();
        }
        if (stage == "slot_pending") {
            $('#suinterviewersection, #suscheduledsection').hide();
            $("#suslotselectionsection,#suinterviewersection").show();
            //alert($("#usercard_"+cid).attr("slots"));
            $("#conform_slot").html("<option value=''>select slot</option>" + $("#usercard_" + cid).attr("slotsoptions"));
        }
        if (stage == "scheduled" || stage == "missed") {
            $('#suslotselectionsection, #suinterviewersection').hide();
            $("#suscheduledsection").show();
            $("#interviewername").text($("#usercard_" + cid).attr("interviewername"));
            $("#interviewerround").text($("#usercard_" + cid).attr("round"));
            $("#interviewlink").text($("#usercard_" + cid).attr("link"));
            $(".scheduleddate").text($("#usercard_" + cid).attr("scheduleddate"));
            $(".scheduledtime").text($("#usercard_" + cid).attr("scheduledtime"));
        }
        if (stage == "completed") {
            $('#suslotselectionsection, #suinterviewersection, #suscheduledsection').hide();
            //$("#interviewcompletedsection").show();
        }


        document.getElementById("selectedslots-container").innerHTML = "";
        //var selectedslots = "2023-11-14 13:53:00,2023-11-14 14:53:00,2023-11-15 13:53:00,2023-11-09 13:53:00";
        var selectedslots = $("#usercard_" + cid).attr("slots");

        if (selectedslots) {
            // Split the selectedslots into an array of date-time strings
            var dateTimesArray = selectedslots.split(',');

            // Create an object to store times based on dates
            var timesByDate = {};

            // Process each date-time
            dateTimesArray.forEach(function(dateTimeString) {
                var dateTime = new Date(dateTimeString);
                /*var originalDate = dateTime.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: '2-digit' }).replace(/\//g, ''); // Original format
                var formattedDate = dateTime.toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: '2-digit' }); // Formatted for selected-dates*/
                var formattedTime = dateTime.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });

                const minmonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var dval = dateTime.getDate();
                var datevalue1 = (String(dval).length == 1) ? "0" + dateTime.getDate() : dateTime.getDate();
                var originalDate = minmonth[dateTime.getMonth()] + dateTime.getDate() + dateTime.getFullYear().toString().substr(-2);
                var formattedDate = dateTime.getDate() + " " + minmonth[dateTime.getMonth()] + " " + dateTime.getFullYear().toString().substr(-2);
                var dateval = datevalue1 + "-" + minmonth[dateTime.getMonth()] + "-" + dateTime.getFullYear().toString().substr(-2);
                var timedivclass = dateTime.getDate() + minmonth[dateTime.getMonth()] + dateTime.getFullYear().toString().substr(-2);
                //var formattedTime = datevalue1+":"+dateTime;

                //Initialize an array for the original date if it doesnt exist
                if (!timesByDate[originalDate]) {
                    timesByDate[originalDate] = [];
                }

                // Add the formatted time to the array for the original date
                timesByDate[originalDate].push({
                    formattedTime: formattedTime,
                    formattedDate: formattedDate,
                    dateval: dateval,
                    timedivclass: timedivclass,
                });
            });

            //Create the HTML dynamically
            var html = '';
            for (var originalDate in timesByDate) {
                if (timesByDate.hasOwnProperty(originalDate)) {
                    html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 1px 0px 0px 0px;" id="' + originalDate + '">';
                    html += '<div>';
                    html += '<span class="selected-dates">' + timesByDate[originalDate][0].formattedDate + '</span>';
                    html += '<span class="date-delete" onclick=delete_datetime("' + originalDate + '")>x</span>';
                    html += '<hr>';
                    html += '</div>';

                    // Add time elements based on the respective date
                    timesByDate[originalDate].forEach(function(timeData) {
                        var timeSlotId = originalDate + timeData.formattedTime.replace(/:/g, '').replace(/\s+/g, '');
                        html += '<div id="' + timeSlotId + '" class="' + timeData.timedivclass + '">';
                        html += '<span class="selection-times" datevalue="' + timeData.dateval + '" >' + timeData.formattedTime + '</span>';
                        html += '<span class="time-delete" onclick=delete_datetime("' + timeSlotId + '")>x</span>';
                        html += '<br>';
                        html += '<input type="hidden" class="timelist" value="' + convertTimeToMinutes(timeData.formattedTime) + '">';
                        html += '</div>';
                    });

                    html += '</div>';
                }
            }


            // Log the generated HTML to the console (you can use it as needed)
            document.getElementById("selectedslots-container").innerHTML = html;
        }

        event.stopPropagation();
    }

    function convertTimeToMinutes(timeString) {
        const [time, period] = timeString.match(/(\d+:\d+) ([APMapm]{2})/).slice(1);
        const [hours, minutes] = time.split(':').map(Number);

        // Convert to 24-hour format
        const adjustedHours = (hours % 12) + (period.toUpperCase() === 'PM' ? 12 : 0);

        // Format the result as HHMM without spaces
        const formattedResult = `${adjustedHours.toString().padStart(2, '0')}${minutes.toString().padStart(2, '0')}`;

        return formattedResult;
    }

    function openselectinterviewerModal(event, title, jid, cid, candidatename) {
        const su_modal = new bootstrap.Modal(document.getElementById('selectinterviewerModal'));
        su_modal.show();
        document.getElementById('selectedcadName').innerHTML = candidatename;
        document.getElementById('selectedcadjobname').innerHTML = title;

        event.stopPropagation();
    }

    function openmodalplus(event, title, jid, cid) {
        const jobModal = new bootstrap.Modal(document.getElementById('jobModal'));
        jobModal.show();
        document.getElementById('selectedJobName').innerHTML = title;
        document.getElementById('selectedJobId').innerHTML = jid;
        document.getElementById('selectedCandId').innerHTML = cid;

        event.stopPropagation();

    }

    function showhiddenbtn(event, id) {
        //alert("#plus_"+id);
        $("#hiddenbtndiv_" + id).show();
        $("#plus_" + id).attr("onclick", "hidehiddenbtn(event," + id + ")");
        event.stopPropagation();
    }

    function hidehiddenbtn(event, id) {
        //alert(id);
        $("#hiddenbtndiv_" + id).hide();
        $("#plus_" + id).attr("onclick", "showhiddenbtn(event," + id + ")");
        event.stopPropagation();
    }

    function deletebuscandidate(id) {
        if (confirm("Are you sure to remove Candidate?")) {
            $("#buscandidate_" + id).remove();
            var count = Number($("#bulkupdatecandidatecount").html());
            count = count - 1;
            $("#bulkupdatecandidatecount").html(count);
        }
    }

    updatecount();

    function updatecount() {
        const statusColumns = document.querySelectorAll('.status-column');
        statusColumns.forEach(column => {
            var cardcount = 0;
            const cards = column.querySelectorAll('.card.record');
            const ccount = column.querySelectorAll('.cardcount');
            const noRecordsMessage = column.querySelector('.card.no');

            cards.forEach(card => {
                //if (card.style.display !== "none") {
                if (card.style.position !== "absolute") {
                    cardcount++;

                }
            });

            //ccount.innerHTML = cardcount;
            ccount.forEach(cco => {
                cco.innerHTML = cardcount;
            });
            

            // Check if noRecordsMessage exists before accessing its style property
            // if (noRecordsMessage) {
            if (cardcount === 0) {
                console.log('block');
                noRecordsMessage.style.position = "unset";
                noRecordsMessage.style.top = "unset";
                noRecordsMessage.style.left = "unset";
                if (column.classList.contains("small-column")) {
                    noRecordsMessage.style.display = "none";
                }
            } else {
                noRecordsMessage.style.position = "absolute";
                noRecordsMessage.style.top = "-9999px";
                noRecordsMessage.style.left = "-9999px";
                if (column.classList.contains("small-column")) {
                    noRecordsMessage.style.display = "block";
                }
            }
        });
    }


    function downloadCSV() {
        var cards = document.querySelectorAll("#roles-list .card.active");
        var filterjds = [];
        for (var i = 0; i < cards.length; i++) {
            filterjds.push(cards[i].getAttribute('jobid'));
        }
        var jobsAndCandidatesarray = [];
        // Example data (replace this with your actual data)
        var cancards = document.querySelectorAll(".status-column .card:not(.no)");
        for (var i = 0; i < cancards.length; i++) {
            var experience = cancards[i].getAttribute('exp');
            var current_ctc = cancards[i].getAttribute('curr_ctc');
            var exp_ctc = cancards[i].getAttribute('exp_ctc');
            var notice = cancards[i].getAttribute('notice');
            var current_location = cancards[i].getAttribute('curr_loc');
            var preffered_location = cancards[i].getAttribute('pref_loc');
            var curelemid = cancards[i].getAttribute('jobid');
            var jobid = cancards[i].getAttribute('jobid');
            var stage = cancards[i].getAttribute('stage');
            var jd = $("#jobcard_" + jobid).attr("jd");
            var canid = cancards[i].getAttribute('id');
            var canidarray = canid.split("_");

            var candidatenameElement = cancards[i].querySelector('.candidatename');
            var canname = candidatenameElement ? candidatenameElement.textContent : '';
            var candidatejobnameElement = cancards[i].querySelector('.candidatejobname');
            var canjobname = candidatejobnameElement ? candidatejobnameElement.textContent : '';
            var candidatephoneElement = cancards[i].querySelector('.candidatejobphone');
            var canphone = candidatephoneElement ? candidatephoneElement.textContent : '';
            var candidateemailElement = cancards[i].querySelector('.candidatejobemail');
            var canemail = candidateemailElement ? candidateemailElement.textContent : '';
            //alert(canphone+" "+canemail);
            if (cards.length > 0) {
                if (filterjds.includes(curelemid)) {
                    //         var experience = cancards[i].getAttribute('exp');
                    // var current_ctc = cancards[i].getAttribute('curr_ctc');
                    // var exp_ctc = cancards[i].getAttribute('exp_ctc');
                    // var notice = cancards[i].getAttribute('notice');
                    // var current_location = cancards[i].getAttribute('curr_loc');
                    // var preffered_location = cancards[i].getAttribute('pref_loc');
                    jobsAndCandidatesarray.push({
                        job_id: jobid,
                        job_name: canjobname,
                        job_description: jd,
                        candidate_id: canidarray[1],
                        candidate_name: canname,
                        candidate_phone: canphone,
                        candidate_email: canemail,
                        experience: experience,
                        current_ctc: current_ctc,
                        exp_ctc: exp_ctc,
                        notice: notice,
                        current_location: current_location,
                        preffered_location: preffered_location,
                        stage: stage
                    });
                } else {

                }
            } else {
                jobsAndCandidatesarray.push({
                    job_id: jobid,
                    job_name: canjobname,
                    job_description: jd,
                    candidate_id: canidarray[1],
                    candidate_name: canname,
                    candidate_phone: canphone,
                    candidate_email: canemail,
                    experience: experience,
                    current_ctc: current_ctc,
                    exp_ctc: exp_ctc,
                    notice: notice,
                    current_location: current_location,
                    preffered_location: preffered_location,
                    stage: stage
                });
            }

        }
        const jobsAndCandidates = [jobsAndCandidatesarray];

        let csvData = 'Job ID, Job Name, Job Description, Candidate ID, Candidate Name, Candidate Phone, Candidate Email,Experience,Current CTC,expected CTC,Notice Period,Current Location,Preffered Location,Stage\n';

        // Populate CSV data
        jobsAndCandidatesarray.forEach(entry => {
            csvData += `${entry.job_id},"${entry.job_name}","${entry.job_description}",${entry.candidate_id},"${entry.candidate_name}","${entry.candidate_phone}","${entry.candidate_email}","${entry.experience}","${entry.current_ctc}","${entry.exp_ctc}","${entry.notice}","${entry.current_location}","${entry.preffered_location}","${entry.stage}"\n`;
        });

        // Create a Blob containing the CSV data
        const blob = new Blob([csvData], {
            type: 'text/csv'
        });

        // Create a temporary URL for the Blob
        const url = URL.createObjectURL(blob);

        // Create a link element
        const link = document.createElement('a');

        // Set the link's attributes
        link.href = url;
        link.download = 'job_candidates_report.csv';

        // Append the link to the document
        document.body.appendChild(link);

        // Trigger a click on the link to start the download
        link.click();

        // Remove the link from the document
        document.body.removeChild(link);

    }

    function downloadresume() {
        var cards = document.querySelectorAll("#roles-list .card.active");
        var filterjds = [];
        for (var i = 0; i < cards.length; i++) {
            filterjds.push(cards[i].getAttribute('jobid'));
        }
        var jobsAndCandidatesarray = [];
        // Example data (replace this with your actual data)
        var cancards = document.querySelectorAll(".status-column .card:not(.no)");
        for (var i = 0; i < cancards.length; i++) {
            var curelemid = cancards[i].getAttribute('jobid');
            var jobid = cancards[i].getAttribute('jobid');
            var jd = $("#jobcard_" + jobid).attr("jd");
            var canid = cancards[i].getAttribute('id');
            var canidarray = canid.split("_");

            var candidatenameElement = cancards[i].querySelector('.candidatename');
            var canname = candidatenameElement ? candidatenameElement.textContent : '';
            var candidatejobnameElement = cancards[i].querySelector('.candidatejobname');
            var canjobname = candidatejobnameElement ? candidatejobnameElement.textContent : '';
            var candidatephoneElement = cancards[i].querySelector('.candidatejobphone');
            var canphone = candidatephoneElement ? candidatephoneElement.textContent : '';
            var candidateemailElement = cancards[i].querySelector('.candidatejobemail');
            var canemail = candidateemailElement ? candidateemailElement.textContent : '';
            //alert(canphone+" "+canemail);
            if (cards.length > 0) {
                if (filterjds.includes(curelemid)) {
                    //some job is selected (filtered data will download)
                    jobsAndCandidatesarray.push({
                        job_id: jobid,
                        job_name: canjobname,
                        job_description: jd,
                        candidate_id: canidarray[1],
                        candidate_name: canname,
                        candidate_phone: canphone,
                        candidate_email: canemail
                    });
                } else {

                }
            } else {
                //no job is selected (all data will download)
                jobsAndCandidatesarray.push({
                    job_id: jobid,
                    job_name: canjobname,
                    job_description: jd,
                    candidate_id: canidarray[1],
                    candidate_name: canname,
                    candidate_phone: canphone,
                    candidate_email: canemail
                });
            }

        }

        $.ajax({
            url: '/download/candidateResumes/',
            dataType: 'json',
            type: 'POST',
            data: {
                resume: jobsAndCandidatesarray,

                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log(response)
                if (response.status) {

                    console.log('successfull');
                    window.location.href = '/download/' + response.file;
                }
            },
            error: function(response) {

                console.log('inside ajax error handler');
            }
        });
    }

    $(document).ready(function() {
        $("#bulkstatusupdateModal .swiper-slide").click(function() {
            //alert($(this).attr("id"));
            $(".swiper-slide .status").removeClass("active");
            $(this).find(".status").addClass("active");
        });
    });
</script>
<!-- Your HTML content here -->

<!-- Your HTML content here -->

<script>
    // Define the substatuses for each status

    // Assuming you have the original data in a variable called originalData
    var substatuses = {};
    var originalData = <?php echo $substatus; ?>
    // Loop through the original data and group names by status
    originalData.forEach(function(entry) {
        var status = entry.status;

        if (substatuses[status] === undefined) {
            substatuses[status] = [];
        }

        substatuses[status].push(entry.name);
    });

    // Now convertedData will contain the desired format
    console.log(substatuses, 'vaaaaaaaaaaaaaa');
    // Get a reference to the status dropdown
    var statusDropdown = document.getElementById('bussubstatus');
    var candidatestatusDropdown = document.getElementById('susubstatus');

    // Function to update the substatus options
    function updateSubstatusOptions(selectedStatus) {

        console.log('Selected Status: ' + selectedStatus);



        // Clear the current options

        candidatestatusDropdown.innerHTML = '';



        // Get the substatuses for the selected status

        var selectedSubstatuses = substatuses[selectedStatus];



        if (selectedSubstatuses && selectedSubstatuses.length > 0) {

            // Create and append substatus options

            var defaul = document.getElementById('currentsubstatus').value;
            console.log('hiiiiihloooooo', defaul)
            // If no substatuses are defined, add a default option

            var defaultOption = document.createElement('option');

            defaultOption.value = defaul; // Set the default value to 'given'

            defaultOption.textContent = defaul; // Set the default text to 'Given'

            candidatestatusDropdown.appendChild(defaultOption);
            selectedSubstatuses.forEach(substatus => {

                var optionElement = document.createElement('option');

                optionElement.value = substatus.toLowerCase().replace(' ', '_');

                optionElement.textContent = substatus;

                candidatestatusDropdown.appendChild(optionElement);

            });
        } else {


            // If no substatuses are defined, add a default option

            var defaultOption = document.createElement('option');

            defaultOption.value = ''; // Set the default value to 'given'

            defaultOption.textContent = 'Select Substatus'; // Set the default text to 'Given'

            candidatestatusDropdown.appendChild(defaultOption);

        }

    }










    function updateSubstatusOptionsbulk(selectedStatus) {

        console.log('Selected Status: ' + selectedStatus);

        // Clear the current options

        statusDropdown.innerHTML = '';

        candidatestatusDropdown.innerHTML = '';



        // Get the substatuses for the selected status

        var selectedSubstatuses = substatuses[selectedStatus];



        if (selectedSubstatuses && selectedSubstatuses.length > 0) {

            // Create and append substatus options

            selectedSubstatuses.forEach(substatus => {

                var optionElement = document.createElement('option');

                optionElement.value = substatus.toLowerCase().replace(' ', '_');

                optionElement.textContent = substatus;

                statusDropdown.appendChild(optionElement);

            });

        } else {

            // If no substatuses are defined, add a default option

            var defaultOption = document.createElement('option');

            defaultOption.value = '';

            defaultOption.textContent = 'Select Substatus';

            statusDropdown.appendChild(defaultOption);

        }

    }

    // Add a change event listener to the swiper slides
    var swiperSlides = document.querySelectorAll('#bulkstatusupdateModal .swiper-wrapper .swiper-slide .status');
    swiperSlides.forEach(slide => {
        slide.addEventListener('click', function(event) {
            var selectedStatus = slide.getAttribute('stat_id');
            console.log('Event: ', event);
            console.log('Selected Status: ' + selectedStatus);
            updateSubstatusOptionsbulk(selectedStatus);
        });
    });


    var swiperSlides = document.querySelectorAll('#statusupdateModal .swiper-wrapper .swiper-slide .status');

    swiperSlides.forEach(slide => {
        slide.addEventListener('click', function(event) {
            var selectedStatus = slide.getAttribute('stat_id');
            var error = 0;
            var errormsg = "";

            var currentstatus = $("#candidatecurrentstatus").val();

            if (selectedStatus == "sourced") {
                error = 1;
                errormsg += "sourced can't be selected";
            }

            if ((currentstatus != "sourced" && selectedStatus == "interested") || (currentstatus != "sourced" && currentstatus != "interested" && selectedStatus == "slot_pending") || (currentstatus != "sourced" && currentstatus != "interested" && currentstatus != "slot_pending" && selectedStatus == "scheduled") || (currentstatus != "sourced" && currentstatus != "interested" && currentstatus != "slot_pending" && currentstatus != "scheduled" && selectedStatus == "completed") || (currentstatus != "sourced" && currentstatus != "interested" && currentstatus != "slot_pending" && currentstatus != "scheduled" && currentstatus != "completed" && selectedStatus == "selected")) {
                error = 1;
                errormsg += "Previous stages can't be selected";
            }

            if (currentstatus != "scheduled" && selectedStatus == "missed") {
                error = 1;
                errormsg += "Missed Interview can be allowed only for scheduled candidates";
            }

            if (error === 1) {
                alert(errormsg);
                // updateSubstatusOptions(currentstatus);
                return false; // Stop event propagation and prevent the default action
            } else {
                updateSubstatusOptions(selectedStatus);
                $("#statusupdateModal .swiper-wrapper .swiper-slide .status").removeClass("active");
                slide.classList.add("active");

                dynamicelements(selectedStatus);

                if (selectedStatus == "interested") {
                    //$("#susubstatus").html('<option value="interested">Interested</option>');
                    updateSubstatusOptions(selectedStatus);
                } else if (selectedStatus == "slot_pending") {
                    //$("#susubstatus").html('<option value="slots_given">Slots Given</option>');
                    updateSubstatusOptions("interested");
                } else if (selectedStatus == "scheduled") {
                    //$("#susubstatus").html('<option value="slot_accepted">Slot Accepted</option>');
                    updateSubstatusOptions("slot_pending");
                } else if (selectedStatus == "missed") {
                    updateSubstatusOptions(selectedStatus);
                } else if (selectedStatus == "completed") {
                    //$("#susubstatus").html('<option value="both_joined">Both Joined</option>');
                    updateSubstatusOptions("scheduled");
                } else if (selectedStatus == "selected") {
                    updateSubstatusOptions("completed");
                }
            }
        });
    });
</script>


<style>
    .cardcount {

        padding-left: 20px;
        font-size: 12px;
        padding-right: 20px;
        padding-top: 7px;
        padding-bottom: 7px;
        color: white;
        border-radius: 5px;
    }

    .cardcountnotcollapsed{ height:43px; }

    .vertical-text .cardcount {
        font-size: 12px;
        padding: 10px;        
    }

    .status-column {
        transition: width 0.5s;
        height: 100vh;
        /* Set column height to full screen height */
        padding: 20px 8px;
        /* Add padding to the column */
        text-align: center;
        /* Center align the content horizontally */
        flex-direction: column;
        justify-content: center;
        transition: width 0.5s;
        /* Center align the column */
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding-top: 5px;
        vertical-align: middle;
    }

    .status-column .text-left {
        color: #2e384d;
        font-size: 14px;
        font-weight: 600;
        font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .small-column {
        width: auto;
        padding: 0px 10px;
        /* Add border shadow */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .vertical-text {
        writing-mode: vertical-rl;
        /*transform: rotate(180deg);*/
        display: inline-block;
        margin: 10px 0;
    }


    .card.active {
        background: #9ee3d6;
        border: none;
    }

    .cardcountcollapsed
    {
        display: none;
    }

    .small-column .cardcountcollapsed
    {
        display: block;
    }

    .small-column .cardcountnotcollapsed
    {
        display: none;
    }


    .time-line-box #bulk_sourced .status.active span:before,
    .time-line-box #status_sourced .status.active span:before {
        background: #6869fd;
        border: 2px solid #6869fd;
    }

    .time-line-box #bulk_contacted .status.active span:before,
    .time-line-box #status_contacted .status.active span:before {
        background: #6869fd;
        border: 2px solid #6869fd;
    }

    .time-line-box #bulk_interested .status.active span:before,
    .time-line-box #status_interested .status.active span:before {

        background: #09ba1b;

        border: 2px solid #09ba1b;

    }

    .time-line-box #bulk_slot_pending .status.active span:before,
    .time-line-box #status_slot_pending .status.active span:before {

        background: #e1e613;

        border: 2px solid #e1e613;

    }

    .time-line-box #bulk_scheduled .status.active span:before,
    .time-line-box #status_scheduled .status.active span:before {

        background: #ec9229;

        border: 2px solid #ec9229;

    }

    .time-line-box #bulk_missed .status.active span:before,
    .time-line-box #status_missed .status.active span:before {

        background: #bb1ec9;

        border: 2px solid #bb1ec9;

    }

    .time-line-box #bulk_completed .status.active span:before,
    .time-line-box #status_completed .status.active span:before {

        background: #1ec9c9;

        border: 2px solid #1ec9c9;

    }

    .selected-dates {
        font-size: 12px;
        border: 1px solid #e6e6e6;
        padding: 3px 20px 3px 6px;
        border-radius: 5px;
        color: #666666;
        font-weight: 500;
        background: #c5c5f5;
        margin-left: 0px;
    }

    #selectedslots-container {
        padding: 0px 7px;
        overflow: auto;
        max-height: 105px;
    }

    #selectedslots-container hr {
        color: #62d1bc;
        opacity: 1;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .selection-times {
        color: #7b7b7b;
        background: #e7e7f3;
        padding: 6px 20px;
        font-size: 12px;
        margin: 15px 0px;
        line-height: 31px;
    }

    .selection-times.active {
        background: #a9a9fb;
    }

    .date-delete {
        font-size: 14px;
        color: gray;
        position: relative;
        margin-left: -12px;
        margin-top: -4px;
        cursor: pointer;
    }

    .time-delete {
        font-size: 12px;
        color: gray;
        position: relative;
        margin-left: -11px;
        margin-top: 0px;
        cursor: pointer;
        font-weight: 600;
    }

    .comment-delete {
        font-size: 14px;
        color: gray;
        position: relative;
        margin-left: -9px;
        cursor: pointer;
    }

    #headerpart h1 {
        font-size: 45px;
        font-weight: 400;
    }

    /*!
 * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
    .datepicker {
        padding: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        direction: ltr;
    }

    @media only screen and (max-width: 1450px) {
        .cardcountnotcollapsed {
            height: 58px;
        }
    }

    .datepicker-inline {
        /* width: 220px; */
    }

    .datepicker.datepicker-rtl {
        direction: rtl;
    }

    .datepicker.datepicker-rtl table tr td span {
        float: right;
    }

    .datepicker-dropdown {
        top: 0;
        left: 0;
    }

    .datepicker-dropdown:before {
        content: '';
        display: inline-block;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid #999999;
        border-top: 0;
        border-bottom-color: rgba(0, 0, 0, 0.2);
        position: absolute;
    }

    .datepicker-dropdown:after {
        content: '';
        display: inline-block;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #ffffff;
        border-top: 0;
        position: absolute;
    }

    .datepicker-dropdown.datepicker-orient-left:before {
        left: 6px;
    }

    .datepicker-dropdown.datepicker-orient-left:after {
        left: 7px;
    }

    .datepicker-dropdown.datepicker-orient-right:before {
        right: 6px;
    }

    .datepicker-dropdown.datepicker-orient-right:after {
        right: 7px;
    }

    .datepicker-dropdown.datepicker-orient-bottom:before {
        top: -7px;
    }

    .datepicker-dropdown.datepicker-orient-bottom:after {
        top: -6px;
    }

    .datepicker-dropdown.datepicker-orient-top:before {
        bottom: -7px;
        border-bottom: 0;
        border-top: 7px solid #999999;
    }

    .datepicker-dropdown.datepicker-orient-top:after {
        bottom: -6px;
        border-bottom: 0;
        border-top: 6px solid #ffffff;
    }

    .datepicker>div {
        display: none;
    }

    .datepicker table {
        margin: 0;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        width: 100%;
    }

    #my-datepicker {
        margin-bottom: 10px;
        margin-top: -4px;
        background: white;
    }

    .datepicker table tr td.active {
        background-color: #6869fd;
        background-image: linear-gradient(to bottom, #6869fd, #6869fd) !important;
    }

    .datepicker td,
    .datepicker th {
        text-align: center;
        width: 16px;
        height: 22px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: none;
        color: #666666;
        font-weight: 400;
        font-size: 11px;
    }

    .table-striped .datepicker table tr td,
    .table-striped .datepicker table tr th {
        background-color: transparent;
    }

    .datepicker table tr td.day:hover,
    .datepicker table tr td.day.focused {
        background: #eeeeee;
        cursor: pointer;
    }

    .datepicker table tr td.old,
    .datepicker table tr td.new {
        color: #999999;
    }

    .datepicker table tr td.disabled,
    .datepicker table tr td.disabled:hover {
        background: none;
        color: #999999;
        cursor: default;
    }

    .datepicker table tr td.highlighted {
        background: #d9edf7;
        border-radius: 0;
    }

    .datepicker table tr td.today,
    .datepicker table tr td.today:hover,
    .datepicker table tr td.today.disabled,
    .datepicker table tr td.today.disabled:hover {
        background-color: #fde19a;
        background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
        background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
        background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
        background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
        background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
        border-color: #fdf59a #fdf59a #fbed50;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        color: #000;
    }

    .datepicker table tr td.today:hover,
    .datepicker table tr td.today:hover:hover,
    .datepicker table tr td.today.disabled:hover,
    .datepicker table tr td.today.disabled:hover:hover,
    .datepicker table tr td.today:active,
    .datepicker table tr td.today:hover:active,
    .datepicker table tr td.today.disabled:active,
    .datepicker table tr td.today.disabled:hover:active,
    .datepicker table tr td.today.active,
    .datepicker table tr td.today:hover.active,
    .datepicker table tr td.today.disabled.active,
    .datepicker table tr td.today.disabled:hover.active,
    .datepicker table tr td.today.disabled,
    .datepicker table tr td.today:hover.disabled,
    .datepicker table tr td.today.disabled.disabled,
    .datepicker table tr td.today.disabled:hover.disabled,
    .datepicker table tr td.today[disabled],
    .datepicker table tr td.today:hover[disabled],
    .datepicker table tr td.today.disabled[disabled],
    .datepicker table tr td.today.disabled:hover[disabled] {
        background-color: #fdf59a;
    }

    .datepicker table tr td.today:active,
    .datepicker table tr td.today:hover:active,
    .datepicker table tr td.today.disabled:active,
    .datepicker table tr td.today.disabled:hover:active,
    .datepicker table tr td.today.active,
    .datepicker table tr td.today:hover.active,
    .datepicker table tr td.today.disabled.active,
    .datepicker table tr td.today.disabled:hover.active {
        background-color: #fbf069 \9;
    }

    .datepicker table tr td.today:hover:hover {
        color: #000;
    }

    .datepicker table tr td.today.active:hover {
        color: #fff;
    }

    .datepicker table tr td.range,
    .datepicker table tr td.range:hover,
    .datepicker table tr td.range.disabled,
    .datepicker table tr td.range.disabled:hover {
        background: #eeeeee;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }

    .datepicker table tr td.range.today,
    .datepicker table tr td.range.today:hover,
    .datepicker table tr td.range.today.disabled,
    .datepicker table tr td.range.today.disabled:hover {
        background-color: #f3d17a;
        background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
        background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
        background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
        background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
        background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
        border-color: #f3e97a #f3e97a #edde34;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }

    .datepicker table tr td.range.today:hover,
    .datepicker table tr td.range.today:hover:hover,
    .datepicker table tr td.range.today.disabled:hover,
    .datepicker table tr td.range.today.disabled:hover:hover,
    .datepicker table tr td.range.today:active,
    .datepicker table tr td.range.today:hover:active,
    .datepicker table tr td.range.today.disabled:active,
    .datepicker table tr td.range.today.disabled:hover:active,
    .datepicker table tr td.range.today.active,
    .datepicker table tr td.range.today:hover.active,
    .datepicker table tr td.range.today.disabled.active,
    .datepicker table tr td.range.today.disabled:hover.active,
    .datepicker table tr td.range.today.disabled,
    .datepicker table tr td.range.today:hover.disabled,
    .datepicker table tr td.range.today.disabled.disabled,
    .datepicker table tr td.range.today.disabled:hover.disabled,
    .datepicker table tr td.range.today[disabled],
    .datepicker table tr td.range.today:hover[disabled],
    .datepicker table tr td.range.today.disabled[disabled],
    .datepicker table tr td.range.today.disabled:hover[disabled] {
        background-color: #f3e97a;
    }

    .datepicker table tr td.range.today:active,
    .datepicker table tr td.range.today:hover:active,
    .datepicker table tr td.range.today.disabled:active,
    .datepicker table tr td.range.today.disabled:hover:active,
    .datepicker table tr td.range.today.active,
    .datepicker table tr td.range.today:hover.active,
    .datepicker table tr td.range.today.disabled.active,
    .datepicker table tr td.range.today.disabled:hover.active {
        background-color: #efe24b \9;
    }

    .datepicker table tr td.selected,
    .datepicker table tr td.selected:hover,
    .datepicker table tr td.selected.disabled,
    .datepicker table tr td.selected.disabled:hover {
        background-color: #9e9e9e;
        background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
        background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
        background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
        background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
        background-image: linear-gradient(to bottom, #b3b3b3, #808080);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
        border-color: #808080 #808080 #595959;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }

    .datepicker table tr td.selected:hover,
    .datepicker table tr td.selected:hover:hover,
    .datepicker table tr td.selected.disabled:hover,
    .datepicker table tr td.selected.disabled:hover:hover,
    .datepicker table tr td.selected:active,
    .datepicker table tr td.selected:hover:active,
    .datepicker table tr td.selected.disabled:active,
    .datepicker table tr td.selected.disabled:hover:active,
    .datepicker table tr td.selected.active,
    .datepicker table tr td.selected:hover.active,
    .datepicker table tr td.selected.disabled.active,
    .datepicker table tr td.selected.disabled:hover.active,
    .datepicker table tr td.selected.disabled,
    .datepicker table tr td.selected:hover.disabled,
    .datepicker table tr td.selected.disabled.disabled,
    .datepicker table tr td.selected.disabled:hover.disabled,
    .datepicker table tr td.selected[disabled],
    .datepicker table tr td.selected:hover[disabled],
    .datepicker table tr td.selected.disabled[disabled],
    .datepicker table tr td.selected.disabled:hover[disabled] {
        background-color: #808080;
    }

    .datepicker table tr td.selected:active,
    .datepicker table tr td.selected:hover:active,
    .datepicker table tr td.selected.disabled:active,
    .datepicker table tr td.selected.disabled:hover:active,
    .datepicker table tr td.selected.active,
    .datepicker table tr td.selected:hover.active,
    .datepicker table tr td.selected.disabled.active,
    .datepicker table tr td.selected.disabled:hover.active {
        background-color: #666666 \9;
    }

    .datepicker table tr td.active,
    .datepicker table tr td.active:hover,
    .datepicker table tr td.active.disabled,
    .datepicker table tr td.active.disabled:hover {
        background-color: #006dcc;
        background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
        background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: linear-gradient(to bottom, #0088cc, #0044cc);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
        border-color: #0044cc #0044cc #002a80;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }

    .datepicker table tr td.active:hover,
    .datepicker table tr td.active:hover:hover,
    .datepicker table tr td.active.disabled:hover,
    .datepicker table tr td.active.disabled:hover:hover,
    .datepicker table tr td.active:active,
    .datepicker table tr td.active:hover:active,
    .datepicker table tr td.active.disabled:active,
    .datepicker table tr td.active.disabled:hover:active,
    .datepicker table tr td.active.active,
    .datepicker table tr td.active:hover.active,
    .datepicker table tr td.active.disabled.active,
    .datepicker table tr td.active.disabled:hover.active,
    .datepicker table tr td.active.disabled,
    .datepicker table tr td.active:hover.disabled,
    .datepicker table tr td.active.disabled.disabled,
    .datepicker table tr td.active.disabled:hover.disabled,
    .datepicker table tr td.active[disabled],
    .datepicker table tr td.active:hover[disabled],
    .datepicker table tr td.active.disabled[disabled],
    .datepicker table tr td.active.disabled:hover[disabled] {
        background-color: #0044cc;
    }

    .datepicker table tr td.active:active,
    .datepicker table tr td.active:hover:active,
    .datepicker table tr td.active.disabled:active,
    .datepicker table tr td.active.disabled:hover:active,
    .datepicker table tr td.active.active,
    .datepicker table tr td.active:hover.active,
    .datepicker table tr td.active.disabled.active,
    .datepicker table tr td.active.disabled:hover.active {
        background-color: #003399 \9;
    }

    .datepicker table tr td span {
        display: block;
        width: 23%;
        height: 54px;
        line-height: 54px;
        float: left;
        margin: 1%;
        cursor: pointer;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .datepicker table tr td span:hover {
        background: #eeeeee;
    }

    .datepicker table tr td span.disabled,
    .datepicker table tr td span.disabled:hover {
        background: none;
        color: #999999;
        cursor: default;
    }

    .datepicker table tr td span.active,
    .datepicker table tr td span.active:hover,
    .datepicker table tr td span.active.disabled,
    .datepicker table tr td span.active.disabled:hover {
        background-color: #006dcc;
        background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
        background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
        background-image: linear-gradient(to bottom, #0088cc, #0044cc);
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
        border-color: #0044cc #0044cc #002a80;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }

    .datepicker table tr td span.active:hover,
    .datepicker table tr td span.active:hover:hover,
    .datepicker table tr td span.active.disabled:hover,
    .datepicker table tr td span.active.disabled:hover:hover,
    .datepicker table tr td span.active:active,
    .datepicker table tr td span.active:hover:active,
    .datepicker table tr td span.active.disabled:active,
    .datepicker table tr td span.active.disabled:hover:active,
    .datepicker table tr td span.active.active,
    .datepicker table tr td span.active:hover.active,
    .datepicker table tr td span.active.disabled.active,
    .datepicker table tr td span.active.disabled:hover.active,
    .datepicker table tr td span.active.disabled,
    .datepicker table tr td span.active:hover.disabled,
    .datepicker table tr td span.active.disabled.disabled,
    .datepicker table tr td span.active.disabled:hover.disabled,
    .datepicker table tr td span.active[disabled],
    .datepicker table tr td span.active:hover[disabled],
    .datepicker table tr td span.active.disabled[disabled],
    .datepicker table tr td span.active.disabled:hover[disabled] {
        background-color: #0044cc;
    }

    .datepicker table tr td span.active:active,
    .datepicker table tr td span.active:hover:active,
    .datepicker table tr td span.active.disabled:active,
    .datepicker table tr td span.active.disabled:hover:active,
    .datepicker table tr td span.active.active,
    .datepicker table tr td span.active:hover.active,
    .datepicker table tr td span.active.disabled.active,
    .datepicker table tr td span.active.disabled:hover.active {
        background-color: #003399 \9;
    }

    .datepicker table tr td span.old,
    .datepicker table tr td span.new {
        color: #999999;
    }

    .datepicker .datepicker-switch {
        width: 145px;
        color: gray;
        font-weight: 500;
    }

    .datepicker .datepicker-switch,
    .datepicker .prev,
    .datepicker .next,
    .datepicker tfoot tr th {
        cursor: pointer;
    }

    .datepicker .datepicker-switch:hover,
    .datepicker .prev:hover,
    .datepicker .next:hover,
    .datepicker tfoot tr th:hover {
        background: #eeeeee;
    }

    .datepicker .cw {
        font-size: 10px;
        width: 12px;
        padding: 0 2px 0 5px;
        vertical-align: middle;
    }

    .input-append.date .add-on,
    .input-prepend.date .add-on {
        cursor: pointer;
    }

    .input-append.date .add-on i,
    .input-prepend.date .add-on i {
        margin-top: 3px;
    }

    .input-daterange input {
        text-align: center;
    }

    .input-daterange input:first-child {
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        border-radius: 3px 0 0 3px;
    }

    .input-daterange input:last-child {
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
    }

    .input-daterange .add-on {
        display: inline-block;
        width: auto;
        min-width: 16px;
        height: 18px;
        padding: 4px 5px;
        font-weight: normal;
        line-height: 18px;
        text-align: center;
        text-shadow: 0 1px 0 #ffffff;
        vertical-align: middle;
        background-color: #eeeeee;
        border: 1px solid #ccc;
        margin-left: -5px;
        margin-right: -5px;
    }

    .datepicker-switch {
        color: #4659ff !important;
        font-size: 14px !important;
        font-weight: bolder !important;
    }

    .datepicker-days .table-condensed {
        font-size: 13px;
    }

    #headerpart big {
        font-size: 28px;
        letter-spacing: 1;
    }

    .description {
        margin-top: 15px;
        height: 190px;
        overflow: auto;
        direction: rtl;
    }

    .description-content {
        font-size: 12px;
        color: black;
        word-spacing: 4px;
        padding-left: 10px;
        direction: ltr;
    }

    .submitbtn {
        border: none;
        color: #4659ff ! important;
        width: 177px;
        background: white;
        box-shadow: 1px 5px 5px 1px #ccc;
        margin-top: 10px;
        font-size: 10px;
        padding: 1px;
        font-weight: 700;
    }

    .tp-hr>span:hover,
    .tp-min>span:hover {
        background: #c5c5f5;
    }

    .noselect {
        -webkit-touch-callout: none;
        /* iOS Safari */
        -webkit-user-select: none;
        /* Safari */
        -khtml-user-select: none;
        /* Konqueror HTML */
        -moz-user-select: none;
        /* Old versions of Firefox */
        -ms-user-select: none;
        /* Internet Explorer/Edge */
        user-select: none;
        /* Non-prefixed version, currently
	   supported by Chrome, Opera and Firefox */
    }

    .time-picker {
        display: flex;
        align-items: center;
        margin: 15px auto;
        width: 100%;
        /*justify-content:space-evenly;
            border: 1px solid #ccc;*/
        border-radius: 10px;
        padding: 0px;
        background: #dcdcdc26;
    }

    .tp-col {
        display: flex;
        flex-direction: column;
        align-items: inherit;
    }

    .tp-hr>span,
    .tp-min>span {
        /*border: 1px solid #ccc;*/
        padding: 0px 0px;
        border-radius: 4px;
        width: 30px;
        text-align: center;
        background: #ccc;
        font-size: 18px;
        font-weight: 500;
        margin: 0px 3px;
        background: #cccccc4a;
        color: #505064;
    }

    .tp-up-arrow,
    .tp-down-arrow,
    .tp-up-arrow-merdian,
    .tp-down-arrow-merdian {
        cursor: pointer;
        width: 15px;
        height: 12px;
        opacity: 0.4;
    }

    .tp-am-pm {
        cursor: pointer;
        display: block;
        padding: 0px 3px;
        border-radius: 5px;
        margin: 0px 3px;
        background: #cccccc4a;
        color: #505064;
        font-size: 16px;
        font-weight: 500;
    }

    .tp-am-pm:hover {
        background: #c5c5f5;
    }

    .tp-hr,
    .tp-min {}

    #addslottime {
        color: #505064;
        /*border: 1px solid gray;*/
        padding: 1px 8px;
        border-radius: 8px;
        font-size: 15px;
        margin-right: 5px;
        background: #cccccc4a;
    }

    .selecteddateslist {
        display: none;
    }

    .blueheader {
        font-size: 14px;
        font-weight: bolder;
        color: #4659ff;
    }

    #calander {
        padding-left: 28px;
    }

    ::-webkit-scrollbar {
        width: 4px;
        heigth: 1px !important;
    }

    ::-webkit-scrollbar:horizontal {
        height: 4px;
        background-color: red;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #e4e4e4;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    ::-webkit-scrollbar-thumb:horizontal {
        background: #e4e4e4;
        border-radius: 10px;

    }

    thead tr:first-child {
        padding-bottom: 10px;
    }

    /*#selectedslots-container>div:nth-of-type(even)
	{
		background-color: #ecececc2;
	}*/
    #selectedslots {
        padding-right: 45px;
        padding-top: 8px;
        padding-left: 30px;
    }

    .datepicker th {
        height: 36px;
    }

    .selecteddatesbtnsu,
    .selecteddatestextsu {
        background: #e7e7f3;
        width: 100%;
        font-size: 12px;
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
        color: #666666;
        margin-bottom: 5px;
    }

    .selecteddatestextsu {
        background: #c4c4f5;
    }

    #suslotpendingsection {
        margin-bottom: 10px;
    }
</style>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function() {
        console.log('yyyyyyyyyyyyyyyyy')
        // Use $j instead of $ for jQuery
        /* $j('#my-datepicker').datepicker({
                                        multidate: true,
                                        format: 'dd-mm-yyyy'
                                    });
 
                                    $j('#my-datepicker').datepicker({
 
                                        multidate: true,
                                        format: 'dd-mm-yyyy'
                                    });
 
                                    $j('#my-datepicker').on('changeDate', function(evt) {
 
                                        var selecteddates = $j('#my-datepicker').datepicker('getDates');
                                        // Rest of your code
                                    });*/

        var dateToday = new Date();
        $j('#my-datepicker').datepicker({
            format: 'dd-mm-yyyy',
            minDate: dateToday,
            multidate: true,
        });

        $j("#my-datepicker").on("change", function() {
            var selected = $j(this).val();
            alert(selected);
        });

        $j("#addcomment").click(function() {
            var comment = $j("#newcomment").val();
            if (comment == "") {
                alert("No Comment Entered");
            } else {
                $j("#commentstablebody").append("<tr><td><span class='comments'>" + comment + " </span></td><td><span class='' onClick='delete_row(this)'>x</span></td></tr>");
                $j("#newcomment").val("");
            }
        });

    });

    function delete_row(e) {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }

    function delete_datetime(elem) {
        document.getElementById(elem).remove();
        //document.getElementById("selslots_"+elem).remove();
        updateslotdropdown();
    }

    $j(document).ready(function() {
        $j('.date').datepicker({
            multidate: true,
            format: 'dd-mm-yyyy'
        });

        $j('#my-datepicker').on('changeDate', function(evt) {
            var selecteddates = $j('#my-datepicker').datepicker('getDates');
            var selecteddateslist = ""
            const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            if (selecteddates != "") {
                selecteddates = String(selecteddates);
                var selecteddatesarray = selecteddates.split(",");
                var i;
                for (i = 0; i < selecteddatesarray.length; ++i) {
                    var dateval = new Date(selecteddatesarray[i]);
                    selecteddateslist += (selecteddateslist == "") ? weekday[dateval.getDay()] + " " + month[dateval.getMonth()] + " " + dateval.getDate() : "," + weekday[dateval.getDay()] + " " + month[dateval.getMonth()] + " " + dateval.getDate();
                }
            }
            $j(".selecteddateslist").html(selecteddateslist);
        });

    });

    $j("#addslottime").click(function() {
        var availabledates = $j(".selecteddateslist").text();
        var hour = $j("#hour").html();
        hour = (hour.length == 1) ? "0" + hour : hour;
        var minute = $j("#minute").html();
        var merdian = $j("#merdian").html();
        var fullhour = $j(merdian == "PM") ? (Number(hour) + 12) : hour;
        fullhour = (fullhour == 24) ? "00" : fullhour;
        var selectedhour = Number(String(fullhour) + String(minute));
        //alert(selectedhour);
        if (availabledates != "") {
            var selecteddates = $j('#my-datepicker').datepicker('getDates');
            var selecteddateandslot = ""
            const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const minmonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            selecteddates = String(selecteddates);
            var selecteddatesarray = selecteddates.split(",");
            var i;
            var gapmsgs = "";
            for (i = 0; i < selecteddatesarray.length; ++i) {
                var timeslots = "";
                var timebtns = "";
                var dateval = new Date(selecteddatesarray[i]);
                var slotcounter = 0;
                var dateelementid = minmonth[dateval.getMonth()] + dateval.getDate() + dateval.getFullYear().toString().substr(-2);
                //$(".checkbox-round").each(function(){
                //if($(this).is(':checked'))
                if (hour != "" && minute != "" && merdian != "") {
                    //var timeslotarr=$(this).val().split("-");
                    //alert(timeslotarr[0]);
                    var timeelementid = minmonth[dateval.getMonth()] + dateval.getDate() + dateval.getFullYear().toString().substr(-2) + hour + minute + merdian;
                    var timeelementclass = dateval.getDate() + minmonth[dateval.getMonth()] + dateval.getFullYear().toString().substr(-2);
                    if ($j("#" + timeelementid).length == 0) {
                        var error = 0;
                        if ($j("#" + dateelementid).length != 0) {
                            $j("#" + dateelementid + " .timelist").each(function() {
                                var presenttime = Number($j(this).val());
                                //alert(selectedhour+"-"+(presenttime+100)+"-"+(presenttime-100));
                                if ((selectedhour < (Number(presenttime + 100))) && (selectedhour > (Number(presenttime - 100)))) {
                                    gapmsgs += (gapmsgs == "") ? dateval.getDate() + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2) : "," + dateval.getDate() + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2);
                                    error = 1;
                                }
                            });
                        }

                        var dval = dateval.getDate();
                        var datevalue = (String(dval).length == 1) ? "0" + dateval.getDate() : dateval.getDate();
                        var datedata = datevalue + "-" + minmonth[dateval.getMonth()] + "-" + dateval.getFullYear().toString().substr(-2);
                        if (error == 0) {
                            timeslots += '<div id="' + timeelementid + '" class="' + timeelementclass + '"><span class="selection-times newslot" datevalue=' + datedata + ' onclick="">' + hour + ":" + minute + " " + merdian + '</span><span class="time-delete" onclick=delete_datetime("' + timeelementid + '")>x</span><br><input type="hidden" class="timelist" value="' + fullhour + minute + '"></div>';

                            timebtns += '<div id="selslots_' + timeelementid + '" class="selecteddatesbtnsu"><span class="selslots-times">' + hour + ":" + minute + " " + merdian + '</span></div>';
                            //options+="<option value=''>"++"</option>";
                        }

                    } else {
                        alert("Time Slot Already Selected");
                        //return false;
                    }
                    slotcounter++;
                }

                //});
                if (slotcounter == 0) {
                    alert("Please Select Slot");
                    return false;
                }

                //alert($("#"+dateelementid).length);
                var dval = dateval.getDate();
                //alert(String(dval).length);
                var datevalue = (String(dval).length == 1) ? "0" + dateval.getDate() : dateval.getDate();
                selecteddateandslotstart = '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 1px 0px 0px 0px;" id="' + dateelementid + '">';
                selecteddateandslot = '<div><span class="selected-dates">' + datevalue + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2) + '</span><span class="date-delete" onclick=delete_datetime("' + dateelementid + '")>x</span><hr></div>' + timeslots;
                selecteddateandslotend = '</div>';

                selectedslotsbtnsstart = '<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12" id="selslots_' + dateelementid + '">';
                selectedslotsbtnslot = '<div><p class="selecteddatestextsu">' + datevalue + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2) + '</p></div>' + timebtns;
                selectedslotsbtnsend = '</div>';

                if ($j("#" + dateelementid).length == 0) {
                    $j("#selectedslots-container").append(selecteddateandslotstart + selecteddateandslot + selecteddateandslotend);
                    //$j("#selectedslots-container-slotpending").append(selectedslotsbtnsstart + selectedslotsbtnslot + selectedslotsbtnsend);
                } else {
                    //$("#"+dateelementid).append(selecteddateandslot);
                    $j("#" + dateelementid).append(timeslots);
                    // $j("#selslots_" + dateelementid).append(timebtns);
                }
            }

            if (gapmsgs != "") {
                alert("Slot selection time interval should have a hour gap on " + gapmsgs);
            }

        } else {
            alert("Please Select Date");
        }
        $j('#my-datepicker').val("").datepicker("update");
        $j(".selecteddateslist").html("");
        updateslotdropdown();
    });

    $j(document).ready(function() {
        var c_time = ct(new Date());
        var hr = parseInt(c_time.split(':')[0]);
        var min = parseInt(c_time.split(':')[1]);
        var meridiem = c_time.split(':')[2];
        $j('.tp-min>span').html(min < 10 ? '0' + min : min);
        $j('.tp-hr>span').html(hr);
        $j('.tp-am-pm').html(meridiem);
        $j('.tp-hr>.tp-up-arrow').click(function() {
            hr = parseInt($j('.tp-hr>span').html());
            hr = (hr == 1 ? 12 : hr -= 1);
            $j('.tp-hr>span').html(hr);
        });
        $j('.tp-min>.tp-up-arrow').click(function() {
            min = parseInt($j('.tp-min>span').html());
            min = (min == 00 ? 59 : min -= 1);
            $j('.tp-min>span').html(min < 10 ? '0' + min : min);
        });
        $j('.tp-hr>.tp-down-arrow').click(function() {
            hr = parseInt($j('.tp-hr>span').html());
            hr = (hr == 12 ? 1 : hr += 1);
            $j('.tp-hr>span').html(hr);
        });
        $j('.tp-min>.tp-down-arrow').click(function() {
            min = parseInt($j('.tp-min>span').html());
            min = (min == 59 ? 00 : min += 1);
            $j('.tp-min>span').html(min < 10 ? '0' + min : min);
        });
        $j('.tp-am-pm').click(function() {
            meridiem = meridiem == 'AM' ? 'PM' : 'AM';
            $j('.tp-am-pm').html(meridiem);
        });
        $j('.tp-hr').on('wheel', function(event) {
            var oEvent = event.originalEvent,
                delta = oEvent.deltaY || oEvent.wheelDelta;
            if (delta > 0) {
                hr = (hr == 12 ? 1 : hr += 1);
            } else {
                hr = (hr == 1 ? 12 : hr -= 1);
            }
            $j('.tp-hr>span').html(hr);
        });
        $j('.tp-min').on('wheel', function(event) {
            var oEvent = event.originalEvent,
                delta = oEvent.deltaY || oEvent.wheelDelta;
            if (delta > 0) {
                min = (min == 59 ? 00 : min += 1);
            } else {
                min = (min == 00 ? 59 : min -= 1);
            }
            $j('.tp-min>span').html(min < 10 ? '0' + min : min);
        });
        $j(".tp-hr>span").click(function() {
            this.focus();
            $j('.tp-hr>span').html('&nbsp;');
            $j(this).keyup(function(e) {
                console.log(e.keyCode);
                $j('.tp-hr>span').html();
                if (/[0-9]/.test(e.key)) {
                    var cVal = $j('.tp-hr>span').html();
                    if (cVal == '&nbsp;') {
                        $j('.tp-hr>span').html(e.key);
                    } else {
                        if (cVal == 0) {
                            $j('.tp-hr>span').append(e.key);
                            exitHr(this, $j(this));
                        } else if (cVal == 1) {
                            if (/[0-2/]/.test(e.key)) {
                                $j('.tp-hr>span').append(e.key);
                                exitHr(this, $j(this));
                            } else {
                                $j('.tp-hr>span').html(e.key);
                            }
                        } else {
                            $j('.tp-hr>span').html(e.key);
                        }
                    }
                } else if ((/13|9/.test(e.keyCode)) || (/:/.test(e.key))) {
                    exitHr(this, $j(this));
                }
            });
        });

        $j(".tp-min>span").click(function() {
            this.focus();
            $j('.tp-min>span').html('&nbsp;');
            $j(this).keyup(function(e) {
                $j('.tp-min>span').html();
                if (/[0-9]/.test(e.key)) {
                    var cVal = $j('.tp-min>span').html();
                    if ((cVal == '&nbsp;') && (/[0-5]/.test(e.key))) {
                        $j('.tp-min>span').html(e.key);
                    } else {
                        $j('.tp-min>span').append(e.key);
                        exitMin(this, $j(this));
                    }
                } else if ((/13|9/.test(e.keyCode)) || (/:/.test(e.key))) {
                    exitMin(this, $j(this));
                }
            });
        });
        $j('.tp-hr>span').blur(function() {
            var a = $j('.tp-hr>span').html();
            if ((a == '') || (a == '&nbsp;')) {
                var hr = parseInt(ct(new Date()).split(':')[0]);
                $j('.tp-hr>span').html(hr);
            }
        });
        $j('.tp-min>span').blur(function() {
            var a = $j('.tp-min>span').html();
            if ((a == '') || (a == '&nbsp;')) {
                var min = parseInt(ct(new Date()).split(':')[1]);
                $j('.tp-min>span').html(min);
            }
        });
    });

    function exitHr(a, b) {
        a.blur();
        b.off('keyup');
        $(".tp-min>span").trigger("click");
    }

    function exitMin(a, b) {
        a.blur();
        b.off('keyup');
    }

    function ct(date) {
        var hrs = date.getHours();
        var mns = date.getMinutes();
        var mer = hrs >= 12 ? 'PM' : 'AM';
        hrs = hrs % 12;
        hrs = hrs ? hrs : 12;
        mns = mns < 10 ? '0' + mns : mns;
        return (hrs + ':' + mns + ':' + mer);
    }
</script>
</style>
@section('footer')
@endsection
@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection