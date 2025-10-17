<?php

namespace Tests\Unit\Services\Auth;

use App\Models\User;
use App\Models\Vehicle;
use App\Services\Auth\DriverRegisterService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverRegisterServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DriverRegisterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DriverRegisterService();
    }

    public function test_register_driver_creates_driver_and_vehicle()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'vehicle_brand' => 'Toyota',
            'vehicle_type' => 'Van',
            'vehicle_plate_number' => 'ABC-123',
        ];

        $result = $this->service->registerDriver($data);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com', 'role' => 'driver']);
        $this->assertTrue(Hash::check('secret123', $result['driver']->password));

        $this->assertDatabaseHas('vehicles', [
            'brand' => 'Toyota',
            'type' => 'Van',
            'driver_id' => $result['driver']->id,
        ]);

        $this->assertEquals($result['driver']->id, $result['vehicle']->driver_id);
    }
}
