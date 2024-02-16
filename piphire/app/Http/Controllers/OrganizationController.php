<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Plan;
use App\EventLog;
use Carbon\Carbon;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use DB;

class OrganizationController extends Controller
{
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
        parse_str($request->frm, $input);



        $plan = Plan::where('id', 1)->first();
        $plan_end_date = Carbon::now()->addYear($plan->year_count)->addMonths($plan->month_count)->format('Y-m-d');

        $organization = new Organization();

        $organization->ouid         = Uuid::uuid1()->toString();
        $organization->plan_id      = $plan->id;
        $organization->total_search = $plan->no_of_searches;
        $organization->left_search  = $plan->no_of_searches;
        $organization->max_resume_count  = $plan->max_resume_count;
        $organization->name  = $input['name'];
        $organization->email  = $input['email'];
        $organization->plan_end_date = $plan_end_date;
        $organization->save();

        $user                       = new User();
        $user->uuid                 = Uuid::uuid1()->toString();
        $user->name                 = $input['name'];
        $user->email                = $input['email'];
        $user->phone                = $request->phone;
        $user->organization_id      = $organization->id;
        $user->verification_link    = Uuid::uuid1()->toString();
        $user->is_manager           = 1;


        $data               = array();
        $data['name']       = $input['name'];
        $data['email']      = $input['email'];
        $data['inviteurl']  = url('/validate/user/' . $user->verification_link);


        $this->sendmail($data, 'Pephire : Activation', 'frontend.mail.activation');

        $user->save();

        $organization->user_id      = $user->id;
        $organization->update();

        $event_text = $request->name . ' joined in pephire at ' . Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $organization->id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data['success']      = 1;

        return response()->json($data);
    }


    public function successregister()
    {

        return view('success');
    }

    private function sendmail($data, $subject, $view)
    {
        Mail::send($view, $data, function ($message) use ($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
        // if (Mail::failures()) {
        //     echo "not send";
        //     }
    }

    public function enterotp($email, $otp)
    {



        $data               = array();
        $data['name']       = "Sandra";
        $data['email']      = "sandra@sentientscripts.com";
        $data['otp']      = $otp;

        return view('enterotp', compact('otp', 'email'));
    }

    public function clearsessions(Request $request)
    {

        parse_str($request->frm, $input);
        //put random number using rand method
        // $otp = 3487;

        $email = $input['email'];

        $userObj = User::where('email', $email)->first();
        if ($userObj) {
            $otp = rand(1000, 9999);


            $data                = array();

            $data['name']        = 'Admin';

            $data['email'] = $email;

            $data['otp'] = $otp;
            $this->sendmail($data, 'Pephire : Clear Session', 'frontend.mail.clearsession');

            $data['success'] = 1;
            $data['error'] = 0;
        } else {
            $data['success'] = 0;
            $data['error'] = 1;
        }
        $email = base64_encode($email);
        $otp = base64_encode($otp);
        $data['email'] = $email;
        $data['otp'] = $otp;
        return response()->json($data);
    }

    public function verify_otp(Request $request)
    {
        parse_str($request->frm, $input);
        $otp = base64_decode($input['otp']);
        $email= base64_decode($input['email']);
        if ($otp == $input['otp_new']) {
            $user = User::where('email', $email)->first();
            $loggedin_instances = DB::table('sessions')->where('user_id', $user->id)->delete();
            $data['success'] = 1;
            $data['error'] = 0;
        } else {
            $data['success'] = 0;
            $data['error'] = 1;
        }

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activateuseraccount(Request $request)
    {
        //
        $user                   = User::where('verification_link', $request->uid)->first();

        $user->password              = Hash::make($request->password);
        $user->verification_link     = '';
        $user->update();


        return redirect('/validate/user/{uid}')->with('success', 'Your account is activated please login to the system');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $organization = Organization::where('id', auth()->user()->organization_id)->withTrashed()->first();
        $data   = array('header_class' => 'organization', 'organization' => $organization);
        return view('frontend/organization/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $organization = Organization::where('id', auth()->user()->organization_id)->withTrashed()->first();

        $organization->name             = $request->name;
        $organization->email            = $request->email;
        $organization->phone            = $request->phone;
        $organization->address          = $request->address;
        $organization->city             = $request->city;
        $organization->state            = $request->state;
        $organization->zip              = $request->zip;
        $organization->is_verified      = 1;

        /*        if ($request->hasFile('logo')) {
            $path = '';
            Storage::makeDirectory('organization');
            $path = $request->file('logo')->store('organization');
            $organization->company_logo = $path;
        }*/

        $organization->update();

        $event_text = $request->name . ' created by ' . auth()->user()->name . ' at ' . Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $organization->id;
        $event->user_id             = auth()->user()->id;
        $event->event_details       = $event_text;
        $event->save();

        return redirect('/dashboard')->with('success', 'Organization updated successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function editwithplan(Request $request, $puid)
    {
        //
        $organization = Organization::where('id', auth()->user()->organization_id)->withTrashed()->first();
        $data   = array('header_class' => 'organization', 'organization' => $organization);
        return view('frontend/organization/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function updatewithplan(Request $request, $puid)
    {
        //
        $organization = Organization::where('id', auth()->user()->organization_id)->withTrashed()->first();

        $organization->name             = $request->name;
        $organization->email            = $request->email;
        $organization->phone            = $request->phone;
        $organization->address          = $request->address;
        $organization->city             = $request->city;
        $organization->state            = $request->state;
        $organization->zip              = $request->zip;
        $organization->is_verified      = 1;

        /*        if ($request->hasFile('logo')) {
            $path = '';
            Storage::makeDirectory('organization');
            $path = $request->file('logo')->store('organization');
            $organization->company_logo = $path;
        }*/

        $organization->update();

        return redirect('/payment/' . $puid);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(organization $organization)
    {
        //
    }
}
