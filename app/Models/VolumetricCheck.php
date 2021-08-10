<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumetricCheck extends Model
{
    use HasFactory;

    
    protected $table = 'boxes';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'width',
        'length',
        'height'
    
    
    ];

}
