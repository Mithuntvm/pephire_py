<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pepappupdateprofile', function (Request $request) {

    //Log::error($request);

    // Validate the request (you can add more validation rules)

    /*$request->validate([

        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

    ]);*/

    $storedFilePath = $request->urlpath;

    $imagePath = 'file:///E:/Pephire_resumes/storage/app/appprofileimages/';

    $file = $request->file('image');

   
    if ($file && $file->isValid())

    {
            
    
    // Generate a unique filename to avoid overwriting existing files

    $filename = uniqid() . '_' . $file->getClientOriginalName();

   

    // Move the file to the desired location in the storage directory

    $file->move($imagePath, $filename);

   

    // Get the path where the file is stored

    $storedFilePath = url('/').'/appprofileimages/'.$filename;

    }

    $updateCandidate = DB::connection('pephireapp')

        ->table('students')

        ->where('students.id', $request->studentid)

        ->update([

            'cgpa' => $request->cgpa,

            'email' => $request->email,

            'unique_id' => $request->registerno,

            'batch' => $request->batch,

            'branch' => $request->branch,

            'projects' => $request->projects,

            'profile_url' => $storedFilePath,

            'skills' => $request->skills,

        ]);

    return response()->json($updateCandidate);

});