<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Turbine;
use App\Models\Inspection;
use Illuminate\Http\Request;

class TurbineController extends Controller
{

    /**
     * Summary of index
     * @return \Inertia\Response
     */
    public function index()
    {
        // Fetch turbines with their components and inspections
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return the turbines to the Inertia `/map` page
        return Inertia::render('Turbines', [
            'turbines' => $turbines,

        ]);
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $turbine = Turbine::create($validated);

        // Fetch turbines with their components and inspections
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return the turbines to the Inertia `/map` page
        return Inertia::render('Turbines', [
            'turbines' => $turbines,

        ]);
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Turbine $turbine
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Turbine $turbine)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
        ]);

        $turbine->update($validated);

        // Fetch turbines with their components and inspections
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return the turbines to the Inertia `/map` page
        return Inertia::render('Turbines', [
            'turbines' => $turbines,

        ]);
    }

    /**
     * Summary of destroy
     * @param \App\Models\Turbine $turbine
     * @return \Inertia\Response
     */
    public function destroy(Turbine $turbine)
    {
        $turbine->delete();

        $turbines = Turbine::with(['components.inspections'])->get();

        return to_route(route: 'turbines.index');
    }
}
