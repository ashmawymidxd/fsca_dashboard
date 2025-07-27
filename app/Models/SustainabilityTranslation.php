<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SustainabilityTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['sustainability_id', 'locale', 'title', 'description'];
}
