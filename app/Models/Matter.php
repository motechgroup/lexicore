<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matter extends Model
{
    protected $fillable = [
        'case_number',
        'title',
        'description',
        'client_id',
        'practice_area_id',
        'lead_attorney_id',
        'status',
        'priority',
        'court',
        'judge',
        'opposing_party',
        'opposing_counsel',
        'start_date',
        'end_date',
        'case_value',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'case_value' => 'decimal:2',
    ];

    /**
     * Get the client associated with the matter.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the practice area of the matter.
     */
    public function practiceArea(): BelongsTo
    {
        return $this->belongsTo(PracticeArea::class);
    }

    /**
     * Get the lead attorney managing the matter.
     */
    public function leadAttorney(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_attorney_id');
    }

    /**
     * Get the hearings for the matter.
     */
    public function hearings(): HasMany
    {
        return $this->hasMany(Hearing::class);
    }

    /**
     * Get the invoices linked to the matter.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the documents uploaded for the matter.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the tasks linked to the matter.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
