<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuarantineWastage extends JsonResource
{
   
    public function toArray($request)
    {
        
        return [
            'buyer_order_id' => $this->buyer_order_id,
            'created_by'=>$this->created_by,
            'product_id'=>$this->product_id 
        ];
    }
}
