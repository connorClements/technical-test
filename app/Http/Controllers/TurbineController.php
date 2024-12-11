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
        // return turbines with components and inspections attached
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
        /**
         * validate turbine creation, with name, latitude (between -90 and 90 deg)
         *  and longitude (between -180 and 180 deg)
         */
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        // create turbine from validated data
        Turbine::create($validated);

        // return the newly created turbine and all turbines as JSON
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
        // validate turbine 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        // update turbine
        $turbine->update($validated);

        // return updated turbines as JSON
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
        // delte turbine
        $turbine->delete();

        // get all turbines
        $turbines = Turbine::with(['components.inspections'])->get();

        // return all turbines as JSON 
        return response()->json([
            'message' => 'Turbine deleted successfully.',
            'turbines' => $turbines,
        ]);
    }
}
