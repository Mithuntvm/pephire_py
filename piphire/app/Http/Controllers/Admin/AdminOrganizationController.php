<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use App\EventLog;
use Carbon\Carbon;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as Controller;

class AdminOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data   = array('page'=>'organization');
        return view('admin/organization/list',$data);
    }


    public function dataTable(Request $request){

        $orgs      = Organization::with('plan')->withTrashed()->get();
        return datatables($orgs)
                ->addColumn('actions', function ($org) {

                    if(!$org->deleted_at){

                        return [
                            'edit_link' => url('backend/organization/'. $org->ouid . '/edit'),
                            'log_link' => url('backend/organization-log/'. $org->ouid),
                            'custom_link' => url('backend/organization/delete/'. $org->id),
                            'custom_title' => 'Delete',
                            'custom_icon' => 'fa-trash-o',
                            'custom_class' => 'btn-danger del-resource',
                            'users'  => url('backend/organization/users/'. $org->ouid)
                        ];

                    }else{
                        
                        return [
                            'edit_link' => url('backend/organization/'. $org->ouid . '/edit'),
                            'log_link' => url('backend/organization-log/'. $org->ouid),
                            'custom_link' => url('backend/organization/activate/'. $org->id),
                            'custom_title' => 'Activate',
                            'custom_icon' => 'fa-check',
                            'custom_class' => 'btn-success act-resource',
                            'users'  => url('backend/organization/users/'. $org->ouid)
                        ];

                    }    

                })
                ->addColumn('plan_name', function ($org) {
                    return $org->plan->name;
                })
                ->addColumn('total_address', function ($org) {
                    return $org->address."\n".$org->city."\n".$org->state."\n".$org->zip;
                })
                ->addColumn('bal_total', function ($org) {
                    return $org->left_search.'/'.$org->total_search;
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
        $plans  = Plan::get();
        $data   = array('page'=>'organization','plans'=>$plans);
        return view('admin/organization/create',$data);        
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

        $plan = Plan::where('id',$request->plan_id)->first();

        $path = '';
        if ($request->hasFile('logo')) {
            Storage::makeDirectory('organization');
            $path = $request->file('logo')->store('organization');
        }

        $organization = new Organization();

        $organization->ouid             = Uuid::uuid1()->toString();
        $organization->name             = $request->name;
        $organization->email            = $request->email;
        $organization->phone            = $request->phone;
        $organization->address          = $request->address;
        $organization->city             = $request->city;
        $organization->state            = $request->state;
        $organization->zip              = $request->zip;
        $organization->plan_id          = $request->plan_id;
        $organization->total_search     = $plan->no_of_searches;
        $organization->left_search      = $plan->no_of_searches;
        $organization->max_users        = $plan->max_users;
        $organization->max_resume_count = $plan->max_resume_count;
        $organization->company_logo     = $path;
        $organization->save();


        $event_text = $request->name.' created by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $organization->id;
        $event->user_id             = 0;
        $event->event_details       = $event_text;
        $event->save();

        return redirect('/backend/organization/list')->with('success', 'Organization created successfully');
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
        $plans  = Plan::get();
        $organization = Organization::where('ouid',$request->ouid)->withTrashed()->first();
        $data   = array('page'=>'organization','plans'=>$plans,'organization'=>$organization);
        return view('admin/organization/edit',$data);         
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

        $plan = Plan::where('id',$request->plan_id)->first();

        $organization = Organization::where('ouid',$request->ouid)->withTrashed()->first();

        $organization->name             = $request->name;
        $organization->email            = $request->email;
        $organization->phone            = $request->phone;
        $organization->address          = $request->address;
        $organization->city             = $request->city;
        $organization->state            = $request->state;
        $organization->zip              = $request->zip;
        $organization->plan_id          = $request->plan_id;
        $organization->total_search     = $plan->no_of_searches;
        $organization->left_search      = $plan->no_of_searches;
        $organization->max_users        = $plan->max_users;
        $organization->max_resume_count = $plan->max_resume_count;
        
        if ($request->hasFile('logo')) {
            $path = '';
            Storage::makeDirectory('organization');
            $path = $request->file('logo')->store('organization');
            $organization->company_logo = $path;
        }

        $organization->update();

        return redirect('/backend/organization/list')->with('success', 'Organization updated successfully');

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
        $orgdets = Organization::where('id',$request->id)->first();
        $orgdets->delete();

        $event_text = $orgdets->name.' de-activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $orgdets->id;
        $event->user_id             = 0;
        $event->event_details       = $event_text;
        $event->save();

        redirect('/backend/organization/list')->with('success', 'Organization deleted successfully');        
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
        $orgdets = Organization::withTrashed()->where('id',$request->id)->first();
        $orgdets->restore();

        $event_text = $orgdets->name.' activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $orgdets->id;
        $event->user_id             = 0;
        $event->event_details       = $event_text;
        $event->save();

        redirect('/backend/organization/list')->with('success', 'Organization activated successfully');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gethistory(Request $request)
    {
        //
        $organization = Organization::where('ouid',$request->ouid)->withTrashed()->first();
        $history = EventLog::where('organization_id',$organization->id)->get();
        $data    = array('page'=>'organization','history'=>$history,'organization'=>$organization);
        return view('admin/organization/history',$data);
    }


}
