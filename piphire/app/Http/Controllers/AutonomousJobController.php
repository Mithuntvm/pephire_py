<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Job;
use App\InterviewerDetails;
use App\InterviewTimeslot;
use App\InterviewTimeslotTrans;
use App\BulkJob;
use App\Organization;
use App\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DB;
use DateTime;
use Illuminate\Support\Facades\Log;

use Mail;


class AutonomousJobController extends Controller
{

    private function sendmail($data, $subject, $view)
    {
        Mail::send($view, $data, function ($message) use ($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
    }


    public function update_automate(Request $request)
    {
        $auto_j = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();

        if ($request->location == 'gdrive' && $auto_j->location != 'gdrive') {
            $post = json_encode(array(
                "FolderName" => 'hiii'

            ));
            $ch = curl_init("http://127.0.0.1:1234/");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            // execute!
            $pythonCall = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);


            $result = $pythonCall;
            // Log::error($pythonCall);


            $data                = array();
            $data['input']       = 'hiii';
            $data['name']        = 'Admin';

            $data['email'] = "sandra@sentientscripts.com";
            $this->sendmail($data, 'Pephire : Google Drive Upload', 'frontend.mail.gdrive_upload');
        } else {
            $pythonCall = $auto_j->Path;
        }
        if ($request->location == 'ftp') {
            $job = DB::connection('pephire_auto')
                ->table('autonomous_job_file_master')
                ->where('uid', auth()->user()->id)
                ->update([

                    'location' => $request->location,
                    'ADLS_StorageAccountKey' => '',
                    'ADLS_ContainerName' => '',
                    'ADLS_StorageAccountName' => '',
                    'FTP_Hostname' => $request->ftp_name,
                    'FTP_Username' => $request->ftp_username,
                    'FTP_Password' => $request->ftp_password,
                    'Path' => $request->path,
                    'filename' => $request->filename,
                    'oid' => auth()->user()->organization_id,
                    'uid' => auth()->user()->id
                ]);
        } elseif ($request->location == 'adls') {


            $auto_job = DB::connection('pephire_auto')
                ->table('autonomous_job_file_master')
                ->where('uid', auth()->user()->id)
                ->first();

            $job = DB::connection('pephire_auto')
                ->table('autonomous_job_file_master')
                ->where('uid', auth()->user()->id)
                ->update([

                    'location' => $request->location,
                    'ADLS_StorageAccountKey' => $request->adls_key,
                    'ADLS_ContainerName' => $request->adls_contname,
                    'ADLS_StorageAccountName' => $request->adls_accname,
                    'FTP_Hostname' => '',
                    'FTP_Username' => '',
                    'FTP_Password' => '',
                    'Path' => $request->path,
                    'filename' => $request->filename,
                    'oid' => auth()->user()->organization_id,
                    'uid' => auth()->user()->id
                ]);
        } else if ($request->location == 'gdrive') {
            $job = DB::connection('pephire_auto')
                ->table('autonomous_job_file_master')
                ->where('uid', auth()->user()->id)
                ->update([

                    'location' => $request->location,
                    'ADLS_StorageAccountKey' => '',
                    'ADLS_ContainerName' => '',
                    'ADLS_StorageAccountName' => '',
                    'FTP_Hostname' => '',
                    'FTP_Username' => '',
                    'FTP_Password' => '',
                    'Path' => $pythonCall,
                    'filename' => '',
                    'oid' => auth()->user()->organization_id,
                    'uid' => auth()->user()->id
                ]);
        }
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();

        if ($request->frequency == 'Hourly') {
            $hour = '';
            $week = '';
            $date = '';
        }
        if ($request->frequency == 'Daily') {
            $hour = $request->hour;
            $week = '';
            $date = '';
        }
        if ($request->frequency == 'Monthly') {
            $hour = $request->hour;
            $week = '';
            $date = $request->month;
        }
        if ($request->frequency == 'Weekly') {
            $hour = $request->hour;
            $week = $request->week;
            $date = '';
        }
        if ($request->frequency == 'Once') {
            $hour = '';
            $week = '';
            $date = '';
        }

        Log::error($request->whatsapp . 'whatsappwhatsappwhatsapp');
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->update([

                'job_file_id' => $auto_job->id,
                'oid' => auth()->user()->organization_id,
                'uid' => auth()->user()->id,
                'frequency' => $request->frequency,
                'hour' => $hour,
                'weekday' => $week,
                'date' => $date,
                'whatsapp' => $request->whatsapp


            ]);
        return back();
    }
    public function autonomusJob(Request $request)
    {
        $auto_j = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();

        if ($request->location == 'gdrive' && $auto_j->location != 'gdrive') {
            $post = json_encode(array(
                "FolderName" => 'hiii'

            ));
            $ch = curl_init("http://127.0.0.1:1234/");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            // execute!
            $pythonCall = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);


            $result = $pythonCall;

            $data                = array();
            $data['input']       = 'hiii';
            $data['name']        = 'Admin';

            $data['email'] = "sandra@sentientscripts.com";
            $this->sendmail($data, 'Pephire : Google Drive Upload', 'frontend.mail.gdrive_upload');
        }
        if ($request->location == 'ftp' || $request->location == 'adls') {
            $pythonCall = $request->path;
        }

        $job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->insert([

                'location' => $request->location,
                'ADLS_StorageAccountKey' => $request->adls_key,
                'ADLS_ContainerName' => $request->adls_contname,
                'ADLS_StorageAccountName' => $request->adls_accname,
                'FTP_Hostname' => $request->ftp_name,
                'FTP_Username' => $request->ftp_username,
                'FTP_Password' => $request->ftp_password,
                'Path' => $pythonCall,
                'filename' => $request->filename,
                'oid' => auth()->user()->organization_id,
                'uid' => auth()->user()->id
            ]);
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();

        if ($request->frequency == 'Hourly') {
            $hour = '';
            $week = '';
            $date = '';
        }
        if ($request->frequency == 'Daily') {
            $hour = $request->hour;
            $week = '';
            $date = '';
        }
        if ($request->frequency == 'Monthly') {
            $hour = $request->hour;
            $week = '';
            $date = $request->month;
        }
        if ($request->frequency == 'Weekly') {
            $hour = $request->hour;
            $week = $request->week;
            $date = '';
        }
        if ($request->frequency == 'Once') {
            $hour = '';
            $week = '';
            $date = '';
        }



        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->insert([

                'job_file_id' => $auto_job->id,
                'oid' => auth()->user()->organization_id,
                'uid' => auth()->user()->id,
                'frequency' => $request->frequency,
                'hour' => $hour,
                'weekday' => $week,
                'date' => $date,
                'whatsapp' => $request->whatsapp

            ]);
        return back();
    }

    public function updateInterview(Request $request)
    {
        $phone = $request->payload;
        $job_arr = $request->payload;


        foreach ($job_arr as $item) {
            $contact_phone = $item['contact'];
            $contact_phone = str_replace("+", "", $contact_phone);
            $contact_phone = str_replace(" ", "", $contact_phone);
            $contact_phone = str_replace("-", "", $contact_phone);
            if ($item['duration'] == '30 Minutes') {
                $duration = 30;
            }
            if ($item['duration'] == '1 hour') {
                $duration = 60;
            }
            if ($item['duration'] == '1 hour 30 minutes') {
                $duration = 90;
            }
            if ($item['duration'] == '2hour') {
                $duration = 120;
            }

            $addMins  = 60 * (int)$duration;

            $start_date = $item['start_date'];

            $end_date = $item['end_date'];



            $current_date = $start_date;

            while ($current_date <= $end_date) {

                // echo $current_date . "\n";
                Log::error( $current_date);

            
            $startTime = strtotime($item['start_date'] . ' ' . $item['start_time']);
            $endTime = strtotime($item['start_date'] . ' ' . $item['end_time']);
            $loop = 1;
            while ($startTime < $endTime) {
                $timeslot = new InterviewTimeslot();
                $timeslot->job_id = '2037';
                $timeslot->user_id = auth()->user()->id;
                $timeslot->interviewer_name = $item['int_name'];
                $timeslot->email = $item['email'];
                $timeslot->contact_number = $contact_phone;
                $timeslot->interview_date = $current_date;
                $timeslot->interview_start_time = $startTime;
                $timeslot->interview_end_time = $endTime;
                $timeslot->meeting_details = $item['details'];
                $timeslot->save();


                $timeslot2 = new InterviewTimeslotTrans();
                $timeslot2->job_id = '2037';
                $timeslot2->user_id = auth()->id();
                $timeslot2->interviewer_name = $item['int_name'];
                $timeslot2->email = $item['email'];
                $timeslot2->contact_number = $contact_phone;
                $timeslot2->interview_date = $current_date;
                $timeslot2->interview_start_time = $startTime;
                $timeslot2->interview_end_time = $endTime;
                $timeslot2->meeting_details = $item['details'];
                $timeslot2->oid = auth()->user()->organization_id;
                $timeslot2->interview_id = $timeslot->id;
                $timeslot2->save();

                $timeslot->reference_id = $timeslot2->id;
                $timeslot->save();

                $interview_details = new InterviewerDetails();
                $interview_details->job_id = '2037';
                $interview_details->user_id = auth()->user()->id;
                $interview_details->interviewer_name = $item['int_name'];
                $interview_details->email = $item['email'];
                $interview_details->contact_number = $item['contact'];
                $interview_details->oid = auth()->user()->organization_id;
                $interview_details->interview_id = $timeslot->id;
                $interview_details->interview_trans_id = $timeslot2->id;
                $interview_details->save();


                $startTime += $addMins;
                $loop++;
            }
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

        }
        }

        $data['status'] = true;
        return response()->json($data);
    }
}
