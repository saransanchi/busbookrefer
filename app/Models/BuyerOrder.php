<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{
    use HasFactory;
    protected $table = 'buyer_orders';
    
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'buyer_id',
        
    ];

    public function buyerorderdetails()
    {
        return $this->hasMany('App\Models\BuyerOrderDetails');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function buyer()
    {
        return $this->belongsTo('App\Models\Buyer');
    }
   
  
}
