<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Gate::authorize('view','roles');
       $roles = RoleResource::collection(Role::all());
       return $roles ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Gate::authorize('edit','roles');
       $role = Role::create($request->only('name'));
        if($permissions = $request->permissions)
            foreach($permissions as $permission_id)
            {
                \DB::table('role_permission')->insert(
                    [
                        'role_id' => $role->id,
                         'permission_id' => $permission_id
                    ]
                );

            }

       return response()->json([
           'data'=> new RoleResource($role)
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        \Gate::authorize('view','roles');
       $role = Role::find($id);
       if(empty($role))
         return response('data not found');
        return new RoleResource($role) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Gate::authorize('edit','roles');
        $role = Role::find($id);
         $role->update($request->only('name'));
        \DB::table('role_permission')->where('role_id',$id)->delete();
        if($permissions = $request->permissions)
            foreach($permissions as $permission_id)
            {
                \DB::table('role_permission')->insert(
                    [
                        'role_id' => $id,
                        'permission_id' => $permission_id
                    ]
                );

            }
       return response()->json([
           'data'=> new RoleResource($role)
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table('role_permission')->where('role_id',$id)->delete();
        Role::destroy($id);
        return response('success removed',Response::HTTP_NO_CONTENT);
    }
}
