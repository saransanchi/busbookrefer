<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $table = 'costs';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'truck_cost',
        'handling_cost',
        'shipping_cost',
    ];
}
