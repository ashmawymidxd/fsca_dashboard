<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Create 50 services
        $services = Service::factory()
            ->count(50)
            ->create();

        // For each service, create 2-4 categories/banners
        $services->each(function ($service) {
            ServiceCategory::factory()
                ->count(rand(2, 4))
                ->create(['service_id' => $service->id]);
        });
    }
}
