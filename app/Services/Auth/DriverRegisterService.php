<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;

class DriverRegisterService
{
    public function registerDriver(array $data)
    {
        // Create driver
        $driver = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'driver',
        ]);

        // Create vehicle
        $vehicle = Vehicle::create([
            'brand' => $data['vehicle_brand'],
            'type' => $data['vehicle_type'],
            'plate_number' => $data['vehicle_plate_number'],
            'driver_id' => $driver->id,
        ]);

        return [
            'driver' => $driver,
            'vehicle' => $vehicle,
        ];
    }
}
