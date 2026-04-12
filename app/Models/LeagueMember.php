<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeagueMember extends Model
{
    // The only timestamp column is joined_at
    const CREATED_AT = 'joined_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'league_id',
        'user_id',
        'status',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
