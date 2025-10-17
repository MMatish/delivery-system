<?php

namespace Tests\Unit\Services\Driver;

use App\Models\Job;
use App\Models\User;
use App\Services\Driver\DriverJobService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverJobServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DriverJobService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DriverJobService();
    }

    // testing if we can get the driver's jobs
    public function test_get_jobs_for_driver()
    {
        $driver = User::factory()->create();
        $job1 = Job::factory()->create([
            'driver_id' => $driver->id,
            'status' => 'assigned'
        ]);
        $job2 = Job::factory()->create([
            'driver_id' => $driver->id,
            'status' => 'assigned'
        ]);

        $jobs = $this->service->getJobsForDriver($driver->id);

        $this->assertCount(2, $jobs);
        $this->assertTrue($jobs->contains($job1));
        $this->assertTrue($jobs->contains($job2));
    }

    // testing the driver's update ability (the driver cannot change the status to the unassigned though)
    public function test_update_status_updates_job()
    {
        $driver = User::factory()->create();
        $job = Job::factory()->create(['driver_id' => $driver->id, 'status' => 'assigned']);

        $updatedJob = $this->service->updateStatus($driver->id, $job->id, 'completed');

        $this->assertEquals('completed', $updatedJob->status);
    }
}
