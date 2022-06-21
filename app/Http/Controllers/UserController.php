<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {


       \Gate::authorize('view','users');
        $users = User::with('role')->paginate(20);
        return response(UserResource::collection($users));
    }
    /**
     * return Response
     */
    public function show($id)
    {
        \Gate::authorize('view','users');
        $user = User::find($id);
        return response()->json(['data' => new UserResource($user)]);
    }

    public function store(CreateUserRequest $request )
    {
     \Gate::authorize('edit','users');
    $user = new User();
    $user->first_name = $request->first_name ;
    $user->last_name = $request->last_name ;
    $user->email = $request->email ;
    $user->role_id = $request->role_id ;
    $user->save();
       return response($user);
    }
     /**
     * return Response
     */
    public function update($id , UserUpdateRequest $request )
    {

        \Gate::authorize('edit','users');
        $user = User::find($id);

        $user->first_name = $request->first_name ;
        $user->last_name = $request->last_name ;
        $user->email = $request->email ;
        $user->role_id = $request->role_id ;
        $user->save();
           return response($user);
        return response()->json(['data' =>new UserResource($user),'message'=>"success updated user","status_code"=>201]);
    }
    public function profile()
    {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error'=>"any user logged","status_code"=>0]);


        return response()->json(['data' =>(new UserResource($user)),"status_code"=>201]);
    }
    public function update_info(UserUpdateRequest $request )
    {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error'=>"any user logged","status_code"=>0]);

        $user->update($request->only('first_name','last_name','email'));
       // $user =  User::create($request->only('first_name','last_name','email')+['password'=>bcrypt($request->password)]);

        return response()->json(['data' =>new UserResource($user),'message'=>"success updated user","status_code"=>201]);
    }

    public function update_password(UpdatePasswordRequest $request )
    {
        $user = auth()->user();
        if(!$user)
            return response()->json(['error'=>"any user logged","status_code"=>0]);

        $user->update($request->only('first_name','last_name','email'));
        $user =  User::create(['password'=>bcrypt($request->password)]);

        return response()->json(['data' =>new UserResource($user),'message'=>"success updated user","status_code"=>201]);
    }
    public function destroy($id  )
    {
        \Gate::authorize('edit','users');
        $user = User::find($id);
        $user->delete();
        return response()->json(['message'=>"success delete user","status_code"=>201]);
    }
}
