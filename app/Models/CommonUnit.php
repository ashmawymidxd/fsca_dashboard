<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'banner_image',
        'cover_image',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar'
    ];
}
