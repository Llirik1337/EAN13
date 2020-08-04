<?php

namespace App\Http\Controllers;

use App\Codedm;
use App\Codeean13;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Codeean13Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        \Log::debug('message');
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
//        \Log::debug(__CLASS__ . "->" . __FUNCTION__);
//        \Log::debug($request->data);
        if ($request->data === null) {
            return response()->json(['msg' => 'missing argument']);
        } else if (!is_array($request->data)) {
            return response()->json(['msg' => 'argumnet is not array']);
        }

        $data = $request->data;
        $error_response = [];
        $codeean13 = [];
        foreach ($data as $key => $element) {
//            \Log::debug($element);



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

//                \Log::debug($code);
//                \Log::debug($tovar);
//                \Log::debug($company);
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
//        \Log::debug(json_encode($codeean13));
        return response()->json(['codeean13' => $codeean13]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Codeean13  $codeean13
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        try {
            $validateData = $request->validate(['data'=> 'required']);
            $input = $request->all();
            $data = $input['data'];

            $errors = [];
            foreach ($data as $codes) {
                if (!Codeean13::updateCode($codes['old'], $codes['new'])) {
                    array_push($errors, ["old"=>$codes['old'],"new"=>$codes['new'] ]);
                }
            }
            return response()->json(["errors" => $errors], 200);
        } catch (Exception $e) {
            Log::debug(json_encode($e));
            return response()->json(json_encode($e), 400);
        }
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

    public function getAllCodedm(Request $request) {
//        Log::debug(__CLASS__);
//        Log::debug(__FUNCTION__);
        $validateData = $request->validate(['codeean'=> 'required']);
        $input = $request->all();
        $codeean = $input['codeean'];
        $ean = Codeean13::getByCode($codeean);
        $result = Codedm::getByStatus($ean->id,null);
//        Log::debug(json_encode($result));
        return response()->json(['data'=>$result]);
    }

    public function getAllFreeDMCode(Request $request) {
        $result = Codeean13::getAllDMByStatus();
        return response()->json(['data'=>$result]);
    }

    public function getStatistics(Request $request)
    {
//        Log::debug(__CLASS__);
//        Log::debug(__FUNCTION__);
        \Log::debug('user');
        \Log::debug(json_encode(Auth::id()));
        return response()->json(Codeean13::getStatisticsByCompanyId(auth()->user()->company_id));
        // Codedm::getByStatus("Print");
    }
}
