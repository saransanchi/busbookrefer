<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOrderDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public function toArray($request)
    {
        $supplierOrderDetails=$this->orderDetails->map(function($product) {
            return [ 
                'productId'=> $product->product_id,
                'productName'=> $product->product()->first()->product_name,
                'agreedQuantity'=> $product->agreed_quantity,
                'deliveredQuantity'=>$product->delivered_quantity,
                'retailPrice'=>$product->retail_price
            ];
        
        });
        
        $suppliers=[
            "id"=>$this->supplier_id,
            "name"=>$this->supplier->user->first_name
        ];
        $paymentStatus=[
            "id"=>$this->payment_status_id,
            "name"=>$this->paymentStatus()->first()->status,
        ];
        return [
            'id' => $this->id,
            'supplierDetails'=>$suppliers,
            'supplierOrderDetails'=>$supplierOrderDetails,
            'deliveredDate'=>$this->delivered_date,
            'paymentStatus'=>$paymentStatus
        ];
    }
}
