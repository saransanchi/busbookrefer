<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    use HasFactory;

    protected $table = 'category_images';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'img_name',
        'local_path',
        'public_path',
        'thumb_path'
    
    ];
}
