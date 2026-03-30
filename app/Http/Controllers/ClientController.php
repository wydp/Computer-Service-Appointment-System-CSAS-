<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Show all clients
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    // Show create form
    public function create()
    {
        return view('clients.create');
    }

    // Save new client
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'nullable|string',
            'notes'      => 'nullable|string',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client added successfully!');
    }

    // Show one client
    public function show(Client $client)
    {
        $client->load(['appointments.staff', 'serviceRecords']);
        return view('clients.show', compact('client'));
    }

    // Show edit form
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // Update client
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'nullable|string',
            'notes'      => 'nullable|string',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully!');
    }

    // Delete client
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully!');
    }
}