<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Geo\Country;
use App\Models\Geo\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Seeds the states table from dr5hn/countries-states-cities-database.
 *
 * Links states to countries via iso2 code lookup. Data is trimmed and validated.
 */
class StateSeeder extends Seeder
{
    private const DATA_URL = 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/states.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Fetching states data...');

        $response = Http::timeout(60)->get(self::DATA_URL);

        if (!$response->successful()) {
            $this->command->error('Failed to fetch states data. HTTP ' . $response->status());
            return;
        }

        $states = $response->json();
        $this->command->info('Processing ' . count($states) . ' states...');

        // Build country lookup: iso2 → id
        $countryMap = Country::pluck('id', 'iso2')->toArray();

        $batch = [];
        $skipped = 0;

        foreach ($states as $state) {
            $countryIso2 = strtoupper(trim($state['country_code'] ?? ''));
            $countryId = $countryMap[$countryIso2] ?? null;

            if (!$countryId) {
                $skipped++;
                continue;
            }

            $name = trim($state['name'] ?? '');
            if (empty($name)) {
                $skipped++;
                continue;
            }

            $stateCode = !empty($state['state_code'])
                ? strtoupper(trim($state['state_code']))
                : null;

            $batch[] = [
                'uuid'       => (string) Str::uuid(),
                'country_id' => $countryId,
                'name'       => $name,
                'state_code' => $stateCode,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks
        foreach (array_chunk($batch, 100) as $chunk) {
            State::insert($chunk);
        }

        $this->command->info("Seeded " . count($batch) . " states. Skipped {$skipped}.");
    }
}
