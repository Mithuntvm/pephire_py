<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;



class PowerbiController extends Controller
{

    public function index(Request $request){
        $header_class = 'powerbi';
        $result = $this->getEmbedToken();
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/powerbi', compact('header_class', 'result','auto_job','schedule'));
    }
    
    private function getEmbedToken(){
        $url = 'http://127.0.0.1:5300/getEmbedToken';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response=json_decode($response_json, true);
        return $response;
    }


}
