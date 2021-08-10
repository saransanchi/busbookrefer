<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\Role;
use validator;
use App\Http\Resources\Role as RoleResource;

class RoleController extends ApiBaseController
{
    public function index()
    {
        $roles = Role::all();
        return $this->sendResponse(RoleResource::collection($roles), 'Roles retrieved successfully.');
    }
  
    public function show($id)
    {
         $role = Role::find($id);
        return $this->sendResponse((new RoleResource($role)), 'Role retrieved successfully.');
    }

}
