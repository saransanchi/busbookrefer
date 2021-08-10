<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersDeliveryDetail extends Model
{
    use HasFactory;
    protected $table = 'suppliers_delivery_details';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'delivery_date',
        'quantity',
        'farmer_detail_product_id'
    
    ];
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
    public function supplier()
    {
        return $this->belongsToMany('App\Models\Supplier','user_id');
    }

}
