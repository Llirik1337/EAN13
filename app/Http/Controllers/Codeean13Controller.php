<?php

namespace App\Http\Controllers;

use App\Codeean13;
use Illuminate\Http\Request;

class Codeean13Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Log::debug('message');
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

    public function add(Request $request)
    {

        if($request->code === '' || $request->code === null)
        {
            return response()->json(['error' => ['msg' => 'missing argument', 'argument'=>'code'] ], 400);
        }

        if($request->tovar === '' || $request->tovar === null)
        {
            return response()->json(['error' => ['msg' => 'missing argument', 'argument'=>'tovar'] ], 400);
        }

        if($request->company === '' || $request->company === null)
        {
            return response()->json(['error' => ['msg' => 'missing argument', 'argument'=>'company'] ], 400);
        }

        \Log::debug(__CLASS__. "->" . __FUNCTION__);
        \Log::debug($request->code);
        \Log::debug($request->tovar);
        \Log::debug($request->company);

        $codeean13 = Codeean13::add($request->code, $request->tovar, $request->company);
        // Codedm::add($request->code, $request->tovar, $request->company);
        return response()->json(['codeean13' => $codeean13]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Codeean13  $codeean13
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $codeean13 = Codeean13::getByCode($request->code);
        \Log::debug(json_encode($codeean13));
        return response()->json(['codeean13' => $codeean13]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Codeean13  $codeean13
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Codeean13 $codeean13)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Codeean13  $codeean13
     * @return \Illuminate\Http\Response
     */
    public function destroy(Codeean13 $codeean13)
    {
        //
    }
}
