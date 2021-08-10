<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllUserDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $details=[];
        $role=$this->roles->first()->id;
     if($this->roles->first()->slug=="supplier"){
            $availableProducts=$this->supplier->products->map(function($product) {
                return [ 'product'=> $product->pivot->product_id,
                        'maximumQuantity'=> $product->pivot->max_quantity ];
             });
             
            $details=[
            'id'=>$this->supplier()->first()->id,
            'id'=>$this->supplier()->first()->user_id,
            'address'=>$this->supplier()->first()->address,
            'contactNo'=>$this->supplier()->first()->contact_no,
            'availableProducts'=>$availableProducts
        ];
        }
        elseif($this->roles->first()->slug=="buyer"){
            $details=[
                'id'=>$this->buyer()->first()->id,
                'id'=>$this->buyer()->first()->user_id,
                'address'=>$this->buyer()->first()->address,
                'contactNo'=>$this->buyer()->first()->contact_no,
                'country'=>$this->buyer()->first()->country
            ];
        }
      

          return[
            'id' => $this->id,
            'firstName'=>$this->first_name,
            'lastName'=>$this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            'role'=>$role,
            'userDetails'=>$details
            
            
           ];
}
}
