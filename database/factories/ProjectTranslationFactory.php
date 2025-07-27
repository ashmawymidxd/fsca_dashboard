<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTranslationFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(3, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    // Add specific locale states
    public function english()
    {
        return $this->state(function (array $attributes) {
            return [
                'locale' => 'en',
            ];
        });
    }

    public function arabic()
    {
        return $this->state(function (array $attributes) {
            return [
                'locale' => 'ar',
            ];
        });
    }
}
