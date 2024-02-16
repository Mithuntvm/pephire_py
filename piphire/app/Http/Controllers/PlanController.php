<?php

namespace App\Http\Controllers;

use App\User;
use App\Plan;
use App\Plantype;
use App\Organization;
use Illuminate\Http\Request;
use DB;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = Organization::where('id',auth()->user()->organization_id)->first();
        $plans  = Plantype::with(['plans' => function($q){
        $q->where('frontend_show',1);
    }])->where('frontend_show',1)
    ->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))
    ->get();
        
        $adminuser = User::where('is_manager','1')->where('organization_id',auth()->user()->organization_id)->first();

        $current_plan = Plan::where('id',auth()->user()->organization->plan_id)->first();

        $header_class = 'plans';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/plans',compact('plans','header_class','organization','adminuser','current_plan','auto_job','schedule'));
    }

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
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function planexpired()
    {
                
        $header_class = 'plans';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend/plan_expired',compact('header_class','auto_job','schedule'));
    }

}
