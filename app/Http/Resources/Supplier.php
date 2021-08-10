<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
class Supplier extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            
            'firstName'=>$this->user()->first()->first_name,
            'lastName'=>$this->user()->first()->last_name,
            'email'=>$this->user()->first()->email,
            'userId'=>$this->user_id,
            'id' => $this->id,
            'address'=>$this->address,
            'contactNo'=>$this->contact_no,
        ];
    }
}
