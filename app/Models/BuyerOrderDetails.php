<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerOrderDetails extends Model
{
    use HasFactory;
    protected $table = 'buyer_order_details';
    
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'buyer_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'net_price',
        'wastage'
    ];
    public function buyerorder()
    {
        return $this->belongsTo('App\Models\BuyerOrder');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function buyer()
    {
        return $this->belongsTo('App\Models\Buyer');
    }
    public function buyerWastageImages()
    {
        return $this->hasMany(BuyerWastageImage::class);
    }

}
