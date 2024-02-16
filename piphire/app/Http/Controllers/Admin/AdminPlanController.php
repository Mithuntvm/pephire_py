<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use App\Plantype;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class AdminPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data   = array('page'=>'plans');
        return view('admin/plan/list',$data);        
    }

    public function dataTable(Request $request){

        $plans      = Plan::with('plantype')->withTrashed()->get();
        return datatables($plans)
                ->addColumn('plantype',function($plan){
                    return $plan->plantype->name;
                })
                ->addColumn('actions', function ($plan) {

                    if(!$plan->deleted_at){

                        return [
                            'edit_link' => url('backend/plan/'. $plan->puid . '/edit'),
                            'custom_link' => url('backend/plan/delete/'. $plan->id),
                            'custom_title' => 'Delete',
                            'custom_icon' => 'fa-trash-o',
                            'custom_class' => 'btn-danger del-resource'
                        ];

                    }else{

                        return [
                            'edit_link' => url('backend/plan/'. $plan->puid . '/edit'),
                            'custom_link' => url('backend/plan/activate/'. $plan->id),
                            'custom_title' => 'Activate',
                            'custom_icon' => 'fa-check',
                            'custom_class' => 'btn-success act-resource'
                        ];

                    }    

                })
                ->setRowClass(function ($org) {
                    return ($org->deleted_at) ? 'alert-warning' : '';
                })                                 
                ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $palntypes = Plantype::get();
        $data   = array('page'=>'plans');
        $data['palntypes'] = $palntypes;
        return view('admin/plan/create',$data);         
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
        //dd($request);
        $frontend_show = $request->frontend_show;

        $plan = new Plan();

        $plan->puid             = Uuid::uuid1()->toString();
        $plan->name             = $request->name;
        $plan->amount           = $request->amount;
        $plan->no_of_searches   = $request->no_of_searches;
        $plan->max_users        = $request->max_users;
        $plan->plantype_id      = $request->plantype_id;
        $plan->description      = $request->description;
        $plan->month_count      = $request->month_count;
        $plan->year_count       = $request->year_count;
        $plan->max_resume_count = $request->max_resume_count;
        $plan->frontend_show    = ($frontend_show) ? 1 : 0;        
        $plan->save();

        return redirect('/backend/plan/list')->with('success', 'Plan created successfully');
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
    public function edit(Request $request)
    {
        //
        $palntypes = Plantype::get();
        $plan   = Plan::where('puid',$request->puid)->first();
        $data   = array('page'=>'plans','plan'=>$plan);
        $data['palntypes'] = $palntypes;
        return view('admin/plan/edit',$data);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $frontend_show = $request->frontend_show;

        $plan                   = Plan::where('puid',$request->puid)->first();
        $plan->name             = $request->name;
        $plan->amount           = $request->amount;
        $plan->no_of_searches   = $request->no_of_searches;
        $plan->max_users        = $request->max_users;
        $plan->plantype_id      = $request->plantype_id;
        $plan->description      = $request->description;
        $plan->month_count      = $request->month_count;
        $plan->year_count       = $request->year_count;
        $plan->max_resume_count = $request->max_resume_count;
        $plan->frontend_show    = ($frontend_show) ? 1 : 0;        
        $plan->update();

        return redirect('/backend/plan/list')->with('success', 'Plan updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Plan::find($request->id)->delete();
        redirect('/backend/plan/list')->with('success', 'Plan deleted successfully');

    }

    /**
     * Activate the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        //
        Plan::withTrashed()->where('id','=',$request->id)->restore();

        redirect('/backend/plan/list')->with('success', 'Plan activated successfully');

    }

}
