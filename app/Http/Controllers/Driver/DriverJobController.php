<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Services\Driver\DriverJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverJobController extends Controller
{
    public function __construct(private DriverJobService $jobService) {}

    public function myJobs()
    {
        $driverId = Auth::id();
        return response()->json($this->jobService->getJobsForDriver($driverId));
    }

    public function updateJobStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|string|in:assigned,in_progress,completed,failed',
        ]);

        $driverId = Auth::id();
        $job = $this->jobService->updateStatus($driverId, $id, $data['status']);
        return response()->json($job);
    }
}
