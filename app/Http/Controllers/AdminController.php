<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{


    public function createUser(Request $request)
    {

        $login = $request->login;
        $password = $request->password;
        $company = $request->company;
        //$right = $request->right;
        $user = User::createUser($login, $password, $company/*, $right*/);
        if ($user !== false) {
            return response()->json(['user' => $user, 'msg' => 'User success create']);
        } else {
            return response()->json(['msg' => 'User early exist!']);
        }
    }
}
