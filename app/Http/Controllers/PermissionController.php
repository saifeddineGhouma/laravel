<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
       // \Gate::authorize('view','permissions');
        $permissions = Permission::all();
        return PermissionResource::collection($permissions);
    }
    public function show($id)
    {
        \Gate::authorize('view','permissions');
        $permission = Permission::find($id);
        return new PermissionResource($permission);
    }
}
