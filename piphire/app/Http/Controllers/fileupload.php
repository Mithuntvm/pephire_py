<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use DB;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\Xlsx;

class FileUploadController extends Controller
{
    public function gdrive(Request $request)
    {
        $header_class = 'gdrive';
        $auto_job = DB::connection('pephire_auto')
            ->table('autonomous_job_file_master')
            ->where('uid', auth()->user()->id)
            ->first();
        $schedule = DB::connection('pephire_auto')
            ->table('autonomous_job_schedule')
            ->where('uid', auth()->user()->id)
            ->first();

        //Fetch information about the existing file in Google Drive
        $parentFolderId = '1DXQ4yIHeTe_Rg3XIVaMWWsCbuQKzTm9X';
        $driveService = $this->getDriveService(); // Create a method to initialize and return the Google Drive service

        // Get a list of all files in the parent folder
        $files = $driveService->files->listFiles([
            'q' => "'$parentFolderId' in parents and trashed=false",
        ]);

        $existingFile = null;

        // Assuming there is only one file in the folder
        foreach ($files->getFiles() as $file) {
            $existingFile = $file;
            break;
        }

        // Pass the existing file information to the view
        return view('frontend/job/gdrive_upload', compact('header_class', 'auto_job', 'schedule'));
    }

    // Add a method to initialize and return the Google Drive service
    private function getDriveService()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');

        // Check if the access token is available and not expired
        if ($client->isAccessTokenExpired()) {
            // The access token is either expired or not available, try to refresh it
            $refreshToken = "1//0ggK8-9Xi0oZ2CgYIARAAGBASNwF-L9Irp2D5O4CxtrLLTOuRahJX45PRpBNHEsqxWj1oCb2huUQJDzXOz7Eq93tLojVyw0Vzb0M"; // Replace with your actual refresh token
            $client->refreshToken($refreshToken);

            // Check if the new access token is valid
            $newAccessToken = $client->getAccessToken();

            if (isset($newAccessToken['access_token'])) {
                // Set the new access token
                $client->setAccessToken($newAccessToken);
            } else {
                // The refresh token might be invalid or expired, redirect the user to OAuth consent screen
                $authUrl = $client->createAuthUrl();
                return redirect($authUrl);
            }
        }

        // Check if the service is successfully initialized
        if (!$client->getAccessToken()) {
            // Handle the case where the service is not initialized (e.g., redirect to OAuth consent screen)
            $authUrl = $client->createAuthUrl();
            return redirect($authUrl);
        }

        $driveService = new Google_Service_Drive($client);

        return $driveService;
    }



    public function proxyUploadFile(Request $request)

    {

        // Construct the URL for the actual file upload route

        $uploadUrl = url('/upload-file');



        // Create a Guzzle HTTP client

        $client = new Client();



        // Perform a POST request to the actual file upload route

        $response = $client->post($uploadUrl, [

            'headers' => [

                'Accept' => 'application/json',
                'Access-Control-Allow-Origin' => 'http://pepdemo.westindia.cloudapp.azure.com',

                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',

                'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
                // ... other headers you need to include

            ],

            'multipart' => [

                [

                    'name' => 'file',

                    'contents' => file_get_contents($request->file('file')->getRealPath()),

                    'filename' => $request->file('file')->getClientOriginalName(),

                ],

            ],

        ]);



        // Return the response from the actual file upload route

        return $response->getBody();
    }


    public function uploadFile(Request $request)

    {

        // Check if the request is coming from the proxy

        if ($request->header('X-Proxy-Request') == 'true') {

            return $this->handleProxyUpload($request);
            Log::error('proxyyyyyyyyyyyyy');
        }



        // Your existing Google Drive upload logic remains here

        $client = new Google_Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));

        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->setAccessType('offline');



        // Check if the access token is available and not expired

        if ($client->isAccessTokenExpired()) {

            // The access token is either expired or not available, try to refresh it

            // $refreshToken = "1//04h9kNNBIIVOpCgYIARAAGAQSNwF-L9IrRuis0ZLDGY3L_O0ClEXhDMuSjEGysQy1qgFKrwZ9_M_Ex6Fira0Au9iNBhaNeXtSdT4"; // Replace with your actual refresh token

            // $client->refreshToken($refreshToken);



            // // Check if the new access token is valid

            // $newAccessToken = $client->getAccessToken();

            if ($client->isAccessTokenExpired()) {
                try {
                    // Attempt to refresh the access token
                    $client->fetchAccessTokenWithRefreshToken();
                } catch (\Exception $e) {
                    // Log the exception message for debugging
                    Log::error('Error refreshing access token: ' . $e->getMessage());
                
                    // Handle the case where the refresh token is invalid or expired
                    $authUrl = $client->createAuthUrl();
                    return redirect($authUrl);
                }
                
            }

            // if (isset($newAccessToken['access_token'])) {
            //     Log::error('normallllllllllllllllll');

            //     // Set the new access token

            //     $client->setAccessToken($newAccessToken);
            // } else {

            //     // The refresh token might be invalid or expired, redirect the user to OAuth consent screen
            //     Log::error('abnormalllllllllllllll');

            //     $authUrl = $client->createAuthUrl();

            //     return redirect($authUrl);
            // }
        }


        $fileMetadata = new Google_Service_Drive_DriveFile([

            'name' => $request->file('file')->getClientOriginalName(),
            'parents' => ['1RKLOJsadYl2BtMqejgLdAfm-3x0T1bHI'], // Set the file name

        ]);



        // Get the file content to upload

        $fileContent = file_get_contents($request->file('file')->getRealPath());

        $driveService = new Google_Service_Drive($client);



        // Set the parent folder ID

        $parentFolderId = '1DXQ4yIHeTe_Rg3XIVaMWWsCbuQKzTm9X';



        // Get a list of all files in the parent folder

        $files = $driveService->files->listFiles([

            'q' => "'$parentFolderId' in parents and trashed=false",

        ]);



        // Loop through each file and delete it

        foreach ($files->getFiles() as $file) {
            Log::error('fileeeeeeeeeeeeeeeeeeee');

            $driveService->files->delete($file->getId());
        }



        // File upload logic

        $fileMetadata = new Google_Service_Drive_DriveFile([

            'name' => $request->file('file')->getClientOriginalName(),

            'parents' => [$parentFolderId],

        ]);



        $fileContent = file_get_contents($request->file('file')->getRealPath());



        $uploadedFile = $driveService->files->create($fileMetadata, [

            'data' => $fileContent,

            'mimeType' => $request->file('file')->getClientMimeType(),

            'uploadType' => 'multipart',

            'fields' => 'id',

        ]);



        // Convert the uploaded file details to a string

        $responseContent = json_encode($uploadedFile, JSON_PRETTY_PRINT);





        return response()->json(['status' => true]);
    }



    private function handleProxyUpload(Request $request)

    {
        Log::error('handleeeeeeeeeeeeeeeeee');

        $client = new Google_Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));

        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->setAccessType('offline');
        // Handle the file upload without interacting with Google Drive

        $fileMetadata = new Google_Service_Drive_DriveFile([

            'name' => $request->file('file')->getClientOriginalName(),

            'parents' => ['1RKLOJsadYl2BtMqejgLdAfm-3x0T1bHI'], // Set the file name

        ]);



        // Get the file content to upload

        $fileContent = file_get_contents($request->file('file')->getRealPath());



        $driveService = new Google_Service_Drive($client);



        // Set the parent folder ID

        $parentFolderId = '1DXQ4yIHeTe_Rg3XIVaMWWsCbuQKzTm9X';



        // Get a list of all files in the parent folder

        $files = $driveService->files->listFiles([

            'q' => "'$parentFolderId' in parents and trashed=false",

        ]);



        // Loop through each file and delete it

        foreach ($files->getFiles() as $file) {
            Log::error('getttttttttttttttttttttt');

            $driveService->files->delete($file->getId());
        }



        // File upload logic

        $fileMetadata = new Google_Service_Drive_DriveFile([

            'name' => $request->file('file')->getClientOriginalName(),

            'parents' => [$parentFolderId],

        ]);



        $fileContent = file_get_contents($request->file('file')->getRealPath());



        $uploadedFile = $driveService->files->create($fileMetadata, [

            'data' => $fileContent,

            'mimeType' => $request->file('file')->getClientMimeType(),

            'uploadType' => 'multipart',

            'fields' => 'id',

        ]);



        // Convert the uploaded file details to a string

        $responseContent = json_encode($uploadedFile, JSON_PRETTY_PRINT);



        return response()->json(['status' => true]);
    }
    public function startJob()

    {
        //$post = json_encode(array(
        // 				"candidate_id" => $candidate_id,
        // 				"org_id" => auth()->user()->organization_id,
        // 				"user_id" => auth()->user()->id,
        // 				"Job_id" => $job_id
        // 			));
        // Log::error($post.'posttttttttttttttttt');
        // 			$ch = curl_init("http://127.0.0.1:7002/ContactCandidate");
        // 			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // 			// execute!
        // 			$pythonCall = curl_exec($ch);

        // 			// close the connection, release resources used
        // 			curl_close($ch);




        //ANOTHER SOLUTION APII





        $ch = curl_init("http://127.0.0.1:7003/ReadGoogleDriveInput");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($httpCode == 0) //Service might not be running
        {
            $data['error']    = 0;
        } else if ($err) {
            // Rollback Transaction
            $data['error']    = 0;
        } else {
            $data['success']    = 1;
        }

        // return response()->json(['status' => true]);
        return response()->json($data);
    }
}
