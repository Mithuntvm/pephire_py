<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Pending_Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;
class PendingCandidateController extends Controller
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
        //
        $email = $request->email;
        $exist = Pending_Candidate::where('email',$email)->first();

        $otp   = mt_rand(1000,9999);

        if($exist){

            $exist->name = $request->name;
            $exist->phone = $request->phone;
            $exist->location = $request->job_location;
            $exist->otp = $otp;
            $exist->update();

            $userid = $exist->id;

            $maildata               = array();
            $maildata['name']       = $request->name;
            $maildata['email']      = $request->email;
            $maildata['otp'] = $otp;
            $this->sendmail($maildata, 'Pephire : User Verification OTP', 'frontend.mail.otp');

        }else{

            $canObj = new Pending_Candidate();

            $canObj->name = $request->name;
            $canObj->email = $request->email;
            $canObj->phone = $request->phone;
            $canObj->location = $request->job_location;
            $canObj->otp = $otp;
            $canObj->save();

            $userid = $canObj->id;

            $maildata               = array();
            $maildata['name']       = $request->name;
            $maildata['email']      = $request->email;
            $maildata['otp']        = $otp;
            $this->sendmail($maildata, 'Pephire : User Verification OTP', 'frontend.mail.otp');

        }


        $data = array();
        $data['success'] = 1;
        $data['userid'] = $userid;
        return response()->json($data);


    }

    private function sendmail($data,$subject,$view)
    {
        Mail::send($view, $data, function($message) use($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
    }

    public function verifyotp(Request $request)
    {
        $otp = $request->otp_code;
        $userid = $request->pendingid;

        $userdets = Pending_Candidate::where('id',$userid)->where('otp',$otp)->first();

        if($userdets){

            $data = array();
            $data['success'] = 1;
            return response()->json($data);
        }else{

            $data = array();
            $data['error'] = 1;
            return response()->json($data);
        }
    }

    public function resentotp(Request $request)
    {
        $userid = $request->userid;

        $userdets = Pending_Candidate::where('id',$userid)->first();

        if($userdets){

            $otp   = mt_rand(1000,9999);
            $userdets->otp = $otp;
            $userdets->update();

            $maildata               = array();
            $maildata['name']       = $userdets->name;
            $maildata['email']      = $userdets->email;
            $maildata['otp']        = $otp;
            $this->sendmail($maildata, 'Pephire : User Verification OTP', 'frontend.mail.otp');
            
            $data = array();
            $data['success'] = 1;
            return response()->json($data);
        }else{
            $data = array();
            $data['otperrror'] = 1;
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pending_Candidate  $pending_Candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Pending_Candidate $pending_Candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pending_Candidate  $pending_Candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Pending_Candidate $pending_Candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pending_Candidate  $pending_Candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pending_Candidate $pending_Candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pending_Candidate  $pending_Candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pending_Candidate $pending_Candidate)
    {
        //
    }
}
