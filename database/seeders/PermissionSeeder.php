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

            // Icons
            ['name' => 'View Icons', 'slug' => 'view-icons'],

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

            // who we are
            ['name' => 'View Who We Are', 'slug' => 'view-who-we-are'],
            ['name' => 'Manage Who We Are', 'slug' => 'manage-who-we-are'],

            // settings
            ['name' => 'View Settings', 'slug' => 'view-settings'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
