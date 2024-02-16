<?php

namespace App\Http\Controllers\Admin;

use App\Plantype;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class AdminPlantypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data   = array('page'=>'plantype');
        return view('admin/plantype/list',$data);           
    }

    public function dataTable(Request $request){

        $plantypes      = Plantype::withTrashed()->get();
        return datatables($plantypes)
                ->addColumn('actions', function ($plantype) {

                    if(!$plantype->deleted_at){

                        return [
                            'edit_link' => url('backend/plantype/'. $plantype->tuid . '/edit'),
                            'custom_link' => url('backend/plantype/delete/'. $plantype->id),
                            'custom_title' => 'Delete',
                            'custom_icon' => 'fa-trash-o',
                            'custom_class' => 'btn-danger del-resource'
                        ];

                    }else{

                        return [
                            'edit_link' => url('backend/plantype/'. $plantype->tuid . '/edit'),
                            'custom_link' => url('backend/plantype/activate/'. $plantype->id),
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
        $data   = array('page'=>'plantype');
        return view('admin/plantype/create',$data);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $frontend_show = $request->frontend_show;

        $plantype = new Plantype();

        $plantype->tuid             = Uuid::uuid1()->toString();
        $plantype->name             = $request->name;
        $plantype->start_date       = $request->start_date;
        $plantype->end_date         = $request->end_date;
        $plantype->frontend_show    = ($frontend_show) ? 1 : 0;
        $plantype->save();

        return redirect('/backend/plantype/list')->with('success', 'Plan Type created successfully');        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plantype  $plantype
     * @return \Illuminate\Http\Response
     */
    public function show(Plantype $plantype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plantype  $plantype
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $plantype   = Plantype::where('tuid',$request->tuid)->first();
        $data   = array('page'=>'plantype','plantype'=>$plantype);
        return view('admin/plantype/edit',$data);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plantype  $plantype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //dd($request->input());
        $frontend_show = $request->frontend_show;
        $plantype                   = Plantype::where('tuid',$request->tuid)->first();
        $plantype->name             = $request->name;
        $plantype->start_date       = $request->start_date;
        $plantype->end_date         = $request->end_date;
        $plantype->frontend_show    = ($frontend_show) ? 1 : 0;        
        $plantype->update();

        return redirect('/backend/plantype/list')->with('success', 'Plan type updated successfully');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plantype  $plantype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Plantype::find($request->id)->delete();
        redirect('/backend/plantype/list')->with('success', 'Plan deleted successfully');        
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
        Plantype::withTrashed()->where('id','=',$request->id)->restore();

        redirect('/backend/plantype/list')->with('success', 'Plan activated successfully');

    }
    
}
