<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $supplier=[
            "id"=>$this->supplier_id,
            "name"=>$this->supplier->user->first_name
        ];
        $paymentStatus=[
            "id"=>$this->payment_status_id,
            "name"=>$this->paymentStatus()->first()->status,
        ];
        return [
        
            'id' => $this->id,
            'supplier'=>$supplier,
            'deliveredDate'=>$this->delivered_date,
            'paymentStatus'=>$paymentStatus,
            'totalPrice'=>$this->total_price


        ];
    }
}
