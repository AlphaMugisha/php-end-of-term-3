<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a paginated listing of the vehicles.
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($vehicles, 200);
        }

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created vehicle.
     */
    public function store(Request $request)
    {
        $data = $this->validateVehicle($request);

        $vehicle = Vehicle::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Vehicle created successfully.',
                'vehicle' => $vehicle,
            ], 201);
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle registered successfully.');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        if ($request->expectsJson()) {
            return response()->json($vehicle->load('clients'), 200);
        }

        $vehicle->load('linkages.client');

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $this->validateVehicle($request, $vehicle->id);

        $vehicle->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Vehicle updated successfully.',
                'vehicle' => $vehicle,
            ], 200);
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle.
     */
    public function destroy(Request $request, Vehicle $vehicle)
    {
        $vehicle->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Vehicle deleted successfully.',
            ], 200);
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }

    /**
     * Validate the incoming vehicle data.
     */
    protected function validateVehicle(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'chassis_number' => [
                'required', 'string', 'max:100',
                Rule::unique('vehicles', 'chassis_number')->ignore($ignoreId),
            ],
            'manufacture_company' => ['required', 'string', 'max:100'],
            'manufacture_year'    => ['required', 'integer', 'between:1900,' . date('Y')],
            'price'               => ['required', 'numeric', 'min:0'],
            'model_name'          => ['required', 'string', 'max:100'],
        ]);
    }
}
