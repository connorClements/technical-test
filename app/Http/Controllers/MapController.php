<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        // Fetch turbines with their components and inspections
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return the turbines to the Inertia `/map` page
        return Inertia::render('Map', [
            'turbines' => $turbines,
        ]);
    }
}
