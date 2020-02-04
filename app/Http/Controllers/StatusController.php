<?php

namespace App\Http\Controllers;

use App\Statuscodedm;
use Illuminate\Http\Request;

class StatusController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $status = Statuscodedm::setStatus($request->id, $request->statusText);

        return response()->json(['status'=>$status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statuscodedm  $statuscodedm
     * @return \Illuminate\Http\Response
     */
    public function show(Statuscodedm $statuscodedm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statuscodedm  $statuscodedm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statuscodedm $statuscodedm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statuscodedm  $statuscodedm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statuscodedm $statuscodedm)
    {
        //
    }
}
