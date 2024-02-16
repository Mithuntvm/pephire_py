<?php

namespace App\Http\Controllers;
use DB;
use Mail;
use App\User;
use App\EventLog;
use Carbon\Carbon;
use App\Organization;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $header_class = 'users';
        $auto_job = DB::connection('pephire_auto')
			->table('autonomous_job_file_master')
			->where('uid', auth()->user()->id)
			->first();
		$schedule = DB::connection('pephire_auto')
			->table('autonomous_job_schedule')
			->where('uid', auth()->user()->id)
			->first();

        return view('frontend.user.list',compact('header_class','auto_job','schedule'));
    }

    public function dataTable(){

        $users     = User::where('organization_id',auth()->user()->organization_id)->withTrashed()->get();

        return datatables($users)
                ->addColumn('actions', function ($user) {

                    if($user->is_manager){

                        return [
                            'edit_link' => url('/myprofile'),
                            'custom_link' => '',
                            'custom_title' => '',
                            'custom_class' => '',
                            'custom_icon' => '',
                            'adminlink' => '',
                            'activationlink' => ''
                        ];

                    }else{

                        if(!$user->deleted_at){

                            return [
                                'edit_link' => url('user/'. $user->uuid . '/edit'),
                                'custom_link' => url('user/delete/'. $user->id),
                                'custom_title' => 'Delete',
                                'custom_icon' => 'fa-trash-o',
                                'custom_class' => 'btn-danger del-resource',
                                'adminlink' => url('makeadminuser/'. $user->uuid),
                                'activationlink' => url('senduseractivation/'. $user->uuid)
                            ];

                        }else{

                            return [
                                'edit_link' => url('user/'. $user->uuid . '/edit'),
                                'custom_link' => url('user/activate/'. $user->id),
                                'custom_title' => 'Activate',
                                'custom_icon' => 'fa-check',
                                'custom_class' => 'btn-success act-resource',
                                'activationlink' => '',
                                'adminlink' => ''
                            ];

                        }

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
    public function create()
    {
        //
        $orgdets   = Organization::where('id',auth()->user()->organization_id)->withTrashed()->first();
        $usercount = User::where('organization_id',auth()->user()->organization_id)->count();

        //dd($usercount);

        if($usercount >= $orgdets->max_users){
            return redirect('/users/')->with('warning', 'Maximum user count exceeded');
        }
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        $header_class = 'users';
        return view('frontend.user.create',compact('header_class','auto_job','schedule'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user                       = new User();
        $user->uuid                 = Uuid::uuid1()->toString();
        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->organization_id      = auth()->user()->organization_id;
        $user->verification_link    = Uuid::uuid1()->toString();
        $user->deleted_at           = Carbon::now();
        $user->save();

        $event_text = $request->name.' invited by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = auth()->user()->organization_id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

/*        $data               = array();
        $data['name']       = $request->name;
        $data['email']      = $request['email'];
        $data['inviteurl']  = url('/validate/user/'.$user->verification_link);
        $this->sendmail($data, 'Pephire : Activation', 'frontend.mail.activation');*/        

        return redirect('/users')->with('success', 'User created successfully');        
    }


    private function sendmail($data,$subject,$view)
    {
        Mail::send($view, $data, function($message) use($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
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
        $user           = User::where('uuid',$request->uuid)->withTrashed()->first();
        $header_class   = 'users';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('frontend.user.edit',compact('user','header_class','auto_job','schedule'));        
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
        $user    = User::where('uuid',$request->uuid)->withTrashed()->first();

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->update();

        return redirect('/users')->with('success', 'User updated successfully');         
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
        $user->delete();

        $event_text = $user->name.' has been de-activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = auth()->user()->organization_id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data               = array();
        $data['name']       = $user->name;
        $data['email']      = $user->email;
        $this->sendmail($data, 'Pephire : Deactivation', 'frontend.mail.deactivate');

        redirect('/users')->with('success', 'User deleted successfully');        
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
        $orgdets   = Organization::where('id',auth()->user()->organization_id)->withTrashed()->first();
        $usercount = User::where('organization_id',auth()->user()->organization_id)->count();

        if($usercount >= $orgdets->max_users){

            $data = array();
            $data['error'] = 1;
            return response()->json($data);

        }

        $user = User::where('id',$request->id)->withTrashed()->first();
        $user->restore();

        $event_text = $user->name.' has been activated by '.auth()->user()->name.' at '.Carbon::now()->format('d/M/Y g:i A');

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = auth()->user()->organization_id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data               = array();
        $data['name']       = $user->name;
        $data['email']      = $user->email;
        $this->sendmail($data, 'Pephire : Activation', 'frontend.mail.activate');

        redirect('/users')->with('success', 'User activated successfully');

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
    

    public function makeadminuser(Request $request)
    {
        //
        $newuser = User::where('uuid',$request->uuid)->withTrashed()->first();
        $user = User::where('id',auth()->user()->id)->first();
        $orgdets = Organization::where('id',$user->organization_id)->withTrashed()->first();

        $user->is_manager = 0;
        $user->update();

        $newuser->is_manager = 1;
        $newuser->update();

        $orgdets->user_id = $newuser->id;
        $orgdets->update();


        redirect('/backend/organization/users/'.$orgdets->ouid)->with('success', 'Admin added successfully');

    }

}
