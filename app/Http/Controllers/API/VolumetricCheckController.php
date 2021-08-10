<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\VolumetricCheck;
use Validator;
use App\Http\Resources\VolumetricCheck as VolumetricCheckResource;
class VolumetricCheckController extends ApiBaseController
{
    public function index()
    {
        $volumetricValues = VolumetricCheck::all();
    
        return $this->sendResponse(VolumetricCheckResource::collection($volumetricValues), 'volumetrci values  retrieved successfully.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'width' => 'required',
            'length' =>'required',
            'height' =>'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
            $volumetricValue = new VolumetricCheck();
            $volumetricValue->width=$request->input('width');
            $volumetricValue->length=$request->input('length');
            $volumetricValue->height=$request->input('height');
            $width=$request->input('width');
            $length=$request->input('length');
            $height=$request->input('height');
            $cost=($width*$length*$height)/5000;
            $volumetricValue->volumetric_value=$cost;

            $volumetricValue->save();

   
        return $this->sendResponseNoData('volumetric value created successfully');
    } 
    public function show($id)
    {
        $volumetricValue = VolumetricCheck::find($id);
        if (is_null($volumetricValue)) {
            return $this->sendError('volumetric value not found');
        }
   
        return $this->sendResponse(new VolumetricCheckResource($volumetricValue), 'volumetric value retrieved successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
    [
        'width'=>'required',
        'length'=>'required',
        'height'=>'required'

    ]
    );
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
     };
    $volumetricValue = VolumetricCheck::findOrFail($id);
    $volumetricValue->width = $request->input('width');
    $volumetricValue->length = $request->input('length');
    $volumetricValue->height = $request->input('height');
    $width=$request->input('width');
    $length=$request->input('length');
    $height=$request->input('height');
    $cost=($width*$length*$height)/5000;
    $volumetricValue->volumetric_value=$cost;

    $volumetricValue->save();
    return $this->sendResponse(new VolumetricCheckResource($volumetricValue), 'Volumetric value updated successfully.');

    }
     //delete product category
   public function destroy($id){
    $VolumetricCheck = VolumetricCheck::find($id);

    if  ($VolumetricCheck->delete()){
        

        return $this->sendResponseNoData('volumetric value deleted successfully');
    }

    return back()->with('error', "error");
}
}
