<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
        'points_per_score',
        'points_per_result',
        'predictions_visible_before_game',
        'members_size_limit',
        'grouped_deadline',
        'deadline_days',
        'unique_code',
    ];

    protected $casts = [
        'predictions_visible_before_game' => 'boolean',
        'grouped_deadline'                => 'boolean',
        'members_size_limit'              => 'integer',
        'points_per_score'                => 'integer',
        'points_per_result'               => 'integer',
        'deadline_days'                   => 'integer',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(LeagueMember::class);
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(MatchPrediction::class);
    }
}
