<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttorneyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'education',
        'bar_admissions',
        'experience_years',
        'social_links',
        'image_path',
        'is_active',
        'order',
    ];

    protected $casts = [
        'education' => 'array',
        'bar_admissions' => 'array',
        'social_links' => 'array',
        'experience_years' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the user that owns the attorney profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
