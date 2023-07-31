<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
// use Illuminate\Support\Facades\Auth as FacadesAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $creds = $request->only(['email','password']);

        if(!$token=auth()->attempt($creds)){
            return response()->json([
                'success' => false
            ]);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => FacadesAuth::user()

        ]);
    }
}
