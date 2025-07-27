<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

class ProjectFactory extends Factory
{
    public function definition()
    {
        return [
            'cover_image' => 'https://tse4.mm.bing.net/th/id/OIP.qhFYeVfkW4sGZi4azhcTvQHaE8?rs=1&pid=ImgDetMain&o=7&rm=3', // Default cover image URL
            'is_active' => $this->faker->boolean(80),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            // Create English translation
            $project->translations()->create([
                'locale' => 'en',
                'title' => "English Title for Project {$project->id}",
                'description' => "English description for Project {$project->id}. " . fake()->paragraphs(3, true),
            ]);

            // Create Arabic translation
            $project->translations()->create([
                'locale' => 'ar',
                'title' => "عنوان عربي للمشروع {$project->id}",
                'description' => "وصف عربي للمشروع {$project->id}. " . fake()->paragraphs(3, true),
            ]);
        });
    }
}
