<?php

namespace App\Http\Controllers;

use App\ApplyFilter;
use DB;
use App\Job;
use App\User;
use App\Skill;
use App\Resume;
use App\Candidate;
use Carbon\Carbon;
use App\PendingJob;
use Ramsey\Uuid\Uuid;
use App\Organization;
use App\Candidate_Jobs;
use App\Candidate_Skill;
use Illuminate\Http\Request;
use App\Organizations_Hold_Resume;
use App\InterviewTimeslot;
use App\InterviewerDetails;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use App\ShortlistedCandidate;
use App\CandidateTimeslots;
use App\CandidateMasterStatu;
use App\CandidateSubStatus;
use App\ConfigurableCandidatestages;

class JobController extends Controller
{


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['Apijobsubmit', 'candidate', 'jobreport']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$header_class = 'jobs';
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/job/list', compact('header_class', 'auto_job', 'schedule'));
	}

	public function dataTable(Request $request)
	{

		$organization = Organization::where('id', auth()->user()->organization_id)->first();

		$jobs        = Job::with('organization', 'User')->where('organization_id', $organization->id)->where('user_id', auth()->user()->id)->get();

		return datatables($jobs)
			->addColumn('actions', function ($job) {

				if (!$job->deleted_at) {

					return [
						'view_link' => url('/jobs/' . $job->juid . '/view'),
						'custom_link' => url('/jobs/delete/' . $job->id),
						'custom_title' => 'Delete',
						'custom_class' => 'btn-danger del-resource'
					];
				} else {

					return [
						'view_link' => url('/jobs/' . $job->juid . '/view'),
						'custom_link' => url('/jobs/activate/' . $job->id),
						'custom_title' => 'Activate',
						'custom_class' => 'btn-success act-resource'
					];
				}
			})
			->setRowClass(function ($job) {
				return ($job->deleted_at) ? 'alert-warning' : '';
			})
			->toJson();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		if ($organization->left_search < 1) {
			return redirect('/plan-expired');
		}


		if ($organization->plan_end_date < Carbon::now()->format('Y-m-d')) {
			return redirect('/plan-expired');
		}



		$job_roles = \DB::connection('pephire_static')
			->table('rolealias')
			->groupBy('Alias')
			->pluck('Alias')->toArray();

		$job_role_categories = \DB::connection('pephire_static')
			->table('rolecategory_master')
			->where('Domain', 'IT')
			->select('Role Category')->get()->toArray();

		if (count($job_role_categories) > 0) {
			$job_role_categories = array_column($job_role_categories, 'Role Category');
		}

		sort($job_roles);
		sort($job_role_categories);

		$resumes = Organizations_Hold_Resume::with('candidate')->with('resume')->where('organization_id', $organization->id)
			->where('user_id', auth()->user()->id)
			->take($organization->max_resume_count)
			->get();

		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();

		$totalcount    = count($resumes);

		$header_class  = 'jobs';
		$resume_client = (empty($resumes)) ? $organization->max_resume_count : $organization->max_resume_count - $resumes->count();

		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();


		return view('frontend/job/create', compact('header_class', 'resumes', 'resume_client', 'totalcount', 'existjob', 'organization', 'job_roles', 'job_role_categories', 'auto_job', 'schedule'));
	}


	public function notInterested(Request $request, $juid)
	{

		foreach ($request->candidatesArr as $candidate_id) {

			$cand = Candidate::where('id', $candidate_id)->first();

			$cand->status = 3;
			$cand->update();
		}
		return response()->json();
	}
	public function reuseHistory(Request $request, $juuid)
	{
		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		if ($organization->left_search < 1) {
			return redirect('/plan-expired');
		}

		if ($organization->plan_end_date < Carbon::now()->format('Y-m-d')) {
			return redirect('/plan-expired');
		}
		$history = Job::where('juid', $juuid)->first();

		$job_roles = \DB::connection('pephire_static')
			->table('rolealias')
			->groupBy('Alias')
			->pluck('Alias')->toArray();

		$job_role_categories = \DB::connection('pephire_static')
			->table('rolecategory_master')
			->where('Domain', 'IT')
			->select('Role Category')->get()->toArray();

		if (count($job_role_categories) > 0) {
			$job_role_categories = array_column($job_role_categories, 'Role Category');
		}

		sort($job_roles);
		sort($job_role_categories);

		$resumes = Organizations_Hold_Resume::with('candidate')->with('resume')->where('organization_id', $organization->id)
			->where('user_id', auth()->user()->id)
			->take($organization->max_resume_count)
			->get();


		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();

		$totalcount    = count($resumes);
		$header_class  = 'jobs';
		$resume_client = (empty($resumes)) ? $organization->max_resume_count : $organization->max_resume_count - $resumes->count();
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/job/reuse', compact('header_class', 'resumes', 'resume_client', 'totalcount', 'existjob', 'organization', 'job_roles', 'job_role_categories', 'history', 'auto_job', 'schedule'));
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$organization = Organization::where('id', auth()->user()->organization_id)->first();

		$candidates = Organizations_Hold_Resume::where('organization_id', $organization->id)
			->where('user_id', auth()->user()->id)
			->get();


		if (empty($candidates)) {
			return redirect('/jobs/create')->with('warning', 'No resume selected/uploaded');
		}

		if ($request->skills != '') {

			foreach ($request->skills as $skill) {
				$sk[] = $skill;
			}


			$skills = implode(',', $sk);
		}

		DB::beginTransaction();

		$job = new Job();
		$job->juid              = Uuid::uuid1()->toString();
		$job->organization_id   = $organization->id;
		$job->user_id           = auth()->user()->id;
		$job->name              = trim($request->jobtitle);
		$job->description       = trim($request->jobdescription);
		$job->joining_date       = trim($request->joining_date) ?: null;
		$job->min_experience    = trim($request->min_experience);
		$job->max_experience       = trim($request->max_experience);
		$job->mandatory_skills       = trim($skills);

		$job->location       = trim($request->location);
		$job->job_role       = trim($request->job_role);
		$job->job_role_category       = trim($request->job_role_category);
		$job->offered_ctc       = trim($request->offered_ctc);
		$job->vacant_positions    = '1';
		$job->save();

		if (!empty($candidates)) {
			foreach ($candidates as $ck) {
				$candidates_jobs = new Candidate_Jobs;
				$candidates_jobs->job_id       = $job->id;
				$candidates_jobs->candidate_id = $ck->candidate_id;
				$candidates_jobs->skills = $ck->skills;
				$candidates_jobs->save();

				$cand = Candidate::where('id', $ck->candidate_id)
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
		}

		Organizations_Hold_Resume::where('organization_id', $organization->id)
			->where('user_id', auth()->user()->id)
			->delete();

		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();
		if ($existjob) {
			$existjob->delete();
		}

		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)->where('uid', auth()->user()->id)
			->where('page', 'pickprofile')->first();
		if ($filter) {
			$filter->delete();
		}


		$data = array();
		if (!empty($job)) {
			$rIds = '';
			foreach ($job->candidates as $jk) {
				$rIds .= $jk->id . '|';
			}

			$data[] = array(
				'job_id' => $job->id,
				'description' => $job->description,
				'candidate_id' => $rIds,
				'organization_id' => auth()->user()->organization_id,
				'user_id' => auth()->user()->id
			);
		}


		$postdata = json_encode($data);
		$string1 = $postdata;
		$post = preg_replace('(^.)', '', $string1);
		$post = preg_replace('(.$)', '', $post);
		$ch = curl_init(env('JOBCTRL_URL'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);
		$myfile = fopen("C:\Pephire\FitmentReq.txt", "w") or die("Unable to open file!");
		$txt = $string1;
		fwrite($myfile, $txt);
		fclose($myfile);
		$myfile = fopen("C:\Pephire\FitmentRes.txt", "w") or die("Unable to open file!");
		$txt = $response;
		fwrite($myfile, $txt);
		fclose($myfile);
		if ($httpCode == 0) //Service might not be running
		{
			// Rollback Transaction
			DB::rollback();
			return redirect('/jobs/create')->with('warningAlert', 'A problem was encountered when Analyzing the Best Candidate. Please try after sometime');
		} else if ($err) {
			// Rollback Transaction
			DB::rollback();
			return redirect('/jobs/create')->with('warningAlert', 'Error in fetching score details from candidate resume. Please try again later.');
		} else {

			$result = json_decode($response, true);

			if (!empty($result)) {

				foreach ($result as $ck => $cv) {

					if (isset($cv['resume_id'])) {
						$can_job = Candidate_Jobs::where('job_id', $job->id)->where('candidate_id', $cv['resume_id'])->first();

						$can_job->score = round($cv['NormScore']);
						$can_job->update();
					}
				}

				//reduce count from organization plan

				$organization->left_search = $organization->left_search - 1;
				$organization->update();
			} else {
				// Rollback Transaction
				DB::rollback();

				return redirect('/jobs/create')->with('warningAlert', 'Error in fetching score details from candidate resume. Please try again later.');
			}
		}




		// Commit Transaction
		DB::commit();

		return redirect('/job/details/' . $job->juid)->with('success', 'Job created successfully');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request)
	{
		//
		$job = Job::where('juid', $request->juid)->first();
		$header_class = 'jobs';
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/resumes/list', compact('header_class', 'job', 'auto_job', 'schedule'));
	}

	public function ResumedataTable(Request $request)
	{

		$job    = Job::where('juid', $request->juid)->first();
		$resumes = Resume::with('candidates')->whereHas('candidates', function ($q) use ($job) {

			$q->where('job_id',  $job->id);
		})->get();

		return datatables($resumes)
			->addColumn('actions', function ($resume) {

				if (!$resume->deleted_at) {

					return [
						'view_link' => url('/resume/' . $resume->ruid . '/view'),
						'custom_link' => url('/jobs/delete/' . $resume->id),
						'custom_title' => 'Delete',
						'custom_class' => 'btn-danger del-resource'
					];
				} else {

					return [
						'view_link' => url('/resume/' . $resume->ruid . '/view'),
						'custom_link' => url('/jobs/activate/' . $resume->id),
						'custom_title' => 'Activate',
						'custom_class' => 'btn-success act-resource'
					];
				}
			})
			->setRowClass(function ($resume) {
				return ($resume->deleted_at) ? 'alert-warning' : '';
			})
			->toJson();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
		$job = Job::where('juid', $request->juid)->withTrashed()->first();
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/job/edit', compact('job', 'auto_job', 'schedule'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{

		$job = Job::where('juid', $request->juid)->withTrashed()->first();
		$job->name              = $request->name;
		$job->description       = $request->description;
		$job->update();

		return redirect('/jobs/history')->with('success', 'Job updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Job  $job
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{

		$job    = Job::where('id', $request->id)->first();
		$user   = User::where('id', $job->user_id)->first();
		$job->delete();
		redirect('/jobs')->with('success', 'Job deleted successfully');
	}


	/**
	 * Activate the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function activate(Request $request)
	{
		//
		$job    = Job::where('id', $request->id)->withTrashed()->first();
		$user   = User::where('id', $job->user_id)->withTrashed()->first();
		$job->restore();

		redirect('/jobs')->with('success', 'Job activated successfully');
	}

	public function getjson(Request $request)
	{
		$job = Job::with('candidates.resume')->where('id', $request->id)->first();
		$data = array();
		if (!empty($job)) {

			foreach ($job->candidates as $jk) {

				$data[] = array(
					'job_id' => $job->id,
					'description' => $job->description,
					'candidate_id' => $jk->id,
					'resume_title' => $jk->resume->name,
					'download_link' => public_path('storage/' . $jk->resume->resume),
					'organization_id' => auth()->user()->organization_id,
					'user_id' => auth()->user()->id
				);
			}
		}


		$postdata = json_encode($data);
		$string = $postdata;
		$post = preg_replace('(^.)', '', $string);
		$post = preg_replace('(.$)', '', $post);


		$ch = curl_init(env('JOBCTRL_URL'));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!




		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);

		curl_close($ch);


		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, true);

			if (!empty($result)) {
				foreach ($result as $ck => $cv) {

					$can_job = Candidate_Jobs::where('job_id', $cv['job_id'])->where('candidate_id', $cv['resume_id'])->first();

					$can_job->score = $cv['PriorityScore'];
					$can_job->update();

					if ($cv['Skills'] != "") {
						$skillArray = explode(',', $cv['Skills']);

						if (!empty($skillArray)) {
							foreach ($skillArray as $mk) {

								$newskill = $mk;

								$existskill = Skill::where('name', $newskill)->first();

								if (!empty($existskill)) {

									$existSkillRel = Candidate_Skill::where('candidate_id', $cv['resume_id'])->where('skill_id', $existskill->id)->first();

									if (empty($existSkillRel)) {

										$can_skill = new Candidate_Skill;

										$can_skill->candidate_id = $cv['resume_id'];
										$can_skill->skill_id = $existskill->id;
										$can_skill->save();
									}
								} else {

									$new_skill = new Skill;

									$new_skill->suid = Uuid::uuid1()->toString();
									$new_skill->name = $newskill;
									$new_skill->save();

									$can_skill = new Candidate_Skill;

									$can_skill->candidate_id = $cv['resume_id'];
									$can_skill->skill_id = $new_skill->id;
									$can_skill->save();
								}
							}
						}
					}
				}
			}
		}
	}

	// list history of jobs
	public function history(Request $request)
	{
		$organization = Organization::where('id', auth()->user()->organization_id)->first();

		$sortval = 'date';

		if (auth()->user()->is_manager == '1') {
			$jobs = Job::withCount('candidates')->where('organization_id', $organization->id)->where('bulk_job_id')->orderBy('created_at', 'DESC')->paginate(25);
		} else {
			$jobs = Job::withCount('candidates')->where('organization_id', $organization->id)->where('user_id', auth()->user()->id)->where('bulk_job_id')->orderBy('created_at', 'DESC')->paginate(25);
		}


		// SELECT * 
		// FROM pephire.jobs 
		// INNER JOIN pephire.candidate__jobs ON pephire.jobs.id = pephire.candidate__jobs.job_id
		// WHERE pephire.jobs.organization_id = 1 
		// AND pephire.jobs.user_id = 2
		// ORDER BY pephire.jobs.created_at DESC;
		$header_class = 'history';
		$sortval = $sortval;
		$jobname = '';
		$sel_startdate = $startdate = '2020-01-01';
		$sel_enddate = $enddate = Carbon::now()->format('Y-m-d');
		$auto_job = DB::connection('pephire_auto')->table('autonomous_job_file_master')->where('uid', auth()->user()->id)->first();
		$schedule = DB::connection('pephire_auto')->table('autonomous_job_schedule')->where('uid', auth()->user()->id)->first();

		return view('frontend/job/history', compact('header_class', 'jobs', 'sortval', 'jobname', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'auto_job', 'schedule'));
	}



	// list history of jobs
	public function searchhistory(Request $request)
	{

		$sortval = $request->sort;

		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		if (auth()->user()->is_manager == '1') {
			$jobs    = Job::withCount('candidates')->where('organization_id', $organization->id);
		} else {
			$jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('user_id', auth()->user()->id);
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
		return view('frontend/job/history', compact('header_class', 'jobs', 'sortval', 'jobname', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'auto_job', 'schedule'));
	}


	// **************** details of job  ****************
	public function details(Request $request)
	{
		$header_class   = 'history';
		$input = $request->input();

		if (array_key_exists('section', $input)) {
			if ($input['section'] == "bulkJobs") {
				$header_class = 'bulkJobs';
			}
		}
		$input = [];
		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		$jobs = Job::with('candidates')->where('organization_id', $organization->id)->orderBy('id', 'desc')->take(3)->get();

		$job = Job::with('candidates.newskills')->where('juid', $request->juid)->first();

		$createdSlotsCount = InterviewTimeslot::where('job_id', $job->id)->count();
		$isEdit['shortlisted'] = $job->shortlisted_candidates()->exists();
		$isEdit['scheduled'] = $isEdit['timeslot'] = $createdSlotsCount > 0 ? true : false;

		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/job/result', compact('header_class', 'job', 'jobs', 'input', 'isEdit', 'auto_job', 'schedule'));
	}


	// **************** searchdetails of job  ****************

	public function searchdetails(Request $request)
	{

		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		$jobs    = Job::with('candidates')->where('organization_id', $organization->id)->orderBy('id', 'desc')->take(3)->get();

		$input = $request->input();
		$experience = explode(',', $request->experience);
		$newskills = explode(',', $request->skill);

		$skillsIdArr = array();
		if (!empty($newskills)) {
			foreach ($newskills as $vk) {


				if ($vk != '') {
					Log::error($vk . 'qwertyuioplkjhgfdsazxcvbnm');
					$skillsIdArr =	Skill::where('name', $vk);
				}
			}
			if (!empty($skillsIdArr)) {
				$skillsIdArr   = $skillsIdArr->pluck('id')->toArray();
			}
		}


		$job = Job::with([
			'candidates.newskills',
			'candidates' => function ($q) use ($input, $experience, $skillsIdArr) {
				$q->where('candidate__jobs.score', '>=', $input['score'])
					->where('candidates.experience', '>=', $experience['0'])
					->where('candidates.experience', '<=', $experience['1'])
					->with('newskills')->whereHas('newskills', function ($qs) use ($skillsIdArr) {
						if (!empty($skillsIdArr)) {


							$qs->whereIn('subskill_master.id', $skillsIdArr);
						}
					});
			}
		])->where('juid', $request->juid)->first();



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
		return view('frontend/job/result', compact('header_class', 'job', 'jobs', 'input', 'isEdit', 'auto_job', 'schedule'));
	}


	//get candidates for the job with search filters
	public function detailssearch(Request $request)
	{

		parse_str($request->input('frm'), $input);

		//DB::enableQueryLog();

		$job = Job::with(
			['candidates' => function ($q) use ($input) {
				$q->where('candidate__jobs.score', '>=', $input['score'])->where('candidates.experience', '>=', $input['experience']);
			}]
		)->where('juid', $input['juid']);

		$result = $job->first();

		//dd(DB::getQueryLog());

		//dd($result);

		$data['success']    = 1;
		$data['view']       = view('frontend.job.result_search')->with('job', $result)->render();
		return response()->json($data);
	}


	// list historyminer of jobs for add to new job
	public function historyminer(Request $request)
	{

		$organization = Organization::where('id', auth()->user()->organization_id)->first();

		$sortval = ($request->sort) ? $request->sort : 'date';

		if (auth()->user()->is_manager == '1') {

			$jobs    = Job::withCount('candidates')->where('organization_id', $organization->id);
		} else {

			$jobs    = Job::withCount('candidates')->where('organization_id', $organization->id)->where('user_id', auth()->user()->id);
		}



		$jobname = '';
		if ($request->jobname) {
			$jobname = $request->jobname;
			$jobs->where('name', 'like', '%' . $request->jobname . '%');
		}

		$startdate = $enddate = '';
		if ($request->from && $request->to) {
			$startdate = $request->from;
			$enddate = $request->to;

			$start_date = Carbon::parse($request->from)->format('Y-m-d');
			$end_date = Carbon::parse($request->to)->format('Y-m-d');

			$jobs->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
		}

		if ($request->sort != 'resume') {

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
		return view('frontend/job/historyminer', compact('header_class', 'jobs', 'sortval', 'jobname', 'startdate', 'enddate', 'auto_job', ''));
	}


	public function updatejobdetails(Request $request)
	{

		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();

		parse_str($request->frm, $input);

		if ($input['skills'] != '') {

			foreach ($input['skills'] as $skill) {
				$sk[] = $skill;
			}


			$skills = implode(',', $sk);
		}

		if (!$existjob) {
			$pendjob = new PendingJob;
			$pendjob->organization_id   = auth()->user()->organization_id;
			$pendjob->user_id           = auth()->user()->id;
			$pendjob->name              = trim($input['jobtitle']);
			$pendjob->description       = trim($input['jobdescription']);
			$pendjob->joining_date       = trim($input['joining_date']) ?: null;
			$pendjob->max_experience       = trim($input['max_experience']);
			$pendjob->max_experience       = trim($input['min_experience']);
			$pendjob->location       = trim($input['location']);
			$pendjob->job_role       = trim($input['job_role']);
			$pendjob->mandatory_skills       = trim($skills);
			$pendjob->offered_ctc       = trim($input['offered_ctc']);
			$pendjob->save();
		} else {
			$existjob->name              = trim($input['jobtitle']);
			$existjob->description       = trim($input['jobdescription']);
			$existjob->joining_date       = trim($input['joining_date']) ?: null;
			$existjob->max_experience       = $input['max_experience'];
			$existjob->min_experience       = trim($input['min_experience']);
			$existjob->location       = trim($input['location']);
			$existjob->job_role       = trim($input['job_role']);
			$existjob->mandatory_skills       = trim($skills);
			$existjob->offered_ctc       = trim($input['offered_ctc']);
			$existjob->update();
		}
		$data                 = array();
		$data['success']      = 1;
		return response()->json($data);
	}
	public function mandatorySkills(Request $request)
	{
		parse_str($request->frm, $input);


		$datatoPost = array();
		$datatoPost[] = array(
			'description' => $input['jobdescription'],


		);

		$postdata = json_encode($datatoPost);
		$string1 = $postdata;
		$post = preg_replace('(^.)', '', $string1);
		$post = preg_replace('(.$)', '', $post);
		$ch = curl_init(env('EXTRACTION_URL'));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);
		$result = json_decode($response, true);

		$common_words = Db::connection('pephire_trans')->table('common_profile_words')->get()->pluck('word')->toArray();



		$skills = str_replace("'", "", $result);
		$skill = explode(",", $skills);
		foreach ($skill as $sk) {


			if (!in_array(strtolower($sk), $common_words)) {
				Log::error($sk);
				$skil[] = $sk;
			}
		}

		$skills = $skil;
		$sks = implode(",", $skills);
		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();
		if (!$existjob) {
			$pendjob = new PendingJob;
			$pendjob->organization_id   = auth()->user()->organization_id;
			$pendjob->user_id           = auth()->user()->id;
			$pendjob->description       = trim($input['jobdescription']);
			$pendjob->mandatory_skills       = trim($sks);
			$pendjob->skills       = trim($sks);
			$pendjob->save();
		} else {

			$existjob->mandatory_skills       = trim($sks);
			$existjob->description       = trim($input['jobdescription']);
			$existjob->skills       = trim($sks);
			$existjob->update();
		}

		$data['skills'] = $skills;
		$data['common_words'] = $common_words;

		return response()->json($data);
	}




	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function Apijobsubmit(Request $request)
	{
		//

		$userdets = User::where('email', $request->email)->first();
		$data     = array();
		if ($userdets) {

			$job = new Job();

			$job->juid              = Uuid::uuid1()->toString();
			$job->organization_id   = $userdets->organization_id;
			$job->user_id           = $userdets->id;
			$job->name              = $request->jobtitle;
			$job->description       = $request->jobdescription;
			$job->save();

			$data['status'] = true;
			$data['data']   = array('jobid' => $job->id);
			$data['message'] = 'success';
		} else {

			$data['status'] = false;
			$data['data']   = array();
			$data['message'] = 'Not a valid user.';
		}

		return response()->json($data);
	}

	public function report(Request $request)
	{

		$id = $request->input('jid');


		$fileName = 'report.csv';
		$tasks = DB::table('candidate__jobs')
			->select('candidate__jobs.score', 'candidate__jobs.id', 'candidates.organization_id', 'candidates.shortlist', 'jobs.description', 'jobs.offered_ctc', 'candidates.name', 'candidates.experience', 'jobs.name as jname', 'candidates.location', 'candidates.email', 'candidates.resume_id', 'candidates.id as cid', 'candidates.phone', 'candidates.notice_period', 'candidate__jobs.job_id')
			->orderBy('candidate__jobs.score', 'DESC')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->where('jobs.id', $id)
			->where('candidates.is_attribute_errror', 0)
			->get();

		$headers = array(
			"Content-type"        => "text/csv",
			"Content-Disposition" => "attachment; filename=$fileName",
			"Pragma"              => "no-cache",
			"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			"Expires"             => "0"
		);


		$columns = array('JDID', 'Job Title', 'Job Description', 'Candidate Name', 'Phone', 'Email', 'Experience', 'CTC', 'Location', 'Notice Period', 'Score', 'Stage');

		$callback = function () use ($tasks, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach ($tasks as $task) {
				$row['JDID']  = $task->job_id;
				$row['Job Title']  = $task->jname;
				$row['Description']    = $task->description;
				$row['Name']    = $task->name;
				$row['Phone']  = $task->phone;
				$row['Email']  = $task->email;
				$row['Experience']  = $task->experience;
				$row['CTC']    = $task->offered_ctc;
				$row['Location']    = $task->location;
				$row['Notice Period']  = $task->notice_period;
				$row['Score']  = $task->score;
				$cand = ShortlistedCandidate::where('candidate_id', $task->cid)->where('job_id', $task->job_id)->count();
				if ($cand != 0) {
					$status = 'Shortlisted';
				} else {
					$status = 'Selected';
				}
				fputcsv($file, array(
					$row['JDID'], $row['Job Title'], $row['Description'], $row['Name'], $row['Phone'], $row['Email'], $row['Experience'], $row['CTC'],
					$row['Location'], $row['Notice Period'], $row['Score'], $status
				));
			}

			fclose($file);
		};

		return response()->stream($callback, 200, $headers);
	}





	public function resumes(Request $request)
	{
		$id = $request->input('juid');

		$fileResumes = [];
		$names = [];
		$tasks = DB::table('candidate__jobs')
			->select('candidate__jobs.score', 'candidate__jobs.id', 'candidates.organization_id', 'jobs.description', 'jobs.offered_ctc', 'candidates.name', 'candidates.experience', 'candidates.location', 'candidates.email', 'candidates.resume_id', 'candidates.id', 'candidates.phone', 'candidates.notice_period', 'candidate__jobs.job_id')
			->groupBy('candidate__jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->where('jobs.id', $id)
			->where('candidates.is_attribute_errror', 0)
			->get();
		foreach ($tasks as $task) {



			$resume = Resume::where('id', $task->resume_id)->first();
			if ($resume != '') {
				$file_resume = $resume->resume;

				$file_name = public_path() . '/storage/' . $resume->resume;

				array_push($fileResumes, $file_name);
				$name = $resume->name;
				array_push($names, $name);
			}
		}


		$zip = new ZipArchive;

		$fileName = 'Resume.zip';
		unlink($fileName);

		if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
			$files = $fileResumes;
			$names = $names;
			foreach (array_combine($files, $names) as $key => $value) {
				$zip->addFile($key, $value);
			}

			$zip->close();
		}


		return response()->download(public_path($fileName));
	}


	public function shortlisted_report(Request $request)
	{

		$id = $request->input('jid');

		$fileName = 'shortlisted_report.csv';
		$tasks = DB::table('shortlisted_candidates')
			->select('candidate__jobs.job_id as sjid', 'candidate__jobs.candidate_id', 'candidate__jobs.score', 'candidate__jobs.id', 'candidate__jobs.candidate_id  as cidd', 'candidates.organization_id', 'jobs.id as jobid', 'jobs.description', 'jobs.offered_ctc', 'candidates.name', 'candidates.experience', 'candidates.location', 'jobs.name as jname', 'candidates.email', 'candidates.resume_id', 'candidates.id', 'candidates.phone', 'candidates.notice_period', 'candidate__jobs.job_id as cjid')
			->join('candidates', 'shortlisted_candidates.candidate_id', '=', 'candidates.id')
			->join('candidate__jobs', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('jobs', 'shortlisted_candidates.job_id', '=', 'jobs.id')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->where('candidate__jobs.job_id', $id)
			->where('shortlisted_candidates.job_id', $id)
			->where('candidates.is_attribute_errror', 0)
			->groupBy('candidates.id')
			->orderBy('candidate__jobs.score', 'DESC')
			->get();

		$headers = array(
			"Content-type"        => "text/csv",
			"Content-Disposition" => "attachment; filename=$fileName",
			"Pragma"              => "no-cache",
			"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			"Expires"             => "0"
		);


		$columns = array('JDID', 'Job Title', 'Job Description', 'Candidate Name', 'Phone', 'Email', 'Experience', 'CTC', 'Location', 'Notice Period', 'Score', 'Stage');

		$callback = function () use ($tasks, $columns) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $columns);

			foreach ($tasks as $task) {
				$row['JDID']  = $task->jobid;
				$row['Job Title']  = $task->jname;
				$row['Description']    = $task->description;
				$row['Name']    = $task->name;
				$row['Phone']  = $task->phone;
				$row['Email']  = $task->email;
				$row['Experience']  = $task->experience;
				$row['CTC']    = $task->offered_ctc;
				$row['Location']    = $task->location;
				$row['Notice Period']  = $task->notice_period;
				$row['Score']  = $task->score;


				fputcsv($file, array($row['JDID'], $row['Job Title'], $row['Description'], $row['Name'], $row['Phone'], $row['Email'], $row['Experience'], $row['CTC'], $row['Location'], $row['Notice Period'], $row['Score'], 'Shortlisted'));
			}

			fclose($file);
		};


		return response()->stream($callback, 200, $headers);
	}

	public function shortlisted_resumes(Request $request)
	{

		$id = $request->input('juid');
		$fileResumes = [];
		$names = [];
		$tasks = DB::table('shortlisted_candidates')
			->select('shortlisted_candidates.job_id', 'shortlisted_candidates.candidate_id', 'candidate__jobs.score', 'candidate__jobs.id', 'candidates.organization_id', 'jobs.description', 'jobs.offered_ctc', 'candidates.name', 'candidates.experience', 'candidates.location', 'candidates.email', 'candidates.resume_id', 'candidates.id', 'candidates.phone', 'candidates.notice_period', 'candidate__jobs.job_id')
			->groupBy('shortlisted_candidates.id')
			->join('candidate__jobs', 'candidate__jobs.job_id', '=', 'shortlisted_candidates.job_id')
			->join('jobs', 'shortlisted_candidates.job_id', '=', 'jobs.id')
			->join('candidates', 'shortlisted_candidates.candidate_id', '=', 'candidates.id')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->where('shortlisted_candidates.job_id', $id)
			->where('candidates.is_attribute_errror', 0)
			->get();

		foreach ($tasks as $task) {
			$resume = Resume::where('id', $task->resume_id)->first();
			if ($resume != '') {
				$file_resume = $resume->resume;

				$file_name = public_path() . '/storage/' . $resume->resume;

				array_push($fileResumes, $file_name);
				$name = $resume->name;
				array_push($names, $name);
			}
		}
		$zip = new ZipArchive;
		$fileName = 'Resume_.zip';
		if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
			$files = $fileResumes;
			$names = $names;
			foreach (array_combine($files, $names) as $key => $value) {
				$zip->addFile($key, $value);
			}

			$zip->close();
		}
		return response()->download(public_path($fileName));
	}
	public function interviewSourcing()
	{
		$header_class = "source";
		$job = Job::withCount('candidates')->where('organization_id', auth()->user()->organization->id)->where('bulk_job_id')->orderBy('created_at', 'ASC')->get();
		$jobs = Job::with('candidates.newskills')->where('organization_id', auth()->user()->organization->id)->orderBy('id', 'desc')->get();
		$accepted_job = DB::connection('pephire')
			->table('candidate__jobs')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'interested')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->distinct()
			->get();
		$candidateIds = CandidateTimeslots::where('user_id', auth()->user()->id)->where('hasAllotted', 1)->get('candidate_id');
		$slot_pending = DB::table('shortlisted_candidates')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('candidates', 'shortlisted_candidates.candidate_id', '=', 'candidates.id')
			->join('candidate__jobs', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('jobs', 'shortlisted_candidates.job_id', '=', 'jobs.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'slot_pending')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->whereNull('shortlisted_candidates.timeslot')
			->distinct()
			->get();

		$scheduled = DB::connection('pephire')
			->table('candidate__jobs')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'scheduled')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->distinct()
			->get();
		$missed_jobs =  DB::connection('pephire')
		->table('candidate__jobs')
		->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
		->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
		->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
		->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
		->where('configurable_candidatestages.stage', 'missed')
		->where('candidates.organization_id', auth()->user()->organization_id)
		->distinct()
		->get();
		$completed_jobs = DB::connection('pephire')
			->table('candidate__jobs')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'completed')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->distinct()
			->get();
		$sourced_job = DB::connection('pephire')
			->table('candidate__jobs')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'sourced')
			->where('candidates.organization_id', auth()->user()->organization_id)
			->distinct()
			->get();
		$contacted_job = DB::connection('pephire')
			->table('candidate__jobs')
			->select('candidates.name', 'candidates.sex', 'candidates.photo', 'candidates.id as cid', 'candidates.email', 'candidates.phone', 'candidates.status', 'jobs.name as jname', 'jobs.id')
			->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
			->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
			->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidate__jobs.candidate_id')
			->where('configurable_candidatestages.stage', 'contacted')
			->where('candidates.organization_id', auth()->user()->organization_id)

			->distinct()
			->get();



		$substatus = DB::connection('pephire')
			->table('candidate_sub_status')
			->select('candidate_sub_status.id', 'candidate_sub_status.name', 'candidate_master_status.status')
			->join('candidate_master_status', 'candidate_master_status.id', '=', 'candidate_sub_status.master_id')
			->distinct()
			->get();
		$stage_list = CandidateMasterStatu::whereNotIn('status', ['offered'])->get();
		// $stage_list = DB::connection('pephire')
		// 		->table('candidate_master_status')
		// 		->select('candidate_sub_status.name')
		// 		->join('candidate_sub_status', 'candidate_master_status.id', '=', 'candidate_sub_status.master_id')			
		// 		->distinct()
		// 		->get();

		// Log::error($contacted_job . 'slot_pendingslot_pending');

		return view('frontend/job/interview_sourcing', compact('header_class', 'jobs', 'job', 'contacted_job', 'accepted_job', 'scheduled', 'completed_jobs', 'slot_pending', 'sourced_job', 'stage_list', 'substatus','missed_jobs'));
	}

	public function update_candidateStatus(Request $request)
	{
		Log::error($request);


		foreach ($request->ids as $id) {
			$job_id = $id['job_id'];
			$candidate_id = $id['candidate_id'];




// 			$post = json_encode(array(
// 				"candidate_id" => $candidate_id,
// 				"organization_id" => auth()->user()->organization_id,
// 				"user_id" => auth()->user()->id,
// 				"job_id" => $job_id
//             ));

// 			$ch = curl_init("http://52.183.132.108:7002/ContactCandidate");
//             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

//             // execute!
//             $pythonCall = curl_exec($ch);

//             // close the connection, release resources used
//             curl_close($ch);

// Log::error($pythonCall.'pythonCallpythonCall');
			$stage = ConfigurableCandidatestages::where('job_id', $job_id)->where('candidate_id', $candidate_id)->first();
			$stage->stage = $request->stage;
			$stage->status = $request->sub_status;
			$stage->update();
		}
		return response()->json(['status' => true]);
	}
	public function delete_candidate(Request $request)
	{
		Log::error($request . 'iiiiiiiiiiiiiiiiiiiii');
		return response()->json(['message' => 'Candidate deleted successfully']);
	}
	public function updateInterviewer(Request $request)
	{
		$jobIds = explode(',', $request->job_id);

		foreach ($jobIds as $j) {
			$exist = InterviewerDetails::where('job_id', $j)->first();
			if ($exist) {

				$exists = InterviewerDetails::where('job_id', $j)->delete();
			}
			$timeslot3 = new InterviewerDetails();
			$timeslot3->job_id = $j;
			$timeslot3->candidate_id = $request->cand_id;
			$timeslot3->user_id = auth()->id();
			$timeslot3->interviewer_name = $request->name;
			$timeslot3->email = $request->email;
			$timeslot3->contact_number = $request->phone;
			$timeslot3->oid = auth()->user()->organization_id;
			$timeslot3->save();
		}
		return response()->json(['status' => true]);
	}
}
