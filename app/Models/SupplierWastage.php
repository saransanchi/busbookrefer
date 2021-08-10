<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierWastage extends Model
{
    use HasFactory;

    protected $table = 'supplier_wastage';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
       'receive_quantity',
       'product_id',
       'supplier_order_id',
       'wastage_quantity'
    ];

    public function supplierorder()
    {
        return $this->belongsTo('App\Models\SupplierOrder');
        
    }
}
