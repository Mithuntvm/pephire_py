<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
class NameController extends Controller
{

    public function index(Request $request)
    {
        
        $search = $request->term;
        // $experience = explode(',', $request->experience);

        $result = Candidate::where('name', 'LIKE', '%'. $search. '%')
        ->where('organization_id',auth()->user()->organization_id)
        ->get();

        return response()->json($result);

    }

}
