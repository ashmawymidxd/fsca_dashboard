<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition()
    {
        $titleEn = $this->faker->unique()->words(3, true);

        return [
            'title_en' => $titleEn,
            'title_ar' => 'عنوان الخدمة بالعربية', // Replace with actual Arabic text
            'description_en' => $this->faker->paragraphs(3, true),
            'description_ar' => 'وصف الخدمة بالعربية. يمكنك وضع النص الفعلي هنا.', // Replace with actual Arabic text
            'cover_image' => 'https://picsum.photos/800/600',
            'slug_en' => Str::slug($titleEn),
            'slug_ar' => 'slug-بالعربية', // Replace with actual Arabic slug
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
