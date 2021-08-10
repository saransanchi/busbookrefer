<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    use HasFactory;

    protected $table = 'wastages';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'order_details_id',
        'quantity',
        'created_by',
    
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
  
    
}
