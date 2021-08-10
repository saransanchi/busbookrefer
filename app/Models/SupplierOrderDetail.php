<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'supplier_order_details';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'supplier_order_id',
    ];



    public function supplierOrder()
    {
        return $this->belongsTo(SupplierOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
   
    
}


