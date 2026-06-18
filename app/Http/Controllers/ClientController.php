<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a paginated listing of the clients.
     */
    public function index(Request $request)
    {
        $clients = Client::latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($clients, 200);
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client.
     */
    public function store(Request $request)
    {
        $data = $this->validateClient($request);

        $client = Client::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Client created successfully.',
                'client'  => $client,
            ], 201);
        }

        return redirect()->route('clients.index')->with('success', 'Client registered successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Request $request, Client $client)
    {
        if ($request->expectsJson()) {
            return response()->json($client->load('vehicles'), 200);
        }

        $client->load('linkages.vehicle');

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client)
    {
        $data = $this->validateClient($request, $client->id);

        $client->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Client updated successfully.',
                'client'  => $client,
            ], 200);
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Request $request, Client $client)
    {
        $client->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Client deleted successfully.',
            ], 200);
        }

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    /**
     * Validate the incoming client data.
     */
    protected function validateClient(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'national_id' => [
                'required', 'string', 'max:50',
                Rule::unique('clients', 'national_id')->ignore($ignoreId),
            ],
            'telephone'   => ['required', 'string', 'max:20'],
            'address'     => ['required', 'string'],
        ]);
    }
}
