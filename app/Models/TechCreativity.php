<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechCreativity extends Model
{
    use HasFactory;

     protected $fillable = [
        'type',
        'image_direction',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'cover_image',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];
}
