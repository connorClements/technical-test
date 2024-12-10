<?php

namespace Database\Seeders;

use App\Models\Turbine;
use App\Models\Inspection;
use Illuminate\Database\Seeder;

class TurbineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 turbines
        Turbine::factory()
            ->count(100)
            ->hasComponents(4)
            ->create()
            ->each(function ($turbine) {
                $components = ['Blade', 'Nacelle', 'Hub', 'Tower'];

                foreach ($components as $componentName) {
                    $component = $turbine->components()->create([
                        'name' => $componentName,
                    ]);

                    Inspection::factory()
                        ->count(4)
                        ->create([
                            'component_id' => $component->id,
                        ]);
                }
            });
    }
}
