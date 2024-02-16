<?php

namespace App\Http\Controllers;

use Route;
use Auth;
use DB;
use App\Job;
use App\Skill;
use App\Resume;
use App\Company;
use Carbon\Carbon;
use App\Candidate;
use App\PendingJob;
use App\Organization;
use App\Candidate_Jobs;
use App\Candidateskills;
use Illuminate\Http\Request;
use App\Organizations_Hold_Resume;
use App\ShortlistedCandidate;
use App\InterviewTimeslot;
use App\User;
use Illuminate\Support\Facades\Log;

use App\Plan;
use App\Plantype;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/terms-and-conditions', function () {
    return view('tc');
});

Route::get('/privacy-policy', function () {
    return view('privacypolicy');
});
Route::get('/return-and-refund', function () {
    return view('returnrefund');
});

Route::get('/candidate', 'JobController@candidate');
Route::get('/report', 'JobController@report');


Route::get('/test', 'testController@index');


Route::get('/', function () {

    if (auth()->user()) {

        // return redirect('/dashboard');
        return redirect('/profiledatabase');
    }

    $plans  = Plantype::with(['plans' => function ($q) {
        $q->where('frontend_show', 1);
    }])->where('frontend_show', 1)
        ->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))
        ->get();
    //dd($plans);
    // return view('welcome');
    return view('welcome', compact('plans'));
    #return view('auth/login');
});

Route::get('/drive', function () {
    return view('drive');
});

Route::get('/dropbox', function () {
    return view('dropbox');
});

Auth::routes();

Route::get('/home', 'CandidateController@index')->name('home');

Route::get('/company', function () {

    $data = Organization::get();

    return response()->json($data);
});

Route::get('/applogin', function () {

    $data = User::get();

    return response()->json($data);
});


Route::post('/newMessage', function (Request $request) {



    $data = $request->json()->all();
    $phone = $data['phoneNumber'];

    $message = $data['message'];


    //insert
    $candidate = Candidate::where('phone', $phone)->first();
    if ($candidate->status == '') {
        $candidate->status = 1;
        $candidate->save();
    }

    $post = json_encode(array(
        "candidatePhone" => $phone,
        "message" => $message,
        "oid" => auth()->user()->organization_id,
        "user_id" => auth()->user()->id

    ));

    $ch = curl_init(env('WEBCTRL_URL'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $pythonCall = curl_exec($ch);

    $time = Carbon::now();
    curl_close($ch);
    if ($pythonCall != 'failure') {

        $phone = str_replace('+', '', $phone);
        $phone = str_replace(' ', '', $phone);
        if (strlen($phone) > 10) {
            $phone = $phone;
        } else {
            $phone = '91' . $phone;
        }

        $newdata = DB::connection('pephire_trans')
            ->table('conversation_details_v2')
            ->where('candidatePhone', $phone)
            ->where('organization_id', auth()->user()->organization_id)
            ->get();
        return response()->json($newdata);
    }
});




Route::post('/MSG', function (Request $request) {


    $data = $request->json()->all();
    $phone = $data['phoneNumber'];
    $phone = str_replace('+', '', $phone);
    $phone = str_replace(' ', '', $phone);
    if (strlen($phone) > 10) {
        $phone = $phone;
    } else {
        $phone = '91' . $phone;
    }
    $refreshdata = DB::connection('pephire_trans')
        ->table('conversation_details_v2')
        ->where('candidatePhone', $phone)
        ->where('organization_id', auth()->user()->organization_id)->get();
    return response()->json($refreshdata);
});
/*
|--------------------------------------------------------------------------
| Administration Routes
|--------------------------------------------------------------------------
|
| The routes associated with super admin goes here.
|
*/
require_once "admin.php";


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| The routes associated with frontend goes here.
|
*/
require_once "frontend.php";
require_once "pephireapp.php";
