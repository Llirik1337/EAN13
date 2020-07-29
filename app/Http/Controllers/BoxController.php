<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Box;
class BoxController extends Controller
{
    public function store(Request $request)
    {
//        \Log::debug('ean');
//        \Log::debug($request);
        $codeean13 = $request->codeean13;
        $msg = 'error missing ean13 code array';
        if($codeean13 !== null) {
            $result = Box::add($codeean13);
            // if($result !== false) {
            //     $msg = 'successful add new package';
            // } else {
            //     $msg = 'error can\'t add package';
            // }
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['msg'=> $msg]);
        }
    }
}
