<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyerWastage extends JsonResource
{
   
    public function toArray($request)
    {
        $buyer_orders=[
            'buyer_order_id' => $this->buyer_order_id,
            
        ];
        return [
            'id' => $this->id,
            'wastage_image'  =>$this->wastage_image,
            'buyer_order_id' => $this->buyer_orders,
            'wastage_quantity'=>$this->wastage_quantity,
            'createdBy' => $this->created_by,
            
        ];
    }
}
