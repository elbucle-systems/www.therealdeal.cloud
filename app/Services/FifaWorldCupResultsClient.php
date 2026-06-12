<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FifaWorldCupResultsClient
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function matches(): array
    {
        $baseUrl = rtrim((string) config('services.fifa.base_url'), '/');

        $response = Http::acceptJson()
            ->withUserAgent((string) config('services.fifa.user_agent'))
            ->withOptions(['verify' => (bool) config('services.fifa.verify_ssl')])
            ->timeout(20)
            ->retry(2, 500)
            ->get("{$baseUrl}/calendar/matches", [
                'language' => 'en',
                'count' => 500,
                'idCompetition' => config('services.fifa.competition_id'),
                'idSeason' => config('services.fifa.season_id'),
            ])
            ->throw()
            ->json();

        return $response['Results'] ?? [];
    }
}
