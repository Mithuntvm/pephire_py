<?php

namespace App\Http\Controllers\Admin;

use App\Job;
use App\User;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class AdminJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $userdets = User::where('uuid',$request->uuid)->withTrashed()->first();
        $data   = array('page'=>'organization','userdets'=>$userdets);
        return view('admin/job/list',$data);        
    }

    public function dataTable(Request $request){

        $jobs      = Job::withTrashed()->with('organization','User')->get();
        return datatables($jobs)
                ->addColumn('actions', function ($job) {

                    if(!$job->deleted_at){

                        return [
                            'edit_link' => url('backend/organization/jobs/'. $job->juid . '/edit'),
                            'custom_link' => url('backend/organization/jobs/delete/'. $job->id),
                            'custom_title' => 'Delete',
                            'custom_icon' => 'fa-trash-o',
                            'custom_class' => 'btn-danger del-resource'
                        ];

                    }else{

                        return [
                            'edit_link' => url('backend/organization/jobs/'. $job->juid . '/edit'),
                            'custom_link' => url('backend/organization/jobs/activate/'. $job->id),
                            'custom_title' => 'Activate',
                            'custom_icon' => 'fa-check',
                            'custom_class' => 'btn-success act-resource'
                        ];

                    }    

                })
                ->addColumn('short_desc', function ($job) {
                    return str_limit($job->description, 150, '...');
                })
                ->setRowClass(function ($job) {
                    return ($job->deleted_at) ? 'alert-warning' : '';
                })                
                ->toJson();

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $userdets = User::where('uuid',$request->uuid)->withTrashed()->first();
        $data   = array('page'=>'organization','userdets'=>$userdets);
        return view('admin/job/create',$data);        
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
        $user   = User::where('uuid',$request->uuid)->withTrashed()->first();

        $organization = Organization::where('id',$user->organization_id)->withTrashed()->first();

        $job = new Job();

        $job->juid              = Uuid::uuid1()->toString();
        $job->organization_id   = $organization->id;
        $job->user_id           = $user->id;
        $job->name              = $request->name;
        $job->description       = $request->description;
        //$job->experience_min    = $request->experience_min;
        //$job->experience_max    = $request->experience_max;
        //$job->qualification     = $request->qualification;
        $job->save();

        return redirect('/backend/organization/jobs/'.$user->uuid)->with('success', 'Job created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        $job = Job::where('juid',$request->juid)->withTrashed()->first();
        $userdets = User::where('id',$job->user_id)->withTrashed()->first();
        $data   = array('page'=>'organization','userdets'=>$userdets,'job'=>$job);
        return view('admin/job/edit',$data);        
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
        $job = Job::where('juid',$request->juid)->withTrashed()->first();

        $userdets = User::where('id',$job->user_id)->withTrashed()->first();

        $job->name              = $request->name;
        $job->description       = $request->description;
        //$job->experience_min    = $request->experience_min;
        //$job->experience_max    = $request->experience_max;
        //$job->qualification     = $request->qualification;
        $job->save();

        return redirect('/backend/organization/jobs/'.$userdets->uuid)->with('success', 'Job created successfully');

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
        $job    = Job::where('id',$request->id)->first(); 
        $user   = User::where('id',$job->user_id)->withTrashed()->first();
        $job->delete();
        redirect('/backend/job/'.$user->uuid.'list')->with('success', 'Job deleted successfully');        
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
        $job    = Job::where('id',$request->id)->withTrashed()->first(); 
        $user   = User::where('id',$job->user_id)->withTrashed()->first();        
        $job->restore();

        redirect('/backend/job/'.$user->uuid.'/list')->with('success', 'Job activated successfully');

    }

}
