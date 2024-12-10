<?php

namespace Database\Factories;

use App\Models\Turbine;
use App\Models\Component;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Component>
 */

class ComponentFactory extends Factory
{
    protected $model = Component::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Blade', 'Nacelle', 'Hub', 'Tower']),
            'turbine_id' => Turbine::factory(), // Creates a turbine when generating a component
        ];
    }
}