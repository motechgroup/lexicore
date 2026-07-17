<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'phone',
        'appointment_date',
        'notes',
        'status',
        'assigned_attorney_id',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    /**
     * Get the client associated with the booking (if registered).
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the attorney assigned to the consultation.
     */
    public function assignedAttorney(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_attorney_id');
    }

    /**
     * Alias for views / admin booking.
     */
    public function attorney(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_attorney_id');
    }

    /**
     * Map scheduled_at to appointment_date.
     */
    public function getScheduledAtAttribute()
    {
        return $this->appointment_date;
    }

    public function setScheduledAtAttribute($value)
    {
        $this->attributes['appointment_date'] = $value;
    }

    /**
     * Map attorney_id to assigned_attorney_id.
     */
    public function getAttorneyIdAttribute()
    {
        return $this->assigned_attorney_id;
    }

    public function setAttorneyIdAttribute($value)
    {
        $this->attributes['assigned_attorney_id'] = $value;
    }

    /**
     * Mock duration minutes.
     */
    public function getDurationMinutesAttribute()
    {
        return 60;
    }
}
