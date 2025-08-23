<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],

            // Profile
            ['name' => 'Manage Profile', 'slug' => 'manage-profile'],

            // Projects
            ['name' => 'View Projects', 'slug' => 'view-projects'],
            ['name' => 'Manage Projects', 'slug' => 'manage-projects'],

            // Support and Help
            ['name' => 'View Support', 'slug' => 'view-support'],
            ['name' => 'Manage Support', 'slug' => 'manage-support'],

            // Sustainability
            ['name' => 'View Sustainability', 'slug' => 'view-sustainability'],
            ['name' => 'Manage Sustainability', 'slug' => 'manage-sustainability'],

            // Services
            ['name' => 'View Services', 'slug' => 'view-services'],
            ['name' => 'Manage Services', 'slug' => 'manage-services'],

            // Service Categories
            ['name' => 'View Service Categories', 'slug' => 'view-service-categories'],
            ['name' => 'Manage Service Categories', 'slug' => 'manage-service-categories'],

            // Notifications
            ['name' => 'Manage Notifications', 'slug' => 'manage-notifications'],

            // Contacts
            ['name' => 'View Contacts', 'slug' => 'view-contacts'],
            ['name' => 'Manage Contacts', 'slug' => 'manage-contacts'],

            // Admins
            ['name' => 'View Admins', 'slug' => 'view-admins'],
            ['name' => 'Manage Admins', 'slug' => 'manage-admins'],

            // Permissions
            ['name' => 'View Permissions', 'slug' => 'view-permissions'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions'],

            // Complete Services
            ['name' => 'View Complete Services', 'slug' => 'view-complete-services'],
            ['name' => 'Manage Complete Services', 'slug' => 'manage-complete-services'],

            // Fleets
            ['name' => 'View Fleets', 'slug' => 'view-fleets'],
            ['name' => 'Manage Fleets', 'slug' => 'manage-fleets'],

            // Sectors
            ['name' => 'View Sectors', 'slug' => 'view-sectors'],
            ['name' => 'Manage Sectors', 'slug' => 'manage-sectors'],

            // Trains
            ['name' => 'View Trains', 'slug' => 'view-trains'],
            ['name' => 'Manage Trains', 'slug' => 'manage-trains'],

            // Common Units
            ['name' => 'View Common Units', 'slug' => 'view-common-units'],
            ['name' => 'Manage Common Units', 'slug' => 'manage-common-units'],

            // heroes
            ['name' => 'View Hero', 'slug' => 'view-heroes'],
            ['name' => 'Manage Hero', 'slug' => 'manage-heroes'],

            // customers
            ['name' => 'View Customers', 'slug' => 'view-customers'],
            ['name' => 'Manage Customers', 'slug' => 'manage-customers'],

            // videos
            ['name' => 'View Videos', 'slug' => 'manage-videos'],

            // who we are
            ['name' => 'View Who We Are', 'slug' => 'view-who-we-are'],
            ['name' => 'Manage Who We Are', 'slug' => 'manage-who-we-are'],

            // settings
            ['name' => 'View Settings', 'slug' => 'view-settings'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings'],

            // Tech & Creativity
            ['name' => 'View Tech Creativity', 'slug' => 'view-tech-creativity'],
            ['name' => 'Manage Tech Creativity', 'slug' => 'manage-tech-creativity'],

            // Policy Terms
            ['name' => 'View Policy Terms', 'slug' => 'view-policy-terms'],
            ['name' => 'Manage Policy Terms', 'slug' => 'manage-policy-terms'],

            // blogs
            ['name' => 'View Blogs', 'slug' => 'view-blogs'],
            ['name' => 'Manage Blogs', 'slug' => 'manage-blogs'],

            // banners
            ['name' => 'View Banners', 'slug' => 'view-banners'],
            ['name' => 'Manage Banners', 'slug' => 'manage-banners'],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
