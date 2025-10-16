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

    public function setDriverIdAttribute($value)
    {
        $this->attributes['driver_id'] = $value;

        if ($value !== null && $this->attributes['status'] === 'unassigned') {
            $this->attributes['status'] = 'assigned';
        }
    }
}
