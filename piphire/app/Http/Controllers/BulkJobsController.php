<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Job;
use App\BulkJob;
use App\Organization;
use App\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DB;
use DateTime;
use Illuminate\Support\Facades\Log;


class BulkJobsController extends Controller
{

    public function index(Request $request)
    {

        $header_class = "bulkJobs";

        $queryResult = DB::table('jobs')
            ->select('jobs.juid', 'jobs.name', 'bulk_jobs.bjuid', 'bulk_jobs.title', 'bulk_jobs.created_at')
            ->join('bulk_jobs', 'bulk_jobs.id', '=', 'jobs.bulk_job_id')
            ->where('jobs.user_id', auth()->user()->id)
            ->orderBy('bulk_jobs.created_at', 'DESC')
            ->get();
        $bjid = DB::table('candidate__jobs')
            ->select('candidates.organization_id', 'candidate__jobs.bulk_job_id')
            ->join('candidates', 'candidates.id', '=', 'candidate__jobs.candidate_id')
            ->where('candidates.organization_id', auth()->user()->organization_id)
            ->whereNotNull('candidate__jobs.bulk_job_id')
            ->count();



        $fitments_left =  Organization::where('id', auth()->user()->organization_id)->get()[0]->left_search;

        $bulkJobs = array();
        foreach ($queryResult as $job) {

            if (array_key_exists($job->bjuid, $bulkJobs)) {
                array_push($bulkJobs[$job->bjuid]['jobs'], $job);
                $bulkJobs[$job->bjuid]['count'] += 1;
            } else {
                $dateObj = new DateTime($job->created_at);
                $bulkJobs[$job->bjuid]['bjuid'] = $job->bjuid;
                $bulkJobs[$job->bjuid]['created_at'] = $dateObj->format('Y-m-d');
                $bulkJobs[$job->bjuid]['title'] = $job->title;
                $bulkJobs[$job->bjuid]['jobs'] = [$job];
                $bulkJobs[$job->bjuid]['count'] = 1;
            }
        }
        $user_email = auth()->user()->email;

        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();


        return view('frontend/bulkJobs/index', compact('header_class', 'bulkJobs', 'user_email', 'fitments_left', 'bjid','auto_job','schedule'));
    }
    public function search(Request $request)
    {

        $header_class = "bulkJobs";
        $queryResult = DB::table('jobs')
            ->select('jobs.juid', 'jobs.name', 'bulk_jobs.bjuid', 'bulk_jobs.title', 'bulk_jobs.created_at')
            ->join('bulk_jobs', 'bulk_jobs.id', '=', 'jobs.bulk_job_id')
            ->when($request->input('jobName'), function ($query, $jobName) {
                $query->where('bulk_jobs.title', $jobName);
            })
            ->where('jobs.user_id', auth()->user()->id)->orderBy('bulk_jobs.created_at', 'DESC')->get();
        $bulkJobs = array();
        foreach ($queryResult as $job) {
            if (array_key_exists($job->bjuid, $bulkJobs)) {
                array_push($bulkJobs[$job->bjuid]['jobs'], $job);
                $bulkJobs[$job->bjuid]['count'] += 1;
            } else {
                $dateObj = new DateTime($job->created_at);
                $bulkJobs[$job->bjuid]['bjuid'] = $job->bjuid;
                $bulkJobs[$job->bjuid]['created_at'] = $dateObj->format('Y-m-d');
                $bulkJobs[$job->bjuid]['title'] = $job->title;
                $bulkJobs[$job->bjuid]['jobs'] = [$job];
                $bulkJobs[$job->bjuid]['count'] = 1;
            }
        }
        $user_email = auth()->user()->email;
        $bjid = '';
        $fitments_left = '';

        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/bulkJobs/index', compact('header_class', 'bulkJobs', 'user_email', 'fitments_left', 'bjid','auto_job','schedule'));
    }
    public function searchhistory(Request $request)
    {
        $sortval = $request->sort;
        $bjid = BulkJob::where('bjuid', $request->bjuid)->first()->id;

        $organization = Organization::where('id', auth()->user()->organization_id)->first();
        if (auth()->user()->is_manager == '1') {
            $jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('bulk_job_id', $bjid);
        } else {
            $jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('bulk_job_id', $bjid)->where('user_id', auth()->user()->id);
        }

        $jobname = '';
        if ($request->jobname) {
            $jobname = $request->jobname;
            $jobs->where('name', 'like', '%' . $jobname . '%');
        }

        $sel_startdate = $startdate = '2020-01-01';
        $sel_enddate = $enddate = Carbon::now()->format('Y-m-d');

        if ($request->from && $request->to) {
            $sel_startdate = Carbon::createFromFormat('m/d/Y', trim($request->from))->format('Y-m-d');
            $sel_enddate = Carbon::createFromFormat('m/d/Y', trim($request->to))->format('Y-m-d');

            $jobs->whereDate('created_at', '>=', $sel_startdate)->whereDate('created_at', '<=', $sel_enddate);
        }

        if ($sortval != 'resume') {
            $jobs->orderBy('created_at', 'DESC');
        } else {
            $jobs->orderBy('candidates_count', 'DESC');
        }

        $jobs = $jobs->paginate(10);
        $jobs->appends(request()->input())->links();


        $header_class   = 'history';
        $sortval        = $sortval;
        $jobname        = $jobname;
        $startdate      = $startdate;
        $enddate        = $enddate;

        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/bulkJobs/history', compact('header_class', 'jobs', 'sortval', 'jobname', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate','auto_job','schedule'));
    }



    public function upload(Request $request)
    {
        $bulkJob = new BulkJob();
        $bulkJob->bjuid = Uuid::uuid4()->toString();
        $bulkJob->title = $request->title;
        $bulkJob->save();

        $userdets = User::where('email', $request->email)->first();
        $data     = array();
        $job_arr = $request->payload;
        $organization = Organization::where('id', auth()->user()->organization_id)->first();
        $search_left = $organization->left_search;


        if ($userdets) {
            $total = 0;
            foreach ($job_arr as $item) {
                $total += (int)$item["vacant_positions"];
            }
            if ($total > (int) $search_left) {
                $data['status'] = false;
                $data['message'] = "No Fitments left";
                return response()->json($data);
            }

            $job_id_arr = array();
            foreach ($job_arr as $item) {
                $juid = Uuid::uuid1()->toString();
                $job = new Job();
                $job->juid              = Uuid::uuid1()->toString();
                $job->organization_id   = $userdets->organization_id;
                $job->user_id           = $userdets->id;
                $job->name              = $item['jobtitle'];
                $job->description       = $item['jobdescription'];
                $job->location          = $item['location'];
                $job->min_experience    = $item['min_experience'];
                $job->max_experience    = $item['max_experience'];
                $job->joining_date      = Carbon::parse($item['joining_date'])->format('Y-m-d');
                $job->job_role          = $item['job_role'];
                $job->offered_ctc       = $item['offered_ctc'];
                $job->vacant_positions = $item['vacant_positions'];
                $job->juid = $juid;
                $job->bulk_job_id = $bulkJob->id;
                $job->mandatory_skills = $item['mandatory_skills'];

                $job->save();
                array_push($job_id_arr, strval($job->id));
            }


            $post = json_encode(array(
                "user_id" => strval($userdets->id),
                "organization_id" => strval($userdets->organization_id),
                "job_id" => $job_id_arr
            ));
            $ch = curl_init(env('BULKJOB_URL'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            // execute!
            $pythonCall = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);
            if ($pythonCall == '') {
                $jo = BulkJob::where('id', $bulkJob->id)->delete();

                $j = Job::where('bulk_job_id', $bulkJob->id)->delete();
            }

            $output = array();
            if ($pythonCall == "No recommendation") {
                $data['message'] = "No profiles found";
            } else {
                $result = json_decode($pythonCall);
                $data['message'] = $result;
                $resJobs = array();
                if ($result) {
                    foreach ($result as $item) {
                        if (!in_array($item->Jd, $resJobs)) {
                            array_push($resJobs, $item->Jd);
                        }
                    }
                }
                $resPos = array();
                if ($result) {
                    foreach ($result as $item) {
                        if (!in_array($item->vacant_positions, $resPos)) {
                            array_push($resPos, $item->vacant_positions);
                        }
                    }
                }

                $organization->left_search -= $item->vacant_positions;
                $organization->save();

                foreach ($result as $item) {


                    $candi = DB::table('candidates')
                        ->where('id', $item->resume_id)
                        ->where('organization_id', auth()->user()->organization_id)->count();
                    Log::error($candi . '$candidat');
                    if ($candi != 0) {

                        $candidate_id = DB::table('candidates')->where('id', $item->resume_id)->where('organization_id', auth()->user()->organization_id)->get('id')->first()->id;
                        Log::error($candidate_id . '$candidate_id$candidate_id');

                        DB::table('candidate__jobs')->insert([
                            "job_id" => $item->Jd,
                            "candidate_id" => $candidate_id,
                            "score" => $item->NormScore,
                            "hired" => 0,
                            "is_scored" => 1,
                            "bulk_job_id" => $bulkJob->id

                        ]);
                        $output['id'] = $item->Jd;
                        $output['score'] = $item->NormScore;
                        $output['organization_id'] = $item->organization_id;
                        $output['resume_id'] = $item->resume_id;
                        $output['user_id'] = $item->user_id;
                    }
                }
            }


            $data['status'] = true;
            $data['data']   = $bulkJob->bjuid;
        } else {

            $data['status'] = false;
            $data['data']   = array();
            $data['message'] = 'Not a valid user.';
        }




        return response()->json($data);
    }



    // list history of jobs
    public function history(Request $request)
    {

        $organization = Organization::where('id', auth()->user()->organization_id)->first();


        $bjid = BulkJob::where('bjuid', $request->bjuid)->first()->id;
        $sortval = 'date';


        if (auth()->user()->is_manager == '1') {

            $jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('bulk_job_id', $bjid)->orderBy('created_at', 'DESC')->paginate(25);
        } else {

            $jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('user_id', auth()->user()->id)->where('bulk_job_id', $bjid)->orderBy('created_at', 'DESC')->paginate(25);
        }

        $header_class   = 'bulkJobs';
        $sortval        = $sortval;
        $jobname        = '';
        $sel_startdate = $startdate = '2020-01-01';
        $sel_enddate = $enddate = Carbon::now()->format('Y-m-d');
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/bulkJobs/history', compact('header_class', 'jobs', 'sortval', 'jobname', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate','auto_job','schedule'));
    }
}
