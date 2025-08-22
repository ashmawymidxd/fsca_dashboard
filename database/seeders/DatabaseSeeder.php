<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            ContactSeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            PermissionSeeder::class,
            // Add other seeders here
        ]);
    }
}
