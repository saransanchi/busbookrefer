<?php


namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Resources\UserResource;
use Auth;
use Validator;
use App\Helpers\AuthRoleClass;
class SupplierController extends ApiBaseController
{
  //show all buyers
  public function index()
  {
      $suppliers = Supplier::all();
      if($suppliers){
      return $this->sendResponse(SupplierResource::collection($suppliers), 'Suppliers retrieved successfully.');
      }
      return $this->sendError('supplier is  not found.');

  }

  public function show($id)
  {

       $supplier = Supplier::find($id);
       if($supplier){
      return $this->sendResponse((new SupplierResource($supplier)), 'Supplier retrieved successfully.');
       }
       return $this->sendError('supplier is  not found.');

  }
  
  public function getSupplierByProductId($productid)
    {
        $products = Product::find($productid);
        $productsuppliers = $products->suppliers()->get();
        $allproductssuppliers=[];
        foreach($productsuppliers as $productsupplier)
            {
                $sproductsuppliers=$productsupplier->user()->first()->name;
                array_push($allproductssuppliers,$sproductsuppliers);
                
            }
        if ($allproductssuppliers) {
            return $this->sendResponse(($allproductssuppliers), 'Products retrieved successfully.');
        }
        return $this->sendError('Products not found.');

   
    }

}
    

