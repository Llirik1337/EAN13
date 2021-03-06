<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Company;


class AppController extends Controller
{


    public function init()
    {
        $user = Auth::user();
        if ($user !== null) {
            $user->user_types;
            foreach ($user->company->codeean13 as $ean) {
                $ean->codedm;
                foreach ($ean->cargo as $cargo) {
                $cargo->codedm;
                }
            }
        }
        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->company;
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'Cloud not log you in.'], 401);
        }
    }

    public function loguot()
    {
        Auth::logout();
    }
}
