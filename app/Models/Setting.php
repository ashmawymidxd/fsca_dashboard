<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name_en',
        'website_name_ar',
        'maintenance_mode',
        'description_en',
        'description_ar',
        'logo',
        'pdf',
        'email',
        'phone',
        'whatsapp',
        'location_name_en',
        'location_name_ar',
        'location_link',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
    ];
}
