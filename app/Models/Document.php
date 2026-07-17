<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'title',
        'filename',
        'filepath',
        'file_size',
        'mime_type',
        'uploader_id',
        'client_id',
        'matter_id',
        'version',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Get the user who uploaded the document.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    /**
     * Get the client associated with the document.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the matter that this document belongs to.
     */
    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }
}
