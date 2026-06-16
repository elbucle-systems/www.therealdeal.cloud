<?php

namespace App\Services;

use App\Models\League;

class ActiveLeagueResolver
{
    public function active(): ?League
    {
        return League::query()
            ->withCount(['members as approved_members_count' => fn ($query) => $query->where('status', 'approved')])
            ->whereHas('members', fn ($query) => $query->where('status', 'approved'), '>', 1)
            ->orderByDesc('approved_members_count')
            ->orderBy('id')
            ->first();
    }

    public function activeId(): ?int
    {
        return $this->active()?->id;
    }
}
