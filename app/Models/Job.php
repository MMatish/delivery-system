<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_address',
        'delivery_address',
        'recipient_name',
        'recipient_phone',
        'status',
        'driver_id',
    ];

    // Relationships
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Automatically set job status to 'assigned' when driver_id changes
     */
    public function setDriverIdAttribute($value)
    {
        // Detect if driver_id actually changed
        $original = $this->attributes['driver_id'] ?? null;

        $this->attributes['driver_id'] = $value;

        // If a driver is being assigned (not null and changed)
        if ($value !== null && $value !== $original) {
            $this->attributes['status'] = 'assigned';
        }

        // If driver is unassigned (set to null)
        if ($value === null) {
            $this->attributes['status'] = 'unassigned';
        }
    }
}
