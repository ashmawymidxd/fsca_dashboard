<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceCategoryFactory extends Factory
{
    public function definition()
    {
        $mainHeaderEn = $this->faker->unique()->words(2, true);
        $type = $this->faker->randomElement(['category', 'banner']);

        return [
            'type' => $type,
            'cover_image' => 'https://picsum.photos/800/600',
            'main_header_en' => $mainHeaderEn,
            'main_header_ar' => 'العنوان الرئيسي بالعربية', // Replace with actual Arabic text
            'sub_header_en' => $this->faker->sentence(),
            'sub_header_ar' => 'العنوان الفرعي بالعربية', // Replace with actual Arabic text
            'description_en' => $this->faker->paragraphs(2, true),
            'description_ar' => 'الوصف بالعربية. يمكنك وضع النص الفعلي هنا.', // Replace with actual Arabic text
            'focus_en' => $type === 'banner' ? $this->faker->words(3, true) : null,
            'focus_ar' => $type === 'banner' ? 'التركيز بالعربية' : null, // Replace with actual Arabic text
            'button_text_en' => $type === 'banner' ? $this->faker->word() : null,
            'button_text_ar' => $type === 'banner' ? 'نص الزر بالعربية' : null, // Replace with actual Arabic text
            'slug_en' => Str::slug($mainHeaderEn),
            'slug_ar' => 'slug-بالعربية', // Replace with actual Arabic slug
            'service_id' => \App\Models\Service::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
