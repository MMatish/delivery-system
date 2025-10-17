<?php

namespace App\Services\Driver;

use App\Models\Job;
use App\Models\User;
use App\Notifications\JobFailedNotification;

class DriverJobService
{
    public function getJobsForDriver(int $driverId)
    {
        return Job::where('driver_id', $driverId)->get();
    }

    public function updateStatus(int $driverId, int $jobId, string $status)
    {
        $job = Job::where('driver_id', $driverId)->findOrFail($jobId);
        $job->update(['status' => $status]);

        if ($status === 'failed') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new JobFailedNotification($job));
            }
        }

        return $job;
    }
}
