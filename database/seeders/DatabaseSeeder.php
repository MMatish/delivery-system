<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creating 2 test users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $testDriver = User::create([
            'name' => 'Test Driver',
            'email' => 'driver@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'driver',
        ]);

        // Creating a vehicle for the test driver as well
        Vehicle::create([
            'brand' => 'Toyota',
            'type' => 'Van',
            'plate_number' => 'ABC-1234',
            'driver_id' => $testDriver->id,
        ]);

        // 2. Creating a random number of drivers ()
        $drivers = User::factory()->count(rand(5, 10))->create();

        // 3. For each driver we create 1 vehicle and random number of jobs
        $drivers->each(function ($driver) {
            // Creating the vehicle
            Vehicle::factory()->create([
                'driver_id' => $driver->id,
            ]);

            // Creating random number of jobs (1-5)
            Job::factory()->count(rand(1, 5))->create([
                'driver_id' => $driver->id,
            ]);
        });
    }
}
