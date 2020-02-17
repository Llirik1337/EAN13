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
	\Log::debug($request->all());
        if($request->data === null) {
           return response()->json(['error'=>'missing argument']);
        } else if (!is_array($request->data)) {
          return response()->json(['error'=>'argument is not array']);
        }
         \Log::debug(__CLASS__ . "->" . __FUNCTION__);
         \Log::debug(json_encode($request->data));

        $error = [];

        $codedm_array = [];

        $codedm_exist = [];

        foreach ($request->data as $key => $element) {
            if (!isset($element['code'])) {
                array_push($error, ['error' => ['msg' => 'missing argument', 'argument' => 'code'], 'element' => $element, 'index' => $key]);
            } else if (!isset($element['codeean13'])) {
                array_push($error, ['error' => ['msg' => 'missing argument', 'argument' => 'codeean13'], 'element' => $element, 'index' => $key]);
            } else {

                $code = $element['code'];
                $codeean13 = $element['codeean13'];

                $codedm = Codedm::add($code, $codeean13);
                if ($codedm !== false) {
                    array_push($codedm_array, $codedm);
                    // return response()->json(['codedm' => $codedm]);
                } else {
                    array_push($codedm_exist, ['warning' => ['msg' => 'code datamatrix early exist'], 'element' => $element, 'index' => $key]);
                }
            }
        }
        return response()->json(['error' => $error, 'codedm' => $codedm_array, 'exists' => $codedm_exist], 200);
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
