<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * login function
     */
    public function login(Request $request){
        $credential= $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(!auth()->attempt($credential)){
            return response()->json(['error'=>true,'message'=>'Invalid Credentials']);
        }
        // if(!auth()->user()->is_active){
        //     auth()->logout();
        //     return response()->json(['error'=>true,'message'=>'User is not active !']);
        // }
        $accessToken =auth()->user()->createToken('authToken')->accessToken;


        return response()->json(['error'=>false,'access_token'=>$accessToken,'message'=>'Login Successfully.']);
    }

    public function getUser(){
        $user =NULL;

        if(auth())
        {
            $user = auth()->user();
        }

        return response()->json(['error'=>false,'user'=>$user,'message'=>'Data Fetch Successfull.']);

    }
}
