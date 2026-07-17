<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hearing extends Model
{
    protected $fillable = [
        'matter_id',
        'title',
        'hearing_date',
        'location',
        'notes',
        'status',
    ];

    protected $casts = [
        'hearing_date' => 'datetime',
    ];

    /**
     * Get the matter that this hearing belongs to.
     */
    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }
}
