<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = \App\Models\Vehicle::class;

    public function definition()
    {
        return [
            'brand' => $this->faker->company(),
            'type' => $this->faker->word(),
            'plate_number' => strtoupper($this->faker->unique()->bothify('???-####')),
            'driver_id' => \App\Models\User::factory(),
        ];
    }
}
