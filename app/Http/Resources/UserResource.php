<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use jeremykenedy\LaravelRoles\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
     
    public function toArray($request)
    {
        $role=[
            "id"=>$this->roles->first()->id,
            "name"=>$this->roles->first()->name,
         ];
          
       return[
        'id' => $this->id,
        'firstName'=>$this->first_name,
        'lastName'=>$this->last_name,
        'name' => $this->name,
        'email' => $this->email,
        'role'=>$role,
        
        
       ];
       
    }
}
