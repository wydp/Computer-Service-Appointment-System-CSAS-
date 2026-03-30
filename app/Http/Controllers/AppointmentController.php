<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show all appointments
    public function index()
    {
        $appointments = Appointment::with(['client', 'staff'])
            ->latest()
            ->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    // Show create form
    public function create()
    {
        $clients = Client::orderBy('first_name')->get();
        $staff   = User::where('role', 'staff')->orderBy('name')->get();
        return view('appointments.create', compact('clients', 'staff'));
    }

    // Save new appointment
    public function store(Request $request)
    {
        $request->validate([
            'client_id'        => 'required|exists:clients,id',
            'staff_id'         => 'required|exists:users,id',
            'service_type'     => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes'            => 'nullable|string',
        ]);

        Appointment::create([
            'client_id'        => $request->client_id,
            'staff_id'         => $request->staff_id,
            'created_by' => auth()->id(), // @phpstan-ignore-line
            'service_type'     => $request->service_type,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => $request->status,
            'notes'            => $request->notes,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully!');
    }

    // Show one appointment
    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'staff', 'serviceRecord']);
        return view('appointments.show', compact('appointment'));
    }

    // Show edit form
    public function edit(Appointment $appointment)
    {
        $clients = Client::orderBy('first_name')->get();
        $staff   = User::where('role', 'staff')->orderBy('name')->get();
        return view('appointments.edit', compact('appointment', 'clients', 'staff'));
    }

    // Update appointment
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'client_id'        => 'required|exists:clients,id',
            'staff_id'         => 'required|exists:users,id',
            'service_type'     => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes'            => 'nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    // Update only the status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully!');
    }

    // Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }
}