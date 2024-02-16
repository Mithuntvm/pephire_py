<?php

namespace App\Http\Controllers;

use DB;
use App\Job;
use App\Skill;
use App\SkillMaster;
use App\Resume;
use App\Company;
use Carbon\Carbon;
use App\Candidate;
use App\PendingJob;
use App\Organization;
use App\ApplyFilter;
use App\Candidate_Skill;
use App\Candidateskills;
use Illuminate\Http\Request;
use App\Organizations_Hold_Resume;
use App\ShortlistedCandidate;
use App\InterviewTimeslot;
use App\User;
use Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class CandidateController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *log::
	 * @return \Illuminate\Http\Response
	 */
	public function index()

	{

		// Delete Pending Resumes

		// Candidate::where('user_id', auth()->user()->id)

		//     ->where('organization_id', auth()->user()->organization_id)

		//     ->where('is_attribute_errror', 1)

		//     ->delete();



		$organization = Organization::where('id', auth()->user()->organization_id)->first();



		if (!$organization) {

			return redirect('/organization-deactive');
		}





		$candidates = Candidate::with('holdstat')

			->has('resume')

			->whereNull('deleted_at')

			->where('is_attribute_errror', 0)

			->where('organization_id', $organization->id)

			->orderBy('id', 'DESC')

			->paginate(10);



		$candidateIds = $candidates->pluck('id');

		$skills = Candidate_Skill::whereIn('candidate_id', $candidateIds)

			->pluck('skillname');




		$totalcount = Candidate::has('resume')->where('organization_id', $organization->id)->count();



		$resume_total   = Candidate::where('organization_id', $organization->id)->count();

		$resume_trashed   = Candidate::where('organization_id', $organization->id)->count();

		$job_total      = Job::where('organization_id', $organization->id)->count();

		$organization   = Organization::where('id', auth()->user()->organization_id)->first();



		foreach ($candidates as $ck) {



			$qn_ans = DB::connection('pephire_trans')

				->table('conversation_details_v2')

				->where('candidatePhone', $ck->phone)

				->where('Qn', 'Hi, This is from PepHire. We would like to consider you for a job opening as Business Analyst. Can you confirm your interest? (Reply 1 for Yes/Reply 2 for No)')



				->get();



			foreach ($qn_ans as $qn) {

				if ($ck->status == '') {



					if ($qn->QnID == 'qn9' && $qn->response == '') {

						$ck->status = 'CONTACTED';
					}

					if ($qn->response == 1) {

						$ck->status = 'INTERESTED';
					}

					if ($qn->response == 2) {

						$ck->status = 'NOT INTERESTED';
					}



					$ck->save();
				}
			}
		}




		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)->where('uid', auth()->user()->id)->where('page', 'profile_database')->first();

		$auto_job = DB::connection('pephire_auto')

			->table('autonomous_job_file_master')

			->where('uid', auth()->user()->id)

			->first();

		$schedule = DB::connection('pephire_auto')

			->table('autonomous_job_schedule')

			->where('uid', auth()->user()->id)

			->first();



		$header_class = 'profile';



		$user = User::where('id', auth()->user()->id)->first();



		return view('frontend/profile/list', compact('organization', 'header_class', 'candidates', 'totalcount', 'resume_total', 'resume_trashed', 'job_total', 'filter', 'auto_job', 'schedule', 'user', 'skills'));
	}





	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	private function sendmail($data, $subject, $view)
	{
		Mail::send($view, $data, function ($message) use ($data, $subject) {
			$message->to($data['email'], $data['name'])->subject($subject);
		});
	}






	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$icon_name = '';
		if ($request->name != '') {
			$nameicon = explode(' ', $request->name);
			$lcount   = count($nameicon);
			foreach ($nameicon as $i => $v) {
				if ($i == 0 || $i == $lcount - 1) {
					$icon_name .= substr($v, 0, 1);
				}
			}
		}

		$icon_name = strtoupper($icon_name);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */



	public function start(Request $request, $id)
	{
		$candidate = Candidate::where('id', $id)->first();

		if ($candidate->flag == '0') {

			$candidate->flag = '1';

			$candidate->save();
		} else {

			$candidate->flag = '0';
			$candidate->save();
		}

		$data = $candidate->flag;
		return redirect('/profile/' . $candidate->cuid);
	}


	public function comment(Request $request, $cid)
	{

		$candidate = Candidate::where('id', $cid)->first();


		$userObj = User::where('id', auth()->user()->id)->first();


		$candidate_stages = DB::connection('pephire')
			->table('comment')
			->insert([

				'comment' => $request->comment,
				'candidate_id' => $cid,
				'user_id' => $userObj->name,
				'date' => Carbon::now(),
			]);

		return redirect('/profile/' . $candidate->cuid);
	}
	public function show(Request $request)
	{
		$header_class = '';

		$candidate = Candidate::with('newskills')->with('resume')->where('cuid', $request->profile)->first();
		$common_words = Db::connection('pephire_trans')->table('common_profile_words')->get()->pluck('word')->toArray();

		$comments = DB::connection('pephire')
			->table('comment')
			->where('candidate_id', $candidate->id)
			->get();


		$u  = Hash::make('test@123');

		$pp = 'Sentient123';

		$ii              = time();

		$candidate->datalink = route('candidateDetails.edit', $candidate->cuid);

		$candidate->save();

		$external = DB::connection('pephire_trans')
			->table('conversation_details_v2')
			->where('candidatePhone', $candidate->phone)->get();

		$qn_ans = DB::connection('pephire_trans')
			->table('conversation_details_v2')
			->where('candidatePhone', $candidate->phone)
			->where('Qn', 'Hi, This is from PepHire. We would like to consider you for a job opening as Business Analyst. Can you confirm your interest? (Reply 1 for Yes/Reply 2 for No)')

			->get();

		$latest = DB::connection('pephire_trans')
			->table('conversation_details_v2')
			->where('candidatePhone', $candidate->phone)
			->latest('Recieved')

			->first();
		$last = DB::connection('pephire_trans')
			->table('last_conversation_v2')
			->where('candidatePhone', $candidate->phone)
			->where('message_source', 'WEB')
			->orwhere('message_source', 'WHATSAPP')
			->get();

		foreach ($candidate->newskills as $skill) {

			$candi = Skill::where('name', $skill->name)->first();
		}




		foreach ($qn_ans as $qn) {
			if ($candidate->status == '') {
				if ($qn->Qn == 'Hi, This is from PepHire. We would like to consider you for a job opening as Business Analyst. Can you confirm your interest? (Reply 1 for Yes/Reply 2 for No)' && $qn->response == '') {
					$candidate->status = 'CONTACTED';
					$candidate_stages = DB::connection('pephire')
						->table('comment')
						->insert([
							'comment' => 'We Contacted Candidate ' . $candidate->name . ' on Whatsapp',
							'status' => 'sent',
							'candidate_id' => $candidate->id,
							'user_id' => 'Pephire',
							'date' => Carbon::now(),
						]);
				}
				if ($qn->response == 1) {
					$candidate->status = 'INTERESTED';
				}
				if ($qn->response == 2) {
					$candidate->status = 'NOT INTERESTED';
				}
				$candidate->save();
			}
		}

		if ($candidate->status == 'CONTACTED') {
			$source = '1';
		} else {
			$source = '';
		}
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('profile.show', compact('header_class', 'candidate', 'common_words', 'external', 'qn_ans', 'comments', 'source', 'latest', 'auto_job', 'schedule'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function edit_candidatedetails(Request $request)
	{
		$header_class = 'plans';

		$candidate = Candidate::with('newskills')->with('resume')->where('id', $request->id)->first();
		$common_words = Db::connection('pephire_trans')->table('common_profile_words')->get()->pluck('word')->toArray();
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('profile.edit_candidatedetails', compact('header_class', 'candidate', 'common_words', 'auto_job', 'schedule'));
	}
	public function editCandidateProfile($cuid)
	{
		$candidate = Candidate::where('cuid', $cuid)->first();

		if ($candidate) {
			if ($candidate->hasCompleted == 1) {
				$errorMsg = "You have already updated your profile !";
				return view('frontend.interview_error', compact('errorMsg'));
			} else {
				return view('frontend.interview_candidateProfile', compact('candidate'));
			}
		} else {
			$errorMsg = "Invalid Profile Request ID !";
			return view('frontend.interview_error', compact('errorMsg'));
		}
	}

	public function editCandidateDetails(Request $request)
	{
		$candidate = Candidate::where('cuid', $request->cuid)->first();
		if ($candidate) {
			return view('frontend.candidate_details', compact('candidate'));
		} else {
			$errorMsg = "Invalid Profile Request ID !";
			return view('frontend.interview_error', compact('errorMsg'));
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editInterviewCandidateProfile($sluid)
	{
		$short_listed = ShortlistedCandidate::where('sluid', $sluid)->first();
		if ($short_listed) {
			$candidate = Candidate::find($short_listed->candidate_id);

			$alreadySubmittedCount = InterviewTimeslot::where('job_id', $short_listed->job_id)->where('allotted_candidate_id', $short_listed->candidate_id)->count();
			if ($alreadySubmittedCount > 0) {
				$errorMsg = "You have already submitted your preferred time slot !";
				return view('frontend.interview_error', compact('errorMsg'));
			}

			if ($candidate->hasCompleted == 1) //Profile already completed
			{
				return redirect()->route('candidateTimeslot.view', $sluid);
			} else {
				return view('frontend.interview_candidateProfile', compact('candidate', 'sluid'));
			}
		} else {
			$errorMsg = "Invalid Interview Request ID !";
			return view('frontend.interview_error', compact('errorMsg'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function updateshowCandidate(Request $request, $cuid)
	{
		$redirect_url = route('candidate.thankYou');
		$candidate = Candidate::where('cuid', $cuid)->first();
		$candidate->update($request->except(['skills', 'companies', 'age', '_token', 'sluid']));

		// Update Skills
		$finalCandidateSkills = explode(',', $request->skills);
		$candidate->newskills()->sync($finalCandidateSkills);

		// Update Companies
		$finalCandidateCompanies = explode(',', $request->companies);

		// Delete all existing
		$candidate->companies()->detach();

		foreach ($finalCandidateCompanies as $company_name) {
			$company = Company::firstOrCreate(['name' => trim($company_name)]);
			$company->candidates()->save($candidate);
		}

		$candidate->update([
			'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'dob' => $request->dob,
			'sex' => $request->sex, 'married' => $request->married, 'education' => $request->education, 'experience' => $request->experience,
			'passport_no' => $request->passport_no, 'visatype' => $request->visatype, 'role' => $request->role,
			'linkedin_id' => $request->linkedin_id, 'location' => $request->location,
			'relocate' => $request->relocate, 'ctc' => $request->ctc, 'gigs' => $request->gigs,
			'notice_period' => $request->notice_period,

		]);


		return response()->json(['status' => true, 'redirect_url' => $redirect_url]);
	}

	public function updateCandidateProfile(Request $request, $cuid)
	{


		if ($request->sluid) // Means profile update during interview flow
		{
			$redirect_url = route('candidateTimeslot.view', $request->sluid);
		} else  // Means profile update during attribution flow
		{
			$redirect_url = route('candidate.thankYou');
		}
		$candidate = Candidate::where('cuid', $cuid)->first();
		$candidate->update($request->except(['skills', 'companies', 'age', '_token', 'sluid']));

		// Update Skills
		$finalCandidateSkills = explode(',', $request->skills);
		$candidate->newskills()->sync($finalCandidateSkills);

		// Update Companies
		$finalCandidateCompanies = explode(',', $request->companies);

		// Delete all existing
		$candidate->companies()->detach();

		foreach ($finalCandidateCompanies as $company_name) {
			$company = Company::firstOrCreate(['name' => trim($company_name)]);
			$company->candidates()->save($candidate);
		}

		$external_candidate_profile_links = DB::connection('pephire_trans')
			->table('link_verification_status')
			->where('Phone', $candidate->phone)
			->where('QnID', 'Datalink')
			->delete();

		// ->update(['link_status' => 1]);

		$candidate_profile_links = DB::table('candidate_profile_links')
			->where('candidate_id', $candidate->id)
			->update(['hasCompleted' => 1]);

		$phone = str_replace('+', '', $candidate->phone);
		$phone = str_replace(' ', '', $phone);
		if (strlen($phone) > 10) {
			$phone = $phone;
		} else {
			$phone = '91' . $phone;
		}
		$personalization_parameters = DB::connection('pephire_trans')->table('personalization_parameters_v2')
			->where('phone', $phone)
			->where('Parameters', "Name")
			->update(['ParameterValue' => $candidate->name]);
		$candidate->update([
			'hasCompleted' => 1, 'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'dob' => $request->dob,
			'sex' => $request->sex, 'married' => $request->married, 'education' => $request->education, 'experience' => $request->experience,
			'passport_no' => $request->passport_no, 'visatype' => $request->visatype, 'role' => $request->role,
			'linkedin_id' => $request->linkedin_id, 'location' => $request->location,
			'relocate' => $request->relocate, 'ctc' => $request->ctc, 'gigs' => $request->gigs,

			'notice_period' => $request->notice_period, 'preffered_location' => $request->pre_loc, 'current_ctc' => $request->curr_ctc,
		]);

		$can = DB::connection('pephire_trans')
			->table('candidate_stages_v2')->where('id', $candidate->id)->where('event', 'shortlist-intro')
			->where('oid', $candidate->organization_id)
			->delete();

		// if ($request->experience < 1) {

		// 	$candidate_stages = DB::connection('pephire_trans')
		// 		->table('candidate_stages_v2')
		// 		->insert([
		// 			'id' => $candidate->id,
		// 			'event' => 'shortlist-fresher',
		// 			'oid' => $candidate->organization_id,
		// 			'usertype' => 'candidate',
		// 			'status' => 'incomplete',
		// 			'date' => Carbon::now(),
		// 		]);
		// } else {

		// 	DB::connection('pephire_trans')
		// 		->table('candidate_stages_v2')->where('id', $candidate->id)->where('event', 'shortlist')->delete();
		// 	$candidate_stages = DB::connection('pephire_trans')
		// 		->table('candidate_stages_v2')
		// 		->insert([
		// 			'id' => $candidate->id,
		// 			'event' => 'shortlist',
		// 			'oid' => $candidate->organization_id,
		// 			'usertype' => 'candidate',
		// 			'status' => 'incomplete',
		// 			'date' => Carbon::now(),
		// 		]);
		// }


		return response()->json(['status' => true, 'redirect_url' => $redirect_url]);
	}


	public function whatsappFlow(Request $request)
	{
		$user = User::where('id', auth()->user()->id)->first();

		$user->whatsapp_flow = $request->whatsapp;

		$user->update();

		return response()->json(['status' => true]);
	}
	public function update_candidatedetails(Request $request, $cuid)
	{

		$candidate = Candidate::where('cuid', $cuid)->first();
		$redirect_url = route('candidatedetails.show', $cuid);

		$candidate->update($request->except(['skills', 'age', '_token', 'sluid']));

		// Update Skills
		$finalCandidateSkills = explode(',', $request->skills);
		$candidate->newskills()->sync($finalCandidateSkills);


		$candidate->update([
			'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'dob' => $request->dob,
			'sex' => $request->sex, 'married' => $request->married, 'education' => $request->education, 'experience' => $request->experience,
			'passport_no' => $request->passport_no, 'visatype' => $request->visatype,
			'linkedin_id' => $request->linkedin_id, 'location' => $request->location,
			'status' => $request->status,


		]);

		$header_class = 'plans';

		$candidate = Candidate::with('newskills')->with('resume')->where('id', $cuid)->first();
		$common_words = Db::connection('pephire_trans')->table('common_profile_words')->get()->pluck('word')->toArray();


		return response()->json(['status' => true, 'redirect_url' => $redirect_url]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Candidate  $candidate
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$candidate  = Candidate::where('id', $request->id)->first();

		Organizations_Hold_Resume::where('candidate_id', $candidate->id)->delete();
		$candidate->delete();

		return response()->json(array('success' => 1));
	}

	// attach resume with organization for new job matrix
	public function addtojob(Request $request)
	{

		$checktotal = Organizations_Hold_Resume::where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)
			->count();

		if ($checktotal == auth()->user()->organization->max_resume_count) {
			$data = array();
			$data['error'] = 1;
			return response()->json($data);
		}

		$candidate  = Candidate::where('id', $request->id)->first();


		$existuser = Organizations_Hold_Resume::where('organization_id', $candidate->organization_id)
			->where('user_id', auth()->user()->id)->where('candidate_id', $candidate->id)->first();

		if (!$existuser) {
			$orghold = new Organizations_Hold_Resume;

			$orghold->organization_id   = $candidate->organization_id;
			$orghold->resume_id         = $candidate->resume_id;
			$orghold->candidate_id      = $candidate->id;
			$orghold->user_id      = auth()->user()->id;

			$orghold->save();
		}

		$totalcount = Organizations_Hold_Resume::where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)->count();

		$resumecount = Resume::where('organization_id', auth()->user()->organization_id)->count();

		$remaining   = auth()->user()->organization->max_resume_count - $totalcount;

		$data = array();
		$data['success'] = 1;
		$data['resumecount'] = $resumecount;
		$data['remaining'] = $remaining;
		$data['totalcount'] = $totalcount;
		return response()->json($data);
	}

	// remove resume with organization for new job matrix
	public function removefromjob(Request $request)
	{

		$candidate  = Candidate::where('id', $request->id)->first();

		$orghold = Organizations_Hold_Resume::where('candidate_id', $candidate->id)->first();

		$orghold->delete();

		$totalcount = Organizations_Hold_Resume::where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)->count();

		$resumecount = Resume::where('organization_id', auth()->user()->organization_id)->count();

		$remaining   = auth()->user()->organization->max_resume_count - $totalcount;

		$data = array();
		$data['success'] = 1;
		$data['resumecount'] = $resumecount;
		$data['remaining'] = $remaining;
		$data['totalcount'] = $totalcount;
		return response()->json($data);
	}


	//get candidates for profile miner in job create
	// public function popupget(Request $request)
	// {

	// 	$pagecount = ($request->page) ? $request->page : 1;

	// 	$candidates = Candidate::with('holdstat')->where('organization_id', auth()->user()->organization_id);

	// 	if ($request->name) {
	// 		$candidates->where('name', 'like', '%' . $request->name . '%');
	// 	}

	// 	if ($request->experience) {
	// 		$candidates->where('experience', '>=', $request->experience);
	// 	}

	// 	if ($request->skill != "") {

	// 		$candidates->with('resume')->with('skills')->whereHas('skills', function ($q) use ($request) {
	// 			$q->where('name', 'like', '%' . $request->skill . '%');
	// 		});
	// 	} else {
	// 		$candidates->with('resume')->with('skills');
	// 	}

	// 	$candidates = $candidates->paginate(10);

	// 	$noload = 1;
	// 	if ($candidates->hasMorePages()) {
	// 		$noload = 0;
	// 	}

	// 	$noloadprev = 0;
	// 	if ($pagecount == 1) {
	// 		$noloadprev = 1;
	// 	}

	// 	$data['noload']       = $noload;
	// 	$data['noloadprev']   = $noloadprev;
	// 	$data['popcount']     = $pagecount + 1;
	// 	$data['success']      = 1;
	// 	$data['resumelist']   = view('frontend.profile.createpopup')->with('candidates', $candidates)->render();
	// 	return response()->json($data);
	// }


	//get candidates for profile miner in job create by filter
	// public function popupgetsearch(Request $request)
	// {

	// 	$pagecount = ($request->page) ? $request->page : 1;

	// 	$candidates = Candidate::with('holdstat')->where('organization_id', auth()->user()->organization_id);

	// 	if ($request->name) {
	// 		$candidates->where('name', 'like', '%' . $request->name . '%');
	// 	}

	// 	if ($request->experience) {
	// 		$candidates->where('experience', '>=', $request->experience);
	// 	}

	// 	if ($request->skill != "") {

	// 		$candidates->with('resume')->with('newskills')->whereHas('newskills', function ($q) use ($request) {
	// 			$q->where('name', 'like', '%' . $request->skill . '%');
	// 		});
	// 	} else {
	// 		$candidates->with('resume')->with('newskills');
	// 	}

	// 	$candidates = $candidates->paginate(10);

	// 	$noload = 1;
	// 	if ($candidates->hasMorePages()) {
	// 		$noload = 0;
	// 	}

	// 	$noloadprev = 0;
	// 	if ($pagecount == 1) {
	// 		$noloadprev = 1;
	// 	}

	// 	$data['noload']       = $noload;
	// 	$data['noloadprev']   = $noloadprev;
	// 	$data['popcount']     = $pagecount + 1;
	// 	$data['success']      = 1;
	// 	$data['resumelist']   = view('frontend.profile.createpopup')->with('candidates', $candidates)->render();
	// 	return response()->json($data);
	// }


	//get candidates for profile miner in job create recomented
	public function getallmatchcandidates(Request $request)
	{

		$existjob = PendingJob::where('organization_id', auth()->user()->organization_id)->where('user_id', auth()->user()->id)->first();

		parse_str($request->frm, $input);
		if (!$existjob) {
			$pendjob = new PendingJob;
			$pendjob->organization_id   = auth()->user()->organization_id;
			$pendjob->user_id           = auth()->user()->id;
			$pendjob->name              = $input['jobtitle'];
			$pendjob->description       = $input['jobdescription'];
			$pendjob->is_recoment       = 1;
			$pendjob->save();
		} else {
			$existjob->name              = $input['jobtitle'];
			$existjob->description       = $input['jobdescription'];
			$existjob->is_recoment       = 1;
			$existjob->update();
		}
		if ($input['skills'] != '') {

			foreach ($input['skills'] as $skill) {
				$sk[] = $skill;
			}


			$skills = implode(',', $sk);
		}
		$datatoPost = array();
		$datatoPost[] = array(
			'Skills' => $existjob->skills,
			'MandatorySkills' => $skills,
			'job_role' => $input['job_role'],
			'MinExp' => $input['min_experience'],
			'MaxExp' => $input['max_experience'],
			'ctc' => $input['offered_ctc'],
			'location' => $input['location'],
			'joining_date' => $input['joining_date'],
			'organization_id' => auth()->user()->organization_id,
			'user_id' => auth()->user()->id
		);

		$postdata = json_encode($datatoPost);
		$string1 = $postdata;
		$post = preg_replace('(^.)', '', $string1);
		$post = preg_replace('(.$)', '', $post);
		$ch = curl_init(env('CANDIDATE_URL'));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);
		$myfile = fopen("C:\Pephire\RecommedationReq.txt", "w") or die("Unable to open file!");
		$txt = $post;
		fwrite($myfile, $txt);
		fclose($myfile);
		$myfile = fopen("C:\Pephire\RecommedationRes.txt", "w") or die("Unable to open file!");
		$txt = $response;
		fwrite($myfile, $txt);
		fclose($myfile);

		if ($httpCode == 0) //Service might not be running
		{
			$data['popcount']     = 0;
			$data['error']        = 1;
			$data['errorMsg']     = "No profiles recommend. Please choose profile from the profile database.";
			$data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', array())->render();
			return response()->json($data);
		} else if ($err) {
			$data['popcount']     = 0;
			$data['error']        = 1;
			$data['errorMsg']     = "No profiles recommend. Please choose profile from the profile database.";
			$data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', array())->render();
			return response()->json($data);
		} else {
			$candidateIds = array();
			$skills = array();
			$result = json_decode($response, true);
			if (!empty($result)) {
				foreach ($result as $pk => $pv) {
					$candidateIds[] = $pv['id'];
				}
			} else {
				$data['popcount']     = 0;
				$data['error']        = 1;
				$data['errorMsg']     = "No profiles recommend. Please choose profile from the profile database.";
				$data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', array())->render();
				return response()->json($data);
			}
		}

		if (!empty($candidateIds)) {

			$organization = Organization::where('id', auth()->user()->organization_id)->first();

			$candidates = Candidate::where('organization_id', auth()->user()->organization_id)
				->whereIn('id', $candidateIds)
				->where('status', '!=', 3)

				->take($organization->max_resume_count)
				->get();
		}

		$exist_count = Organizations_Hold_Resume::where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)->count();

		if ($exist_count) {
			Organizations_Hold_Resume::where('organization_id', auth()->user()->organization_id)
				->where('user_id', auth()->user()->id)
				->delete();
		}
		$organization = Organization::where('id', auth()->user()->organization_id)->first();

		if (!empty($candidates)) {

			foreach ($candidates as  $cv) {

				$candidate_hold = new Organizations_Hold_Resume;
				$candidate_hold->organization_id  = $cv->organization_id;
				$candidate_hold->resume_id        = $cv->resume_id;
				$candidate_hold->candidate_id     = $cv->id;
				$candidate_hold->user_id     = auth()->user()->id;


				$candidate_hold->save();
			}
		}

		$resumes = Organizations_Hold_Resume::with('candidate')->with('resume')->where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)
			->take($organization->max_resume_count)
			->get();

		$data['popcount']     = count($resumes);
		$data['success']      = 1;
		$data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', $resumes)->render();
		return response()->json($data);
	}


	//get candidates profiles after removed one candidate
	public function getallresumes(Request $request)
	{
		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		$resumes = Organizations_Hold_Resume::with('candidate')->with('resume')->where('organization_id', auth()->user()->organization_id)
			->where('user_id', auth()->user()->id)
			->take($organization->max_resume_count)->get();
		$data['popcount']     = count($resumes);
		$data['success']      = 1;
		$data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', $resumes)->render();
		return response()->json($data);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function profiledatabase()
	{
		//
		$organization = Organization::where('id', auth()->user()->organization_id)->first();
		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)
			->where('page', 'pickprofile')
			->first();
		// $candidates = Candidate::with('holdstat')
		// 	->with('resume')
		// 	->with('newskills')
		// 	->where('organization_id', $organization->id)
		// 	->active()
		// 	->whereNotNull('name')
		// 	->whereNotNull('phone')
		// 	->orderBy('id', 'DESC')->paginate(10);
		$candidates = Candidate::with('holdstat')
    ->with('resume')
    ->with('newskills')
    ->where('organization_id', $organization->id)
    ->active()
    ->whereNotNull('name')
    ->whereNotNull('phone')
    ->whereNotIn('id', function ($query) {
        $query->select('candidate_id')
            ->from('shortlisted_candidates');
    })
    ->orderBy('id', 'DESC')
    ->paginate(10);


		$totalcount = Organizations_Hold_Resume::where('organization_id', $organization->id)
			->where('user_id', auth()->user()->id)
			->count();
		$user = User::where('id', auth()->user()->id)->first();
		$resumecount = Resume::where('organization_id', $organization->id)->count();

		$remaining   = $organization->max_resume_count - $totalcount;

		$header_class  = 'jobs';

		$header_class = 'profile';
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/profile/listdb', compact('header_class', 'candidates', 'totalcount', 'organization', 'filter', 'resumecount', 'remaining', 'auto_job', 'schedule', 'user'));
	}

	public function resetform_profile()
	{
		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)->where('uid', auth()->user()->id)
			->where('page', 'profile_database')->first();
		if ($filter) {
			$filter->delete();
		}
		return redirect('/profiledatabase');
	}

	public function resetform_pickprofile()
	{
		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)->where('uid', auth()->user()->id)
			->where('page', 'pickprofile')->first();
		if ($filter) {
			$filter->delete();
		}
		return redirect('/profileminer');
	}


	//get candidates by search in profile database
	public function candidatesearch(Request $request)
	{
		parse_str($request->frm, $input);

		$skillIds = $companyIds = array();

		
		if ($input['skill'] != '') {

$skillsnames = explode(',', $input['skill']);
}

		if (!empty($input['company'])) {

			$companynames = explode(',', $input['company']);
		}
		if (!empty($skillsnames)) {


foreach ($skillsnames as $key => $value) {

	if ($key == 0 && $value != '') {

		$skillObj   = SkillMaster::where('name', $value);
	} else if ($value != '') {

		$skillObj->orWhere('name', $value);
	}
}

$skillIds   = $skillObj->pluck('name')->toArray();
}

		if (!empty($companynames)) {

			foreach ($companynames as $keyc => $valuec) {

				if ($keyc == 0) {

					$compObj   = Company::where('name', 'LIKE', '%' . $valuec . '%');
				} else {

					$compObj->orWhere('name', 'LIKE', '%' . $valuec . '%');
				}
			}

			$companyIds   = $compObj->pluck('id')->toArray();
		}



		$candObj = Candidate::with('holdstat')->where('organization_id', auth()->user()->organization_id);


		$expArray = $request->exp;

		// $candidates = Candidate::with('holdstat')
		// 	->select(DB::raw(" candidates.photo,candidates.deleted_at,candidates.phone, candidates.sex, candidates.name, experience, candidates.created_at, candidates.id, candidates.cuid, candidates.resume_id, group_concat(distinct skill_master.name order by skill_master.name asc separator ',') as skills"))
		// 	->join('candidatesubskills', 'candidates.id', '=', 'candidatesubskills.candidate_id')
		// 	->leftJoin('candidate_companies', 'candidate_companies.candidate_id', '=', 'candidatesubskills.candidate_id')
		// 	->join('skill_master', 'candidatesubskills.skill_id', '=', 'skill_master.id')
		// 	->where('organization_id', auth()->user()->organization_id)
		// 	->groupby('candidatesubskills.candidate_id');
			
		$candidates =  Candidate::with('holdstat')
			->select(DB::raw(" candidates.photo,candidates.deleted_at,candidates.phone, candidates.sex, candidates.name, experience, candidates.created_at, candidates.id, candidates.cuid, candidates.resume_id, group_concat(distinct candidatesubskills.name ) as skills"))
			->join('candidatesubskills', 'candidatesubskills.candidate_id', '=', 'candidates.id')
			->leftJoin('candidate_companies', 'candidate_companies.candidate_id', '=', 'candidatesubskills.candidate_id')
			// ->join('skill_master', 'candidatesubskills.skill_id', '=', 'skill_master.id')
			->where('organization_id', auth()->user()->organization_id)
			->whereNull('candidates.deleted_at')
			->groupby('candidatesubskills.candidate_id');
			if (!empty($skillIds)) {
			$candidates->whereIn('candidatesubskills.name', $skillIds)
				->having(DB::raw('count(candidatesubskills.name)'), '=', count($skillIds));
		}
		if (!empty($companyIds)) {
			$candidates->whereIn('company_id', $companyIds);
		}
		if (!empty($nameIds)) {

			$candidates->whereIn('candidates.id', $nameIds);
		}
		if ($expArray) {
			$candidates->where('experience', '>=', $expArray[0])->where('experience', '<=', $expArray[1]);
		}
		$candidates_result = $candidates->paginate(10);
		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)
			->where('page', 'pickprofile')->first();
		if (!$filter) {
			$apply_filter = new ApplyFilter;
			$apply_filter->exp_1   = $expArray[0];
			$apply_filter->exp_2  = $expArray[1];
			$apply_filter->skills   = $input['skill'];
			$apply_filter->oid   = auth()->user()->organization_id;
			$apply_filter->uid   = auth()->user()->id;
			$apply_filter->page   = 'pickprofile';
			$apply_filter->company   = $input['company'];
			$apply_filter->save();
		} else {
			$filter->exp_1   = $expArray[0];
			$filter->exp_2  = $expArray[1];
			$filter->skills   = $input['skill'];
			$filter->company   = $input['company'];
			$filter->update();
		}

		$candidates_count_query = clone $candidates;
		$candidates_count = $candidates->getCountForPagination();

		$offset = $request->page;
		$limit = 15;
		$candidates->offset($offset * $limit)->take($limit);

		$data['page'] = $request->page;
		$data['totalcount'] = $candidates_count;
		$data['resumelist'] = $candidates_result;
		$data['data'] = $candidates_result;
		$data['skillIds'] = $skillIds;
		$data['resumelist']   = view('frontend.profile.searchdb')->with('candidates', $candidates_result)->render();
		return response()->json($data);
	}
	public function candidatesearch_new(Request $request)
	{

		parse_str($request->frm, $input);

		// Log::info(print_r($input, true));
		$skillIds = $companyIds = array();

		if ($input['skill'] != '') {

			$skillsnames = explode(',', $input['skill']);
		}

		if ($input['company'] != '') {

			$companynames = explode(',', $input['company']);
		}

		if ($input['name'] != '') {

			$names = explode(',', $input['name']);
		}


		if (!empty($names)) {
			$nameObj = Candidate::where('name', 'LIKE', '%' . $names[0] . '%');

			foreach ($names as $keyn => $valuen) {
				if ($valuen != '') {
					$nameObj = $nameObj->orWhere('name', 'LIKE', '%' . $valuen . '%');
				}
			}

			$nameIds = $nameObj->pluck('id')->toArray();
		}
		Log::info(print_r($nameIds, true));
		if (!empty($skillsnames)) {


			foreach ($skillsnames as $key => $value) {

				if ($key == 0 && $value != '') {

					$skillObj   = SkillMaster::where('name', $value);
				} else if ($value != '') {

					$skillObj->orWhere('name', $value);
				}
			}

			$skillIds   = $skillObj->pluck('name')->toArray();
		}
		// if (!empty($skillsnames)) {
		//  	$skillIds   = $skillsnames;
		// }

		// Log::info(print_r($skillIds, true));
		if (!empty($companynames)) {

			foreach ($companynames as $keyc => $valuec) {
				if ($valuec) {
					if ($keyc == 0) {

						$compObj   = Company::where('name', 'LIKE', '%' . $valuec . '%');
					} else {

						$compObj->orWhere('name', 'LIKE', '%' . $valuec . '%');
					}
				}
			}

			$companyIds   = $compObj->pluck('id')->toArray();
		}



		$candObj = Candidate::where('organization_id', auth()->user()->organization_id)->first();


		$expArray = $request->exp;
		$getDates = explode('-', $request->daterange);

		$candidates =  DB::table('candidatesubskills')
			->select(DB::raw(" candidates.photo,candidates.deleted_at,candidates.phone, candidates.sex, candidates.name, experience, candidates.created_at, candidates.id, candidates.cuid, candidates.resume_id, group_concat(distinct candidatesubskills.name ) as skills"))
			->join('candidates', 'candidatesubskills.candidate_id', '=', 'candidates.id')
			->leftJoin('candidate_companies', 'candidate_companies.candidate_id', '=', 'candidatesubskills.candidate_id')
			// ->join('skill_master', 'candidatesubskills.skill_id', '=', 'skill_master.id')
			->where('organization_id', auth()->user()->organization_id)
			->whereNull('candidates.deleted_at')
			->groupby('candidatesubskills.candidate_id');

		if (!empty($skillIds)) {
			$candidates->whereIn('candidatesubskills.name', $skillIds)
				->having(DB::raw('count(candidatesubskills.name)'), '=', count($skillIds));
		}
		if (!empty($companyIds)) {
			$candidates->whereIn('company_id', $companyIds);
		}
		if (!empty($nameIds)) {

			$candidates->whereIn('candidates.id', $nameIds);
		}
		if ($expArray) {

			$candidates->where('experience', '>=', $expArray[0])->where('experience', '<=', $expArray[1]);
		}
		Log::error($expArray[0] . '---' . $expArray[1]);

		$candii = $candidates->get();
		Log::info(print_r($candii, true));

		if ($getDates) {
			$start_date = Carbon::createFromFormat('m/d/Y', trim($getDates[0]))->format('Y-m-d');
			$end_date = Carbon::createFromFormat('m/d/Y', trim($getDates[1]))->format('Y-m-d');
			// Log::error($start_date . '---' . $end_date);
			if ($start_date && $end_date) {
				$candidates->whereDate('candidates.created_at', '>=', $start_date)->whereDate('candidates.created_at', '<=', $end_date);
			}
		}
		$offset = $request->page;
		$limit = 15;
		$candidates_result = $candidates->get();
		$candidates_count_query = clone $candidates;
		$candidates_count = $candidates->getCountForPagination();

		$filter = ApplyFilter::where('oid', auth()->user()->organization_id)
			->where('page', 'profile_database')->first();



		if (!$filter) {
			$apply_filter = new ApplyFilter;
			$apply_filter->exp_1   = $expArray[0];
			$apply_filter->exp_2  = $expArray[1];
			$apply_filter->skills   = $input['skill'];
			$apply_filter->oid   = auth()->user()->organization_id;
			$apply_filter->uid   = auth()->user()->id;
			$apply_filter->page   = 'profile_database';
			$apply_filter->company   = $input['company'];
			$apply_filter->name   = $input['name'];
			$apply_filter->uploaded_date_1   = $start_date;
			$apply_filter->uploaded_date_2   = $end_date;
			$apply_filter->save();
		} else {
			$filter->exp_1   = $expArray[0];
			$filter->exp_2  = $expArray[1];
			$filter->skills   = $input['skill'];
			$filter->company   = $input['company'];
			$filter->name   = $input['name'];
			$filter->uploaded_date_1   = $start_date;
			$filter->uploaded_date_2   = $end_date;
			$filter->update();
		}
		// Log::info(print_r($candidates_result, true));
		$data['page'] = $request->page;
		$data['totalcount'] = $candidates_count;

		$data['skillIds'] = $skillIds;
		if (sizeof($candidates_result)) {
			$data['resumelist']   = view('frontend.profile.dbsearch')->with('candidates', $candidates_result)->render();
		} else {
			$data['resumelist']   = '<p class="alert alert-warning text-center">No  profile</p>';
		}
		return response()->json($data);
	}



	public function listCandidates()
	{


		$fetch = InterviewTimeslot::where('hasAllotted', 1)->first();
		if (!empty($fetch)) {
			$candidates = Candidate::where('id', $fetch->allotted_candidate_id)->first();
		} else {
			$candidates = '';
		}
		$timeslots = InterviewTimeslot::where('hasAllotted', 1)
			->where('user_id', auth()->user()->id)
			->orderBy('interview_date', 'desc')
			->orderBy('interview_start_time', 'desc')
			->paginate(10);

		$interviewersArr = InterviewTimeslot::distinct('interviewer_name')->where('user_id', auth()->user()->id)->pluck('interviewer_name')->toArray();

		if ($s_date = InterviewTimeslot::where('hasAllotted', 1)->orderBy('interview_date', 'asc')->where('user_id', auth()->user()->id)->first()) {
			$sel_startdate = $startdate = $s_date->interview_date;
		} else {
			$sel_startdate = $startdate = '2020-01-01';
		}

		if ($s_date = InterviewTimeslot::where('hasAllotted', 1)->orderBy('interview_date', 'desc')->where('user_id', auth()->user()->id)->first()) {
			$sel_enddate = $enddate = $s_date->interview_date;
		} else {
			$sel_enddate = $enddate = '2020-01-01';
		}

		$sel_starttime = 0;
		$sel_endtime = 1440;
		$header_class   = 'candidates.list';
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();

		return view('frontend/candidate/list', compact('header_class', 'candidates', 'timeslots', 'interviewersArr', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'sel_starttime', 'sel_endtime', 'auto_job', 'schedule'));
	}

	public function filterCandidates(Request $request)
	{

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

		$timeslots = InterviewTimeslot::where('hasAllotted', 1)
			->where('interview_start_time', '>=', $filter_start_time)->where('interview_start_time', '<=', $filter_end_time);

		if ($sel_interviewer_name) {
			$timeslots = $timeslots->where('interviewer_name', $sel_interviewer_name);
		}
		$timeslots = $timeslots->paginate(10);

		$interviewersArr = InterviewTimeslot::distinct('interviewer_name')->pluck('interviewer_name')->toArray();

		$startdate = InterviewTimeslot::orderBy('interview_date', 'asc')->first()->interview_date;
		$enddate = InterviewTimeslot::orderBy('interview_date', 'desc')->first()->interview_date;
		$header_class   = 'candidates.list';
		$auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();
		return view('frontend/candidate/list', compact('header_class', 'timeslots', 'interviewersArr', 'startdate', 'enddate', 'sel_startdate', 'sel_enddate', 'sel_starttime', 'sel_endtime', 'sel_interviewer_name', 'auto_job', 'schedule'));
	}
}
