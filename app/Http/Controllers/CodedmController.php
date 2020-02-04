<?php

namespace App\Http\Controllers;

use App\Codedm;
use Illuminate\Http\Request;

class CodedmController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Codedm  $codedm
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        \Log::debug('$request->codeean13_id');
        \Log::debug($request->codeean13_id);
        $codedm = Codedm::getCodeDmByCodeEan13Id($request->codeean13_id);
        if ($codedm !== null) {
            $status = $codedm->Status()->create(['name' => 'Print']);
            \Log::debug('status');
            \Log::debug($status);
            $status->save();
            $codedm->status_id = $status->id;
            $codedm->save();
        }
        \Log::debug('store');
        \Log::debug(json_encode($codedm));

        return response()->json(['codedm' => $codedm]);
    }

    public function add(Request $request)
    {
        \Log::debug(__CLASS__ . "->" . __FUNCTION__);
        \Log::debug($request->code);
        \Log::debug($request->codeean13);
        $codedm = Codedm::add($request->code, $request->codeean13);
        if ($codedm !== false) {
            return response()->json(['codedm'=> $codedm]);
        }
        return response()->json(['error'=>'code datamatrix early exist'], 400);
    }

    public function getByCode(Request $request)
    {
        \Log::debug('$request->code');
        \Log::debug($request->code);

        $codedm = Codedm::getByCode($request->code);

        if ($codedm !== null) {
            $status = $codedm->status;
            if ($status !== null) {
                $status->name = 'Inflicted';
                $status->save();
            }
        }
        return response()->json(['codedm' => $codedm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Codedm  $codedm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Codedm $codedm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Codedm  $codedm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Codedm $codedm)
    {
        //
    }
}
