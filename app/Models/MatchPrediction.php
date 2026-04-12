<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchPrediction extends Model
{
    protected $fillable = [
        'match_id',
        'username',
        'predicted_score_a',
        'predicted_score_b',
        'league_id',
    ];

    protected $casts = [
        'predicted_score_a' => 'integer',
        'predicted_score_b' => 'integer',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}
