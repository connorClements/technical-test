<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Turbine;
use App\Models\Component;
use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Component $component
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'component_id' => 'required',
            'inspection_date' => 'required|date',
            'score' => 'required|integer|min:1|max:5',
        ]);

        $component = Component::where('id', $validated['component_id'])->first();

        $inspection = $component->inspections()->create($validated);

        return to_route(route: 'turbines.index');
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inspection $inspection
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Inspection $inspection)
    {
        $validated = $request->validate([
            'inspection_date' => 'sometimes|date',
            'score' => 'sometimes|integer|min:1|max:5',
        ]);

        $inspection->update($validated);

        return to_route(route: 'turbines.index');
    }

    /**
     * Summary of destroy
     * @param \App\Models\Inspection $inspection
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Inspection $inspection)
    {
        $inspection->delete();

        // Return the updated turbines as a JSON response
        return to_route(route: 'turbines.index');
    }
}
