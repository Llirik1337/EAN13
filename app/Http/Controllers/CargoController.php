<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
class CargoController extends Controller
{
    public static function store(Request $request) {
        $input = $request->all();
        return response()->json(['errors' =>Cargo::addNewCodedm($input['data'])]);
}
}
