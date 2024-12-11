<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
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

        return to_route(route: 'turbines.index');
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

        return to_route(route: 'turbines.index');
    }

    /**
     * 
     * @param \App\Models\Component $component
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Component $component)
    {
        $component->delete();

        return to_route(route: 'turbines.index');
    }
}
