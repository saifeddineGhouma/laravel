<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['data' =>User::all()]);
    }
    /**
     * return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['data' =>$user]);
    }

    public function store(Request $request )
    {

       $user =  User::create($request->all());
       $user->password = bcrypt($request->password);
       $user->save();
        return response()->json(['data' =>$user,'message'=>"success add user","status_code"=>201]);
    }
     /**
     * return Response
     */
    public function update($id , Request $request )
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json(['data' =>$user,'message'=>"success updated user","status_code"=>201]);
    }

    public function destroy($id  )
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message'=>"success delete user","status_code"=>201]);
    }
}
