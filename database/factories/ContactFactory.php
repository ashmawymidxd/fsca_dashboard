<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition()
    {
        $serviceTypes = ['Web Development', 'Graphic Design', 'SEO', 'Consulting', 'Other'];
        $statuses = ['new', 'replied', 'pending'];

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'service_type' => $this->faker->randomElement($serviceTypes),
            'message' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement($statuses),
            'admin_notes' => $this->faker->optional(0.3)->paragraph(2), // 30% chance of having notes
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
