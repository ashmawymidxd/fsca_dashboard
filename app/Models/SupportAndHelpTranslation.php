<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportAndHelpTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['support_and_help_id', 'locale', 'title', 'description'];
}
