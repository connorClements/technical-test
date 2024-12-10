<?php

namespace Database\Factories;

use App\Models\Component;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    protected $model = Inspection::class;

    public function definition()
    {
        return [
            'component_id' => Component::factory(), // Creates a component when generating an inspection
            'inspection_date' => $this->faker->date(),
            'score' => $this->faker->numberBetween(1, 5), // Score between 1-5
        ];
    }
}
