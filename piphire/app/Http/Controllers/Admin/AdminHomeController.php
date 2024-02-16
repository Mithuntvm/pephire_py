<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Invoice;
use App\Organization;
use Illuminate\Http\Request;
use App\Plan;
use App\Candidate;
use App\Plantype;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller as Controller;

class AdminHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userCount = count(User::all());
        $users = User::get("created_at");
        $invoice = Invoice::all(["amount", "created_at", "status"])->where("status", "captured");
        $plans = Plan::all();
        $planType = Plantype::all();
        $whatsappCount = Candidate::all(["data_completed"]);

        $data   = array('page'=>'dashboard', 'userCount' => $userCount, 'users' => $users, 'invoice' => $invoice , 'plans' => $plans, 'planType' => $planType, 'whatsappCount' => $whatsappCount);
        // dd($invoice);
        
        
        // dd($this->prepareData($users));
        return view('admin/dashboard/index',$data);
    }


    // public function prepareData($dates){
    //     $minDate = $dates[0]->created_at;
    //     $maxDate = $dates[0]->created_at;
    //     foreach ($dates as $date){
    //         if ($date->created_at->lt($minDate)){
    //             $minDate = $date->created_at;
    //         }
    //         if ($date->created_at->gt($maxDate)){
    //             $maxDate = $date->created_at;
    //         }
    //     }
    //     $minDate = $minDate->subMonth();
    //     $maxDate = $maxDate->addMonth();
    //     $months = [];
    //     $itr_min = clone $minDate;
    //     $itr_max = Carbon::now()->addMonth();
    //     $itr_min->subDays($itr_min->day - 1);
    //     $itr_max->subDays($itr_max->day - 1);
    //     while($itr_max->gte($itr_min)){
    //         array_push($months,clone $itr_min);
    //         $itr_min->addMonth();
    //     }
        
    //     $data = [];
    //     for($i = 1; i < count($month); $i++)
    //         foreach ($dates as $date){
    //             if ($month[i - 1].gte($date) && $month[i].lte($date) ){
                    
    //             }
    //         }
        

    //     return $months;
    //     // return $months;
    // }



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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function checkemailexist(Request $request){

        //$user = User::withTrashed()->where('email',$request->email)->first();
        $organization = Organization::withTrashed()->where('email',$request->email)->first();

        $organization = $user = array();
        
        if($organization && ($request->orgid == $organization->id)){
            $organization = array();
        }

        if($user && ($request->userid == $user->id)){
            $user = array();
        }

        if(!$user && !$organization){

            echo 'true';

        }else{

            echo 'false';

        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminedit(Request $request)
    {
        //
        $data   = array('page'=>'admin');
        return view('admin/users/admin-edit',$data);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminupdate(Request $request)
    {
        //

        $user = User::where('id',auth()->user()->id)->first();

        $user->name = $request->name;
        $user->phone = $request->phone;

        if($request->password != ""){
            $user->password = Hash::make($request->password);
        }

        $user->update();
        return redirect('/backend/dashboard');

    }



}
