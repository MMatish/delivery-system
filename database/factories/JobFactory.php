<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;

class JobFactory extends Factory
{
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
    /**
     * Randomize status after creation
     */
    public function configure()
    {
        return $this->afterCreating(function (Job $job) {
            $job->update([
                'status' => $this->faker->randomElement([
                    'assigned',
                    'in_progress',
                    'completed',
                    'failed',
                ]),
            ]);
        });
    }
}
