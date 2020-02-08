<?php

namespace App\Http\Controllers;

use App\Codedm;
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
        \Log::debug(__CLASS__ . "->" . __FUNCTION__);
        \Log::debug($request->data);
        if ($request->data === null) {
            return response()->json(['msg' => 'missing argument', 'argument' => 'code']);
        }

        $data = $request->data;
        $error_response = [];
        $codeean13 = [];
        foreach ($data as $key => $element) {
            \Log::debug($element);



            if (!isset($element['code'])) {
                array_push($error_response, ['error' => ['msg' => 'missing argument', 'argument' => 'code'], 'element' => $element, 'index' => $key]);
            } else
            if (!isset($element['tovar'])) {
                array_push($error_response, ['error' => ['msg' => 'missing argument', 'argument' => 'tovar'], 'element' => $element, 'index' => $key]);
            } else
            if (!isset($element['company'])) {
                array_push($error_response, ['error' => ['msg' => 'missing argument', 'argument' => 'company'], 'element' => $element, 'index' => $key]);
            } else {
                $code = $element['code'];
                $tovar = $element['tovar'];
                $company = $element['company'];

                \Log::debug($code);
                \Log::debug($tovar);
                \Log::debug($company);
                array_push($codeean13, Codeean13::add($code, $tovar, $company));
            }
        }
        return response()->json(['codeean13' => $codeean13, 'error' => $error_response]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Codeean13  $codeean13
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $code = $request->get('code');
        // \Log::debug($code);
        // \Log::debug($request->all());
        $codeean13 = Codeean13::getByCode($code);
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


    public function getStatistics(Request $request)
    {
        \Log::debug('user');
        \Log::debug(json_encode(auth()->user()));
        return response()->json(Codeean13::getStatisticsByCompnayId(auth()->user()->company_id));
        // Codedm::getByStatus("Print");
    }
}
