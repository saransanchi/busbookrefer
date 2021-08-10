<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\SupplierOrderDetail;
use App\Models\SupplierOrder;
use Validator;
use App\Http\Resources\SupplierOrder as SupplierOrderResource;
use App\Http\Resources\SupplierOrderDetail as SupplierOrderDetailResource;
use App\Http\Resources\SupplierOrderInvoice as SupplierOrderInvoiceResource;



class SupplierOrderController extends ApiBaseController
{
    public function index()
 {
     $supplierOrders = SupplierOrder::all();
     if($supplierOrders){
     return $this->sendResponse(SupplierOrderResource::collection($supplierOrders), 'SupplierOrders retrieved successfully.');
     }
     return $this->sendError('failed to retrieve SupplierOrders');

 }
    public function store(Request $request)
    {
            $input = $request->all();
        
            $validator = Validator::make($input, [
                'supplierId'                  => 'required',
                'deliveredDate'                 =>'required',
                'paymentStatus'                 =>'required'       
                ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
      

            $supplierOrder = SupplierOrder::create([
                'supplier_id'             => $request->input('supplierId'),
                'delivered_date'            =>$request->input('deliveredDate'),
                'payment_status_id'            =>$request->input('paymentStatus'),


                ]);
            $validator = Validator::make($input, [
                'supplierOrderDetails'=>'required',
    
                ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $totalPrice=0;
            foreach ($request->supplierOrderDetails as $supplierOrderDetail) {
                
                $supplierOrderDetailObj=[
                        "supplier_order_id"          => $supplierOrder->id,
                        'product_id'                 => $supplierOrderDetail['productId'],
                        'retail_price'               => $supplierOrderDetail['retailPrice'],
                        'agreed_quantity'            => $supplierOrderDetail['agreedQuantity'],
                        'delivered_quantity'         => $supplierOrderDetail['deliveredQuantity'],
                        'wastage_quantity'           => $supplierOrderDetail['wastageQuantity'],
                    ];
                    $supplierOrder->orderDetails()->insert([$supplierOrderDetailObj]);  
                    $totalPrice=$totalPrice+($supplierOrderDetail['deliveredQuantity']-$supplierOrderDetail['wastageQuantity'])*$supplierOrderDetail['retailPrice'];
                    $supplierOrder->total_price=$totalPrice;
                    $supplierOrder->save();
                }   
            return $this->sendResponseNoData('Supplier Order Details created successfully.');
 } 
 
 public function show($id)
 {
     $supplierOrderDetail = SupplierOrder::find($id);
     if (is_null($supplierOrderDetail)) {
         return $this->sendError('Supplier order is not found.');
     }

     return $this->sendResponse(new SupplierOrderResource($supplierOrderDetail), 'supplierOrderDetail retrieved successfully.');
 }   
 
    public function update(Request $request, $id)
    {
        $supplierOrder = SupplierOrder::find($id);
        $validator = Validator::make($request->all(), [
            'supplierId'                     => 'required',
            'deliveredDate'                 =>'required' ,
            'paymentStatus'                 =>'required'


        ]);
        $supplierOrder->delivered_date = $request->input('deliveredDate');
        $supplierOrder->payment_status_id  =$request->input('paymentStatus');
        $supplierOrder->save();
        $supplierOrder->orderDetails()->delete();
        $supplierAllOrderDetails=[];
        $totalPrice=0;
        foreach ($request->supplierOrderDetails as $supplierOrderDetail) {
                
            $supplierOrderDetailObj=[
                "supplier_order_id"          => $supplierOrder->id,
                'product_id'                 => $supplierOrderDetail['productId'],
                'retail_price'               => $supplierOrderDetail['retailPrice'],
                'agreed_quantity'            => $supplierOrderDetail['agreedQuantity'],
                'delivered_quantity'         => $supplierOrderDetail['deliveredQuantity'],
                'wastage_quantity'           => $supplierOrderDetail['wastageQuantity'],
                
            ];
            $supplierOrder->orderDetails()->insert([$supplierOrderDetailObj]);
            $totalPrice=$totalPrice+($supplierOrderDetail['deliveredQuantity']-$supplierOrderDetail['wastageQuantity'])*$supplierOrderDetail['retailPrice'];
            $supplierOrder->total_price=$totalPrice;
            $supplierOrder->save();
            array_push($supplierAllOrderDetails,$supplierOrderDetailObj);

            $data=[
                "supplierOrderDetails"=>$supplierAllOrderDetails,
                "totalPrice"=>$supplierOrder->total_price
            ];
        }
        if($data){
    return $this->sendResponse(($data),'SupplierOrderDetail updated successfully.');
        }
        return $this->sendError('fail to update SupplierOrderDetail');
  
    
}
public function getSupplierInvoice($supplierOrderId)
    {
        $supplierOrder = SupplierOrder::find($id);
        $supplierOrderDetails = $supplierOrder->orderDetails()->get();
        $allSupplierOrderDetails=[];
        $totalPrice = 0;
        foreach($supplierOrderDetails as $supplierOrderDetail)
                        
            {
                $price=($supplierOrderDetail->delivered_quantity-$supplierOrderDetail->wastage_quantity)*$supplierOrderDetail->retail_price;
                
                $OrderDetail=[
                    "id"=>$supplierOrderDetail->id,
                   "supplierName" =>$supplierOrderDetail->supplierOrder->supplier->user->first_name,
                     "productName"=>$supplierOrderDetail->product()->first()->product_name,
                     'retailPrice'=>$supplierOrderDetail->retail_price,
                    "deliveredQuantity"=>$supplierOrderDetail->delivered_quantity,
                    "wastageQuantity"=>$supplierOrderDetail->wastage_quantity,
                    "price"=>$price,   


                ];
                $totalPrice += $price;
                array_push($allSupplierOrderDetails,$OrderDetail); 

            }  
            $data=[
                    "supplierOrderDetails"=>$allSupplierOrderDetails,
                    "totalPrice"          =>$totalPrice
            ];
        if (is_null($data)) {
            return $this->sendError('invoice details not found.');
        }
        return $this->sendResponse(($data), 'supplier invoice details retrieved successfully.');
    }

    public function getDetailsBySupplierOrderId($order_id)
    {
        $supplierOrder = SupplierOrder::find($order_id);
        if (is_null($supplierOrder)) {
            return $this->sendError('Supplier order details are not found.');
        }

        return $this->sendResponse(new SupplierOrderDetailResource($supplierOrder), 'Supplier order details retrieved successfully.');
    }  

    
}
