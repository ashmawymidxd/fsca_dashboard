<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en', 'title_ar',
        'description_en', 'description_ar',
        'cover_image', 'slug_en', 'slug_ar'
    ];

    public function categories()
    {
        return $this->hasMany(ServiceCategory::class);
    }

    public function getCoverImageUrlAttribute()
    {
        return url($this->cover_image);
    }
}
