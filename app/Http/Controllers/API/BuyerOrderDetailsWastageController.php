<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\BuyerOrderDetails;
use App\Models\BuyerWastageImage;
use Validator;
use File;
use Image;
use View;
use App\Http\Resources\BuyerWastageImage as BuyerWastageImageResource;

class BuyerOrderDetailsWastageController extends ApiBaseController
{

    //upload buyer wastage details
    public function store(Request $request, $id) {
        $input = $request->all();
        $validator = Validator::make($request->all(), 
              [ 
              'wastageImage' => 'required|mimes:pdf,png,jpg|max:4096',
              'wastageQuantity'=>'required',
              'buyerOrderDetailsId'=>'required'
             ]);
             if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
        if ($request->hasFile('wastageImage')) {

            $supplierOrderDetails = BuyerOrderDetails::find($id);
            $supplierOrderDetails->wastage = $request->input('wastageQuantity');
            $supplierOrderDetails->save();


            $buyer_order_details_id    = $id;
            $buyer_wastage_image = $request->file('wastageImage');
            $buyer_wastage_image_thumb = Image::make($request->file('wastageImage'));

            $random_string = md5(microtime());

            $buyer_wastage_image_name       = $random_string .'.'. $buyer_wastage_image->getClientOriginalExtension();
            $buyer_wastage_image_name_thumb = $random_string.'.'.$buyer_wastage_image->getClientOriginalExtension();

            $save_path           = storage_path() . '/buyerwastageimages/' . $buyer_order_details_id;
            $save_path_thumb     = storage_path() . '/buyerwastageimages/' . $buyer_order_details_id.'/thumb/';

            $path          = $save_path . $buyer_wastage_image_name;
            $path_thumb    = $save_path_thumb . $buyer_wastage_image_name_thumb;

            $public_path        = '/buyerwastageimages/' . $buyer_order_details_id . '/' . $buyer_wastage_image_name;
            $public_path_thumb  = '/buyerwastageimages/' . $buyer_order_details_id.'/thumb/'.$buyer_wastage_image_name_thumb;

            // Make the buyer a folder and set permissions

            File::makeDirectory($save_path, $mode = 0755, true, true);

            File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
            //resize product image

            $buyer_wastage_image_thumb->resize(150,150);
            

            // Save the file to the server
            $buyer_wastage_image->move($save_path, $buyer_wastage_image_name);
            $buyer_wastage_image_thumb->save($path_thumb);

            $buyerOrderDetails = BuyerOrderDetails::find($id);
        
            $buyerWastageImage = new BuyerWastageImage;
            
            $buyerWastageImage->img_name          = $buyer_wastage_image_name;
            $buyerWastageImage->public_path       = $public_path;
            $buyerWastageImage->local_path        = $save_path . '/' . $buyer_wastage_image_name;
            $buyerWastageImage->thumb_path        = $public_path_thumb;

            $buyerOrderDetails->buyerWastageImages()->save($buyerWastageImage);

            return $this->sendResponseNoData('buyer wastage images stored successfully');

            
        } else {
            return $this->sendError("buyer wastage images are not found");

        }
    }
    public function updateWastage(Request $request, $id){
        $buyerOrderDetails = BuyerOrderDetails::find($id);
        $buyerOrderDetails->wastage = $request->input('wastageQuantity');
        $buyerOrderDetails->buyerWastageImages()->delete();
        if ($request->hasFile('wastageImage')) {
            $buyer_order_details_id    = $id;
            $buyer_wastage_image = $request->file('wastageImage');
            $buyer_wastage_image_thumb = Image::make($request->file('wastageImage'));

            $random_string = md5(microtime());

            $buyer_wastage_image_name       = $random_string .'.'. $buyer_wastage_image->getClientOriginalExtension();
            $buyer_wastage_image_name_thumb = $random_string.'.'.$buyer_wastage_image->getClientOriginalExtension();

            $save_path           = storage_path() . '/buyerwastageimages/' . $buyer_order_details_id;
            $save_path_thumb     = storage_path() . '/buyerwastageimages/' . $buyer_order_details_id.'/thumb/';

            $path          = $save_path . $buyer_wastage_image_name;
            $path_thumb    = $save_path_thumb . $buyer_wastage_image_name_thumb;

            $public_path        = '/buyerwastageimages/' . $buyer_order_details_id . '/' . $buyer_wastage_image_name;
            $public_path_thumb  = '/buyerwastageimages/' . $buyer_order_details_id.'/thumb/'.$buyer_wastage_image_name_thumb;

            // Make the buyer a folder and set permissions

            File::makeDirectory($save_path, $mode = 0755, true, true);

            File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
            //resize product image

            $buyer_wastage_image_thumb->resize(150,150);
            

            // Save the file to the server
            $buyer_wastage_image->move($save_path, $buyer_wastage_image_name);
            $buyer_wastage_image_thumb->save($path_thumb);
           
        
            $buyerWastageImage = new BuyerWastageImage;
            
            $buyerWastageImage->img_name          = $buyer_wastage_image_name;
            $buyerWastageImage->public_path       = $public_path;
            $buyerWastageImage->local_path        = $save_path . '/' . $buyer_wastage_image_name;
            $buyerWastageImage->thumb_path        = $public_path_thumb;

            $buyerOrderDetails->buyerWastageImages()->save($buyerWastageImage);

            return $this->sendResponseNoData('buyer wastage images stored successfully');

            
        } else {
            return $this->sendError("buyer wastage images are not found");

        }

    }
     
    public function deleteWastageImage($wastage_image_id)
    {
        $buyerWastageImage = BuyerWastageImage::findOrFail($wastage_image_id);
    
        if (File::exists($buyerWastageImage->local_path) && ($buyerWastageImage->thumb_path)) {
            File::delete($buyerWastageImage->local_path);
            File::delete(storage_path() . $buyerWastageImage->thumb_path);
        }
    
        $buyerWastageImage->delete();
    
        return $this->sendResponseNoData('buyer wastage image  Successfully Deleted!');
    }

    public function showBuyerWastageImages($id)
    {
        $buyerWastage = BuyerOrderDetails::find($id);
        $buyerWastageImages = $buyerWastage->buyerWastageImages()->first();
        return new BuyerWastageImageResource($buyerWastageImages);

    } 
}