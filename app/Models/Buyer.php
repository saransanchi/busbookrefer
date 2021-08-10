<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $table = 'buyers';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'address',
        'country',
        'contact_no',
    
    
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }
    public function buyerorderdetails()
    {
        return $this->hasMany('App\Models\BuyerOrderDetail');
    }
    public function buyerorder()
    {
        return $this->hasMany('App\Models\BuyerOrder');
    }
   public function buyerwastage()
   {
       return $this->hasMany(BuyerWastage::class);
   }
}
