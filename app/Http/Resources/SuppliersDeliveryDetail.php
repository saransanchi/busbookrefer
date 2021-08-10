<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuppliersDeliveryDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
    //    $prduct_id=[
    //         'id'=>$this->product_id,
    //         'name'=>$this->product_name,
    //    ];

       return [


        'id' => $this->id,
        'productId' => $this->product_id,
        'supplierId' => $this->supplier_id,
        'deliveryDate'=>$this->delivery_date,
        'quantity' => $this->quantity,
        'createdAt' => $this->created_at->format('d/m/Y'),
        'updatedAt' => $this->updated_at->format('d/m/Y'),
    ];

        
    }
}
