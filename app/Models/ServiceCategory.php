<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'cover_image',
        'main_header_en', 'main_header_ar',
        'sub_header_en', 'sub_header_ar',
        'description_en', 'description_ar',
        'focus_en', 'focus_ar',
        'slug_en', 'slug_ar',
        'button_text_en', 'button_text_ar',
        'service_id',
        'order',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getCoverImageUrlAttribute()
    {
        return url($this->cover_image);
    }
}
