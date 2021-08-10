<?php

namespace App\Http\Controllers\API;
use App\Models\BuyerOrder;
use App\Models\BuyerOrderDetail;
use App\Models\BuyerWastageImage;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Http\Resources\BuyerOrderDetail as BuyerOrderDetailResource;

class BuyerOrderDetailController extends ApiBaseController
{
   
    public function show($id)
    {
        $buyerorder = BuyerOrder::find($id);
        //print_r($buyerorder->buyer_id);
        if ($buyerorder) {
            return $this->sendResponse(new BuyerOrderDetailResource($buyerorder), 'Buyer Order Details Retrieved Successfully.');
        }
        return $this->sendError('Buyerorder details not found.');
        
    }
}
