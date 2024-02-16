<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/pepapplogin', function (Request $request) {
    Log::error($request);
    $logon = DB::connection('pephireapp')
        ->table('students')
        ->where('students.phone', $request->username)
        ->where('students.password', $request->password)
        ->get();
    return response()->json($logon);
});
Route::get('/companies', function (Request $request) {
    $newdata = DB::connection('pephireapp')
        ->table('companies')
        ->get();
    return response()->json($newdata);
});
Route::get('/appjobs', function (Request $request) {



    $registeredjobsvalue[0] = 0;

    $registeredjob = DB::connection('pephireapp')

        ->table('jobtostudent')

        ->select(DB::raw('Group_Concat(jobid) as jobid'))

        ->where('studentid', $request->studentid)

        ->groupBy('studentid')

        ->get();

    if ($registeredjob != "[]") {

        Log::error($registeredjob);

        $registeredjobsvalue = explode(',', $registeredjob[0]->jobid);
    }

    //return response()->json($registeredjob);



    $newdata = DB::connection('pephireapp')

        ->table('jobs')

        ->select('jobs.id as jobid', 'jobs.jobname', 'jobs.description as jobdescription', 'company_name', 'company_details', 'company_logo', 'companies.id as id', 'jobs.created_at', 'jobs.jobimage')

        ->join('companies', 'jobs.company_id', '=', 'companies.id')

        ->join('jobtocollege', 'jobtocollege.jobid', '=', 'jobs.id')

        ->where('jobtocollege.collegeid', $request->collegeid)

        ->whereNotIn('jobtocollege.jobid', $registeredjobsvalue)

        ->get();

    foreach ($newdata as $data) {

        //print_r($data);

        $datetime = $data->created_at;



        $now = new DateTime();

        $ago = new DateTime($datetime);

        $interval = $now->diff($ago);



        if ($interval->y >= 1) {

            $data->created_at = $interval->y == 1 ? $interval->y . " year ago" : $interval->y . " years ago";
        } elseif ($interval->m >= 1) {

            $data->created_at = $interval->m == 1 ? $interval->m . " month ago" : $interval->m . " months ago";
        } elseif ($interval->d >= 1) {

            $data->created_at = $interval->d == 1 ? $interval->d . " day ago" : $interval->d . " days ago";
        } elseif ($interval->h >= 1) {

            $data->created_at = $interval->h == 1 ? $interval->h . " hour ago" : $interval->h . " hours ago";
        } elseif ($interval->i >= 1) {

            $data->created_at = $interval->i == 1 ? $interval->i . " minute ago" : $interval->i . " minutes ago";
        } else {

            $data->created_at = "Just now";
        }
    }

    return response()->json($newdata);
});

Route::get('/appappliedjobs', function (Request $request) {



    $registeredjobsvalue[0] = 0;

    $registeredjob = DB::connection('pephireapp')

        ->table('jobtostudent')

        ->select(DB::raw('Group_Concat(jobid) as jobid'))

        ->where('studentid', $request->studentid)

        ->groupBy('studentid')

        ->get();

    if ($registeredjob != "[]") {

        Log::error($registeredjob);

        $registeredjobsvalue = explode(',', $registeredjob[0]->jobid);
    }

    //return response()->json($registeredjob);



    $newdata = DB::connection('pephireapp')

        ->table('jobs')

        ->select('jobs.id as jobid', 'jobs.jobname', 'jobs.description as jobdescription', 'company_name', 'company_details', 'company_logo', 'companies.id as id', 'jobtostudent.created_at', 'jobs.jobimage')

        ->join('companies', function ($join) {

            $join->on('jobs.company_id', '=', 'companies.id');
        })

        ->join('jobtocollege', function ($join) {

            $join->on('jobtocollege.jobid', '=', 'jobs.id');
        })

        ->join('jobtostudent', function ($join) {

            $join->on('jobtostudent.jobid', '=', 'jobs.id');
        })

        ->where('jobtostudent.studentid', $request->studentid)

        ->where('jobtocollege.collegeid', $request->collegeid)

        ->whereIn('jobtocollege.jobid', $registeredjobsvalue)
        ->orderBy('created_at', 'desc')

        ->get();

    foreach ($newdata as $data) {

        //print_r($data);

        $datetime = $data->created_at;



        $now = new DateTime();

        $ago = new DateTime($datetime);

        $interval = $now->diff($ago);



        if ($interval->y >= 1) {

            $data->created_at = $interval->y == 1 ? $interval->y . " year ago" : $interval->y . " years ago";
        } elseif ($interval->m >= 1) {

            $data->created_at = $interval->m == 1 ? $interval->m . " month ago" : $interval->m . " months ago";
        } elseif ($interval->d >= 1) {

            $data->created_at = $interval->d == 1 ? $interval->d . " day ago" : $interval->d . " days ago";
        } elseif ($interval->h >= 1) {

            $data->created_at = $interval->h == 1 ? $interval->h . " hour ago" : $interval->h . " hours ago";
        } elseif ($interval->i >= 1) {

            $data->created_at = $interval->i == 1 ? $interval->i . " minute ago" : $interval->i . " minutes ago";
        } else {

            $data->created_at = "Just now";
        }
    }

    return response()->json($newdata);
});

Route::get('/registerjob', function (Request $request) {

    $registercandidate = DB::connection('pephireapp')

        ->table('jobtostudent')

        ->insert([

            'jobid' => $request->jobid,

            'studentid' => $request->studentid,

            'collegeid' => $request->collegeid,

        ]);

    return response()->json($registercandidate);
});
Route::get('/studentdetail', function (Request $request) {

    Log::error($request);

    $studentdetail = DB::connection('pephireapp')

        ->table('students')

        ->where('students.id', $request->studentid)

        ->get();

    return response()->json($studentdetail);
});
Route::get('/appprofileimages/{filename}', function ($filename) {

    $path = 'file:///E:/Pephire_resumes/storage/app/appprofileimages/' . $filename;
    //echo $path;


    //Log:error($path);

    if (!File::exists($path)) {

        abort(404);
        //echo 405;
    }



    $file = File::get($path);

    $type = File::mimeType($path);



    $response = Response::make($file, 200);

    $response->header('Content-Type', $type);



    return $response;
});

Route::get('/appcompanylogos/{filename}', function ($filename) {

    $path = 'file:///E:/Pephire_resumes/storage/app/appcompanylogos/' . $filename;
    //echo $path;


    //Log:error($path);

    if (!File::exists($path)) {

        abort(404);
        //echo 405;
    }



    $file = File::get($path);

    $type = File::mimeType($path);



    $response = Response::make($file, 200);

    $response->header('Content-Type', $type);



    return $response;
});

Route::get('/showprofiles/{filename}', function ($filename) {

    $aid=auth()->user()->organization_id;
    $path = "file:///E:/Pephire_resumes/storage/app/profileimages/{$aid}/{$filename}";
    //echo $path;


    //Log:error($path);

    if (!File::exists($path)) {
        abort(404);
        //echo 405;
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);

    return $response;
});

Route::get('/allskills', function (Request $request) {

    //Log::error($request);

    $skills = DB::connection('pephire')

        ->table('skill_master')

        ->select('name as skillname')

        ->get();

    return response()->json($skills);
});

Route::get('/buildings', function (Request $request) {

    //Log::error($request);

    $buildings = DB::connection('pephireapp')

        ->table('buildings')

        ->select('building_name as name','building_color as color','id',DB::raw('"floors" as type'),DB::raw('"buildings.png" as icon'))

        ->get();

    return response()->json($buildings);
});

Route::get('/floors', function (Request $request) {

    //Log::error($request);

    $floors = DB::connection('pephireapp')

        ->table('floors')

        ->select('floor_name as name','floor_color as color','id',DB::raw('"rooms" as type'),DB::raw('"Floors.png" as icon'))
        ->where('building_id', $request->loaderid)
        ->get();

    return response()->json($floors);
});

Route::get('/rooms', function (Request $request) {

    //Log::error($request);

    $rooms = DB::connection('pephireapp')

        ->table('rooms')

        ->select('room_name as name','room_color as color','id',DB::raw('"cameras" as type'),DB::raw('"rooms.png" as icon'))
        ->where('floor_id', $request->loaderid)
        ->get();

    return response()->json($rooms);
});

Route::get('/cameras', function (Request $request) {

    //Log::error($request);

    $rooms = DB::connection('pephireapp')

        ->table('cameras')
        ->where('room_id', $request->loaderid)
        ->get();

    return response()->json($rooms);
});

Route::get('/mymatches', function (Request $request) {

    $newdata = DB::connection('pephireapp')

        ->table('kca_matches')

        ->select('kca_matches.id as matchid', 'kca_matches.match_name','kca_matches.match_date', 'kca_matches.umpire_fees', 'kca_matches.venue')

        ->join('matchtostudent', 'matchtostudent.matchid', '=', 'kca_matches.id')

        ->where('matchtostudent.studentid', $request->studentid)

        ->get();


    return response()->json($newdata);
});