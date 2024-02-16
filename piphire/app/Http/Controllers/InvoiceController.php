<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use DB;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $header_class = 'invoice';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('invoices.index', compact('header_class','auto_job','schedule'));
    }

    /**
     * Return a listing of invoices for DataTable.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $invoices = Invoice::with('plan')->where('user_id', auth()->user()->id)->get();
        return datatables($invoices)
            ->addColumn('plan_name',function($invoice){
                return $invoice->plan->name;
            })
            ->addColumn('actions', function ($invoice) {
                return [
                    'view_link' => url('invoice/' . $invoice->id)
                ];
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $header_class = 'invoice';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('invoices.show', compact('invoice', 'header_class','auto_job','schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
