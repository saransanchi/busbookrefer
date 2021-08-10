<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentStatus as PaymentStatusResource;

class PaymentStatusController extends ApiBaseController
{
      //showing all payment options
   public function index(){
    $allPaymentStatus=PaymentStatus::all();
    return $this->sendResponse(PaymentStatusResource::collection($allPaymentStatus), 'Payment options  retrieved successfully.');
 }

 //showing payment option
 public function show($id){
    
    $paymentStatus=PaymentStatus::find($id);
    if(is_null($paymentStatus)){
        return $this->sendError("payment option  is not found");
    }
    return $this->sendResponse(new PaymentStatusResource($paymentStatus), 'Payment option  retrieved successfully.');
   }
}
