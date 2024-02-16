<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use App\Candidate;
use App\ShortlistedCandidate;
use App\InterviewTimeslot;
use App\InterviewTimeslotTrans;
use Ahc\Jwt\JWT;
use GuzzleHttp\Client;
use App\ShortListedCandidatesTrans;
use App\Candidate_Jobs;
use App\InterviewerDetails;
use App\Job;
use Mail;

use Google_Client, Google_Service_Calendar, Google_Service_Calendar_Event, Google_Service_Exception;

class InterviewConfirmationController extends Controller
{
    public function index()
    {

        $links = \DB::table('candidate_interview_links')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($links as $key => $link) {
            echo $key + 1 . ") " . $link->webLink . '<br/><a href="' . $link->webLink . '" target="_blank">Open in new tab</a>';
            echo "<br/><br/>";
        }
    }

    public function candidate_timeslots(Request $request, $cid)
    {
        $cid = '0c1e1a78-5d01-11ee-94cb-000d3af17cb8';
        $candidates = Candidate::where('cuid', $cid)->first();
        $candidate_jobs = Candidate_Jobs::where('candidate_id', $candidates->id)->where('shortlist','1')->first();
        $job = Job::where('id', $candidate_jobs->job_id)->first();

        return view('candidate_timeslots', compact('job', 'candidates'));
    }
    public function storeCandidateTimeslot(Request $request, $cid)
    {
        Log::error($request.'ooooooooooooooooooooooooooooooooo');

$text = $request->selectedDateTimes;

// Split the text into date and time segments using regular expressions
$date_time_segments = preg_split("/~|\|/", $text);

// Initialize an empty array to store the dictionaries
$resultArray = [];

// Define a function to extract date and time and format the entry as a dictionary
function format_date_and_time($segment) {
    // Use regular expressions to extract date and time
    if (preg_match("/(\d+ [A-Za-z]+ \d+)-(\d+:\d+ [APap][Mm])/", $segment, $matches)) {
        $date = $matches[1];
        $time = $matches[2];
        return ["date" => $date, "time" => $time];
    } elseif (preg_match("/(\d+:\d+ [APap][Mm])/", $segment, $matches)) {
        // If no date is found, use a default date (e.g., today's date)
        $date = date("d M y");
        $time = $matches[1];
        return ["date" => $date, "time" => $time];
    }
    return null;
}
$job = Job::where('id', $request->job_id)->first();

// Extract and format the date and time for each segment
foreach ($date_time_segments as $segment) {
    $formatted_entry = format_date_and_time($segment);
    if ($formatted_entry !== null) {
        $resultArray= $formatted_entry;
        $time = strtotime($formatted_entry['time']);
        $startTime = strtotime($formatted_entry['date'] . ' ' . $formatted_entry['time']);
        $endTime=   $startTime+3600;
    }
    Log::error($startTime .'------------------'.$endTime );

    $timestamp = strtotime($formatted_entry['date']);

    // Convert the Unix timestamp to the yyyy-mm-dd format
    $formatted_date = date('Y-m-d', $timestamp);
    
$details = InterviewerDetails::where('job_id', $request->job_id)->first();
    $timeslot = new InterviewTimeslot();
    $timeslot->job_id = Job::where('id', $request->job_id)->first()->id;
    $timeslot->user_id = $request->user_id;

    //take details from interviewer details 

    $timeslot->interviewer_name = trim($details->interviewer_name);
    $timeslot->email = $details->email;
    $timeslot->contact_number = $details->contact_number;
    $timeslot->interview_date = $formatted_date;
    $timeslot->interview_start_time =date('Y-m-d H:i:s', $startTime);
    $timeslot->interview_end_time = date('Y-m-d H:i:s',$endTime);
    // $timeslot->meeting_details = trim($request->meeting_details);
    $timeslot->save();

    $timeslot2 = new InterviewTimeslotTrans();
    $timeslot2->job_id =  Job::where('id', $request->job_id)->first()->id;
    $timeslot2->user_id = $request->user_id;
    $timeslot2->interviewer_name = trim($details->interviewer_name);
    $timeslot2->email = $details->email;
    $timeslot2->contact_number = $details->contact_number;
    $timeslot2->interview_date = $formatted_date;
    $timeslot2->interview_start_time =date('Y-m-d H:i:s',$startTime);
    $timeslot2->interview_end_time = date('Y-m-d H:i:s',$endTime);
    // $timeslot2->meeting_details = trim($request->meeting_details);
    $timeslot2->oid = $request->organization_id;
    $timeslot2->interview_id = $timeslot->id;
    $timeslot2->save();

    $timeslot->reference_id = $timeslot2->id;
    $timeslot->save();


    
 
}
$candidates = Candidate::where('cuid', $cid)->first();

$candidate_stages = DB::connection('pephire')
->table('interview_comment')
->insert([
    'job_id' => Job::where('id', $request->job_id)->first()->id,
    'candidate_id' => $candidates->id,
    'interviewer_id' => $details->id,
    'user_id' => $request->user_id,
    'organization_id' => $request->organization_id,
    'comment'=>$request->comment,
    'source' => 'candidate',
]);


        // Log::info(print_r($resultArray,true));
        return response()->json(['status' => true, 'redirect_url' => route('interview.thankYou')]);
    }
    public function scheduledCSV()
    {
        $fetch = InterviewTimeslot::where('hasAllotted', 1)->first();
        $candidates = Candidate::where('id', $fetch->allotted_candidate_id)->first();


        $interviewersArr = InterviewTimeslot::distinct('interviewer_name')->pluck('interviewer_name')->toArray();

        if ($s_date = InterviewTimeslot::where('hasAllotted', 1)->orderBy('interview_date', 'asc')->first()) {
            $sel_startdate = $startdate = $s_date->interview_date;
        } else {
            $sel_startdate = $startdate = '2020-01-01';
        }

        if ($s_date = InterviewTimeslot::where('hasAllotted', 1)->orderBy('interview_date', 'desc')->first()) {
            $sel_enddate = $enddate = $s_date->interview_date;
        } else {
            $sel_enddate = $enddate = '2020-01-01';
        }

        $sel_starttime = 0;
        $sel_endtime = 1440;

        $fileName = 'scheduled.csv';



        $fetch = InterviewTimeslot::where('hasAllotted', 1)->first();
        $candidates = Candidate::where('id', $fetch->allotted_candidate_id)->first();

        $timeslots = InterviewTimeslot::where('hasAllotted', 1)
            ->orderBy('interview_date', 'ASC')
            ->orderBy('interview_start_time', 'ASC')
            ->get();


        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('JDID', 'Interviewer Name', 'Date', 'Start Time', 'Candidate', 'Experience');

        $callback = function () use ($timeslots, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($timeslots as $time) {

                $cand = Candidate::where('id', $time->allotted_candidate_id)->first();
                $row['JDID']  = $time->job_id;
                $row['Interviewer Name']    =  $time->interviewer_name;
                $row['Date']    = $time->interview_date;
                $row['Start Time']    = date("g:i A", $time->interview_start_time);
                $row['Candidate']  = $cand->name;
                $row['Experience']  = $cand->experience;
                fputcsv($file, array($row['JDID'], $row['Interviewer Name'], $row['Date'], $row['Start Time'], $row['Candidate'], $row['Experience']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function viewCandidateTimeslot($sluid)
    {
        $short_listed = ShortlistedCandidate::where('sluid', $sluid)->first();
        if ($short_listed) {
            $alreadySubmittedCount = InterviewTimeslot::where('job_id', $short_listed->job_id)->where('allotted_candidate_id', $short_listed->candidate_id)->count();
            if ($alreadySubmittedCount > 0) {
                $errorMsg = "You have already submitted your preferred time slot !";
                return view('frontend.interview_error', compact('errorMsg'));
            }
            Log::error($alreadySubmittedCount);
            $timeslots = InterviewTimeslot::where('job_id', $short_listed->job_id)
                ->where('hasAllotted', 0)
                ->orderBy('interview_date', 'ASC')
                ->orderBy('interview_start_time', 'ASC')
                ->get()
                ->groupBy(['interview_date', 'interviewer_name']);

            return view('frontend.interview_candidateTimeslot', compact('sluid', 'timeslots'));
        } else {
            $errorMsg = "Invalid Interview Request ID !";
            return view('frontend.interview_error', compact('errorMsg'));
        }
    }



    public function updateCandidateTimeslot(Request $request, $sluid)
    {

        $time = strtotime($request->timeslot);
        $short_list = ShortlistedCandidate::where('sluid', $sluid)->first();

        $short_list->timeslot = $time;
        $short_list->update();

        $short_listed = ShortlistedCandidate::where('sluid', $sluid)->first();


        if ($short_listed) {
            $timeslot = InterviewTimeslot::find($request->timeslot);
            $timeslottt = InterviewTimeslotTrans::where('id', $timeslot->reference_id)->first();

            $short_list = ShortlistedCandidate::where('sluid', $sluid)->first();

            $short_list->timeslot = $timeslot->interview_start_time;
            $short_list->timeslot_end = $timeslot->interview_end_time;
            $short_list->update();

            $timeslot->allotted_candidate_id = $short_list->candidate_id;


            $timeslot->update();

            $timeslottt->allotted_candidate_id = $short_list->candidate_id;


            $timeslottt->update();

            $short_listtrans = ShortlistedCandidatesTrans::where('sid', $short_list->id)->first();

            $short_listtrans->timeslot = date("Y-m-d H:i:s.u", $timeslot->interview_start_time);
            $short_listtrans->timeslot_end = date("Y-m-d H:i:s.u", $timeslot->interview_end_time);
            $short_listtrans->update();



            if ($timeslot->hasAllotted == 1) {
                log::error('hiiiii this is  allotted');
                return response()->json(['status' => false]);
            }

            $timeslot->hasAllotted = 1;

            $timeslot->update();

            $external_candidate_profile_links = DB::connection('pephire_trans')
                ->table('link_verification_status')
                ->where('Phone', $short_listed->candidate->phone)
                ->where('QnID', 'InterviewLink')
                ->update(['link_status' => 1]);

            $phone = str_replace('+', '', $short_listed->candidate->phone);
            $phone = str_replace(' ', '', $phone);
            if (strlen($phone) > 10) {
                $phone = $phone;
            } else {
                $phone = '91' . $phone;
            }

            $personalization_parameters_date = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' => $phone,
                'usertype' => "candidate",
                'Parameters' => 'Date',
                'ParameterValue' => $timeslot->interview_date,
                'oid' => $short_listed->candidate->organization_id,


            ]);



            $contact_number = str_replace('+', '', $timeslot->contact_number);
            $contact_number = str_replace(' ', '', $contact_number);
            if (strlen($phone) > 10) {
                $contact_number = $contact_number;
            } else {
                $contact_number = '91' . $contact_number;
            }

            $personalization_parameters_time = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' => $contact_number,
                'usertype' => "interviewer",
                'Parameters' => 'InterviewTime',
                'ParameterValue' => date("H:i:s", $timeslot->interview_start_time),
                'oid' => $short_listed->candidate->organization_id,
            ]);

            $personalization_parameters_time = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' => $phone,
                'usertype' => "candidate",
                'Parameters' => 'Time',
                'ParameterValue' => date("H:i:s", $timeslot->interview_start_time),
                'oid' => $short_listed->candidate->organization_id,
            ]);
            $time = date("Y-m-d H:i:s.u", $timeslot->interview_start_time);
            $personalization_parameters_email = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' => $phone,
                'usertype' => "candidate",
                'Parameters' => 'Email',
                'ParameterValue' => $short_listed->candidate->email,
                'oid' => $short_listed->candidate->organization_id,
            ]);


            $data = array();
            $data['candidate_email'] = $short_listed->candidate->email;
            $data['candidate_name'] = $short_listed->candidate->name;
            $data['candidate_phone'] = $short_listed->candidate->phone;
            $data['oid'] = $short_listed->candidate->organization_id;
            $data['job_title'] = $short_listed->job->name;
            $data['hr_name'] = $short_listed->candidate->user->name;
            $data['hr_email'] = $short_listed->candidate->user->email;
            $data['interviewer_email'] = $timeslot->email;
            $data['interview_start_time'] = $timeslot->interview_start_time;
            $data['interview_end_time'] = $timeslot->interview_end_time;
            $data['meeting_details'] = $timeslot->meeting_details;

            // Uncomment this when the google calendar is working!
            $this->handleGoogleCalender($data);

            return response()->json(['status' => true, 'redirect_url' => route('interview.thankYou')]);
            // return view('frontend.interview_thankyou',compact('data') );

        }
    }



    public function handleGoogleCalender($data)
    {
        $start_time = \Carbon\Carbon::parse((int)$data['interview_start_time'])->format('Y-m-d H:i:s');
        $end_time = \Carbon\Carbon::parse((int)$data['interview_end_time'])->format('Y-m-d H:i:s');

        $start_time = str_replace(" ", "T", $start_time);
        $end_time = str_replace(" ", "T", $end_time);

        // Instantiate with API secret, algo, maxAge and leeway.
        $jwt = new JWT('qyQggjxdlegCMMxAkLpjG106ylrNU6ElODpt', 'HS256', 3600, 10);
        // $token   = (new JWT('topSecret', 'HS512', 1800))->encode(['uid' => 1, 'scopes' => ['user']]));
        $token = $jwt->encode([
            'iss'    => 'afahBK6SSLCmQvsiwhKpvw', // API key
            'exp'    => time() + 5 * 60 // 5 minutes * 60 seconds/minute
        ]);

        // ZOOM API starts
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];

            $rawContent = [
                'topic' => 'Interview Invite | PepHire',
                'type' => 2,
                'start_time' => $start_time,
                'agenda' => 'Custom Zoom meeting for Interview Invite',
                'settings' => [
                    'approval_type' => 0,
                ],
            ];

            $client = new client();
            $response = $client->post('https://api.zoom.us/v2/users/johnzacharia.sics@gmail.com/meetings', [
                'headers' => $headers,
                'json' => $rawContent,
            ]);

            $responseArr = json_decode($response->getBody()->getContents(), TRUE);
            $join_url = $responseArr['join_url'];
            $password = $responseArr['password'];

            $personalization_parameters_link = DB::connection('pephire_trans')->table('personalization_parameters_v2')->insert([
                'Phone' =>  $data['candidate_phone'],
                'usertype' => "candidate",
                'Parameters' => 'Link',
                'ParameterValue' => $join_url,
                'oid' => $data['oid']
            ]);

            try {

                $client = new Google_Client();
                $client->setApplicationName("Google Calendar PepHire API");
                $client->setAuthConfig(config('googlecalendar')['key']);
                $client->setScopes(config('googlecalendar')['scopes']);
                $client->setSubject(config('googlecalendar')['impersonatedUser']);
                $service = new Google_Service_Calendar($client);

                $contents = '<strong>Zoom Meeting Link</strong>: <a href="' . $join_url . '">Join with Zoom</a><br/><strong>Password</strong>: ' . $password . '<br/><br/>' . $data["meeting_details"] . '<br/><br/>Good Day ' . $data["candidate_name"] . ', <br/>This time is being scheduled for conducting interview for  position of ' . $data["job_title"] . ' present at our organization. <br/><br/>Details on Mode of Interview and Link for interview will be updated in this invite once accepted. <br/><br/>Wishing you the very best. <br/><br/>Regards,<br/>' . $data["hr_name"];

                $event = new Google_Service_Calendar_Event(array(
                    'summary' => 'Interview Invite | PepHire',
                    'description' => $contents,
                    'start' => array(
                        'dateTime' => $start_time,
                        'timeZone' => config('googlecalendar')['timeZone'],
                    ),
                    'end' => array(
                        'dateTime' => $end_time,
                        'timeZone' => config('googlecalendar')['timeZone'],
                    ),
                    'attendees' => array(
                        array('email' => $data['candidate_email']),
                        array('email' => $data['hr_email']),
                        array('email' => $data['interviewer_email']),
                    ),
                    'reminders' => array(
                        'useDefault' => FALSE,
                        'overrides' => array(
                            array('method' => 'email', 'minutes' => 24 * 60),
                            array('method' => 'popup', 'minutes' => 60),
                        ),
                    ),
                ));

                $calendarId = config('googlecalendar')['calendarId'];
                $opts = array('sendUpdates' => 'all', 'conferenceDataVersion' => true); // send Notification immediately by Mail & Stop Hangout Call Link
                $event = $service->events->insert($calendarId, $event, $opts);
            } catch (Google_Service_Exception $e) {
            }
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            // $raw_response = explode("\n", $e->getResponse());
            // throw new IDPException(end($raw_response));
            Log::error("Error at zoom" . $e);
        }
    }
  
}
