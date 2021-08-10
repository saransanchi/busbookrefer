<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'category_id',
        'product_name',
        'price',
    
    ];


  
    public function SuppliersDeliveryDetail()
    {
        return $this->belongsToMany('App\Models\SuppliersDeliveryDetail');
    }
    public function Product()
    {
        return $this->belongsToMany('App\Models\Product');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

  public function suppliers()
    {
        return $this->belongsToMany(Supplier::class,'product_supplier','product_id','supplier_id');
    }
 public function supplierProducts()
    {
        return $this->hasOne(SupplierOrder::class);
    }

    public function supplierOrderProducts()
    {
        return $this->hasOne(SupplierOrderDetail::class);
    }
    public function buyerorderdetails()
    {
        return $this->hasMany('App\Models\BuyerOrderDetail');
    }
 
}
