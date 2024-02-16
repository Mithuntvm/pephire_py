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

        //taking files


        // Assuming there is only one file in the folder
        // foreach ($files->getFiles() as $file) {
        //     $existingFile = $file;
        //     break;
        // }
        $filesInDirectory = glob(public_path('/gdrive_files/*'));
        $latestFile = end($filesInDirectory);
        Log::info(print_r($latestFile, true));
        // Pass the latest file information to the view
        return view('frontend/job/gdrive_upload', compact('header_class', 'auto_job', 'schedule', 'latestFile'));
    }

    // Add a method to initialize and return the Google Drive service
    // private function getDriveService()
    // {
    //     $client = new Google_Client();
    //     $client->setClientId(env('GOOGLE_CLIENT_ID'));
    //     $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    //     $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    //     $client->setAccessType('offline');

    //     // Check if the access token is available and not expired
    //     if ($client->isAccessTokenExpired()) {
    //         // The access token is either expired or not available, try to refresh it
    //         $refreshToken = "1//0gQF4GUhl7F1dCgYIARAAGBASNwF-L9IracvKPQW2J6inkmHc4S6ygmMGuRylM6JMSl-S85X_4_1WasocjbZObCDUV9k9-tQsXjU"; // Replace with your actual refresh token
    //         $client->refreshToken($refreshToken);

    //         // Check if the new access token is valid
    //         $newAccessToken = $client->getAccessToken();

    //         if (isset($newAccessToken['access_token'])) {
    //             // Set the new access token
    //             $client->setAccessToken($newAccessToken);
    //         } else {
    //             // The refresh token might be invalid or expired, redirect the user to OAuth consent screen
    //             $authUrl = $client->createAuthUrl();
    //             return redirect($authUrl);
    //         }
    //     }

    //     // Check if the service is successfully initialized
    //     if (!$client->getAccessToken()) {
    //         // Handle the case where the service is not initialized (e.g., redirect to OAuth consent screen)
    //         $authUrl = $client->createAuthUrl();
    //         return redirect($authUrl);
    //     }

    //     $driveService = new Google_Service_Drive($client);

    //     return $driveService;
    // }



    // public function proxyUploadFile(Request $request)

    // {

    //     // Construct the URL for the actual file upload route

    //     $uploadUrl = url('/upload-file');



    //     // Create a Guzzle HTTP client

    //     $client = new Client();



    //     // Perform a POST request to the actual file upload route

    //     $response = $client->post($uploadUrl, [

    //         'headers' => [

    //             'Accept' => 'application/json',
    //             'Access-Control-Allow-Origin' => 'http://pepdemo.westindia.cloudapp.azure.com',

    //             'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',

    //             'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
    //             // ... other headers you need to include

    //         ],

    //         'multipart' => [

    //             [

    //                 'name' => 'file',

    //                 'contents' => file_get_contents($request->file('file')->getRealPath()),

    //                 'filename' => $request->file('file')->getClientOriginalName(),

    //             ],

    //         ],

    //     ]);



    //     // Return the response from the actual file upload route

    //     return $response->getBody();
    // }

    public function uploadFile(Request $request)

    {

        // Create a Google Client

        $client = new Google_Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));

        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->setAccessType('offline');



        // Check if the access token is available and not expired

        if ($client->isAccessTokenExpired()) {

            // The access token is either expired or not available, try to refresh it

            $refreshToken = "1//049pLr3N0gaEyCgYIARAAGAQSNwF-L9IrARkowg-MsQR3tjkNTZRsfkDa0vC5gPgFrGTzbG2_x8mgp6RRft47n_s7d7FPW4MFjEQ"; // Replace with your actual refresh token

            $client->refreshToken($refreshToken);



            // Check if the new access token is valid

            $newAccessToken = $client->getAccessToken();

            //    Log::error("newwwwwwwwwwwwwwwwwww". $newAccessToken);

            if (isset($newAccessToken['access_token'])) {

                // Set the new access token

                $client->setAccessToken($newAccessToken);
            } else {

                // The refresh token might be invalid or expired, redirect the user to OAuth consent screen

                $authUrl = $client->createAuthUrl();

                return redirect($authUrl);
            }
        }



        // Continue with the rest of your code for making authenticated requests...



        // Create a Google Drive Service

        $fileMetadata = new \Google_Service_Drive_DriveFile([

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

            $driveService->files->delete($file->getId());
        }



        // File upload logic

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => 'JD_Input.xlsx',
            'parents' => [$parentFolderId],
        ]);

        $fileContent = file_get_contents($request->file('file')->getRealPath());

        $uploadedFile = $driveService->files->create($fileMetadata, [
            'data' => $fileContent,
            'mimeType' => $request->file('file')->getClientMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id,name',
        ]);

        // Save a copy locally
        $localFilePath = public_path('/gdrive_files/') . $uploadedFile->name;

        // Delete all other files in the local directory
        $filesInDirectory = glob(public_path('/gdrive_files/*'));
        foreach ($filesInDirectory as $file) {
            // Delete all files except the newly uploaded file
            if ($file !== $localFilePath) {
                unlink($file);
            }
        }

        file_put_contents($localFilePath, $fileContent);

        return response()->json(['status' => true]);
    }


    public function startJob()

    {

        $ch = curl_init("http://127.0.0.1:7003/ReadGoogleDriveInput");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        Log::error('httttt' . $httpCode . 'errrr' . $err . 'ressss' . $response);
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
