<?php
namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        // Create 50 projects with translations
        Project::factory()->count(50)->create();
    }
}
