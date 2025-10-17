<?php

namespace Tests\Unit\Services\Admin;

use App\Models\Job;
use App\Models\User;
use App\Services\Admin\AdminJobService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminJobServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AdminJobService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminJobService();
    }

    // simple test to check if we get the correct jobs
    public function test_get_all_jobs_with_and_without_status()
    {
        // creating first job
        Job::create([
            'pickup_address' => '123 Main Street, City A',
            'delivery_address' => '456 Oak Avenue, City B',
            'recipient_name' => 'Alice Smith',
            'recipient_phone' => '123-456-7890',
            'status' => 'unassigned',
        ]);

        // creating second job
        Job::create([
            'pickup_address' => '789 Pine Road, City C',
            'delivery_address' => '321 Maple Lane, City D',
            'recipient_name' => 'Bob Johnson',
            'recipient_phone' => '987-654-3210',
            'status' => 'assigned',
        ]);

        $allJobs = $this->service->getAllJobs();
        $this->assertCount(2, $allJobs);

        $assignedJobs = $this->service->getAllJobs('assigned');
        $this->assertCount(1, $assignedJobs);
        $this->assertEquals('assigned', $assignedJobs->first()->status);
    }

    public function test_create_update_delete_assign_driver()
    {
        $driver = User::factory()->create(['role' => 'driver']);
        $jobData = [
            'pickup_address' => 'A',
            'delivery_address' => 'B',
            'recipient_name' => 'John',
            'recipient_phone' => '123',
            'status' => 'unassigned',
        ];

        // creating job
        $job = $this->service->createJob($jobData);
        $this->assertDatabaseHas('jobs', ['id' => $job->id, 'status' => 'unassigned']);

        // updating job
        $updatedJob = $this->service->updateJob($job->id, ['status' => 'assigned']);
        $this->assertEquals('assigned', $updatedJob->status);

        // assigning driver, this should automatically change the status
        $assignedJob = $this->service->assignDriver($job->id, $driver->id);
        $this->assertEquals($driver->id, $assignedJob->driver_id);

        // checking the logic of the model: assigning a driver auto-updates status
        $this->assertEquals('assigned', $assignedJob->status, 'Status should auto-change to assigned when driver_id is set');

        // deleting a job
        $this->service->deleteJob($job->id);
        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }

}
