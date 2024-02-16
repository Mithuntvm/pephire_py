<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use App\Job;
use App\Candidate;
use App\ShortlistedCandidate;
use App\ShortListedCandidatesTrans;
use App\InterviewTimeslot;
use App\InterviewTimeslotTrans;
use App\InterviewerDetails;
use App\Candidate_Jobs;
use App\CandidateStages;
use Illuminate\Support\Facades\Log;
use App\ConfigurableCandidatestages;

use App\Organization;

class InterviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeShortlistedCandidates(Request $request, $juid)
    {
        $job = Job::where('juid', $request->juid)->first();

        foreach ($request->candidatesArr as $candidate_id) {

            $cand = ShortlistedCandidate::where('candidate_id', $candidate_id)->where('job_id', $job->id)->count();
            if ($cand == 0) {

                $shortlisted = new ShortlistedCandidate();
                $shortlisted->user_id = auth()->id();
                $shortlisted->job_id = $job->id;
                $shortlisted->candidate_id = $candidate_id;
                $shortlisted->save();

                $shortlistedtrans = new ShortListedCandidatesTrans();
                $shortlistedtrans->user_id = auth()->id();
                $shortlistedtrans->job_id = $job->id;
                $shortlistedtrans->candidate_id = $candidate_id;
                $shortlistedtrans->oid = auth()->user()->organization_id;
                $shortlistedtrans->sid = $shortlisted->id;
                $shortlistedtrans->save();
                $job->ruid = 'shortlisted';
                $job->save();

                $candidate__jobs = Candidate_Jobs::where('candidate_id', $candidate_id)->first();
                $candidate__jobs->shortlist = 1;
                $candidate__jobs->save();
                // $candidateobs = ConfigurableCandidateStage::where('candidate_id', $candidate_id)->first();
                // Log::error($candidateobs.'candidateobscandidateobscandidateobs');
                $stage = new ConfigurableCandidatestages();
                $stage->user_id = auth()->user()->id;
                $stage->org_id = auth()->user()->organization_id;
                $stage->job_id = $job->id;
                $stage->candidate_id = $candidate_id;
                $stage->stage = 'sourced';
                $stage->status = 'sourced';
                $stage->save();


                $fetchJob = Job::where('id', $job->id)->first();

                $candidate_stages = DB::connection('pephire')
                    ->table('comment')
                    ->insert([

                        'comment' => 'This candidate is shortlisted for the Job' . $fetchJob->name . '.',
                        'candidate_id' => $candidate_id,
                        'user_id' => 'Pephire',
                        'date' => Carbon::now(),
                    ]);




                $can = DB::connection('pephire_trans')
                    ->table('candidate_stages_v2')->where('id', $candidate_id)->where('event', 'shortlist-intro')
                    ->where('oid', auth()->user()->organization_id)
                    ->delete();


                $candidate_stages = DB::connection('pephire_trans')
                    ->table('candidate_stages_v2')
                    ->insert([
                        'id' => $candidate_id,
                        'event' => 'shortlist-intro',
                        'oid' => auth()->user()->organization_id,
                        'usertype' => 'candidate',
                        'status' => 'incomplete',
                        'date' => Carbon::now(),
                    ]);

                $candidate = Candidate::where('id', $candidate_id)->first();

                $candidate->shortlist = '1';
                $candidate->save();


                $candidate_jobs = Candidate_Jobs::where('candidate_id', $candidate_id)->first();

                $candidate_jobs->shortlist = '1';
                $candidate_jobs->save();

                // $stages = DB::connection('pephire')
                //     ->table('configurable_candidatestage')
                //     ->insert([

                //         'user_id' => auth()->user()->id,
                //         'org_id' => auth()->user()->organization_id,
                //         'job_id' => $job->id,
                //         'candidate_id' => $candidate_id,
                //         'stage' => 'sourced',
                //     ]);

                $phone = str_replace('+', '', $candidate->phone);
                $phone = str_replace(' ', '', $phone);
                if (strlen($phone) > 10) {
                    $phone = $phone;
                } else {
                    $phone = '91' . $phone;
                }

                $personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                    'Phone' => $phone,
                    'usertype' => 'candidate',
                    'Parameters' => 'Job',
                    'ParameterValue' => $job->name,
                    'oid' => $candidate->organization_id,

                ]);
            }
        }

        return response()->json(['status' => true, 'redirect_url' => route('shortlistedCandidates.show', $juid)]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showShortlistedCandidates($juid)
    {
        $fetchJob = Job::where('juid', $juid)->first();
        $shortlisted = $fetchJob->shortlisted_candidates->pluck('candidate_id')->toArray();

        $job = Job::with(
            ['candidates.newskills', 'candidates' => function ($q) use ($shortlisted) {
                $q->whereIn('candidates.id', $shortlisted);
            }]
        )->where('juid', $juid)->first();
        foreach ($shortlisted as $id) {
            Log::error($id . 'my id is thisss');
            $cand = Candidate::where('id', $id)
                ->where('organization_id', auth()->user()->organization_id)
                ->first();

            if ($cand) {

                Log::error('inserted to personlisation pararmeter');

                $phone = str_replace('+', '', $cand->phone);
                $phone = str_replace(' ', '', $phone);
                if (strlen($phone) > 10) {
                    $phone = $phone;
                } else {
                    $phone = '91' . $phone;
                }

                $del1 = DB::connection('pephire_trans')
                    ->table('personalization_parameters_v2')
                    ->where('Phone', $phone)
                    ->where('usertype', 'candidate')
                    ->where('Parameters', 'Name')
                    ->where('oid', auth()->user()->organization_id)
                    ->delete();

                $del2 = DB::connection('pephire_trans')
                    ->table('personalization_parameters_v2')
                    ->where('Phone', $phone)
                    ->where('usertype', 'candidate')
                    ->where('Parameters', 'DataLink')
                    ->where('oid', auth()->user()->organization_id)
                    ->delete();

                $personalizationA_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                    'Phone' => $phone,
                    'usertype' => "candidate",
                    'Parameters' => 'Name',
                    'ParameterValue' => $cand->name,
                    'oid' => $cand->organization_id,

                ]);

                $personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                    'Phone' => $phone,
                    'usertype' => "candidate",
                    'Parameters' => 'DataLink',
                    'ParameterValue' => route('candidateProfile.edit', $cand->cuid),
                    'oid' => $cand->organization_id,

                ]);

                $personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')
                    ->where('phone', $phone)->where('Parameters', 'Datalink')
                    ->update(['parameterValue' => route('candidateProfile.edit', $cand->cuid)]);

                $link_verification = DB::connection('pephire_trans')->table('link_verification_status')->insert([
                    'QnID' => 'DataLink',
                    'Phone' => $cand->phone,
                    'link_status' => 0,
                    'oid' => $cand->organization_id
                ]);

                $candidate_profile_links = DB::table('candidate_profile_links')
                    ->insert([
                        'candidate_id' => $cand->id,
                        'webLink' => route('candidateProfile.edit', $cand->cuid),
                    ]);
            }
        }

        $createdSlotsCount = InterviewTimeslot::where('job_id', $job->id)->count();
        $isEdit['shortlisted'] = $job->shortlisted_candidates()->exists();
        $isEdit['scheduled'] = $isEdit['timeslot'] = $createdSlotsCount > 0 ? true : false;

        $header_class   = 'history';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/job/shortlisted', compact('header_class', 'job', 'isEdit', 'fetchJob', 'auto_job', 'schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateShortlistedCandidates(Request $request, $juid)
    {
        $job = Job::where('juid', $request->juid)->first();
        $existingShortlisted = $job->shortlisted_candidates;

        foreach ($existingShortlisted as $shortlisted) {
            if (!in_array($shortlisted->candidate_id, $request->candidatesArr)) {
                $shortlisted->hasFinalized = 0;
                $shortlisted->save();
            }
        }

        return response()->json(['status' => true, 'redirect_url' => route('interviewTimeSlot.view', $juid)]);
    }

    public function viewInterviewTimeSlot($juid)
    {

        $fetchJob = Job::where('juid', $juid)->first();
        $shortlisted = $fetchJob->shortlisted_candidates->pluck('candidate_id')->toArray();

        $job = Job::with(
            ['candidates.newskills', 'candidates' => function ($q) use ($shortlisted) {
                $q->whereIn('candidates.id', $shortlisted);
            }]
        )->where('juid', $juid)->first();

        $maxSlotsCount = $job->shortlisted_candidates()->where('hasFinalized', 1)->count() + 6;
        $createdSlotsCount = InterviewTimeslot::where('job_id', $job->id)->count();

        $timeslots = InterviewTimeslot::where('job_id', $job->id)
            ->orderBy('interview_date', 'ASC')
            ->orderBy('interview_start_time', 'ASC')
            ->get()
            ->groupBy(['interview_date', 'interviewer_name']);

        $isEdit['shortlisted'] = $isEdit['timeslot'] = $job->shortlisted_candidates()->exists();
        $isEdit['scheduled'] = $createdSlotsCount > 0 ? true : false;

        $header_class   = 'history';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/job/timeslot', compact('header_class', 'job', 'timeslots', 'maxSlotsCount', 'createdSlotsCount', 'isEdit', 'auto_job', 'schedule'));
    }

    public function storeInterviewTimeSlot(Request $request, $juid)
    {


        $contact_phone = $request->contact_number;

        $contact_phone = str_replace("+", "", $contact_phone);
        $contact_phone = str_replace(" ", "", $contact_phone);
        $contact_phone = str_replace("-", "", $contact_phone);

        $job = Job::where('juid', $juid)->first();

        $event = DB::table('jobs')
            ->where('juid', $juid)
            ->update(['ruid' => 'timeslot']);

        $maxSlotsCount = $job->shortlisted_candidates()->where('hasFinalized', 1)->count() + 2;
        $createdSlotsCount = InterviewTimeslot::where('job_id', $job->id)->count();

        $addMins  = 60 * (int)$request->duration;
        $startTime = strtotime($request->interview_date . ' ' . $request->start_time);
        $endTime = strtotime($request->interview_date . ' ' . $request->end_time);

        $loop = 1;
        while ($startTime < $endTime) {
            $timeslot = new InterviewTimeslot();
            $timeslot->job_id = Job::where('juid', $request->juid)->first()->id;
            $timeslot->user_id = auth()->id();
            $timeslot->interviewer_name = trim($request->name);
            $timeslot->email = $request->email;
            $timeslot->contact_number = $contact_phone;
            $timeslot->interview_date = $request->interview_date;
            $timeslot->interview_start_time = $startTime;

            $timeslot->interview_end_time = ($startTime + $addMins);
            $timeslot->meeting_details = trim($request->meeting_details);
            $timeslot->save();


            $timeslot2 = new InterviewTimeslotTrans();
            $timeslot2->job_id = Job::where('juid', $request->juid)->first()->id;
            $timeslot2->user_id = auth()->id();
            $timeslot2->interviewer_name = trim($request->name);
            $timeslot2->email = $request->email;
            $timeslot2->contact_number = $contact_phone;
            $timeslot2->interview_date = $request->interview_date;
            $timeslot2->interview_start_time = date("Y-m-d H:i:s", $startTime);
            $timeslot2->interview_end_time = date("Y-m-d H:i:s", ($startTime + $addMins));
            $timeslot2->meeting_details = trim($request->meeting_details);
            $timeslot2->oid = auth()->user()->organization_id;
            $timeslot2->interview_id = $timeslot->id;
            $timeslot2->save();

            $timeslot->reference_id = $timeslot2->id;
            $timeslot->save();


            $timeslot3 = new InterviewerDetails();
            $timeslot3->job_id = Job::where('juid', $request->juid)->first()->id;
            $timeslot3->user_id = auth()->id();
            $timeslot3->interviewer_name = trim($request->name);
            $timeslot3->email = $request->email;
            $timeslot3->contact_number = $contact_phone;
            $timeslot3->oid = auth()->user()->organization_id;
            $timeslot3->interview_id = $timeslot->id;
            $timeslot3->interview_trans_id = $timeslot2->id;


            $timeslot3->save();


            $startTime += $addMins;
            $loop++;
        }


        $submittedCandidatesArr = InterviewTimeslot::where('job_id', $job->id)
            ->where('hasAllotted', 1)->pluck('allotted_candidate_id')->toArray();
        $alreadyLinkSentCandidates = DB::table('candidate_interview_links')
            ->where('job_id', $job->id)
            ->pluck('candidate_id')->toArray();

        $finalShortlistedCandidates = $job->shortlisted_candidates()->where('hasFinalized', 1)
            ->whereNotIn('candidate_id', array_merge($submittedCandidatesArr, $alreadyLinkSentCandidates))
            ->get();

        foreach ($finalShortlistedCandidates as $finalShortlistedCandidate) {
            $candidate = $finalShortlistedCandidate->candidate;


            $candidate_stages = DB::connection('pephire_trans')
                ->table('candidate_stages_v2')
                ->insert([
                    'id' => $candidate->id,
                    'event' => 'interview',
                    'oid' => $candidate->organization_id,
                    'usertype' => 'candidate',
                    'status' => 'incomplete',
                    'date' => Carbon::now(),
                ]);

            Log::error($candidate_stages . 'candidate_stages');
            $fetchJob = Job::where('juid', $request->juid)->first();


            $candidate_stages = DB::connection('pephire')
                ->table('comment')
                ->insert([

                    'comment' => 'This candidate is selected to the interview for the Job ' . $fetchJob->name . '.',
                    'candidate_id' => $candidate->id,
                    'user_id' => 'Pephire',
                    'date' => Carbon::now(),
                ]);

            $link_verification = DB::connection('pephire_trans')->table('link_verification_status')->insert([
                'QnID' => 'InterviewLink',
                'Phone' => $candidate->phone,
                'link_status' => '0',
                'oid' => $candidate->organization_id,
            ]);
            $stage = DB::connection('pephire_trans')->table('laststage_v2')->insert([
                'Phone' => $candidate->phone,
                'stage' => 'Interview'
            ]);

            $phone = str_replace('+', '', $candidate->phone);
            $phone = str_replace(' ', '', $phone);
            if (strlen($phone) > 10) {
                $phone = $phone;
            } else {
                $phone = '91' . $phone;
            }

            $personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' => $phone,
                'usertype' => "candidate",
                'Parameters' => 'InterviewLink',
                'ParameterValue' => route('interviewCandidateProfile.edit', $finalShortlistedCandidate->sluid),
                'oid' => $candidate->organization_id,


            ]);

            $personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')
                ->where('phone', $phone)->where('Parameters', 'InterviewLink')
                ->update(['parameterValue' => route('interviewCandidateProfile.edit', $finalShortlistedCandidate->sluid)]);




            $candidate_interview_links = DB::table('candidate_interview_links')
                ->insert([
                    'job_id' => $job->id,
                    'candidate_id' => $candidate->id,
                    'webLink' => route('interviewCandidateProfile.edit', $finalShortlistedCandidate->sluid),
                ]);
        }

        return response()->json(['status' => true, 'redirect_url' => route('interviewTimeSlot.view', $juid)]);
    }

    public function showScheduledCandidates($juid)
    {
        $fetchJob = Job::where('juid', $juid)->first();

        $event = DB::table('jobs')
            ->where('juid', $juid)
            ->update(['ruid' => 'scheduled']);

        $shortlisted = $fetchJob->shortlisted_candidates()->where('hasFinalized', 1)->pluck('candidate_id')->toArray();

        $job = Job::with(
            ['candidates.newskills', 'candidates' => function ($q) use ($shortlisted) {
                $q->whereIn('candidates.id', $shortlisted);
            }]
        )->where('juid', $juid)->first();

        $isEdit = $job->shortlisted_candidates()->exists();

        $interviewersArr = InterviewTimeslot::where('job_id', $job->id)->distinct('interviewer_name')->pluck('interviewer_name')->toArray();

        $sel_startdate = $startdate = InterviewTimeslot::where('job_id', $job->id)->orderBy('interview_date', 'asc')->first()->interview_date;
        $sel_enddate = $enddate = InterviewTimeslot::where('job_id', $job->id)->orderBy('interview_date', 'desc')->first()->interview_date;
        $sel_starttime = 0;
        $sel_endtime = 1440;
        $header_class   = 'history';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/job/scheduled', compact('header_class', 'job', 'fetchJob', 'isEdit', 'interviewersArr', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'sel_starttime', 'sel_endtime', 'auto_job', 'schedule'));
    }

    public function filterScheduledCandidates(Request $request)
    {

        $fetchJob = Job::where('juid', $request->juid)->first();
        $sel_startdate = Carbon::createFromFormat('m/d/Y', trim($request->from))->format('Y-m-d');
        $sel_enddate = Carbon::createFromFormat('m/d/Y', trim($request->to))->format('Y-m-d');
        $sel_interviewer_name = $request->interviewer;

        // interview_start_time contains interview date as well
        $sel_starttime = $request->from_time;
        $s_hrs = floor($sel_starttime / 60);
        $s_mins = $sel_starttime - ($s_hrs * 60);
        $filter_start_time = strtotime($sel_startdate . ' ' . $s_hrs . ':' . $s_mins);

        // interview_end_time contains interview date as well
        $sel_endtime = $request->to_time;
        $e_hrs = floor($sel_endtime / 60);
        $e_mins = $sel_endtime - ($e_hrs * 60);
        $filter_end_time = strtotime($sel_enddate . ' ' . $e_hrs . ':' . $e_mins);

        $submittedCandidatesArr = InterviewTimeslot::where('job_id', $fetchJob->id)
            ->where('hasAllotted', 1)
            ->where('interview_start_time', '>=', $filter_start_time)->where('interview_start_time', '<=', $filter_end_time);

        if ($sel_interviewer_name) {
            $submittedCandidatesArr = $submittedCandidatesArr->where('interviewer_name', $sel_interviewer_name);
        }
        $submittedCandidatesArr = $submittedCandidatesArr->pluck('allotted_candidate_id')->toArray();

        $job = Job::with(
            ['candidates.newskills', 'candidates' => function ($q) use ($submittedCandidatesArr) {
                $q->whereIn('candidates.id', $submittedCandidatesArr);
            }]
        )->where('juid', $request->juid)->first();

        $isEdit = $job->shortlisted_candidates()->exists();


        $interviewersArr = InterviewTimeslot::where('job_id', $job->id)->distinct('interviewer_name')->pluck('interviewer_name')->toArray();

        $startdate = InterviewTimeslot::where('job_id', $job->id)->orderBy('interview_date', 'asc')->first()->interview_date;
        $enddate = InterviewTimeslot::where('job_id', $job->id)->orderBy('interview_date', 'desc')->first()->interview_date;
        $header_class   = 'history';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/job/scheduled', compact('header_class', 'job', 'fetchJob', 'isEdit', 'interviewersArr', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'sel_starttime', 'sel_endtime', 'sel_interviewer_name', 'auto_job', 'schedule'));
    }
}
