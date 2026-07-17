<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeArea extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'content',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the matters associated with this practice area.
     */
    public function matters(): HasMany
    {
        return $this->hasMany(Matter::class);
    }
}
