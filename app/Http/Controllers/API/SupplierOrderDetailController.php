<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\SupplierOrderDetail;
use App\Models\SupplierOrder;
use Validator;
use App\Http\Resources\SupplierOrderDetail as SupplierOrderDetailResource;


class SupplierOrderDetailController extends ApiBaseController
{
    public function destroy($id){
        $supplierOrderDetail = SupplierOrderDetail::find($id);
        if  ($supplierOrderDetail->delete()){
            return $this->sendResponseNoData('supplier order details  deleted successfully');
        }
         return $this->sendError("unable to delete the order details");
    }

 } 
            
   
    
    