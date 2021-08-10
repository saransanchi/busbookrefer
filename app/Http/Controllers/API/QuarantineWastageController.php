<?php

namespace App\Http\Controllers;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\QuarantineWastage;
use Validator;
use Auth;
use App\Http\Resources\QuarantineWastage as QuarantineWastageResource;

class QuarantineWastageController extends ApiBaseController
{
    public function index()
    {
        $quarantinewastage = QuarantineWastage::all();
      //  $user=Auth::user()->id;
        return $this->sendResponse(QuarantineWastageResource::collection($quarantinewastage), 'Quarantine Wastages retrieved successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'buyer_order_id' => 'required',
            'created_by' =>'required',
            'product_id' =>'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
            $quarantinewastage = new QuarantineWastage();
            foreach ($request->supplierWastages as $SupplierWastage){ 
           
                $quarantineWastageObj=[
                    'product_id'       =>$SupplierWastage['product_id'],
                    'buyer_order_id'=>$SupplierWastage['buyer_order_id'],
                    'created_by' =>$SupplierWastage['created_by'],
                ];
               }
            // $quarantinewastage->order_details_id=$request->input('order_details_id');
            // $quarantinewastage->wastage_quantity=$request->input('wastage_quantity');
            // $quarantinewastage->created_by=$request->input('created_by');
          
            // $quarantinewastage->save();
            $quarantinewastage->insert($quarantineWastageObj);
   
        return $this->sendResponse([],'Quarantine Wastage created successfully.');
    } 
   
    public function show($id)
    {
        $quarantinewastage = QuarantineWastage::find($id);
  
        if (is_null($quarantinewastage)) {
            return $this->sendError('Quarantine wastage not found.');
        }
   
        return $this->sendResponse(new QuarantineWastageResource($quarantinewastage), 'Quarantine Wastage retrieved successfully.');
    }
    
    
    public function update(Request $request, $id)
    {
       $quarantinewastage=$QuarantineWastage::find($id);
        $validator = Validator::make($request->all(),
    [
        'buyer_order_id'=>'required',
        'created_by' =>'required',
        'product_id' =>'required'
    ]
    );
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
     };
    $quarantinewastage = QuarantineWastage::findOrFail($id);
    $quarantinewastage->order_details_id = $request->input('buyer_order_id');
    $quarantinewastage->created_by = $request->input('created_by');
    $quarantinewastage->save();
    return $this->sendResponse(new QuarantineWastageResource($quarantinewastage), 'Quarantine Wastage retrieved successfully.');

    }
   
    public function destroy($id)
    {
        $quarantinewastage = QuarantineWastage::find($id);
    
        if  ($quarantinewastage->delete()){
            
    
            return $this->sendResponseNoData('Quarantine wastage details  deleted successfully');
        }
    
        return back()->with('error', "error");
    }

    }

}
