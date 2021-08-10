<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class SupplierOrderInvoice extends JsonResource
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
            'supplierOrder'=>$this,
            'supplierOrderDetails'=>$this->orderDetails,
            'user'=>$this->supplier->user,
        ];   
     }
}
