<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Attempt user login with provided credentials and return a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     *        The HTTP request containing user login credentials (email and password).
     *
     * @return \Illuminate\Http\JsonResponse
     *         A JSON response indicating the result of the login attempt, including user data
     *         on successful login, or an error message on failure.
     */
    public function login(Request $request){
        $credential= $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(!auth()->attempt($credential)){
            return response()->json(['error'=>true,'message'=>'Invalid Credentials'],7);
        }
  
        $accessToken =auth()->user()->createToken('authToken')->accessToken;
        $user = auth()->user();

        $user_data=[
            'name'=>$user->name,
            'email'=>$user->email,
            'profile_photo_path'=>$user->profile_photo_path
        ];

        return response()->json(['error'=>false,'data'=>$user_data,'access_token'=>$accessToken,'message'=>'Login Successfully.'],200);
    }

    /**
     * Retrieve the authenticated user's information and return a JSON response.
     *
     * This function checks if a user is logged in. If not, it returns an error response.
     * Otherwise, it retrieves the authenticated user's data and returns it in a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     *         A JSON response containing either the user's data or an error message.
     */
    
    public function getUser(){
        // Check if the user is not logged in

        if (!auth()->user()) {
            return response()->json(['error'=>true,'message'=>'User is not logged in'],404);
        }

        // Retrieve the authenticated user
        $user = auth()->user();

        // Return a JSON response with the user's data
        return response()->json(['error'=>false,'user'=>$user,'message'=>'Data Fetch Successful.'],200);
    }
}
