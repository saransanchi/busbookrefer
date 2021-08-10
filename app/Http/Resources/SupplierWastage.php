<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierWastage extends JsonResource
{
   
    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'supplier_order_id'=>$this->supplier_order_id,
            'receice_quantity'  =>$this->receice_quantity,
            'product_id' =>$this->product_id,
            'wastage_quantity'=>$this->wastage_quantity,
                 
        ];
        
    }


}
