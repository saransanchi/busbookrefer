<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\ApiBaseController as ApiBaseController;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Supplier;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Str;
use Validator;
use App\Http\Resources\UserResource;
use App\Http\Resources\AllUserDetails;

class UsersManagementController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();
    
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
      
        $validator = Validator::make($input, [
            'name'                  => 'required|max:255|unique:users',
            'firstName'            => 'required',
            'lastName'             => 'required',
            'email'                 => 'required',
            'password'              => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
            'role'                  => 'required',
            'address'               => 'required',
            'contactNo'             => 'required', 
              
             ]);
             if($request->input('role')=="4"){
                $validator = Validator::make($input, [
                    'availableProducts'           =>'required',
                    ]);
                    if($validator->fails()){
                        return $this->sendError('Validation Error.', $validator->errors());       
                    }
            } 
            if($request->input('role')=="5"){
                $validator = Validator::make($input, [
                    'country'           =>'required',
                    ]);
                    if($validator->fails()){
                        return $this->sendError('Validation Error.', $validator->errors());       
                    }
            }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = User::create([
            'name'             => $request->input('name'),
            'first_name'       => $request->input('firstName'),
            'last_name'        => $request->input('lastName'),
            'email'            => $request->input('email'),
            'password'         => bcrypt($request->input('password')),

        ]);
        $user->attachRole($request->input('role'));
        
        if( $user-> hasRole(Str::slug('buyer'))){
        $buyer=Buyer::create([
            "user_id" => $user->id,
            "country"=>$request->input('country'),
             "address"=>$request->input('address'),
            "contact_no"=>$request->input('contactNo')
            ]);
        }

        else if( $user-> hasRole(Str::slug('supplier')))           {
            $supplier=Supplier::create([
                "user_id" => $user->id,
                 "address"=>$request->input('address'),
                "contact_no"=>$request->input('contactNo'),

                ]);
                
                 foreach ($request->availableProducts as $product) {
                    $availableProduct=[
                        'product_id'                 => $product['product'],
                        'max_quantity'                 => $product['maximumQuantity'],
                    ];
                    $supplier->products()->attach([$availableProduct]);

                 }
            }    
        return $this->sendResponseNoData('Users details  created successfully.');
 } 
            
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
  
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
   
        return $this->sendResponse(new AllUserDetails($user), 'User details  retrieved successfully.');
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
            $user = User::find($id);
            $validator = Validator::make($request->all(), [
                'firstName'            => 'required',
                'lastName'             => 'required',
                'password'              => 'required|confirmed|min:6',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required', 
                'contactNo'            => 'required',
                'address'              => 'required',

            ]);
            if($user->hasRole('buyer'))   
            {
                $validator = Validator::make($request->all(), [
                    'country'             => 'required',
                ]);
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $user=User::find($id);
            $buyer = $user->buyer()->first();
            $buyer->country = $request->input('country');
            $buyer->address = $request->input('address');
            $buyer->contact_no = $request->input('contactNo');
            $buyer->save();

        }
        if($user->hasRole('supplier'))   
            {
                 $validator = Validator::make($request->all(), [
                    'availableProducts'             =>'required'
    
    
                ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }
        }


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }
      $user->save();
        if($user->hasRole('buyer'))  
        { 
            $user=User::find($id);
            $buyer = $user->buyer()->first();
            $buyer->country = $request->input('country');
            $buyer->address = $request->input('address');
            $buyer->contact_no = $request->input('contactNo');
            $buyer->save();
        }

        if($user->hasRole('supplier'))   
            {
            $user=User::find($id);
            $supplier = $user->supplier()->first();
            $supplier->address = $request->input('address');
            $supplier->contact_no = $request->input('contactNo');
            $supplier->save();
           
            $supplier->products()->detach();

            foreach ($request->availableProducts as $availableProduct) {
                $availableProduct=[
                    'product_id'                 => $availableProduct['product'],
                    'max_quantity'                 => $availableProduct['maximumQuantity'],
                ];
                $supplier->products()->attach([$availableProduct]);

             }
        }

        return $this->sendResponse(new AllUserDetails($user), 'User updated successfully.');
    
}

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
             return $this->sendResponse (new UserResource($user),'User deleted successfully');

        return $this->sendError("unable to delete user");
    }
    
}
