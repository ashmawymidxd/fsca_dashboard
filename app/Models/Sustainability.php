<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sustainability extends Model
{
    use HasFactory;

    protected $fillable = ['cover_image', 'is_active'];

    public function translations()
    {
        return $this->hasMany(SustainabilityTranslation::class);
    }

    // Updated translation method with default locale
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale', $locale)->first();
    }

    // Helper method to get English translation
    public function english()
    {
        return $this->translation('en');
    }

    // Helper method to get Arabic translation
    public function arabic()
    {
        return $this->translation('ar');
    }
}
