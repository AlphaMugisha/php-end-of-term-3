<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use App\Models\VehicleClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LinkageController extends Controller
{
    /**
     * Display a paginated listing of the linkages.
     */
    public function index(Request $request)
    {
        $linkages = VehicleClient::with(['client', 'vehicle'])
            ->latest('linked_at')
            ->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($linkages, 200);
        }

        return view('linkage.index', compact('linkages'));
    }

    /**
     * Show the form for creating a new linkage.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        // Only vehicles that are not already linked.
        $vehicles = Vehicle::whereDoesntHave('linkages')->orderBy('model_name')->get();

        return view('linkage.create', compact('clients', 'vehicles'));
    }

    /**
     * Store a newly created linkage and auto-generate a plate number.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'  => ['required', 'integer', 'exists:clients,id'],
            'vehicle_id' => [
                'required', 'integer', 'exists:vehicles,id',
                // The vehicle must not already be linked.
                Rule::unique('vehicle_client', 'vehicle_id'),
            ],
        ], [
            'vehicle_id.unique' => 'This vehicle is already linked to a client.',
        ]);

        $linkage = VehicleClient::create([
            'client_id'    => $data['client_id'],
            'vehicle_id'   => $data['vehicle_id'],
            'plate_number' => VehicleClient::generatePlateNumber(),
            'linked_at'    => now(),
        ]);

        $linkage->load(['client', 'vehicle']);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Vehicle linked to client successfully.',
                'linkage' => $linkage,
            ], 201);
        }

        return redirect()->route('linkages.index')
            ->with('success', 'Vehicle linked successfully. Assigned plate number: ' . $linkage->plate_number);
    }

    /**
     * Display the specified linkage.
     */
    public function show(Request $request, VehicleClient $linkage)
    {
        $linkage->load(['client', 'vehicle']);

        if ($request->expectsJson()) {
            return response()->json($linkage, 200);
        }

        return view('linkage.show', compact('linkage'));
    }

    /**
     * Remove the specified linkage.
     */
    public function destroy(Request $request, VehicleClient $linkage)
    {
        $linkage->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Linkage removed successfully.',
            ], 200);
        }

        return redirect()->route('linkages.index')->with('success', 'Linkage removed successfully.');
    }
}
