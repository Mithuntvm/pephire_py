<?php

namespace App\Http\Controllers;

use App\Organizations_Hold_Resume;
use Illuminate\Http\Request;
use DB;
class OrganizationsHoldResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Organizations_Hold_Resume  $organizations_Hold_Resume
     * @return \Illuminate\Http\Response
     */
    public function show(Organizations_Hold_Resume $organizations_Hold_Resume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizations_Hold_Resume  $organizations_Hold_Resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizations_Hold_Resume $organizations_Hold_Resume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizations_Hold_Resume  $organizations_Hold_Resume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizations_Hold_Resume $organizations_Hold_Resume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizations_Hold_Resume  $organizations_Hold_Resume
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        
        $holditem  = Organizations_Hold_Resume::where('id',$request->id)->first();
        if($holditem){
        $holditem->delete();
        }
        return response()->json(array('success'=>1));        
    }
}
