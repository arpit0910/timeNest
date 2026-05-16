<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Geo\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Seeds the countries table from dr5hn/countries-states-cities-database.
 *
 * Data is trimmed, properly cased, and validated before insertion.
 */
class CountrySeeder extends Seeder
{
    private const DATA_URL = 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/countries.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Fetching countries data...');

        $response = Http::timeout(30)->get(self::DATA_URL);

        if (!$response->successful()) {
            $this->command->error('Failed to fetch countries data. HTTP ' . $response->status());
            return;
        }

        $countries = $response->json();
        $this->command->info('Processing ' . count($countries) . ' countries...');

        $batch = [];

        foreach ($countries as $country) {
            $batch[] = [
                'uuid'            => (string) Str::uuid(),
                'name'            => trim(mb_convert_case($country['name'] ?? '', MB_CASE_TITLE, 'UTF-8')),
                'iso2'            => strtoupper(trim($country['iso2'] ?? '')),
                'iso3'            => strtoupper(trim($country['iso3'] ?? '')),
                'phone_code'      => trim($country['phone_code'] ?? ''),
                'currency_code'   => strtoupper(trim($country['currency'] ?? '')),
                'currency_symbol' => trim($country['currency_symbol'] ?? ''),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // Filter out invalid entries
        $batch = array_filter($batch, function ($item) {
            return !empty($item['name'])
                && !empty($item['iso2'])
                && strlen($item['iso2']) === 2
                && !empty($item['iso3'])
                && strlen($item['iso3']) === 3;
        });

        // Insert in chunks for performance
        foreach (array_chunk($batch, 50) as $chunk) {
            Country::insert($chunk);
        }

        $this->command->info('Seeded ' . count($batch) . ' countries.');
    }
}
