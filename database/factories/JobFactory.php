<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = \App\Models\Job::class;

    public function definition()
    {
        return [
            'pickup_address' => $this->faker->address(),
            'delivery_address' => $this->faker->address(),
            'recipient_name' => $this->faker->name(),
            'recipient_phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['assigned','in_progress','completed','failed']),
            'driver_id' => \App\Models\User::factory(),
        ];
    }
}
