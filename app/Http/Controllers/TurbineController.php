<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use App\Models\Inspection;
use Illuminate\Http\Request;

class TurbineController extends Controller
{

    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $turbines = Turbine::with(['components.inspections'])->get();

        // Return turbines as JSON
        return response()->json(['turbines' => $turbines]);
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

        // Return the newly created turbine and all turbines as JSON
        $turbines = Turbine::with(['components.inspections'])->get();
        return response()->json([
            'message' => 'Turbine created successfully.',
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

        // Return updated turbines as JSON
        $turbines = Turbine::with(['components.inspections'])->get();
        return response()->json([
            'message' => 'Turbine updated successfully.',
            'turbines' => $turbines,
        ]);
    }


    /**
     * Summary of destroy
     * @param \App\Models\Turbine $turbine
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Turbine $turbine)
    {
        $turbine->delete();

        $turbines = Turbine::with(['components.inspections'])->get();

        return response()->json([
            'message' => 'Turbine deleted successfully.',
            'turbines' => $turbines,
        ]);
    }
}
