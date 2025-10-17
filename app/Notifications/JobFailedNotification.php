<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JobFailedNotification extends Notification
{
    use Queueable;

    protected Job $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Job Failed')
            ->line("The job to {$this->job->recipient_name} has failed.")
            ->line("Pickup: {$this->job->pickup_address}")
            ->line("Delivery: {$this->job->delivery_address}");
    }

    public function toArray($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'recipient' => $this->job->recipient_name,
            'status' => $this->job->status,
        ];
    }
}
