<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Validator;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends ApiBaseController
{   
     //showing all the product categories
     public function index()
     {
         $allCategories = Category::all();
         if($allCategories){
         return $this->sendResponse(CategoryResource::collection($allCategories), 'Category retrieved successfully.');
         }
         return $this->sendError('categories not found.');
 
     }
    //showing product category
    public function show($id)
    {
        $Category = Category::find($id);
        if($Category){
        return $this->sendResponse(new CategoryResource($Category), 'Category retrieved successfully.');
        }
        return $this->sendError('category not found.');

    }
   
   

   //update category details
   public function update(Request $request,$id){
    $validator = Validator::make($request->all(),
    [
      'categoryName'     => 'required',     
    ]
    );
    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
     } 
       $Category = Category::findOrFail($id);
       $Category->category_name = $request->input('categoryName');
        if($Category->save()){
            return $this->sendResponse(new CategoryResource($Category), 'Category updated successfully.');
        }

   }
 
    public function destroy($id){	 
        $Category = Category::find($id);	  
        $Products =$Category->Products()->get();	   
        if (count($Products)==0){	   
            if( $Category->delete()){	       
                return $this->sendResponseNoData('Category deleted successfully');	           
            }  	     
        }	  
        else{	 
            return $this->sendError ('Category have more products');       
        }	   
        return back()->with('error', "error");	  
    }
}

