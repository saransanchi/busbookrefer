<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\BuyerOrder;
use App\Models\BuyerOrderDetails;
use App\Models\Product;
use App\Models\Cost;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\BuyerOrder as BuyerOrderResource;
use App\Http\Resources\Cost as CostResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BuyerOrderController extends ApiBaseController
{
    
        public function calculateTotalPrice($buyerOrderId)
        {
            $costs=Cost::all()->first();
            //dd($costs->truck_cost);
            $truckCost    =$costs->truck_cost; //Config::get('nfc_constant_values.truck_price');
            $handlingCost =$costs->handling_cost; //Config::get('nfc_constant_values.handling_price');
            $shippingCost =$costs->shipping_cost; //Config::get('nfc_constant_values.shipping_price');
    
            $totalQuantity=DB::table('buyer_order_details')->where('buyer_order_id',$buyerOrderId)->sum('quantity');
            $totlPrice=DB::table('buyer_order_details')->where('buyer_order_id', $buyerOrderId)->sum('total_price');
            if($totalQuantity==2000 || $totalQuantity<2000){
             $finalPrice= $truckCost + $handlingCost + $shippingCost+ $totlPrice;
             DB::table('buyer_orders')->where('id',$buyerOrderId)->update(['gross_price'=> $finalPrice]);
            }
            elseif($totalQuantity%2000 == 0){
                $truckCost=intdiv($totalQuantity, 2000)*3500;
                $finalPrice= $truckCost + $handlingCost + $shippingCost+ $totlPrice;
              DB::table('buyer_orders')->where('id',$buyerOrderId)->update(['gross_price' =>$finalPrice]);
            }
            elseif($totalQuantity>2000){
                $truckCost=(intdiv($totalQuantity, 2000)+1)*3500;
                $finalPrice= $truckCost + $handlingCost + $shippingCost+ $totlPrice;
                DB::table('buyer_orders')->where('id',$buyerOrderId)->update(['gross_price'=>$finalPrice]);
            }
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyerOrder = BuyerOrder::all();
        if($buyerOrder){
            
            return $this->sendResponse(BuyerOrderResource::collection($buyerOrder), 'Buyer Orders retrieved successfully.'); 
        }
        return $this->sendError('Buyer Order not found.'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            "buyerOrderDetails"=>'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($buyerOrder = BuyerOrder::create(['buyer_id' => auth('api')->user()->buyer()->first()->id])){
            foreach($request->buyerOrderDetails as $buyerOrderDetail){
            $product       = Product::find($buyerOrderDetail['productId']);
            $unitPrice     = $product->price; 
                 $details=[
                    'buyer_order_id'    => $buyerOrder->id,
                    'product_id'        => $buyerOrderDetail['productId'],
                    'quantity'          => $buyerOrderDetail['quantity'],
                    'unit_price'        => $unitPrice,
                    'total_price'       => $buyerOrderDetail['quantity']*$unitPrice,
                ];
            $buyerOrder->buyerorderdetails()->insert($details);
            }
        }
       self::calculateTotalPrice($buyerOrder->id);
        return $this->sendResponse(($buyerOrder),'Buyer Order created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuyerOrder  $buyerOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $buyerOrder = BuyerOrder::find($id);
       $buyerOrderDetails = $buyerOrder->buyerorderdetails()->get();
        $validator = Validator::make($request->all(), [
            "buyerOrderDetails"=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $buyerOrder->buyerorderdetails()->delete();
            foreach($request->buyerOrderDetails as $buyerOrderDetail){
            $product       = Product::find($buyerOrderDetail['productId']);
            $unitPrice     = $product->price; 
          //  dd($product );
                 $details=[
                    'buyer_order_id'    =>  $buyerOrder->id,
                    'product_id'        =>  $buyerOrderDetail['productId'],
                    'quantity'          => $buyerOrderDetail['quantity'],
                    'unit_price'        =>  $unitPrice,
                    'total_price'         =>  $buyerOrderDetail['quantity']*$unitPrice,
                ];
            $buyerOrder->buyerorderdetails()->insert($details);
            self::calculateTotalPrice($buyerOrder->id);
        }
            return $this->sendResponse([], 'Buyer Order updated successfully.');
    }
    public function getNetPrice($buyerOrderId)
    {
        $wastagePrice = 0;
        $buyerOrder = BuyerOrder::find($buyerOrderId);
        $buyerOrderDetails=$buyerOrder->buyerorderdetails()->get();
        //dd($buyerOrderDetails);
        foreach ($buyerOrderDetails as $buyerOrderDetail) {

            $wastagePrice += ($buyerOrderDetail->wastage * $buyerOrderDetail->unit_price);
            
        }
        $netPrice = ($buyerOrder->gross_price) -  $wastagePrice;
        DB::table('buyer_orders')->where('id',$buyerOrder->id)->update(['net_price'=>$netPrice]);
        return $this->sendResponse($netPrice, 'Buyer Order Net Price Update successfully.');

    } 
}
