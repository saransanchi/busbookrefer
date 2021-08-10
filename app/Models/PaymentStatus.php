<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;
    protected $table = 'payment_statuses';

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'status',
        'slug'
    ];



    public function supplierOrder()
    {
        return $this->hasMany(SupplierOrder::class);
    }
}
