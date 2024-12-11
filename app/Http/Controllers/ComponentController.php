<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Turbine $turbine
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // validate and store component against turbine with name
        $validated = $request->validate([
            'turbine_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        // get turbine and create a new component for it
        $turbine = Turbine::where('id', $validated['turbine_id'])->first();
        $turbine->components()->create($validated);

        // get all turbines
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return updated turbines as JSON
        return response()->json([
            'message' => 'Component created successfully.',
            'turbines' => $turbines,
        ]);
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Component $component
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Component $component)
    {
        // validate information to update component (name)
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        // update component
        $component->update($validated);

        // get all turbines
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return updated turbines as JSON
        return response()->json([
            'message' => 'Component updated successfully.',
            'turbines' => $turbines,
        ]);
    }

    /**
     * 
     * @param \App\Models\Component $component
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Component $component)
    {
        // delete component
        $component->delete();

        // get all turbines
        $turbines = Turbine::with(['components.inspections'])->get();

        // return all turbines as JSON
        return response()->json([
            'message' => 'Component deleted successfully.',
            'turbines' => $turbines,
        ]);
    }
}
