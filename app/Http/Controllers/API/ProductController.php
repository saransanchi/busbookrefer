<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Validator;
use App\Http\Resources\Product as ProductResource;
   
class ProductController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        if($products){
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
        }
        return $this->sendError('Products not found.');

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
            'name' => 'required',
            'categoryId' =>'required',
            'price'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
            $product = new Product();
            $product->product_name=$request->input('name');
            $product->category_id=$request->input('categoryId');
            $product->price=$request->input('price');
            $product->save();
             return $this->sendResponseNoData('Product created successfully.');
    } 
   
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
            'categoryId'=>'required',
            'price' =>'required'
        ]
        );
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('name');
        $product->category_id = $request->input('categoryId');
        $product->price = $request->input('price');
        $product->save();
        return $this->sendResponse(new ProductResource($product), 'Product Updated successfully.');

    }
    public function destroy(Product $product)
    {
        $product->delete();
   
        return $this->sendResponseNoData('Product deleted successfully.');
    }
    public function getProductsBySupplierId($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        $supplierProducts = $supplier->products()->get();
        $allproductsuppliers=[];
        foreach($supplierProducts as $supplierProduct)
            {
                $supplierProduct=[
                    "id"=>$supplierProduct->id,
                    "name"=>$supplierProduct->product_name,
                    "maximumQuantity"=>$supplierProduct->pivot->max_quantity,
                ];
                
                 array_push($allSupplierProducts,$supplierProduct);  
            }
        if (is_null($allproductsuppliers)) {
            return $this->sendError('Products not found.');
        }
      
        return $this->sendResponse(($allSupplierProducts), 'Products retrieved successfully.');
    }
    
    public function getProductsByCategoryId($categoryId)
    {
        $category = Category::find($categoryId);
        $categoryProducts = $category->products()->get();
        $allcategoryProducts=[];
        foreach($categoryProducts as $categoryProduct)
            {
                $categoryProductDetails=[
                    "id"=>$categoryProduct->id,
                   "name"=>$categoryProduct->product_name,
                   "price"=>$categoryProduct->price,
                ];
                 array_push($allcategoryProducts,$categoryProductDetails);
            }
        if (is_null($allcategoryProducts)) {
            return $this->sendError('Products not found.');
        }
        return $this->sendResponse(($allcategoryProducts), 'Products retrieved successfully.');
    }

   
}