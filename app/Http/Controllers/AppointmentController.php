<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show all appointments
    public function index(Request $request)
    {
        $query = Appointment::with(['client', 'staff'])->latest();

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(10);
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

        $appointment = Appointment::create([
            'client_id'        => $request->client_id,
            'staff_id'         => $request->staff_id,
            'created_by' => auth()->id(), // @phpstan-ignore-line
            'service_type'     => $request->service_type,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => $request->status,
            'notes'            => $request->notes,
        ]);

        // Log initial status creation
        AppointmentStatusHistory::create([
            'appointment_id'      => $appointment->id,
            'old_status'          => null,
            'new_status'          => $request->status,
            'changed_by_user_id'  => auth()->id(), // @phpstan-ignore-line
            'changed_at'          => now(),
            'notes'               => 'Appointment created',
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

        // Track if status has changed
        $oldStatus = $appointment->status;
        $newStatus = $request->status;

        $appointment->update($request->all());

        // Log status change if it occurred
        if ($oldStatus !== $newStatus) {
            AppointmentStatusHistory::create([
                'appointment_id'      => $appointment->id,
                'old_status'          => $oldStatus,
                'new_status'          => $newStatus,
                'changed_by_user_id'  => auth()->id(), // @phpstan-ignore-line
                'changed_at'          => now(),
                'notes'               => null,
            ]);
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    // Update only the status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $request->status;

        $appointment->update(['status' => $newStatus]);

        // Log status change with user info
        $historyData = [
            'appointment_id'      => $appointment->id,
            'old_status'          => $oldStatus,
            'new_status'          => $newStatus,
            'changed_by_user_id'  => auth()->id(), // @phpstan-ignore-line
            'changed_at'          => now(),
        ];

        // If marking as completed, record the service staff
        if ($newStatus === 'completed') {
            $historyData['service_completed_by_id'] = $appointment->staff_id;
        }

        AppointmentStatusHistory::create($historyData);

        return back()->with('success', 'Status updated successfully!');
    }

    // Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    // Get appointment tracking data (API)
    public function getTracking(Appointment $appointment)
    {
        $appointment->load(['client', 'staff', 'statusHistories.changedByUser', 'statusHistories.serviceCompletedByUser']);

        $tracking = $appointment->statusHistories->map(function($history) {
            return [
                'status_change' => $history->getStatusChangeLabel(),
                'changed_by' => $history->changedByUser->name,
                'service_completed_by' => $history->serviceCompletedByUser?->name,
                'timestamp' => $history->changed_at->format('M d, Y \a\t h:i A'),
                'notes' => $history->notes,
            ];
        });

        return response()->json([
            'appointment' => [
                'client_name' => $appointment->client->full_name,
                'service_type' => $appointment->service_type,
                'date_time' => \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') . ' at ' . \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A'),
                'status' => ucfirst(str_replace('_', ' ', $appointment->status)),
            ],
            'tracking' => $tracking,
        ]);
    }
}