<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->only('email','password')))
        {
            $user = auth()->user();
            $token = $user->createToken('admin')->accessToken ;
            return response()->json([
                'token'=>$token ,
                'data'=>new UserResource($user)
            ]);
        }
        return response()->json([
            'error'=>'login or password not exist'

        ]);
    }
    public function register(Request $request)
    {
        //$user =  User::create($request->only('first_name','last_name','email')+['password'=>bcrypt($request->password)]);

        $user = new User();
        $user->first_name = $request->first_name ;
        $user->last_name = $request->last_name ;
        $user->email = $request->email ;
        $user->password = bcrypt($request->first_name)  ;
        $user->role_id = 1 ;

        $user->save();

         return response()->json(['data' =>$user,'message'=>"success add user","status_code"=>201]);

    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
