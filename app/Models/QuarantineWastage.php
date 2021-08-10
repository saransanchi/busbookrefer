<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarantineWastage extends Model
{
    use HasFactory;
    protected $table = 'quarantinewastages';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
      
        'buyer_order_id',
        'product_id',
        'created_by',
    ];

    public function buyerorderdetails()
    {
        return $this->belongsTo('App\Models\BuyerOrderDetails');
    }

  
}
