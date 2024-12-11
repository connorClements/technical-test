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
        $validated = $request->validate([
            'turbine_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        $turbine = Turbine::where('id', $validated['turbine_id'])->first();

        $component = $turbine->components()->create($validated);

        // Return updated turbines as JSON
        $turbines = Turbine::with(['components.inspections'])->get();

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
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $component->update($validated);

        // Return updated turbines as JSON
        $turbines = Turbine::with(['components.inspections'])->get();

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
        $component->delete();

        // Return updated turbines as JSON
        $turbines = Turbine::with(['components.inspections'])->get();

        return response()->json([
            'message' => 'Component deleted successfully.',
            'turbines' => $turbines,
        ]);
    }
}
