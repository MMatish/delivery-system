<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\DriverRegisterService;
use Illuminate\Http\Request;

class DriverRegisterController extends Controller
{
    public function __construct(private DriverRegisterService $driverService) {}

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
        ]);

        $result = $this->driverService->registerDriver($data);

        return response()->json([
            'driver' => $result['driver']->only('id','name','email','role'),
            'vehicle' => $result['vehicle'],
        ], 201);
    }
}
