<?php

namespace App\Http\Resources;
use App\Models\Product;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
class BuyerOrderDetail extends JsonResource
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
            'productId'          => $product->product_id,
            'productName'        => $product->product()->first()->product_name,
            'productUnitPrice'   => $product->unit_price,
            'quantity'           => $product->quantity,
            'price'              => $product->total_price,
        ];
         });
         
        // $buyerWastageImages=$this->buyerorderdetails->map(function($image) {
        //     return [ 
        //         'id'=>$image->buyerWastageImages()->first()->id,
        //         'img_name' => $image->buyerWastageImages()->first()->img_name,
        //         'local_path' => $image->buyerWastageImages()->first()->local_path,
        //         'public_path' => $image->buyerWastageImages()->first()->public_path,
        //         'thumb_path' => $image->buyerWastageImages()->first()->thumb_path,


        //     ];
        
        // });

         $buyer=Buyer::find($this->buyer_id);
         $user=User::find($buyer->user_id);
         $buyerDetails=[
            'id'               => $buyer->id,
            'buyerName'        => $user->name,
            'buyerAddress'     => $buyer->address
        ];

        return [
            'id'                 => $this->buyerorderdetails()->first()->buyer_order_id,
            'buyer'              => $buyerDetails,
            'buyerOrderDetails'  => $productDetails,
            // 'wastageImage'      =>$buyerWastageImages,
            'grossPrice'         => $this->gross_price,
            'netPrice'           => $this->net_price,
            'createdAt'          => $this->created_at->format('d/m/Y'),
            'updatedAt'          => $this->updated_at->format('d/m/Y'),
        ];

    }
}
