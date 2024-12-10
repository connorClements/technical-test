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

        // Call the OpenCage API
        $apiKey = env('OPENCAGE_API_KEY'); // Store your API key in .env
        $response = Http::get("https://api.opencagedata.com/geocode/v1/json", [
            'q' => "$latitude,$longitude",
            'key' => $apiKey,
        ]);

        // Parse city name from response
        $name = 'Unknown Area'; // Default value

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
