<?php

namespace App\Services\Admin;

use App\Models\Job;

class AdminJobService
{
    public function getAllJobs(?string $status = null)
    {
        $query = Job::with('driver')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function createJob(array $data)
    {
        return Job::create($data);
    }

    public function updateJob(int $id, array $data)
    {
        $job = Job::findOrFail($id);
        $job->update($data);
        return $job->fresh('driver');
    }

    public function deleteJob(int $id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
    }

    public function assignDriver(int $jobId, int $driverId)
    {
        $job = Job::findOrFail($jobId);
        $job->update(['driver_id' => $driverId]);
        return $job->fresh('driver');
    }
}
