<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\User;
use App\EventLog;
use Carbon\Carbon;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as Controller;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //dd($request->ouid);
        $orgdets   = Organization::where('ouid',$request->ouid)->withTrashed()->first();

        $data   = array('page'=>'organization','orgdets'=>$orgdets);
        return view('admin/users/list',$data);
    }

    public function dataTable(Request $request){

        $orgdets   = Organization::where('ouid',$request->ouid)->withTrashed()->first();

        $users     = User::where('organization_id',$orgdets->id)->withTrashed()->get();

        return datatables($users)
                ->addColumn('actions', function ($user) {

                    if(!$user->deleted_at){

                        return [
                            'edit_link' => url('backend/organization/users/'. $user->uuid . '/edit'),
                            'custom_link' => url('backend/organization/users/delete/'. $user->id),
                            'custom_title' => 'Delete',
                            'custom_icon' => 'fa-trash-o',
                            'custom_class' => 'btn-danger del-resource',
                            'job_listing' => url('backend/organization/jobs/'. $user->uuid),
                            'activationlink' => url('backend/senduseractivation/'. $user->uuid)
                        ];

                    }else{

                        return [
                            'edit_link' => url('backend/organization/users/'. $user->uuid . '/edit'),
                            'custom_link' => url('backend/organization/users/activate/'. $user->id),
                            'custom_title' => 'Activate',
                            'custom_icon' => 'fa-check',
                            'custom_class' => 'btn-success act-resource',
                            'job_listing' => url('backend/organization/jobs/'. $user->uuid),
                            'activationlink' => url('backend/senduseractivation/'. $user->uuid)
                        ];

                    }    

                })
                ->setRowClass(function ($user) {
                    return ($user->deleted_at) ? 'alert-warning' : '';
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
        $orgdets   = Organization::where('ouid',$request->ouid)->withTrashed()->first();

        $usercount = User::where('organization_id',$orgdets->id)->count();

            if($usercount >= $orgdets->max_users){
                return redirect('/backend/organization/users/'.$orgdets->ouid)->with('warning', 'Maximum user count exceeded');
            }

        $data   = array('page'=>'organization','orgdets'=>$orgdets);
        return view('admin/users/create',$data);        
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
        $orgdets   = Organization::where('ouid',$request->ouid)->withTrashed()->first();

        $user                       = new User();
        $user->uuid                 = Uuid::uuid1()->toString();
        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->organization_id      = $orgdets->id;
        $user->verification_link    = Uuid::uuid1()->toString();
        $user->save();


        $event_text = $request->name.' invited by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $orgdets->id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        return redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'User created successfully');


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
        $user    = User::where('uuid',$request->uuid)->withTrashed()->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();
        $data    = array('page'=>'organization','user'=>$user, 'orgdets'=>$orgdets);
        return view('admin/users/edit',$data);        
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
        $user    = User::where('uuid',$request->uuid)->withTrashed()->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->update();

        return redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'User updated successfully');        
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
        $user = User::where('id',$request->id)->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();
        $user->delete();

        $event_text = $user->name.' has been de-activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $orgdets->id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data               = array();
        $data['name']       = $user->name;
        $data['email']      = $user->email;
        $this->sendmail($data, 'Pephire : Deactivation', 'frontend.mail.deactivate');

        redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'User deleted successfully');        
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
        $user = User::where('id',$request->id)->withTrashed()->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();
        $user->restore();

        $event_text = $user->name.' has been activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $orgdets->id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data               = array();
        $data['name']       = $user->name;
        $data['email']      = $user->email;
        $this->sendmail($data, 'Pephire : Activation', 'frontend.mail.activate');

        redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'User activated successfully');

    }


    /**
     * Resend the activation link to specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function senduseractivation(Request $request)
    {
        //
        $user = User::where('uuid',$request->uuid)->withTrashed()->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();

        $newkey = Uuid::uuid1()->toString();

        $user->verification_link    = $newkey;
        $user->update();

        $data               = array();
        $data['name']       = $user->name;
        $data['email']      = $user->email;
        $data['inviteurl']  = url('/validate/user/'.$newkey);
        $this->sendmail($data, 'Pephire : Activation', 'frontend.mail.activation');

        redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'Activation link send successfully');

    }

    private function sendmail($data,$subject,$view)
    {
        Mail::send($view, $data, function($message) use($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
    }    


}
