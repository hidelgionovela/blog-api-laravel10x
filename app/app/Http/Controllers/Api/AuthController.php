<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $creds = $request->only(['email','password']);

        if(!$token=auth()->attempt($creds)){
            return response()->json([
                'success' => false,
                'message' => 'invalid credentials'
            ]);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => FacadesAuth::user()

        ]);
    }

    public function register(Request $request){

        $encryptedPass = Hash::make($request->password);

        $user = new User();

        try {    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user->save();
            return $this->login($request);
        } catch (Exception $th) {
            return response()->json([
                'success'=>false,
                'message'=>''.$th
            ]);
        }
    }

    public function logout(Request $request){

        try { 
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));   
            return response()->json([
                'success'=>true,
                'message'=>'logout Success'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'success'=>false,
                'message'=>''.$th
            ]);
        }
    }

}
