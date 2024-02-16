<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Tag;
use App\User;
use App\Skill;
use App\Resume;
use App\Candidate;
use App\SkillMaster;
use Ramsey\Uuid\Uuid;
use App\Organization;
use App\Candidate_Tag;
use App\Candidate_Skill;
use App\Candidateskills;
use App\Pending_Candidate;
use Illuminate\Http\Request;
use App\Organizations_Hold_Resume;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use File;
use ZipArchive;


class ResumeController extends Controller
{

    public function __construct()
    {
        ini_set('max_execution_time', 3600);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function show(Resume $resume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume)
    {
        //
    }

    /**
     * Remove the specified resource from current job.
     *
     * @param  \App\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function putonhold(Request $request)
    {
        //
        $resume             = Resume::where('id', $request->id)->first();
        $resume->putonhold  = 1;
        $resume->update();

        return response()->json(array('success' => 1));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resume     = Resume::where('id', $request->id)->first();

        $candidate  = Candidate::where('resume_id', $resume->id)->first();





        $post = json_encode(array(

            "organization_id" => auth()->user()->organization_id,

            "phone" => $candidate->phone

        ));



        $ch = curl_init("http://127.0.0.1:9001/cleartransdb");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);



        // execute!

        $pythonCall = curl_exec($ch);



        // close the connection, release resources used

        curl_close($ch);



        $resume->delete();

        $candidate->delete();

        return response()->json(array('success' => 1));
    }



    public function docpcupload(Request $request)

    {



        $organization = Organization::where('id', auth()->user()->organization_id)->first();

        $data = array();

        if ($request->pc) {



            $fileHash = $fileName = $path = '';

            $fileHash = Uuid::uuid1()->toString();

            $fileName = $fileHash . '.' . strtolower($request->pc->getClientOriginalExtension());

            $path = Storage::putFileAs('organization/' . $organization->ouid, $request->pc, $fileName);



            if ($path) {

                $resume                     = new Resume;

                $resume->ruid               = Uuid::uuid1()->toString();

                $resume->organization_id    = $organization->id;

                $resume->user_id            = auth()->user()->id;

                $resume->resume             = $path;

                $resume->name               = $request->pc->getClientOriginalName();

                $resume->filesize           = round($request->pc->getSize() * 0.000001, 3);

                $resume->save();
            }
        } else {



            $datas = array();

            $datas['error']    = 1;

            $datas['errorMsg']  = "No file choosen";



            return response()->json($datas);
        }



        /////api
        $data[] = array(

            'resume_id' => $resume->id,

            'resume_title' => $resume->name,

            'download_link' => 'E:\Pephire_resumes\storage\app/' . $resume->resume,

            'organization_id' => auth()->user()->organization_id,

            'user_id' => auth()->user()->id,
            'source' => 'manual',


        );



        $postdata = json_encode($data);



        $curl = curl_init();



        curl_setopt_array($curl, array(

            CURLOPT_PORT => "5001",

            CURLOPT_URL => 'http://127.0.0.1:5001/parameters',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_ENCODING => "",

            CURLOPT_MAXREDIRS => 10,

            CURLOPT_TIMEOUT => 30,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_CUSTOMREQUEST => "POST",

            CURLOPT_POSTFIELDS => $postdata,

            CURLOPT_HTTPHEADER => array(

                "Content-Type: application/json",

                "Postman-Token: dae13fc3-3858-42f8-946f-d71930d357a3",

                "cache-control: no-cache"

            ),

        ));



        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $err = curl_error($curl);



        curl_close($curl);


              // Decode the JSON string into a PHP associative array

        $data = json_decode($response, true);



        // Extract values from the array and assign them to variables

        Log::info(print_r($response, true));

        $status = $data['status'];
        if ($status == 'failed') { //Service might not be running
            //email for admin

            $nextcount = $request->currentcount + 1;

            $datas = array();

            $datas['error']    = 1;



            $datas['nextcount'] = $nextcount;

            $datas['errorMsg']  = "The attribution Error. Please try again later. If the issue persists, please contact info@pephire.com";



            return response()->json($datas);
        } else if ($status == 'success') {
            $candidate_id = $data['candidate_id'];

            $cand = Candidate::where('id', $candidate_id)->first();
            Log::error($cand);


            $candidate_profile_links = DB::table('candidate_profile_links')

                ->insert([

                    'candidate_id' => $cand->id,

                    'webLink' => route('candidateProfile.edit',  $cand->cuid),

                ]);


            $nextcount = $request->currentcount + 1;



            $datas = array();

            $datas['success']    = 1;

            $datas['nextcount']  = $nextcount;

            return response()->json($datas);
        }
    }






    public function driveupload(Request $request)
    {
        parse_str($request->frm, $input);
        $organization = Organization::where('id', auth()->user()->organization_id)->first();

        $data = array();

        if ($request->data) {
            foreach ($request->data as $key) {

                $docpath = 'organization/' . $organization->ouid;
                if (!Storage::has($docpath)) {
                    Storage::makeDirectory($docpath);
                }

                $fileName = explode('.', $key['name']);
                $extension = end($fileName);
                $name = $docpath . '/' . $key['id'] . '.' . $extension;

                $oAuthToken = $request->token;
                $fileId     = $key['id'];
                $getUrl = 'https://www.googleapis.com/drive/v2/files/' . $fileId . '?alt=media'; //
                $authHeader = 'Authorization: Bearer ' . $oAuthToken;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array($authHeader));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $file = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                Storage::put($name, $file);


                $resume                     = new Resume;
                $resume->ruid               = Uuid::uuid1()->toString();
                $resume->organization_id    = $organization->id;
                $resume->user_id            = auth()->user()->id;
                $resume->resume             = $name;
                $resume->name               = $key['name'];
                $resume->filesize           = round($key['sizeBytes'] * 0.000001, 3);
                $resume->upload_via         = 'drive';
                $resume->save();

                $number = Candidate::where('organization_id', $organization->id)->count();

                $number    = $number + 1;
                $candidate = new Candidate;
                $candidate->cuid            = Uuid::uuid1()->toString();
                $candidate->cuno            = sprintf('%06d', $number);
                $candidate->organization_id = $organization->id;
                $candidate->user_id         = auth()->user()->id;
                $candidate->resume_id       = $resume->id;
                $candidate->flag        = '0';
                $candidate->status        = 4;
                $candidate->save();
            }
        } else {
            $data['error']              = 1;
            $data['errormsg']           = 'No file choosen';
            return response()->json($data);
        }

        $data['success']      = 1;
        return response()->json($data);
    }

    public function downloadresume(Request $request)
    {
        $fileResumes = [];
        $checked = $request->input('resume');
        if ($checked) {
            foreach ($checked as $bjid) {

                $resume = Resume::where('id', $bjid)->first();
                $file_resume = $resume->resume;

                $file_name = 'E:\Pephire_resumes\storage\app/' . $resume->resume;

                array_push($fileResumes, $file_name);
            }
        }

        $zip = new ZipArchive;

        $fileName = 'BulkJob_Report.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = $fileResumes;

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        return response()->download(public_path($fileName));
    }


    public function downloadZip(Request $request)
    {

        $fileResumes = [];
        $checked = $request->input('resume');

        if ($checked != '') {
            foreach ($checked as $bjid) {

                $resume = Resume::where('id', $bjid)->first();
                $file_resume = $resume->resume;

                $file_name = 'E:\Pephire_resumes\storage\app/' . $resume->resume;

                array_push($fileResumes, $file_name);
            }

            $zip = new ZipArchive;

            $fileName = 'Report.zip';

            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                $files = $fileResumes;

                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }

                $zip->close();
            }

            return response()->download(public_path($fileName));
        }
    }

    public function dropboxupload(Request $request)
    {
        parse_str($request->frm, $input);
        $organization = Organization::where('id', auth()->user()->organization_id)->first();

        $data = array();

        if ($request->data) {
            foreach ($request->data as $key) {
                $docpath = 'organization/' . $organization->ouid;
                if (!Storage::has($docpath)) {
                    Storage::makeDirectory($docpath);
                }

                $contents = file_get_contents($key['link']);
                $extension = pathinfo($key['link'], PATHINFO_EXTENSION);
                $name = $docpath . '/' . str_replace("id:", "", $key['id']) . '.' . $extension;

                Storage::put($name, $contents);

                $resume                     = new Resume;
                $resume->ruid               = Uuid::uuid1()->toString();
                $resume->organization_id    = $organization->id;
                $resume->user_id            = auth()->user()->id;
                $resume->resume             = $name;
                $resume->name               = $key['name'];
                $resume->filesize           = round($key['bytes'] * 0.000001, 3);
                $resume->upload_via         = 'dropbox';
                $resume->save();

                $number = Candidate::where('organization_id', $organization->id)->count();

                $number    = $number + 1;
                $candidate = new Candidate;
                $candidate->cuid            = Uuid::uuid1()->toString();
                $candidate->cuno            = sprintf('%06d', $number);
                $candidate->organization_id = $organization->id;
                $candidate->user_id         = auth()->user()->id;
                $candidate->resume_id       = $resume->id;
                $candidate->flag        = '0';
                $candidate->save();
            }
        } else {
            $data['error']              = 1;
            $data['errormsg']           = 'No file choosen';
            return response()->json($data);
        }


        $data['success']      = 1;

        return response()->json($data);
    }


    public function getresumelist(Request $request)
    {

        $organization = Organization::where('id', auth()->user()->organization_id)->first();

        $resumes = Organizations_Hold_Resume::with('candidate')->with('resume')->where('organization_id', $organization->id)
            ->where('user_id', auth()->user()->id)->get();

        $data['success']      = 1;
        $data['totalcount']   = $resumes->count();
        $data['left_count']   = $organization->max_resume_count - $resumes->count();
        $data['resumelist']   = view('frontend.resumes.create_list')->with('resumes', $resumes)->render();
        return response()->json($data);
    }


    private function sendmail($data, $subject, $view)
    {
        Mail::send($view, $data, function ($message) use ($data, $subject) {
            $message->to($data['email1'], $data['name'])->subject($subject);
        });
    }

    //python call to resume attributes
    public function getAttributesApi($candidateid)
    {

        $candidate = Candidate::with('resume')->where('id', $candidateid)->first();

        $data = array();
        if (!empty($candidate)) {
            $data[] = array(
                'resume_id' => $candidate->id,
                'resume_title' => $candidate->resume->name,
                'download_link' => public_path('storage/' . $candidate->resume->resume),
                'organization_id' => auth()->user()->organization_id,
                'user_id' => auth()->user()->id
            );
        }

        $postdata = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "5000",
            CURLOPT_URL => "http://127.0.0.1:5001/parameters",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: dae13fc3-3858-42f8-946f-d71930d357a3",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            //email for admin
            $candidate->name    = $candidate->resume->name;
            $candidate->update();
        } else {
            $result = json_decode($response, true);

            if (!empty($result)) {
                foreach ($result as $ck => $cv) {

                    $candidate = Candidate::where('id', $cv['resume_id'])->first();
                    $name = '';
                    if ($cv['Photo'] != 'No Images') {
                        $photolocation = url('/extracted_images/') . $cv['Photo'];
                        if (file_exists($photolocation)) {
                            $docpath = 'candidates/' . $candidate->organization_id;
                            Storage::makeDirectory($docpath);
                            $contents = file_get_contents($photolocation);
                            $extension = pathinfo($photolocation, PATHINFO_EXTENSION);
                            $name = $docpath . '/' . $candidate->cuid . '.' . $extension;
                            Storage::put($name, $contents);
                        }
                    }

                    $phone = str_replace('+', '', $cv['Contact']);
                    $phone = str_replace(' ', '', $cv['Contact']);
                    $phone = str_replace('-', '', $cv['Contact']);
                    Log::error($phone . 'p2222222222222222222');

                    $candidate->name        = $cv['Name'];
                    $candidate->email       = $cv['Email'];
                    $candidate->phone       = $phone;
                    $candidate->dob         = (strtolower($cv['DOB']) == 'nil') ? NULL : $cv['DOB'];
                    $candidate->passport_no = $cv['Passport'];
                    $candidate->visatype    = $cv['Visa'];
                    $candidate->education   = $cv['Education'];
                    $candidate->sex         = $cv['Sex'];
                    $candidate->married     = $cv['Marital_Status'];
                    $candidate->linkedin_id = $cv['LinkedIn'];
                    $candidate->engage_details = $cv['Engage'];
                    $candidate->productivity_details = $cv['Productivity'];
                    $candidate->corporate_culture = $cv['Corporateculture'];
                    $candidate->strength_details = $cv['Strengths'];
                    $candidate->role = $cv['Role'];
                    $candidate->role_category = $cv['RoleCategory'];
                    // $candidate->location = $cv['location'];
                    // $candidate->ctc = $cv['ctc'];
                    $candidate->flag = '0';
                    $candidate->status        = 4;
                    $candidate->experience  = (strtolower($cv['Experience']) == 'nan') ? 0 :  $cv['Experience'];
                    $candidate->is_profile  = 1;
                    $candidate->photo  = $name;
                    $candidate->update();


                    if (isset($cv['Skills']) && $cv['Skills'] != "") {
                        $skillArray = explode(',', $cv['Skills']);

                        if (!empty($skillArray)) {
                            foreach ($skillArray as $mk) {

                                $newskill = $mk;

                                $existskill = Skill::where('name', $newskill)->first();

                                if (!empty($existskill)) {

                                    $can_skill = new Candidate_Skill;

                                    $can_skill->candidate_id = $candidate->id;
                                    $can_skill->skill_id = $existskill->id;
                                    $can_skill->skillname = $newskill;
                                    $can_skill->save();
                                } else {

                                    $new_skill = new Skill;

                                    $new_skill->suid = Uuid::uuid1()->toString();
                                    $new_skill->name = $newskill;
                                    $new_skill->save();

                                    $can_skill = new Candidate_Skill;

                                    $can_skill->candidate_id = $candidate->id;
                                    $can_skill->skill_id = $new_skill->id;
                                    $can_skill->skillname = $newskill;
                                    $can_skill->save();
                                }
                            }
                        }
                    }


                    if ($cv['Name'] == '') {

                        $resume = Resume::where('id', $candidate->resume_id)->first();
                        $resume->delete();

                        $candidate->delete();
                    }
                }
            }
        }
    }

    public function attributiondocs($retry = NULL)
    {

        if (!$retry) {
            $total_count = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 0)
                ->count();
        } else {
            $total_count = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 1)
                ->where('attribution_retry_status', 0)
                ->count();
        }

        $header_class = 'profile';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/profile/profilescore', compact('header_class', 'total_count', 'retry', 'auto_job', 'schedule'));
    }

    private function handleLoading($total_count, $is_retry)
    {
        if ($is_retry == '0') {
            $yet_to_attribute_count = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 0)
                ->count();
        } else {
            $yet_to_attribute_count = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 1)
                ->where('attribution_retry_status', 0)
                ->count();
        }

        $percent      = 100 / $total_count;
        $scored        = $total_count - $yet_to_attribute_count;
        $totalpercent = $percent * $scored;
        $totalpercent  = number_format((float)$totalpercent, 2, '.', '');

        return array('yet_to_attribute_count' => $yet_to_attribute_count, 'totalpercent' => floor($totalpercent));
    }


    public function profileattributionscore(Request $request)
    {
        $total_count = $request->total_count;

        if ($request->is_retry == '0') {
            $candidate = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 0)
                ->first();
        } else {
            $candidate = Candidate::where('user_id', auth()->user()->id)
                ->where('attribution_status', 0)
                ->where('is_attribute_errror', 1)
                ->where('attribution_retry_status', 0)
                ->first();
        }

        /////api
        if ($candidate) {

            $data[] = array(
                'resume_id' => $candidate->id,
                'resume_title' => $candidate->resume->name,
                'download_link' => public_path('storage/' . $candidate->resume->resume),
                'organization_id' => auth()->user()->organization_id,
                'user_id' => auth()->user()->id
            );

            $postdata = json_encode($data);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "5001",
                CURLOPT_URL => "http://127.0.0.1:5001/parameters",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Postman-Token: dae13fc3-3858-42f8-946f-d71930d357a3",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            if ($httpCode == 0) { //Service might not be running

                if ($request->is_retry == '0') {
                    $candidate->attribution_status  = 0;
                    $candidate->is_attribute_errror  = 1;
                    $candidate->name = $candidate->resume->name;
                } else {
                    $candidate->attribution_retry_status  = 1;
                }
                $candidate->update();

                //email for admin

                $datas = array();
                $datas['error']    = 1;
                $datas['errorMsg']  = "The attribution service is not running. Please try again later. If the issue persists, please contact info@pephire.com";

                $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

                return response()->json($datas);
            } else if ($err) {
                if ($request->is_retry == '0') {
                    $candidate->attribution_status  = 0;
                    $candidate->is_attribute_errror  = 1;
                    $candidate->name = $candidate->resume->name;
                } else {
                    $candidate->attribution_retry_status  = 1;
                }
                $candidate->update();



                //email for admin

                $datas = array();
                $datas['error']    = 1;
                $datas['errorMsg']  = ucfirst($candidate->resume->name) . " : Error in fetching details from candidate resume. Please try again later.";

                $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

                return response()->json($datas);
            } else {
                $result = json_decode($response, true);

                if (isset($result[0]['Data']) && $result[0]['Data'] == 'Error') {

                    $candidate->attribution_status  = 1;
                    $candidate->is_attribute_errror  = 1;
                    $candidate->is_deleted_attribute = 1;
                    $candidate->update();

                    $resume = Resume::where('id', $candidate->resume_id)->first();
                    $resume->delete();

                    $datas = array();
                    $datas['error']    = 1;
                    $datas['errorMsg']  = "Resume " . ucfirst($candidate->resume->name) . " : is Invalid.";

                    $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

                    return response()->json($datas);
                }

                if (empty($result)) {
                    $candidate->attribution_status  = 1;
                    $candidate->is_attribute_errror  = 1;
                    $candidate->is_deleted_attribute = 1;
                    $candidate->update();

                    $datas = array();
                    $datas['error']    = 1;
                    $datas['errorMsg']  = ucfirst($candidate->resume->name) . " : Empty response from candidate resume. Please try again later.";

                    $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

                    return response()->json($datas);
                } else {
                    foreach ($result as $ck => $cv) {

                        //email check user
                        $emailold = Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->count();
                        if ($emailold) {

                            $resemailIds = Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->pluck('resume_id')->toArray();

                            Resume::whereIn('id', $resemailIds)->delete();

                            Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->delete();
                        }
                        //email check user

                        //phone validation
                        $phoneold = Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->count();
                        if ($phoneold) {

                            $resumeIds = Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->pluck('resume_id')->toArray();

                            Resume::whereIn('id', $resumeIds)->delete();

                            Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->delete();
                        }

                        $name = '';
                        if ($cv['Photo'] != 'No Images' && $cv['Photo'] != '') {
                            $photolocation = 'extracted_images/' . $cv['Photo'];
                            if (File::exists($photolocation)) {
                                $docpath = 'candidates/' . $candidate->organization_id;
                                Storage::makeDirectory($docpath);
                                $contents = file_get_contents($photolocation);
                                $extension = pathinfo($photolocation, PATHINFO_EXTENSION);
                                $name = $docpath . '/' . $candidate->cuid . '.' . $extension;
                                Storage::put($name, $contents);
                            }
                        }
                        $phone = str_replace('+', '', $cv['Contact']);
                        $phone = str_replace(' ', '', $cv['Contact']);
                        $phone = str_replace('-', '', $cv['Contact']);

                        $candidate->name        = $cv['Name'];
                        $candidate->email       = ($cv['Email'] != '') ? $cv['Email'] : NULL;
                        $candidate->phone       = ($phone != '') ? $phone : NULL;
                        $candidate->dob         = (strtolower($cv['DOB']) == 'nil') ? NULL : $cv['DOB'];
                        $candidate->passport_no = $cv['Passport'];
                        $candidate->visatype    = $cv['Visa'];
                        $candidate->education   = $cv['Education'];
                        $candidate->sex         = $cv['Sex'];
                        $candidate->married     = $cv['Marital_Status'];
                        $candidate->missingfields = $cv['missingfields'];
                        $candidate->data_completed = $cv['data_completed'];
                        $candidate->linkedin_id = $cv['LinkedIn'];
                        $candidate->engage_details = $cv['Engage'];
                        $candidate->productivity_details = $cv['Productivity'];
                        $candidate->corporate_culture = $cv['Corporateculture'];
                        $candidate->strength_details = $cv['Strengths'];
                        $candidate->role = $cv['Role'];
                        $candidate->role_category = $cv['RoleCategory'];
                        // $candidate->location = $cv['location'];
                        // $candidate->ctc = $cv['ctc'];
                        $candidate->experience  = (strtolower($cv['Experience']) == 'nan') ? 0 :  $cv['Experience'];
                        $candidate->is_profile  = 1;
                        $candidate->photo  = $name;
                        $candidate->attribution_status  = 1;
                        $candidate->is_attribute_errror = 0;
                        $candidate->update();

                        if (isset($cv['SkillIdentified']) && $cv['SkillIdentified'] != "") {
                            $skillArray = explode('|', $cv['SkillIdentified']);

                            if (!empty($skillArray)) {
                                foreach ($skillArray as $mk) {

                                    $mainskilldets = explode('<>', $mk);

                                    $newskill = $mainskilldets[0];

                                    $existskill = SkillMaster::where('name', $newskill)->first();

                                    if (!empty($existskill)) {

                                        $can_skill = new Candidate_Skill;

                                        $can_skill->candidate_id = $candidate->id;
                                        $can_skill->skill_id = $existskill->id;
                                        $can_skill->Score = $mainskilldets[1];
                                        $can_skill->skillname = $newskill;
                                        $can_skill->save();
                                    } else {

                                        $new_skill = new SkillMaster;

                                        $new_skill->name = $newskill;
                                        $new_skill->save();

                                        $can_skill = new Candidate_Skill;

                                        $can_skill->candidate_id = $candidate->id;
                                        $can_skill->skill_id = $new_skill->id;
                                        $can_skill->Score = $mainskilldets[1];
                                        $can_skill->skillname = $newskill;
                                        $can_skill->save();
                                    }
                                }
                            }
                        }


                        if (isset($cv['SubSkillIdentified']) && $cv['SubSkillIdentified'] != "") {
                            $subskillArray = explode('|', $cv['SubSkillIdentified']);

                            if (!empty($subskillArray)) {
                                foreach ($subskillArray as $hk) {

                                    $subskilldets = explode('<>', $hk);

                                    $newsubskill = $subskilldets[0];

                                    $existsubskill = Skill::where('name', $newsubskill)->first();

                                    if (!empty($existsubskill)) {

                                        $cansub_skill = new Candidateskills;

                                        $cansub_skill->candidate_id = $candidate->id;
                                        $cansub_skill->skill_id = $existsubskill->id;
                                        $cansub_skill->Score = $subskilldets[1];
                                        $cansub_skill->save();
                                    } else {

                                        $newsub_skill = new Skill;

                                        $newsub_skill->name = $newsubskill;
                                        $newsub_skill->save();

                                        $cansub_skill = new Candidateskills;

                                        $cansub_skill->candidate_id = $candidate->id;
                                        $cansub_skill->skill_id = $newsub_skill->id;
                                        $cansub_skill->Score = $subskilldets[1];
                                        $cansub_skill->save();
                                    }
                                }
                            }
                        }


                        if (isset($cv['Roles_Tagged']) && $cv['Roles_Tagged'] != "") {
                            $Tagrray = explode('|', $cv['Roles_Tagged']);

                            if (!empty($Tagrray)) {
                                foreach ($Tagrray as $thk) {

                                    $tagdets = explode('<>', $thk);


                                    $existtag = Tag::where('name', $tagdets[0])->first();

                                    if (!empty($existtag)) {

                                        $cand_tag = new Candidate_Tag;

                                        $cand_tag->candidate_id = $candidate->id;
                                        $cand_tag->tag_id = $existtag->id;
                                        $cand_tag->score = $tagdets[1];
                                        $cand_tag->tag_name = $tagdets[0];
                                        $cand_tag->save();
                                    } else {

                                        $newtag = new Tag;

                                        $newtag->name = $tagdets[0];
                                        $newtag->save();

                                        $cand_tag = new Candidate_Tag;

                                        $cand_tag->candidate_id = $candidate->id;
                                        $cand_tag->tag_id = $newtag->id;
                                        $cand_tag->score = $tagdets[1];
                                        $cand_tag->tag_name = $tagdets[0];
                                        $cand_tag->save();
                                    }
                                }
                            }
                        }

                        if ($cv['Name'] == '' || $cv['Contact'] == '') {

                            $candidate->attribution_status  = 1;
                            $candidate->is_attribute_errror  = 1;
                            $candidate->is_deleted_attribute = 1;
                            $candidate->update();

                            $resume = Resume::where('id', $candidate->resume_id)->first();
                            $resume->delete();


                            $datas = array();
                            $datas['error']    = 1;
                            $datas['errorMsg']  = ucfirst($candidate->resume->name) . " : Missing name or contact number data in candidate resume.";

                            $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

                            return response()->json($datas);
                        }
                    }
                }
            }

            // External DB Updation
            $checkAlreadySent = DB::table('candidate_profile_links')->where('candidate_id', $candidate->id)->first();

            if ($candidate->name && $candidate->phone && !$checkAlreadySent) {
                $checkAlreadySentInTrans =  DB::connection('pephire_trans')
                    ->table('candidate_profile_links_v1')->where('candidatePhone', $candidate->phone)->first();

                if (!$checkAlreadySentInTrans) {
                    $external_candidate_profile_links = DB::connection('pephire_trans')
                        ->table('candidate_profile_links_v1')
                        ->insert([
                            'candidate_id' => $candidate->id,
                            'candidateName' => $candidate->name,
                            'user_id' => $candidate->user_id,
                            'organization_id' => $candidate->organization_id,
                            'candidatePhone' => $candidate->phone,
                            'webLink' => route('candidateProfile.edit', $candidate->cuid),
                        ]);

                    $candidate_profile_links = DB::table('candidate_profile_links')
                        ->insert([
                            'candidate_id' => $candidate->id,
                            'webLink' => route('candidateProfile.edit', $candidate->cuid),
                        ]);
                }
            }
        }
        ////api


        $datas = array();
        $datas['success']    = 1;

        $datas = array_merge($datas, $this->handleLoading($total_count, $request->is_retry));

        return response()->json($datas);
    }


    public function pendingresumes($retry = NULL)
    {

        $candidates = Candidate::where('user_id', auth()->user()->id)
            ->where('organization_id', auth()->user()->organization_id)
            ->where('attribution_status', 0)
            ->where('is_attribute_errror', 1)
            ->with('delresume')->paginate(50);

        $deletecandidates = Candidate::where('user_id', auth()->user()->id)
            ->where('organization_id', auth()->user()->organization_id)
            ->where('is_deleted_attribute', 1)
            ->with('delresume')->get();

        // Candidate::where('user_id', auth()->user()->id)
        //     ->where('organization_id', auth()->user()->organization_id)
        //     ->where('is_deleted_attribute', 1)
        //     ->delete();

        $header_class = 'profile';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();
        return view('frontend/profile/notscored', compact('header_class', 'candidates', 'deletecandidates', 'retry', 'auto_job', 'schedule'));
    }


    public function downloaddoc(Request $request)
    {

        $resume = Resume::where('ruid', $request->ruid)->first();
        Log::error($resume->resume . 'path');
        Log::error($resume->name . 'name');
        return response()->download('E:\Pephire_resumes\storage\app/' . $resume->resume, $resume->name);
    }


    public function Apidocupload(Request $request)
    {
        $userdata = User::where('email', $request->email)->first();

        if (!$userdata) {
            $data['status']            = false;
            $data['message']           = 'Not a valid user';
            $data['data']              = array();
            return response()->json($data);
        }

        $organization = Organization::where('id', $userdata->organization_id)->first();
        $data = array();
        $datas = array();
        if ($request->resume) {


            $documentloc = $request->resume;
                $fileHash = Uuid::uuid1()->toString();
                $docpath = 'organization/' . $organization->ouid;
                Storage::makeDirectory($docpath);
                $contents = file_get_contents($documentloc);
                $extension = pathinfo($documentloc, PATHINFO_EXTENSION);
                $path = $docpath . '/' . $fileHash . '.' . $extension;
                Storage::put($path, $contents);
           


            if ($path) {
                $resume                     = new Resume;
                $resume->ruid               = Uuid::uuid1()->toString();
                $resume->organization_id    = $organization->id;
                $resume->user_id            = $userdata->id;
                $resume->resume             = $path;
                $resume->name               = $request->resume_name;
                $resume->filesize           = 0;
                $resume->save();


               
            }
        } else {
            $data['status']            = false;
            $data['message']           = 'No file selected';
            $data['data']              = array();
            return response()->json($data);
        }

Log::error($request->source.'jijijijiiiiiiiiiiiiiiiiiiiii');

      

            $data[] = array(
                'resume_id' => $resume->id,

                'resume_title' => $resume->name,
    
                'download_link' => 'E:\Pephire_resumes\storage\app/' . $resume->resume,
    
                'organization_id' => $request->organization_id,
    
                'user_id' => $request->user_id,
                'source' => $request->source
            );

            $postdata = json_encode($data);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "5001",
                CURLOPT_URL => "http://127.0.0.1:5001/parameters",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Postman-Token: dae13fc3-3858-42f8-946f-d71930d357a3",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

           

        ////api

        $datas['status']            = true;
        $datas['message']           = 'success';
        $datas['data']              = array(
            'resume_id' => $resume->id,

            'resume_title' => $resume->name,

            'download_link' => 'E:\Pephire_resumes\storage\app/' . $resume->resume,

            'organization_id' => auth()->user()->organization_id,

            'user_id' => auth()->user()->id,
            'source' => $request->source
        );

        return response()->json($datas);
    }



    public function submitresume(Request $request)
    {
        $userid = $request->userid;

        $userdets = Pending_Candidate::where('id', $userid)->first();

        $organization = Organization::where('id', 1)->first();

        $data = array();
        if ($request->resume) {

            $fileHash = $fileName = $path = '';
            $fileHash = Uuid::uuid1()->toString();
            $fileName = $fileHash . '.' . strtolower($request->resume->getClientOriginalExtension());
            $path = Storage::putFileAs('organization/' . $organization->ouid, $request->resume, $fileName);

            if ($path) {
                $resume                     = new Resume;
                $resume->ruid               = Uuid::uuid1()->toString();
                $resume->organization_id    = 1;
                $resume->user_id            = 1;
                $resume->resume             = $path;
                $resume->name               = $request->resume->getClientOriginalName();
                $resume->filesize           = round($request->resume->getSize() * 0.000001, 3);
                $resume->save();

                $number = Candidate::where('organization_id', 1)->count();

                $number                     = $number + 1;
                $candidate                  = new Candidate;
                $candidate->cuid            = Uuid::uuid1()->toString();
                $candidate->cuno            = sprintf('%06d', $number);
                $candidate->organization_id = 1;
                $candidate->user_id         = 1;
                $candidate->resume_id       = $resume->id;
                $candidate->name            = $userdets->name;
                $candidate->email           = $userdets->email;
                $candidate->phone           = $userdets->phone;
                $candidate->location        = $userdets->job_location;
                $candidate->flag        = '0';
                $candidate->status        = 4;
                $candidate->save();

                Pending_Candidate::where('id', $userid)->delete();


                /////api
                if (!empty($candidate)) {

                    $candidate->is_attribute_errror  = 1;
                    $candidate->update();

                    $data[] = array(
                        'resume_id' => $candidate->id,
                        'resume_title' => $candidate->resume->name,
                        'download_link' => public_path('storage/' . $candidate->resume->resume),
                        'organization_id' => 1,
                        'user_id' => 1
                    );

                    $postdata = json_encode($data);

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_PORT => "5001",
                        CURLOPT_URL => "http://127.0.0.1:5001/parameters",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $postdata,
                        CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json",
                            "Postman-Token: dae13fc3-3858-42f8-946f-d71930d357a3",
                            "cache-control: no-cache"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {

                        $candidate->name    = $candidate->resume->name;
                        $candidate->update();

                        Candidate::where('user_id', $userdets->id)->where('attribution_status', '0')->update(array('is_attribute_errror' => 1));



                        //email for admin

                        $datas = array();
                        $datas['error']    = 1;
                        $datas['resumeerror']    = 0;
                        return response()->json($datas);
                    } else {
                        $result = json_decode($response, true);

                        if (isset($result[0]['Data']) && $result[0]['Data'] == 'Error') {

                            $candidate->is_deleted_attribute = 1;
                            $candidate->update();

                            $resume = Resume::where('id', $candidate->resume_id)->first();
                            $resume->delete();
                            $datas = array();
                            $datas['error']    = 1;
                            $datas['resumeerror']    = 1;
                            $datas['filename']    = $resume->name;
                            return response()->json($datas);
                        }

                        if (!empty($result)) {
                            foreach ($result as $ck => $cv) {


                                //email check user
                                $emailold = Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->count();
                                if ($emailold) {

                                    $resemailIds = Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->pluck('resume_id')->toArray();

                                    Resume::whereIn('id', $resemailIds)->delete();

                                    Candidate::where('organization_id', $cv['organization_id'])->where('email', $cv['Email'])->whereNotNull('email')->delete();
                                }
                                //email check user

                                //phone validation
                                $phoneold = Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->count();

                                if ($phoneold) {
                                    $resumeIds = Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->pluck('resume_id')->toArray();

                                    Resume::whereIn('id', $resumeIds)->delete();

                                    Candidate::where('organization_id', $cv['organization_id'])->where('phone', $cv['Contact'])->whereNotNull('phone')->delete();
                                }


                                $name = '';
                                if ($cv['Photo'] != 'No Images' && $cv['Photo'] != '') {
                                    $photolocation = 'extracted_images/' . $cv['Photo'];
                                    if (File::exists($photolocation)) {
                                        $docpath = 'candidates/' . $candidate->organization_id;
                                        Storage::makeDirectory($docpath);
                                        $contents = file_get_contents($photolocation);
                                        $extension = pathinfo($photolocation, PATHINFO_EXTENSION);
                                        $name = $docpath . '/' . $candidate->cuid . '.' . $extension;
                                        Storage::put($name, $contents);
                                    }
                                }
                                $phone = str_replace('+', '', $cv['Contact']);
                                $phone = str_replace(' ', '', $cv['Contact']);
                                $phone = str_replace('-', '', $cv['Contact']);
                                $candidate->name        = $cv['Name'];
                                $candidate->email       = ($cv['Email'] != '') ? $cv['Email'] : NULL;
                                $candidate->phone       = ($phone != '') ? $phone : NULL;
                                $candidate->dob         = (strtolower($cv['DOB']) == 'nil') ? NULL : $cv['DOB'];
                                $candidate->passport_no = $cv['Passport'];
                                $candidate->visatype    = $cv['Visa'];
                                $candidate->education   = $cv['Education'];
                                $candidate->sex         = $cv['Sex'];
                                $candidate->married     = $cv['Marital_Status'];
                                $candidate->missingfields = $cv['missingfields'];
                                $candidate->data_completed = $cv['data_completed'];
                                $candidate->linkedin_id = $cv['LinkedIn'];
                                $candidate->engage_details = $cv['Engage'];
                                $candidate->productivity_details = $cv['Productivity'];
                                $candidate->corporate_culture = $cv['Corporateculture'];
                                $candidate->strength_details = $cv['Strengths'];
                                $candidate->role = $cv['Role'];
                                $candidate->role_category = $cv['RoleCategory'];
                                // $candidate->location = $cv['location'];
                                // $candidate->ctc = $cv['ctc'];
                                $candidate->experience  = (strtolower($cv['Experience']) == 'nan') ? 0 :  $cv['Experience'];
                                $candidate->is_profile  = 1;
                                $candidate->photo  = $name;
                                $candidate->attribution_status  = 1;
                                $candidate->is_attribute_errror = 0;
                                $candidate->update();


                                if (isset($cv['SkillIdentified']) && $cv['SkillIdentified'] != "") {
                                    $skillArray = explode('|', $cv['SkillIdentified']);

                                    if (!empty($skillArray)) {
                                        foreach ($skillArray as $mk) {

                                            $mainskilldets = explode('<>', $mk);

                                            $newskill = $mainskilldets[0];

                                            $existskill = SkillMaster::where('name', $newskill)->first();

                                            if (!empty($existskill)) {

                                                $can_skill = new Candidate_Skill;

                                                $can_skill->candidate_id = $candidate->id;
                                                $can_skill->skill_id = $existskill->id;
                                                $can_skill->Score = $mainskilldets[1];
                                                $can_skill->skillname = $newskill;
                                                $can_skill->save();
                                            } else {

                                                $new_skill = new SkillMaster;

                                                $new_skill->name = $newskill;
                                                $new_skill->save();

                                                $can_skill = new Candidate_Skill;

                                                $can_skill->candidate_id = $candidate->id;
                                                $can_skill->skill_id = $new_skill->id;
                                                $can_skill->Score = $mainskilldets[1];
                                                $can_skill->skillname = $newskill;
                                                $can_skill->save();
                                            }
                                        }
                                    }
                                }



                                if (isset($cv['SubSkillIdentified']) && $cv['SubSkillIdentified'] != "") {
                                    $subskillArray = explode('|', $cv['SubSkillIdentified']);

                                    if (!empty($subskillArray)) {
                                        foreach ($subskillArray as $hk) {

                                            $subskilldets = explode('<>', $hk);

                                            $newsubskill = $subskilldets[0];

                                            $existsubskill = Skill::where('name', $newsubskill)->first();

                                            if (!empty($existsubskill)) {

                                                $cansub_skill = new Candidateskills;

                                                $cansub_skill->candidate_id = $candidate->id;
                                                $cansub_skill->skill_id = $existsubskill->id;
                                                $cansub_skill->Score = $subskilldets[1];
                                                $cansub_skill->save();
                                            } else {

                                                $newsub_skill = new Skill;

                                                $newsub_skill->name = $newsubskill;
                                                $newsub_skill->save();

                                                $cansub_skill = new Candidateskills;

                                                $cansub_skill->candidate_id = $candidate->id;
                                                $cansub_skill->skill_id = $newsub_skill->id;
                                                $cansub_skill->Score = $subskilldets[1];
                                                $cansub_skill->save();
                                            }
                                        }
                                    }
                                }


                                if (isset($cv['Roles_Tagged']) && $cv['Roles_Tagged'] != "") {
                                    $Tagrray = explode('|', $cv['Roles_Tagged']);

                                    if (!empty($Tagrray)) {
                                        foreach ($Tagrray as $thk) {

                                            $tagdets = explode('<>', $thk);

                                            $existtag = Tag::where('name', $tagdets[0])->first();

                                            if (!empty($existtag)) {

                                                $cand_tag = new Candidate_Tag;

                                                $cand_tag->candidate_id = $candidate->id;
                                                $cand_tag->tag_id = $existtag->id;
                                                $cand_tag->score = $tagdets[1];
                                                $cand_tag->tag_name = $tagdets[0];
                                                $cand_tag->save();
                                            } else {

                                                $newtag = new Tag;

                                                $newtag->name = $tagdets[0];
                                                $newtag->save();

                                                $cand_tag = new Candidate_Tag;

                                                $cand_tag->candidate_id = $candidate->id;
                                                $cand_tag->tag_id = $newtag->id;
                                                $cand_tag->score = $tagdets[1];
                                                $cand_tag->tag_name = $tagdets[0];
                                                $cand_tag->save();
                                            }
                                        }
                                    }
                                }

                                if ($cv['Name'] == '' || $cv['Contact'] == '') {

                                    $candidate->is_deleted_attribute = 1;
                                    $candidate->update();

                                    $resume = Resume::where('id', $candidate->resume_id)->first();
                                    $resume->delete();


                                    $datas = array();
                                    $datas['error']    = 1;
                                    $datas['resumeerror']    = 1;
                                    $datas['filename']    = $resume->name;
                                    return response()->json($datas);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $data['error']              = 1;
            return response()->json($data);
        }
        $data['success']      = 1;
        return response()->json($data);
    }
}
