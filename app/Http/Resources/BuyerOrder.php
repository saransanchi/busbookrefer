<?php

namespace App\Http\Resources;
use App\Models\Product;
use App\Models\User;
use App\Models\Buyer;
//use App\Models\BuyerOrder;
use Illuminate\Http\Resources\Json\JsonResource;
//use Illuminate\Support\Facades\DB;

class BuyerOrder extends JsonResource
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
       
       $productDetails=$this->buyerorderdetails->map(function($product) {
        return [
            'productId'          =>$product->product_id,
            'productName'        => $product->product()->first()->product_name,
            'productUnitPrice'   => $product->unit_price,
            'quantity'           =>$product->quantity,
            'price'              =>$product->total_price,
        ];
         });

         $buyer=Buyer::find($this->buyer_id);
         $user=User::find($buyer->user_id);
         $buyerDetails=[
            'id'               =>$buyer->id,
            'buyerName'        => $user->name,
            'buyerAddress'     => $buyer->address
        ];

        return [
            'id'                 => $this->id,
            'buyer'              => $buyerDetails,
            'buyerOrderDetails'  => $productDetails,
            'grossPrice'         => $this->gross_price,
            'netPrice'           => $this->net_price,
            'createdAt'          => $this->created_at->format('d/m/Y'),
            'updatedAt'          => $this->updated_at->format('d/m/Y'),
        ];

    }
}
