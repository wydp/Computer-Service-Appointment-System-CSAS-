<?php

namespace App\Http\Controllers;

use App\Models\ServiceRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    // Show all service records
    public function index(Request $request)
    {
        $query = ServiceRecord::with(['client', 'staff', 'appointment'])->latest();

        // Combined search for client name OR service type
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('first_name', 'like', '%' . $search . '%')
                              ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('appointment', function ($appointmentQuery) use ($search) {
                    $appointmentQuery->where('service_type', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('service_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('service_date', '<=', $request->date_to);
        }

        // Filter by remarks
        if ($request->has('remarks') && !empty($request->remarks)) {
            $query->where('remarks', 'like', '%' . $request->remarks . '%');
        }

        $records = $query->paginate(10);
        return view('service-records.index', compact('records'));
    }

    // Save new service record
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'description'    => 'required|string',
            'service_date'   => 'required|date',
            'remarks'        => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        ServiceRecord::create([
            'appointment_id' => $appointment->id,
            'client_id'      => $appointment->client_id,
            'staff_id'       => $appointment->staff_id,
            'description'    => $request->description,
            'service_date'   => $request->service_date,
            'remarks'        => $request->remarks,
        ]);

        // Mark appointment as completed
        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Service record saved!');
    }

    // Show edit form for service record description
    public function edit(ServiceRecord $serviceRecord)
    {
        // Only allow original staff or admin to edit
        $isAuthorized = auth()->id() === $serviceRecord->staff_id || auth()->user()->isAdmin();

        if (!$isAuthorized) {
            return redirect()->route('service-records.index')
                ->with('error', 'You are not authorized to edit this service record.');
        }

        return view('service-records.edit', compact('serviceRecord'));
    }

    // Update service record (description only)
    public function update(Request $request, ServiceRecord $serviceRecord)
    {
        // Only allow original staff or admin to edit
        $isAuthorized = auth()->id() === $serviceRecord->staff_id || auth()->user()->isAdmin();

        if (!$isAuthorized) {
            return redirect()->route('service-records.index')
                ->with('error', 'You are not authorized to edit this service record.');
        }

        $request->validate([
            'description' => 'required|string',
        ]);

        $serviceRecord->update([
            'description' => $request->description,
        ]);

        return redirect()->route('service-records.index')
            ->with('success', 'Service record description updated successfully!');
    }
}