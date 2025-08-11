<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name',
        'website_description',
        'email',
        'phone',
        'whatsapp',
        'location_name',
        'location_link',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
    ];
}
