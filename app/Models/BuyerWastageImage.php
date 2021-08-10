<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerWastageImage extends Model
{
    use HasFactory;
    protected $table = 'buyer_wastage_images';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'img_name',
        'local_path',
        'public_path',
        'thumb_path',
        'buyer_order_details_id',
    ];

    public function buyerOrderDetail()
    {
        return $this->belongsTo(BuyerOrderDetails::class,'buyer_order_details_id');
    }
}
