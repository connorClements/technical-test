<?php

namespace Database\Factories;

use App\Models\Turbine;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turbine>
 */
class TurbineFactory extends Factory
{
    protected $model = Turbine::class;

    public function definition()
    {
        $latitude = $this->faker->latitude();
        $longitude = $this->faker->longitude();

        // call the OpenCage API
        $apiKey = env('OPENCAGE_API_KEY');
        $response = Http::get("https://api.opencagedata.com/geocode/v1/json", [
            'q' => "$latitude,$longitude",
            'key' => $apiKey,
        ]);

        // default area name
        $name = 'Unknown Area';

        // if coordinates are successful for any of the bottom results, attach these as new 'name'
        if ($response->successful() && !empty($response->json()['results'])) {
            $components = $response->json()['results'][0]['components'] ?? [];
            $name = $components['city']
                ?? $components['town']
                ?? $components['village']
                ?? $components['hamlet']
                ?? $components['region']
                ?? $components['island']
                ?? $components['body_of_water']
                ?? $components['country']
                ?? $components['continent']
                ?? $components['place']
                ?? $name; // Fallback to default if none of these exist
        }

        return [
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }
}
