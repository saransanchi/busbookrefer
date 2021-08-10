<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'address',
        'contact_no',
    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_supplier','supplier_id','product_id')->withPivot('max_quantity')->withTimestamps();
    }
    public function supplierOrders()
    {
        return $this->hasMany(SupplierOrder::class);
    }

    

    
    
}
