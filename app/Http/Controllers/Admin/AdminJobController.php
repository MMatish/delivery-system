<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminJobService;
use Illuminate\Http\Request;
use App\Models\User;

class AdminJobController extends Controller
{
    public function __construct(private AdminJobService $jobService)
    {
    }

    /**
     * List jobs (optionally filtered by status)
     */
    public function listJobs(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:unassigned,assigned,in_progress,completed,failed',
        ]);

        $jobs = $this->jobService->getAllJobs($request->status);

        return response()->json($jobs);
    }


    public function createJob(Request $request)
    {
        $data = $request->validate([
            'pickup_address' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);

        $job = $this->jobService->createJob($data);
        return response()->json($job, 201);
    }

    public function modifyJob(Request $request, $id)
    {
        $data = $request->validate([
            'pickup_address' => 'sometimes|string|max:255',
            'delivery_address' => 'sometimes|string|max:255',
            'recipient_name' => 'sometimes|string|max:255',
            'recipient_phone' => 'sometimes|string|max:20',
            'status' => 'sometimes|string|in:assigned,in_progress,completed,failed',
            'driver_id' => 'sometimes|exists:users,id',
        ]);

        $job = $this->jobService->updateJob($id, $data);
        return response()->json($job);
    }

    public function deleteJob($id)
    {
        $this->jobService->deleteJob($id);
        return response()->json(['message' => 'Job deleted successfully']);
    }

    public function assignJobToDriver(Request $request, $id)
    {
        $data = $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $job = $this->jobService->assignDriver($id, $data['driver_id']);
        return response()->json($job);
    }

    public function listDrivers()
    {
        $drivers = User::where('role', 'driver')->get(['id', 'name', 'email']);
        return response()->json($drivers);
    }
}
