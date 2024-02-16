<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Job;
use App\User;
use App\Resume;
use Carbon\Carbon;
use App\Candidate;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['organizationcreate','checkemailexist','checkemailexistorg','loginajax','homecontactus']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $organization   = Organization::where('id',auth()->user()->organization_id)->first();


        if(!$organization){
            return redirect('/organization-deactive');
        }

        $resume_total   = Candidate::where('organization_id',$organization->id)->count();
        $resume_trashed   = Candidate::withTrashed()->where('organization_id',$organization->id)->count();
        $job_total      = Job::where('organization_id',$organization->id)->count();
        $jobs           = Job::with('candidates')->where('organization_id',$organization->id)->orderBy('id', 'desc')->take(3)->get();
        //dd($jobs);

        $header_class = 'dashboard';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/dashboard',compact('organization','resume_total','job_total','header_class','jobs','resume_trashed','auto_job','schedule'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function organizationdeactive(Request $request)
    {

        $header_class = 'dashboard';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/dashboard-deacive',compact('header_class','schedule','auto_job'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function teaminsight(Request $request)
    {

        $header_class = 'teaminsight';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/teaminsight',compact('header_class','auto_job','schedule'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function businessinsight(Request $request)
    {

        $header_class = 'businessinsight';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/businessinsight',compact('header_class','auto_job','schedule'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sourcing(Request $request)
    {

        $header_class = 'sourcing';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/sourcing',compact('header_class','auto_job','schedule'));
    }


    /**
     * Show the organization create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function organizationcreate()
    {
        return view('frontend/organization/create');
    }

    public function checkemailexist(Request $request){

        $user = User::withTrashed()->where('email',$request->email)->first();
        //$organization = Organization::withTrashed()->where('email',$request->email)->first();

        $organization = array();

        if($organization && ($request->orgid == $organization->id)){
            $organization = array();
        }

        if($user && ($request->userid == $user->id)){
            $user = array();
        }

        if(!$user && !$organization){

            echo 'true';

        }else{

            echo 'false';

        }

    }


    public function checkemailexistorg(Request $request){

        //$user = User::withTrashed()->where('email',$request->email)->first();
        $organization = Organization::withTrashed()->where('email',$request->email)->first();

        if($organization && ($request->orgid == $organization->id)){
            $organization = array();
        }

        if(!$organization){

            echo 'true';

        }else{

            echo 'false';

        }

    }

    /**
     * Show the myprofile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myprofileview(Request $request)
    {
        $userObj     = auth()->user();
        $header_class = 'dashboard';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/profile_edit',compact('header_class','userObj','auto_job','schedule'));
    }


    /**
     * Update the profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updatemyprofile(Request $request)
    {

        $userObj = User::where('id',auth()->user()->id)->first();

        if ($request->hasFile('profileimg')) {

            $imagePath = 'profileimages/'.auth()->user()->organization_id;
            $file = $request->file('profileimg');
            $path = $request->file('profileimg')->store($imagePath);

            $userObj->profileimage           = $path;
        }


        $userObj->name          = $request->name;
        $userObj->designation   = $request->designation;
        $userObj->phone         = $request->phone;
        $userObj->twitter       = $request->twitter;
        $userObj->location      = $request->location;
        $userObj->bio           = $request->bio;
        $userObj->update();
        //dd($userObj);

        return redirect('/profiledatabase');

    }

    /**
     * Show the document.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewfile(Request $request,$cuid)
    {

        $candidate = Candidate::with('resume')->where('cuid',$cuid)->first();

        $urltodoc  = url('/storage/'.$candidate->resume->resume);
        //$urltodoc  = $candidate->resume->resume;

        //dd($candidate);

        $header_class = 'dashboard';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/viewfile',compact('header_class','urltodoc','auto_job','schedule'));
    }


    // login in ajax
    public function loginajax(Request $request){

        $credentials    = $request->only('email', 'password');
        $data           = array();

        $user = User::where('email', $request->input('email'))->first();

        if($user){
            $loggedin_instances = DB::table('sessions')->where('user_id', $user->id)->first();
        }else{
            $loggedin_instances = array();
        }

        if($loggedin_instances){

            $last_seen = Carbon::parse(date('Y-m-d H:i:s',$loggedin_instances->last_activity));

            $absence = Carbon::now()->diffInMinutes($last_seen);

            if ($absence > config('session.lifetime')) {

                Auth::attempt($credentials);
                Auth::logoutOtherDevices($request->password);
                $data['success'] = 1;

            }else{

                $data['multyerror'] = 1;

            }

        }else{

            if (Auth::attempt($credentials)) {
                $data['success'] = 1;
            }else{
                $data['error'] = 1;
            }

        }

        return response()->json($data);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactus(Request $request)
    {

        $header_class = 'contactus';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/contactus',compact('header_class','auto_job','schedule'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sendcontactus(Request $request)
    {

        $data                = array();
        $data['input']       = $request->input();
        $data['name']        = 'Admin';
        //$data['email']       = 'sameer@sentientscripts.com';
        // $data['email']       = 'kurian.benny@quinoid.in';
        $data['email'] = "pephire2019@gmail.com";
        $this->sendmail($data, 'Pephire : Contact Us', 'frontend.mail.contactus');

        return redirect('/contactus')->with('success', 'Email sent successfully');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homecontactus(Request $request)
    {

        //dd($request->input());

        $data                = array();
        $data['input']       = $request->input();
        $data['name']        = 'Admin';
        $data['email']       = 'info@pephire.com';
        // $data['email']       = 'kurian.benny@quinoid.in';
        $this->sendmail($data, 'Pephire : Contact Us', 'frontend.mail.contactus');

        return response()->json(array('success'=>1));
    }

    private function sendmail($data,$subject,$view)
    {
        Mail::send($view, $data, function($message) use($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
    }


}
